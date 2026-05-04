@extends('teacher.layouts.app')
@section('title','Students')

@section('content')

<div class="row g-4">

    {{-- LEFT SIDEBAR --}}
    <div class="col-md-2">
        <div style="margin-top: 40px;">
            <div class="card shadow-sm border-0">
                <div class="card-body p-2">

                    @for($i=1; $i<=5; $i++)
                        <a href="{{ route('teacher.students.index', array_merge(request()->all(), ['form'=>$i])) }}"
                            class="btn w-100 mb-2 form-btn
                            {{ (int)($form ?? 0) === $i ? 'active-form' : '' }}">
                            Form {{ $i }}
                        </a>
                    @endfor

                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT CONTENT --}}
    <div class="col-md-10">

        {{-- TITLE --}}
        <div class="text-center mb-4">

            <h3 class="fw-bold d-flex justify-content-center align-items-center gap-2">

                <i class="bi bi-people-fill"></i>

                {{ $form ? 'Form '.$form.' Students' : 'All Students' }}

            </h3>

        </div>

        {{-- FILTER --}}
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">

                <form class="row g-2"
                      method="GET"
                      action="{{ route('teacher.students.index') }}">

                    <input type="hidden" name="form" value="{{ $form }}">

                    {{-- SEARCH --}}
                    <div class="col-md-6">
                        <input class="form-control"
                               name="q"
                               value="{{ request('q') }}"
                               placeholder="Search student name..."
                               oninput="this.form.submit()">
                    </div>

                    {{-- CLASS + CLEAR --}}
                    <div class="col-md-6 d-flex gap-2">

                        <select class="form-select"
                                name="class"
                                onchange="this.form.submit()">

                            <option value="">All Classes</option>

                            @foreach(['Al-Bukhari','At-Tirmizi','An-Nasaie'] as $c)
                                <option value="{{ $c }}"
                                    {{ request('class') == $c ? 'selected' : '' }}>
                                    {{ $c }}
                                </option>
                            @endforeach

                        </select>

                        <a href="{{ route('teacher.students.index') }}" class="btn btn-theme">
                            Reset
                        </a>

                    </div>

                </form>

            </div>
        </div>

        {{-- TABLE --}}
        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Class</th>
                            <th>Form</th>
                            <th>Talents</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($students as $i => $s)
                        <tr class="student-row"
                            data-id="{{ $s->id }}"
                            style="cursor:pointer;">

                            <td>{{ $i+1 }}</td>

                            <td class="fw-semibold">
                                {{ $s->name }}
                            </td>

                            <td>{{ $s->class_name ?? '-' }}</td>

                            <td>
                                <span class="badge bg-light text-dark border">
                                    Form {{ $s->form ?? '-' }}
                                </span>
                            </td>

                            <td class="text-center">
                                <span class="badge bg-primary rounded-pill">
                                    {{ $s->talents_count }}
                                </span>
                            </td>

                            <td class="text-end">
                                <button class="icon-btn view">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No students found
                            </td>
                        </tr>
                    @endforelse
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</div>

{{-- MODAL --}}
<div class="modal fade" id="studentModal">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Student Details</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="studentModalBody">
                <div class="text-center text-muted py-4">Loading...</div>
            </div>

        </div>
    </div>
</div>

<style>
.form-btn {
    background: #f8f9fa;
    border: 1px solid #ddd;
    color: #333;
}

.form-btn:hover {
    background: #e9ecef;
}

.active-form {
    background: #0d3b66 !important;
    color: #fff !important;
    border: none;
}
.btn-theme {
    background: #0d3b66 !important;
    color: #fff !important;
    border: none;
}

.btn-theme:hover {
    background: #0b3154 !important;
    color: #fff !important;
}
</style>

{{-- JS --}}
<script>
document.addEventListener('click', async function(e){
    const row = e.target.closest('.student-row');
    if(!row) return;

    const id = row.dataset.id;

    document.getElementById('studentModalBody').innerHTML =
        `<div class="text-center text-muted py-4">Loading...</div>`;

    try {
        const res = await fetch(`/teacher/students/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });

        const html = await res.text();
        document.getElementById('studentModalBody').innerHTML = html;

        new bootstrap.Modal(document.getElementById('studentModal')).show();

    } catch {
        document.getElementById('studentModalBody').innerHTML =
            `<div class="text-danger text-center py-4">Error loading data</div>`;
    }
});
</script>

@endsection