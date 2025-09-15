<x-layout.app title="Test" activeMenu="course.create" :withError="false">
    @push('style')
        <style>
        </style>
    @endpush

    <x-breadcrumb title="Test" :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => url('/')],
        ['label' => 'Course', 'url' => route('course.index')],
        ['label' => 'Test'],
    ]" />

    <div class="row">
        <div class="col-12">
            <div class="card test-card shadow-sm">
                <div class="card-body position-relative p-4">

                    <div class="d-flex align-items-center mb-3">
                        <div class="me-auto">
                            <h5 class="card-title mb-1">{{ $modul_detail->moduldetail_section->nama }}</h5>
                            <div class="card-subtitle text-muted" id="question-count">
                                @if ($soal)
                                    Soal : {{ $soal->urutan }} / {{ count($modul_detail->soals) }}
                                @else
                                    Soal : - / {{ count($modul_detail->soals) }}
                                @endif
                            </div>
                        </div>

                        <div class="text-end ms-3">
                            <div class="small text-muted">Waktu tersisa</div>
                            <div class="fw-bold fs-4 text-danger" id="countdown">--:--</div>
                            {{-- <div class="small text-muted" id="timer-minutes-label"></div> --}}
                        </div>
                    </div>

                    <div id="question-area"
                        class="d-flex flex-column justify-content-top align-items-center text-center px-3"
                        style="min-height: calc(100vh - 350px);">
                        @if ($soal)
                            <form id="soal-auto-submit-form" method="POST"
                                action="{{ route('soal.test', ['modulDetailId' => $modul_detail->id]) }}">
                                @csrf

                                <input type="hidden" name="soal_id" value="{{ $soal->id }}">
                                {{-- <input type="hidden" name="jawaban_user" id="jawaban_user"> --}}
                                <input type="hidden" value="{{ $soal->tipe }}" name="jenis_soal" id="jenis_soal">

                                <h4 id="question-content" class="mb-4 text-start"> {{ $soal->urutan }}.
                                    {!! nl2br(e($soal->isi)) !!} </h4>

                                @if ($soal->tipe == 'multiple_choice')
                                    @foreach ($soal->soal_details as $detail)
                                        <div class="form-check mt-4 text-start">
                                            <input name="jawaban_user" class="form-check-input" type="radio"
                                                value="{{ $detail->id }}" id="radio-{{ $detail->id }}">
                                            <label class="form-check-label" for="radio-{{ $detail->id }}">
                                                {{ $detail->label }}. {{ $detail->isi }}
                                            </label>
                                        </div>
                                    @endforeach
                                @else
                                    <textarea name="jawaban_user" id="essayAnswer" rows="4" class="form-control" placeholder="Masukkan Jawaban"
                                        autofocus></textarea>
                                @endif

                                <div class="mt-4 w-100 text-end">
                                    <button type="button" id="manual-submit-btn"
                                        class="btn btn-primary d-inline-flex align-items-center">
                                        @if ($soal->urutan == count($modul_detail->soals))
                                            Submit
                                        @else
                                            Next
                                        @endif
                                        <i class="bx bx-right-arrow-alt ms-2"></i>
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            @if ($soal)
                (() => {
                    let isSubmitting = false;
                    let remaining = {{ (int) ($soal->durasi_detik ?? 0) }};
                    let timer;

                    const $form = $('#soal-auto-submit-form');
                    const $countdown = $('#countdown');
                    // const $label = $('#timer-minutes-label');
                    const $btn = $('#manual-submit-btn');

                    const formatTime = sec =>
                        `${String(Math.floor(sec / 60)).padStart(2,'0')}:${String(sec % 60).padStart(2,'0')}`;

                    const syncAnswer = () => {
                        if ($form.find('textarea[name="jawaban_user"]').length) return; // essay → langsung terkirim

                        const val = $form.find('input[name="jawaban_user"]:checked').val() || '';
                        $('#jawaban_user_temp').remove(); // hapus biar tidak numpuk
                        $('<input>', {
                                type: 'hidden',
                                id: 'jawaban_user_temp',
                                name: 'jawaban_user',
                                value: val
                            })
                            .appendTo($form);
                    };

                    const lockUI = () => {
                        $btn.prop('disabled', true).text('Mengirim...');
                        $form.find('textarea').prop('readonly', true);
                        $form.find('input[type="radio"]').prop('disabled', true);
                        isSubmitting = true;
                    };

                    const submitForm = () => {
                        if (isSubmitting) return;
                        syncAnswer();
                        lockUI();
                        clearInterval(timer);
                        $form[0].submit();
                    };

                    const startTimer = () => {
                        const update = () => {
                            $countdown.text(formatTime(remaining));
                            // $label.text(remaining > 0 ? Math.ceil(remaining / 60) + ' menit tersisa' : '');

                            if (remaining <= 0) submitForm();
                            remaining--;
                        };
                        update();
                        timer = setInterval(update, 1000);
                    };

                    $btn.on('click', submitForm);
                    $form.on('change', 'input[name="jawaban_user"]', syncAnswer);

                    startTimer();
                })();
            @endif
        </script>
    @endpush

    {{-- @push('script')
        <script>
            @if ($soal)
                (function() {
                    let isSubmitting = false;
                    let remaining = {{ (int) ($soal->durasi_detik ?? 0) }};
                    let timerInterval = null;

                    const $form = $('#soal-auto-submit-form');
                    const $countdown = $('#countdown');
                    const $timerLabel = $('#timer-minutes-label');
                    const $manualBtn = $('#manual-submit-btn');

                    // Format mm:ss
                    function formatTime(sec) {
                        const m = Math.floor(sec / 60);
                        const s = sec % 60;
                        return (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
                    }

                    // Pastikan server selalu menerima field 'jawaban_user':
                    // - Jika essay: textarea sudah bernama jawaban_user -> tidak perlu hidden.
                    // - Jika multiple choice: buat/ubah hidden input #jawaban_user_temp
                    //   berisi value radio yang dipilih (atau '' jika tidak dipilih).
                    function syncJawabanToHidden() {
                        const hasEssay = $form.find('textarea[name="jawaban_user"]').length > 0;
                        if (hasEssay) return; // essay already has the field

                        // multiple choice: ambil selected radio (jika ada)
                        const $checked = $form.find('input[name="jawaban_user"]:checked');
                        const val = $checked.length ? $checked.val() : '';

                        // buat atau update hidden input yang akan dikirim
                        if ($('#jawaban_user_temp').length === 0) {
                            $('<input>').attr({
                                type: 'hidden',
                                id: 'jawaban_user_temp',
                                name: 'jawaban_user',
                                value: val
                            }).appendTo($form);
                        } else {
                            $('#jawaban_user_temp').val(val);
                        }
                    }

                    // Kunci UI -- safe: kita sudah menyalin jawaban ke hidden sebelum mem-disable input
                    function lockUI() {
                        // buat tombol jadi disabled supaya tidak double-click
                        $manualBtn.prop('disabled', true).text('Mengirim...');
                        // buat textarea readonly (readonly masih dikirim saat submit)
                        $form.find('textarea').prop('readonly', true);
                        // disable radio supaya user tidak bisa klik lagi
                        $form.find('input[name="jawaban_user"][type="radio"]').prop('disabled', true);
                        isSubmitting = true;
                    }

                    function submitForm() {
                        if (isSubmitting) return;

                        // salin nilai jawaban (atau kosong) ke hidden agar tetap terkirim walau radio dinonaktifkan
                        syncJawabanToHidden();

                        // kunci UI & stop timer
                        lockUI();
                        if (timerInterval) clearInterval(timerInterval);

                        // submit native -> _token tetap terkirim (hidden CSRF tidak disabled)
                        $form[0].submit();
                    }

                    function startTimer() {
                        $countdown.text(formatTime(remaining));
                        if (remaining >= 60) $timerLabel.text(Math.ceil(remaining / 60) + ' menit tersisa');

                        timerInterval = setInterval(function() {
                            remaining--;
                            if (remaining < 0) remaining = 0;
                            $countdown.text(formatTime(remaining));

                            if (remaining > 0 && remaining % 60 === 0) {
                                $timerLabel.text(Math.ceil(remaining / 60) + ' menit tersisa');
                            }

                            if (remaining <= 0) {
                                clearInterval(timerInterval);
                                submitForm();
                            }
                        }, 1000);
                    }

                    $(function() {
                        startTimer();

                        // Manual submit button
                        $manualBtn.on('click', submitForm);

                        // Optional: jika ingin sinkronisasi hidden saat user mengganti pilihan (bukan submit)
                        // agar nilai hidden selalu up-to-date jika user menekan Next cepat
                        $form.on('change', 'input[name="jawaban_user"][type="radio"]', function() {
                            // update hidden segera (tidak submit)
                            syncJawabanToHidden();
                        });

                        // Jika ingin juga sinkron saat textarea berubah:
                        $form.on('input', 'textarea[name="jawaban_user"]', function() {
                            // nothing needed for essay because textarea has name jawaban_user and will be sent
                        });
                    });
                })();
            @endif
        </script>
    @endpush --}}
</x-layout.app>
