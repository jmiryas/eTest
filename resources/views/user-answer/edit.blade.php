<x-layout.app title="Perbarui User Answer" activeMenu="user-answer.edit" :withError="false">
    <div class="container my-5">
        <x-breadcrumb title="Perbarui User Answer" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'User Answer', 'url' => route('user-answer.index')],
            ['label' => 'Perbarui User Answer'],
        ]" />

        <div class="card">
            <div class="card-body">
                <x-error-list />

                <form action="{{ route('user-answer.update', $userAnswer) }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @include('user-answer.includes.form')

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2">Perbarui</button>
                        <a href="{{ route('user-answer.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>