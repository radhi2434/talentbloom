@extends('student.layouts.app')

@section('title', 'Dashboard')

@section('content')

<style>
.stat-card {
    background: #ffffff;
    border-radius: 18px;
    padding: 28px;
    height: 140px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.06);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.category-card {
    border-radius: 18px;
    padding: 20px;
    height: 160px;
    color: white;
    position: relative;
    box-shadow: 0 10px 25px rgba(0,0,0,0.06);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    cursor: pointer;
}

.category-icon {
    position: absolute;
    top: 20px;
    left: 20px;
    font-size: 40px;
    opacity: 0.3;
}

.badge-group {
    position: absolute;
    top: 20px;
    right: 20px;
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    width: 90px;
    justify-content: flex-end;
}

.badge-img {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    object-fit: cover;
    background: white;
    padding: 3px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    transition: 0.2s;
}

.badge-img:hover {
    transform: scale(1.2);
}

.category-content {
    margin-top: auto;
}

.bg-academic { background: #7ea0c8; }
.bg-sports { background: #a78fd8; }
.bg-leadership { background: #d88fb0; }
.bg-cocurricular { background: #8fc9b0; }

h2 {
    font-weight: 700;
}
</style>

<div class="container">

    <h5 class="mb-4">
        <i class="bi bi-trophy"></i>
        Welcome back, {{ auth()->user()->name }}!
    </h5>

    {{-- TOP CARDS --}}
    <div class="row g-4 mb-4">

        <div class="col-md-6">
            <div class="stat-card">
                <div>
                    <small class="text-muted">Total Achievements</small>
                    <h2>{{ $totalAchievements }}</h2>
                </div>
                <i class="bi bi-award fs-1 text-secondary"></i>
            </div>
        </div>

        <div class="col-md-6">
            <div class="stat-card">
                <div>
                    <small class="text-muted">Top Achievement</small>
                    <h6 class="fw-bold">
                        {{ $topAchievement->title ?? 'No achievement yet' }}
                    </h6>
                </div>
                <i class="bi bi-star fs-1 text-warning"></i>
            </div>
        </div>

    </div>

    {{-- CATEGORY --}}
    <div class="row g-4">

        @php
            $categories = [
                'academic' => ['Academic', 'bi-mortarboard', 'bg-academic'],
                'sports' => ['Sports', 'bi-trophy', 'bg-sports'],
                'leadership' => ['Leadership', 'bi-person-badge', 'bg-leadership'],
                'cocurricular' => ['Co-curricular', 'bi-people', 'bg-cocurricular'],
            ];
        @endphp

        @foreach($categories as $key => [$label, $icon, $bg])
        <div class="col-md-6">
            <div class="category-card {{ $bg }}"
                 onclick="showAchievements('{{ $key }}', null)">

                <i class="bi {{ $icon }} category-icon"></i>

                {{-- BADGES --}}
                <div class="badge-group">
                    @foreach($badgesByCategory[$key] ?? [] as $b)

                        @php
                            $lvl = strtolower(trim($b));
                            $map = [
                                'national' => 'national.png',
                                'state' => 'state.png',
                                'district' => 'district.png',
                                'school' => 'school.png',
                            ];
                            $img = $map[$lvl] ?? 'school.png';
                        @endphp

                        <img src="{{ asset('badges/'.$img) }}"
                             class="badge-img"
                             title="{{ ucfirst($lvl) }}"
                             onclick="event.stopPropagation(); showAchievements('{{ $key }}','{{ $lvl }}')">
                    @endforeach
                </div>

                <div class="category-content">
                    <h2>{{ $counts->$key ?? 0 }}</h2>
                    <p class="mb-0">{{ $label }}</p>
                </div>

            </div>
        </div>
        @endforeach

    </div>

</div>

{{-- 🔥 MODAL --}}
<div class="modal fade" id="achievementModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Achievements</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="achievementContent">
                Loading...
            </div>

        </div>
    </div>
</div>

<script>
function showAchievements(category, level){

    let modal = new bootstrap.Modal(document.getElementById('achievementModal'));
    modal.show();

    document.getElementById('achievementContent').innerHTML = "Loading...";

    let url = `/student/achievements-list?category=${category}`;

    if(level){
        url += `&level=${level}`;
    }

    fetch(url)
        .then(res => res.text())
        .then(data => {
            document.getElementById('achievementContent').innerHTML = data;
        });
}
</script>

@endsection