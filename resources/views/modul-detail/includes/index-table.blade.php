<div class="table-responsive">
    <table class="table table-striped" id="data-table" style="height: 100px;">
        <thead>
            <tr>
                <th>No</th>

                <th class="align-middle">Modul</th>
                <th class="align-middle">Section</th>
                <th class="align-middle">Judul</th>
                <th class="align-middle">Waktu Mulai</th>
                <th class="align-middle">Waktu Selesai</th>
                <th class="align-middle">Durasi Menit</th>
                <th class="align-middle">Urutan</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($modulDetail as $row)
                <tr>
                    <td>{{ $loop->iteration + ($modulDetail->currentPage() - 1) * $modulDetail->perPage() }}</td>

                    <td>{{ $row?->modul->judul }}</td>
                    <td>{{ $row?->moduldetail_section->nama }}</td>
                    <td>{{ $row?->judul }}</td>
                    <td>{{ formatDatetime($row?->waktu_mulai, 'datetime') }}</td>
                    <td>{{ formatDatetime($row?->waktu_selesai, 'datetime') }}</td>
                    <td>{{ $row?->durasi_menit ?? '-' }}</td>
                    <td>{{ $row?->urutan }}</td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            @can('etest modul-detail view')
                                <div class="me-1">
                                    <a href="{{ route('modul-detail.show', $row) }}"
                                        class="btn btn-icon btn-outline-info btn-sm" data-bs-toggle="tooltip"
                                        data-bs-title="Detail" data-bs-placement="top">
                                        <span class="bx bx-show text-info"></span>
                                    </a>
                                </div>
                            @endcan
                            @can('etest modul-detail edit')
                                <div class="me-1">
                                    <a href="{{ route('modul-detail.edit', $row) }}"
                                        class="btn btn-icon btn-outline-primary btn-sm" data-bs-toggle="tooltip"
                                        data-bs-title="Edit" data-bs-placement="top">
                                        <span class="bx bx-pencil text-primary"></span>
                                    </a>
                                </div>
                            @endcan
                            @can('etest modul-detail delete')
                                <form action="{{ route('modul-detail.destroy', $row) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <x-input.confirm-button text="Data modul detail ini akan dihapus!" positive="Ya, hapus!"
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
    {!! $modulDetail->withQueryString()->links() !!}
</div>
