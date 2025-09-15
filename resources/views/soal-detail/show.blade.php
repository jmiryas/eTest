<x-layout.app title="Detail Soal Detail" activeMenu="soal-detail.show" :withError="true">
     <div class="container my-5">
        <x-breadcrumb title="Detail Soal Detail" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Soal Detail', 'url' => route('soal-detail.index')],
            ['label' => 'Detail Soal Detail'],
        ]" />

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('soal-detail.index') }}" class="btn btn-sm btn-secondary">
                        <i class="bx bx-arrow-back me-1"></i>Kembali
                    </a>

                    <div>
                        @can('etest soal-detail view')
                        <a href="{{ route('soal-detail.create') }}"
                            class="btn btn-sm btn-info">
                            <i class="bx bx-plus me-1"></i>Baru
                        </a>
                        @endcan
                        @can('etest soal-detail edit')
                        <a href="{{ route('soal-detail.edit', $soalDetail) }}"
                            class="btn btn-sm btn-primary">
                            <i class="bx bx-pencil me-1"></i>Edit
                        </a>
                        @endcan
                        @can('etest soal-detail delete')
                            <form action="{{ route('soal-detail.destroy', $soalDetail) }}"
                                method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <x-input.confirm-button text="Data soal detail ini akan dihapus!"
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
                                    <label for="first-name-horizontal">Soal Id</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $soalDetail->soal_id }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Label</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $soalDetail->label }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Konten</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $soalDetail->konten }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Is Correct</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $soalDetail->is_correct }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Urutan</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $soalDetail->urutan }}</div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>
