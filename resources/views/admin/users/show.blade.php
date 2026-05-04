@extends('admin.layouts.app')
@section('title', 'User Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">User Details</h3>
    <div class="d-flex gap-2">
        <a class="btn btn-outline-warning" href="{{ route('admin.users.edit', $user) }}">Edit</a>
        <a class="btn btn-outline-secondary" href="{{ route('admin.users.index') }}">Back</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="text-muted">Full Name</div>
                <div class="fw-semibold">{{ $user->name }}</div>
            </div>
            <div class="col-md-6">
                <div class="text-muted">Email</div>
                <div class="fw-semibold">{{ $user->email }}</div>
            </div>
            <div class="col-md-6">
                <div class="text-muted">IC Number</div>
                <div class="fw-semibold">{{ $user->ic_number }}</div>
            </div>
            <div class="col-md-6">
                <div class="text-muted">Role</div>
                <div><span class="badge bg-secondary">{{ $user->role }}</span></div>
            </div>
        </div>
    </div>
</div>
@endsection
