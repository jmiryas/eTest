<div class="table-responsive">
    <table class="table table-striped" id="data-table" style="height: 100px;">
        <thead>
            <tr>
                <th>No</th>

                <th class="align-middle">Section</th>
                <th class="align-middle">Tipe</th>
                <th class="align-middle">Isi</th>
                <th class="align-middle">Poin</th>
                <th class="align-middle">Urutan</th>
                {{-- <th class="align-middle">Updatd At</th> --}}
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($soal as $row)
                <tr>
                    <td>{{ $loop->iteration + ($soal->currentPage() - 1) * $soal->perPage() }}</td>

                    <td>{{ $row?->modul_detail->judul }}</td>
                    <td>{{ $row?->tipe }}</td>
                    <td>{{ $row?->isi }}</td>
                    <td>{{ $row?->poin }}</td>
                    <td>{{ $row?->urutan }}</td>
                    {{-- <td>{{ $row?->updatd_at }}</td> --}}
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            @can('etest soal view')
                                <div class="me-1">
                                    <a href="{{ route('soal.show', $row) }}" class="btn btn-icon btn-outline-info btn-sm"
                                        data-bs-toggle="tooltip" data-bs-title="Detail" data-bs-placement="top">
                                        <span class="bx bx-show text-info"></span>
                                    </a>
                                </div>
                            @endcan
                            @can('etest soal edit')
                                <div class="me-1">
                                    <a href="{{ route('soal.edit', $row) }}" class="btn btn-icon btn-outline-primary btn-sm"
                                        data-bs-toggle="tooltip" data-bs-title="Edit" data-bs-placement="top">
                                        <span class="bx bx-pencil text-primary"></span>
                                    </a>
                                </div>
                            @endcan
                            @can('etest soal delete')
                                <form action="{{ route('soal.destroy', $row) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <x-input.confirm-button text="Data soal ini akan dihapus!" positive="Ya, hapus!"
                                        icon="info" class="btn btn-icon btn-outline-danger btn-sm"
                                        data-bs-toggle="tooltip" data-bs-title="Hapus" data-bs-placement="top">
                                        <span class="bx bx-trash text-danger"></span>
                                    </x-input.confirm-button>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Pagination --}}
<div class="mt-3 d-flex justify-content-end">
    {!! $soal->withQueryString()->links() !!}
</div>
