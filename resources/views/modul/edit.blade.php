<x-layout.app title="Perbarui Modul" activeMenu="modul.edit" :withError="false">
    <div class="container my-5">
        <x-breadcrumb title="Perbarui Modul" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Modul', 'url' => route('modul.index')],
            ['label' => 'Perbarui Modul'],
        ]" />

        <div class="card">
            <div class="card-body">
                <x-error-list />

                <form action="{{ route('modul.update', $modul) }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @include('modul.includes.form')

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2">Perbarui</button>
                        <a href="{{ route('modul.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>