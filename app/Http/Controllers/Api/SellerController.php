<?php

namespace App\Http\Controllers\Api;

use App\Models\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SellerController extends Controller
{
    // Display the authenticated seller's profile
    public function profile()
    {
        $user = Auth::user();
        $seller = Seller::where('UserId', $user->id)->first();

        if (!$seller) {
            return response()->json(['message' => 'Seller profile not found'], 404);
        }

        return response()->json($seller, 200);
    }

    // Display all sellers
    public function index()
    {
        return response()->json(Seller::all(), 200);
    }

    // Store a new seller
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'UserId' => 'required|exists:users,id',
            'Universitas' => 'required|string|max:100',
            'IdMajor' => 'required|exists:majors,IdMajor',
            'Language' => 'nullable|string|max:100',
            'Rating' => 'nullable|numeric|between:0,5',
            'YearSince' => 'required|integer|min:0',
            'Orders' => 'nullable|integer|min:0',
            'Level' => 'required|string|max:50',
            'Description' => 'nullable|string',
            'GraduationMonth' => 'nullable|integer|between:1,12',
            'GraduationYear' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $seller = Seller::create($request->all());

        return response()->json(['success' => true, 'data' => $seller], 201);
    }

    // Display a specific seller
    public function show($id)
    {
        $seller = Seller::find($id);

        if (!$seller) {
            return response()->json(['message' => 'Seller not found'], 404);
        }

        return response()->json($seller, 200);
    }

    // Update a specific seller
    public function update(Request $request, $id)
    {
        $seller = Seller::find($id);

        if (!$seller) {
            return response()->json(['message' => 'Seller not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'Universitas' => 'required|string|max:100',
            'IdMajor' => 'nullable|exists:majors,IdMajor',
            'Language' => 'nullable|string|max:100',
            'Rating' => 'nullable|numeric|between:0,5',
            'YearSince' => 'required|integer|min:0',
            'Orders' => 'nullable|integer|min:0',
            'Level' => 'required|string|max:50',
            'Description' => 'nullable|string',
            'GraduationMonth' => 'nullable|integer|between:1,12',
            'GraduationYear' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $seller->update($request->all());

        return response()->json(['success' => true, 'data' => $seller], 200);
    }

    // Delete a specific seller
    public function destroy($id)
    {
        $seller = Seller::find($id);

        if (!$seller) {
            return response()->json(['message' => 'Seller not found'], 404);
        }

        $seller->delete();

        return response()->json(['success' => true, 'message' => 'Seller deleted'], 200);
    }
}
