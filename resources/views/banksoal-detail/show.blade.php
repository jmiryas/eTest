<x-layout.app title="Detail Banksoal Detail" activeMenu="banksoal-detail.show" :withError="true">
     <div class="container my-5">
        <x-breadcrumb title="Detail Banksoal Detail" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Banksoal Detail', 'url' => route('banksoal-detail.index')],
            ['label' => 'Detail Banksoal Detail'],
        ]" />

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('banksoal-detail.index') }}" class="btn btn-sm btn-secondary">
                        <i class="bx bx-arrow-back me-1"></i>Kembali
                    </a>

                    <div>
                        @can('etest banksoal-detail view')
                        <a href="{{ route('banksoal-detail.create') }}"
                            class="btn btn-sm btn-info">
                            <i class="bx bx-plus me-1"></i>Baru
                        </a>
                        @endcan
                        @can('etest banksoal-detail edit')
                        <a href="{{ route('banksoal-detail.edit', $banksoalDetail) }}"
                            class="btn btn-sm btn-primary">
                            <i class="bx bx-pencil me-1"></i>Edit
                        </a>
                        @endcan
                        @can('etest banksoal-detail delete')
                            <form action="{{ route('banksoal-detail.destroy', $banksoalDetail) }}"
                                method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <x-input.confirm-button text="Data banksoal detail ini akan dihapus!"
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
                                    <label for="first-name-horizontal">Banksoal Id</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $banksoalDetail->banksoal_id }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Label</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $banksoalDetail->label }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Isi</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $banksoalDetail->isi }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Is Correct</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $banksoalDetail->is_correct }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Urutan</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $banksoalDetail->urutan }}</div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>
