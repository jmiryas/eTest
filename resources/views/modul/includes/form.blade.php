<div class="row">
    <div class="col-md-12">

        <div class="mb-4">
            <label for="course_id" class="form-label">Course</label>

            <x-input.select2 name="course_id" id="course_id" :options="$courses" :selected="old('course_id', $modul?->course_id)" placeholder="Pilih Course"
                class="form-control" />

            @error('course_id')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control {{ $errors->has('judul') ? 'is-invalid' : '' }}"
                id="judul" value="{{ old('judul', $modul?->judul) }}" placeholder="Masukkan Judul" />
            @error('judul')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="4"
                class="form-control {{ $errors->has('deskripsi') ? 'is-invalid' : '' }}" placeholder="Masukkan Deskripsi">{{ old('deskripsi', $modul?->deskripsi) }}</textarea>
            @error('deskripsi')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label for="urutan" class="form-label">Urutan</label>
            <x-input.currency name="urutan" id="urutan" value="{{ old('urutan', $modul?->urutan) }}"
                placeholder="Masukkan Urutan"
                class="form-control text-end {{ $errors->has('urutan') ? 'is-invalid' : '' }}" />
            @error('urutan')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>
