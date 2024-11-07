<?php

namespace App\Http\Controllers\Api;

use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Display reviews belonging to the authenticated user
    public function index()
    {
        $userId = Auth::id();
        $reviews = Review::where('UserId', $userId)
            ->with(['user', 'transaction'])
            ->get();

        return response()->json($reviews, 200);
    }

    // Store a new review by the authenticated user if they are the buyer in the transaction
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'IdTransaction' => 'required|exists:transactions,IdTransaction',
            'Rating' => 'required|numeric|min:0|max:5',
            'Comment' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Check if the authenticated user is the buyer in the specified transaction
        $userId = Auth::id();
        $transaction = Transaction::where('IdTransaction', $request->IdTransaction)
            ->where('IdBuyer', $userId)
            ->first();

        if (!$transaction) {
            return response()->json(['message' => 'Access denied. You are not the buyer in this transaction.'], 403);
        }

        // Create the review with the authenticated user's ID as UserId
        $review = Review::create([
            'UserId' => $userId,
            'IdTransaction' => $request->IdTransaction,
            'Rating' => $request->Rating,
            'Comment' => $request->Comment,
        ]);

        return response()->json([
            'success' => true,
            'data' => $review,
            'message' => 'Review created successfully',
        ], 201);
    }

    // Show a specific review if it belongs to the authenticated user
    public function show($id)
    {
        $userId = Auth::id();
        $review = Review::where('UserId', $userId)
            ->with(['user', 'transaction'])
            ->find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found or access denied'], 404);
        }

        return response()->json($review, 200);
    }

    // Update a specific review by the authenticated user
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'Rating' => 'sometimes|numeric|min:0|max:5',
            'Comment' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $userId = Auth::id();
        $review = Review::where('UserId', $userId)->find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found or access denied'], 404);
        }

        $review->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $review,
            'message' => 'Review updated successfully',
        ], 200);
    }

    // Delete a specific review by the authenticated user
    public function destroy($id)
    {
        $userId = Auth::id();
        $review = Review::where('UserId', $userId)->find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found or access denied'], 404);
        }

        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review deleted successfully'
        ], 200);
    }
}
