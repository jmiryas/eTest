<x-layout.app title="Perbarui Kursus" activeMenu="course.edit" :withError="false">
    <div class="container my-5">
        <x-breadcrumb title="Perbarui Kursus" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Kursus', 'url' => route('course.index')],
            ['label' => 'Perbarui Kursus'],
        ]" />

        <div class="card">
            <div class="card-body">
                <x-error-list />

                <form action="{{ route('course.update', $course) }}" method="POST" role="form"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @include('course.includes.form')

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2">Perbarui</button>
                        <a href="{{ route('course.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>
