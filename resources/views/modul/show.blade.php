<x-layout.app title="Detail Modul" activeMenu="modul.show" :withError="true">
     <div class="container my-5">
        <x-breadcrumb title="Detail Modul" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Modul', 'url' => route('modul.index')],
            ['label' => 'Detail Modul'],
        ]" />

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('modul.index') }}" class="btn btn-sm btn-secondary">
                        <i class="bx bx-arrow-back me-1"></i>Kembali
                    </a>

                    <div>
                        @can('etest modul view')
                        <a href="{{ route('modul.create') }}"
                            class="btn btn-sm btn-info">
                            <i class="bx bx-plus me-1"></i>Baru
                        </a>
                        @endcan
                        @can('etest modul edit')
                        <a href="{{ route('modul.edit', $modul) }}"
                            class="btn btn-sm btn-primary">
                            <i class="bx bx-pencil me-1"></i>Edit
                        </a>
                        @endcan
                        @can('etest modul delete')
                            <form action="{{ route('modul.destroy', $modul) }}"
                                method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <x-input.confirm-button text="Data modul ini akan dihapus!"
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
                                <div class="col-md-8 form-group">: {{ $modul->course_id }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Judul</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $modul->judul }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Deskripsi</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $modul->deskripsi }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Urutan</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $modul->urutan }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Is Active</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $modul->is_active }}</div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>
