<?php

namespace App\Http\Controllers;

use App\Models\ModuldetailSection;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use \Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Woo\GridView\DataProviders\EloquentDataProvider;

class ModuldetailSectionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:etest moduldetail-section view', only: ['index', 'show']),
            new Middleware('permission:etest moduldetail-section create', only: ['create', 'store']),
            new Middleware('permission:etest moduldetail-section edit', only: ['edit', 'update']),
            new Middleware('permission:etest moduldetail-section delete', only: ['destroy']),
        ];
    }

    public function index(Request $request): View
    {
        $query = ModuldetailSection::query();

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

        $moduldetailSection = $query->paginate(10);

        if ($request->header('HX-Request')) {
            return view('moduldetail-section.includes.index-table', compact('moduldetailSection'));
        }

        return view('moduldetail-section.index', compact('moduldetailSection', 'columns', 'selectedColumns'));
    }

    public function create(): View
    {
        $moduldetailSection = new ModuldetailSection();

        return view('moduldetail-section.create', compact('moduldetailSection'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'nama' => 'nullable|string|max:50',
            'urutan' => 'nullable|integer',
        ]);

        try {
            ModuldetailSection::create($validatedData);
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'Terjadi kesalahan saat membuat data.');
        }

        return redirect()->route('moduldetail-section.index')
            ->with('success', 'Moduldetail Section berhasil dibuat');
    }

    public function show(ModuldetailSection $moduldetailSection): View
    {
        return view('moduldetail-section.show', compact('moduldetailSection'));
    }

    public function edit(ModuldetailSection $moduldetailSection): View
    {
        return view('moduldetail-section.edit', compact('moduldetailSection'));
    }

    public function update(Request $request, ModuldetailSection $moduldetailSection): RedirectResponse
    {
        $validatedData = $request->validate([
            'nama' => 'nullable|string|max:50',
            'urutan' => 'nullable|integer',
        ]);

        try {
            $moduldetailSection->update($validatedData);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->back()
                    ->withInput($request->all())
                    ->with('error', 'Data moduldetail section ini sudah digunakan dan tidak dapat diperbarui.');
            }
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }

        return redirect()->route('moduldetail-section.index')
            ->with('success', 'Moduldetail Section berhasil diperbarui');
    }

    public function destroy(ModuldetailSection $moduldetailSection): RedirectResponse
    {
        try {
            $moduldetailSection->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->route('moduldetail-section.index')
                    ->with('error', 'Data moduldetail section ini sudah digunakan dan tidak dapat dihapus.');
            }
            return redirect()->route('moduldetail-section.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data.');
        }

        return redirect()->route('moduldetail-section.index')
            ->with('success', 'Moduldetail Section berhasil dihapus');
    }
}
