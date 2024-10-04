<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Fetch the current user's profile
    public function show(Request $request)
{
    $user = Auth::user();
    
    // Check if the profile exists, if not, create a default profile
    $profile = UserProfile::firstOrCreate(
        ['user_id' => $user->id], // Condition to check if a profile exists
        [ // Default values if a profile is created
            'bio' => null,
            'address' => null,
            'phone_number' => null,
            'profile_picture' => null,
        ]
    );

    return response()->json([
        'user' => $user,
        'profile' => $profile,
    ]);
}


    // Update the user's profile
    public function update(Request $request)
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->first();

        // Validate the input
        $request->validate([
            'bio' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Profile picture validation
        ]);

        // Update profile fields
        $profile->bio = $request->input('bio');
        $profile->address = $request->input('address');
        $profile->phone_number = $request->input('phone_number');

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $path = $file->store('public/profile_pictures'); // Save to storage/app/public/profile_pictures
            $profile->profile_picture = basename($path);
        }

        $profile->save();

        return response()->json([
            'message' => 'Profile updated successfully',
            'profile' => $profile,
        ]);
    }
}