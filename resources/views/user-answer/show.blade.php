<x-layout.app title="Detail User Answer" activeMenu="user-answer.show" :withError="true">
     <div class="container my-5">
        <x-breadcrumb title="Detail User Answer" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'User Answer', 'url' => route('user-answer.index')],
            ['label' => 'Detail User Answer'],
        ]" />

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('user-answer.index') }}" class="btn btn-sm btn-secondary">
                        <i class="bx bx-arrow-back me-1"></i>Kembali
                    </a>

                    <div>
                        @can('etest user-answer view')
                        <a href="{{ route('user-answer.create') }}"
                            class="btn btn-sm btn-info">
                            <i class="bx bx-plus me-1"></i>Baru
                        </a>
                        @endcan
                        @can('etest user-answer edit')
                        <a href="{{ route('user-answer.edit', $userAnswer) }}"
                            class="btn btn-sm btn-primary">
                            <i class="bx bx-pencil me-1"></i>Edit
                        </a>
                        @endcan
                        @can('etest user-answer delete')
                            <form action="{{ route('user-answer.destroy', $userAnswer) }}"
                                method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <x-input.confirm-button text="Data user answer ini akan dihapus!"
                                    positive="Ya, hapus!" icon="info"
                                    class="btn btn-danger btn-sm"
                                    data-bs-toggle="tooltip"
                                    data-bs-title="Hapus"
                                    data-bs-placement="top">
                                    <i class="bx bx-trash me-1"></i>Hapus
                                </x-input.confirm-button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="row g-3">
                    
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Peserta Id</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $userAnswer->peserta_id }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Modul Detail Id</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $userAnswer->modul_detail_id }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Soal Id</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $userAnswer->soal_id }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Corrector Id</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $userAnswer->corrector_id }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Soal Tipe</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $userAnswer->soal_tipe }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Soal Text</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $userAnswer->soal_text }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Answer Label</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $userAnswer->answer_label }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Answer Text</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $userAnswer->answer_text }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Is Correct</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $userAnswer->is_correct }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Score</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $userAnswer->score }}</div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>
