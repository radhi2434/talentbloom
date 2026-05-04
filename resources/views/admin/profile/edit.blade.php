@extends('admin.layouts.app')

@section('title', 'My Profile')

@section('content')

<style>
.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.profile-avatar {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #e9ecef;
}

.section-title {
    font-weight: 600;
    font-size: 14px;
    color: #6c757d;
}

.btn {
    border-radius: 8px;
}
</style>

<div class="container">

    {{-- HEADER --}}
    <div class="mb-4">
        <h4 class="fw-semibold d-flex align-items-center gap-2">
            <i class="bi bi-person-circle"></i>
            My Profile
        </h4>
        <small class="text-muted">Manage your account information</small>
    </div>

    @if(session('success'))
        <div class="alert alert-success small">
            {{ session('success') }}
        </div>
    @endif


    {{-- ================= PROFILE CARD ================= --}}
    <div class="card mb-4">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-3">

            {{-- LEFT (AVATAR + NAME) --}}
            <div class="d-flex align-items-center gap-3">

                <img
                    src="{{ auth()->user()->profile_photo
                            ? asset('storage/' . auth()->user()->profile_photo)
                            : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=0D6EFD&color=fff' }}"
                    class="profile-avatar"
                >

                <div>
                    <div class="fw-semibold">{{ auth()->user()->name }}</div>
                    <small class="text-muted">{{ auth()->user()->email }}</small>
                </div>

            </div>

            {{-- RIGHT (UPLOAD) --}}
            <form method="POST"
                  action="{{ route('admin.profile.photo') }}"
                  enctype="multipart/form-data"
                  class="d-flex align-items-center gap-2">

                @csrf

                <input type="file"
                       name="photo"
                       class="form-control form-control-sm"
                       accept="image/png,image/jpeg"
                       required>

                <button class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-upload"></i>
                </button>

            </form>

        </div>
    </div>


    {{-- ================= PROFILE FORM ================= --}}
    <div class="card mb-4">
        <div class="card-body">

            <div class="section-title mb-3">Profile Information</div>

            <form method="POST" action="{{ route('admin.profile.update') }}">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name</label>
                        <input class="form-control"
                               name="name"
                               value="{{ old('name', auth()->user()->name) }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email Address</label>
                        <input class="form-control"
                               name="email"
                               value="{{ old('email', auth()->user()->email) }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input class="form-control"
                               name="phone"
                               value="{{ old('phone', auth()->user()->phone) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Position</label>
                        <input class="form-control"
                               name="position"
                               value="{{ old('position', auth()->user()->position) }}"
                               placeholder="Principal / Admin / Coordinator">
                    </div>

                </div>

                <div class="text-end">
                    <button class="btn btn-dark px-4">
                        Save Profile
                    </button>
                </div>

            </form>
        </div>
    </div>


    {{-- ================= PASSWORD ================= --}}
    <div class="card">
        <div class="card-body">

            <div class="section-title mb-3">Change Password</div>

            <form method="POST" action="{{ route('admin.profile.password') }}">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">New Password</label>
                        <input class="form-control"
                               type="password"
                               name="password"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input class="form-control"
                               type="password"
                               name="password_confirmation"
                               required>
                    </div>

                </div>

                <div class="text-end">
                    <button class="btn btn-warning px-4">
                        Update Password
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>

@endsection