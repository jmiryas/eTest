<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use \Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Woo\GridView\DataProviders\EloquentDataProvider;

class PesertaController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:etest peserta view', only: ['index', 'show']),
            new Middleware('permission:etest peserta create', only: ['create', 'store']),
            new Middleware('permission:etest peserta edit', only: ['edit', 'update']),
            new Middleware('permission:etest peserta delete', only: ['destroy']),
        ];
    }

    public function generate()
    {
        $rolePeserta = Role::firstOrCreate(['name' => 'Peserta']);

        $users = DB::select("SELECT p.id AS peserta_id, p.nama, u.id AS user_id, u.username
            FROM peserta AS p
            LEFT JOIN users AS u ON p.id COLLATE utf8mb4_unicode_ci = u.username
            WHERE u.id IS NULL;
        ");

        $jumlah = 0;

        foreach ($users as $item) {
            // dd($item);

            $newUser = User::create([
                'name' => $item->nama,
                'username' => $item->peserta_id,
                'password' => Hash::make("123456"),
            ]);

            $newUser->assignRole($rolePeserta->name);

            $jumlah++;
        }

        return redirect()->route('peserta.index')
            ->with('success', "Berhasil generate user sebanyak $jumlah");
    }

    public function index(Request $request): View
    {
        $query = Peserta::query();

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

        $peserta = $query->paginate(10);

        if ($request->header('HX-Request')) {
            return view('peserta.includes.index-table', compact('peserta'));
        }

        return view('peserta.index', compact('peserta', 'columns', 'selectedColumns'));
    }

    public function create(): View
    {
        $peserta = new Peserta();

        return view('peserta.create', compact('peserta'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'id' => 'required|string|max:50|unique:peserta,id',
            'nama' => 'nullable|string|max:100',
            'kodejk' => 'nullable|string|in:L,P,-',
            'tgl_lahir' => 'nullable|date_format:Y-m-d H:i:s',
        ]);

        try {
            Peserta::create($validatedData);
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'Terjadi kesalahan saat membuat data.');
        }

        return redirect()->route('peserta.index')
            ->with('success', 'Peserta berhasil dibuat');
    }

    public function show(Peserta $peserta): View
    {
        return view('peserta.show', compact('peserta'));
    }

    public function edit(Peserta $peserta): View
    {
        return view('peserta.edit', compact('peserta'));
    }

    public function update(Request $request, Peserta $peserta): RedirectResponse
    {
        $validatedData = $request->validate([
            'nama' => 'nullable|string|max:100',
            'kodejk' => 'nullable|string|in:L,P,-',
            'tgl_lahir' => 'nullable|date_format:Y-m-d H:i:s',
        ]);

        try {
            $peserta->update($validatedData);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->back()
                    ->withInput($request->all())
                    ->with('error', 'Data peserta ini sudah digunakan dan tidak dapat diperbarui.');
            }
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }

        return redirect()->route('peserta.index')
            ->with('success', 'Peserta berhasil diperbarui');
    }

    public function destroy(Peserta $peserta): RedirectResponse
    {
        try {
            $peserta->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->route('peserta.index')
                    ->with('error', 'Data peserta ini sudah digunakan dan tidak dapat dihapus.');
            }
            return redirect()->route('peserta.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data.');
        }

        return redirect()->route('peserta.index')
            ->with('success', 'Peserta berhasil dihapus');
    }
}
