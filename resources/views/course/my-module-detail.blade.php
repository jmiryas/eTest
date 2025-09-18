<x-layout.app title="My Section" activeMenu="course.create" :withError="false">
    <div class="container my-5">
        @push('style')
            <style>
                /* compact & clean */
                .accordion-button {
                    gap: .5rem;
                    padding-left: 1rem;
                    padding-right: 1rem;
                    font-weight: 600;
                }

                /* list link styling */
                .list-link {
                    color: inherit;
                    /* pakai warna teks container */
                    padding-left: .25rem;
                    padding-right: .25rem;
                    border-radius: .25rem;
                    transition: color .15s ease, text-decoration .15s ease;
                    outline: none;
                }

                /* underline on hover and keyboard focus for accessibility */
                .list-link:hover,
                .list-link:focus,
                .list-link:focus-visible {
                    text-decoration: underline;
                    color: var(--bs-primary);
                    /* bootstrap primary color */
                }

                /* sedikit compact spacing untuk list-group di dalam accordion */
                .accordion .list-group .list-group-item {
                    padding-top: .25rem;
                    padding-bottom: .25rem;
                }

                /* optional: highlight active/current item (jika kamu mau tandai) */
                .list-group .list-group-item.active-link {
                    background: transparent;
                    font-weight: 600;
                    color: var(--bs-primary);
                    text-decoration: underline;
                }

                .list-link.ps-2 {
                    padding-left: .5rem;
                }
            </style>
        @endpush

        <x-breadcrumb title="My Section" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Course', 'url' => route('course.index')],
            ['label' => 'My Section'],
        ]" />

        <div class="row g-3">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap mb-6 gap-2">
                            <div>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-label-info">
                                        {{ $modul_detail->moduldetail_section->nama }}
                                    </span>
                                </div>

                                <h5 class="mt-2">{{ $modul_detail->judul }}</h5>
                            </div>

                            <div>
                                @if (data_get($section_status, $modul_detail->id) === 'done')
                                    <span class="badge bg-label-success">
                                        <i class="bx bx-check-circle me-1"></i>
                                        Done
                                    </span>
                                @elseif ($modul_detail->moduldetail_section_id === 'materi')
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalSelesaiBelajar">
                                        <i class='bx bx-check-circle me-1'></i> Selesai Belajar
                                    </button>
                                @else
                                    <a href="{{ route('soal.test', ['modulDetailId' => $modul_detail->id]) }}"
                                        class="btn btn-primary d-inline-flex align-items-center">
                                        <i class="bx bx-task me-2"></i>
                                        Kerjakan
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="card academy-content shadow-none border">

                            @if ($modul_detail->moduldetail_section_id == 'materi')
                                <div class="p-2">
                                    <div class="cursor-pointer">
                                        <div class="ratio ratio-16x9">
                                            {!! $modul_detail->embedded_video !!}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="card-body pt-4">
                                <h5>Tentang modul ini</h5>
                                <p class="mb-0">
                                    {{ $modul_detail->modul->deskripsi }}
                                </p>

                                @if ($modul_detail->moduldetail_section_id != 'materi')
                                    <hr class="my-6" />

                                    <h5>Spesifikasi</h5>

                                    <div class="row g-2">
                                        <div class="col-12 col-md-4">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2 text-start" style="min-width:120px;">
                                                        <i class="bx bx-list-check me-2"></i>Jumlah Soal
                                                    </div>
                                                    <div class="px-2">:</div>
                                                    <div>{{ count($modul_detail->soals) }}</div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2 text-start" style="min-width:120px;">
                                                        <i class="bx bx-checkbox-checked me-2"></i>Pilihan Ganda
                                                    </div>
                                                    <div class="px-2">:</div>
                                                    <div>{{ $modul_detail->multiple_choice_count ?? 0 }}</div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2 text-start" style="min-width:120px;">
                                                        <i class="bx bx-pencil me-2"></i>Essai
                                                    </div>
                                                    <div class="px-2">:</div>
                                                    <div>{{ $modul_detail->essay_count ?? 0 }}</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-auto">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2 text-start" style="min-width:120px;">
                                                        <i class="bx bx-calendar me-2"></i>Tanggal
                                                    </div>
                                                    <div class="px-2">:</div>
                                                    <div>
                                                        {{ formatDatetime($modul_detail->waktu_mulai, 'day', $modul_detail->waktu_selesai) }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2 text-start" style="min-width:120px;">
                                                        <i class="bx bx-time me-2"></i>Jam
                                                    </div>
                                                    <div class="px-2">:</div>
                                                    <div>
                                                        {{ formatDatetime($modul_detail->waktu_mulai, 'time', $modul_detail->waktu_selesai) }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2 text-start" style="min-width:120px;">
                                                        <i class="bx bx-timer me-2"></i>Durasi
                                                    </div>
                                                    <div class="px-2">:</div>
                                                    <div>{{ $modul_detail->durasi_menit }} menit</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <hr class="my-6" />

                                <h5>Tentang section ini</h5>

                                <p class="mb-6">
                                    {{ $modul_detail->deskripsi }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="accordion stick-top accordion-custom-button course-content-fixed" id="courseContent">
                    @foreach ($course->moduls as $modulIdx => $modul)
                        <div class="accordion-item mb-0">
                            <h2 class="accordion-header" id="heading{{ $loop->index }}">
                                <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#chapter{{ $loop->index }}" aria-expanded="false"
                                    aria-controls="chapter{{ $loop->index }}">
                                    <div class="d-flex flex-column">
                                        <small class="text-muted fw-medium">Modul {{ $modulIdx + 1 }}</small>
                                        <span class="h6 mb-0">{{ $modul->judul }}</span>
                                    </div>
                                </button>
                            </h2>

                            <div id="chapter{{ $loop->index }}" class="accordion-collapse collapse"
                                data-bs-parent="#courseContent">
                                <div class="accordion-body py-2">
                                    <ul class="list-group list-group-flush small">
                                        @foreach ($modul->modul_details as $detailIdx => $detail)
                                            <li class="list-group-item py-1 border-0">
                                                <small
                                                    class="text-muted fw-medium">{{ $detail->moduldetail_section->nama ?? '' }}</small>

                                                @if (in_array($section_status[$detail->id], ['done', 'open']))
                                                    <a href="{{ route('course.my-module-section', ['courseId' => $course->id, 'id' => $detail->id]) }}"
                                                        class="d-block text-decoration-none list-link" role="button"
                                                        tabindex="0">
                                                        {{ $detailIdx + 1 . '. ' . $detail->judul }}
                                                    </a>
                                                @else
                                                    <a href="#"
                                                        class="d-block text-decoration-none list-link d-flex justify-content-between align-items-start"
                                                        role="button" tabindex="0">
                                                        <span>{{ $detailIdx + 1 . '. ' . $detail->judul }}</span>

                                                        <span class="d-flex align-items-start gap-1">
                                                            <i class="bx bx-lock-alt fs-5 text-muted"></i>
                                                            <span class="badge bg-label-secondary">Locked</span>
                                                        </span>
                                                    </a>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalSelesaiBelajar" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog">
                <form action="{{ route('modul-detail.konfirmasi') }}" method="POST" class="modal-content">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="backDropModalTitle">Selesai belajar materi ini?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Alert -->
                        <div class="alert alert-info d-flex align-items-center" role="alert">
                            <i class="bx bx-info-circle me-2 fs-4"></i>
                            <div>Apakah kamu benar-benar sudah mempelajari dan menguasai materi ini?</div>
                        </div>

                        <!-- Instruksi -->
                        <h6 class="fw-semibold">Instruksi</h6>
                        <p class="mb-2">Silakan ketik ulang teks di bawah ini untuk konfirmasi:</p>

                        <!-- Teks Konfirmasi -->
                        <p class="font-monospace bg-light px-3 py-2 rounded">
                            Saya sudah mempelajari dan memahami materi ini
                        </p>

                        <input type="hidden" name="modul_detail_id" value="{{ $modul_detail->id }}" />

                        <!-- Input -->
                        <div class="mb-3">
                            <label for="confirmationText" class="form-label">Ketik ulang teks di atas</label>
                            <input name="konfirmasi" type="text"
                                class="form-control {{ $errors->has('konfirmasi') ? 'is-invalid' : '' }}"
                                placeholder="Masukkan teks konfirmasi di sini" />
                            @error('konfirmasi')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                            Close
                        </button>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>
