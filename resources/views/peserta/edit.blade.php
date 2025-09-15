<x-layout.app title="Perbarui Peserta" activeMenu="peserta.edit" :withError="false">
    <div class="container my-5">
        <x-breadcrumb title="Perbarui Peserta" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Peserta', 'url' => route('peserta.index')],
            ['label' => 'Perbarui Peserta'],
        ]" />

        <div class="card">
            <div class="card-body">
                <x-error-list />

                <form action="{{ route('peserta.update', $peserta) }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @include('peserta.includes.form')

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2">Perbarui</button>
                        <a href="{{ route('peserta.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>