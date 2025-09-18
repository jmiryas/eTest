<x-layout.app title="Tambah Peserta Kursus" activeMenu="course-detail.create" :withError="false">
    <div class="container my-5">
        <x-breadcrumb title="Tambah Peserta Kursus" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Course Detail', 'url' => route('course-detail.index')],
            ['label' => 'Tambah Peserta Kursus'],
        ]" />

        <div class="card">
            <div class="card-body">
                <x-error-list />

                <form action="{{ route('course-detail.store') }}" method="POST" role="form"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    @include('course-detail.includes.form')

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2">Tambah</button>
                        <a href="{{ route('course-detail.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>
