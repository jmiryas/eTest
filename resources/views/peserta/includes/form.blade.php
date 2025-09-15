<div class="row">
    <div class="col-md-12">
        <div class="mb-4">
            <label for="id" class="form-label">ID</label>
            <input type="text" name="id" class="form-control {{ $errors->has('id') ? 'is-invalid' : '' }}"
                id="id" value="{{ old('id', $peserta?->id) }}" placeholder="Masukkan id" />
            @error('id')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control {{ $errors->has('nama') ? 'is-invalid' : '' }}"
                id="nama" value="{{ old('nama', $peserta?->nama) }}" placeholder="Masukkan Nama" />
            @error('nama')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label for="kodejk" class="form-label">Kodejk</label>
            <x-input.select2 name="kodejk" id="kodejk"
                class="form-control {{ $errors->has('kodejk') ? 'is-invalid' : '' }}" placeholder="Pilih Kodejk"
                :options="[
                    'L' => 'L',
                    'P' => 'P',
                    '-' => '-',
                ]" selected="{{ old('kodejk', $peserta?->kodejk) }}" />
            @error('kodejk')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>
