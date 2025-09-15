<div class="btn-group text-nowrap" role="group">
    @can('etest user view')
        <div class="me-1">
            <a href="{{ route('users.show', $row) }}" class="btn btn-icon btn-outline-info btn-sm" data-bs-toggle="tooltip"
                data-bs-title="Detail" data-bs-placement="top">
                <span class="bx bx-show text-info"></span>
            </a>
        </div>
    @endcan
    @can('etest user edit')
        <div class="me-1">
            <a href="{{ route('users.edit', $row) }}" class="btn btn-icon btn-outline-primary btn-sm"
                data-bs-toggle="tooltip" data-bs-title="Edit" data-bs-placement="top">
                <span class="bx bx-pencil text-primary"></span>
            </a>
        </div>
    @endcan
    @can('etest user delete')
        <form action="{{ route('users.destroy', $row) }}" method="POST" class="d-inline">
            @csrf @method('DELETE')
            <x-input.confirm-button text="Data pendaftaran tryout ini akan dihapus!" positive="Ya, hapus!" icon="info"
                class="btn btn-icon btn-outline-danger btn-sm" data-bs-toggle="tooltip" data-bs-title="Hapus"
                data-bs-placement="top">
                <span class="bx bx-trash text-danger"></span>
            </x-input.confirm-button>
        </form>
    @endcan
</div>
