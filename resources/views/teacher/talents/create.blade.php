@extends('teacher.layouts.app')
@section('title','Add Talent')

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

.btn-theme {
    background: #0d3b66;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 8px 18px;
}
.btn-theme:hover {
    background: #0b3154;
    color: #fff;
}

.form-control, .form-select {
    border-radius: 8px;
}
</style>

{{-- HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold d-flex align-items-center gap-2">
        <i class="bi bi-plus-circle text-primary"></i>
        Add Talent
    </h4>

    <a class="btn btn-light border btn-sm px-3 d-flex align-items-center gap-1"
            href="{{ route('teacher.talents.index') }}">
            <i class="bi bi-arrow-left"></i>
            Back
    </a>
</div>

@if ($errors->any())
    <div class="alert alert-danger shadow-sm small">
        <ul class="mb-0">
            @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-body p-4">

        <form method="POST"
              action="{{ route('teacher.talents.store') }}"
              enctype="multipart/form-data">
            @csrf

            {{-- STUDENT --}}
            <div class="mb-3">
                <div class="section-title">Student</div>
                <select class="form-select" name="student_id" required>
                    <option value="">-- Select Student --</option>
                    @foreach($students as $s)
                        <option value="{{ $s->id }}">
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
                       placeholder="Enter talent title"
                       required>
            </div>

            {{-- 🔥 CATEGORY + LEVEL + AWARD + DATE --}}
            <div class="row g-3">

                {{-- CATEGORY --}}
                <div class="col-md-3">
                    <div class="section-title">Category</div>
                    <select name="category" class="form-select">
                        <option value="Sports">Sports</option>
                        <option value="Academic">Academic</option>
                        <option value="Leadership">Leadership</option>
                        <option value="Co-curricular">Co-curricular</option>
                    </select>
                </div>

                {{-- LEVEL --}}
                <div class="col-md-3">
                    <div class="section-title">Level</div>
                    <select name="level" class="form-select">
                        <option value="School">School</option>
                        <option value="District">District</option>
                        <option value="State">State</option>
                        <option value="National">National</option>
                        <option value="International">International</option>
                    </select>
                </div>

                {{-- AWARD --}}
                <div class="col-md-3">
                    <div class="section-title">Award</div>
                    <select name="award" class="form-select">
                        <option value="">-- Select Award --</option>

                        @foreach($awards as $a)
                            <option value="{{ $a->id }}">
                                {{ ucfirst($a->name) }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- DATE --}}
                <div class="col-md-3">
                    <div class="section-title">Achieved Date</div>
                    <input type="date"
                           name="achieved_at"
                           class="form-control">
                </div>

            </div>

            {{-- DESCRIPTION --}}
            <div class="mt-3">
                <div class="section-title">Description</div>
                <textarea name="description"
                          class="form-control"
                          rows="3"
                          placeholder="Optional description..."></textarea>
            </div>

            {{-- FILE --}}
            <div class="mt-3">
                <div class="section-title">Upload Proof</div>
                <input type="file"
                       name="proof"
                       class="form-control">
            </div>

            {{-- BUTTON --}}
            <div class="mt-4 d-flex justify-content-end">
                <button class="btn-theme">
                    Save Talent
                </button>
            </div>

        </form>

    </div>
</div>

@endsection