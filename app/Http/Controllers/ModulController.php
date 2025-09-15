<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Modul;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use \Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Woo\GridView\DataProviders\EloquentDataProvider;

class ModulController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:etest modul view', only: ['index', 'show']),
            new Middleware('permission:etest modul create', only: ['create', 'store']),
            new Middleware('permission:etest modul edit', only: ['edit', 'update']),
            new Middleware('permission:etest modul delete', only: ['destroy']),
        ];
    }

    public function index(Request $request): View
    {
        $query = Modul::with(["course"]);

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

        $modul = $query->paginate(10);

        if ($request->header('HX-Request')) {
            return view('modul.includes.index-table', compact('modul'));
        }

        return view('modul.index', compact('modul', 'columns', 'selectedColumns'));
    }

    public function create(): View
    {
        $modul = new Modul();

        $courses = Course::orderBy("judul")->pluck("judul", "id")->toArray();

        return view('modul.create', compact('modul', 'courses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'course_id' => 'nullable|string|max:50',
            'judul' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'urutan' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            Modul::create($validatedData);
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'Terjadi kesalahan saat membuat data.');
        }

        return redirect()->route('modul.index')
            ->with('success', 'Modul berhasil dibuat');
    }

    public function show(Modul $modul): View
    {
        return view('modul.show', compact('modul'));
    }

    public function edit(Modul $modul): View
    {
        return view('modul.edit', compact('modul'));
    }

    public function update(Request $request, Modul $modul): RedirectResponse
    {
        $validatedData = $request->validate([
            'course_id' => 'nullable|string|max:50',
            'judul' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'urutan' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $modul->update($validatedData);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->back()
                    ->withInput($request->all())
                    ->with('error', 'Data modul ini sudah digunakan dan tidak dapat diperbarui.');
            }
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }

        return redirect()->route('modul.index')
            ->with('success', 'Modul berhasil diperbarui');
    }

    public function destroy(Modul $modul): RedirectResponse
    {
        try {
            $modul->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->route('modul.index')
                    ->with('error', 'Data modul ini sudah digunakan dan tidak dapat dihapus.');
            }
            return redirect()->route('modul.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data.');
        }

        return redirect()->route('modul.index')
            ->with('success', 'Modul berhasil dihapus');
    }
}
