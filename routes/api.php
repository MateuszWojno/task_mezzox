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
    Route::get('/', [\App\Http\Controllers\CustomerController::class, 'index'])
        ->name('customers.index')
        ->middleware(middleware: 'permission:customers.read');


    Route::prefix('customers')->group(function () {
        Route::post(uri: '/', action: [\App\Http\Controllers\CustomerController::class, 'store'])
            ->name(name: 'customers.create')
            ->middleware(middleware: 'permission:customers.create');

        Route::delete(uri: '/{id}', action: [\App\Http\Controllers\CustomerController::class, 'destroy'])
            ->name(name: 'customers.destroy')
            ->middleware(middleware: 'permission:customers.delete');

        Route::get('/{id}', [\App\Http\Controllers\CustomerController::class, 'show'])
            ->name('customers.show')
            ->middleware(middleware: 'permission:customers.read');


    });

    /**
     * Books
     */

    Route::prefix('books')->group(function () {

        Route::get(uri: '/{id}', action: [\App\Http\Controllers\BookController::class, 'show'])
            ->name(name: 'books.show')
            ->middleware(middleware: 'permission:books.read');

        Route::get(uri: '/', action: [\App\Http\Controllers\BookController::class, 'index'])
            ->name(name: 'books.index')
            ->middleware(middleware: 'permission:books.read');

        Route::post('/customers/{customerId}/borrow-book/{bookId}', [\App\Http\Controllers\BookController::class, 'borrowBook'])
            ->name('customers.borrow-book')
            ->middleware(middleware: 'permission:books.read');

        Route::post('/customers/{customerId}/return-book/{bookId}', [\App\Http\Controllers\BookController::class, 'returnBook'])
            ->name('customers.return-book')
            ->middleware(middleware: 'permission:books.read');

        Route::get('/{search}', [\App\Http\Controllers\BookController::class, 'searchBook'])
            ->name('books.search')
            ->middleware('permission:books.search');


    });

});


