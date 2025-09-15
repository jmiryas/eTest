<div class="table-responsive">
    <table class="table table-striped" id="data-table" style="height: 100px;">
        <thead>
            <tr>
                <th>No</th>

                <th class="align-middle">Course</th>
                <th class="align-middle">Judul</th>
                {{-- <th class="align-middle">Deskripsi</th> --}}
                <th class="align-middle">Urutan</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($modul as $row)
                <tr>
                    <td>{{ $loop->iteration + ($modul->currentPage() - 1) * $modul->perPage() }}</td>

                    <td>{{ $row?->course->judul ?? '' }}</td>
                    <td>{{ $row?->judul }}</td>
                    {{-- <td>{{ $row?->deskripsi }}</td> --}}
                    <td>{{ $row?->urutan }}</td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            @can('etest modul view')
                                <div class="me-1">
                                    <a href="{{ route('modul.show', $row) }}" class="btn btn-icon btn-outline-info btn-sm"
                                        data-bs-toggle="tooltip" data-bs-title="Detail" data-bs-placement="top">
                                        <span class="bx bx-show text-info"></span>
                                    </a>
                                </div>
                            @endcan
                            @can('etest modul edit')
                                <div class="me-1">
                                    <a href="{{ route('modul.edit', $row) }}"
                                        class="btn btn-icon btn-outline-primary btn-sm" data-bs-toggle="tooltip"
                                        data-bs-title="Edit" data-bs-placement="top">
                                        <span class="bx bx-pencil text-primary"></span>
                                    </a>
                                </div>
                            @endcan
                            @can('etest modul delete')
                                <form action="{{ route('modul.destroy', $row) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <x-input.confirm-button text="Data modul ini akan dihapus!" positive="Ya, hapus!"
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
    {!! $modul->withQueryString()->links() !!}
</div>
