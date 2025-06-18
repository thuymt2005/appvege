<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Hiển thị trang dashboard của quản trị viên
        return view('admin.dashboard');
    }
}
