<x-layout.app title="Perbarui Course Detail" activeMenu="course-detail.edit" :withError="false">
    <div class="container my-5">
        <x-breadcrumb title="Perbarui Course Detail" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Course Detail', 'url' => route('course-detail.index')],
            ['label' => 'Perbarui Course Detail'],
        ]" />

        <div class="card">
            <div class="card-body">
                <x-error-list />

                <form action="{{ route('course-detail.update', $courseDetail) }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @include('course-detail.includes.form')

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2">Perbarui</button>
                        <a href="{{ route('course-detail.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>