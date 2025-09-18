<?php

namespace App\Http\Controllers;

use App\Models\Banksoal;
use App\Models\BanksoalDetail;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use \Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Woo\GridView\DataProviders\EloquentDataProvider;

class BanksoalController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:etest banksoal view', only: ['index', 'show']),
            new Middleware('permission:etest banksoal create', only: ['create', 'store']),
            new Middleware('permission:etest banksoal edit', only: ['edit', 'update']),
            new Middleware('permission:etest banksoal delete', only: ['destroy']),
        ];
    }

    public function index(Request $request): View
    {
        $query = Banksoal::query();

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

        $banksoal = $query->paginate(10);

        if ($request->header('HX-Request')) {
            return view('banksoal.includes.index-table', compact('banksoal'));
        }

        return view('banksoal.index', compact('banksoal', 'columns', 'selectedColumns'));
    }

    public function create(): View
    {
        $banksoal = new Banksoal();

        $banksoal->poin = 1;
        $banksoal->urutan = 1;
        $banksoal->tipe_durasi = "second";
        $banksoal->durasi_original = 30;

        return view('banksoal.create', compact('banksoal'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'group_code' => 'required|string|max:50',
            'tipe' => 'required|string|in:multiple_choice,essay,',
            'isi' => 'required|string',
            'poin' => 'required|integer',
            'tipe_durasi' => 'required|string|in:second,minute',
            'durasi_original' => 'required|integer',
            'urutan' => 'required|integer',
            'options' => 'required|array|size:5',
            'options.*.label' => 'required|string',
            'options.*.isi' => 'required|string',
            'correct_option' => 'required|integer|min:0|max:4',
        ]);

        try {
            $original_duration = $request->input('durasi_original');
            $duration_type = $request->input('tipe_durasi');

            $duration_second = convert_time_units($original_duration, $duration_type, 'second');

            $banksoal = Banksoal::create($validatedData);

            $banksoal->durasi_detik = $duration_second;
            $banksoal->save();

            foreach ($validatedData["options"] as $index => $option) {
                $is_correct = (int) $validatedData["correct_option"] == $index;
                $urutan = $index + 1;

                BanksoalDetail::create([
                    "banksoal_id" => $banksoal->id,
                    "label" => $option["label"],
                    "isi" => $option["isi"],
                    "is_correct" => $is_correct,
                    "urutan" => $urutan
                ]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'Terjadi kesalahan saat membuat data.');
        }

        return redirect()->route('banksoal.index')
            ->with('success', 'Banksoal berhasil dibuat');
    }

    public function show(Banksoal $banksoal): View
    {
        return view('banksoal.show', compact('banksoal'));
    }

    public function edit(Banksoal $banksoal): View
    {
        return view('banksoal.edit', compact('banksoal'));
    }

    public function update(Request $request, Banksoal $banksoal): RedirectResponse
    {
        $validatedData = $request->validate([
            'group_code' => 'required|string|max:50',
            'tipe' => 'required|string|in:multiple_choice,essay,',
            'isi' => 'required|string',
            'poin' => 'required|integer',
            'tipe_durasi' => 'required|string|in:second,minute',
            'durasi_original' => 'required|integer',
            'urutan' => 'required|integer',
        ]);

        try {
            $original_duration = $request->input('durasi_original');
            $duration_type = $request->input('tipe_durasi');

            $duration_second = convert_time_units($original_duration, $duration_type, 'second');

            $banksoal->update($validatedData);

            $banksoal->durasi_detik = $duration_second;
            $banksoal->save();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->back()
                    ->withInput($request->all())
                    ->with('error', 'Data banksoal ini sudah digunakan dan tidak dapat diperbarui.');
            }
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }

        return redirect()->route('banksoal.index')
            ->with('success', 'Banksoal berhasil diperbarui');
    }

    public function destroy(Banksoal $banksoal): RedirectResponse
    {
        try {
            $banksoal->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->route('banksoal.index')
                    ->with('error', 'Data banksoal ini sudah digunakan dan tidak dapat dihapus.');
            }
            return redirect()->route('banksoal.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data.');
        }

        return redirect()->route('banksoal.index')
            ->with('success', 'Banksoal berhasil dihapus');
    }
}
