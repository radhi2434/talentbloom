@extends(auth()->user()->role === 'admin' ? 'admin.layouts.app' :(auth()->user()->role === 'teacher' ? 'teacher.layouts.app' : 'student.layouts.app'))

@section('title', 'My Profile')

@section('content')
<div class="container">
    <h3 class="mb-4">My Profile</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- PHOTO --}}
    <div class="card mb-4">
        <div class="card-body d-flex align-items-center gap-4">

            @php
                $u = auth()->user();
                $photo = $u->profile_photo ? asset('storage/'.$u->profile_photo) : null;
                $fullClass = trim(($u->form ?? '') . ' ' . ($u->class_name ?? ''));
            @endphp

            <div>
                @if($photo)
                    <img src="{{ $photo }}" alt="Profile photo"
                         class="rounded-circle border"
                         style="width:90px;height:90px;object-fit:cover;">
                @else
                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                         style="width:90px;height:90px;font-size:28px;">
                        {{ strtoupper(substr($u->name,0,2)) }}
                    </div>
                @endif
            </div>

            <div class="flex-grow-1">
                <form method="POST" action="{{ route('profile.photo') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-2 align-items-center">
                        <div class="col-md-6">
                            <input type="file" name="photo" class="form-control" accept="image/*" required>
                            @error('photo')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-auto">
                            <button class="btn btn-outline-primary">Upload / Change Photo</button>
                        </div>
                    </div>
                </form>
                <div class="small text-muted mt-2">Allowed: jpg, png, webp. Max 2MB.</div>
            </div>
        </div>
    </div>

    {{-- PROFILE INFO --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input class="form-control" value="{{ $u->name }}" disabled>
                    <div class="form-text">Full name cannot be changed</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input class="form-control" value="{{ $u->email }}" disabled>
                    <div class="form-text">Email cannot be changed</div>
                </div>

                {{-- ✅ FIXED CLASS DISPLAY --}}
                <div class="mb-3">
                    <label class="form-label">Class</label>
                    <input class="form-control"
                        value="{{ $fullClass ?: 'No class assigned' }}"
                        disabled>
                    <div class="form-text">Class cannot be changed</div>
                </div>

                <button class="btn btn-primary">Save Profile</button>
            </form>
        </div>
    </div>

    {{-- CHANGE PASSWORD --}}
    <div class="card">
        <div class="card-body">
            <h5 class="mb-3">Change Password</h5>

            <form method="POST" action="{{ route('profile.password') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input class="form-control" type="password" name="password" required>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input class="form-control" type="password" name="password_confirmation" required>
                </div>

                <button class="btn btn-warning">Update Password</button>
            </form>
        </div>
    </div>

</div>
@endsection