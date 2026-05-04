{{-- 🔥 STUDENT INFO --}}
<div class="mb-3">
    <div class="p-3 rounded border bg-light d-flex justify-content-between align-items-center">

        <div>
            <div class="fw-semibold">{{ $student->name }}</div>
            <small class="text-muted">
                Total Talents (Filtered):
                <span class="fw-semibold">{{ $talents->count() }}</span>
            </small>
        </div>

        <div>
            <span class="badge bg-primary rounded-pill px-3 py-2">
                {{ $talents->count() }} Records
            </span>
        </div>

    </div>
</div>


{{-- TABLE --}}
<div class="table-responsive">
    <table class="table table-striped align-middle mb-0">

        <thead class="table-light">
        <tr>
            <th>Title</th>
            <th>Category</th>
            <th>Level</th>
            <th>Award</th>
            <th>Points</th>
            <th>Teacher</th>
            <th>Date</th>
            <th>Updated</th>
            <th class="text-end">Actions</th>
        </tr>
        </thead>

        <tbody>

        @forelse($talents as $t)

            <tr>
                <td class="fw-semibold">{{ $t->title }}</td>

                <td>
                    <span class="badge bg-light text-dark border">
                        {{ ucfirst($t->category ?? '-') }}
                    </span>
                </td>

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
                                'gold' => 'bg-warning text-dark',
                                'silver' => 'bg-secondary',
                                'bronze' => 'bg-danger',
                                'participation' => 'bg-dark',
                                default => 'bg-secondary'
                            };
                        @endphp

                        <span class="badge {{ $color }}">
                            {{ ucfirst($t->award) }}
                        </span>
                    @else
                        -
                    @endif
                </td>

                {{-- POINTS --}}
                <td>
                    <span class="badge bg-primary">
                        {{ $t->points ?? 0 }} pts
                    </span>
                </td>

                {{-- TEACHER --}}
                <td>
                    @if($t->teacher)
                        <a href="{{ route('admin.teachers.show', $t->teacher) }}"
                           class="text-decoration-none">
                            {{ $t->teacher->name }}
                        </a>
                    @else
                        -
                    @endif
                </td>

                {{-- DATE --}}
                <td>{{ $t->achieved_at?->format('d M Y') ?? '-' }}</td>

                {{-- UPDATED --}}
                <td>{{ $t->updated_at?->format('d M Y') ?? '-' }}</td>

                {{-- ACTION (🔥 ICON STYLE SAME MACAM PAGE LAIN) --}}
                <td class="text-end">

                    <div class="d-inline-flex gap-2">

                        <a class="btn btn-sm btn-edit"
                           href="{{ route('admin.talents.edit', $t) }}">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <form method="POST"
                              action="{{ route('admin.talents.destroy', $t) }}"
                              onsubmit="return confirm('Delete this talent?')">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>

                    </div>

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