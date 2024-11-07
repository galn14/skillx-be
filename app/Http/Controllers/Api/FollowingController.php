<?php

namespace App\Http\Controllers\Api;

use App\Models\Following;
use App\Models\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FollowingController extends Controller
{
    // List all followings for the authenticated user
    public function index()
    {
        $userId = Auth::id();
        $followings = Following::where('IdFollower', $userId)
            ->with('seller')
            ->get();

        return response()->json($followings, 200);
    }

    // Follow a seller, restricted to buyers only
    public function store(Request $request)
    {
        $request->validate([
            'IdSeller' => 'required|exists:sellers,IdSeller',
        ]);

        $userId = Auth::id();

        // Check if the user is a buyer by looking up in the `buyers` table
        $buyer = Buyer::where('UserId', $userId)->first();

        if (!$buyer) {
            return response()->json(['message' => 'Only buyers can follow sellers'], 403);
        }

        // Check if the user is already following this seller
        $existingFollowing = Following::where('IdFollower', $userId)
            ->where('IdSeller', $request->IdSeller)
            ->first();

        if ($existingFollowing) {
            return response()->json(['message' => 'Already following this seller'], 409);
        }

        // Create the following
        $following = Following::create([
            'IdFollower' => $userId,
            'IdSeller' => $request->IdSeller,
        ]);

        return response()->json([
            'success' => true,
            'data' => $following,
            'message' => 'Followed seller successfully',
        ], 201);
    }

    // Unfollow a seller
    public function destroy($id)
    {
        $userId = Auth::id();
        $following = Following::where('IdFollower', $userId)
            ->where('IdSeller', $id)
            ->first();

        if (!$following) {
            return response()->json(['message' => 'Not following this seller'], 404);
        }

        $following->delete();

        return response()->json([
            'success' => true,
            'message' => 'Unfollowed seller successfully'
        ], 200);
    }
}
