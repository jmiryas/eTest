<div class="table-responsive">
    <table class="table table-striped" id="data-table" style="height: 100px;">
        <thead>
            <tr>
                <th>No</th>

                <th class="align-middle">Banksoal</th>
                <th class="align-middle">Label</th>
                <th class="align-middle">Isi</th>
                <th class="align-middle">Status</th>
                <th class="align-middle">Urutan</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($banksoalDetail as $row)
                <tr>
                    <td>{{ $loop->iteration + ($banksoalDetail->currentPage() - 1) * $banksoalDetail->perPage() }}</td>

                    <td>{{ $row?->banksoal->isi }}</td>
                    <td>{{ $row?->label }}</td>
                    <td>{{ $row?->isi }}</td>
                    <td>
                        @if ($row?->is_correct)
                            <i class="bx bx-check text-success fs-3"></i>
                        @else
                            <i class="bx bx-x text-danger fs-3"></i>
                        @endif
                    </td>
                    <td>{{ $row?->urutan }}</td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            @can('etest banksoal-detail view')
                                <div class="me-1">
                                    <a href="{{ route('banksoal-detail.show', $row) }}"
                                        class="btn btn-icon btn-outline-info btn-sm" data-bs-toggle="tooltip"
                                        data-bs-title="Detail" data-bs-placement="top">
                                        <span class="bx bx-show text-info"></span>
                                    </a>
                                </div>
                            @endcan
                            @can('etest banksoal-detail edit')
                                <div class="me-1">
                                    <a href="{{ route('banksoal-detail.edit', $row) }}"
                                        class="btn btn-icon btn-outline-primary btn-sm" data-bs-toggle="tooltip"
                                        data-bs-title="Edit" data-bs-placement="top">
                                        <span class="bx bx-pencil text-primary"></span>
                                    </a>
                                </div>
                            @endcan
                            @can('etest banksoal-detail delete')
                                <form action="{{ route('banksoal-detail.destroy', $row) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <x-input.confirm-button text="Data banksoal detail ini akan dihapus!"
                                        positive="Ya, hapus!" icon="info" class="btn btn-icon btn-outline-danger btn-sm"
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
    {!! $banksoalDetail->withQueryString()->links() !!}
</div>
