<x-layout.app title="Perbarui Banksoal Detail" activeMenu="banksoal-detail.edit" :withError="false">
    <div class="container my-5">
        <x-breadcrumb title="Perbarui Banksoal Detail" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Banksoal Detail', 'url' => route('banksoal-detail.index')],
            ['label' => 'Perbarui Banksoal Detail'],
        ]" />

        <div class="card">
            <div class="card-body">
                <x-error-list />

                <form action="{{ route('banksoal-detail.update', $banksoalDetail) }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @include('banksoal-detail.includes.form')

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2">Perbarui</button>
                        <a href="{{ route('banksoal-detail.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>