<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'birthday' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
        ]);

        $user = Auth::user();

        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->date_of_birth = $request->input('birthday');
        $user->gender = $request->input('gender');

        $user->save();

        return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
    }
}
