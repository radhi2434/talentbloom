@extends('admin.layouts.app')
@section('title','Edit Talent')

@section('content')

<style>
.card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.section-title {
    font-size: 13px;
    font-weight: 600;
    color: #6c757d;
    margin-bottom: 6px;
}

.btn-dark-custom {
    background: #000;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 8px 18px;
}
.btn-dark-custom:hover {
    background: #222;
}

.form-control, .form-select {
    border-radius: 8px;
}
</style>


{{-- HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 d-flex align-items-center gap-2">
        <i class="bi bi-pencil-square"></i>
        Edit Talent
    </h4>

    <a class="btn btn-light border d-flex align-items-center gap-1"
       href="{{ route('admin.talents.index') }}">
        <i class="bi bi-arrow-left"></i>
        Back
    </a>
</div>


{{-- ERROR --}}
@if($errors->any())
    <div class="alert alert-danger small">
        <ul class="mb-0">
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div class="card">
    <div class="card-body">

        <form method="POST"
              action="{{ route('admin.talents.update', $talent) }}"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- STUDENT --}}
            <div class="mb-3">
                <div class="section-title">Student</div>
                <select class="form-select" name="student_id" required>
                    @foreach($students as $s)
                        <option value="{{ $s->id }}"
                            {{ old('student_id', $talent->student_id)==$s->id ? 'selected' : '' }}>
                            {{ $s->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- TITLE --}}
            <div class="mb-3">
                <div class="section-title">Title</div>
                <input class="form-control"
                       name="title"
                       value="{{ old('title', $talent->title) }}"
                       required>
            </div>

            <div class="row g-3">

                {{-- CATEGORY --}}
                <div class="col-md-3">
                    <div class="section-title">Category</div>
                    <input class="form-control"
                           name="category"
                           value="{{ old('category', $talent->category) }}">
                </div>

                {{-- LEVEL --}}
                <div class="col-md-3">
                    <div class="section-title">Level</div>
                    <select class="form-select" name="level" required>
                        <option value="school" {{ old('level', strtolower($talent->level))=='school' ? 'selected' : '' }}>School</option>
                        <option value="zone" {{ old('level', strtolower($talent->level))=='zone' ? 'selected' : '' }}>Zone</option>
                        <option value="sbp" {{ old('level', strtolower($talent->level))=='sbp' ? 'selected' : '' }}>SBP</option>
                        <option value="district" {{ old('level', strtolower($talent->level))=='district' ? 'selected' : '' }}>District</option>
                        <option value="state" {{ old('level', strtolower($talent->level))=='state' ? 'selected' : '' }}>State</option>
                        <option value="national" {{ old('level', strtolower($talent->level))=='national' ? 'selected' : '' }}>National</option>
                        <option value="international" {{ old('level', strtolower($talent->level))=='international' ? 'selected' : '' }}>International</option>
                    </select>
                </div>

                {{-- AWARD --}}
                <div class="col-md-3">
                    <div class="section-title">Award</div>
                    <select name="award" class="form-select">
                        <option value="">-- Select Award --</option>

                        @foreach($awards as $a)
                            <option value="{{ strtolower($a) }}"
                                {{ old('award', $talent->award ?? '') == strtolower($a) ? 'selected' : '' }}>
                                {{ ucfirst($a) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- DATE --}}
                <div class="col-md-3">
                    <div class="section-title">Achieved Date</div>
                    <input class="form-control"
                           type="date"
                           name="achieved_at"
                           value="{{ old('achieved_at', optional($talent->achieved_at)->format('Y-m-d')) }}">
                </div>

            </div>

            {{-- DESCRIPTION --}}
            <div class="mt-3">
                <div class="section-title">Description</div>
                <textarea class="form-control"
                          name="description"
                          rows="3">{{ old('description', $talent->description) }}</textarea>
            </div>


            {{-- PROOF SECTION --}}
            @if($talent->proof_path)
                <div class="mt-3 p-3 border rounded bg-light">
                    <div class="fw-semibold mb-2">Current Proof</div>

                    <a target="_blank"
                       href="{{ asset('storage/'.$talent->proof_path) }}"
                       class="text-decoration-none">
                        <i class="bi bi-file-earmark"></i> View File
                    </a>

                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="remove_proof" value="1">
                        <label class="form-check-label text-danger">
                            Remove proof
                        </label>
                    </div>
                </div>
            @endif


            {{-- UPLOAD --}}
            <div class="mt-3">
                <div class="section-title">Replace / Upload Proof</div>
                <input class="form-control" type="file" name="proof">
            </div>


            {{-- BUTTON --}}
            <div class="mt-4 d-flex justify-content-end gap-2">

                <a href="{{ route('admin.talents.index') }}"
                   class="btn btn-light border">
                    Cancel
                </a>

                <button class="btn-dark-custom">
                    Update Talent
                </button>

            </div>

        </form>

    </div>
</div>

@endsection