<x-layout.app title="My Course" activeMenu="course.create" :withError="false">
    <div class="container my-5">
        <x-breadcrumb title="My Course" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Course', 'url' => route('course.index')],
            ['label' => 'My Course'],
        ]" />

        <div>
            <div class="app-academy">
                <div class="card">
                    <div class="card-header d-flex flex-wrap justify-content-between gap-4">
                        <div class="card-title mb-0 me-1">
                            {{-- <h5 class="mb-0">My Courses</h5> --}}
                            <p class="mb-0">Kamu punya {{ count($myCourses) }} course</p>
                        </div>

                        {{-- <div
                            class="d-flex justify-content-md-end align-items-center column-gap-6 flex-sm-row flex-column row-gap-4">
                            <select class="form-select">
                                <option value="">All Courses</option>
                            </select>

                            <div class="form-check form-switch my-2 ms-2">
                                <input type="checkbox" class="form-check-input" id="CourseSwitch" />
                                <label class="form-check-label text-nowrap mb-0" for="CourseSwitch">Hide
                                    completed</label>
                            </div>
                        </div> --}}
                    </div>

                    <div class="card-body">
                        <div class="row gy-6 mb-6">
                            @forelse ($myCourses as $item)
                                <div class="col-sm-6 col-lg-4">
                                    <div class="card p-2 h-100 shadow-none border">
                                        <div class="rounded-2 text-center mb-4">
                                            <a href="{{ route('course.my-modules', ['id' => $item->id]) }}"><img
                                                    class="img-fluid" src="{{ asset('img/default/course.jpg') }}"
                                                    alt="Course" /></a>
                                        </div>

                                        <div class="card-body p-4 pt-2">
                                            {{-- <div class="d-flex justify-content-between align-items-center mb-4">
                                            <span class="badge bg-label-primary">Web</span>
                                            <p
                                                class="d-flex align-items-center justify-content-center fw-medium gap-1 mb-0">
                                                4.4
                                                <span class="text-warning"><i
                                                        class="icon-base ti tabler-star-filled icon-lg me-1 mb-1_5"></i></span><span
                                                    class="fw-normal">(1.23k)</span>
                                            </p>
                                        </div> --}}

                                            <a href="#" class="h5">{{ $item->judul }}</a>
                                            <p class="mt-1" style="text-align: justify;">
                                                {{ substr($item->deskripsi, 0, 133) . ' ...' }}
                                            </p>

                                            <p class="d-flex align-items-center mb-1">
                                                <i
                                                    class="icon-base ti tabler-clock me-1"></i>{{ $item->moduls->count() }}
                                                moduls
                                            </p>

                                            {{-- <div class="progress mb-4" style="height: 8px">
                                                <div class="progress-bar w-75" role="progressbar" aria-valuenow="25"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div> --}}

                                            <div
                                                class="mt-4 d-flex flex-column flex-md-row gap-4 text-nowrap flex-wrap flex-md-nowrap flex-lg-wrap flex-xxl-nowrap">
                                                <a class="w-100 btn btn-label-primary d-flex align-items-center"
                                                    href="{{ route('course.my-modules', ['id' => $item->id]) }}">
                                                    <span class="me-2">Mulai</span><i
                                                        class="icon-base ti tabler-chevron-right icon-xs lh-1 scaleX-n1-rtl"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p>Belum ada course...</p>
                            @endforelse
                        </div>

                        {{ $myCourses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
