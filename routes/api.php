<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BuyerController;
use App\Http\Controllers\Api\MajorController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\SellerController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Api\ServicesController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\ComplaintController;
use App\Http\Controllers\Api\FollowingController;
use App\Http\Controllers\Api\KeranjangController;
use App\Http\Controllers\Api\UserSkillController;
use App\Http\Controllers\Api\PortofolioController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\Api\GoogleLoginController;


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

Route::prefix('transactions')->middleware('auth:api')->group(function () {
    Route::get('/', [TransactionController::class, 'index']); // List user's transactions
    Route::post('/', [TransactionController::class, 'store']); // Create a transaction for the user
    Route::get('/{id}', [TransactionController::class, 'show']); // Show a specific transaction of the user
    Route::put('/{id}', [TransactionController::class, 'update']); // Update a transaction of the user
    Route::delete('/{id}', [TransactionController::class, 'destroy']); // Delete a transaction of the user
});

Route::prefix('reviews')->middleware('auth:api')->group(function () {
    Route::get('/', [ReviewController::class, 'index']); // List user's reviews
    Route::post('/', [ReviewController::class, 'store']); // Create a new review
    Route::get('/{id}', [ReviewController::class, 'show']); // Show a specific review of the user
    Route::put('/{id}', [ReviewController::class, 'update']); // Update a review of the user
    Route::delete('/{id}', [ReviewController::class, 'destroy']); // Delete a review of the user
});

Route::prefix('followings')->middleware('auth:api')->group(function () {
    Route::get('/', [FollowingController::class, 'index']); // List followings
    Route::post('/', [FollowingController::class, 'store']); // Follow a seller (restricted to buyers)
    Route::delete('/{id}', [FollowingController::class, 'destroy']); // Unfollow a seller
});

Route::get('login/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::middleware('auth:api')->prefix('wishlist')->group(function () {
    Route::get('/view', [WishlistController::class, 'index']); // Menampilkan wishlist user
    Route::post('/add', [WishlistController::class, 'store']); // Menambah produk ke wishlist
    Route::delete('/{id}', [WishlistController::class, 'destroy']); // Menghapus produk dari wishlist
});

Route::middleware('auth:api')->prefix('keranjang')->group(function () {
    Route::get('/view', [KeranjangController::class, 'index']);
    Route::post('/add', [KeranjangController::class, 'store']);
    Route::delete('/{id}', [KeranjangController::class, 'destroy']);
});

use App\Http\Controllers\Api\NotificationController;

Route::middleware('auth:api')->prefix('notifications')->group(function () {
    Route::get('/view', [NotificationController::class, 'index']);
    Route::post('/add', [NotificationController::class, 'store']);
    Route::delete('/{id}', [NotificationController::class, 'destroy']);
});

use App\Http\Controllers\Api\MessageController;

Route::middleware('auth:api')->prefix('messages')->group(function () {
    Route::get('/view', [MessageController::class, 'index']); // Menampilkan pesan yang diterima
    Route::post('/send', [MessageController::class, 'store']); // Mengirim pesan
    Route::delete('/{id}', [MessageController::class, 'destroy']); // Menghapus pesan
});

Route::get('/firebase/test', [TestController::class, 'testFirebase']);
Route::post('/google-login', [GoogleLoginController::class, 'googleLogin']);
