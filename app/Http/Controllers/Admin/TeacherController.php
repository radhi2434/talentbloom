<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;
        $position = $request->position;

        $teachers = User::where('role', 'teacher')

            ->when($q, function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('name', 'like', "%{$q}%")
                       ->orWhere('email', 'like', "%{$q}%");
                });
            })

            ->when($position, function ($query) use ($position) {
                $query->where('position', $position);
            })

            ->orderBy('name','asc')
            ->paginate(10)
            ->withQueryString();

        $positions = Position::all();

        return view('admin.teachers.index', compact('teachers', 'positions'));
    }


    public function create()
    {
        $positions = Position::all();

        return view('admin.teachers.create', compact('positions'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required','string','max:255'],
            'email'    => ['required','email','max:255','unique:users,email'],
            'gender'   => ['required','in:male,female'],
            'phone'    => ['nullable','string','max:20'],
            'position' => ['required']
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'gender'   => $request->gender,
            'phone'    => $request->phone,
            'position' => $request->position,
            'role'     => 'teacher',
            'password' => Hash::make('abc123')
        ]);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher created. Default password: abc123');
    }


    public function show(User $teacher)
    {
        $this->ensureTeacher($teacher);

        return view('admin.teachers.show', compact('teacher'));
    }


    public function edit(User $teacher)
    {
        $this->ensureTeacher($teacher);

        $positions = Position::all();

        return view('admin.teachers.edit', compact('teacher', 'positions'));
    }


    public function update(Request $request, User $teacher)
    {
        $this->ensureTeacher($teacher);

        $request->validate([
            'name'     => ['required','string','max:255'],
            'email'    => ['required','email','max:255','unique:users,email,' . $teacher->id],
            'gender'   => ['required','in:male,female'],
            'phone'    => ['nullable','string','max:20'],
            'position' => ['required']
        ]);

        $teacher->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'gender'   => $request->gender,
            'phone'    => $request->phone,
            'position' => $request->position
        ]);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher updated successfully.');
    }


    public function destroy(User $teacher)
    {
        $this->ensureTeacher($teacher);

        $teacher->delete();

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher deleted successfully.');
    }


    private function ensureTeacher(User $user): void
    {
        abort_unless($user->role === 'teacher', 404);
    }
}