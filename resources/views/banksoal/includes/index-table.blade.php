<div class="table-responsive">
    <table class="table table-striped" id="data-table" style="height: 100px;">
        <thead>
            <tr>
                <th>No</th>

                <th class="align-middle">Group Code</th>
                <th class="align-middle">Tipe</th>
                <th class="align-middle">Isi</th>
                <th class="align-middle">Poin</th>
                <th class="align-middle">Durasi (Menit)</th>
                <th class="align-middle">Urutan</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($banksoal as $row)
                <tr>
                    <td>{{ $loop->iteration + ($banksoal->currentPage() - 1) * $banksoal->perPage() }}</td>

                    <td>{{ $row?->group_code }}</td>
                    <td>{{ get_jenis_soal($row?->tipe) }}</td>
                    <td>{{ $row?->isi }}</td>
                    <td>{{ $row?->poin }}</td>
                    <td>{{ convert_time_units($row?->durasi_original, 'second', 'minute') }}</td>
                    <td>{{ $row?->urutan }}</td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            @can('etest banksoal view')
                                <div class="me-1">
                                    <a href="{{ route('banksoal.show', $row) }}"
                                        class="btn btn-icon btn-outline-info btn-sm" data-bs-toggle="tooltip"
                                        data-bs-title="Detail" data-bs-placement="top">
                                        <span class="bx bx-show text-info"></span>
                                    </a>
                                </div>
                            @endcan
                            @can('etest banksoal edit')
                                <div class="me-1">
                                    <a href="{{ route('banksoal.edit', $row) }}"
                                        class="btn btn-icon btn-outline-primary btn-sm" data-bs-toggle="tooltip"
                                        data-bs-title="Edit" data-bs-placement="top">
                                        <span class="bx bx-pencil text-primary"></span>
                                    </a>
                                </div>
                            @endcan
                            @can('etest banksoal delete')
                                <form action="{{ route('banksoal.destroy', $row) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <x-input.confirm-button text="Data banksoal ini akan dihapus!" positive="Ya, hapus!"
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
    {!! $banksoal->withQueryString()->links() !!}
</div>
