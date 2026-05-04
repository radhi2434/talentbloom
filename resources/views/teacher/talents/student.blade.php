@extends('teacher.layouts.app')
@section('title','Student Talents')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h3 class="mb-0">{{ $student->name }}</h3>
        <div class="text-muted small">Talents list</div>
    </div>

    <a href="{{ route('teacher.talents.index') }}" class="btn btn-outline-dark btn-sm">
        Back
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-sm align-middle">
            <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th style="width:180px;">Category</th>
                    <th style="width:120px;">Year</th>
                </tr>
            </thead>
            <tbody>
            @forelse($talents as $t)
                <tr>
                    <td>{{ $t->title }}</td>
                    <td>{{ $t->category }}</td>
                    <td>{{ $t->year ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center text-muted py-4">No talents yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
