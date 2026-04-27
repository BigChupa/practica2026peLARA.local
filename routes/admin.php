<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminAuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware([\App\Http\Middleware\AdminAreaAuth::class])->group(function () {
        Route::get('/sales-data', [AdminController::class, 'salesData'])->name('sales.data');
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::resource('products', ProductController::class);
        Route::resource('cars', CarController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('orders', OrderController::class, ['only' => ['index', 'show', 'update', 'destroy']]);
        Route::resource('users', UserController::class, ['only' => ['index', 'show', 'edit', 'update', 'destroy']]);
        Route::get('/sto-appointments', [AdminController::class, 'stoAppointments'])->name('sto.appointments');
        Route::post('/sto-appointments/{appointment}/verify', [AdminController::class, 'verifyStoAppointment'])->name('sto.appointments.verify');
    });
});
