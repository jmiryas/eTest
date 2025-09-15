<div class="row">
    <div class="col-md-12">
        <div class="mb-4">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control {{ $errors->has('judul') ? 'is-invalid' : '' }}"
                id="judul" value="{{ old('judul', $course?->judul) }}" placeholder="Masukkan Judul" />
            @error('judul')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="4"
                class="form-control {{ $errors->has('deskripsi') ? 'is-invalid' : '' }}" placeholder="Masukkan Deskripsi">{{ old('deskripsi', $course?->deskripsi) }}</textarea>
            @error('deskripsi')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>
