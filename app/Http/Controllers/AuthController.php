<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate request input
    $validated = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ]);

    // Attempt to authenticate the user
    if (!Auth::attempt($validated)) {
        return response()->json([
            'message' => 'Invalid email or password',
        ], 401);
    }

    // Get authenticated user
    /** @var User $user */
    $user = Auth::user();

    // Generate API token
    $token = $user->createToken('auth-token')->plainTextToken;

    // Log successful login
    Log::info("User login successful: {$user->email}");

    return response()->json([
        'message' => 'Login successful',
        'token' => $token,
        'user' => [
            'id' => $user->id,
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'role' => $user->role,
        ],
    ], 200);
}

    
}
