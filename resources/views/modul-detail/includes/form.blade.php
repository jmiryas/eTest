<div class="row">
    <div class="col-md-12">

        <div class="mb-4">
            <label for="modul_id" class="form-label">Modul</label>
            <x-input.select2 name="modul_id" id="modul_id" :options="$moduls" :selected="old('modul_id', $modulDetail?->modul_id)" placeholder="Pilih Modul"
                class="form-control" />

            @error('modul_id')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label for="moduldetail_section_id" class="form-label">Section</label>

            <x-input.select2 name="moduldetail_section_id" id="moduldetail_section_id" :options="$sections"
                :selected="old('moduldetail_section_id', $modulDetail?->moduldetail_section_id)" placeholder="Pilih Section" class="form-control" />

            @error('moduldetail_section_id')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control {{ $errors->has('judul') ? 'is-invalid' : '' }}"
                id="judul" value="{{ old('judul', $modulDetail?->judul) }}" placeholder="Masukkan Judul" />
            @error('judul')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="4"
                class="form-control {{ $errors->has('deskripsi') ? 'is-invalid' : '' }}" placeholder="Masukkan Deskripsi">{{ old('deskripsi', $modulDetail?->deskripsi) }}</textarea>
            @error('deskripsi')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label for="embedded_video" class="form-label">Embedded Video</label>
            <textarea name="embedded_video" id="embedded_video" rows="4"
                class="form-control {{ $errors->has('embedded_video') ? 'is-invalid' : '' }}" placeholder="Masukkan embedded video">{{ old('embedded_video', $modulDetail?->embedded_video) }}</textarea>
            @error('embedded_video')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>

        <div class="row">
            <div class="col">
                <div class="mb-4">
                    <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                    <input name="waktu_mulai" type="text" class="form-control" placeholder="YYYY-MM-DD HH:MM"
                        id="waktuMulai" />

                    @error('waktu_mulai')
                        <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="col">
                <div class="mb-4">
                    <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                    <input name="waktu_selesai" type="text" class="form-control" placeholder="YYYY-MM-DD HH:MM"
                        id="waktuSelesai" />

                    @error('waktu_mulai')
                        <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>

        {{-- <div class="mb-4">
            <label for="durasi_menit" class="form-label">Durasi Menit</label>
            <x-input.currency name="durasi_menit" id="durasi_menit"
                value="{{ old('durasi_menit', $modulDetail?->durasi_menit) }}" placeholder="Masukkan Durasi Menit"
                class="form-control text-end {{ $errors->has('durasi_menit') ? 'is-invalid' : '' }}" />
            @error('durasi_menit')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div> --}}

        {{-- <div class="mb-4">
            <label for="urutan" class="form-label">Urutan</label>
            <x-input.currency name="urutan" id="urutan" value="{{ old('urutan', $modulDetail?->urutan) }}"
                placeholder="Masukkan Urutan"
                class="form-control text-end {{ $errors->has('urutan') ? 'is-invalid' : '' }}" />
            @error('urutan')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div> --}}
    </div>
</div>
