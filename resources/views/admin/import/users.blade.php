@extends('admin.layouts.app')
@section('title','Import '.ucfirst($role).'s')

@section('content')

<style>
.card {
    border-radius: 10px;
}

.form-control {
    border-radius: 8px;
    padding: 9px 12px;
}

.form-control:focus {
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

/* Info box */
.import-box {
    background: #fff8e1;
    border: 1px solid #ffe58f;
    border-radius: 10px;
    padding: 14px;
}

/* Code styling */
.import-box code {
    color: #d63384;
}
</style>


{{-- HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 d-flex align-items-center gap-2">
        <i class="bi bi-upload"></i>
        Import {{ ucfirst($role) }}s from Excel
    </h4>

    <a class="btn btn-light border btn-sm px-3 d-flex align-items-center gap-1"
       href="{{ $role === 'student' ? route('admin.students.index') : route('admin.teachers.index') }}">
        <i class="bi bi-arrow-left"></i>
        Back
    </a>
</div>


{{-- ALERTS --}}
@if(session('success'))
    <div class="alert alert-success small">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger small">{{ session('error') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger small">
        <ul class="mb-0">
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div class="card shadow-sm border-0">
    <div class="card-body">

        {{-- PASSWORD INFO --}}
        <div class="small text-muted mb-3">
            Default password for all new accounts:
            <strong>abc123</strong>
        </div>

        <form method="POST"
              action="{{ $role === 'student' ? route('admin.students.import.handle') : route('admin.teachers.import.handle') }}"
              enctype="multipart/form-data">
            @csrf

            {{-- FILE --}}
            <div class="mb-3">
                <label class="form-label">Excel File (.xlsx / .csv)</label>
                <input class="form-control" type="file" name="file" required>
            </div>

            {{-- INFO BOX --}}
            <div class="import-box mb-3">
                <strong>Excel header MUST be:</strong><br><br>

                @if($role === 'student')
                    <code>name</code>, <code>email</code>, <code>gender</code>,
                    <code>form</code>, <code>class</code>, <code>date_joined</code>
                    <br><br>
                    Example:
                    <code>Aqilah Radhiah</code>,
                    <code>aqilah@talentbloom.com</code>,
                    <code>Female</code>,
                    <code>1</code>,
                    <code>Al-Bukhari</code>,
                    <code>2024-01-01</code>
                @else
                    <code>name</code>, <code>email</code>, <code>gender</code>,
                    <code>phone</code>, <code>position</code>
                    <br><br>
                    Example:
                    <code>Ustaz Ahmad</code>,
                    <code>ahmad@talentbloom.com</code>,
                    <code>Male</code>,
                    <code>0123456789</code>,
                    <code>Guru Mata Pelajaran</code>
                @endif
            </div>

            {{-- BUTTON --}}
            <div class="d-flex justify-content-end">
                <button class="btn btn-dark px-3">
                    <i class="bi bi-upload"></i> Upload & Import
                </button>
            </div>

        </form>

    </div>
</div>

@endsection