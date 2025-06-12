<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Hiển thị trang dashboard của người dùng
        return view('user.dashboard');
    }
}
