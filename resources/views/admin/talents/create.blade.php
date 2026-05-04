@extends('admin.layouts.app')
@section('title','Add Talent')

@section('content')

<style>
.card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

/* section title */
.section-title {
    font-size: 13px;
    font-weight: 600;
    color: #6c757d;
    margin-bottom: 6px;
}

/* black primary button */
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

/* input spacing */
.form-control, .form-select {
    border-radius: 8px;
}
</style>


{{-- HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 d-flex align-items-center gap-2">
        <i class="bi bi-trophy"></i>
        Add Talent
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
              action="{{ route('admin.talents.store') }}"
              enctype="multipart/form-data">
            @csrf

            {{-- STUDENT --}}
            <div class="mb-3">
                <div class="section-title">Student</div>
                <select class="form-select" name="student_id" required>
                    <option value="">-- Select Student --</option>
                    @foreach($students as $s)
                        <option value="{{ $s->id }}"
                            {{ old('student_id')==$s->id ? 'selected' : '' }}>
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
                       value="{{ old('title') }}"
                       placeholder="e.g. National Math Competition"
                       required>
            </div>

            {{-- GRID --}}
            <div class="row g-3">

                {{-- CATEGORY --}}
                <div class="col-md-3">
                    <div class="section-title">Category</div>
                    <select class="form-select" name="category">
                        <option value="">-- Select Category --</option>
                        <option value="sports">Sports</option>
                        <option value="academics">Academics</option>
                        <option value="co-curricular">Co-Curricular</option>
                        <option value="leadership">Leadership</option>
                    </select>
                </div>

                {{-- LEVEL --}}
                <div class="col-md-3">
                    <div class="section-title">Level</div>
                    <select class="form-select" name="level">
                        <option value="">-- Select Level --</option>
                        <option value="school">School</option>
                        <option value="zone">Zone</option>
                        <option value="sbp">SBP</option>
                        <option value="district">District</option>
                        <option value="state">State</option>
                        <option value="national">National</option>
                        <option value="international">International</option>
                    </select>
                </div>

                {{-- AWARD --}}
                <div class="col-md-3">
                    <div class="section-title">Award</div>
                    <select name="award" class="form-select">
                        <option value="">-- Select Award --</option>
                        @foreach($awards as $a)
                            <option value="{{ strtolower($a) }}"
                                {{ old('award') == strtolower($a) ? 'selected' : '' }}>
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
                           value="{{ old('achieved_at') }}">
                </div>

            </div>

            {{-- DESCRIPTION --}}
            <div class="mt-3">
                <div class="section-title">Description</div>
                <textarea class="form-control"
                          name="description"
                          rows="3"
                          placeholder="Optional details about achievement">{{ old('description') }}</textarea>
            </div>

            {{-- PROOF --}}
            <div class="mt-3">
                <div class="section-title">Proof (optional)</div>
                <input class="form-control" type="file" name="proof">
            </div>

            {{-- BUTTON --}}
            <div class="mt-4 d-flex justify-content-end">
                <button class="btn-dark-custom">
                    Save Talent
                </button>
            </div>

        </form>

    </div>
</div>

@endsection