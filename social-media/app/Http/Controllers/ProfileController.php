<?php

// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;

class ProfileController extends Controller
{
    // Fetch user and profile information
    public function show()
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->first();

        return response()->json(['user' => $user, 'profile' => $profile]);
    }

    // Update the user profile
    // Update the user profile
    public function update(Request $request)
    {
        $user = auth()->user();
        $profile = UserProfile::where('user_id', $user->id)->first();
    
        if (!$profile) {
            return response()->json(['message' => 'Profile not found.'], 404);
        }

    // Validate incoming data
    $request->validate([
        'bio' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:255',
        'phone_number' => 'nullable|string|max:15',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Update fields
    if ($request->has('bio')) {
        $profile->bio = $request->bio;
    }
    if ($request->has('address')) {
        $profile->address = $request->address;
    }
    if ($request->has('phone_number')) {
        $profile->phone_number = $request->phone_number;
    }
    if ($request->hasFile('profile_picture')) {
        $path = $request->file('profile_picture')->store('profile_pictures', 'public');
        $profile->profile_picture = $path;
    }

    $profile->save(); // Save changes to the user_profiles table

    return response()->json(['message' => 'Profile updated successfully.']);
}

    
}
