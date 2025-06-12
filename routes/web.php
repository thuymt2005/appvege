<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authcontroller;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [Authcontroller::class, 'index'])->name('login');
Route::post('/login', [Authcontroller::class, 'login'])->name('login.post');
Route::get('/register', [Authcontroller::class, 'register'])->name('register');
Route::post('/register', [Authcontroller::class, 'registerPost'])->name('register.post');
Route::get('/logout', [Authcontroller::class, 'logout'])->name('logout');
// Route::get('/dashboard', [Authcontroller::class, 'dashboard'])->name('dashboard')->middleware('auth');


