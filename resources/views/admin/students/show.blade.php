@extends('admin.layouts.app')
@section('title', 'Student Details')

@section('content')

<style>
/* Card clean */
.card {
    border-radius: 12px;
    overflow: hidden;
}

/* Avatar */
.avatar {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: #2c2c2c;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 18px;
}

/* Header line */
.card-header-custom {
    border-bottom: 1px solid #f1f1f1;
}

/* Info box */
.info-box {
    background: #fafafa;
    border-radius: 10px;
    padding: 14px;
    height: 100%;
}

/* Label */
.info-label {
    font-size: 12px;
    color: #6c757d;
}

/* Value */
.info-value {
    font-weight: 600;
    margin-top: 4px;
}

/* Buttons */
.btn {
    border-radius: 8px;
}
</style>


<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-semibold mb-0 d-flex align-items-center gap-2">
        <i class="bi bi-person-lines-fill"></i>
        Student Details
    </h4>

    <div class="d-flex gap-2">
        <a href="{{ route('admin.students.edit', $student) }}"
           class="btn btn-warning btn-sm px-3">
           <i class="bi bi-pencil"></i> Edit
        </a>

        <a href="{{ route('admin.students.index') }}"
           class="btn btn-light border btn-sm px-3">
           Back
        </a>
    </div>
</div>


<div class="card shadow-sm border-0">

    {{-- HEADER --}}
    <div class="card-body card-header-custom d-flex align-items-center gap-3">

        <div class="avatar">
            {{ strtoupper(substr($student->name,0,1)) }}
        </div>

        <div>
            <h5 class="mb-1">{{ $student->name }}</h5>
            <div class="text-muted small">{{ $student->email }}</div>
        </div>

    </div>


    {{-- BODY --}}
    <div class="card-body">

        <div class="row g-3">

            <div class="col-md-4">
                <div class="info-box">
                    <div class="info-label">Gender</div>
                    <div class="info-value">{{ ucfirst($student->gender) }}</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-box">
                    <div class="info-label">Form</div>
                    <div class="info-value">Form {{ $student->form }}</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-box">
                    <div class="info-label">Class</div>
                    <div class="info-value">{{ $student->class_name }}</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-box">
                    <div class="info-label">Date Joined</div>
                    <div class="info-value">
                        {{ \Carbon\Carbon::parse($student->date_joined)->format('d M Y') }}
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

@endsection