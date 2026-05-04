@extends('teacher.layouts.app')
@section('title','Edit Talent')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Edit Talent</h3>
    <a href="{{ route('teacher.talents.index') }}" class="btn btn-outline-secondary">Back</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form method="POST" action="{{ route('teacher.talents.update', $talent->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('teacher.talents._form', ['talent' => $talent])

            <button class="btn btn-warning">Update Talent</button>
        </form>
    </div>
</div>
@endsection
