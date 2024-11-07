<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // Display transactions belonging to the authenticated user
    public function index()
    {
        $userId = Auth::id();
        $transactions = Transaction::where('IdBuyer', $userId)
            ->orWhere('IdSeller', $userId)
            ->orWhere('IdSellerFeat', $userId)
            ->with(['seller', 'featuredSeller', 'buyer', 'product'])
            ->get();

        return response()->json($transactions, 200);
    }

    // Store a new transaction for the authenticated user
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'IdProduct' => 'required|exists:products,IdProduct',
            'Price' => 'required|numeric|min:0',
            'TotalPrice' => 'required|numeric|min:0',
            'TransactionStatus' => 'required|in:Pending,In Progress,Complete,Refunded',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Automatically assign the authenticated user as the buyer or seller
        $userId = Auth::id();

        $transaction = Transaction::create([
            'IdSeller' => $userId, // Assuming the user is the seller; adjust as needed
            'IdBuyer' => $userId,  // Set the user as the buyer as well
            'IdSellerFeat' => $request->IdSellerFeat, // Optional featured seller
            'IdProduct' => $request->IdProduct,
            'Price' => $request->Price,
            'TotalPrice' => $request->TotalPrice,
            'TransactionStatus' => $request->TransactionStatus,
        ]);

        return response()->json([
            'success' => true,
            'data' => $transaction,
            'message' => 'Transaction created successfully',
        ], 201);
    }

    // Show a specific transaction if it belongs to the authenticated user
    public function show($id)
    {
        $userId = Auth::id();
        $transaction = Transaction::where(function ($query) use ($userId) {
                $query->where('IdBuyer', $userId)
                      ->orWhere('IdSeller', $userId)
                      ->orWhere('IdSellerFeat', $userId);
            })
            ->with(['seller', 'featuredSeller', 'buyer', 'product'])
            ->find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found or access denied'], 404);
        }

        return response()->json($transaction, 200);
    }

    // Update a specific transaction for the authenticated user
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'TransactionStatus' => 'sometimes|in:Pending,In Progress,Complete,Refunded',
            'Price' => 'sometimes|numeric|min:0',
            'TotalPrice' => 'sometimes|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $userId = Auth::id();
        $transaction = Transaction::where('IdBuyer', $userId)
            ->orWhere('IdSeller', $userId)
            ->orWhere('IdSellerFeat', $userId)
            ->find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found or access denied'], 404);
        }

        $transaction->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $transaction,
            'message' => 'Transaction updated successfully',
        ], 200);
    }

    // Delete a specific transaction for the authenticated user
    public function destroy($id)
    {
        $userId = Auth::id();
        $transaction = Transaction::where('IdBuyer', $userId)
            ->orWhere('IdSeller', $userId)
            ->orWhere('IdSellerFeat', $userId)
            ->find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found or access denied'], 404);
        }

        $transaction->delete();

        return response()->json([
            'success' => true,
            'message' => 'Transaction deleted successfully'
        ], 200);
    }
}
