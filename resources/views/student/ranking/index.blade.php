@extends('student.layouts.app')
@section('title', 'My Ranking')

@section('content')

<h4 class="mb-4">
    <i class="bi bi-trophy"></i> My Ranking
</h4>

{{-- OVERALL RANK --}}
<div class="card text-white mb-4 shadow"
     style="background: linear-gradient(90deg,#1f4e79,#3c78a8); border-radius:12px;">
    <div class="card-body d-flex justify-content-between align-items-center">

        <div>
            <h2 class="mb-0">#{{ $overallRank }}</h2>
            <small>Overall School Ranking</small><br>
            <small>{{ auth()->user()->talents()->count() }} total achievements</small>
        </div>

        <div>
            <small>Out of {{ $totalStudents }} students</small>
        </div>

    </div>
</div>

{{-- CATEGORY RANK CARDS --}}
<div class="row g-3 mb-4">

    @foreach($categoryRanks as $cat => $data)

        @php
            $colors = [
                'academic' => '#7da2ce',
                'sports' => '#9a86d6',
                'leadership' => '#d783a6',
                'co-curricular' => '#7ec0a6'
            ];
        @endphp

        <div class="col-md-3">
            <div class="card shadow-sm"
                 style="background: {{ $colors[$cat] }}; color:white; border-radius:12px;">
                <div class="card-body">

                    {{-- 🔥 ICON + TITLE --}}
                    <div class="d-flex align-items-center gap-2 mb-1">

                        @if($cat == 'academic')
                            <i class="bi bi-mortarboard-fill"></i>
                        @elseif($cat == 'sports')
                            <i class="bi bi-trophy-fill"></i>
                        @elseif($cat == 'leadership')
                            <i class="bi bi-person-badge-fill"></i>
                        @elseif($cat == 'co-curricular')
                            <i class="bi bi-people-fill"></i>
                        @endif

                        <strong>{{ ucfirst($cat) }}</strong>

                    </div>

                    <h4>#{{ $data['rank'] }}</h4>
                    <small>{{ $data['count'] }} achievements</small>

                </div>
            </div>
        </div>

    @endforeach

</div>

{{-- TOP STUDENTS TABLE --}}
<div class="card shadow-sm">
    <div class="card-body">

        <h6 class="mb-3">Top Students Ranking</h6>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Ranking</th>
                    <th>Full Name</th>
                    <th>Total Talents</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $index => $s)
                    <tr>
                        <td>#{{ $index + 1 }}</td>
                        <td>{{ $s->name }}</td>
                        <td>{{ $s->talents_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection