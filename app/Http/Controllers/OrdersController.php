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
        $cart = Cart::where('user_id', $user->id)->where('is_active', true)->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Giỏ hàng trống hoặc không tồn tại.');
        }

        // Xử lý lưu đơn hàng (tùy chọn – có thể bạn sẽ cần lưu vào bảng orders ở đây)

        // Đánh dấu giỏ hàng này là đã thanh toán
        $cart->is_active = false;
        $cart->save();

        // Tạo giỏ hàng mới cho user nếu cần (nếu bạn muốn mỗi người chỉ có 1 giỏ hàng đang hoạt động)
        Cart::create([
            'user_id' => $user->id,
            'is_active' => true,
        ]);

        return redirect()->route('cart')->with('success', 'Đơn hàng đã được thanh toán.');
    }
}
