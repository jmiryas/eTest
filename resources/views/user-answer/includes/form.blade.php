<div class="row">
    <div class="col-md-12">
        
                <div class="mb-4">
                    <label for="peserta_id" class="form-label">Peserta Id</label>
                    <input 
                        type="text" 
                        name="peserta_id" 
                        class="form-control {{ $errors->has('peserta_id') ? 'is-invalid' : '' }}" 
                        id="peserta_id" 
                        value="{{ old('peserta_id', $userAnswer?->peserta_id) }}" 
                        placeholder="Masukkan Peserta Id" />
                    @error('peserta_id')<small class="invalid-feedback">{{ $message }}</small>@enderror
                </div>
                <div class="mb-4">
                    <label for="modul_detail_id" class="form-label">Modul Detail Id</label>
                    <input 
                        type="text" 
                        name="modul_detail_id" 
                        class="form-control {{ $errors->has('modul_detail_id') ? 'is-invalid' : '' }}" 
                        id="modul_detail_id" 
                        value="{{ old('modul_detail_id', $userAnswer?->modul_detail_id) }}" 
                        placeholder="Masukkan Modul Detail Id" />
                    @error('modul_detail_id')<small class="invalid-feedback">{{ $message }}</small>@enderror
                </div>
                <div class="mb-4">
                    <label for="soal_id" class="form-label">Soal Id</label>
                    <input 
                        type="text" 
                        name="soal_id" 
                        class="form-control {{ $errors->has('soal_id') ? 'is-invalid' : '' }}" 
                        id="soal_id" 
                        value="{{ old('soal_id', $userAnswer?->soal_id) }}" 
                        placeholder="Masukkan Soal Id" />
                    @error('soal_id')<small class="invalid-feedback">{{ $message }}</small>@enderror
                </div>
                <div class="mb-4">
                    <label for="corrector_id" class="form-label">Corrector Id</label>
                    <x-input.currency name="corrector_id" id="corrector_id"
                        value="{{ old('corrector_id', $userAnswer?->corrector_id) }}" 
                        placeholder="Masukkan Corrector Id"
                        class="form-control text-end {{ $errors->has('corrector_id') ? 'is-invalid' : '' }}" />
                    @error('corrector_id')<small class="invalid-feedback">{{ $message }}</small>@enderror
                </div>
                <div class="mb-4">
                    <label for="soal_tipe" class="form-label">Soal Tipe</label>
                    <input 
                        type="text" 
                        name="soal_tipe" 
                        class="form-control {{ $errors->has('soal_tipe') ? 'is-invalid' : '' }}" 
                        id="soal_tipe" 
                        value="{{ old('soal_tipe', $userAnswer?->soal_tipe) }}" 
                        placeholder="Masukkan Soal Tipe" />
                    @error('soal_tipe')<small class="invalid-feedback">{{ $message }}</small>@enderror
                </div>
                <div class="mb-4">
                    <label for="answer_label" class="form-label">Answer Label</label>
                    <input 
                        type="text" 
                        name="answer_label" 
                        class="form-control {{ $errors->has('answer_label') ? 'is-invalid' : '' }}" 
                        id="answer_label" 
                        value="{{ old('answer_label', $userAnswer?->answer_label) }}" 
                        placeholder="Masukkan Answer Label" />
                    @error('answer_label')<small class="invalid-feedback">{{ $message }}</small>@enderror
                </div>
                <div class="mb-4">
                    <label for="score" class="form-label">Score</label>
                    <x-input.currency name="score" id="score"
                        value="{{ old('score', $userAnswer?->score) }}" 
                        placeholder="Masukkan Score"
                        class="form-control text-end {{ $errors->has('score') ? 'is-invalid' : '' }}" />
                    @error('score')<small class="invalid-feedback">{{ $message }}</small>@enderror
                </div>
    </div>
</div>