<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function home()
    {
        // Hiển thị trang dashboard của người dùng
        return view('home');
    }
    public function profile()
    {
        // Hiển thị trang thông tin cá nhân của người dùng
        return view('auth.profile');
    }
    public function search()
    {
        return 123;
    }
}
