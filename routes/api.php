<?php

use App\Http\Controllers\Admin\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\ProductController;

//Route::post('/reset-email', [PasswordResetController::class, 'send_reset_password_email']);
//Route::post('/reset-password/{token}', [PasswordResetController::class, 'reset']);


Route::middleware(['api'])->group(function () {
    // Fetch products for the authenticated vendor
    Route::get('/products',[ProductController::class, 'index']);
});

Route::middleware('api')->group(function () {
    //Admin
    Route::post('/register-a', [AdminController::class, 'loginRegister']);
    Route::post('/login-a', [AdminController::class, 'loginAdmin']);
}); 

Route::middleware('api')->group(function () {
    //User
    Route::get('/test/{id?}',[UserController::class, 'test']);
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/logout', [UserController::class, 'logout']);
 
});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/get-u', [UserController::class, 'get']);
    Route::post('/change', [UserController::class, 'change_password']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});