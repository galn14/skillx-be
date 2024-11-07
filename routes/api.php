<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\SellerController;
use App\Http\Controllers\Api\MajorController;
use App\Http\Controllers\Api\ServicesController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ComplaintController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\UserSkillController;
use App\Http\Controllers\Api\PortofolioController;
use App\Http\Controllers\Api\BuyerController;

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
    Route::get('/list', [SellerController::class, 'index']); // List all sellers
    Route::post('/input', [SellerController::class, 'store']); // Create a new seller
    Route::get('/{id}', [SellerController::class, 'show']); // Show a specific seller
    Route::put('/update/{id}', [SellerController::class, 'update']); // Update a specific seller
    Route::delete('/delete/{id}', [SellerController::class, 'destroy']); // Delete a specific seller
});

Route::prefix('majors')->middleware('auth:api')->group(function () {
    Route::get('/list', [MajorController::class, 'index']); // List all majors
    Route::post('/input', [MajorController::class, 'store']); // Create a new major
    Route::get('/{id}', [MajorController::class, 'show']); // Show a specific major
    Route::delete('/delete/{id}', [MajorController::class, 'destroy']); // Delete a specific major
});

Route::prefix('services')->middleware('auth:api')->group(function () {
    Route::get('/list', [ServicesController::class, 'index']); // List all services
    Route::post('/input', [ServicesController::class, 'store']); // Create a new service
    Route::get('/{id}', [ServicesController::class, 'show']); // Show a specific service
    Route::delete('/delete/id}', [ServicesController::class, 'destroy']); // Delete a specific service
});

Route::prefix('products')->middleware('auth:api')->group(function () {
    Route::get('/list', [ProductController::class, 'index']); // List all products
    Route::post('/input', [ProductController::class, 'store']); // Create a new product
    Route::get('/{id}', [ProductController::class, 'show']); // Show a specific product
    Route::put('/update', [ProductController::class, 'update']); // Update the authenticated user's product
    Route::delete('/delete/{id}', [ProductController::class, 'destroy']); // Delete a specific product

});

Route::prefix('complaints')->middleware(['auth:api'])->group(function () {
    Route::post('/create', [ComplaintController::class, 'store']);        // Create a complaint
    Route::get('/view/{id}', [ComplaintController::class, 'show']);      // View a specific complaint
    Route::put('/update/{id}', [ComplaintController::class, 'update']);    // Update a complaint
    Route::delete('/delete/{id}', [ComplaintController::class, 'destroy']); // Delete a complaint
});

Route::prefix('skills')->middleware(['auth:api'])->group(function () {
    Route::post('/create', [SkillController::class, 'store']);        // Create a skill
    Route::get('/view/{id}', [SkillController::class, 'show']);      // View a specific skill
    Route::put('/update/{id}', [SkillController::class, 'update']);    // Update a skill
    Route::delete('/delete/{id}', [SkillController::class, 'destroy']); // Delete a skill
});

Route::prefix('user/skills')->middleware(['auth:api'])->group(function () {
    Route::get('/view', [UserSkillController::class, 'index']);         // View user skills
    Route::post('/add', [UserSkillController::class, 'store']);        // Add a skill to user
    Route::delete('/delete/{skillId}', [UserSkillController::class, 'destroy']); // Remove a skill from user
});

Route::prefix('user/portofolios')->middleware(['auth:api'])->group(function () {
    Route::get('/view', [PortofolioController::class, 'index']);          // View all portfolio items
    Route::post('/create', [PortofolioController::class, 'store']);         // Create a new portfolio item
    Route::get('/view/{id}', [PortofolioController::class, 'show']);      // View a specific portfolio item
    Route::put('/update/{id}', [PortofolioController::class, 'update']);    // Update a portfolio item
    Route::delete('/delete/{id}', [PortofolioController::class, 'destroy']); // Delete a portfolio item
});

Route::middleware(['auth:api'])->group(function () {
    Route::get('/buyer', [BuyerController::class, 'show']);            // View buyer profile
    Route::post('/buyer', [BuyerController::class, 'store']);          // Create buyer profile
    Route::put('/buyer', [BuyerController::class, 'update']);          // Update buyer profile
    Route::delete('/buyer', [BuyerController::class, 'destroy']);      // Delete buyer profile
});