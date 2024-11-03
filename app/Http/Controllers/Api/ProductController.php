<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // Display all products
    public function index()
    {
        return response()->json(Product::with(['major', 'service', 'seller'])->get(), 200);
    }

    // Store a new product
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NamaProduct' => 'required|string|max:100',
            'DeskripsiProduct' => 'required|string',
            'FotoProduct' => 'nullable|string|max:255',
            'Price' => 'required|numeric|min:0',
            'IdMajor' => 'nullable|exists:majors,IdMajor',
            'ServicesId' => 'required|exists:services,IdServices',
            'IdSeller' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $product = Product::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $product,
            'message' => 'Product created successfully',
        ], 201);
    }

    // Display a specific product
    public function show($id)
    {
        $product = Product::with(['major', 'service', 'seller'])->find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product, 200);
    }

    // Delete a specific product
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ], 200);
    }
}
