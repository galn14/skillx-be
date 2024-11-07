<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    // Menampilkan wishlist user yang sedang login
    public function index()
    {
        $wishlists = Wishlist::with('product')
        ->where('UserId', Auth::user()->id) // Menggunakan Auth::user() sebagai alternatif
        ->get();

    return response()->json($wishlists, 200);
    }

    // Menambahkan produk ke wishlist
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'IdProduct' => 'required|exists:products,IdProduct',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Cek apakah produk sudah ada di wishlist
        $existingWishlist = Wishlist::where('UserId', Auth::user()->id)
            ->where('IdProduct', $request->IdProduct)
            ->first();

        if ($existingWishlist) {
            return response()->json([
                'success' => false,
                'message' => 'Produk sudah ada di wishlist',
            ], 409);
        }

        // Tambahkan produk ke wishlist
        $wishlist = new Wishlist();
        $wishlist->UserId = Auth::user()->id;
        $wishlist->IdProduct = $request->IdProduct;
        $wishlist->save();

        return response()->json([
            'success' => true,
            'data' => $wishlist,
            'message' => 'Produk berhasil ditambahkan ke wishlist',
        ], 201);
    }

    // Menghapus produk dari wishlist
    public function destroy($id)
    {
        $wishlist = Wishlist::where('UserId', Auth::user()->id)
            ->where('IdWishlist', $id)
            ->first();

        if (!$wishlist) {
            return response()->json(['message' => 'Wishlist tidak ditemukan'], 404);
        }

        $wishlist->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus dari wishlist'
        ], 200);
    }
}
