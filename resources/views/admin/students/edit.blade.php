@extends('admin.layouts.app')
@section('title', 'Edit Student')

@section('content')

<style>
/* Card */
.card {
    border-radius: 10px;
}

/* Label */
.form-label {
    font-size: 14px;
    font-weight: 500;
}

/* Input */
.form-control, .form-select {
    border-radius: 8px;
    padding: 9px 12px;
}

/* Focus clean */
.form-control:focus, .form-select:focus {
    box-shadow: none;
    border-color: #adb5bd;
}

/* Button */
.btn {
    border-radius: 8px;
}

</style>


<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 d-flex align-items-center gap-2">
        <i class="bi bi-pencil-square"></i>
        Edit Student
    </h4>

    <a href="{{ route('admin.students.index') }}"
        class="btn btn-light border btn-sm px-3 d-flex align-items-center gap-1">
        <i class="bi bi-arrow-left"></i>
        Back
    </a>
</div>


<div class="card shadow-sm border-0">
    <div class="card-body">

        <form method="POST" action="{{ route('admin.students.update', $student->id) }}">
            @csrf
            @method('PUT')

            {{-- NAME --}}
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text"
                       class="form-control"
                       name="name"
                       value="{{ old('name', $student->name) }}"
                       required>
            </div>

            {{-- EMAIL --}}
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email"
                       class="form-control"
                       name="email"
                       value="{{ old('email', $student->email) }}"
                       required>
            </div>

            {{-- ROW --}}
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Gender</label>
                    <select class="form-select" name="gender" required>
                        <option value="">Select</option>
                        <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Form</label>
                    <select class="form-select" name="form" required>
                        <option value="">Select</option>
                        @foreach($forms as $form)
                            <option value="{{ $form->form_number }}"
                                {{ old('form', $student->form) == $form->form_number ? 'selected' : '' }}>
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
                                {{ old('class_name', $student->class_name) == $class->name ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- DATE --}}
            <div class="mb-4">
                <label class="form-label">Date Joined</label>
                <input type="date"
                       class="form-control"
                       name="date_joined"
                       value="{{ old('date_joined', \Carbon\Carbon::parse($student->date_joined)->format('Y-m-d')) }}"
                       required>
            </div>

            {{-- BUTTON --}}
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.students.index') }}"
                    class="btn btn-light border px-4">
                    Cancel
                </a>

                <button class="btn btn-dark px-4">
                    Update Student
                </button>
            </div>

        </form>

    </div>
</div>

@endsection