<x-layout.app title="Detail Soal" activeMenu="soal.show" :withError="true">
     <div class="container my-5">
        <x-breadcrumb title="Detail Soal" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Soal', 'url' => route('soal.index')],
            ['label' => 'Detail Soal'],
        ]" />

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('soal.index') }}" class="btn btn-sm btn-secondary">
                        <i class="bx bx-arrow-back me-1"></i>Kembali
                    </a>

                    <div>
                        @can('etest soal view')
                        <a href="{{ route('soal.create') }}"
                            class="btn btn-sm btn-info">
                            <i class="bx bx-plus me-1"></i>Baru
                        </a>
                        @endcan
                        @can('etest soal edit')
                        <a href="{{ route('soal.edit', $soal) }}"
                            class="btn btn-sm btn-primary">
                            <i class="bx bx-pencil me-1"></i>Edit
                        </a>
                        @endcan
                        @can('etest soal delete')
                            <form action="{{ route('soal.destroy', $soal) }}"
                                method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <x-input.confirm-button text="Data soal ini akan dihapus!"
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
                                    <label for="first-name-horizontal">Modul Detail Id</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $soal->modul_detail_id }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Tipe</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $soal->tipe }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Isi</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $soal->isi }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Poin</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $soal->poin }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Urutan</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $soal->urutan }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Updatd At</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $soal->updatd_at }}</div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>
