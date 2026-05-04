<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Form;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;
        $form = $request->form;   
        $class = $request->class;

        $students = User::where('role', 'student')

            ->when($q, function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
                });
            })

            ->when($form, function ($query) use ($form) {
                $query->where('form', $form);
            })

            ->when($class, function ($query) use ($class) {
                $query->where('class_name', $class);
            })

            ->orderBy('form', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(10)
            ->withQueryString();


        $classes = SchoolClass::all();
        $forms = Form::all();

        return view('admin.students.index', compact(
            'students',
            'classes',
            'forms'
        ));
    }

    public function create()
    {
        $classes = SchoolClass::all();
        $forms = Form::all();

        return view('admin.students.create', compact('classes','forms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'gender' => ['required','in:male,female'],
            'form' => ['required','integer'],
            'class_name' => ['required','string'],
            'date_joined' => ['required','date']
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'form' => $request->form,
            'class_name' => $request->class_name,
            'date_joined' => $request->date_joined,
            'role' => 'student',
            'password' => Hash::make('abc123')
        ]);

        return redirect()->route('admin.students.index')
            ->with('success', 'Student created. Default password: abc123');
    }

    public function show(User $student)
    {
        $this->ensureStudent($student);

        return view('admin.students.show', compact('student'));
    }

    public function edit(User $student)
    {
        $this->ensureStudent($student);

        $classes = SchoolClass::all();
        $forms = Form::all();

        return view('admin.students.edit', compact('student','classes','forms'));
    }

    public function update(Request $request, User $student)
    {
        $this->ensureStudent($student);

        $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email,' . $student->id],
            'gender' => ['required','in:male,female'],
            'form' => ['required','integer'],
            'class_name' => ['required','string'],
            'date_joined' => ['required','date']
        ]);

        // DEBUG (optional)
        // dd($request->all());

        $student->update([
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'form' => $request->form,
            'class_name' => $request->class_name,
            'date_joined' => $request->date_joined
        ]);

        return redirect()->route('admin.students.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(User $student)
    {
        $this->ensureStudent($student);

        $student->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Student deleted successfully.');
    }

    private function ensureStudent(User $user): void
    {
        abort_unless($user->role === 'student', 404);
    }
}