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
     * Display a list of all portfolios for the authenticated user.
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
     * Store a new portfolio for the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'TitlePortofolio' => 'required|string|max:255',
            'DescriptionPortofolio' => 'required|string|max:255',
            'LinkPortofolio' => 'required|string|max:255',
            'PhotoPortofolio' => 'nullable|string|max:255',
            'TypePortofolio' => 'required|string|max:100',
            'StatusPortofolio' => 'required|string|max:100',
            'DateCreatedPortofolio' => 'required|date',
            'DateEndPortofolio' => 'nullable|date|after_or_equal:DateCreatedPortofolio',
            'IsPresentPortofolio' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $userId = Auth::id();
        
        $portofolio = Portofolio::create([
            'UserId' => $userId,
            'TitlePortofolio' => $request->TitlePortofolio,
            'DescriptionPortofolio' => $request->DescriptionPortofolio,
            'LinkPortofolio' => $request->LinkPortofolio,
            'PhotoPortofolio' => $request->PhotoPortofolio,
            'TypePortofolio' => $request->TypePortofolio,
            'StatusPortofolio' => $request->StatusPortofolio,
            'DateCreatedPortofolio' => $request->DateCreatedPortofolio,
            'DateEndPortofolio' => $request->DateEndPortofolio,
            'IsPresentPortofolio' => $request->IsPresentPortofolio,
        ]);

        return response()->json([
            'success' => true,
            'data' => $portofolio,
            'message' => 'Portfolio created successfully.',
        ], 201);
    }

    /**
     * Display a specific portfolio by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $userId = Auth::id();
        $portofolio = Portofolio::where('UserId', $userId)->where('IdPortofolio', $id)->first();

        if (!$portofolio) {
            return response()->json(['message' => 'Portfolio not found'], 404);
        }

        return response()->json($portofolio, 200);
    }

    /**
     * Update a specific portfolio for the authenticated user.
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
            return response()->json(['message' => 'Portfolio not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'TitlePortofolio' => 'required|string|max:255',
            'DescriptionPortofolio' => 'required|string|max:255',
            'LinkPortofolio' => 'required|string|max:255',
            'PhotoPortofolio' => 'nullable|string|max:255',
            'TypePortofolio' => 'required|string|max:100',
            'StatusPortofolio' => 'required|string|max:100',
            'DateCreatedPortofolio' => 'required|date',
            'DateEndPortofolio' => 'nullable|date|after_or_equal:DateCreatedPortofolio',
            'IsPresentPortofolio' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $portofolio->update([
            'TitlePortofolio' => $request->TitlePortofolio,
            'DescriptionPortofolio' => $request->DescriptionPortofolio,
            'LinkPortofolio' => $request->LinkPortofolio,
            'PhotoPortofolio' => $request->PhotoPortofolio,
            'TypePortofolio' => $request->TypePortofolio,
            'StatusPortofolio' => $request->StatusPortofolio,
            'DateCreatedPortofolio' => $request->DateCreatedPortofolio,
            'DateEndPortofolio' => $request->DateEndPortofolio,
            'IsPresentPortofolio' => $request->IsPresentPortofolio,
        ]);

        return response()->json([
            'success' => true,
            'data' => $portofolio,
            'message' => 'Portfolio updated successfully.',
        ], 200);
    }

    /**
     * Delete a specific portfolio.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $userId = Auth::id();
        $portofolio = Portofolio::where('UserId', $userId)->where('IdPortofolio', $id)->first();

        if (!$portofolio) {
            return response()->json(['message' => 'Portfolio not found'], 404);
        }

        $portofolio->delete();

        return response()->json([
            'success' => true,
            'message' => 'Portfolio deleted successfully.',
        ], 200);
    }
}
