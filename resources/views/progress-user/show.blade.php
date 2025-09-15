<x-layout.app title="Detail Progress User" activeMenu="progress-user.show" :withError="true">
     <div class="container my-5">
        <x-breadcrumb title="Detail Progress User" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Progress User', 'url' => route('progress-user.index')],
            ['label' => 'Detail Progress User'],
        ]" />

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('progress-user.index') }}" class="btn btn-sm btn-secondary">
                        <i class="bx bx-arrow-back me-1"></i>Kembali
                    </a>

                    <div>
                        @can('etest progress-user view')
                        <a href="{{ route('progress-user.create') }}"
                            class="btn btn-sm btn-info">
                            <i class="bx bx-plus me-1"></i>Baru
                        </a>
                        @endcan
                        @can('etest progress-user edit')
                        <a href="{{ route('progress-user.edit', $progressUser) }}"
                            class="btn btn-sm btn-primary">
                            <i class="bx bx-pencil me-1"></i>Edit
                        </a>
                        @endcan
                        @can('etest progress-user delete')
                            <form action="{{ route('progress-user.destroy', $progressUser) }}"
                                method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <x-input.confirm-button text="Data progress user ini akan dihapus!"
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
                                <div class="col-md-8 form-group">: {{ $progressUser->peserta_id }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Corrector Id</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $progressUser->corrector_id }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Course Id</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $progressUser->course_id }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Modul Id</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $progressUser->modul_id }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Section Id</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $progressUser->section_id }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Section Type</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $progressUser->section_type }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Waktu Submit</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $progressUser->waktu_submit }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Waktu Koreksi</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $progressUser->waktu_koreksi }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Is Corrected</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $progressUser->is_corrected }}</div>
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Score</label>
                                </div>
                                <div class="col-md-8 form-group">: {{ $progressUser->score }}</div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>
