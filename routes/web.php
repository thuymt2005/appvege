<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrdersController;

use App\Http\Middleware\LoginMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use App\Http\Middleware\AuthMiddleware;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('home') : view('welcome');
});
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');


Route::middleware([AuthMiddleware::class])->group(function () {
    Route::get('/login', [Authcontroller::class, 'login'])->name('login');
    Route::post('/login', [Authcontroller::class, 'loginPost'])->name('login.post');
    Route::get('/register', [Authcontroller::class, 'register'])->name('register');
    Route::post('/register', [Authcontroller::class, 'registerPost'])->name('register.post');
});

Route::middleware([LoginMiddleware::class])->group(function () {
    Route::post('/logout', [Authcontroller::class, 'logout'])->name('logout');
});

Route::middleware([LoginMiddleware::class, AdminMiddleware::class])->group(function () {
    Route::resource('admin', AdminController::class);
});

Route::middleware([LoginMiddleware::class, UserMiddleware::class])->group(function () {
    Route::get('/home', [UserController::class, 'home'])->name('home');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [UserController::class, 'update'])->name('profile.update');

    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{product_id}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');


    Route::get('/orders', [OrdersController::class, 'index'])->name('orders.index');
    Route::get('/orders/{orderId}', [OrdersController::class, 'show'])->name('orders.show');
    Route::post('/orders/checkout/', [OrdersController::class, 'checkout'])->name('orders.checkout');
});
