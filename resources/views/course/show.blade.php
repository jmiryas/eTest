<x-layout.app title="Detail Kursus" activeMenu="course.show" :withError="true">
    <div class="container my-5">
        <x-breadcrumb title="Detail Kursus" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Kursus', 'url' => route('course.index')],
            ['label' => 'Detail Kursus'],
        ]" />

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('course.index') }}" class="btn btn-sm btn-secondary">
                        <i class="bx bx-arrow-back me-1"></i>Kembali
                    </a>

                    <div>
                        @can('etest course view')
                            <a href="{{ route('course.create') }}" class="btn btn-sm btn-info">
                                <i class="bx bx-plus me-1"></i>Baru
                            </a>
                        @endcan
                        @can('etest course edit')
                            <a href="{{ route('course.edit', $course) }}" class="btn btn-sm btn-primary">
                                <i class="bx bx-pencil me-1"></i>Edit
                            </a>
                        @endcan
                        @can('etest course delete')
                            <form action="{{ route('course.destroy', $course) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <x-input.confirm-button text="Data course ini akan dihapus!" positive="Ya, hapus!"
                                    icon="info" class="btn btn-danger btn-sm" data-bs-toggle="tooltip"
                                    data-bs-title="Hapus" data-bs-placement="top">
                                    <i class="bx bx-trash me-1"></i>Hapus
                                </x-input.confirm-button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="row g-3">

                    <div class="col-md-4">
                        <label for="first-name-horizontal">Judul</label>
                    </div>
                    <div class="col-md-8 form-group">: {{ $course->judul }}</div>
                    <div class="col-md-4">
                        <label for="first-name-horizontal">Deskripsi</label>
                    </div>
                    <div class="col-md-8 form-group">: {{ $course->deskripsi }}</div>
                    <div class="col-md-4">
                        <label for="first-name-horizontal">Is Active</label>
                    </div>
                    <div class="col-md-8 form-group">: {{ $course->is_active }}</div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>
