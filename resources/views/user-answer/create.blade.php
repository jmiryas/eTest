<x-layout.app title="Tambah User Answer" activeMenu="user-answer.create" :withError="false">
    <div class="container my-5">
        <x-breadcrumb title="Tambah User Answer" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'User Answer', 'url' => route('user-answer.index')],
            ['label' => 'Tambah User Answer'],
        ]" />

        <div class="card">
            <div class="card-body">
                <x-error-list />

                <form action="{{ route('user-answer.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    @include('user-answer.includes.form')

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2">Tambah</button>
                        <a href="{{ route('user-answer.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>