<x-layout.app title="Detail Moduldetail Section" activeMenu="moduldetail-section.show" :withError="true">
     <div class="container my-5">
        <x-breadcrumb title="Detail Moduldetail Section" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Moduldetail Section', 'url' => route('moduldetail-section.index')],
            ['label' => 'Detail Moduldetail Section'],
        ]" />

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('moduldetail-section.index') }}" class="btn btn-sm btn-secondary">
                        <i class="bx bx-arrow-back me-1"></i>Kembali
                    </a>

                    <div>
                        @can('etest moduldetail-section view')
                        <a href="{{ route('moduldetail-section.create') }}"
                            class="btn btn-sm btn-info">
                            <i class="bx bx-plus me-1"></i>Baru
                        </a>
                        @endcan
                        @can('etest moduldetail-section edit')
                        <a href="{{ route('moduldetail-section.edit', $moduldetailSection) }}"
                            class="btn btn-sm btn-primary">
                            <i class="bx bx-pencil me-1"></i>Edit
                        </a>
                        @endcan
                        @can('etest moduldetail-section delete')
                            <form action="{{ route('moduldetail-section.destroy', $moduldetailSection) }}"
                                method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <x-input.confirm-button text="Data moduldetail section ini akan dihapus!"
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
                                    <label for="first-name-horizontal">Nama</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $moduldetailSection->nama }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Urutan</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $moduldetailSection->urutan }}</div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>
