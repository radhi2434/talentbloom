<div class="card border-0 shadow-sm mb-3">
    <div class="card-body d-flex justify-content-between align-items-center">

        <div>
            <div class="text-muted small">Student</div>
            <div class="fw-bold fs-6">{{ $student->name }}</div>
        </div>

        <div class="text-end">
            <div class="text-muted small">Total Talents</div>
            <div class="fw-bold fs-5">{{ $talents->count() }}</div>
        </div>

    </div>
</div>

<div class="table-responsive">
    <table class="table align-middle custom-table">

        <thead>
        <tr>
            <th>Title</th>
            <th>Category</th>
            <th>Level</th>
            <th>Award</th> 
            <th class="text-center">Points</th> 
            <th>Teacher</th> 
            <th>Date</th>
            <th>Updated</th> 
            <th class="text-center">Actions</th>
        </tr>
        </thead>

        <tbody>

        @forelse($talents as $t)

            <tr>

                {{-- TITLE --}}
                <td class="fw-semibold">
                    {{ $t->title }}
                </td>

                {{-- CATEGORY --}}
                <td>
                    <span class="badge bg-light text-dark border">
                        {{ ucfirst($t->category ?? '-') }}
                    </span>
                </td>

                {{-- LEVEL --}}
                <td>
                    <span class="badge bg-light text-dark border">
                        {{ ucfirst($t->level ?? '-') }}
                    </span>
                </td>

                {{-- AWARD --}}
                <td>
                    @if($t->award)

                        @php
                            $color = match(strtolower($t->award)) {
                                'gold' => 'badge-award gold',
                                'silver' => 'badge-award silver',
                                'bronze' => 'badge-award bronze',
                                'participation' => 'badge-award participation',
                                default => 'badge-award'
                            };
                        @endphp

                        <span class="{{ $color }}">
                            {{ ucfirst($t->award) }}
                        </span>

                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>

                {{-- POINTS --}}
                <td class="text-center">
                    <span class="points-badge">
                        {{ $t->points ?? 0 }}
                    </span>
                </td>

                {{-- TEACHER --}}
                <td>
                    @if($t->updater)
                        <a href="{{ route('user.profile.show', $t->updater->id) }}"
                           class="fw-semibold text-decoration-none text-primary">
                            {{ $t->updater->name }}
                        </a>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>

                {{-- DATE --}}
                <td>
                    {{ $t->achieved_at?->format('d M Y') ?? '-' }}
                </td>

                {{-- UPDATED --}}
                <td class="text-muted small">
                    {{ $t->updated_at?->format('d M Y') ?? '-' }}
                </td>

                {{-- ACTION --}}
                <td class="text-center">

                    <a class="icon-btn edit"
                       href="{{ route('teacher.talents.edit', $t->id) }}">
                        <i class="bi bi-pencil"></i>
                    </a>

                    <form class="d-inline"
                          method="POST"
                          action="{{ route('teacher.talents.destroy', $t->id) }}"
                          onsubmit="return confirm('Delete this talent?')">
                        @csrf
                        @method('DELETE')

                        <button class="icon-btn delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="9" class="text-center text-muted py-4">
                    No talents found
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>
</div>


{{-- STYLE --}}
<style>
/* table clean look */
.custom-table thead {
    background: #f8f9fa;
}
.custom-table th {
    font-size: 13px;
    color: #6c757d;
    font-weight: 600;
}
.custom-table tbody tr:hover {
    background: #f5f8fc;
}

/* award badges */
.badge-award {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    background: #e9ecef;
}

.badge-award.gold {
    background: #fff3cd;
    color: #856404;
}
.badge-award.silver {
    background: #e2e3e5;
    color: #383d41;
}
.badge-award.bronze {
    background: #f8d7da;
    color: #721c24;
}
.badge-award.participation {
    background: #d1ecf1;
    color: #0c5460;
}

/* points */
.points-badge {
    background: #0d3b66;
    color: #fff;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
}

/* icon buttons */
.icon-btn {
    border: none;
    padding: 6px 10px;
    border-radius: 8px;
    margin: 0 2px;
}

.icon-btn.edit {
    background: #fff3cd;
    color: #856404;
}
.icon-btn.edit:hover {
    background: #ffc107;
    color: #000;
}

.icon-btn.delete {
    background: #f8d7da;
    color: #721c24;
}
.icon-btn.delete:hover {
    background: #dc3545;
    color: #fff;
}
</style>