<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CartItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Lấy tất cả giỏ hàng
        $carts = Cart::all();
        $products = Product::all();

        // Thêm sản phẩm vào một số giỏ hàng
        foreach ($carts as $cart) {
            // Chọn ngẫu nhiên 1-3 sản phẩm cho mỗi giỏ hàng
            $randomProducts = $products->random(rand(1, 3));

            foreach ($randomProducts as $product) {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'quantity' => rand(1, 5),
                ]);
            }
        }
    }
}
