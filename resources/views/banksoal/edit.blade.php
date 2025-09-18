<x-layout.app title="Perbarui Banksoal" activeMenu="banksoal.edit" :withError="false">
    <div class="container my-5">
        <x-breadcrumb title="Perbarui Banksoal" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Banksoal', 'url' => route('banksoal.index')],
            ['label' => 'Perbarui Banksoal'],
        ]" />

        <div class="card">
            <div class="card-body">
                <x-error-list />

                <form action="{{ route('banksoal.update', $banksoal) }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @include('banksoal.includes.form')

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2">Perbarui</button>
                        <a href="{{ route('banksoal.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>