@forelse($achievements as $t)
<div class="border rounded p-3 mb-2">

    <strong>{{ $t->title }}</strong><br>

    <small class="text-muted">
        {{ $t->category }} | {{ $t->level }}
    </small>

</div>
@empty
<div class="text-muted">No achievements found</div>
@endforelse