<?php

// app/Http/Controllers/Api/TokenValidationController.php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use App\Services\FirebaseService;

class TokenValidationController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    /**
     * Validate JWT token for local email and password login.
     */
    public function validateToken(Request $request)
    {
        $token = $request->token;

        if (!$token) {
            return response()->json(['valid' => false, 'message' => 'Token not provided'], 400);
        }

        try {
            JWTAuth::setToken($token);
            if (!$user = JWTAuth::authenticate()) {
                return response()->json(['valid' => false, 'message' => 'User not found'], 404);
            }

            return response()->json(['valid' => true, 'user' => $user], 200);

        } catch (TokenExpiredException $e) {
            return response()->json(['valid' => false, 'message' => 'Token expired'], 401);

        } catch (TokenInvalidException $e) {
            return response()->json(['valid' => false, 'message' => 'Token invalid'], 401);

        } catch (TokenBlacklistedException $e) {
            return response()->json(['valid' => false, 'message' => 'Token blacklisted'], 401);

        } catch (JWTException $e) {
            return response()->json(['valid' => false, 'message' => 'Token error'], 500);
        }
    }

    /**
     * Validate Firebase token for Google login.
     */
    public function validateGoogleToken(Request $request)
    {
        $token = $request->token;

        if (!$token) {
            return response()->json(['valid' => false, 'message' => 'Token not provided'], 400);
        }

        try {
            // Use the FirebaseService's verifyGoogleToken method
            $verifiedIdToken = $this->firebaseService->verifyGoogleToken($token);
            $firebaseUserId = $verifiedIdToken->claims()->get('sub');

            return response()->json(['valid' => true, 'firebase_user_id' => $firebaseUserId], 200);

        } catch (\Exception $e) {
            return response()->json(['valid' => false, 'message' => 'Firebase token error: ' . $e->getMessage()], 500);
        }
    }
}
