@php
    $labels = ['A', 'B', 'C', 'D', 'E'];
    $oldOptions = old('options', []);
@endphp

<div class="row">
    <h5 class="card-header">Soal</h5>

    <div class="col-md-12">
        <div class="mb-4">
            <label for="group_code" class="form-label">Group Code</label>
            <input type="text" name="group_code"
                class="form-control {{ $errors->has('group_code') ? 'is-invalid' : '' }}" id="group_code"
                value="{{ old('group_code', $banksoal?->group_code) }}" placeholder="Masukkan Group Code" />
            @error('group_code')
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
                ]" selected="{{ old('tipe', $banksoal?->tipe) }}" />
            @error('tipe')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label for="isi" class="form-label">Isi</label>
            <textarea name="isi" id="isi" rows="4"
                class="form-control {{ $errors->has('isi') ? 'is-invalid' : '' }}" placeholder="Masukkan isi">{{ old('isi', $banksoal?->isi) }}</textarea>

            @error('isi')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label for="poin" class="form-label">Poin</label>
            <x-input.currency name="poin" id="poin" value="{{ old('poin', $banksoal?->poin) }}"
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

                    <x-input.select2 name="tipe_durasi" id="tipe_durasi" :options="['second' => 'Detik', 'minute' => 'Menit']" :selected="old('tipe_durasi', $banksoal?->tipe_durasi)"
                        placeholder="Pilih Durasi Soal" class="form-control" />
                </div>

                <div class="col-12 col-md-6">
                    <label for="isi" class="form-label d-block">Durasi</label>

                    <x-input.currency name="durasi_original" id="durasi_original"
                        value="{{ old('durasi_original', $banksoal?->durasi_original) }}"
                        placeholder="Masukkan durasi original"
                        class="form-control text-end {{ $errors->has('durasi_original') ? 'is-invalid' : '' }}" />
                </div>
            </div>
        </div>

        <div class="mb-4">
            <label for="urutan" class="form-label">Urutan</label>
            <x-input.currency name="urutan" id="urutan" value="{{ old('urutan', $banksoal?->urutan) }}"
                placeholder="Masukkan Urutan"
                class="form-control text-end {{ $errors->has('urutan') ? 'is-invalid' : '' }}" />
            @error('urutan')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <h5 class="card-header">Opsi Soal</h5>

    <div class="row mb-3 align-items-center">
        <div class="col-12 col-md-1">
            <label class="form-label">Label</label>
        </div>
        <div class="col-12 col-md-8">
            <label class="form-label">Isi</label>
        </div>
        <div class="col-12 col-md-3">
            <label class="form-label d-block">Jawaban Benar</label>
        </div>
    </div>

    @foreach ($labels as $i => $label)
        <div class="row mb-3 align-items-center">
            <div class="col-12 col-md-1">
                <input type="text" name="options[{{ $i }}][label]" class="form-control" readonly
                    value="{{ $label }}" readonly>
            </div>

            <div class="col-12 col-md-8">
                <input type="text" name="options[{{ $i }}][isi]"
                    class="form-control {{ $errors->has("options.$i.isi") ? 'is-invalid' : '' }}"
                    value="{{ $oldOptions[$i]['isi'] ?? '' }}" placeholder="Masukkan isi opsi" />
                @error("options.$i.isi")
                    <small class="invalid-feedback">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-12 col-md-3">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="correct_option"
                        id="correct_{{ $i }}" value="{{ $i }}"
                        {{ (string) ($oldCorrect ?? '') === (string) $i ? 'checked' : '' }}>
                    <label class="form-check-label" for="correct_{{ $i }}">Pilih</label>
                </div>

                @error('correct_option')
                    <small class="invalid-feedback d-block">{{ $message }}</small>
                @enderror
            </div>
        </div>
    @endforeach
</div>
