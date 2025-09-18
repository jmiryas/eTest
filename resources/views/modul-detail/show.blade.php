<x-layout.app title="Detail Submodul" activeMenu="modul-detail.show" :withError="true">
    <div class="container my-5">
        <x-breadcrumb title="Detail Submodul" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Submodul', 'url' => route('modul-detail.index')],
            ['label' => 'Detail Submodul'],
        ]" />

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('modul-detail.index') }}" class="btn btn-sm btn-secondary">
                        <i class="bx bx-arrow-back me-1"></i>Kembali
                    </a>

                    <div>
                        @can('etest modul-detail view')
                            <a href="{{ route('modul-detail.create') }}" class="btn btn-sm btn-info">
                                <i class="bx bx-plus me-1"></i>Baru
                            </a>
                        @endcan
                        @can('etest modul-detail edit')
                            <a href="{{ route('modul-detail.edit', $modulDetail) }}" class="btn btn-sm btn-primary">
                                <i class="bx bx-pencil me-1"></i>Edit
                            </a>
                        @endcan
                        @can('etest modul-detail delete')
                            <form action="{{ route('modul-detail.destroy', $modulDetail) }}" method="POST"
                                class="d-inline">
                                @csrf @method('DELETE')
                                <x-input.confirm-button text="Data modul detail ini akan dihapus!" positive="Ya, hapus!"
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
                        <label for="first-name-horizontal">Modul Id</label>
                    </div>
                    <div class="col-md-8 form-group">: {{ $modulDetail->modul_id }}</div>
                    <div class="col-md-4">
                        <label for="first-name-horizontal">Moduldetail Section Id</label>
                    </div>
                    <div class="col-md-8 form-group">: {{ $modulDetail->moduldetail_section_id }}</div>
                    <div class="col-md-4">
                        <label for="first-name-horizontal">Judul</label>
                    </div>
                    <div class="col-md-8 form-group">: {{ $modulDetail->judul }}</div>
                    <div class="col-md-4">
                        <label for="first-name-horizontal">Deskripsi</label>
                    </div>
                    <div class="col-md-8 form-group">: {{ $modulDetail->deskripsi }}</div>
                    <div class="col-md-4">
                        <label for="first-name-horizontal">Waktu Mulai</label>
                    </div>
                    <div class="col-md-8 form-group">: {{ $modulDetail->waktu_mulai }}</div>
                    <div class="col-md-4">
                        <label for="first-name-horizontal">Waktu Selesai</label>
                    </div>
                    <div class="col-md-8 form-group">: {{ $modulDetail->waktu_selesai }}</div>
                    <div class="col-md-4">
                        <label for="first-name-horizontal">Durasi Menit</label>
                    </div>
                    <div class="col-md-8 form-group">: {{ $modulDetail->durasi_menit }}</div>
                    <div class="col-md-4">
                        <label for="first-name-horizontal">Urutan</label>
                    </div>
                    <div class="col-md-8 form-group">: {{ $modulDetail->urutan }}</div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>
