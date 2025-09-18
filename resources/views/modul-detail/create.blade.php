<x-layout.app title="Tambah Submodul" activeMenu="modul-detail.create" :withError="false">
    @push('style')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @endpush

    <div class="container my-5">
        <x-breadcrumb title="Tambah Submodul" :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => url('/')],
            ['label' => 'Submodul', 'url' => route('modul-detail.index')],
            ['label' => 'Tambah Submodul'],
        ]" />

        <div class="card">
            <div class="card-body">
                <x-error-list />

                <form action="{{ route('modul-detail.store') }}" method="POST" role="form"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    @include('modul-detail.includes.form')

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2">Tambah</button>
                        <a href="{{ route('modul-detail.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
            flatpickr("#waktuMulai", {
                enableTime: true,
                time_24hr: true,
                dateFormat: "Y-m-d H:i",
                // defaultDate: new Date(),
            });

            flatpickr("#waktuSelesai", {
                enableTime: true,
                time_24hr: true,
                dateFormat: "Y-m-d H:i",
                // defaultDate: new Date(),
            });
        </script>
    @endpush
</x-layout.app>
