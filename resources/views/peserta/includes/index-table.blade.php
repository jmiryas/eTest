<div class="table-responsive">
    <table class="table table-striped" id="data-table" style="height: 100px;">
        <thead>
            <tr>
                <th>No</th>
                <th class="align-middle">ID</th>
                <th class="align-middle">Nama</th>
                <th class="align-middle">Jenis Kelamin</th>
                {{-- <th class="align-middle">Tgl Lahir</th> --}}
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($peserta as $row)
                <tr>
                    <td>{{ $loop->iteration + ($peserta->currentPage() - 1) * $peserta->perPage() }}</td>

                    <td>{{ $row?->id }}</td>
                    <td>{{ $row?->nama }}</td>
                    <td>{{ $row?->kodejk }}</td>
                    {{-- <td>{{ $row?->tgl_lahir }}</td> --}}
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            @can('etest peserta view')
                                <div class="me-1">
                                    <a href="{{ route('peserta.show', $row) }}"
                                        class="btn btn-icon btn-outline-info waves-effect btn-sm" data-bs-toggle="tooltip"
                                        data-bs-title="Detail" data-bs-placement="top">
                                        <span class="bx bx-show text-info"></span>
                                    </a>
                                </div>
                            @endcan
                            @can('etest peserta edit')
                                <div class="me-1">
                                    <a href="{{ route('peserta.edit', $row) }}"
                                        class="btn btn-icon btn-outline-primary btn-sm" data-bs-toggle="tooltip"
                                        data-bs-title="Edit" data-bs-placement="top">
                                        <span class="bx bx-pencil text-primary"></span>
                                    </a>
                                </div>
                            @endcan
                            @can('etest peserta delete')
                                <form action="{{ route('peserta.destroy', $row) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <x-input.confirm-button text="Data peserta ini akan dihapus!" positive="Ya, hapus!"
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
    {!! $peserta->withQueryString()->links() !!}
</div>
