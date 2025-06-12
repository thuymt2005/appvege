<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
            return redirect()->route('login')->withErrors([
                'email' => 'Bạn cần đăng nhập để truy cập.',
            ]);
        }

        // Nếu đã đăng nhập thì cho đi tiếp
        return $next($request);
    }
}
