<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\SellerController;
use App\Http\Controllers\Api\MajorController;

/**
 * route "/register"
 * @method "POST"
 */
Route::post('/register', App\Http\Controllers\Api\RegisterController::class)->name('register');

/**
 * route "/login"
 * @method "POST"
 */
Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');

/**
 * route "/user"
 * @method "GET"
 */
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * route "/logout"
 * @method "POST"
 */
Route::post('/logout', [App\Http\Controllers\Api\LogoutController::class, 'logout'])->middleware('auth:api');


/**
 * route "/validate-token"
 * @method "GET"
 */
Route::get('/validate-token', [App\Http\Controllers\Api\TokenValidationController::class, 'validateToken']);



Route::prefix('sellers')->middleware('auth:api')->group(function () {
    Route::get('/profile', [SellerController::class, 'profile']); // Get the authenticated seller's profile
    Route::get('/', [SellerController::class, 'index']); // List all sellers
    Route::post('/', [SellerController::class, 'store']); // Create a new seller
    Route::get('/{id}', [SellerController::class, 'show']); // Show a specific seller
    Route::put('/{id}', [SellerController::class, 'update']); // Update a specific seller
    Route::delete('/{id}', [SellerController::class, 'destroy']); // Delete a specific seller
});

Route::prefix('majors')->middleware('auth:api')->group(function () {
    Route::get('/', [MajorController::class, 'index']); // List all majors
    Route::post('/', [MajorController::class, 'store']); // Create a new major
    Route::get('/{id}', [MajorController::class, 'show']); // Show a specific major
    Route::delete('/{id}', [MajorController::class, 'destroy']); // Delete a specific major
});
