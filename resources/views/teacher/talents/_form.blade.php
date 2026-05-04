<div class="mb-3">
    <label class="form-label">Student</label>
    <select name="student_id" class="form-select" required>
        <option value="">-- Select Student --</option>
        @foreach($students as $s)
            <option value="{{ $s->id }}" @selected(old('student_id', $talent->student_id ?? '') == $s->id)>
                {{ $s->name }}
            </option>
        @endforeach
    </select>
    @error('student_id') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Title</label>
    <input name="title" class="form-control" value="{{ old('title', $talent->title ?? '') }}" required>
    @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="row g-3 mb-3">

    {{-- CATEGORY --}}
    <div class="col-md-3">
        <label class="form-label">Category</label>
        <select name="category" class="form-select" required>
            @foreach(['Sports','Academic','Leadership','Co-curricular'] as $c)
                <option value="{{ $c }}" @selected(old('category', $talent->category ?? '') == $c)>
                    {{ $c }}
                </option>
            @endforeach
        </select>
        @error('category') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- LEVEL --}}
    <div class="col-md-3">
        <label class="form-label">Level</label>
        <select name="level" class="form-select" required>
            @foreach([
                'school' => 'School',
                'district' => 'District',
                'state' => 'State',
                'national' => 'National',
                'international' => 'International',
                'zone' => 'Zone',
                'sbp' => 'SBP'
            ] as $value => $label)
                <option value="{{ $value }}" @selected(old('level', strtolower($talent->level ?? '')) == $value)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('level') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- AWARD --}}
    <div class="col-md-3">
        <label class="form-label">Award</label>
        <select name="award" class="form-select">
            <option value="">-- Select Award --</option>
            <option value="gold" @selected(old('award', $talent->award ?? '') == 'gold')>Gold</option>
            <option value="silver" @selected(old('award', $talent->award ?? '') == 'silver')>Silver</option>
            <option value="bronze" @selected(old('award', $talent->award ?? '') == 'bronze')>Bronze</option>
        </select>
        @error('award') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- DATE --}}
    <div class="col-md-3">
        <label class="form-label">Achieved Date</label>
        <input type="date" name="achieved_at" class="form-control"
               value="{{ old('achieved_at', optional($talent->achieved_at ?? null)->format('Y-m-d')) }}">
        @error('achieved_at') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="4">{{ old('description', $talent->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Replace / Upload Proof (optional)</label>
    <input type="file" name="proof" class="form-control">
    @if(!empty($talent->proof_path))
        <div class="small text-muted mt-1">Current: {{ $talent->proof_path }}</div>
    @endif
</div>