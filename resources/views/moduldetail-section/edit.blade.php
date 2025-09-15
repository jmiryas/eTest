<x-layout.app title="Perbarui Moduldetail Section" activeMenu="moduldetail-section.edit" :withError="false">
    <div class="container my-5">
        <x-breadcrumb title="Perbarui Moduldetail Section" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Moduldetail Section', 'url' => route('moduldetail-section.index')],
            ['label' => 'Perbarui Moduldetail Section'],
        ]" />

        <div class="card">
            <div class="card-body">
                <x-error-list />

                <form action="{{ route('moduldetail-section.update', $moduldetailSection) }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @include('moduldetail-section.includes.form')

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2">Perbarui</button>
                        <a href="{{ route('moduldetail-section.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>