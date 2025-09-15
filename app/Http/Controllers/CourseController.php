<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Modul;
use App\Models\ModulDetail;
use App\Models\ProgressUser;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use \Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Woo\GridView\DataProviders\EloquentDataProvider;

class CourseController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:etest course view-peserta', only: ['myCourse']),
            new Middleware('permission:etest course view', only: ['index', 'show']),
            new Middleware('permission:etest course create', only: ['create', 'store']),
            new Middleware('permission:etest course edit', only: ['edit', 'update']),
            new Middleware('permission:etest course delete', only: ['destroy']),
        ];
    }

    public function myCourse()
    {
        $myCourses = Course::whereHas('course_details', function ($query) {
            $query->where('peserta_id', auth()->user()->username);
        })->paginate(10);

        return view('course.my-course', compact('myCourses'));
    }

    public function myModules(Request $request, $id)
    {
        $moduls = Modul::with(["modul_details.moduldetail_section"])->where(['course_id' => $id])->get();

        $progress_list = ProgressUser::where("peserta_id", auth()->user()->username)
            ->where("course_id", $id)
            ->pluck("section_id")
            ->toArray();

        $section_status = [];
        $open_found = false;

        foreach ($moduls as $modul) {
            foreach ($modul->modul_details as $detail) {
                if (in_array($detail->id, $progress_list)) {
                    $section_status[$detail->id] = 'done';
                } else if (!$open_found) {
                    $section_status[$detail->id] = 'open';
                    $open_found = true;
                } else {
                    $section_status[$detail->id] = 'locked';
                }
            }
        }

        if (!$moduls) {
            return redirect()->route('course.my-course')
                ->with('error', 'Course tidak ditemukan');
        }

        return view('course.my-modules', compact('moduls', 'section_status'));
    }

    public function myModulSection($courseId, $id)
    {
        $course = Course::with(["moduls.modul_details.moduldetail_section"])->where("id", $courseId)->first();

        $modul_detail = ModulDetail::with(["modul", "moduldetail_section", "soals"])
            ->withCount([
                "soals as multiple_choice_count" => function ($q) {
                    $q->where('tipe', 'multiple_choice');
                },
                "soals as essay_count" => function ($q) {
                    $q->where('tipe', 'essay');
                }
            ])
            ->orderBy("urutan")
            ->where("id", $id)
            ->first();

        $progress_list = ProgressUser::where("peserta_id", auth()->user()->username)
            ->where("course_id", $courseId)
            ->pluck("section_id")
            ->toArray();

        $total_pilgan = ModulDetail::withCount(['soals' => function ($query) {
            $query->where('tipe', 'multiple_choice');
        }])
            ->where('id', $id)->get();

        $section_status = [];
        $open_found = false;

        foreach ($course->moduls as $modul) {
            foreach ($modul->modul_details as $detail) {
                if (in_array($detail->id, $progress_list)) {
                    $section_status[$detail->id] = 'done';
                } else if (!$open_found) {
                    $section_status[$detail->id] = 'open';
                    $open_found = true;
                } else {
                    $section_status[$detail->id] = 'locked';
                }
            }
        }

        // dd($section_status);

        return view('course.my-module-detail', compact('course', 'modul_detail', 'section_status'));
    }

    public function index(Request $request): View
    {
        $query = Course::query();

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

        $course = $query->paginate(10);

        if ($request->header('HX-Request')) {
            return view('course.includes.index-table', compact('course'));
        }

        return view('course.index', compact('course', 'columns', 'selectedColumns'));
    }

    public function create(): View
    {
        $course = new Course();

        return view('course.create', compact('course'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'judul' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            Course::create($validatedData);
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'Terjadi kesalahan saat membuat data.');
        }

        return redirect()->route('course.index')
            ->with('success', 'Course berhasil dibuat');
    }

    public function show(Course $course): View
    {
        return view('course.show', compact('course'));
    }

    public function edit(Course $course): View
    {
        return view('course.edit', compact('course'));
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
        $validatedData = $request->validate([
            'judul' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $course->update($validatedData);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->back()
                    ->withInput($request->all())
                    ->with('error', 'Data course ini sudah digunakan dan tidak dapat diperbarui.');
            }
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }

        return redirect()->route('course.index')
            ->with('success', 'Course berhasil diperbarui');
    }

    public function destroy(Course $course): RedirectResponse
    {
        try {
            $course->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->route('course.index')
                    ->with('error', 'Data course ini sudah digunakan dan tidak dapat dihapus.');
            }
            return redirect()->route('course.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data.');
        }

        return redirect()->route('course.index')
            ->with('success', 'Course berhasil dihapus');
    }
}
