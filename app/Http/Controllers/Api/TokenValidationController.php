<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

class TokenValidationController extends Controller
{
    public function validateToken(Request $request)
    {
        try {
            // Check if token is present in the request
            $token = $request->token;
            if (!$token) {
                return response()->json(['valid' => false, 'message' => 'Token not provided'], 400); // Missing token
            }

            // Set the token in JWTAuth
            JWTAuth::setToken($token);

            // Attempt to authenticate using the token
            if (!$user = JWTAuth::authenticate()) {
                return response()->json(['valid' => false, 'message' => 'User not found'], 404);
            }

            // Token is valid
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
}
