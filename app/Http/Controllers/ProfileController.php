<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function index(){
        return view('profile.index');
    }
    public function update(Request $request)
{
    $request->validate([
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'name' => 'required|string|max:255',
    ]);

    $user = auth()->user();

    if ($request->hasFile('profile_picture')) {
        $file = $request->file('profile_picture');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/profile_pictures', $filename);

        $user->profile_picture = 'profile_pictures/' . $filename;
    }

    $user->name = $request->input('name');
    $user->save();

    return redirect()->back()->with('success', 'Profile updated successfully.');
}
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('profile.show', compact('user')); // Pass the user object to the view
    }

}
