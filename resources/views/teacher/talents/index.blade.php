@extends('teacher.layouts.app')
@section('title','Manage Talents')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Manage Talents</h3>

    <a class="btn btn-theme" href="{{ route('teacher.talents.create') }}">
        + Add New Talent
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form class="card p-3 mb-3"
      method="GET"
      action="{{ route('teacher.talents.index') }}">

    <div class="row g-2 align-items-center">

        <div class="col-md-4">
            <input class="form-control"
                   name="q"
                   value="{{ request('q') }}"
                   placeholder="Search by Student Name..."
                   oninput="this.form.submit()">
        </div>

        <div class="col-md-2">
            <select class="form-select" name="category" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($categories as $val => $label)
                    <option value="{{ $val }}" @selected(request('category')==$val)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <select class="form-select" name="level" onchange="this.form.submit()">
                <option value="">All Levels</option>
                @foreach($levels as $val => $label)
                    <option value="{{ $val }}" @selected(request('level')==$val)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <select class="form-select" name="year" onchange="this.form.submit()">
                <option value="">All Years</option>
                @foreach($years as $y)
                    <option value="{{ $y }}" @selected((string)request('year') === (string)$y)>
                        {{ $y }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <a href="{{ route('teacher.talents.index') }}"
               class="btn btn-theme w-100">
                Clear
            </a>
        </div>

    </div>

</form>

{{-- TABLE --}}
<div class="card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">

            <thead>
                <tr>
                    <th style="width:120px;" class="text-center">Rank</th>
                    <th>Student Name</th>
                    <th style="width:120px;" class="text-center">Talents</th>
                    <th class="text-end pe-3" style="width:120px;">Actions</th>
                </tr>
            </thead>

            <tbody>
            @forelse($students as $idx => $s)
                @php
                    $rank = ($students->currentPage()-1)*$students->perPage() + $idx + 1;
                @endphp

                <tr>
                    <td class="text-center">
                        <span class="badge rounded-pill bg-secondary">
                            {{ $rank }}
                        </span>
                    </td>

                    <td>{{ $s->name }}</td>

                    <td class="text-center">
                        <span class="badge rounded-pill bg-primary">
                            {{ $s->talents_count }}
                        </span>
                    </td>

                    {{-- 🔥 SHIFT LEFT SIKIT --}}
                    <td class="text-end pe-4">
                        <button class="icon-btn view btn-view-talents"
                                data-student-id="{{ $s->id }}"
                                data-student-name="{{ $s->name }}">
                            <i class="bi bi-eye"></i>
                        </button>
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        No students found
                    </td>
                </tr>
            @endforelse
            </tbody>

        </table>
    </div>
</div>

{{-- 🔥 PAGINATION --}}
<div class="mt-3 d-flex flex-column align-items-center gap-1">

    {{ $students->links() }}

    {{-- 🔥 DYNAMIC TEXT --}}
    <div class="small text-muted">
        Showing
        <b>{{ $students->firstItem() ?? 0 }}</b>
        to
        <b>{{ $students->lastItem() ?? 0 }}</b>
        of
        <b>{{ $students->total() }}</b>
        results
    </div>

</div>

{{-- MODAL --}}
<div class="modal fade" id="talentsModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="talentsModalTitle">
                    Student Talent Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="talentsModalBody">
                <div class="text-center text-muted py-4">Loading...</div>
            </div>

        </div>
    </div>
</div>

<style>
.btn-theme {
    background: #0d3b66;
    color: #fff;
    border: none;
}
.btn-theme:hover {
    background: #0b3154;
    color: #fff;
}

.icon-btn {
    border: none;
    background: #eef2f7;
    color: #0d3b66;
    padding: 6px 10px;
    border-radius: 8px;
}
.icon-btn:hover {
    background: #0d3b66;
    color: #fff;
}

/* pagination */
.pagination .page-item.active .page-link {
    background: #0d3b66;
    border-color: #0d3b66;
    color: #fff;
}
.pagination .page-link {
    color: #0d3b66;
}
.pagination .page-link:hover {
    background: #0d3b66;
    color: #fff;
}
</style>

<script>
document.addEventListener('click', async function(e){
    const btn = e.target.closest('.btn-view-talents');
    if(!btn) return;

    const studentId = btn.dataset.studentId;
    const studentName = btn.dataset.studentName;

    const url = new URL("{{ url('/teacher/talents/student') }}/" + studentId);

    const params = new URLSearchParams(window.location.search);
    params.forEach((v,k) => url.searchParams.set(k,v));

    document.getElementById('talentsModalTitle').textContent =
        `Student Talent Details: ${studentName}`;

    document.getElementById('talentsModalBody').innerHTML =
        `<div class="text-center text-muted py-4">Loading...</div>`;

    const res = await fetch(url);
    const html = await res.text();

    document.getElementById('talentsModalBody').innerHTML = html;

    new bootstrap.Modal(document.getElementById('talentsModal')).show();
});
</script>

@endsection