<?php

namespace App\Http\Controllers\Api;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    // Menampilkan pesan yang diterima oleh pengguna yang sedang login
    public function index()
{
    $messages = Message::with(['sender', 'receiver'])
        ->where(function($query) {
            $query->where('ReceiverId', Auth::user()->id)
                  ->orWhere('SenderId', Auth::user()->id);
        })
        ->get();

    return response()->json($messages, 200);
}

    // Mengirim pesan baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ReceiverId' => 'required|exists:users,Id', // Pastikan penerima ada dalam database
            'MessageTitle' => 'nullable|string|max:255',
            'MessageContent' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Membuat pesan baru
        $message = new Message();
        $message->SenderId = Auth::user()->id; // Id pengirim (user yang login)
        $message->ReceiverId = $request->ReceiverId;
        $message->MessageTitle = $request->MessageTitle;
        $message->MessageContent = $request->MessageContent;
        $message->save();

        return response()->json([
            'success' => true,
            'data' => $message,
            'message' => 'Pesan berhasil dikirim',
        ], 201);
    }

    // Menghapus pesan
    public function destroy($id)
    {
        $message = Message::where('ReceiverId', Auth::user()->id)
            ->where('IdMessage', $id)
            ->first();

        if (!$message) {
            return response()->json(['message' => 'Pesan tidak ditemukan'], 404);
        }

        $message->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil dihapus',
        ], 200);
    }
}
