<?php

namespace App\Http\Controllers;

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
use Illuminate\Validation\Rule;
use Woo\GridView\DataProviders\EloquentDataProvider;

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
                ->with('success', 'Test berhasil diselesaikan');
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

        $modul_sections = ModulDetail::orderBy("judul")->pluck("judul", "id")->toArray();

        return view('soal.create', compact('soal', 'modul_sections'));
    }

    public function store(Request $request): RedirectResponse
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

            $soal = Soal::create($validatedData);

            $soal->durasi_detik = $duration_second;
            $soal->save();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'Terjadi kesalahan saat membuat data.');
        }

        return redirect()->route('soal.index')
            ->with('success', 'Soal berhasil dibuat');
    }

    public function show(Soal $soal): View
    {
        return view('soal.show', compact('soal'));
    }

    public function edit(Soal $soal): View
    {
        $modul_sections = ModulDetail::orderBy("judul")->pluck("judul", "id")->toArray();

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
