<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    public function edit()
    {
        return view('admin.profile.edit');
    }

    /**
     * Admin can update ALL fields
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'unique:users,email,' . $user->id],
            'phone'     => ['nullable', 'string', 'max:20'],
            'position' => 'nullable|string|max:255',
        ]);

        $user->update($request->only([
            'name',
            'email',
            'phone',
            'position' => $request->position,
        ]));

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $user = auth()->user();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // ✅ force logout after password change
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Password updated. Please login again.');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => ['required','image','mimes:jpg,jpeg,png','max:2048'],
        ]);

        $user = auth()->user();

        // delete old photo
        if ($user->profile_photo && \Storage::disk('public')->exists($user->profile_photo)) {
            \Storage::disk('public')->delete($user->profile_photo);
        }

        $path = $request->file('photo')->store('profile_photos', 'public');

        $user->update([
            'profile_photo' => $path,
        ]);

        return back()->with('success', 'Profile photo updated successfully.');
    }


}
