<x-layout.app title="Perbarui Progress User" activeMenu="progress-user.edit" :withError="false">
    <div class="container my-5">
        <x-breadcrumb title="Perbarui Progress User" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Progress User', 'url' => route('progress-user.index')],
            ['label' => 'Perbarui Progress User'],
        ]" />

        <div class="card">
            <div class="card-body">
                <x-error-list />

                <form action="{{ route('progress-user.update', $progressUser) }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @include('progress-user.includes.form')

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2">Perbarui</button>
                        <a href="{{ route('progress-user.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>