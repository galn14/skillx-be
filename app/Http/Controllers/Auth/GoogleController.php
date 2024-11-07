<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Add this line
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            // Retrieve the user information from Google
            $googleUser = Socialite::driver('google')->user();

            // Find the user by Google ID or email
            $user = User::where('google_id', $googleUser->id)
                        ->orWhere('email', $googleUser->email)
                        ->first();

            if ($user) {
                // Update Google ID if missing for existing email users
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->id]);
                }
            } else {
                // Register a new user if one doesn't exist
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => Hash::make(uniqid()), // Generate a secure random password
                ]);
            }

            // Log in the user
            Auth::login($user);

            // Redirect to the intended dashboard or default route
            return redirect()->intended('dashboard');

        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Google login error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Unable to login with Google. Please try again.');
        }
    }
}
