<x-layout.app title="Tambah Progress User" activeMenu="progress-user.create" :withError="false">
    <div class="container my-5">
        <x-breadcrumb title="Tambah Progress User" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Progress User', 'url' => route('progress-user.index')],
            ['label' => 'Tambah Progress User'],
        ]" />

        <div class="card">
            <div class="card-body">
                <x-error-list />

                <form action="{{ route('progress-user.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    @include('progress-user.includes.form')

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2">Tambah</button>
                        <a href="{{ route('progress-user.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>