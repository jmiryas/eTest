<x-layout.app title="Test" activeMenu="course.create" :withError="false">
    <div class="container my-5">
        <x-breadcrumb title="Test" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Course', 'url' => route('course.index')],
            ['label' => 'Test'],
        ]" />

        <div class="row g-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-3">
                                <h5 class="card-title mb-1">{{ $modul_detail->moduldetail_section->nama }}</h5>
                                <div class="card-subtitle mb-4">Soal : {{ $soal->urutan }} /
                                    {{ count($modul_detail->soals) }}</div>
                            </div>

                            <div class="col-12 col-md-auto ms-md-auto text-md-end">
                                <h5 class="card-title mb-1">
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-layout.app>
