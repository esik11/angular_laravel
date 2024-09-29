<?php

// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    // Fetch user and profile information
    public function show(Request $request)
{
    $user = Auth::user();
    $profile = UserProfile::where('user_id', $user->id)->first();
    return response()->json(['user' => $user, 'profile' => $profile]);
}

    // Update the user profile
    public function update(Request $request)
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->first();
    
        // Validate the incoming request data
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string',
        ]);
    
        // Handle the profile picture upload
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $profile->profile_picture = $path; // Update the profile picture path
        }
    
        // Update other fields
        $profile->bio = $request->bio ?? $profile->bio;
        $profile->address = $request->address ?? $profile->address;
        $profile->phone_number = $request->phone_number ?? $profile->phone_number;
        $profile->save();
    
        return response()->json(['message' => 'Profile updated successfully!']);
    }
    
}
