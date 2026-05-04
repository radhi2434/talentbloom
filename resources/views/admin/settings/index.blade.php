@extends('admin.layouts.app')

@section('content')

<style>
.card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.card-header {
    background: #f8f9fc !important;
    font-weight: 600;
    border-bottom: 1px solid #eee;
}

.badge {
    font-size: 12px;
    padding: 6px 8px;
}
</style>

<div class="container mt-4">

    {{-- HEADER --}}
    <div class="mb-4">
        <h4 class="fw-semibold d-flex align-items-center gap-2">
            <i class="bi bi-gear"></i>
            System Settings
        </h4>
        <small class="text-muted">Manage system configuration</small>
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success small">
            {{ session('success') }}
        </div>
    @endif


    {{-- ================= TOP GRID ================= --}}
    <div class="row g-4">

        {{-- CLASSES --}}
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">Classes</div>

                <div class="card-body">

                    <form method="POST" action="{{ route('admin.settings.class.store') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" name="name" class="form-control" placeholder="Class name">
                            <button class="btn btn-primary btn-sm">Add</button>
                        </div>
                    </form>

                    <table class="table table-sm">
                        @foreach($classes as $class)
                        <tr>
                            <td width="30">{{ $loop->iteration }}</td>
                            <td>{{ $class->name }}</td>
                            <td class="text-end">
                                <form method="POST" action="{{ route('admin.settings.class.delete',$class->id) }}">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>

                </div>
            </div>
        </div>


        {{-- FORMS --}}
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">Forms</div>

                <div class="card-body">

                    <form method="POST" action="{{ route('admin.settings.form.store') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="number" name="form_number" class="form-control" placeholder="Form number">
                            <button class="btn btn-primary btn-sm">Add</button>
                        </div>
                    </form>

                    <table class="table table-sm">
                        @foreach($forms as $form)
                        <tr>
                            <td width="30">{{ $loop->iteration }}</td>
                            <td>Form {{ $form->form_number }}</td>
                            <td class="text-end">
                                <form method="POST" action="{{ route('admin.settings.form.delete',$form->id) }}">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>

                </div>
            </div>
        </div>


        {{-- POSITIONS --}}
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">Positions</div>

                <div class="card-body">

                    <form method="POST" action="{{ route('admin.settings.position.store') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" name="name" class="form-control" placeholder="Position">
                            <button class="btn btn-primary btn-sm">Add</button>
                        </div>
                    </form>

                    <table class="table table-sm">
                        @foreach($positions as $position)
                        <tr>
                            <td width="30">{{ $loop->iteration }}</td>
                            <td>{{ $position->name }}</td>
                            <td class="text-end">
                                <form method="POST" action="{{ route('admin.settings.position.delete',$position->id) }}">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>

                </div>
            </div>
        </div>

    </div>


    {{-- ================= AWARD ================= --}}
    <div class="row mt-4 g-4">

        {{-- AWARD CATEGORY --}}
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">Award Categories</div>

                <div class="card-body">

                    <form method="POST" action="{{ route('admin.settings.award.category.store') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" name="name" class="form-control" placeholder="Gold, Silver..." required>
                            <button class="btn btn-success btn-sm">Add</button>
                        </div>
                    </form>

                    <table class="table table-sm text-center">
                        @foreach($awardCategories as $a)
                        <tr>
                            <td width="30">{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ ucfirst($a->name) }}</td>
                            <td class="text-end">
                                <form method="POST" action="{{ route('admin.settings.award.category.delete',$a->id) }}">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>

                </div>
            </div>
        </div>


        {{-- AWARD POINTS --}}
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Award Points</span>

                    <button class="btn btn-sm btn-outline-primary"
                            data-bs-toggle="collapse"
                            data-bs-target="#addAward">
                        + Add
                    </button>
                </div>

                <div class="card-body">

                    {{-- ADD --}}
                    <div id="addAward" class="collapse mb-3">
                        <form method="POST" action="{{ route('admin.settings.award.store') }}">
                            @csrf

                            <div class="row g-2">
                                <div class="col-md-4">
                                    <select name="award" class="form-select">
                                        <option>Award</option>
                                        @foreach($awardCategories as $a)
                                            <option value="{{ strtolower($a->name) }}">
                                                {{ ucfirst($a->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <select name="level" class="form-select">
                                        <option>Level</option>
                                        <option value="school">School</option>
                                        <option value="district">District</option>
                                        <option value="state">State</option>
                                        <option value="national">National</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <input type="number" name="points" class="form-control" placeholder="Points">
                                </div>
                            </div>

                            <button class="btn btn-success btn-sm mt-2 w-100">
                                Save Setting
                            </button>
                        </form>
                    </div>


                    {{-- LIST (ALIGN FIXED) --}}
                    @foreach($settings as $s)

                    <div class="d-flex align-items-center justify-content-between border rounded px-3 py-2 mb-2">

                        {{-- LEFT --}}
                        <div class="d-flex align-items-center gap-2" style="min-width:220px;">
                            
                            <span class="badge bg-warning text-dark text-center"
                                  style="width:90px;">
                                {{ ucfirst($s->award) }}
                            </span>

                            <span class="badge bg-secondary text-center"
                                  style="width:110px;">
                                {{ strtoupper($s->level) }}
                            </span>

                        </div>

                        {{-- RIGHT --}}
                        <div class="d-flex align-items-center gap-2">

                            <form method="POST"
                                  action="{{ route('admin.settings.award.update',$s->id) }}"
                                  class="d-flex align-items-center gap-2">
                                @csrf @method('PUT')

                                <input type="number"
                                       name="points"
                                       value="{{ $s->points }}"
                                       class="form-control form-control-sm text-center"
                                       style="width:70px; height:32px;">

                                <button class="btn btn-success btn-sm px-2">
                                    <i class="bi bi-check"></i>
                                </button>
                            </form>

                            <form method="POST"
                                  action="{{ route('admin.settings.award.delete',$s->id) }}">
                                @csrf @method('DELETE')

                                <button class="btn btn-outline-danger btn-sm px-2">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>

                        </div>

                    </div>

                    @endforeach

                </div>
            </div>
        </div>

    </div>

</div>

@endsection