<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::with(['cartItems.product.category'])
                    ->where('user_id', auth()->id())
                    ->where('is_active', 1)
                    ->first();

        $suggestedProducts = Product::inRandomOrder()->limit(3)->get(); // Tùy chọn
        $featuredCategories = Category::limit(3)->get(); // Tùy chọn

        return view('cart.index', compact('cart', 'suggestedProducts', 'featuredCategories'));
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


    public function remove($id)
    {
        $cartItem = \App\Models\CartItem::find($id);

        if (!$cartItem || $cartItem->cart->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy sản phẩm trong giỏ hàng']);
        }

        $cart = $cartItem->cart;

        // Xoá sản phẩm khỏi cart_items
        $cartItem->delete();

        // Kiểm tra nếu giỏ hàng đã trống, có thể xử lý tuỳ ý
        $isCartEmpty = $cart->cartItems()->count() === 0;

        return response()->json([
            'success' => true,
            'cartEmpty' => $isCartEmpty
        ]);
    }

}
