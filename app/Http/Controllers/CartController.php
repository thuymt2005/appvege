<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }


    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $quantity = $request->input('quantity', 1);

        // Lấy cart hiện tại của user
        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id(),
        ]);

        // Kiểm tra xem sản phẩm đã tồn tại trong cart chưa
        $item = CartItem::where('cart_id', $cart->id)
                        ->where('product_id', $id)
                        ->first();

        if ($item) {
            // Nếu có, tăng số lượng
            $item->quantity += $quantity;
            $item->save();
        } else {
            // Nếu chưa có, tạo mới
            CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $id,
                'quantity'   => $quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng');
    }


    // /**
    //  * Remove an item from the cart.
    //  *
    //  * @param  int  $itemId
    //  * @return \Illuminate\Http\RedirectResponse
    //  */
    // public function remove($itemId)
    // {
    //     // Logic to remove item from cart
    //     return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    // }
}
