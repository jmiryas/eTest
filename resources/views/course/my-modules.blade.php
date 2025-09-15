<x-layout.app title="My Modules" activeMenu="course.create" :withError="false">
    <div class="container my-5">
        @push('style')
            <style>
                .section-item:hover {
                    cursor: pointer;
                    background-color: #f1f2f6;
                }

                .section-link {
                    all: unset;
                }
            </style>
        @endpush

        <x-breadcrumb title="My Modules" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Course', 'url' => route('course.index')],
            ['label' => 'My Modules'],
        ]" />

        <div class="row g-3">
            @forelse ($moduls as $index => $item)
                @php
                    $modulDetailId = 'modulDetail-' . $index;
                @endphp

                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center mb-2">
                                <div class="d-flex justify-content-center align-items-center bg-info bg-opacity-10 text-info rounded me-3"
                                    style="width: 40px; height: 40px;">
                                    <i class="bx bx-folder fs-5"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Modul {{ $index + 1 }}</small>
                                    <h6 class="mb-0 fw-semibold">{{ $item->judul }}</h6>
                                </div>
                            </div>

                            <!-- Deskripsi -->
                            <p class="text-muted small mb-2" style="text-align: justify;">
                                {{ $item->deskripsi }}
                            </p>

                            <div class="text-end">
                                <a data-bs-toggle="collapse" href="#{{ $modulDetailId }}" role="button"
                                    aria-expanded="false" aria-controls="{{ $modulDetailId }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="bx bx-show me-1"></i> View Modul
                                </a>
                            </div>

                            <div class="collapse" id="{{ $modulDetailId }}">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="demo-inline-spacing">
                                            <div class="list-group">
                                                @foreach ($item->modul_details as $section)
                                                    @php
                                                        $icon = 'bx bx-edit-alt icon-md me-3';

                                                        if ($section->moduldetail_section_id == 'pretest') {
                                                            $icon = 'bx bx-edit-alt icon-md me-3';
                                                        } elseif ($section->moduldetail_section_id == 'materi') {
                                                            $icon = 'bx bx-book icon-md me-3';
                                                        } elseif ($section->moduldetail_section_id == 'posttest') {
                                                            $icon = 'bx bx-check-circle icon-md me-3';
                                                        }
                                                    @endphp

                                                    @if (in_array($section_status[$section->id], ['done', 'open']))
                                                        <a href="{{ route('course.my-module-section', ['courseId' => $item->course_id, 'id' => $section->id]) }}"
                                                            class="list-group-item list-group-item-action waves-effect d-flex items-center justify-content-between align-items-center">
                                                            <div
                                                                class="d-flex items-center justify-content-between align-items-center">
                                                                <i class="{{ $icon }}"></i>
                                                                <span class="badge bg-label-info me-2">
                                                                    {{ $section->moduldetail_section->nama }}
                                                                </span>
                                                                {{ $section->judul }}
                                                            </div>

                                                            <i class="bx bx-chevron-right fs-4"></i>
                                                        </a>
                                                    @else
                                                        <a href="#"
                                                            class="list-group-item list-group-item-action waves-effect d-flex items-center justify-content-between align-items-center">
                                                            <div
                                                                class="d-flex items-center justify-content-between align-items-center">
                                                                <i class="{{ $icon }}"></i>
                                                                <span class="badge bg-label-info me-2">
                                                                    {{ $section->moduldetail_section->nama }}
                                                                </span>
                                                                {{ $section->judul }}
                                                            </div>

                                                            <div class="d-flex align-items-center gap-2">
                                                                <i class="bx bx-lock-alt fs-4 text-muted"></i>
                                                                <span class="badge bg-label-secondary">Locked</span>
                                                            </div>
                                                        </a>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>Tidak ada data</p>
            @endforelse
        </div>
    </div>
</x-layout.app>
