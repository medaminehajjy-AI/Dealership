<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\PurchaseRequestController;
use App\Http\Controllers\Api\AdminPurchaseRequestController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\AdminCustomerController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\AdminMessageController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\AdminBookingController;
use App\Http\Controllers\Api\ProfileController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/contact',[ContactController::class, 'store']);

Route::get('/cars', [CarController::class, 'index']);
Route::get('/cars/latest', [CarController::class, 'latest']);
Route::get('/cars/{id}', [CarController::class, 'show']);

Route::get('/brands', [BrandController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);



Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    Route::post('/cars/{carId}/favorite', [FavoriteController::class, 'store']);
    Route::delete('/cars/{carId}/favorite', [FavoriteController::class, 'destroy']);
    Route::get('/cars/{carId}/favorite', [FavoriteController::class, 'check']);
    Route::get('/favorites', [FavoriteController::class, 'index']);

    Route::post('/cars/{carId}/purchase-request', [PurchaseRequestController::class, 'store']);
    Route::get('/purchase-requests',[PurchaseRequestController::class, 'index']);

    Route::post('/cars/{id}/booking',[BookingController::class, 'store']);

    Route::get('/profile', [ProfileController::class, 'me']);
    Route::post('/profile/picture',[ProfileController::class, 'updatePicture']);
    Route::post('/profile/password',[ProfileController::class, 'changePassword']);


});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    
    Route::get('/admin/dashboard',[AdminController::class, 'dashboard']);
    Route::get('/admin/statistics', [AdminController::class, 'statistics']);

    Route::get('/admin/purchase-requests', [AdminPurchaseRequestController::class, 'index']);
    Route::patch('/admin/purchase-requests/{id}',[AdminPurchaseRequestController::class, 'updateStatus']);
    Route::get('/admin/cars',[CarController::class, 'indexAdmin']);
    Route::post('/admin/cars',[CarController::class, 'store']);
    Route::get('/admin/cars/{id}',[CarController::class, 'adminShow']);
    Route::put('/admin/cars/{id}',[CarController::class, 'update']);
    Route::delete('/admin/cars/{id}',[CarController::class, 'destroy']);
    Route::post('/admin/cars/{id}/images',[CarController::class, 'uploadImage']);
    Route::delete('/admin/car-images/{id}',[CarController::class, 'deleteImage']);
    Route::get('/admin/customers',[AdminCustomerController::class, 'index']);
    Route::delete('/admin/customers/{id}',[AdminCustomerController::class, 'destroy']);
    Route::get('/admin/messages',[AdminMessageController::class, 'index']);
    Route::patch('/admin/messages/{id}/read',[AdminMessageController::class, 'markAsRead']);
    Route::delete('/admin/messages/{id}',[AdminMessageController::class, 'destroy']);
    Route::get('/admin/bookings',[AdminBookingController::class, 'index']);
    Route::patch('/admin/bookings/{id}',[AdminBookingController::class, 'updateStatus']);

});



