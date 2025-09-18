<x-layout.app title="Tambah Banksoal" activeMenu="banksoal.create" :withError="false">
    <div class="container my-5">
        <x-breadcrumb title="Tambah Banksoal" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Banksoal', 'url' => route('banksoal.index')],
            ['label' => 'Tambah Banksoal'],
        ]" />

        <div class="card">
            <div class="card-body">
                <x-error-list />

                <form action="{{ route('banksoal.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    @include('banksoal.includes.form')

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2">Tambah</button>
                        <a href="{{ route('banksoal.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>