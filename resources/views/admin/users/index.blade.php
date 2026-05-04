@extends('admin.layouts.app')
@section('title', 'Users')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Manage Users</h3>
    <a class="btn btn-primary" href="{{ route('admin.users.create') }}">+ Add User</a>
</div>

<form class="row g-2 mb-3" method="GET" action="{{ route('admin.users.index') }}">
    <div class="col-md-4">
        <input class="form-control" name="q" value="{{ request('q') }}" placeholder="Search name/email/ic...">
    </div>
    <div class="col-md-3">
        <select class="form-select" name="role">
            <option value="">All roles</option>
            <option value="teacher" @selected(request('role')==='teacher')>Teacher</option>
            <option value="student" @selected(request('role')==='student')>Student</option>
        </select>
    </div>
    <div class="col-md-2">
        <button class="btn btn-outline-dark w-100">Filter</button>
    </div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>IC Number</th>
                    <th>Role</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse($users as $u)
                <tr>
                    <td>{{ $u->id }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->ic_number }}</td>
                    <td><span class="badge bg-secondary">{{ $u->role }}</span></td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.users.show', $u) }}">View</a>
                        <a class="btn btn-sm btn-outline-warning" href="{{ route('admin.users.edit', $u) }}">Edit</a>
                        <form class="d-inline" method="POST" action="{{ route('admin.users.destroy', $u) }}"
                              onsubmit="return confirm('Delete this user?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No users found</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $users->links() ?? '' }}
</div>
@endsection
