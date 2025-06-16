<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Điều hướng theo role
            if ($user->isAdmin()) {
                return redirect()->route('admin.index');
            }

            if ($user->isUser()) {
                return redirect()->route('home');
            }

            Auth::logout(); // xoá session
            return redirect()->route('login')->withErrors([
                'email' => 'Tài khoản không hợp lệ. Vui lòng đăng nhập lại.',
            ]);
        }

        return $next($request); // nếu chưa đăng nhập, tiếp tục vào login
    }
}
