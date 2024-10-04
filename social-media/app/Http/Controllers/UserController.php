<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;
class UserController extends Controller
{
    // Fetch the currently logged-in user
    public function getUser(Request $request)
    {
        return response()->json(Auth::user());
    }
}