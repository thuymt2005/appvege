<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
            $account = Auth::user();

            if ($account->isAdmin()) {
                return redirect()->route('admin.index');
            }

            if ($account->isUser()) {
                return redirect()->route('user.dashboard');
            }

            Auth::logout();
            return back()->withErrors([
                'email' => 'Tài khoản không có quyền truy cập.',
            ]);
        }

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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:accounts,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $account = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // mặc định người đăng ký là user
        ]);

        Auth::login($account); // tự động đăng nhập sau khi đăng ký

        return redirect()->route('user.dasboard'); // chuyển về trang user
    }

    // Hien thi trang quen mat khau
    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    // Xu ly quen mat khau
    public function forgotPasswordPost(Request $request)
    {
        return redirect()->route('login')->with('status', 'Link reset password đã được gửi đến email của bạn.');
    }
    // Xu ly dang xuat
    public function logout()
    {
        // Logic xu ly dang xuat
        Auth::logout();
        return redirect()->route('login');
    }
}
