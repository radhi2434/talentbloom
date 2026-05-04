@extends('admin.layouts.app')
@section('title','Analytics')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-3">
    <h4 class="mb-0">Analytics Page</h4>

    {{-- FILTER --}}
    <form method="GET" action="{{ route('admin.analytics') }}">
        <select name="category" class="form-select form-select-sm">
            <option value="all" {{ $category=='all'?'selected':'' }}>All Talents</option>
            <option value="sports" {{ $category=='sports'?'selected':'' }}>Sports</option>
            <option value="academics" {{ $category=='academics'?'selected':'' }}>Academic</option>
            <option value="co-curricular" {{ $category=='co-curricular'?'selected':'' }}>Co-curricular</option>
            <option value="leadership" {{ $category=='leadership'?'selected':'' }}>Leadership</option>
        </select>

        <button class="btn btn-sm btn-dark mt-1">Apply</button>
    </form>
</div>

{{-- TREND ANALYSIS --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h6>Talent Trend by Form</h6>
        <canvas id="trendChart" height="100"></canvas>
    </div>
</div>

{{-- LIST DATA --}}
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h6>All Talent Records</h6>

        <table class="table table-bordered mt-3">
            <thead class="table-light">
                <tr>
                    <th>Student</th>
                    <th>Form</th>
                    <th>Category</th>
                    <th>Title</th>
                </tr>
            </thead>

            <tbody>
                @forelse($talents as $t)
                <tr>
                    <td>{{ $t->student->name ?? '-' }}</td>
                    <td>{{ $t->student->form ?? '-' }}</td>
                    <td>{{ ucfirst($t->category) }}</td>
                    <td>{{ $t->title }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">No data available</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

{{-- ================== CHART ================== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(document.getElementById('trendChart'), {
    type: 'line',
    data: {
        labels: @json($forms),
        datasets: [{
            label: 'Talent Trend',
            data: @json($trend),
            borderColor: '#007bff',
            backgroundColor: 'rgba(0,123,255,0.1)',
            tension: 0.3,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' }
        }
    }
});
</script>

@endsection