<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () {
    Route::crud('user', 'UserController');
    Route::crud('book', 'BookController');
    Route::crud('role', 'RoleController');
    Route::crud('permission', 'PermissionController');
    Route::crud('author', 'AuthorController');
    Route::crud('category', 'CategoryController');
    Route::crud('sale', 'SaleController');
    Route::crud('voucher', 'VoucherController');
});
