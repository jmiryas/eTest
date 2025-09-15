<?php

namespace App\Http\Controllers;

use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use \Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Woo\GridView\DataProviders\EloquentDataProvider;

class UserAnswerController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:etest user-answer view', only: ['index', 'show']),
            new Middleware('permission:etest user-answer create', only: ['create', 'store']),
            new Middleware('permission:etest user-answer edit', only: ['edit', 'update']),
            new Middleware('permission:etest user-answer delete', only: ['destroy']),
        ];
    }

    public function index(Request $request): View
    {
        $query = UserAnswer::with(["modul_detail", "peserta", "soal", "corrector"]);

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

        $userAnswer = $query->paginate(10);

        if ($request->header('HX-Request')) {
            return view('user-answer.includes.index-table', compact('userAnswer'));
        }

        return view('user-answer.index', compact('userAnswer', 'columns', 'selectedColumns'));
    }

    public function create(): View
    {
        $userAnswer = new UserAnswer();

        return view('user-answer.create', compact('userAnswer'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'peserta_id' => 'nullable|string|max:50',
            'modul_detail_id' => 'nullable|string|max:50',
            'soal_id' => 'nullable|string|max:50',
            'corrector_id' => 'nullable|integer',
            'soal_tipe' => 'nullable|string|max:50',
            'soal_text' => 'nullable|string',
            'answer_label' => 'nullable|string|max:50',
            'answer_text' => 'nullable|string',
            'is_correct' => 'nullable|boolean',
            'score' => 'nullable|numeric',
        ]);

        try {
            UserAnswer::create($validatedData);
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'Terjadi kesalahan saat membuat data.');
        }

        return redirect()->route('user-answer.index')
            ->with('success', 'User Answer berhasil dibuat');
    }

    public function show(UserAnswer $userAnswer): View
    {
        return view('user-answer.show', compact('userAnswer'));
    }

    public function edit(UserAnswer $userAnswer): View
    {
        return view('user-answer.edit', compact('userAnswer'));
    }

    public function update(Request $request, UserAnswer $userAnswer): RedirectResponse
    {
        $validatedData = $request->validate([
            'peserta_id' => 'nullable|string|max:50',
            'modul_detail_id' => 'nullable|string|max:50',
            'soal_id' => 'nullable|string|max:50',
            'corrector_id' => 'nullable|integer',
            'soal_tipe' => 'nullable|string|max:50',
            'soal_text' => 'nullable|string',
            'answer_label' => 'nullable|string|max:50',
            'answer_text' => 'nullable|string',
            'is_correct' => 'nullable|boolean',
            'score' => 'nullable|numeric',
        ]);

        try {
            $userAnswer->update($validatedData);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->back()
                    ->withInput($request->all())
                    ->with('error', 'Data user answer ini sudah digunakan dan tidak dapat diperbarui.');
            }
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }

        return redirect()->route('user-answer.index')
            ->with('success', 'User Answer berhasil diperbarui');
    }

    public function destroy(UserAnswer $userAnswer): RedirectResponse
    {
        try {
            $userAnswer->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->route('user-answer.index')
                    ->with('error', 'Data user answer ini sudah digunakan dan tidak dapat dihapus.');
            }
            return redirect()->route('user-answer.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data.');
        }

        return redirect()->route('user-answer.index')
            ->with('success', 'User Answer berhasil dihapus');
    }
}
