<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Talent;
use Illuminate\Http\Request;

class StudentProfileController extends Controller
{
    /**
     * ✅ STUDENT LIST (TABLE VIEW)
     */
    public function index(Request $request)
    {
        $q     = $request->get('q');
        $form  = $request->get('form');
        $class = $request->get('class');

        $students = User::where('role', 'student')
            ->withCount('talents')

            // ✅ FILTER BY FORM
            ->when($form, function ($query) use ($form) {
                $query->where('form', $form);
            })

            // ✅ FILTER BY CLASS
            ->when($class, function ($query) use ($class) {
                $query->where('class_name', $class);
            })

            // ✅ SEARCH
            ->when($q, function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('name', 'like', "%{$q}%")
                       ->orWhere('email', 'like', "%{$q}%");
                });
            })

            ->orderBy('name')
            ->get();

        // ✅ CLASS DROPDOWN (BASED ON FORM)
        $classes = collect();

        if ($form) {
            foreach (['Al-Bukhari','At-Tirmizi','An-Nasaie'] as $c) {
                $classes->push($c); // 🔥 ONLY CLASS NAME
            }
        } else {
            // kalau tak pilih form → show semua class
            foreach (['Al-Bukhari','At-Tirmizi','An-Nasaie'] as $c) {
                $classes->push($c);
            }
        }

        return view('teacher.students.index', compact(
            'students',
            'classes',
            'form',
            'class'
        ));
    }

    /**
     * ✅ MODAL VIEW (AJAX)
     */
    public function show(User $student)
    {
        abort_unless($student->role === 'student', 404);

        // 🔥 LOAD RELATION
        $student->load(['talents.teacher'])->loadCount('talents');

        $talents = $student->talents()->latest()->get();

        // 🔥 CORRECT TALLY
        $counts = [
            'sports' => $student->talents()->whereRaw("LOWER(category) = 'sports'")->count(),
            'academic' => $student->talents()->whereRaw("LOWER(category) IN ('academic','academics')")->count(),
            'leadership' => $student->talents()->whereRaw("LOWER(category) = 'leadership'")->count(),
            'cocurricular' => $student->talents()->whereRaw("LOWER(category) IN ('co-curricular','cocurricular')")->count(),
        ];

        return view('teacher.students._modal', compact(
            'student',
            'talents',
            'counts'
        ));
    }

    /**
     * ✅ ADD TALENT
     */
    public function storeTalent(Request $request, User $student)
    {
        abort_unless($student->role === 'student', 404);

        $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required|in:Sports,Academic,Leadership,Co-curricular',
            'level'       => 'required|string|max:50',
            'achieved_at' => 'nullable|date',
        ]);

        Talent::create([
            'student_id'  => $student->id,
            'title'       => $request->title,
            'category'    => $request->category,
            'level'       => ucfirst($request->level),
            'achieved_at' => $request->achieved_at,
            'teacher_id'  => auth()->id(), // kalau ada column
        ]);

        return back()->with('success', 'Talent added successfully.');
    }

    public function createTalent(User $student)
    {
        return view('teacher.students.create', compact('student'));
    }
}