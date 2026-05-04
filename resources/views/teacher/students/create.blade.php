@extends('teacher.layouts.app')

@section('content')

<div class="container" style="max-width: 800px;">

    <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-light border btn-sm px-3 d-flex align-items-center gap-1"
            href="{{ route('teacher.students.index') }}">
            <i class="bi bi-arrow-left"></i>
            Back
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">

            {{-- TITLE --}}
            <h4 class="mb-4 fw-bold d-flex align-items-center gap-2">
                <i class="bi bi-plus-circle text-primary"></i>
                Add Talent for {{ $student->name }}
            </h4>

            <form method="POST"
                  action="{{ route('teacher.students.talents.store', $student->id) }}"
                  enctype="multipart/form-data">

                @csrf

                {{-- TITLE --}}
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Enter talent title" required>
                </div>

                {{-- 🔥 CATEGORY + LEVEL + AWARD (SEBARIS) --}}
                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select" required>
                            <option value="Sports">Sports</option>
                            <option value="Academic">Academic</option>
                            <option value="Leadership">Leadership</option>
                            <option value="Co-curricular">Co-curricular</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Level</label>
                        <select name="level" class="form-select" required>
                            <option value="School">School</option>
                            <option value="District">District</option>
                            <option value="State">State</option>
                            <option value="National">National</option>
                            <option value="International">International</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Award</label>
                        <select name="award" class="form-select">
                            <option value="">-- Select Award --</option>
                            <option value="Gold">Gold</option>
                            <option value="Silver">Silver</option>
                            <option value="Bronze">Bronze</option>
                            <option value="Participation">Participation</option>
                        </select>
                    </div>

                </div>

                {{-- DATE --}}
                <div class="mb-3">
                    <label class="form-label">Achieved Date</label>
                    <input type="date"
                           name="achieved_at"
                           class="form-control">
                </div>

                {{-- DESCRIPTION --}}
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description"
                              class="form-control"
                              rows="3"
                              placeholder="Optional description..."></textarea>
                </div>

                {{-- FILE --}}
                <div class="mb-4">
                    <label class="form-label">Upload Proof (optional)</label>
                    <input type="file"
                           name="proof"
                           class="form-control">
                </div>

                {{-- SAVE BUTTON (KANAN) --}}
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-theme px-4">
                        Save Talent
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

<style>
.btn-theme {
    background: #0d3b66;
    color: #fff;
    border: none;
}

.btn-theme:hover {
    background: #0b3154;
    color: #fff;
}
</style>

@endsection