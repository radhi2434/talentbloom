<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Talent;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        // ===============================
        // GET FILTER
        // ===============================
        $category = $request->get('category', 'all');

        // ===============================
        // GET TALENT DATA
        // ===============================
        $query = Talent::with('student');

        if ($category !== 'all') {
            $query->where('category', $category);
        }

        $talents = $query->get();

        // ===============================
        // TREND DATA (BY FORM)
        // ===============================
        $forms = [1,2,3,4,5];
        $trend = [];

        foreach ($forms as $form) {

            $count = Talent::whereHas('student', function($q) use ($form){
                $q->where('form', $form);
            })
            ->when($category !== 'all', function($q) use ($category){
                $q->where('category', $category);
            })
            ->distinct('student_id')
            ->count('student_id');

            $trend[] = $count;
        }

        // ===============================
        // RETURN VIEW
        // ===============================
        return view('admin.analytics', compact(
            'talents',
            'trend',
            'forms',
            'category'
        ));
    }
}