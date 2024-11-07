<?php

namespace App\Http\Controllers\Api;

use App\Models\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BuyerController extends Controller
{
    /**
     * Display the authenticated user's buyer profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $userId = Auth::id();
        $buyer = Buyer::where('UserId', $userId)->first();

        if (!$buyer) {
            return response()->json(['message' => 'Buyer profile not found'], 404);
        }

        return response()->json($buyer, 200);
    }

    /**
     * Store a newly created buyer profile for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'PhotoProfile' => 'nullable|string|max:255',
            'Universitas' => 'nullable|string|max:100',
            'IdMajor' => 'nullable|exists:majors,IdMajor',
            'Language' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $userId = Auth::id();

        // Check if the user already has a buyer profile
        if (Buyer::where('UserId', $userId)->exists()) {
            return response()->json(['message' => 'Buyer profile already exists'], 409);
        }

        // Create a new buyer profile
        $buyer = Buyer::create([
            'UserId' => $userId,
            'PhotoProfile' => $request->PhotoProfile,
            'Universitas' => $request->Universitas,
            'IdMajor' => $request->IdMajor,
            'Language' => $request->Language,
        ]);

        return response()->json([
            'success' => true,
            'data' => $buyer,
            'message' => 'Buyer profile created successfully.',
        ], 201);
    }

    /**
     * Update the authenticated user's buyer profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $userId = Auth::id();
        $buyer = Buyer::where('UserId', $userId)->first();

        if (!$buyer) {
            return response()->json(['message' => 'Buyer profile not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'PhotoProfile' => 'nullable|string|max:255',
            'Universitas' => 'nullable|string|max:100',
            'IdMajor' => 'nullable|exists:majors,IdMajor',
            'Language' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Update the buyer profile
        $buyer->update([
            'PhotoProfile' => $request->PhotoProfile,
            'Universitas' => $request->Universitas,
            'IdMajor' => $request->IdMajor,
            'Language' => $request->Language,
        ]);

        return response()->json([
            'success' => true,
            'data' => $buyer,
            'message' => 'Buyer profile updated successfully.',
        ], 200);
    }

    /**
     * Remove the authenticated user's buyer profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        $userId = Auth::id();
        $buyer = Buyer::where('UserId', $userId)->first();

        if (!$buyer) {
            return response()->json(['message' => 'Buyer profile not found'], 404);
        }

        $buyer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Buyer profile deleted successfully.',
        ], 200);
    }
}
