<x-layout.app title="Perbarui Submodul" activeMenu="modul-detail.edit" :withError="false">
    <div class="container my-5">
        <x-breadcrumb title="Perbarui Submodul" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Submodul', 'url' => route('modul-detail.index')],
            ['label' => 'Perbarui Submodul'],
        ]" />

        <div class="card">
            <div class="card-body">
                <x-error-list />

                <form action="{{ route('modul-detail.update', $modulDetail) }}" method="POST" role="form"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @include('modul-detail.includes.form')

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2">Perbarui</button>
                        <a href="{{ route('modul-detail.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>
