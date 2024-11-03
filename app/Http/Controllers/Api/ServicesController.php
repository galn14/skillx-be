<?php

namespace App\Http\Controllers\Api;

use App\Models\Services;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ServicesController extends Controller
{
    // Display all services
    public function index()
    {
        return response()->json(Services::with('major')->get(), 200);
    }

    // Store a new service
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NamaServices' => 'required|string|max:100',
            'IdMajor' => 'required|exists:majors,IdMajor',
            'LogoServices' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $service = Services::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $service,
            'message' => 'Services created successfully',
        ], 201);
    }

    // Display a specific service
    public function show($id)
    {
        $service = Services::with('major')->find($id);

        if (!$service) {
            return response()->json(['message' => 'Services not found'], 404);
        }

        return response()->json($service, 200);
    }

    // Delete a specific service
    public function destroy($id)
    {
        $service = Services::find($id);

        if (!$service) {
            return response()->json(['message' => 'Services not found'], 404);
        }

        $service->delete();

        return response()->json([
            'success' => true,
            'message' => 'Services deleted successfully'
        ], 200);
    }
}
