<x-layout.app title="Detail Course Detail" activeMenu="course-detail.show" :withError="true">
     <div class="container my-5">
        <x-breadcrumb title="Detail Course Detail" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Course Detail', 'url' => route('course-detail.index')],
            ['label' => 'Detail Course Detail'],
        ]" />

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('course-detail.index') }}" class="btn btn-sm btn-secondary">
                        <i class="bx bx-arrow-back me-1"></i>Kembali
                    </a>

                    <div>
                        @can('etest course-detail view')
                        <a href="{{ route('course-detail.create') }}"
                            class="btn btn-sm btn-info">
                            <i class="bx bx-plus me-1"></i>Baru
                        </a>
                        @endcan
                        @can('etest course-detail edit')
                        <a href="{{ route('course-detail.edit', $courseDetail) }}"
                            class="btn btn-sm btn-primary">
                            <i class="bx bx-pencil me-1"></i>Edit
                        </a>
                        @endcan
                        @can('etest course-detail delete')
                            <form action="{{ route('course-detail.destroy', $courseDetail) }}"
                                method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <x-input.confirm-button text="Data course detail ini akan dihapus!"
                                    positive="Ya, hapus!" icon="info"
                                    class="btn btn-danger btn-sm"
                                    data-bs-toggle="tooltip"
                                    data-bs-title="Hapus"
                                    data-bs-placement="top">
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
                                    <label for="first-name-horizontal">Course Id</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $courseDetail->course_id }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Peserta Id</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $courseDetail->peserta_id }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Enrolled By</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $courseDetail->enrolled_by }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Enrolled At</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $courseDetail->enrolled_at }}</div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>
