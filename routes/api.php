<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\AddressController;

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
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
        Route::get('verify/{code}', 'verify');
        Route::post('password/reset', 'resetPassword')->name('password.reset');
        Route::post('password/change', 'changePassword');
        Route::get('logout', 'logout');
    });
});

Route::controller(ProfileController::class)->group(function () {
    Route::get('profiles', 'getProfile');
    Route::post('profiles', 'updateProfile');
});
Route::controller(BookController::class)->group(function () {
    Route::get('books', 'index');
    Route::get('books/{id}', 'show');
});
Route::resource('addresses', AddressController::class);
Route::resource('carts', CartController::class);
