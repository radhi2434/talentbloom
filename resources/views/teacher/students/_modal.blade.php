@if(session('success')) 
    <div class="alert alert-success shadow-sm">
        {{ session('success') }}
    </div>
@endif

{{-- 🔹 PERSONAL INFO --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">

        <div class="fw-bold mb-3 d-flex align-items-center gap-2">
            <i class="bi bi-person-circle text-primary"></i>
            Personal Info
        </div>

        <div class="row g-3">

            <div class="col-md-6">
                <div class="text-muted small">Full Name</div>
                <div class="fw-semibold fs-6">{{ $student->name }}</div>
            </div>

            <div class="col-md-6">
                <div class="text-muted small">Form</div>
                <span class="badge bg-light text-dark border">
                    Form {{ $student->form ?? '-' }}
                </span>
            </div>

            <div class="col-md-6">
                <div class="text-muted small">Class</div>
                <div class="fw-semibold">{{ $student->class_name ?? '-' }}</div>
            </div>

            <div class="col-md-6">
                <div class="text-muted small">Email</div>
                <div class="fw-semibold text-primary">{{ $student->email }}</div>
            </div>

        </div>
    </div>
</div>

{{-- 🔹 TALENT SUMMARY --}}
<div class="card border-0 shadow-sm">
    <div class="card-body">

        <div class="d-flex align-items-center justify-content-between mb-3">

            <div class="fw-bold d-flex align-items-center gap-2">
                <i class="bi bi-bar-chart-fill text-success"></i>
                Talents 
                <span class="badge bg-primary rounded-pill">
                    {{ $student->talents_count }}
                </span>
            </div>

            <a href="{{ url('/teacher/students/'.$student->id.'/talents/create') }}"
               class="btn btn-sm px-3 add-talent-btn">
                <i class="bi bi-plus-lg"></i> Add Talent
            </a>

        </div>

        {{-- 🔹 TALLY --}}
        <div class="row g-2">

            <div class="col-md-6">
                <div class="d-flex justify-content-between p-2 rounded bg-light">
                    <span>Sports</span>
                    <span class="fw-bold text-dark">{{ $counts['sports'] }}</span>
                </div>
            </div>

            <div class="col-md-6">
                <div class="d-flex justify-content-between p-2 rounded bg-light">
                    <span>Leadership</span>
                    <span class="fw-bold text-dark">{{ $counts['leadership'] }}</span>
                </div>
            </div>

            <div class="col-md-6">
                <div class="d-flex justify-content-between p-2 rounded bg-light">
                    <span>Academic</span>
                    <span class="fw-bold text-dark">{{ $counts['academic'] }}</span>
                </div>
            </div>

            <div class="col-md-6">
                <div class="d-flex justify-content-between p-2 rounded bg-light">
                    <span>Co-curricular</span>
                    <span class="fw-bold text-dark">{{ $counts['cocurricular'] }}</span>
                </div>
            </div>

        </div>

    </div>
</div>

<style>
.add-talent-btn {
    background: #0d3b66;
    color: #fff;
    border: none;
}

.add-talent-btn:hover {
    background: #0b3154;
    color: #fff;
}
</style>