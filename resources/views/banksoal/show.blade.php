<x-layout.app title="Detail Banksoal" activeMenu="banksoal.show" :withError="true">
     <div class="container my-5">
        <x-breadcrumb title="Detail Banksoal" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Banksoal', 'url' => route('banksoal.index')],
            ['label' => 'Detail Banksoal'],
        ]" />

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('banksoal.index') }}" class="btn btn-sm btn-secondary">
                        <i class="bx bx-arrow-back me-1"></i>Kembali
                    </a>

                    <div>
                        @can('etest banksoal view')
                        <a href="{{ route('banksoal.create') }}"
                            class="btn btn-sm btn-info">
                            <i class="bx bx-plus me-1"></i>Baru
                        </a>
                        @endcan
                        @can('etest banksoal edit')
                        <a href="{{ route('banksoal.edit', $banksoal) }}"
                            class="btn btn-sm btn-primary">
                            <i class="bx bx-pencil me-1"></i>Edit
                        </a>
                        @endcan
                        @can('etest banksoal delete')
                            <form action="{{ route('banksoal.destroy', $banksoal) }}"
                                method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <x-input.confirm-button text="Data banksoal ini akan dihapus!"
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
                                    <label for="first-name-horizontal">Group Code</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $banksoal->group_code }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Tipe</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $banksoal->tipe }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Isi</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $banksoal->isi }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Poin</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $banksoal->poin }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Tipe Durasi</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $banksoal->tipe_durasi }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Durasi Original</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $banksoal->durasi_original }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Durasi Detik</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $banksoal->durasi_detik }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Urutan</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $banksoal->urutan }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Updatd At</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $banksoal->updatd_at }}</div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>
