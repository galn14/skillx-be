<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\UserLogout; // Import the UserLogout model
use Carbon\Carbon;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        try {
            // Get the token and authenticate the user
            $token = JWTAuth::getToken();
            $user = JWTAuth::authenticate($token); // Ensure token is valid and retrieve user

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated or token invalid'
                ], 401); // Unauthorized if user not found
            }

            // Invalidate the token
            JWTAuth::invalidate($token);

            // Log the logout event
            UserLogout::create([
                'user_id' => $user->id, // Authenticated user's ID
                'logout_time' => Carbon::now(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Successfully logged out'
            ], 200);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token invalid or expired'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to log out'
            ], 500);
        }
    }
}
