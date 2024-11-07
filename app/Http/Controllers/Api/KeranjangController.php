<?php

namespace App\Http\Controllers\Api;

use App\Models\Keranjang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KeranjangController extends Controller
{
    // Menampilkan semua item keranjang user yang sedang login
    public function index()
    {
        $keranjangs = Keranjang::with('product')
            ->where('UserId', Auth::user()->id)
            ->get();

        return response()->json($keranjangs, 200);
    }

    // Menambahkan produk ke keranjang
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'IdProduct' => 'required|exists:products,IdProduct',
            'Quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Cek apakah produk sudah ada di keranjang
        $existingKeranjang = Keranjang::where('UserId', Auth::user()->id)
            ->where('IdProduct', $request->IdProduct)
            ->first();

        if ($existingKeranjang) {
            // Update quantity jika produk sudah ada di keranjang
            $existingKeranjang->Quantity += $request->Quantity;
            $existingKeranjang->save();

            return response()->json([
                'success' => true,
                'message' => 'Quantity produk berhasil diperbarui di keranjang',
                'data' => $existingKeranjang,
            ], 200);
        }

        // Tambahkan produk ke keranjang
        $keranjang = new Keranjang();
        $keranjang->UserId = Auth::user()->id;
        $keranjang->IdProduct = $request->IdProduct;
        $keranjang->Quantity = $request->Quantity;
        $keranjang->save();

        return response()->json([
            'success' => true,
            'data' => $keranjang,
            'message' => 'Produk berhasil ditambahkan ke keranjang',
        ], 201);
    }

    // Menghapus produk dari keranjang
    public function destroy($id)
    {
        $keranjang = Keranjang::where('UserId', Auth::user()->id)
            ->where('IdKeranjang', $id)
            ->first();

        if (!$keranjang) {
            return response()->json(['message' => 'Item keranjang tidak ditemukan'], 404);
        }

        $keranjang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus dari keranjang',
        ], 200);
    }
}
