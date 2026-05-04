@extends('admin.layouts.app')
@section('title','Manage Talents')

@section('content')

<style>
.card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

/* badges */
.rank-badge {
    background: #6c757d;
    border-radius: 999px;
    padding: 5px 10px;
}

.talent-badge {
    background: #0d6efd;
    border-radius: 999px;
    padding: 5px 10px;
}

/* action icon box */
.action-box {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #eef2f7;
    color: #333;
    border: none;
}

.action-box:hover {
    background: #e2e6ea;
}

/* filter text */
.filter-info {
    font-size: 13px;
    color: #6c757d;
}
</style>


{{-- HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 d-flex align-items-center gap-2">
        <i class="bi bi-trophy"></i>
        Manage Talents
    </h4>

    <a class="btn btn-primary d-flex align-items-center gap-1 shadow-sm"
       href="{{ route('admin.talents.create') }}">
        <i class="bi bi-plus-lg"></i>
        Add New Talent
    </a>
</div>


@if(session('success'))
    <div class="alert alert-success small">{{ session('success') }}</div>
@endif


{{-- FILTER --}}
<form class="card p-3 mb-3"
      method="GET"
      id="filterForm"
      action="{{ route('admin.talents.index') }}">

    <div class="row g-2 align-items-center">

        <div class="col-md-4">
            <input class="form-control"
                   name="q"
                   value="{{ request('q') }}"
                   placeholder="Search by Student Name..."
                   onkeyup="this.form.submit()">
        </div>

        <div class="col-md-2">
            <select class="form-select"
                    name="category"
                    onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($categories as $val => $label)
                    <option value="{{ $val }}"
                        {{ request('category') == $val ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <select class="form-select"
                    name="level"
                    onchange="this.form.submit()">
                <option value="">All Levels</option>
                @foreach($levels as $val => $label)
                    <option value="{{ $val }}"
                        {{ request('level') == $val ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <select class="form-select"
                    name="year"
                    onchange="this.form.submit()">
                <option value="">All Years</option>
                @foreach($years as $y)
                    <option value="{{ $y }}"
                        {{ (string)request('year') === (string)$y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <a href="{{ route('admin.talents.index') }}"
               class="btn btn-light border w-100">
                Clear
            </a>
        </div>

    </div>

    <div class="mt-2 filter-info">
        Showing <b>{{ $students->total() }}</b> students found
    </div>

</form>


<div class="card">
    <div class="table-responsive">

        <table class="table align-middle mb-0">

            <thead>
                <tr>
                    <th style="width:120px;" class="text-center">Rank</th>
                    <th>Student Name</th>
                    <th style="width:120px;" class="text-center">Talents</th>
                    <th class="text-end" style="width:120px;">Actions</th>
                </tr>
            </thead>

            <tbody>

            @forelse($students as $idx => $s)

                @php
                    $rank = ($students->currentPage()-1)*$students->perPage() + $idx + 1;
                @endphp

                <tr>
                    <td class="text-center">
                        <span class="rank-badge text-white">
                            {{ $rank }}
                        </span>
                    </td>

                    <td>{{ $s->name }}</td>

                    <td class="text-center">
                        <span class="talent-badge text-white">
                            {{ $s->talents_count }}
                        </span>
                    </td>

                    <td class="text-end">
                        <button
                            class="action-box btn-view-talents"
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


{{-- PAGINATION --}}
<div class="d-flex flex-column align-items-center mt-3">

    {{ $students->links() }}

    <div class="text-muted small mt-2">
        Showing {{ $students->firstItem() }} to {{ $students->lastItem() }}
        of {{ $students->total() }} results
    </div>

</div>


{{-- MODAL --}}
<div class="modal fade" id="talentsModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="talentsModalTitle"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body" id="talentsModalBody">
        <div class="text-center text-muted py-4">Loading...</div>
      </div>

    </div>
  </div>
</div>


<script>
document.addEventListener('click', async function(e){
    const btn = e.target.closest('.btn-view-talents');
    if(!btn) return;

    const studentId = btn.dataset.studentId;
    const studentName = btn.dataset.studentName;

    const url = new URL("{{ url('/admin/talents/student') }}/" + studentId);

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