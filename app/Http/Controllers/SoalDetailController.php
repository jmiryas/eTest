<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\SoalDetail;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use \Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Woo\GridView\DataProviders\EloquentDataProvider;

class SoalDetailController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:etest soal-detail view', only: ['index', 'show']),
            new Middleware('permission:etest soal-detail create', only: ['create', 'store']),
            new Middleware('permission:etest soal-detail edit', only: ['edit', 'update']),
            new Middleware('permission:etest soal-detail delete', only: ['destroy']),
        ];
    }

    public function index(Request $request): View
    {
        $query = SoalDetail::with(["soal"]);

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

        $soalDetail = $query->paginate(10);

        if ($request->header('HX-Request')) {
            return view('soal-detail.includes.index-table', compact('soalDetail'));
        }

        return view('soal-detail.index', compact('soalDetail', 'columns', 'selectedColumns'));
    }

    public function create(): View
    {
        $soalDetail = new SoalDetail();

        $soalDetail->urutan = 1;
        $soalDetail->is_correct = false;

        $soals = Soal::orderBy("isi")->pluck("isi", "id");

        return view('soal-detail.create', compact('soalDetail', 'soals'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'soal_id' => 'required|string|max:50|exists:soal,id',
            'label' => 'required|string|max:10',
            'isi' => 'required|string',
            'is_correct' => 'required|boolean',
            'urutan' => 'required|integer',
        ]);

        try {
            SoalDetail::create($validatedData);
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'Terjadi kesalahan saat membuat data.');
        }

        return redirect()->route('soal-detail.index')
            ->with('success', 'Soal Detail berhasil dibuat');
    }

    public function show(SoalDetail $soalDetail): View
    {
        return view('soal-detail.show', compact('soalDetail'));
    }

    public function edit(SoalDetail $soalDetail): View
    {
        $soals = Soal::orderBy("isi")->pluck("isi", "id");

        return view('soal-detail.edit', compact('soalDetail', 'soals'));
    }

    public function update(Request $request, SoalDetail $soalDetail): RedirectResponse
    {
        $validatedData = $request->validate([
            'soal_id' => 'nullable|string|max:50',
            'label' => 'nullable|string|max:10',
            'isi' => 'nullable|string',
            'is_correct' => 'nullable|boolean',
            'urutan' => 'nullable|integer',
        ]);

        try {
            $soalDetail->update($validatedData);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->back()
                    ->withInput($request->all())
                    ->with('error', 'Data soal detail ini sudah digunakan dan tidak dapat diperbarui.');
            }
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }

        return redirect()->route('soal-detail.index')
            ->with('success', 'Soal Detail berhasil diperbarui');
    }

    public function destroy(SoalDetail $soalDetail): RedirectResponse
    {
        try {
            $soalDetail->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->route('soal-detail.index')
                    ->with('error', 'Data soal detail ini sudah digunakan dan tidak dapat dihapus.');
            }
            return redirect()->route('soal-detail.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data.');
        }

        return redirect()->route('soal-detail.index')
            ->with('success', 'Soal Detail berhasil dihapus');
    }
}
