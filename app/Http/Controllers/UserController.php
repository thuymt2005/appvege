<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
    {
        // Hiển thị trang dashboard của người dùng
        return view('user.dashboard');
    }
    public function profile()
    {
        // Hiển thị trang thông tin cá nhân của người dùng
        return view('user.profile');
    }
}
