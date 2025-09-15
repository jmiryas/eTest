<div class="row">
    <div class="col-md-12">

        <div class="mb-4">
            <label for="soal_id" class="form-label">Soal</label>

            <x-input.select2 name="soal_id" id="soal_id" :options="$soals" :selected="old('soal_id', $soalDetail?->soal_id)" placeholder="Pilih Soal"
                class="form-control" />

            @error('soal_id')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label for="label" class="form-label">Label</label>
            <input type="text" name="label" class="form-control {{ $errors->has('label') ? 'is-invalid' : '' }}"
                id="label" value="{{ old('label', $soalDetail?->label) }}" placeholder="Masukkan Label" />
            @error('label')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label for="isi" class="form-label">Teks</label>
            <textarea name="isi" id="isi" rows="4"
                class="form-control {{ $errors->has('isi') ? 'is-invalid' : '' }}" placeholder="Masukkan isi">{{ old('isi', $soalDetail?->isi) }}</textarea>
            @error('isi')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label for="isi" class="form-label d-block">Status Jawaban</label>

            <div class="form-check form-check-inline mt-4">
                <input class="form-check-input" type="radio" name="is_correct" id="inlineRadio1" value="0"
                    {{ old('is_correct', $soalDetail?->is_correct) == 0 ? 'checked' : '' }} />
                <label class="form-check-label" for="inlineRadio1">Salah</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is_correct" id="inlineRadio2" value="1"
                    {{ old('is_correct', $soalDetail?->is_correct) == 1 ? 'checked' : '' }} />
                <label class="form-check-label" for="inlineRadio2">Benar</label>
            </div>


            @error('is_correct')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label for="urutan" class="form-label">Urutan</label>
            <x-input.currency name="urutan" id="urutan" value="{{ old('urutan', $soalDetail?->urutan) }}"
                placeholder="Masukkan Urutan"
                class="form-control text-end {{ $errors->has('urutan') ? 'is-invalid' : '' }}" />
            @error('urutan')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>
