<x-layout.app title="Tambah Opsi Paket Soal" activeMenu="soal-detail.create" :withError="false">
    <div class="container my-5">
        <x-breadcrumb title="Tambah Opsi Paket Soal" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Opsi Paket Soal', 'url' => route('soal-detail.index')],
            ['label' => 'Tambah Opsi Paket Soal'],
        ]" />

        <div class="card">
            <div class="card-body">
                <x-error-list />

                <form action="{{ route('soal-detail.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    @include('soal-detail.includes.form')

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2">Tambah</button>
                        <a href="{{ route('soal-detail.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>
