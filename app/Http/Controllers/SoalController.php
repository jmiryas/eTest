<?php

namespace App\Http\Controllers;

use App\Models\Banksoal;
use App\Models\ModulDetail;
use App\Models\ProgressUser;
use App\Models\Soal;
use App\Models\SoalDetail;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use \Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Woo\GridView\DataProviders\EloquentDataProvider;
use Illuminate\Support\Str;

class SoalController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:etest soal view', only: ['index', 'show']),
            new Middleware('permission:etest soal create', only: ['create', 'store']),
            new Middleware('permission:etest soal edit', only: ['edit', 'update']),
            new Middleware('permission:etest soal delete', only: ['destroy']),
        ];
    }

    public function test(Request $request, $modulDetailId)
    {
        if ($request->isMethod("post")) {
            $validatedData = $request->validate([
                "soal_id" => ["required", "exists:soal,id"],
                "jenis_soal" => ["required", Rule::in(["multiple_choice", "essay"])],
                "jawaban_user" => [
                    Rule::when(
                        $request->jenis_soal === "multiple_choice",
                        ["nullable", "exists:soal_detail,id"],
                        ["nullable", "string"]
                    ),
                ],
            ]);

            $current_soal = Soal::where("id", $validatedData["soal_id"])->first();
            $current_jawaban = null;

            if ($validatedData["jenis_soal"] == "multiple_choice" && $validatedData["jawaban_user"] != null) {
                $current_jawaban = SoalDetail::where("id", $validatedData["jawaban_user"])->first();
            }

            $answer = UserAnswer::firstOrCreate([
                "peserta_id" => auth()->user()->username,
                "modul_detail_id" => $modulDetailId,
                "soal_id" => $current_soal->id,
                "soal_tipe" => $current_soal->tipe,
                "soal_text" => $current_soal->isi
            ]);

            $answer->answer_label = $current_jawaban ? $current_jawaban->label : null;
            $answer->answer_text = $current_jawaban ? $current_jawaban->isi : $validatedData["jawaban_user"];
            $answer->is_correct = $current_jawaban ? $current_jawaban->is_correct : null;
            $answer->score = $current_jawaban ? ($current_jawaban->is_correct ? $current_soal->poin : 0) : 0;

            $answer->save();
        }

        $modul_detail = ModulDetail::with(["modul", "moduldetail_section", "soals"])->where("id", $modulDetailId)->first();

        $soal = Soal::with(['soal_details' => fn($q) => $q->orderBy('urutan', 'asc')])
            ->where('modul_detail_id', $modulDetailId)
            ->whereDoesntHave('user_answers', fn($q) => $q->where('peserta_id', auth()->user()->username))
            ->orderBy('urutan', 'asc')
            ->first();

        // cek apakah soalnya sudah selesai semua

        $done_total = UserAnswer::where("modul_detail_id", $modulDetailId)
            ->where("peserta_id", auth()->user()->username)
            ->distinct("soal_id")
            ->count("soal_id");

        // Kalau belum selesai tapi tidak ada soal

        if ((count($modul_detail->soals) != $done_total) && !$soal) {
            return redirect()->route('course.my-modules', ['id' => $modul_detail->modul->course_id])
                ->with('warning', 'Test ini belum memiliki soal');
        }

        if (count($modul_detail->soals) == $done_total) {
            $progress = ProgressUser::firstOrCreate([
                "peserta_id" => auth()->user()->username,
                "course_id" => $modul_detail->modul->course_id,
                "modul_id" => $modul_detail->modul_id,
                "section_id" => $modul_detail->id,
                "section_type" => $modul_detail->moduldetail_section->nama,
            ]);

            $progress->waktu_submit = now();
            $progress->save();

            return redirect()->route('course.my-modules', ['id' => $modul_detail->modul->course_id])
                ->with('success', 'Test berhasil diselesaikan')
                ->with('noback', true);
        }

        return view("soal.test", compact("modul_detail", "soal"));
    }

    public function index(Request $request): View
    {
        $query = Soal::with(["modul_detail"]);

        // tambahkan kolom yang mau dikecualikan di pencarian
        $except = ['created_by', 'updated_by'];

        $columns = collect($query->getModel()->getFillable())->filter(function ($item) use ($except) {
            return !in_array($item, $except);
        })->toArray();

        $selectedColumns = $request->get('col', $columns);

        if ($search = $request->get('search')) {
            $query->where(function ($query) use ($search, $selectedColumns) {
                foreach ($selectedColumns as $column) {
                    $query->orWhere($column, 'like', '%' . $search . '%');
                }
            });
        }

        $soal = $query->paginate(10);

        if ($request->header('HX-Request')) {
            return view('soal.includes.index-table', compact('soal'));
        }

        return view('soal.index', compact('soal', 'columns', 'selectedColumns'));
    }

    public function create(): View
    {
        $soal = new Soal();

        $soal->poin = 1;
        $soal->urutan = 1;

        $modul_sections = ModulDetail::with(['modul', 'moduldetail_section'])
            ->where('moduldetail_section_id', '!=', 'materi')
            ->get()
            ->sortBy(fn($item) => $item->moduldetail_section->urutan)
            ->groupBy(fn($item) => 'Modul ' . $item->modul->urutan . '. ' . $item->modul->judul)
            ->map(fn($group) => $group->mapWithKeys(
                fn($item) => [$item->id => "{$item->moduldetail_section->nama} : {$item->judul}"]
            ))
            ->toArray();

        $group_code_soals = Banksoal::select("group_code")
            ->distinct()
            ->orderBy("group_code")
            ->pluck("group_code", "group_code")
            ->toArray();

        return view('soal.create', compact('soal', 'modul_sections', 'group_code_soals'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'modul_detail_id' => 'required|string|max:50',
            'group_code'      => 'required|exists:banksoal,group_code',
        ]);

        $now = now();

        // 1) ambil semua banksoal untuk group_code (single query)
        $banksoals = DB::table('banksoal')
            ->where('group_code', $data['group_code'])
            ->orderBy('urutan')
            ->get();

        if ($banksoals->isEmpty()) {
            return redirect()->route('soal.index')
                ->with('info', 'Tidak ada banksoal untuk group code tersebut.');
        }

        // 2) ambil semua isi (unique) dan cek soal yang sudah ada di modul (single query)
        $banksoalIsis = $banksoals->pluck('isi')->filter()->unique()->values()->all();

        $existingIsis = DB::table('soal')
            ->where('modul_detail_id', $data['modul_detail_id'])
            ->whereIn('isi', $banksoalIsis)
            ->pluck('isi')
            ->map(fn($v) => (string) $v)
            ->all();

        // 3) ambil semua banksoal_detail untuk semua banksoal (single query)
        $banksoalIds = $banksoals->pluck('id')->all();
        $detailsGrouped = DB::table('banksoal_detail')
            ->whereIn('banksoal_id', $banksoalIds)
            ->orderBy('urutan')
            ->get()
            ->groupBy('banksoal_id');

        // 4) build batch inserts (soal + soal_detail) — generate ULID manual
        $soalInserts = [];
        $soalIdMap   = []; // banksoal_id => new soal id
        foreach ($banksoals as $b) {
            $isi = (string) ($b->isi ?? '');
            if ($isi === '' || in_array($isi, $existingIsis, true)) {
                continue;
            }

            $newSoalId = (string) Str::ulid();

            $soalInserts[] = [
                'id' => $newSoalId,
                'modul_detail_id' => $data['modul_detail_id'],
                'tipe' => $b->tipe,
                'isi' => $b->isi,
                'poin' => $b->poin,
                'tipe_durasi' => $b->tipe_durasi,
                'durasi_original' => $b->durasi_original,
                'durasi_detik' => $b->durasi_detik,
                'urutan' => $b->urutan
            ];

            $soalIdMap[$b->id] = $newSoalId;
        }

        if (empty($soalInserts)) {
            $jumlah = count($soalInserts);
            return redirect()->route('soal.index')
                ->with('success', "Soal berhasil disimpan sebanyak: {$jumlah}");
        }

        // 5) bangun semua soal_detail berdasarkan mapping (tidak ada query di loop)
        $soalDetailInserts = [];
        foreach ($banksoals as $b) {
            if (!isset($soalIdMap[$b->id])) {
                continue; // dilewatkan karena soal tidak dibuat (sudah ada/empty)
            }

            $targetSoalId = $soalIdMap[$b->id];
            $details = $detailsGrouped->get($b->id, collect());

            foreach ($details as $d) {
                $soalDetailInserts[] = [
                    'id' => (string) Str::ulid(),
                    'soal_id' => $targetSoalId,
                    'label' => $d->label,
                    'isi' => $d->isi,
                    'is_correct' => $d->is_correct,
                    'urutan' => $d->urutan
                ];
            }
        }

        // 6) simpan semuanya dalam 1 transaction
        DB::transaction(function () use ($soalInserts, $soalDetailInserts) {
            DB::table('soal')->insert($soalInserts);
            if (!empty($soalDetailInserts)) {
                DB::table('soal_detail')->insert($soalDetailInserts);
            }
        });

        $saved = count($soalInserts);
        $skipped = count($banksoals) - $saved;

        return redirect()->route('soal.index')
            ->with('success', "Soal berhasil disimpan sebanyak: {$saved}");
    }

    // public function store(Request $request): RedirectResponse
    // {
    //     $validatedData = $request->validate([
    //         'modul_detail_id' => 'required|string|max:50',
    //         'group_code' => 'required|exists:banksoal,group_code'
    //     ]);

    //     try {
    //         $banksoals = Banksoal::where("group_code", $validatedData["group_code"])->get();

    //         foreach ($banksoals as $banksoal) {
    //             $soal = Soal::create([
    //                 "modul_detail_id" => $validatedData["modul_detail_id"],
    //                 "tipe" => $banksoal->tipe,
    //                 "isi" => $banksoal->isi,
    //                 "poin" => $banksoal->poin,
    //                 "tipe_durasi" => $banksoal->tipe_durasi,
    //                 "durasi_original" => $banksoal->durasi_original,
    //                 "durasi_detik" => $banksoal->durasi_detik,
    //                 "urutan" => $banksoal->urutan
    //             ]);

    //             $options = $banksoal->banksoal_details->map(function ($detail) use ($soal) {
    //                 return [
    //                     "id" => (string) Str::ulid(),
    //                     "soal_id" => $soal->id,
    //                     "label" => $detail->label,
    //                     "isi" => $detail->isi,
    //                     "is_correct" => $detail->is_correct,
    //                     "urutan" => $detail->urutan
    //                 ];
    //             })->toArray();

    //             SoalDetail::insert($options);
    //         }
    //     } catch (\Illuminate\Database\QueryException $e) {
    //         return redirect()->back()
    //             ->withInput($request->all())
    //             ->with('error', 'Terjadi kesalahan saat membuat data: ' . $e->getMessage());
    //     }

    //     return redirect()->route('soal.index')
    //         ->with('success', 'Soal berhasil dibuat');
    // }

    public function show(Soal $soal): View
    {
        return view('soal.show', compact('soal'));
    }

    public function edit(Soal $soal): View
    {
        $modul_sections = ModulDetail::with(['modul', 'moduldetail_section'])
            ->where('moduldetail_section_id', '!=', 'materi')
            ->get()
            ->sortBy(fn($item) => $item->moduldetail_section->urutan)
            ->groupBy(fn($item) => 'Modul ' . $item->modul->urutan . '. ' . $item->modul->judul)
            ->map(fn($group) => $group->mapWithKeys(
                fn($item) => [$item->id => "{$item->moduldetail_section->nama} : {$item->judul}"]
            ))
            ->toArray();

        return view('soal.edit', compact('soal', 'modul_sections'));
    }

    public function update(Request $request, Soal $soal): RedirectResponse
    {
        $validatedData = $request->validate([
            'modul_detail_id' => 'nullable|string|max:50',
            'tipe' => 'nullable|string|in:multiple_choice,essay,',
            'isi' => 'nullable|string',
            'poin' => 'nullable|integer',
            'tipe_durasi' => 'required|in:second,minute',
            'durasi_original' => 'required|integer|min:1',
            'urutan' => 'nullable|integer',
            'updatd_at' => 'nullable|date_format:Y-m-d H:i:s',
        ]);

        try {
            $original_duration = $request->input('durasi_original');
            $duration_type = $request->input('tipe_durasi');

            $duration_second = convert_time_units($original_duration, $duration_type, 'second');

            $soal->update($validatedData);

            $soal->durasi_detik = $duration_second;
            $soal->save();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->back()
                    ->withInput($request->all())
                    ->with('error', 'Data soal ini sudah digunakan dan tidak dapat diperbarui.');
            }
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }

        return redirect()->route('soal.index')
            ->with('success', 'Soal berhasil diperbarui');
    }

    public function destroy(Soal $soal): RedirectResponse
    {
        try {
            $soal->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->route('soal.index')
                    ->with('error', 'Data soal ini sudah digunakan dan tidak dapat dihapus.');
            }
            return redirect()->route('soal.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data.');
        }

        return redirect()->route('soal.index')
            ->with('success', 'Soal berhasil dihapus');
    }
}
