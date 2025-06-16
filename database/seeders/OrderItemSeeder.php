<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Lấy tất cả đơn hàng
        $orders = Order::all();
        $products = Product::all();

        // Thêm sản phẩm vào mỗi đơn hàng
        foreach ($orders as $order) {
            // Chọn ngẫu nhiên 1-5 sản phẩm cho mỗi đơn hàng
            $randomProducts = $products->random(rand(1, 5));
            $totalPrice = 0;

            foreach ($randomProducts as $product) {
                $quantity = rand(1, 3);
                $price = $product->price;
                $itemTotal = $quantity * $price;
                $totalPrice += $itemTotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);
            }

            // Cập nhật tổng giá trị đơn hàng
            $order->update(['total_price' => $totalPrice]);
        }
    }
}
