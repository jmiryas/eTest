<div class="table-responsive">
    <table class="table table-striped" id="data-table" style="height: 100px;">
        <thead>
            <tr>
                <th>No</th>

                <th class="align-middle">Course</th>
                <th class="align-middle">Peserta</th>
                <th class="align-middle">Enrolled By</th>
                <th class="align-middle">Enrolled At</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($courseDetail as $row)
                <tr>
                    <td>{{ $loop->iteration + ($courseDetail->currentPage() - 1) * $courseDetail->perPage() }}</td>

                    <td>{{ $row?->course->judul }}</td>
                    <td>{{ "({$row?->peserta_id}) {$row?->peserta->nama}" }}</td>
                    <td>{{ $row?->enroller->name }}</td>
                    <td>{{ formatDatetime($row?->enrolled_at, 'datetime') }}</td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            @can('etest course-detail view')
                                <div class="me-1">
                                    <a href="{{ route('course-detail.show', $row) }}"
                                        class="btn btn-icon btn-outline-info btn-sm" data-bs-toggle="tooltip"
                                        data-bs-title="Detail" data-bs-placement="top">
                                        <span class="bx bx-show text-info"></span>
                                    </a>
                                </div>
                            @endcan
                            @can('etest course-detail edit')
                                <div class="me-1">
                                    <a href="{{ route('course-detail.edit', $row) }}"
                                        class="btn btn-icon btn-outline-primary btn-sm" data-bs-toggle="tooltip"
                                        data-bs-title="Edit" data-bs-placement="top">
                                        <span class="bx bx-pencil text-primary"></span>
                                    </a>
                                </div>
                            @endcan
                            @can('etest course-detail delete')
                                <form action="{{ route('course-detail.destroy', $row) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <x-input.confirm-button text="Data course detail ini akan dihapus!"
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
    {!! $courseDetail->withQueryString()->links() !!}
</div>
