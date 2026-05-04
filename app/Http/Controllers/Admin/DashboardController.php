<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Talent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // ===============================
        // FILTER (EXISTING)
        // ===============================
        $categoryFilter = strtolower($request->get('category'));

        if ($categoryFilter == 'academics') {
            $categoryFilter = 'academic';
        }

        if ($categoryFilter == 'cocurricular') {
            $categoryFilter = 'co-curricular';
        }

        // ===============================
        // TREND
        // ===============================
        $year = $request->get('year', date('Y'));
        $formFilter = $request->get('form');

        // ===============================
        // KPI 
        // ===============================
        $totalStudents = User::where('role', 'student')->count();

        $sportsCount = Talent::whereRaw("LOWER(category) IN ('sports','sport')")->count();
        $academicCount = Talent::whereRaw("LOWER(category) IN ('academic','academics')")->count();
        $leadershipCount = Talent::whereRaw("LOWER(category) = 'leadership'")->count();
        $cocurricularCount = Talent::whereRaw("LOWER(category) IN ('co-curricular','co curricular','cocurricular')")->count();

        $noTalentCount = User::where('role', 'student')
            ->whereDoesntHave('talents')
            ->count();

        // ===============================
        // RANKING
        // ===============================
        $rankingsQuery = User::where('role', 'student')
            ->withCount(['talents' => function ($q) use ($categoryFilter) {
                if ($categoryFilter && $categoryFilter !== 'all') {
                    $q->whereRaw("LOWER(category) = ?", [$categoryFilter]);
                }
            }]);

        $rankings = $rankingsQuery
            ->orderByDesc('talents_count')
            ->limit(10)
            ->get()
            ->map(function ($u) {
                return (object)[
                    'name' => $u->name,
                    'total' => $u->talents_count,
                ];
            });

        // ===============================
        // STACKED BAR 
        // ===============================
        $forms = [1, 2, 3, 4, 5];

        $discovered = [];
        $notDiscovered = [];

        foreach ($forms as $form) {

            $total = User::where('role', 'student')
                ->where('form', $form)
                ->count();

            $withTalent = Talent::whereHas('student', function ($q) use ($form) {
                $q->where('form', $form);
            })
            ->when($categoryFilter && $categoryFilter !== 'all', function ($q) use ($categoryFilter) {
                $q->whereRaw("LOWER(category) = ?", [$categoryFilter]);
            })
            ->distinct('student_id')
            ->count('student_id');

            $discovered[] = $withTalent;
            $notDiscovered[] = max(0, $total - $withTalent);
        }

        // ===============================
        // DONUT 
        // ===============================
        $donutLabels = ['Sports', 'Academic', 'Leadership', 'Co-curricular'];

        $donutData = [
            Talent::whereRaw("LOWER(category) IN ('sports','sport')")->count(),
            Talent::whereRaw("LOWER(category) IN ('academic','academics')")->count(),
            Talent::whereRaw("LOWER(category) = 'leadership'")->count(),
            Talent::whereRaw("LOWER(category) IN ('co-curricular','co curricular','cocurricular')")->count(),
        ];

        // ============
        // TREND DATA
        // ============
        $trendData = DB::table('talent')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('LOWER(category) as category'),
                DB::raw('COUNT(*) as total')
            )
            ->when($formFilter, function($q) use ($formFilter){
                $q->whereExists(function ($sub) use ($formFilter) {
                    $sub->select(DB::raw(1))
                        ->from('users')
                        ->whereColumn('users.id', 'talent.student_id')
                        ->where('users.form', $formFilter);
                });
            })
            ->whereYear('created_at', $year)
            ->groupBy('month','category')
            ->get();

        $categories = ['sports','academic','leadership','co-curricular'];

        $trendFormatted = [];

        foreach($categories as $cat){
            $trendFormatted[$cat] = array_fill(0,12,0);
        }

        foreach($trendData as $row){
            $index = $row->month - 1;
            if(isset($trendFormatted[$row->category])){
                $trendFormatted[$row->category][$index] = $row->total;
            }
        }

        return view('admin.dashboard', compact(
            'totalStudents',
            'sportsCount',
            'academicCount',
            'cocurricularCount',
            'leadershipCount',
            'noTalentCount',
            'rankings',
            'forms',
            'discovered',
            'notDiscovered',
            'donutLabels',
            'donutData',
            'trendFormatted',
            'year',
            'formFilter'
        ));
    }
}