<x-layout.app title="Paket Soal" activeMenu="soal" :withError="true">
    <div class="my-5 container-fluid">
        <x-breadcrumb title="Paket Soal" :breadcrumbs="[['label' => 'Dashboard', 'url' => url('/')], ['label' => 'Paket Soal']]" />

        <div class="card">
            <div class="card-header">
                <div class="row g-3 justify-content-between align-items-center">
                    @can('etest soal create')
                        <div class="col-12 col-md-auto">
                            <a href="{{ route('soal.create') }}" class="btn btn-primary w-100 w-md-fit">
                                <span class="bx bx-plus me-1"></span>Tambah Data
                            </a>
                        </div>
                    @endcan

                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari soal..."
                                value="{{ old('search', request('search')) }}" hx-get="{{ route('soal.index') }}"
                                hx-trigger="keyup[keyCode==13], keyup changed delay:500ms" hx-target="#soal-table"
                                hx-push-url="true" hx-indicator="#search-loading"
                                hx-include="#filter-checkboxes input:checked">

                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">Filter</button>

                            <ul class="dropdown-menu dropdown-menu-end" id="filter-checkboxes">
                                <li>
                                    <div class="mx-2 form-check">
                                        <x-input.checkbox class="form-check-input" id="checkbox-all" :checked="count($columns) == count($selectedColumns)"
                                            :parent="true" />
                                        <label class="form-check-label" for="checkbox-all">-- All --</label>
                                    </div>
                                </li>
                                @foreach ($columns as $column)
                                    <li>
                                        <div class="mx-2 form-check">
                                            <x-input.checkbox class="form-check-input" id="checkbox-{{ $column }}"
                                                name="col[]" value="{{ $column }}" :checked="in_array($column, $selectedColumns)"
                                                parentId="checkbox-all" />
                                            <label class="form-check-label" for="checkbox-{{ $column }}">
                                                {{ str()->title(str()->replace('_', ' ', $column)) }}
                                            </label>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-container">
                <div id="search-loading" class="htmx-indicator">
                    <div class="flex-row px-4 py-3 mx-auto mt-5 text-center card d-flex justify-content-center justify-items-center"
                        style="width: 200px;">
                        <div class="px-2 d-flex align-items-center">
                            <div class="loading-spinner"></div>
                        </div>
                        <span>Sedang mencari soal...</span>
                    </div>
                </div>

                <div id="soal-table">
                    @include('soal.includes.index-table', compact('soal'))
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
