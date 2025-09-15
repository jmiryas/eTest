<div class="row">
    <div class="col-md-12">

        <div class="mb-4">
            <label for="modul_detail_id" class="form-label">Modul Section</label>

            <x-input.select2 name="modul_detail_id" id="modul_detail_id" :options="$modul_sections" :selected="old('modul_detail_id', $soal?->modul_detail_id)"
                placeholder="Pilih Section" class="form-control" />

            @error('modul_detail_id')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label for="tipe" class="form-label">Tipe</label>
            <x-input.select2 name="tipe" id="tipe"
                class="form-control {{ $errors->has('tipe') ? 'is-invalid' : '' }}" placeholder="Pilih Tipe"
                :options="[
                    'multiple_choice' => 'Pilihan Ganda',
                    'essay' => 'Esai',
                    '' => '',
                ]" selected="{{ old('tipe', $soal?->tipe) }}" />
            @error('tipe')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label for="isi" class="form-label">Isi</label>
            <textarea name="isi" id="isi" rows="4"
                class="form-control {{ $errors->has('isi') ? 'is-invalid' : '' }}" placeholder="Masukkan isi">{{ old('isi', $soal?->isi) }}</textarea>

            @error('isi')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label for="poin" class="form-label">Poin</label>
            <x-input.currency name="poin" id="poin" value="{{ old('poin', $soal?->poin) }}"
                placeholder="Masukkan Poin"
                class="form-control text-end {{ $errors->has('poin') ? 'is-invalid' : '' }}" />
            @error('poin')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <div class="row">
                <div class="col-12 col-md-6">
                    <label for="isi" class="form-label d-block">Tipe Durasi</label>

                    <x-input.select2 name="tipe_durasi" id="tipe_durasi" :options="['second' => 'Detik', 'minute' => 'Menit']" :selected="old('tipe_durasi', $soal?->tipe_durasi)"
                        placeholder="Pilih Soal" class="form-control" />
                </div>

                <div class="col-12 col-md-6">
                    <label for="isi" class="form-label d-block">Durasi</label>

                    <x-input.currency name="durasi_original" id="durasi_original"
                        value="{{ old('durasi_original', $soal?->durasi_original) }}"
                        placeholder="Masukkan durasi original"
                        class="form-control text-end {{ $errors->has('durasi_original') ? 'is-invalid' : '' }}" />
                </div>
            </div>
        </div>

        <div class="mb-4">
            <label for="urutan" class="form-label">Urutan</label>
            <x-input.currency name="urutan" id="urutan" value="{{ old('urutan', $soal?->urutan) }}"
                placeholder="Masukkan Urutan"
                class="form-control text-end {{ $errors->has('urutan') ? 'is-invalid' : '' }}" />
            @error('urutan')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>
