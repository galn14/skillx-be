<?php

namespace App\Http\Controllers\Api;

use App\Models\Portofolio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PortofolioController extends Controller
{
    /**
     * Display the user's portfolio.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $userId = Auth::id();
        $portofolios = Portofolio::where('UserId', $userId)->get();

        return response()->json($portofolios, 200);
    }

    /**
     * Store a newly created portfolio item for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'TitlePortofolio' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $userId = Auth::id();

        // Create a new portfolio item
        $portofolio = Portofolio::create([
            'UserId' => $userId,
            'TitlePortofolio' => $request->TitlePortofolio,
        ]);

        return response()->json([
            'success' => true,
            'data' => $portofolio,
            'message' => 'Portfolio created successfully.',
        ], 201);
    }

    /**
     * Display a specific portfolio item.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $userId = Auth::id();
        $portofolio = Portofolio::where('UserId', $userId)->where('IdPortofolio', $id)->first();

        if (!$portofolio) {
            return response()->json(['message' => 'Portfolio item not found'], 404);
        }

        return response()->json($portofolio, 200);
    }

    /**
     * Update a specific portfolio item.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $userId = Auth::id();
        $portofolio = Portofolio::where('UserId', $userId)->where('IdPortofolio', $id)->first();

        if (!$portofolio) {
            return response()->json(['message' => 'Portfolio item not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'TitlePortofolio' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Update the portfolio item
        $portofolio->update([
            'TitlePortofolio' => $request->TitlePortofolio,
        ]);

        return response()->json([
            'success' => true,
            'data' => $portofolio,
            'message' => 'Portfolio updated successfully.',
        ], 200);
    }

    /**
     * Remove a specific portfolio item.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $userId = Auth::id();
        $portofolio = Portofolio::where('UserId', $userId)->where('IdPortofolio', $id)->first();

        if (!$portofolio) {
            return response()->json(['message' => 'Portfolio item not found'], 404);
        }

        $portofolio->delete();

        return response()->json([
            'success' => true,
            'message' => 'Portfolio deleted successfully.',
        ], 200);
    }
}
