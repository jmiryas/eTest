<x-layout.app title="Tambah Peserta" activeMenu="peserta.create" :withError="false">
    <div class="container my-5">
        <x-breadcrumb title="Tambah Peserta" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Peserta', 'url' => route('peserta.index')],
            ['label' => 'Tambah Peserta'],
        ]" />

        <div class="card">
            <div class="card-body">
                <x-error-list />

                <form action="{{ route('peserta.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    @include('peserta.includes.form')

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2">Tambah</button>
                        <a href="{{ route('peserta.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>