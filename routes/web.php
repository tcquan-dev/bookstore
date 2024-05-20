<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Home\AddressController;
use App\Http\Controllers\Home\CartController;

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
Route::resource('carts', CartController::class);
