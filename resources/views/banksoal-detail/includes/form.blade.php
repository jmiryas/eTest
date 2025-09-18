<div class="row">
    <div class="col-md-12">
        
                <div class="mb-4">
                    <label for="banksoal_id" class="form-label">Banksoal Id</label>
                    <input 
                        type="text" 
                        name="banksoal_id" 
                        class="form-control {{ $errors->has('banksoal_id') ? 'is-invalid' : '' }}" 
                        id="banksoal_id" 
                        value="{{ old('banksoal_id', $banksoalDetail?->banksoal_id) }}" 
                        placeholder="Masukkan Banksoal Id" />
                    @error('banksoal_id')<small class="invalid-feedback">{{ $message }}</small>@enderror
                </div>
                <div class="mb-4">
                    <label for="label" class="form-label">Label</label>
                    <input 
                        type="text" 
                        name="label" 
                        class="form-control {{ $errors->has('label') ? 'is-invalid' : '' }}" 
                        id="label" 
                        value="{{ old('label', $banksoalDetail?->label) }}" 
                        placeholder="Masukkan Label" />
                    @error('label')<small class="invalid-feedback">{{ $message }}</small>@enderror
                </div>
                <div class="mb-4">
                    <label for="urutan" class="form-label">Urutan</label>
                    <x-input.currency name="urutan" id="urutan"
                        value="{{ old('urutan', $banksoalDetail?->urutan) }}" 
                        placeholder="Masukkan Urutan"
                        class="form-control text-end {{ $errors->has('urutan') ? 'is-invalid' : '' }}" />
                    @error('urutan')<small class="invalid-feedback">{{ $message }}</small>@enderror
                </div>
    </div>
</div>