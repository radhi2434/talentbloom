@extends('admin.layouts.app')
@section('title', 'Add Student')

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
        <i class="bi bi-person-plus"></i>
        Add New Student
    </h4>

    <a class="btn btn-light border btn-sm px-3 d-flex align-items-center gap-1"
       href="{{ route('admin.students.index') }}">
        <i class="bi bi-arrow-left"></i>
        Back
    </a>
</div>


<div class="card shadow-sm border-0">
    <div class="card-body">

        <form method="POST" action="{{ route('admin.students.store') }}">
            @csrf

            {{-- NAME --}}
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input class="form-control" name="name" value="{{ old('name') }}" required>
            </div>

            {{-- EMAIL --}}
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
            </div>

            {{-- ROW --}}
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Gender</label>
                    <select class="form-select" name="gender" required>
                        <option value="">Select</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Form</label>
                    <select class="form-select" name="form" required>
                        <option value="">Select</option>
                        @foreach($forms as $form)
                            <option value="{{ $form->form_number }}"
                                {{ old('form') == $form->form_number ? 'selected' : '' }}>
                                Form {{ $form->form_number }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Class</label>
                    <select class="form-select" name="class_name" required>
                        <option value="">Select</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->name }}"
                                {{ old('class_name') == $class->name ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- DATE --}}
            <div class="mb-3">
                <label class="form-label">Date Joined</label>
                <input type="date" class="form-control"
                       name="date_joined"
                       value="{{ old('date_joined') }}"
                       required>
            </div>

            {{-- ALERT --}}
            <div class="alert small" style="background:#fff8e1; border:1px solid #ffe58f;">
                Default password: <strong>abc123</strong>
            </div>

            {{-- BUTTON --}}
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.students.index') }}"
                   class="btn btn-light border px-3">
                    Cancel
                </a>

                <button class="btn btn-dark px-3">
                    Create Student
                </button>
            </div>

        </form>

    </div>
</div>

@endsection