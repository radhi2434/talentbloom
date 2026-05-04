@extends('admin.layouts.app')
@section('title', 'Edit Teacher')

@section('content')

<style>
.card {
    border-radius: 10px;
}

.form-label {
    font-size: 14px;
    font-weight: 500;
}

.form-control, .form-select {
    border-radius: 8px;
    padding: 9px 12px;
}

.form-control:focus, .form-select:focus {
    box-shadow: none;
    border-color: #adb5bd;
}

.btn {
    border-radius: 8px;
}

.btn-dark {
    background: #111;
    border: none;
}
.btn-dark:hover {
    background: #000;
}
</style>


{{-- HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 d-flex align-items-center gap-2">
        <i class="bi bi-pencil-square"></i>
        Edit Teacher
    </h4>

    <a class="btn btn-light border btn-sm px-3 d-flex align-items-center gap-1"
       href="{{ route('admin.teachers.index') }}">
        <i class="bi bi-arrow-left"></i>
        Back
    </a>
</div>


<div class="card shadow-sm border-0">
<div class="card-body">

<form method="POST"
      action="{{ route('admin.teachers.update', $teacher) }}">

@csrf
@method('PUT')


{{-- NAME --}}
<div class="mb-3">
<label class="form-label">Full Name</label>

<input class="form-control"
       name="name"
       value="{{ old('name', $teacher->name) }}"
       required>

</div>


{{-- EMAIL --}}
<div class="mb-3">
<label class="form-label">Email Address</label>

<input class="form-control"
       type="email"
       name="email"
       value="{{ old('email', $teacher->email) }}"
       required>

</div>


{{-- ROW --}}
<div class="row">

    {{-- GENDER --}}
    <div class="col-md-4 mb-3">
        <label class="form-label">Gender</label>

        <select class="form-select"
                name="gender"
                required>

            <option value="">Select</option>

            <option value="male"
            {{ old('gender', $teacher->gender) == 'male' ? 'selected' : '' }}>
            Male
            </option>

            <option value="female"
            {{ old('gender', $teacher->gender) == 'female' ? 'selected' : '' }}>
            Female
            </option>

        </select>
    </div>


    {{-- PHONE --}}
    <div class="col-md-4 mb-3">
        <label class="form-label">Phone Number</label>

        <input class="form-control"
               name="phone"
               value="{{ old('phone', $teacher->phone) }}">
    </div>


    {{-- POSITION --}}
    <div class="col-md-4 mb-3">
        <label class="form-label">Position</label>

        <select class="form-select"
                name="position"
                required>

            <option value="">Select</option>

            @foreach($positions as $position)

                <option value="{{ $position->name }}"
                {{ old('position', $teacher->position) == $position->name ? 'selected' : '' }}>
                {{ $position->name }}
                </option>

            @endforeach

        </select>
    </div>

</div>


{{-- BUTTON --}}
<div class="d-flex justify-content-end gap-2 mt-3">

    <a href="{{ route('admin.teachers.index') }}"
       class="btn btn-light border px-3">
        Cancel
    </a>

    <button class="btn btn-dark px-3">
       Update Teacher
    </button>

</div>


</form>

</div>
</div>

@endsection