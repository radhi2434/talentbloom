@extends('teacher.layouts.app')
@section('title','Dashboard')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-3">
    <div class="d-flex align-items-center gap-2">
        <i class="bi bi-person-circle fs-4"></i>
        <h4 class="mb-0">Teacher Dashboard</h4>
    </div>

    {{-- FILTER BAR --}}
    <form class="d-flex gap-2" method="GET" action="/teacher/dashboard">

        <select class="form-select form-select-sm"
                name="category"
                onchange="this.form.submit()">

            @php 
                $category = strtolower(request('category','all')); 
            @endphp

            <option value="all" @selected($category=='all')>All Talents</option>
            <option value="sports" @selected($category=='sports')>Sports</option>
            <option value="academic" @selected($category=='academic')>Academic</option>
            <option value="co-curricular" @selected($category=='co-curricular')>Co-curricular</option>
            <option value="leadership" @selected($category=='leadership')>Leadership</option>
        </select>

        <a href="/teacher/dashboard"
           class="btn btn-sm btn-dark">
            Clear
        </a>

    </form>
</div>

{{-- KPI --}}
<div class="row g-3 mb-4">

    <div class="col">
        <div class="card shadow-sm border-0 text-center p-2">
            <div class="text-muted small">Total Students</div>
            <div class="fs-4 fw-bold">{{ $totalStudents ?? 0 }}</div>
        </div>
    </div>

    <div class="col">
        <div class="card shadow-sm border-0 text-center p-2">
            <div class="text-muted small">Sports</div>
            <div class="fs-4 fw-bold">{{ $sportsCount ?? 0 }}</div>
        </div>
    </div>

    <div class="col">
        <div class="card shadow-sm border-0 text-center p-2">
            <div class="text-muted small">Academic</div>
            <div class="fs-4 fw-bold">{{ $academicCount ?? 0 }}</div>
        </div>
    </div>

    <div class="col">
        <div class="card shadow-sm border-0 text-center p-2">
            <div class="text-muted small">Leadership</div>
            <div class="fs-4 fw-bold">{{ $leadershipCount ?? 0 }}</div>
        </div>
    </div>

    <div class="col">
        <div class="card shadow-sm border-0 text-center p-2">
            <div class="text-muted small">Co-curricular</div>
            <div class="fs-4 fw-bold">{{ $cocurricularCount ?? 0 }}</div>
        </div>
    </div>

</div>

{{-- CHART --}}
<div class="row g-3">

    {{-- BAR --}}
    <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">
                    <i class="bi bi-bar-chart-line me-2"></i>
                    Talent Distribution by Form
                </h6>

                <div class="chart-container">
                    <canvas id="talentChart"></canvas>
                </div>

            </div>
        </div>
    </div>

    {{-- DONUT --}}
    <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">
                    <i class="bi bi-pie-chart me-2"></i>
                    Talent Distribution
                </h6>

                <div class="chart-container">
                    <canvas id="donutChart"></canvas>
                </div>

            </div>
        </div>
    </div>

</div>

{{-- PROGRESS --}}
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">
                    <i class="bi bi-activity me-2"></i>
                    Talent Discovery Progress by Form
                </h6>

                <div class="row">
                    @foreach($forms as $index => $form)
                        @php
                            $total = $discovered[$index] + $notDiscovered[$index];
                            $percent = $total > 0 ? ($discovered[$index] / $total) * 100 : 0;

                            if ($percent == 100) {
                                $color = 'bg-success';
                            } elseif ($percent >= 50) {
                                $color = 'bg-warning';
                            } else {
                                $color = 'bg-danger';
                            }
                        @endphp

                        <div class="col-md-4 mb-3">
                            <div class="border rounded p-3">

                                <div class="d-flex justify-content-between mb-1">
                                    <strong>Form {{ $form }}</strong>
                                    <span>{{ round($percent) }}%</span>
                                </div>

                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar {{ $color }}"
                                         style="width: {{ $percent }}%">
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>

{{-- TREND --}}
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h6 class="fw-semibold mb-0">
                        <i class="bi bi-graph-up me-2"></i>
                        Monthly Talent Trend
                    </h6>

                    {{-- FILTER --}}
                    <form method="GET" action="/teacher/dashboard" class="d-flex gap-2">

                        {{-- KEEP CATEGORY --}}
                        <input type="hidden" name="category" value="{{ request('category') }}">

                        {{-- YEAR --}}
                        <select name="year"
                                class="form-select form-select-sm"
                                onchange="this.form.submit()">

                            @for($y = now()->year; $y >= now()->year - 5; $y--)
                                <option value="{{ $y }}"
                                    {{ request('year', now()->year) == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>

                        {{-- FORM --}}
                        <select name="form"
                                class="form-select form-select-sm"
                                onchange="this.form.submit()">

                            <option value="">Forms</option>

                            @foreach([1,2,3,4,5] as $f)
                                <option value="{{ $f }}"
                                    {{ request('form') == $f ? 'selected' : '' }}>
                                    Form {{ $f }}
                                </option>
                            @endforeach

                        </select>

                    </form>

                </div>

                <div style="height: 300px;">
                    <canvas id="trendChart"></canvas>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- CSS --}}
<style>
.chart-container {
    height: 300px;
}
.chart-container canvas {
    height: 100% !important;
    width: 100% !important;
}
.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    transition: 0.2s;
}
.card:hover {
    transform: translateY(-2px);
}
</style>

{{-- CHART JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// BAR
const forms = @json($forms ?? []);
const discovered = @json($discovered ?? []);
const notDiscovered = @json($notDiscovered ?? []);

new Chart(document.getElementById('talentChart'), {
    type: 'bar',
    data: {
        labels: forms.map(f => 'Form ' + f),
        datasets: [
            { label: 'Talent Discovered', data: discovered, backgroundColor: '#28a745' },
            { label: 'Yet to be Identified', data: notDiscovered, backgroundColor: '#dc3545' }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: { stacked: true },
            y: { stacked: true, beginAtZero: true }
        }
    }
});

// DONUT
const donutLabels = @json($donutLabels ?? []);
const donutData = @json($donutData ?? []);

new Chart(document.getElementById('donutChart'), {
    type: 'doughnut',
    data: {
        labels: donutLabels,
        datasets: [{
            data: donutData,
            backgroundColor: ['#007bff','#28a745','#ffc107','#dc3545']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,

        onClick: function(evt, elements) {
            if(elements.length > 0){
                let index = elements[0].index;
                let category = donutLabels[index].toLowerCase();

                if (category === 'co curricular') category = 'co-curricular';

                window.location.href = "/teacher/dashboard?category=" + category;
            }
        }
    }
});

// TREND
const trendData = @json($trendFormatted ?? []);

new Chart(document.getElementById('trendChart'), {
    type: 'line',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        datasets: [
            {
                label: 'Sports',
                data: trendData.sports,
                borderColor: '#007bff',
                tension: 0.3
            },
            {
                label: 'Academic',
                data: trendData.academic,
                borderColor: '#28a745',
                tension: 0.3
            },
            {
                label: 'Leadership',
                data: trendData.leadership,
                borderColor: '#ffc107',
                tension: 0.3
            },
            {
                label: 'Co-curricular',
                data: trendData['co-curricular'],
                borderColor: '#dc3545',
                tension: 0.3
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>

@endsection