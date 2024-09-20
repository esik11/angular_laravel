<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Show the user's profile
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', ['user' => $user]);
    }

    // Handle profile updates, including profile picture
    public function update(Request $request)
    {
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string|max:500',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:15',
        ]);

        $user = Auth::user();

        // If the user doesn't have a profile, create a new one
        $profile = $user->profile ?: new UserProfile(['user_id' => $user->id]);

        if ($request->hasFile('profile_picture')) {
            // Delete the old profile picture if it exists
            if ($profile->profile_picture) {
                Storage::delete('public/profile_pictures/' . $profile->profile_picture);
            }

            // Store the new profile picture
            $fileName = time() . '.' . $request->profile_picture->extension();
            $request->profile_picture->storeAs('public/profile_pictures', $fileName);
            $profile->profile_picture = $fileName;
        }

        // Update the other fields
        $profile->bio = $request->input('bio');
        $profile->address = $request->input('address');
        $profile->phone_number = $request->input('phone_number');
        $profile->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}

