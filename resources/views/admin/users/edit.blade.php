@extends('admin.layouts.app')
@section('title', 'Edit User')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Edit User</h3>
    <a class="btn btn-outline-secondary" href="{{ route('admin.users.index') }}">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">IC Number</label>
                <input class="form-control" name="ic_number" value="{{ old('ic_number', $user->ic_number) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <select class="form-select" name="role" required>
                    <option value="teacher" @selected(old('role', $user->role)==='teacher')>Teacher</option>
                    <option value="student" @selected(old('role', $user->role)==='student')>Student</option>
                    <option value="admin" @selected(old('role', $user->role)==='admin')>Admin</option>
                </select>
            </div>

            <button class="btn btn-warning">Update</button>
        </form>
    </div>
</div>
@endsection
