<?php

/*

namespace App\Http\Controllers\Api;

use App\Models\Subscribe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SubscribeController extends Controller
{
    // Menampilkan semua data langganan (khusus admin)
    public function index()
    {
        $this->authorize('admin-access'); // Pastikan hanya admin yang bisa mengakses

        $subscribes = Subscribe::with('user')->get();
        return response()->json($subscribes, 200);
    }

    // Menambahkan data langganan baru untuk user yang sedang login
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Month' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $subscribe = new Subscribe();
        $subscribe->UserId = auth()->user()->id; // Id user yang sedang login
        $subscribe->Month = $request->Month;
        $subscribe->start_date = $request->start_date;
        $subscribe->end_date = $request->end_date;
        $subscribe->save();

        return response()->json([
            'success' => true,
            'data' => $subscribe,
            'message' => 'Langganan berhasil ditambahkan',
        ], 201);
    }

    // Memperbarui data langganan user yang sedang login
    public function update(Request $request)
    {
        $subscribe = Subscribe::where('UserId', auth()->user()->id)->first();

        if (!$subscribe) {
            return response()->json(['message' => 'Langganan tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'Month' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $subscribe->Month = $request->Month;
        $subscribe->start_date = $request->start_date;
        $subscribe->end_date = $request->end_date;
        $subscribe->save();

        return response()->json([
            'success' => true,
            'data' => $subscribe,
            'message' => 'Langganan berhasil diperbarui',
        ], 200);
    }

    // Menghapus data langganan user yang sedang login
    public function destroy()
    {
        $subscribe = Subscribe::where('UserId', auth()->user()->id)->first();

        if (!$subscribe) {
            return response()->json(['message' => 'Langganan tidak ditemukan'], 404);
        }

        $subscribe->delete();

        return response()->json([
            'success' => true,
            'message' => 'Langganan berhasil dihapus'
        ], 200);
    }

    public function authorize()
    {
        
    }
}

*/