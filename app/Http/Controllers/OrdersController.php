<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function index()
    {
        // Logic to retrieve and display orders
        return view('orders.index');
    }

    public function show($orderId)
    {
        // Logic to retrieve and display a specific order
        return view('orders.show', ['orderId' => $orderId]);
    }

    public function checkout(Request $request)
    {
        $user = auth()->user();

        // Lấy giỏ hàng đang hoạt động của user
        $cart = Cart::where('user_id', $user->id)
                    ->where('is_active', true)
                    ->with('cartItems')
                    ->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Giỏ hàng trống hoặc không tồn tại.');
        }

        // TODO: Xử lý lưu đơn hàng vào bảng orders (nếu cần)

        // Xóa sạch các item trong giỏ
        $cart->cartItems()->delete();

        // (Tùy chọn) Đánh dấu giỏ hàng là đã thanh toán, nếu bạn không muốn dùng lại giỏ
        // $cart->is_active = false;
        // $cart->save();

        return redirect()->route('cart')->with('success', 'Đơn hàng đã được thanh toán và giỏ hàng đã được làm trống.');
    }

}
