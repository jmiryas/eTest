<x-layout.app title="Detail Peserta" activeMenu="peserta.show" :withError="true">
    <div class="container my-5">
        <x-breadcrumb title="Detail Peserta" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Peserta', 'url' => route('peserta.index')],
            ['label' => 'Detail Peserta'],
        ]" />

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('peserta.index') }}" class="btn btn-sm btn-secondary">
                        <i class="bx bx-arrow-back me-1"></i>Kembali
                    </a>

                    <div>
                        @can('etest peserta view')
                            <a href="{{ route('peserta.create') }}" class="btn btn-sm btn-info">
                                <i class="bx bx-plus me-1"></i>Baru
                            </a>
                        @endcan
                        @can('etest peserta edit')
                            <a href="{{ route('peserta.edit', $peserta) }}" class="btn btn-sm btn-primary">
                                <i class="bx bx-pencil me-1"></i>Edit
                            </a>
                        @endcan
                        @can('etest peserta delete')
                            <form action="{{ route('peserta.destroy', $peserta) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <x-input.confirm-button text="Data peserta ini akan dihapus!" positive="Ya, hapus!"
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
                        <label for="first-name-horizontal">Nama</label>
                    </div>
                    <div class="col-md-8 form-group">: {{ $peserta->nama }}</div>
                    <div class="col-md-4">
                        <label for="first-name-horizontal">Kodejk</label>
                    </div>
                    <div class="col-md-8 form-group">: {{ $peserta->kodejk }}</div>
                    <div class="col-md-4">
                        <label for="first-name-horizontal">Tgl Lahir</label>
                    </div>
                    <div class="col-md-8 form-group">: {{ $peserta->tgl_lahir }}</div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>
