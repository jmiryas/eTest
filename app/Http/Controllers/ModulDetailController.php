<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Modul;
use App\Models\ModulDetail;
use App\Models\ModuldetailSection;
use App\Models\ProgressUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use \Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Woo\GridView\DataProviders\EloquentDataProvider;

class ModulDetailController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:etest modul-detail view', only: ['index', 'show']),
            new Middleware('permission:etest modul-detail create', only: ['create', 'store']),
            new Middleware('permission:etest modul-detail edit', only: ['edit', 'update']),
            new Middleware('permission:etest modul-detail delete', only: ['destroy']),
        ];
    }

    public function konfirmasi(Request $request)
    {
        $expected = "saya sudah mempelajari dan memahami materi ini";

        $request->merge([
            "konfirmasi" => strtolower(trim($request->input("konfirmasi", ""))),
        ]);

        $validatedData = $request->validate([
            "modul_detail_id" => "required|exists:modul_detail,id",
            "konfirmasi" => "required|in:$expected",
        ]);

        $modul_detail = ModulDetail::with(["modul", "moduldetail_section"])
            ->where("id", $validatedData["modul_detail_id"])
            ->first();

        ProgressUser::create([
            "peserta_id" => auth()->user()->username,
            "course_id" => $modul_detail->modul->course_id,
            "modul_id" => $modul_detail->modul->id,
            "section_id" => $modul_detail->id,
            "section_type" => $modul_detail->moduldetail_section->nama,
            "waktu_submit" => Carbon::now(),
        ]);

        return redirect()->route('course.my-modules', ['id' => $modul_detail->modul->course_id])
            ->with('success', 'Materi berhasil diselesaikan');
    }

    public function index(Request $request): View
    {
        $query = ModulDetail::with(["moduldetail_section", "modul"]);

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

        $modulDetail = $query->paginate(10);

        if ($request->header('HX-Request')) {
            return view('modul-detail.includes.index-table', compact('modulDetail'));
        }

        return view('modul-detail.index', compact('modulDetail', 'columns', 'selectedColumns'));
    }

    public function create(): View
    {
        $modulDetail = new ModulDetail();

        $courses = Course::with(["moduls" => function ($q) {
            $q->selectRaw("id, course_id, CONCAT('Modul ', urutan, ' : ', judul) AS judul, id")
                ->orderBy("urutan");
        }])
            ->orderBy("judul")
            ->where("is_active", true)
            ->get();

        $moduls = $courses->mapWithKeys(function ($course) {
            return [
                $course->judul => $course->moduls->pluck("judul", "id")->toArray()
            ];
        })->toArray();

        $sections = ModuldetailSection::orderBy("urutan")->pluck("nama", "id")->toArray();

        return view('modul-detail.create', compact('modulDetail', 'moduls', 'sections'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'modul_id' => 'required|string|max:50|exists:modul,id',
            'moduldetail_section_id' => 'required|string|max:50|exists:moduldetail_section,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'embedded_video' => 'nullable|string',
            'waktu_mulai' => 'nullable|sometimes|date_format:Y-m-d H:i',
            'waktu_selesai' => 'nullable|sometimes|date_format:Y-m-d H:i',
        ]);

        try {
            $modul_detail = ModulDetail::create($validatedData);

            if ($modul_detail && $request->filled('waktu_mulai') && $request->filled('waktu_selesai')) {
                $start = Carbon::parse($request->input('waktu_mulai'));
                $end = Carbon::parse($request->input('waktu_selesai'));
                $duration_minute = $start->diffInMinutes($end);

                $modul_detail->durasi_menit = $duration_minute;

                $modul_detail->save();
            }

            $modul_detail->load("moduldetail_section");

            $modul_detail->urutan = $modul_detail->moduldetail_section->urutan;

            $modul_detail->save();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'Terjadi kesalahan saat membuat data.');
        }

        return redirect()->route('modul-detail.index')
            ->with('success', 'Modul Detail berhasil dibuat');
    }

    public function show(ModulDetail $modulDetail): View
    {
        return view('modul-detail.show', compact('modulDetail'));
    }

    public function edit(ModulDetail $modulDetail): View
    {
        $courses = Course::with(["moduls" => function ($q) {
            $q->selectRaw("id, course_id, CONCAT('Modul ', urutan, ' : ', judul) AS judul, id")
                ->orderBy("urutan");
        }])
            ->orderBy("judul")
            ->where("is_active", true)
            ->get();

        $moduls = $courses->mapWithKeys(function ($course) {
            return [
                $course->judul => $course->moduls->pluck("judul", "id")->toArray()
            ];
        })->toArray();

        $sections = ModuldetailSection::orderBy("urutan")->pluck("nama", "id")->toArray();

        return view('modul-detail.edit', compact('modulDetail', 'moduls', 'sections'));
    }

    public function update(Request $request, ModulDetail $modulDetail): RedirectResponse
    {
        $validatedData = $request->validate([
            'modul_id' => 'required|string|max:50|exists:modul,id',
            'moduldetail_section_id' => 'required|string|max:50|exists:moduldetail_section,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'embedded_video' => 'nullable|string',
            'waktu_mulai' => 'nullable|sometimes|date_format:Y-m-d H:i',
            'waktu_selesai' => 'nullable|sometimes|date_format:Y-m-d H:i',
        ]);

        try {
            $modulDetail->update($validatedData);

            if ($modulDetail && $request->filled('waktu_mulai') && $request->filled('waktu_selesai')) {
                $start = Carbon::parse($request->input('waktu_mulai'));
                $end = Carbon::parse($request->input('waktu_selesai'));
                $duration_minute = $start->diffInMinutes($end);

                $modulDetail->durasi_menit = $duration_minute;

                $modulDetail->save();
            }

            $modulDetail->load("moduldetail_section");

            $modulDetail->urutan = $modulDetail->moduldetail_section->urutan;

            $modulDetail->save();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->back()
                    ->withInput($request->all())
                    ->with('error', 'Data modul detail ini sudah digunakan dan tidak dapat diperbarui.');
            }
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }

        return redirect()->route('modul-detail.index')
            ->with('success', 'Modul Detail berhasil diperbarui');
    }

    public function destroy(ModulDetail $modulDetail): RedirectResponse
    {
        try {
            $modulDetail->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->route('modul-detail.index')
                    ->with('error', 'Data modul detail ini sudah digunakan dan tidak dapat dihapus.');
            }
            return redirect()->route('modul-detail.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data.');
        }

        return redirect()->route('modul-detail.index')
            ->with('success', 'Modul Detail berhasil dihapus');
    }
}
