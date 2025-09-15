<x-layout.app title="Perbarui Soal" activeMenu="soal.edit" :withError="false">
    <div class="container my-5">
        <x-breadcrumb title="Perbarui Soal" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Soal', 'url' => route('soal.index')],
            ['label' => 'Perbarui Soal'],
        ]" />

        <div class="card">
            <div class="card-body">
                <x-error-list />

                <form action="{{ route('soal.update', $soal) }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @include('soal.includes.form')

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2">Perbarui</button>
                        <a href="{{ route('soal.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>