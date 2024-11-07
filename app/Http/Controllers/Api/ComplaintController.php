<?php

namespace App\Http\Controllers\Api;

use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ComplaintController extends Controller
{
    /**
     * Display a specific complaint.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $complaint = Complaint::find($id);

        if (!$complaint) {
            return response()->json(['message' => 'Complaint not found'], 404);
        }

        return response()->json($complaint, 200);
    }

    /**
     * Store a newly created complaint.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'IdTransaction' => 'required|exists:transactions,IdTransaction',
            'ComplaintText' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $complaint = Complaint::create([
            'IdTransaction' => $request->IdTransaction,
            'ComplaintText' => $request->ComplaintText,
        ]);

        return response()->json([
            'success' => true,
            'data' => $complaint,
            'message' => 'Complaint created successfully',
        ], 201);
    }

    /**
     * Update an existing complaint.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $complaint = Complaint::find($id);

        if (!$complaint) {
            return response()->json(['message' => 'Complaint not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'ComplaintText' => 'sometimes|required|string',
            'Status' => 'sometimes|required|in:Pending,Resolved',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $complaint->update($request->only(['ComplaintText', 'Status']));

        return response()->json([
            'success' => true,
            'data' => $complaint,
            'message' => 'Complaint updated successfully',
        ], 200);
    }

    /**
     * Delete a complaint.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $complaint = Complaint::find($id);

        if (!$complaint) {
            return response()->json(['message' => 'Complaint not found'], 404);
        }

        $complaint->delete();

        return response()->json([
            'success' => true,
            'message' => 'Complaint deleted successfully'
        ], 200);
    }
}
