@extends('teacher.layouts.app')

@section('content')

<style>

/* CARD */
.profile-card {
    border-radius: 16px;
    background: #fff;
    box-shadow: 0 6px 20px rgba(0,0,0,0.05);
}

/* HEADER */
.profile-header {
    border-bottom: 1px solid #eee;
    padding-bottom: 12px;
}

/* SECTION TITLE */
.section-title {
    font-weight: 600;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* TAG BASE */
.tag {
    display: inline-block;
    padding: 5px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 500;
}

/* COLORS */
.tag-award {
    background: #e6f4ea;
    color: #198754;
}

.tag-exp {
    background: #e7f0ff;
    color: #0d6efd;
}

/* 🔥 NEW POSITION TAG */
.tag-position {
    background: #f1f3f5;
    color: #495057;
}

/* LABEL */
.category-label {
    font-size: 12px;
    color: #6c757d;
    margin-bottom: 4px;
}

.info-label {
    font-size: 13px;
    color: #6c757d;
}

.info-value {
    font-weight: 500;
}

</style>

<div class="container py-4">

    <div class="profile-card p-4">

        {{-- HEADER --}}
        <div class="d-flex align-items-center gap-3 profile-header">

            {{-- Avatar --}}
            @if($user->profile_photo)
                <img src="{{ asset('storage/'.$user->profile_photo) }}"
                     class="rounded-circle"
                     style="width:75px;height:75px;object-fit:cover;">
            @else
                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                     style="width:75px;height:75px;">
                    {{ strtoupper(substr($user->name,0,1)) }}
                </div>
            @endif

            <div>
                <h5 class="mb-1 fw-bold">{{ $user->name }}</h5>

                {{-- 🔥 POSITION TAG --}}
                <span class="tag tag-position">
                    {{ $user->position ?? ucfirst($user->role) }}
                </span>
            </div>

        </div>

        {{-- INFO --}}
        <div class="row mt-3 mb-4">
            <div class="col-md-4">
                <div class="info-label">Email</div>
                <div class="info-value">{{ $user->email }}</div>
            </div>
            <div class="col-md-4">
                <div class="info-label">Role</div>
                <div class="info-value">{{ ucfirst($user->role) }}</div>
            </div>
            <div class="col-md-4">
                <div class="info-label">Phone</div>
                <div class="info-value">{{ $user->phone ?? '-' }}</div>
            </div>
        </div>

        {{-- AWARDS --}}
        <div class="mb-4">
            <div class="section-title">
                <i class="bi bi-trophy-fill text-warning"></i>
                Awards
            </div>

            @forelse($user->awards as $award)
                <span class="tag tag-award me-2 mb-2">
                    {{ $award->name }}
                </span>
            @empty
                <span class="text-muted small">No awards</span>
            @endforelse
        </div>

        {{-- EXPERTISE --}}
        <div>
            <div class="section-title">
                <i class="bi bi-stars text-primary"></i>
                Expertise
            </div>

            @foreach(['Academic','Sports','Co-curricular'] as $cat)

                @php
                    $list = $user->expertises->where('category', $cat);
                @endphp

                @if($list->count())
                    <div class="mb-3">
                        <div class="category-label">{{ $cat }}</div>

                        @foreach($list as $exp)
                            <span class="tag tag-exp me-2 mb-2">
                                {{ $exp->name }}
                            </span>
                        @endforeach
                    </div>
                @endif

            @endforeach

        </div>

    </div>

</div>

@endsection