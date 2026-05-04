<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Talent;
use Illuminate\Support\Facades\Auth;

class AchievementController extends Controller
{
    public function index(Request $request)
    {
        $student = Auth::user();

        // ===== SUMMARY COUNTS (REAL DATABASE) =====
        $counts = Talent::where('student_id', $student->id)
            ->selectRaw("
                SUM(category = 'Academic') as academic,
                SUM(category = 'Sports') as sports,
                SUM(category = 'Leadership') as leadership,
                SUM(category = 'Co-curricular') as cocurricular
            ")
            ->first();

        // ===== FILTERING =====
        $query = Talent::where('student_id', $student->id);

        if ($request->category && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->level && $request->level !== 'all') {
            $query->where('level', $request->level);
        }

        if ($request->year && $request->year !== 'all') {
            $query->whereYear('achieved_at', $request->year);
        }

        if ($request->q) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        $talents = $query->latest()->paginate(6)->withQueryString();

        return view('student.achievements.index', compact(
            'counts',
            'talents'
        ));
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
