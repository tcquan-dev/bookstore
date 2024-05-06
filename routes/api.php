<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\DeliveryAddressController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'prefix' => 'auth'
], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
        Route::get('verify/{code}', 'verify');
    });
});

Route::group([
    'middleware' => 'jwt.auth'
], function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::get('profiles', 'getProfile');
        Route::match(['put', 'patch'], 'profiles', [ProfileController::class, 'updateProfile']);
    });
    Route::resource('delivery_addresses', DeliveryAddressController::class);
    Route::resource('carts', CartController::class);
});
