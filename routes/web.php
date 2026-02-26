<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;

Route::get('/shop', [ShopController::class, 'index'])->name('shop');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/sync', [CartController::class, 'syncGuest'])->name('cart.sync');
use App\Http\Controllers\CheckoutController;

Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/confirmation', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/contacts', function () {
    return view('contacts');
})->name('contacts');



Route::get('/appointments/create/{service}', [App\Http\Controllers\AppointmentController::class, 'create'])->name('appointments.create');
Route::post('/appointments', [App\Http\Controllers\AppointmentController::class, 'store'])->name('appointments.store');
Route::get('/appointments', [App\Http\Controllers\AppointmentController::class, 'index'])->name('appointments.index');
Route::get('/appointments/{appointment}', [App\Http\Controllers\AppointmentController::class, 'show'])->name('appointments.show');
Route::post('/appointments/{appointment}/cancel', [App\Http\Controllers\AppointmentController::class, 'cancel'])->name('appointments.cancel');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('orders', App\Http\Controllers\OrderController::class, ['only' => ['index', 'show']]);
});

Route::middleware(['auth', 'user'])->group(function () {
    Route::resource('posts', App\Http\Controllers\PostController::class);
    Route::resource('categories', App\Http\Controllers\CategoryController::class, ['only' => ['index', 'show']]);
    Route::resource('users', App\Http\Controllers\UserController::class, ['only' => ['show', 'edit', 'update']]);
});

require __DIR__ . '/admin.php';
