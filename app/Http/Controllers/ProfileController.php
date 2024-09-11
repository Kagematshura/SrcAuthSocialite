<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(){
        return view('profile.index');
    }
    public function update(Request $request)
{
    $request->validate([
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user = auth()->user();

    if ($request->hasFile('profile_picture')) {
        $file = $request->file('profile_picture');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/profile_pictures', $filename);

        $user->profile_picture = 'profile_pictures/' . $filename;
    }

    $user->save();

    return redirect()->back()->with('success', 'Profile updated successfully.');
}

}
