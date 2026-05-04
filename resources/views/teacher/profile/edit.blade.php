@extends('teacher.layouts.app')

@section('title', 'My Profile')

@section('content')

<div class="container py-4">

    {{-- 🔥 TITLE --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold d-flex align-items-center gap-2">
            <i class="bi bi-person-circle"></i>
            My Profile
        </h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @php
        $user = auth()->user();
        $photo = $user->profile_photo
            ? asset('storage/'.$user->profile_photo)
            : null;
    @endphp

    {{-- ================= HEADER CARD ================= --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body d-flex align-items-center gap-4">

            {{-- AVATAR --}}
            @if($photo)
                <img src="{{ $photo }}" class="avatar-lg">
            @else
                <div class="avatar-placeholder">
                    {{ strtoupper(substr($user->name,0,1)) }}
                </div>
            @endif

            {{-- INFO --}}
            <div>
                <h4 class="mb-1 fw-bold">{{ $user->name }}</h4>
                <div class="text-muted small">{{ $user->email }}</div>
                <div class="badge bg-light text-dark border mt-2">
                    {{ $user->position }}
                </div>
            </div>

        </div>
    </div>


    {{-- ================= PROFILE INFO ================= --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">

            <h5 class="section-title">Profile Information</h5>

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="label">Full Name</label>
                        <input class="form-control" value="{{ $user->name }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="label">Email</label>
                        <input class="form-control" value="{{ $user->email }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="label">Position</label>
                        <input class="form-control" value="{{ $user->position }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="label">Phone Number</label>
                        <input type="text" name="phone" class="form-control"
                               value="{{ $user->phone }}">
                    </div>

                </div>

                <div class="text-end mt-3">
                    <button class="btn btn-theme px-4">
                        Update Profile
                    </button>
                </div>

            </form>

        </div>
    </div>


    {{-- ================= PHOTO ================= --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">

            <h5 class="section-title">Profile Photo</h5>

            <form method="POST"
                  action="{{ route('profile.photo') }}"
                  enctype="multipart/form-data">
                @csrf

                <div class="d-flex gap-2">
                    <input type="file" name="photo" class="form-control" required>
                    <button class="btn btn-theme">
                        Upload
                    </button>
                </div>

                <small class="text-muted">jpg, png (max 2MB)</small>

            </form>

        </div>
    </div>


    {{-- ================= AWARDS ================= --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">

            <h5 class="section-title">Awards</h5>

            <div class="mb-2">
                @forelse($user->awards as $award)
                    <span class="chip chip-success">
                        {{ $award->name }}
                        <a href="{{ route('profile.award.delete', $award->id) }}">×</a>
                    </span>
                @empty
                    <small class="text-muted">No awards yet</small>
                @endforelse
            </div>

            <form method="POST" action="{{ route('profile.award.add') }}">
                @csrf

                <div class="d-flex gap-2">
                    <input name="award" class="form-control"
                           placeholder="Add award..." required>

                    <button class="btn btn-theme">Add</button>
                </div>
            </form>

        </div>
    </div>


    {{-- ================= EXPERTISE ================= --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">

            <h5 class="section-title">Expertise</h5>

            @foreach(['Academic','Sports','Co-curricular'] as $cat)

                <div class="mb-3">

                    <div class="fw-semibold mb-2">{{ $cat }}</div>

                    <div class="mb-2">
                        @forelse(($user->expertises ?? collect())->where('category',$cat) as $exp)
                            <span class="chip chip-primary">
                                {{ $exp->name }}
                                <a href="{{ route('profile.expertise.delete', $exp->id) }}">×</a>
                            </span>
                        @empty
                            <small class="text-muted">No data</small>
                        @endforelse
                    </div>

                    <form method="POST" action="{{ route('profile.expertise.add') }}">
                        @csrf
                        <input type="hidden" name="category" value="{{ $cat }}">

                        <div class="d-flex gap-2">
                            <input name="name" class="form-control"
                                   placeholder="Add {{ $cat }}" required>

                            <button class="btn btn-outline-theme">Add</button>
                        </div>
                    </form>

                </div>

            @endforeach

        </div>
    </div>


    {{-- ================= PASSWORD ================= --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <h5 class="section-title">Change Password</h5>

            <form method="POST" action="{{ route('profile.password') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="label">New Password</label>
                    <input type="password" name="password"
                           class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="label">Confirm Password</label>
                    <input type="password"
                           name="password_confirmation"
                           class="form-control" required>
                </div>

                <div class="text-end">
                    <button class="btn btn-theme">
                        Update Password
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>


{{-- 🔥 STYLE --}}
<style>
.section-title {
    font-weight: 600;
    margin-bottom: 15px;
}

.avatar-lg {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    object-fit: cover;
}

.avatar-placeholder {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: #0d3b66;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
}

.chip {
    display: inline-flex;
    align-items: center;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    margin: 3px;
}
.chip a {
    margin-left: 6px;
    text-decoration: none;
    color: inherit;
}

.chip-success {
    background: #e6f4ea;
    color: #1e7e34;
}

.chip-primary {
    background: #e7f1ff;
    color: #0d3b66;
}

.btn-theme {
    background: #0d3b66;
    color: #fff;
    border: none;
}
.btn-theme:hover {
    background: #0b3154;
    color: #fff;
}

.btn-outline-theme {
    border: 1px solid #0d3b66;
    color: #0d3b66;
}
.btn-outline-theme:hover {
    background: #0d3b66;
    color: #fff;
}
</style>

@endsection