<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\FirebaseService;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;

class GoogleLoginController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function googleLogin(Request $request)
    {
        $idToken = $request->input('idToken');

        try {
            // Verify Google ID token with Firebase
            $verifiedIdToken = $this->firebaseService->verifyGoogleToken($idToken);
            $firebaseUserId = $verifiedIdToken->claims()->get('sub');
            $email = $verifiedIdToken->claims()->get('email');
            $name = $verifiedIdToken->claims()->get('name');

            // Check if user already exists
            $user = User::where('google_id', $firebaseUserId)->orWhere('email', $email)->first();

            if (!$user) {
                // Create a new user if not found
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'google_id' => $firebaseUserId,
                    'password' => bcrypt(Str::random(16)), // Random password as it's not used for Google login
                ]);
            }

            // Generate JWT token for the user
            $token = JWTAuth::fromUser($user);

            return response()->json([
                'success' => true,
                'user' => $user,
                'token' => $token,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token Google tidak valid atau terjadi kesalahan',
            ], 401);
        }
    }
}
