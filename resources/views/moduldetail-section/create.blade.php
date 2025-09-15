<x-layout.app title="Tambah Moduldetail Section" activeMenu="moduldetail-section.create" :withError="false">
    <div class="container my-5">
        <x-breadcrumb title="Tambah Moduldetail Section" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Moduldetail Section', 'url' => route('moduldetail-section.index')],
            ['label' => 'Tambah Moduldetail Section'],
        ]" />

        <div class="card">
            <div class="card-body">
                <x-error-list />

                <form action="{{ route('moduldetail-section.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    @include('moduldetail-section.includes.form')

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2">Tambah</button>
                        <a href="{{ route('moduldetail-section.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>