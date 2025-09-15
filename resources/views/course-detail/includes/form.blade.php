<div class="row">
    <div class="col-md-12">

        <div class="mb-4">
            <label for="course_id" class="form-label">Course</label>

            <x-input.select2 name="course_id" id="course_id" :options="$courses" :selected="old('course_id', $courseDetail?->course_id)" placeholder="Pilih Course"
                class="form-control" />

            @error('course_id')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label for="peserta_id" class="form-label">Peserta</label>

            <x-input.select2 name="peserta_id" id="peserta_id" :options="$pesertas" :selected="old('peserta_id', $courseDetail?->peserta_id)"
                placeholder="Pilih Peserta" class="form-control" />

            @error('peserta_id')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>

        {{-- <div class="mb-4">
            <label for="enrolled_by" class="form-label">Enrolled By</label>
            <x-input.currency name="enrolled_by" id="enrolled_by"
                value="{{ old('enrolled_by', $courseDetail?->enrolled_by) }}" placeholder="Masukkan Enrolled By"
                class="form-control text-end {{ $errors->has('enrolled_by') ? 'is-invalid' : '' }}" />
            @error('enrolled_by')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div> --}}
    </div>
</div>
