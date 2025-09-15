<?php

namespace App\Http\Controllers;

use App\Models\ProgressUser;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use \Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Woo\GridView\DataProviders\EloquentDataProvider;

class ProgressUserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:etest progress-user view', only: ['index', 'show']),
            new Middleware('permission:etest progress-user create', only: ['create', 'store']),
            new Middleware('permission:etest progress-user edit', only: ['edit', 'update']),
            new Middleware('permission:etest progress-user delete', only: ['destroy']),
        ];
    }

    public function index(Request $request): View
    {
        $query = ProgressUser::with(["course", "modul_detail", "modul", "peserta", "corrector"]);

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

        $progressUser = $query->paginate(10);

        if ($request->header('HX-Request')) {
            return view('progress-user.includes.index-table', compact('progressUser'));
        }

        return view('progress-user.index', compact('progressUser', 'columns', 'selectedColumns'));
    }

    public function create(): View
    {
        $progressUser = new ProgressUser();

        return view('progress-user.create', compact('progressUser'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'peserta_id' => 'nullable|string|max:50',
            'corrector_id' => 'nullable|integer',
            'course_id' => 'nullable|string|max:50',
            'modul_id' => 'nullable|string|max:50',
            'section_id' => 'nullable|string|max:50',
            'section_type' => 'nullable|string|max:50',
            'waktu_submit' => 'nullable|date_format:Y-m-d H:i:s',
            'waktu_koreksi' => 'nullable|date_format:Y-m-d H:i:s',
            'is_corrected' => 'nullable|boolean',
            'score' => 'nullable|numeric',
        ]);

        try {
            ProgressUser::create($validatedData);
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'Terjadi kesalahan saat membuat data.');
        }

        return redirect()->route('progress-user.index')
            ->with('success', 'Progress User berhasil dibuat');
    }

    public function show(ProgressUser $progressUser): View
    {
        return view('progress-user.show', compact('progressUser'));
    }

    public function edit(ProgressUser $progressUser): View
    {
        return view('progress-user.edit', compact('progressUser'));
    }

    public function update(Request $request, ProgressUser $progressUser): RedirectResponse
    {
        $validatedData = $request->validate([
            'peserta_id' => 'nullable|string|max:50',
            'corrector_id' => 'nullable|integer',
            'course_id' => 'nullable|string|max:50',
            'modul_id' => 'nullable|string|max:50',
            'section_id' => 'nullable|string|max:50',
            'section_type' => 'nullable|string|max:50',
            'waktu_submit' => 'nullable|date_format:Y-m-d H:i:s',
            'waktu_koreksi' => 'nullable|date_format:Y-m-d H:i:s',
            'is_corrected' => 'nullable|boolean',
            'score' => 'nullable|numeric',
        ]);

        try {
            $progressUser->update($validatedData);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->back()
                    ->withInput($request->all())
                    ->with('error', 'Data progress user ini sudah digunakan dan tidak dapat diperbarui.');
            }
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }

        return redirect()->route('progress-user.index')
            ->with('success', 'Progress User berhasil diperbarui');
    }

    public function destroy(ProgressUser $progressUser): RedirectResponse
    {
        try {
            $progressUser->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->route('progress-user.index')
                    ->with('error', 'Data progress user ini sudah digunakan dan tidak dapat dihapus.');
            }
            return redirect()->route('progress-user.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data.');
        }

        return redirect()->route('progress-user.index')
            ->with('success', 'Progress User berhasil dihapus');
    }
}
