<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Talent;
use App\Models\Award;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherTalentController extends Controller
{
    public function index(Request $request)
    {
        $categories = [
            'Sports' => 'Sports',
            'Academic' => 'Academic',
            'Leadership' => 'Leadership',
            'Co-curricular' => 'Co-curricular',
        ];

        $levels = [
            'School' => 'School',
            'District' => 'District',
            'State' => 'State',
            'National' => 'National',
        ];

        $years = Talent::whereNotNull('achieved_at')
            ->selectRaw('YEAR(achieved_at) as y')
            ->distinct()
            ->orderByDesc('y')
            ->pluck('y')
            ->values();

        if ($years->isEmpty()) {
            $years = collect(range(date('Y'), date('Y') - 5));
        }

        $students = User::where('role', 'student')
            ->when($request->filled('q'), function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->q . '%');
            })
            ->withCount(['talents as talents_count' => function ($q) use ($request) {

                if ($request->filled('category')) {
                    $q->where('category', $request->category);
                }

                if ($request->filled('level')) {
                    $q->where('level', $request->level);
                }

                if ($request->filled('year')) {
                    $q->whereYear('achieved_at', $request->year);
                }
            }])
            ->orderByDesc('talents_count')
            ->paginate(10)
            ->appends($request->query());

        return view('teacher.talents.index', compact('students', 'categories', 'levels', 'years'));
    }

    // ✅ STUDENT TALENTS (MODAL)
    public function studentTalents(Request $request, User $student)
    {
        $talents = Talent::with('updater') 
            ->where('student_id', $student->id)
            ->when($request->filled('category'), fn($q) => $q->where('category', $request->category))
            ->when($request->filled('level'), fn($q) => $q->where('level', $request->level))
            ->when($request->filled('year'), fn($q) => $q->whereYear('achieved_at', $request->year))
            ->orderByDesc('achieved_at')
            ->get();

        $total = $talents->count();

        return view('teacher.talents._student_talents', compact('student', 'talents', 'total'));
    }

    // ✅ CREATE
    public function create()
    {
        $students = User::where('role', 'student')->orderBy('name')->get();
        $awards = Award::orderBy('id')->get();

        return view('teacher.talents.create', compact('students', 'awards'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => ['required','exists:users,id'],
            'title'      => ['required','string','max:255'],
            'category'   => ['required','string','max:50'],
            'level'      => ['required','string','max:50'],
            'award'      => ['nullable','in:gold,silver,bronze'],
            'achieved_at'=> ['nullable','date'],
            'description'=> ['nullable','string'],
            'proof'      => ['nullable','file','mimes:jpg,jpeg,png,pdf','max:2048'],
        ]);

        if ($request->hasFile('proof')) {
            $data['proof_path'] = $request->file('proof')->store('proofs', 'public');
        }

        $data['category'] = ucfirst(strtolower($data['category']));
        $data['level'] = ucfirst(strtolower($data['level']));

        // 🔥 ADD THIS
        $data['updated_by'] = auth()->id();

        Talent::create($data);

        return redirect()->route('teacher.talents.index')
            ->with('success', 'Talent created successfully.');
    }

    // ✅ EDIT
    public function edit(Talent $talent)
    {
        $students = User::where('role', 'student')->orderBy('name')->get();
        return view('teacher.talents.edit', compact('talent', 'students'));
    }

    public function update(Request $request, Talent $talent)
    {
        $data = $request->validate([
            'student_id' => ['required','exists:users,id'],
            'title'      => ['required','string','max:255'],
            'category'   => ['required','string','max:50'],
            'level'      => ['required','string','max:50'],
            'award'      => ['nullable','in:gold,silver,bronze'],
            'achieved_at'=> ['nullable','date'],
            'description'=> ['nullable','string'],
            'proof'      => ['nullable','file','mimes:jpg,jpeg,png,pdf','max:2048'],
        ]);

        if ($request->hasFile('proof')) {
            if ($talent->proof_path) {
                Storage::disk('public')->delete($talent->proof_path);
            }
            $data['proof_path'] = $request->file('proof')->store('proofs', 'public');
        }

        $data['category'] = ucfirst(strtolower($data['category']));
        $data['level'] = ucfirst(strtolower($data['level']));

        $data['updated_by'] = auth()->id();

        $talent->update($data);

        return redirect()->route('teacher.talents.index')
            ->with('success', 'Talent updated successfully.');
    }

    public function destroy(Talent $talent)
    {
        if ($talent->proof_path) {
            Storage::disk('public')->delete($talent->proof_path);
        }

        $talent->delete();

        return back()->with('success', 'Talent deleted successfully.');
    }
}