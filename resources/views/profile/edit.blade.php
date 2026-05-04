@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container">
    <h3 class="mb-4">My Profile</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ================= PROFILE PHOTO ================= --}}
    <div class="card mb-4">
        <div class="card-body d-flex align-items-center gap-4">

            {{-- Avatar --}}
            <img
                src="{{ auth()->user()->profile_photo
                        ? asset('storage/' . auth()->user()->profile_photo)
                        : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=6c757d&color=fff' }}"
                alt="Profile Photo"
                style="width:90px;height:90px;border-radius:50%;object-fit:cover;"
            >

            {{-- Upload Photo --}}
            <form method="POST"
                  action="{{ route('profile.photo') }}"
                  enctype="multipart/form-data">
                @csrf

                <div class="mb-2">
                    <input type="file"
                           name="photo"
                           class="form-control"
                           accept="image/png,image/jpeg"
                           required>
                </div>

                <button class="btn btn-outline-primary btn-sm">
                    Upload / Change Photo
                </button>
            </form>

        </div>
    </div>

    {{-- ================= PROFILE INFO ================= --}}
    <div class="card mb-4">
        <div class="card-body">

            {{-- READ ONLY --}}
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input class="form-control" value="{{ auth()->user()->name }}" disabled>
                <small class="text-muted">Full name cannot be changed</small>
            </div>

            <div class="mb-3">
                <label class="form-label">IC Number</label>
                <input class="form-control" value="{{ auth()->user()->ic_number }}" disabled>
                <small class="text-muted">IC number cannot be changed</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input class="form-control" value="{{ auth()->user()->email }}" disabled>
                <small class="text-muted">Email cannot be changed</small>
            </div>

            {{-- EDITABLE --}}
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input class="form-control"
                           name="phone"
                           value="{{ old('phone', auth()->user()->phone) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <textarea class="form-control"
                              name="address"
                              rows="2">{{ old('address', auth()->user()->address) }}</textarea>
                </div>

                <button class="btn btn-primary">Save Profile</button>
            </form>
        </div>
    </div>

    {{-- ================= CHANGE PASSWORD ================= --}}
    <div class="card">
        <div class="card-body">
            <h5 class="mb-3">Change Password</h5>

            <form method="POST" action="{{ route('profile.password') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input class="form-control" type="password" name="password" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input class="form-control" type="password" name="password_confirmation" required>
                </div>

                <button class="btn btn-warning">
                    Update Password
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
