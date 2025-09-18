<?php

namespace App\Http\Controllers;

use App\Models\BanksoalDetail;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use \Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Woo\GridView\DataProviders\EloquentDataProvider;

class BanksoalDetailController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:etest banksoal-detail view', only: ['index', 'show']),
            new Middleware('permission:etest banksoal-detail create', only: ['create', 'store']),
            new Middleware('permission:etest banksoal-detail edit', only: ['edit', 'update']),
            new Middleware('permission:etest banksoal-detail delete', only: ['destroy']),
        ];
    }

    public function index(Request $request): View
    {
        $query = BanksoalDetail::with(["banksoal"]);

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

        $banksoalDetail = $query->paginate(10);

        if ($request->header('HX-Request')) {
            return view('banksoal-detail.includes.index-table', compact('banksoalDetail'));
        }

        return view('banksoal-detail.index', compact('banksoalDetail', 'columns', 'selectedColumns'));
    }

    public function create(): View
    {
        $banksoalDetail = new BanksoalDetail();

        return view('banksoal-detail.create', compact('banksoalDetail'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'banksoal_id' => 'nullable|string|max:50',
            'label' => 'nullable|string|max:10',
            'isi' => 'nullable|string',
            'is_correct' => 'nullable|boolean',
            'urutan' => 'nullable|integer',
        ]);

        try {
            BanksoalDetail::create($validatedData);
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'Terjadi kesalahan saat membuat data.');
        }

        return redirect()->route('banksoal-detail.index')
            ->with('success', 'Banksoal Detail berhasil dibuat');
    }

    public function show(BanksoalDetail $banksoalDetail): View
    {
        return view('banksoal-detail.show', compact('banksoalDetail'));
    }

    public function edit(BanksoalDetail $banksoalDetail): View
    {
        return view('banksoal-detail.edit', compact('banksoalDetail'));
    }

    public function update(Request $request, BanksoalDetail $banksoalDetail): RedirectResponse
    {
        $validatedData = $request->validate([
            'banksoal_id' => 'nullable|string|max:50',
            'label' => 'nullable|string|max:10',
            'isi' => 'nullable|string',
            'is_correct' => 'nullable|boolean',
            'urutan' => 'nullable|integer',
        ]);

        try {
            $banksoalDetail->update($validatedData);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->back()
                    ->withInput($request->all())
                    ->with('error', 'Data banksoal detail ini sudah digunakan dan tidak dapat diperbarui.');
            }
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }

        return redirect()->route('banksoal-detail.index')
            ->with('success', 'Banksoal Detail berhasil diperbarui');
    }

    public function destroy(BanksoalDetail $banksoalDetail): RedirectResponse
    {
        try {
            $banksoalDetail->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->route('banksoal-detail.index')
                    ->with('error', 'Data banksoal detail ini sudah digunakan dan tidak dapat dihapus.');
            }
            return redirect()->route('banksoal-detail.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data.');
        }

        return redirect()->route('banksoal-detail.index')
            ->with('success', 'Banksoal Detail berhasil dihapus');
    }
}
