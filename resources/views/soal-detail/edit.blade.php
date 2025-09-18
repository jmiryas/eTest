<x-layout.app title="Perbarui Opsi Paket Soal" activeMenu="soal-detail.edit" :withError="false">
    <div class="container my-5">
        <x-breadcrumb title="Perbarui Opsi Paket Soal" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Opsi Paket Soal', 'url' => route('soal-detail.index')],
            ['label' => 'Perbarui Opsi Paket Soal'],
        ]" />

        <div class="card">
            <div class="card-body">
                <x-error-list />

                <form action="{{ route('soal-detail.update', $soalDetail) }}" method="POST" role="form"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @include('soal-detail.includes.form')

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2">Perbarui</button>
                        <a href="{{ route('soal-detail.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>
