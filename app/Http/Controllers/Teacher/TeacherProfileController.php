<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\User;

class TeacherProfileController extends Controller
{
    public function show(User $user)
    {
        // hanya teacher je boleh view
        if ($user->role !== 'teacher') {
            abort(404);
        }

        // load data
        $user->load('expertises', 'awards');

        return view('teacher.profile.show', compact('user'));
    }
}