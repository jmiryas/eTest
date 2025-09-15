<div class="row">
    <div class="col-md-12">
        
                <div class="mb-4">
                    <label for="nama" class="form-label">Nama</label>
                    <input 
                        type="text" 
                        name="nama" 
                        class="form-control {{ $errors->has('nama') ? 'is-invalid' : '' }}" 
                        id="nama" 
                        value="{{ old('nama', $moduldetailSection?->nama) }}" 
                        placeholder="Masukkan Nama" />
                    @error('nama')<small class="invalid-feedback">{{ $message }}</small>@enderror
                </div>
                <div class="mb-4">
                    <label for="urutan" class="form-label">Urutan</label>
                    <x-input.currency name="urutan" id="urutan"
                        value="{{ old('urutan', $moduldetailSection?->urutan) }}" 
                        placeholder="Masukkan Urutan"
                        class="form-control text-end {{ $errors->has('urutan') ? 'is-invalid' : '' }}" />
                    @error('urutan')<small class="invalid-feedback">{{ $message }}</small>@enderror
                </div>
    </div>
</div>