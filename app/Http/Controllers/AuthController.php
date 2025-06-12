<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Hien thi trang dang nhap
    public function login()
    {
        return view('auth.login');
    }

    // Xu ly dang nhap
    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            // Đăng nhập thành công
            $account = Auth::user(); // Lấy đối tượng Account

            if ($account->isAdmin()) {
                return redirect()->route('admin.index');
            }

            if ($account->isUser()) {
                return redirect()->route('user.index');
            }

            // Nếu role không rõ ràng, logout và báo lỗi
            Auth::logout();
            return back()->withErrors([
                'email' => 'Tài khoản không có quyền truy cập.',
            ]);
        }

        // Sai thông tin đăng nhập
        return back()->withErrors([
            'email' => 'Sai tài khoản hoặc mật khẩu.',
        ])->withInput();
    }

    // Hien thi trang dang ky
    public function register()
    {
        return view('auth.register');
    }
    // Xu ly dang ky
    public function registerPost(Request $request)
    {
        return redirect()->route('login')->with('success', 'Đăng ký thành công!');
    }

    // Hien thi trang quen mat khau
    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }
    // Xu ly quen mat khau
    public function forgotPasswordPost(Request $request)
    {
        // $request->validate([
        //     'email' => 'required|email',
        // ]);

        // // Logic xu ly quen mat khau
        // // ...

        return redirect()->route('login')->with('status', 'Link reset password đã được gửi đến email của bạn.');
    }
    // Xu ly dang xuat
    public function logout()
    {
        // Logic xu ly dang xuat
        Auth::logout();
        return redirect()->route('login');
    }
    // Trang chu
    public function home()
    {
        return view('home');
    }
}
