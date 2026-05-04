<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Talent;
use App\Models\User;
use App\Models\TalentSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TalentController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;
        $category = $request->category;
        $level = $request->level;
        $year = $request->year;

        $students = User::query()
            ->where('role', 'student')

            ->when($q, function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%");
            })

            ->when($category || $level || $year, function ($query) use ($category, $level, $year) {
                $query->whereHas('talents', function ($tq) use ($category, $level, $year) {

                    $tq->when($category, fn($q) => $q->where('category', $category));
                    $tq->when($level, fn($q) => $q->where('level', $level));
                    $tq->when($year, fn($q) => $q->whereYear('achieved_at', $year));

                });
            })

            ->withCount([
                'talents as talents_count' => function ($tq) use ($category, $level, $year) {

                    $tq->when($category, fn($q) => $q->where('category', $category));
                    $tq->when($level, fn($q) => $q->where('level', $level));
                    $tq->when($year, fn($q) => $q->whereYear('achieved_at', $year));

                }
            ])

            ->orderByDesc('talents_count')
            ->paginate(10)
            ->withQueryString();

        $categories = [
            'sports' => 'Sports',
            'academics' => 'Academics',
            'co-curricular' => 'Co-curricular',
            'leadership' => 'Leadership',
        ];

        $levels = [
            'school' => 'School',
            'district' => 'District',
            'state' => 'State',
            'national' => 'National',
            'international' => 'International',
        ];

        $years = Talent::query()
            ->selectRaw('YEAR(achieved_at) as y')
            ->whereNotNull('achieved_at')
            ->groupBy('y')
            ->orderByDesc('y')
            ->pluck('y');

        return view('admin.talents.index', compact(
            'students',
            'categories',
            'levels',
            'years'
        ));
    }

    public function create()
    {
        $students = User::where('role', 'student')->orderBy('name')->get(['id','name']);

        $awards = \App\Models\TalentSetting::select('award')->distinct()->pluck('award');

        return view('admin.talents.create', compact('students','awards'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => ['required','exists:users,id'],
            'title' => ['required','string','max:255'],
            'category' => ['nullable','string','max:100'],
            'level' => ['required','string','max:100'], // MUST be required now
            'award' => ['nullable','string'],
            'achieved_at' => ['nullable','date'],
            'description' => ['nullable','string'],
            'proof' => ['nullable','file','mimes:jpg,jpeg,png,pdf','max:4096'],
        ]);

        //VALIDATE STUDENT
        $student = User::findOrFail($request->student_id);
        abort_unless($student->role === 'student', 422);

        //NORMALIZE INPUT (IMPORTANT)
        $level = strtolower($request->level);
        $award = strtolower($request->award);

        //GET POINT BASED ON AWARD + LEVEL
        $setting = TalentSetting::where('award', $award)
            ->where('level', $level)
            ->first();

        $points = $setting ? $setting->points : 0;

        //PREPARE DATA
        $data = [
            'student_id' => $request->student_id,
            'title' => $request->title,
            'category' => $request->category ? ucfirst(strtolower($request->category)) : null,
            'level' => ucfirst($level),
            'award' => $award,
            'points' => $points, 
            'achieved_at' => $request->achieved_at,
            'description' => $request->description,
            'updated_by' => auth()->id(),
        ];

        //HANDLE FILE
        if ($request->hasFile('proof')) {
            $data['proof_path'] = $request->file('proof')
                ->store('talent-proofs', 'public');
        }

        //CREATE TALENT
        Talent::create($data);

        return redirect()->route('admin.talents.index')
            ->with('success', 'Talent added successfully.');
    }

    public function edit(Talent $talent)
    {
        $students = User::where('role', 'student')->orderBy('name')->get(['id','name']);

        $awards = \App\Models\TalentSetting::select('award')->distinct()->pluck('award');

        return view('admin.talents.edit', compact('talent','students','awards'));
    }
    
    public function update(Request $request, Talent $talent)
    {
        $request->validate([
            'student_id' => ['required','exists:users,id'],
            'title' => ['required','string','max:255'],
            'category' => ['nullable','string','max:100'],
            'level' => ['nullable','string','max:100'],
            'award' => ['nullable','string'],
            'achieved_at' => ['nullable','date'],
            'description' => ['nullable','string'],
            'proof' => ['nullable','file','mimes:jpg,jpeg,png,pdf','max:4096'],
            'remove_proof' => ['nullable','boolean'],
        ]);

        $student = User::findOrFail($request->student_id);
        abort_unless($student->role === 'student', 422);

        $setting = TalentSetting::where('award', $request->award)->first();

        $data = $request->only([
            'student_id','title','category','level','achieved_at','description','award'
        ]);

        $data['points'] = $setting->points ?? 0;
        $data['updated_by'] = auth()->id(); 

        // remove proof
        if ($request->boolean('remove_proof') && $talent->proof_path) {
            Storage::disk('public')->delete($talent->proof_path);
            $data['proof_path'] = null;
        }

        // replace proof
        if ($request->hasFile('proof')) {
            if ($talent->proof_path) {
                Storage::disk('public')->delete($talent->proof_path);
            }
            $data['proof_path'] = $request->file('proof')
                ->store('talent-proofs', 'public');
        }

        $data['category'] = ucfirst(strtolower($data['category']));
        $data['level'] = ucfirst(strtolower($data['level']));

        $talent->update($data);

        return redirect()->route('admin.talents.index')
            ->with('success', 'Talent updated successfully.');
    }

    public function destroy(Talent $talent)
    {
        if ($talent->proof_path) {
            Storage::disk('public')->delete($talent->proof_path);
        }

        $talent->delete();

        return redirect()->route('admin.talents.index')
            ->with('success', 'Talent deleted successfully.');
    }

    public function studentTalents(Request $request, User $student)
    {
        abort_unless($student->role === 'student', 404);

        $category = $request->category;
        $level = $request->level;
        $year = $request->year;

        $talents = Talent::query()
            ->where('student_id', $student->id)
            ->with('teacher') 
            ->when($category, fn($q) => $q->where('category', $category))
            ->when($level, fn($q) => $q->where('level', $level))
            ->when($year, fn($q) => $q->whereYear('achieved_at', $year))
            ->latest()
            ->get();

        return view('admin.talents._student_modal', compact('student', 'talents'));
    }
}