<?php

use Illuminate\Support\Facades\Route;

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

Route::prefix('auth')->group(function () {

    /**
     * Login
     */
    Route::post(uri: '/login', action: [\App\Http\Controllers\AuthController::class, 'login'])
        ->name(name: 'auth.login');

    /**
     * Registration
     */
    Route::post(uri: '/register', action: [\App\Http\Controllers\AuthController::class, 'register'])
        ->name(name: 'auth.register');


    /**
     * Customers
     */

    Route::prefix('customers')->group(function () {
        Route::post(uri: '/', action: [\App\Http\Controllers\CustomerController::class, 'store'])
            ->name(name: 'customers.create')
            ->middleware(middleware: 'permission:customers.create');

        Route::delete(uri: '/{id}', action: [\App\Http\Controllers\CustomerController::class, 'destroy'])
            ->name(name: 'customers.destroy')
            ->middleware(middleware: 'permission:customers.delete');

    });

});


