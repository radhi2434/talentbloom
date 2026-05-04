@extends('admin.layouts.app')
@section('title', 'Add User')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Add User</h3>
    <a class="btn btn-outline-secondary" href="{{ route('admin.users.index') }}">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input class="form-control" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">IC Number</label>
                <input class="form-control" name="ic_number" value="{{ old('ic_number') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <select class="form-select" name="role" required>
                    <option value="">-- Select Role --</option>
                    <option value="teacher" @selected(old('role')==='teacher')>Teacher</option>
                    <option value="student" @selected(old('role')==='student')>Student</option>
                </select>
            </div>

            <div class="alert alert-info">
                Default password for new user: <strong>abc123</strong>
            </div>

            <button class="btn btn-primary">Create</button>
        </form>
    </div>
</div>
@endsection
