<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Hien thi trang dang nhap
    public function index()
    {
        return view('auth.login');
    }

    // Xu ly dang nhap
    public function login(Request $request)
    {
        // Logic xu ly dang nhap
        // ...
        return redirect()->route('home');
    }
    // Hien thi trang dang ky
    public function register()
    {
        return view('auth.register');
    }
    // Xu ly dang ky
    public function registerPost(Request $request)
    {
        // Logic xu ly dang ky
        // ...
        return redirect()->route('home');
    }
    // Xu ly dang xuat
    public function logout()
    {
        // Logic xu ly dang xuat
        // ...
        return redirect()->route('login');
    }
    // Trang chu
    public function home()
    {
        return view('home');
    }
}
