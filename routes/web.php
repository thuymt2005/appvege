<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

use App\Http\Middleware\LoginMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use App\Http\Middleware\AuthMiddleware;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([AuthMiddleware::class])->group(function () {
    Route::get('/login', [Authcontroller::class, 'login'])->name('login');
    Route::post('/login', [Authcontroller::class, 'loginPost'])->name('login.post');
    Route::get('/register', [Authcontroller::class, 'register'])->name('register');
    Route::post('/register', [Authcontroller::class, 'registerPost'])->name('register.post');
    Route::get('/forgot-password',[Authcontroller::class, 'forgotPassword' ])->name('forgot-password');
    Route::post('/forgot-password', [Authcontroller::class, 'forgotPasswordPost'])->name('forgot-password.post');
});

Route::middleware([LoginMiddleware::class])->group(function () {
    Route::post('/logout', [Authcontroller::class, 'logout'])->name('logout');
});

Route::middleware([LoginMiddleware::class, AdminMiddleware::class])->group(function () {
    Route::resource('admin', AdminController::class);
});

Route::middleware([LoginMiddleware::class, UserMiddleware::class])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/user/search', [UserController::class, 'search'])->name('user.search');
});
