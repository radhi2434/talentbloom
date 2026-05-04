@extends('student.layouts.app')
@section('title','My Achievements')

@section('content')

<div class="container-fluid px-4">

    <h5 class="fw-semibold mb-4">
        <i class="bi bi-award"></i> My Achievements
    </h5>

    {{-- ================= SUMMARY CARDS ================= --}}
    <div class="row g-4 mb-4">

        <div class="col-md-3">
            <div class="summary-card academic">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="count">{{ $counts->academic ?? 0 }}</div>
                        <div>Academic</div>
                    </div>
                    <i class="bi bi-mortarboard-fill icon"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="summary-card sports">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="count">{{ $counts->sports ?? 0 }}</div>
                        <div>Sports</div>
                    </div>
                    <i class="bi bi-trophy-fill icon"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="summary-card leadership">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="count">{{ $counts->leadership ?? 0 }}</div>
                        <div>Leadership</div>
                    </div>
                    <i class="bi bi-person-badge-fill icon"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="summary-card cocurricular">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="count">{{ $counts->cocurricular ?? 0 }}</div>
                        <div>Co-curricular</div>
                    </div>
                    <i class="bi bi-people-fill icon"></i>
                </div>
            </div>
        </div>

    </div>


    {{-- ================= FILTER ================= --}}
    <form method="GET" class="mb-4">

        <div class="row g-3 mb-3">

            {{-- CATEGORY --}}
            <div class="col-md-3">
                <select name="category" class="form-select" onchange="this.form.submit()">
                    <option value="all">All Categories</option>
                    <option value="academic" {{ request('category')=='academic'?'selected':'' }}>Academic</option>
                    <option value="sports" {{ request('category')=='sports'?'selected':'' }}>Sports</option>
                    <option value="leadership" {{ request('category')=='leadership'?'selected':'' }}>Leadership</option>
                    <option value="co-curricular" {{ request('category')=='co-curricular'?'selected':'' }}>Co-curricular</option>
                </select>
            </div>

            {{-- LEVEL --}}
            <div class="col-md-3">
                <select name="level" class="form-select" onchange="this.form.submit()">
                    <option value="all">All Levels</option>
                    <option value="school" {{ request('level')=='school'?'selected':'' }}>School</option>
                    <option value="district" {{ request('level')=='district'?'selected':'' }}>District</option>
                    <option value="state" {{ request('level')=='state'?'selected':'' }}>State</option>
                    <option value="national" {{ request('level')=='national'?'selected':'' }}>National</option>
                </select>
            </div>

            {{-- YEAR --}}
            <div class="col-md-3">
                <select name="year" class="form-select" onchange="this.form.submit()">
                    <option value="all">All Years</option>
                    @for($y = now()->year; $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ request('year')==$y?'selected':'' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>

            {{-- CLEAR ONLY --}}
            <div class="col-md-3 d-flex gap-2">
                <a href="{{ route('student.achievements') }}"
                   class="btn btn-outline-secondary w-100">
                    Clear
                </a>
            </div>

        </div>

        {{-- SEARCH AUTO --}}
        <input type="text"
               name="q"
               class="form-control"
               placeholder="Search by Title"
               value="{{ request('q') }}"
               onkeyup="setTimeout(() => this.form.submit(), 500)">
    </form>


    {{-- ================= TALENT CARDS ================= --}}
    <div class="row g-4">
        @forelse($talents as $talent)

            <div class="col-md-4 d-flex">

                <div class="talent-card {{ $talent->category }} w-100 d-flex flex-column">

                    <h6 class="fw-semibold d-flex align-items-center gap-2 mb-2">

                        @if($talent->category == 'academic')
                            <i class="bi bi-mortarboard-fill text-academic"></i>
                        @elseif($talent->category == 'sports')
                            <i class="bi bi-trophy-fill text-sports"></i>
                        @elseif($talent->category == 'leadership')
                            <i class="bi bi-person-badge-fill text-leadership"></i>
                        @elseif($talent->category == 'co-curricular')
                            <i class="bi bi-people-fill text-cocurricular"></i>
                        @endif

                        {{ $talent->title }}
                    </h6>

                    <span class="category-pill">
                        {{ ucfirst($talent->category) }}
                    </span>

                    <span class="date">
                        {{ \Carbon\Carbon::parse($talent->achieved_at)->format('d M Y') }}
                    </span>

                    <div class="mt-2 flex-grow-1">
                        {{ $talent->description }}
                    </div>

                </div>

            </div>

        @empty
            <div class="text-center text-muted py-5">
                No achievements found.
            </div>
        @endforelse
    </div>

</div>


{{-- ================= STYLES ================= --}}
<style>

.summary-card {
    padding: 22px;
    border-radius: 14px;
    color: white;
}

.summary-card .count {
    font-size: 30px;
    font-weight: 700;
}

.summary-card.academic { background: #7fa6d9; }
.summary-card.sports { background: #a48be0; }
.summary-card.leadership { background: #e38ab4; }
.summary-card.cocurricular { background: #8dd1b5; }

.icon {
    font-size: 26px;
}

.talent-card {
    background: #ffffff;
    padding: 20px;
    border-radius: 14px;
    border: 2px solid;
    transition: all 0.25s ease;
    min-height: 160px;
}

.talent-card.academic { border-color: #7fa6d9; }
.talent-card.sports { border-color: #a48be0; }
.talent-card.leadership { border-color: #e38ab4; }
.talent-card.co-curricular { border-color: #8dd1b5; }

.talent-card:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 12px 25px rgba(0,0,0,0.12);
    border-width: 3px;
}

.text-academic { color: #7fa6d9; }
.text-sports { color: #a48be0; }
.text-leadership { color: #e38ab4; }
.text-cocurricular { color: #8dd1b5; }

.category-pill {
    background: #eef2ff;
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 12px;
    margin-right: 10px;
}

.date {
    font-size: 12px;
    color: #6b7280;
}

</style>

@endsection