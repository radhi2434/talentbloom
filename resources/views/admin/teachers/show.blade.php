@extends('admin.layouts.app')
@section('title', 'Teacher Details')

@section('content')

<style>
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

/* Header divider */
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


{{-- HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 d-flex align-items-center gap-2">
        <i class="bi bi-person-badge"></i>
        Teacher Details
    </h4>

    <div class="d-flex gap-2">
        <a href="{{ route('admin.teachers.edit', $teacher) }}"
           class="btn btn-warning btn-sm px-3">
           <i class="bi bi-pencil"></i> Edit
        </a>

        <a href="{{ route('admin.teachers.index') }}"
           class="btn btn-light border btn-sm px-3 d-flex align-items-center gap-1">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
</div>


<div class="card shadow-sm border-0">

    {{-- PROFILE --}}
    <div class="card-body card-header-custom d-flex align-items-center gap-3">

        <div class="avatar">
            {{ strtoupper(substr($teacher->name,0,1)) }}
        </div>

        <div>
            <h5 class="mb-1">{{ $teacher->name }}</h5>
            <div class="text-muted small">{{ $teacher->email }}</div>
        </div>

    </div>


    {{-- DETAILS --}}
    <div class="card-body">

        <div class="row g-3">

            <div class="col-md-4">
                <div class="info-box">
                    <div class="info-label">Gender</div>
                    <div class="info-value">{{ ucfirst($teacher->gender) }}</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-box">
                    <div class="info-label">Phone</div>
                    <div class="info-value">{{ $teacher->phone ?? '-' }}</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-box">
                    <div class="info-label">Position</div>
                    <div class="info-value">{{ $teacher->position }}</div>
                </div>
            </div>

        </div>

    </div>

</div>

@endsection