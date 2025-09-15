<div class="row">
    <div class="col-md-12">
        
                <div class="mb-4">
                    <label for="peserta_id" class="form-label">Peserta Id</label>
                    <input 
                        type="text" 
                        name="peserta_id" 
                        class="form-control {{ $errors->has('peserta_id') ? 'is-invalid' : '' }}" 
                        id="peserta_id" 
                        value="{{ old('peserta_id', $progressUser?->peserta_id) }}" 
                        placeholder="Masukkan Peserta Id" />
                    @error('peserta_id')<small class="invalid-feedback">{{ $message }}</small>@enderror
                </div>
                <div class="mb-4">
                    <label for="corrector_id" class="form-label">Corrector Id</label>
                    <x-input.currency name="corrector_id" id="corrector_id"
                        value="{{ old('corrector_id', $progressUser?->corrector_id) }}" 
                        placeholder="Masukkan Corrector Id"
                        class="form-control text-end {{ $errors->has('corrector_id') ? 'is-invalid' : '' }}" />
                    @error('corrector_id')<small class="invalid-feedback">{{ $message }}</small>@enderror
                </div>
                <div class="mb-4">
                    <label for="course_id" class="form-label">Course Id</label>
                    <input 
                        type="text" 
                        name="course_id" 
                        class="form-control {{ $errors->has('course_id') ? 'is-invalid' : '' }}" 
                        id="course_id" 
                        value="{{ old('course_id', $progressUser?->course_id) }}" 
                        placeholder="Masukkan Course Id" />
                    @error('course_id')<small class="invalid-feedback">{{ $message }}</small>@enderror
                </div>
                <div class="mb-4">
                    <label for="modul_id" class="form-label">Modul Id</label>
                    <input 
                        type="text" 
                        name="modul_id" 
                        class="form-control {{ $errors->has('modul_id') ? 'is-invalid' : '' }}" 
                        id="modul_id" 
                        value="{{ old('modul_id', $progressUser?->modul_id) }}" 
                        placeholder="Masukkan Modul Id" />
                    @error('modul_id')<small class="invalid-feedback">{{ $message }}</small>@enderror
                </div>
                <div class="mb-4">
                    <label for="section_id" class="form-label">Section Id</label>
                    <input 
                        type="text" 
                        name="section_id" 
                        class="form-control {{ $errors->has('section_id') ? 'is-invalid' : '' }}" 
                        id="section_id" 
                        value="{{ old('section_id', $progressUser?->section_id) }}" 
                        placeholder="Masukkan Section Id" />
                    @error('section_id')<small class="invalid-feedback">{{ $message }}</small>@enderror
                </div>
                <div class="mb-4">
                    <label for="section_type" class="form-label">Section Type</label>
                    <input 
                        type="text" 
                        name="section_type" 
                        class="form-control {{ $errors->has('section_type') ? 'is-invalid' : '' }}" 
                        id="section_type" 
                        value="{{ old('section_type', $progressUser?->section_type) }}" 
                        placeholder="Masukkan Section Type" />
                    @error('section_type')<small class="invalid-feedback">{{ $message }}</small>@enderror
                </div>
                <div class="mb-4">
                    <label for="score" class="form-label">Score</label>
                    <x-input.currency name="score" id="score"
                        value="{{ old('score', $progressUser?->score) }}" 
                        placeholder="Masukkan Score"
                        class="form-control text-end {{ $errors->has('score') ? 'is-invalid' : '' }}" />
                    @error('score')<small class="invalid-feedback">{{ $message }}</small>@enderror
                </div>
    </div>
</div>