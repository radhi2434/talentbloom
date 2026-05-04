<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Talent;

class RankingController extends Controller
{
    public function index()
    {
        $student = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | TOTAL TALENTS PER STUDENT
        |--------------------------------------------------------------------------
        */
        $students = User::where('role', 'student')
            ->withCount('talents')
            ->orderByDesc('talents_count')
            ->get();

        // overall ranking
        $overallRank = $students->search(fn($s) => $s->id === $student->id) + 1;
        $totalStudents = $students->count();

        /*
        |--------------------------------------------------------------------------
        | CATEGORY RANKING
        |--------------------------------------------------------------------------
        */
        $categories = ['academic', 'sports', 'leadership', 'co-curricular'];

        $categoryRanks = [];

        foreach ($categories as $cat) {

            $categoryStudents = User::where('role', 'student')
                ->withCount(['talents as cat_count' => function ($q) use ($cat) {
                    $q->where('category', $cat);
                }])
                ->orderByDesc('cat_count')
                ->get();

            $rank = $categoryStudents->search(fn($s) => $s->id === $student->id) + 1;

            $categoryRanks[$cat] = [
                'rank' => $rank,
                'count' => $student->talents()->where('category', $cat)->count()
            ];
        }

        return view('student.ranking.index', compact(
            'overallRank',
            'totalStudents',
            'categoryRanks',
            'students'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
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
