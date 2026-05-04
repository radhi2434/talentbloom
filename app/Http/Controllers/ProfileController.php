<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Expertise;
use App\Models\TeacherAward; 

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user()->load('expertises', 'awards');

        $allExpertise = Expertise::all();

        $role = $user->role;

        if ($role === 'teacher') {
            return view('teacher.profile.edit', compact(
                'user',
                'allExpertise'
            ));
        }

        if ($role === 'student') {
            return view('student.profile.edit', compact('user'));
        }

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'phone'   => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        $user = auth()->user();

        $user->update([
            'phone'   => $request->phone,
            'address' => $request->address,
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $user = auth()->user();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Password updated. Please login again.');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $user = auth()->user();

        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $path = $request->file('photo')->store('profile_photos', 'public');

        $user->update([
            'profile_photo' => $path,
        ]);

        return back()->with('success', 'Profile photo updated successfully.');
    }

    // ================= EXPERTISE =================

    public function addExpertise(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string'
        ]);

        $user = auth()->user();

        $exp = Expertise::create([
            'name' => $request->name,
            'category' => $request->category
        ]);

        $user->expertises()->attach($exp->id);

        return back()->with('success', 'Expertise added!');
    }

    public function deleteExpertise($id)
    {
        $user = auth()->user();

        $user->expertises()->detach($id);

        return back()->with('success', 'Expertise removed!');
    }

    // ================= AWARDS (FINAL FIX) =================

    public function addAward(Request $request)
    {
        $request->validate([
            'award' => 'required|string|max:255'
        ]);

        TeacherAward::create([
            'user_id' => auth()->id(),
            'name' => $request->award
        ]);

        return back()->with('success', 'Award added!');
    }

    public function deleteAward($id)
    {
        TeacherAward::where('id', $id)
            ->where('user_id', auth()->id())
            ->delete();

        return back()->with('success', 'Award deleted!');
    }

    public function show(\App\Models\User $user)
    {
        return view('user.profile.show', compact('user'));
    }
}