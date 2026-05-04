@extends('admin.layouts.app')
@section('title', 'Manage Students')

@section('content')

<style>
/* Card styling */
.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

/* Table header */
.table thead {
    background: #f8f9fc;
    font-weight: 600;
}

/* Action buttons */
.action-btns .btn {
    border-radius: 8px;
    padding: 5px 10px;
}

/* View */
.btn-view {
    background: #e7f1ff;
    color: #0d6efd;
    border: none;
}
.btn-view:hover {
    background: #0d6efd;
    color: #fff;
}

/* Edit */
.btn-edit {
    background: #fff4e5;
    color: #ff9800;
    border: none;
}
.btn-edit:hover {
    background: #ff9800;
    color: #fff;
}

/* Delete */
.btn-delete {
    background: #fdecea;
    color: #dc3545;
    border: none;
}
.btn-delete:hover {
    background: #dc3545;
    color: #fff;
}

/* Top buttons */
.btn-primary, .btn-success {
    border-radius: 10px;
    padding: 8px 16px;
}

.pagination-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.pagination {
    justify-content: center !important;
}

.showing-text {
    font-size: 14px;
    color: #6c757d;
}
</style>


<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0 d-flex align-items-center gap-2">
        <i class="bi bi-people-fill text-dark"></i>
        Manage Students
    </h3>

    <div class="d-flex gap-2">
        <a class="btn btn-success shadow-sm" href="{{ route('admin.students.import.show') }}">
            <i class="bi bi-upload"></i> Import Excel
        </a>

        <a class="btn btn-primary shadow-sm" href="{{ route('admin.students.create') }}">
            <i class="bi bi-plus-lg"></i> Add Student
        </a>
    </div>
</div>

<form class="row g-2 mb-3 align-items-center"
      method="GET"
      id="filterForm"
      action="{{ route('admin.students.index') }}">

    {{-- SEARCH --}}
    <div class="col-md-4">
        <input class="form-control"
               name="q"
               value="{{ request('q') }}"
               placeholder="Search by name/email"
               onkeyup="this.form.submit()">
    </div>

    {{-- FORM --}}
    <div class="col-md-3">
        <select class="form-select"
                name="form"
                id="formSelect"
                onchange="this.form.submit()">

            <option value="">-- All Forms --</option>

            @foreach($forms ?? [] as $f)
                <option value="{{ $f->form_number }}"
                    {{ request('form') == $f->form_number ? 'selected' : '' }}>
                    Form {{ $f->form_number }}
                </option>
            @endforeach

        </select>
    </div>

    {{-- CLASS --}}
    <div class="col-md-3">
        <select class="form-select"
                name="class"
                id="classSelect"
                onchange="this.form.submit()">

            <option value="">-- All Classes --</option>

            @foreach($classes ?? [] as $class)
                <option value="{{ $class->name }}"
                    {{ request('class') == $class->name ? 'selected' : '' }}>
                    {{ $class->name }}
                </option>
            @endforeach

        </select>
    </div>

    {{-- CLEAR --}}
    <div class="col-md-2">
        <a href="{{ route('admin.students.index') }}"
            class="btn btn-light border w-100">
            Clear
        </a>
    </div>

</form>


<div class="card">
    <div class="table-responsive">

        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Form</th>
                    <th>Class</th>
                    <th>Date Joined</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>

            <tbody>
            @forelse($students as $s)

                <tr>
                    <td>{{ $s->name }}</td>
                    <td>{{ $s->email }}</td>
                    <td>{{ ucfirst($s->gender) }}</td>
                    <td>{{ $s->form }}</td>
                    <td>{{ $s->class_name }}</td>
                    <td>{{ $s->date_joined }}</td>

                    <td class="text-end action-btns">

                        <a class="btn btn-sm btn-view"
                           href="{{ route('admin.students.show', $s) }}">
                           <i class="bi bi-eye"></i>
                        </a>

                        <a class="btn btn-sm btn-edit"
                           href="{{ route('admin.students.edit', $s) }}">
                           <i class="bi bi-pencil"></i>
                        </a>

                        <form class="d-inline"
                              method="POST"
                              action="{{ route('admin.students.destroy', $s) }}"
                              onsubmit="return confirm('Delete this student?')">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        No students found
                    </td>
                </tr>

            @endforelse
            </tbody>

        </table>

    </div>
</div>

<div class="pagination-wrapper mt-3">

    {{ $students->links() }}

    <div class="showing-text mt-2 text-center">
        Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} 
        of {{ $students->total() }} results
    </div>

</div>

<script>
    const formSelect = document.getElementById('formSelect');
    const classSelect = document.getElementById('classSelect');

    function toggleClass() {
        if (!formSelect.value) {
            classSelect.disabled = true;
        } else {
            classSelect.disabled = false;
        }
    }

    toggleClass();

    formSelect.addEventListener('change', function() {
        classSelect.value = '';
        toggleClass();
    });
</script>

@endsection