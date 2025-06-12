<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Hiển thị trang dashboard của quản trị viên
        return view('admin.dashboard');
    }
}
