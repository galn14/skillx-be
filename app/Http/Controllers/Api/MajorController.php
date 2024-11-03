<?php

namespace App\Http\Controllers\Api;

use App\Models\Major;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MajorController extends Controller
{
    // Display all majors
    public function index()
    {
        return response()->json(Major::all(), 200);
    }

    // Store a new major
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NamaMajor' => 'required|string|max:100',
            'LogoMajor' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $major = Major::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $major,
            'message' => 'Major created successfully',
        ], 201);
    }

    // Display a specific major
    public function show($id)
    {
        $major = Major::find($id);

        if (!$major) {
            return response()->json(['message' => 'Major not found'], 404);
        }

        return response()->json($major, 200);
    }

    // Delete a specific major
    public function destroy($id)
    {
        $major = Major::find($id);

        if (!$major) {
            return response()->json(['message' => 'Major not found'], 404);
        }

        $major->delete();

        return response()->json([
            'success' => true,
            'message' => 'Major deleted successfully'
        ], 200);
    }
}
