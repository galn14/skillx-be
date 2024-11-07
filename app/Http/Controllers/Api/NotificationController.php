<?php

namespace App\Http\Controllers\Api;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    // Menampilkan semua notifikasi untuk user yang sedang login
    public function index()
    {
        $notifications = Notification::where('UserId', Auth::user()->id)
                                     ->orderBy('Time', 'desc')
                                     ->get();

        return response()->json($notifications, 200);
    }

    // Menambahkan notifikasi baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Title' => 'required|string|max:255',
            'Description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $notification = new Notification();
        $notification->UserId = Auth::user()->id; // ID user yang sedang login
        $notification->Title = $request->Title;
        $notification->Description = $request->Description;
        $notification->Time = now(); // Waktu saat notifikasi dibuat
        $notification->save();

        return response()->json([
            'success' => true,
            'data' => $notification,
            'message' => 'Notifikasi berhasil ditambahkan',
        ], 201);
    }

    // Menghapus notifikasi berdasarkan ID
    public function destroy($id)
    {
        $notification = Notification::where('UserId', Auth::user()->id)
                                    ->where('IdNotification', $id)
                                    ->first();

        if (!$notification) {
            return response()->json(['message' => 'Notifikasi tidak ditemukan'], 404);
        }

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi berhasil dihapus',
        ], 200);
    }
}
