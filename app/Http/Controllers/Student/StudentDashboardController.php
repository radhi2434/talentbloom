<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Talent;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $student = Auth::user();

        // ===== TOTAL ACHIEVEMENTS =====
        $totalAchievements = Talent::where('student_id', $student->id)->count();

        // ===== TOP ACHIEVEMENT (SORT BY LEVEL PRIORITY) =====
        $topAchievement = Talent::where('student_id', $student->id)
            ->orderByRaw("
                FIELD(level, 'National', 'State', 'District', 'School')
            ")
            ->first();

        // ===== CATEGORY COUNTS =====
        $counts = Talent::where('student_id', $student->id)
            ->selectRaw("
                SUM(LOWER(category) IN ('academic','academics')) as academic,
                SUM(LOWER(category) IN ('sports','sport')) as sports,
                SUM(LOWER(category) = 'leadership') as leadership,
                SUM(LOWER(category) IN ('co-curricular','co curricular','cocurricular')) as cocurricular
            ")
            ->first();

        // ===== GET ALL TALENTS =====
        $talents = Talent::where('student_id', $student->id)->get();

        // ===== BADGES BY CATEGORY =====
        $badgesByCategory = [
            'academic' => [],
            'sports' => [],
            'leadership' => [],
            'cocurricular' => [],
        ];

        foreach ($talents as $t) {
            $cat = strtolower($t->category);

            if ($cat === 'academics') $cat = 'academic';
            if ($cat === 'co-curricular') $cat = 'cocurricular';
            if ($cat === 'co curricular') $cat = 'cocurricular';

            if (!isset($badgesByCategory[$cat])) continue;

            $level = ucfirst(strtolower($t->level));

            if (!in_array($level, $badgesByCategory[$cat])) {
                $badgesByCategory[$cat][] = $level;
            }
        }

        // ===== SORT BADGES (PRIORITY) =====
        $priority = ['National', 'State', 'District', 'School'];

        foreach ($badgesByCategory as $cat => $levels) {
            usort($levels, function ($a, $b) use ($priority) {
                return array_search($a, $priority) <=> array_search($b, $priority);
            });

            $badgesByCategory[$cat] = $levels;
        }

        // ===== CLASS RANKING =====
        $ranking = \App\Models\User::where('role', 'student')
            ->withCount('talents')
            ->orderByDesc('talents_count')
            ->get()
            ->search(fn($u) => $u->id === $student->id) + 1;

        // ===== RETURN =====
        return view('student.dashboard', compact(
            'totalAchievements',
            'counts',
            'ranking',
            'topAchievement',
            'badgesByCategory'
        ));
    }

    public function achievementList(Request $request)
    {
        $studentId = auth()->id();

        $query = \App\Models\Talent::where('student_id', $studentId);

        // ===============================
        // CATEGORY FILTER (FIXED)
        // ===============================
        if ($request->filled('category')) {

            $category = strtolower($request->category);

            $query->where(function ($q) use ($category) {

                if ($category === 'academic') {
                    $q->whereRaw("LOWER(category) IN ('academic','academics')");
                }

                elseif ($category === 'sports') {
                    $q->whereRaw("LOWER(category) IN ('sports','sport')");
                }

                elseif ($category === 'leadership') {
                    $q->whereRaw("LOWER(category) = 'leadership'");
                }

                elseif ($category === 'cocurricular') {
                    $q->whereRaw("LOWER(category) IN ('co-curricular','co curricular','cocurricular')");
                }

            });
        }

        // ===============================
        // LEVEL FILTER (BADGE CLICK)
        // ===============================
        if ($request->filled('level')) {
            $query->whereRaw("LOWER(level) = ?", [strtolower($request->level)]);
        }

        // ===============================
        // YEAR FILTER
        // ===============================
        if ($request->filled('year')) {
            $query->whereYear('achieved_at', $request->year);
        }

        // ===============================
        // SEARCH (TITLE)
        // ===============================
        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        // ===============================
        // ORDER (HIGHEST LEVEL FIRST 🔥)
        // ===============================
        $query->orderByRaw("
            FIELD(LOWER(level), 'national', 'state', 'district', 'school')
        ");

        $achievements = $query->get();

        // ===============================
        // RETURN PARTIAL VIEW (POPUP)
        // ===============================
        return view('student.partials.achievement-list', compact('achievements'));
    }
}