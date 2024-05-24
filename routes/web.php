<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\SaleController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\CartController;
use App\Http\Controllers\Home\OrderController;
use App\Http\Controllers\Home\AddressController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/home', 'index');
    Route::get('/profiles', 'getProfileForm')->name('profiles');
    Route::post('/profiles/update', 'updateProfile')->name('profiles.update');
});
Route::resource('addresses', AddressController::class);
Route::controller(SaleController::class)->group(function () {
    Route::get('sales', 'index');
});
Route::resource('carts', CartController::class)->middleware('auth.backpack');
Route::resource('orders', OrderController::class);
