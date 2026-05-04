@extends('admin.layouts.app')
@section('title', 'Manage Teachers')

@section('content')

<style>
/* Action icon box */
.action-box {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
    border-radius: 10px;
    text-decoration: none;
}

/* Colors */
.action-view {
    background: #e7f1ff;
    color: #0d6efd;
}

.action-edit {
    background: #fff4e5;
    color: #ff9800;
}

.action-delete {
    background: #fdecea;
    color: #dc3545;
    border: none;
}

/* Hover */
.action-box:hover {
    opacity: 0.85;
    transform: scale(1.05);
}
</style>


<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0 d-flex align-items-center gap-2">
        <i class="bi bi-person-badge"></i>
        Manage Teachers
    </h3>

    <div class="d-flex gap-2">
        <a class="btn btn-success d-flex align-items-center gap-1"
           href="{{ route('admin.teachers.import.show') }}">
            <i class="bi bi-upload"></i>
            Import Excel
        </a>

        <a class="btn btn-primary d-flex align-items-center gap-1"
           href="{{ route('admin.teachers.create') }}">
            <i class="bi bi-plus-lg"></i>
            Add New Teacher
        </a>
    </div>
</div>


{{-- FILTER --}}
<form class="row g-2 mb-3 align-items-center"
      method="GET"
      id="filterForm"
      action="{{ route('admin.teachers.index') }}">

    <div class="col-md-6">
        <input
            class="form-control"
            name="q"
            value="{{ request('q') }}"
            placeholder="Search by name/email"
            onkeyup="this.form.submit()"
        >
    </div>

    <div class="col-md-4">
        <select class="form-select"
                name="position"
                onchange="this.form.submit()">

            <option value="">-- All Positions --</option>

            @foreach ($positions as $position)
                <option
                    value="{{ $position->name }}"
                    {{ request('position') == $position->name ? 'selected' : '' }}>
                    {{ $position->name }}
                </option>
            @endforeach

        </select>
    </div>

    <div class="col-md-2">
        <a href="{{ route('admin.teachers.index') }}"
           class="btn btn-light border w-100">
            Clear
        </a>
    </div>

</form>


<div class="card">
    <div class="table-responsive">

        {{-- ⚠️ TABLE TAK DIUBAH --}}
        <table class="table table-striped mb-0">

            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <th>Position</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($teachers as $t)

                    <tr>

                        <td>{{ $t->name }}</td>

                        <td>{{ $t->email }}</td>

                        <td>{{ ucfirst($t->gender) }}</td>

                        <td>{{ $t->phone }}</td>

                        <td>{{ $t->position }}</td>

                        {{-- ✅ BUTTON STYLE UPDATED --}}
                        <td class="text-end d-flex justify-content-end gap-2">

                            <a href="{{ route('admin.teachers.show', $t) }}"
                               class="action-box action-view">
                                <i class="bi bi-eye"></i>
                            </a>

                            <a href="{{ route('admin.teachers.edit', $t) }}"
                               class="action-box action-edit">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form class="d-inline"
                                  method="POST"
                                  action="{{ route('admin.teachers.destroy', $t) }}"
                                  onsubmit="return confirm('Delete this teacher?')">

                                @csrf
                                @method('DELETE')

                                <button class="action-box action-delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            No teachers found
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>
</div>


{{-- PAGINATION --}}
<div class="d-flex flex-column align-items-center mt-3">

    {{ $teachers->links() }}

    <div class="text-muted small mt-2">
        Showing {{ $teachers->firstItem() }} to {{ $teachers->lastItem() }}
        of {{ $teachers->total() }} results
    </div>

</div>

@endsection