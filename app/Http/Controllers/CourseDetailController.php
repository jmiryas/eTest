<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseDetail;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use \Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Woo\GridView\DataProviders\EloquentDataProvider;

class CourseDetailController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:etest course-detail view', only: ['index', 'show']),
            new Middleware('permission:etest course-detail create', only: ['create', 'store']),
            new Middleware('permission:etest course-detail edit', only: ['edit', 'update']),
            new Middleware('permission:etest course-detail delete', only: ['destroy']),
        ];
    }

    public function index(Request $request): View
    {
        $query = CourseDetail::with(["course", "peserta", "enroller"]);

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

        $courseDetail = $query->paginate(10);

        if ($request->header('HX-Request')) {
            return view('course-detail.includes.index-table', compact('courseDetail'));
        }

        return view('course-detail.index', compact('courseDetail', 'columns', 'selectedColumns'));
    }

    public function create(): View
    {
        $courseDetail = new CourseDetail();

        $courses = Course::orderBy("judul")->pluck("judul", "id")->toArray();
        $pesertas = Peserta::orderBy('nama')
            ->get()
            ->mapWithKeys(fn($p) => [$p->id => "({$p->id}) {$p->nama}"])
            ->toArray();

        return view('course-detail.create', compact('courseDetail', 'courses', 'pesertas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'course_id' => 'required|string|max:50|exists:courses,id',
            'peserta_id' => 'required|string|max:50|exists:peserta,id'
        ]);

        try {
            CourseDetail::create([
                ...$validatedData,
                'enrolled_by' => auth()->id(),
                'enrolled_at' => now(),
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'Terjadi kesalahan saat membuat data.');
        }

        return redirect()->route('course-detail.index')
            ->with('success', 'Course Detail berhasil dibuat');
    }

    public function show(CourseDetail $courseDetail): View
    {
        return view('course-detail.show', compact('courseDetail'));
    }

    public function edit(CourseDetail $courseDetail): View
    {
        $courses = Course::orderBy("judul")->pluck("judul", "id")->toArray();
        $pesertas = Peserta::orderBy('nama')
            ->get()
            ->mapWithKeys(fn($p) => [$p->id => "({$p->id}) {$p->nama}"])
            ->toArray();

        return view('course-detail.edit', compact('courseDetail', 'courses', 'pesertas'));
    }

    public function update(Request $request, CourseDetail $courseDetail): RedirectResponse
    {
        $validatedData = $request->validate([
            'course_id' => 'nullable|string|max:50',
            'peserta_id' => 'nullable|string|max:50',
            'enrolled_by' => 'nullable|integer',
            'enrolled_at' => 'nullable|date_format:Y-m-d H:i:s',
        ]);

        try {
            $courseDetail->update($validatedData);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->back()
                    ->withInput($request->all())
                    ->with('error', 'Data course detail ini sudah digunakan dan tidak dapat diperbarui.');
            }
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }

        return redirect()->route('course-detail.index')
            ->with('success', 'Course Detail berhasil diperbarui');
    }

    public function destroy(CourseDetail $courseDetail): RedirectResponse
    {
        try {
            $courseDetail->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->route('course-detail.index')
                    ->with('error', 'Data course detail ini sudah digunakan dan tidak dapat dihapus.');
            }
            return redirect()->route('course-detail.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data.');
        }

        return redirect()->route('course-detail.index')
            ->with('success', 'Course Detail berhasil dihapus');
    }
}
