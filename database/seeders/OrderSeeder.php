<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Lấy tất cả người dùng có role là 'user'
        $users = User::where('role', 'user')->get();

        // Các trạng thái đơn hàng
        $statuses = ['pending', 'processing', 'completed', 'cancelled'];
        $paymentStatuses = ['unpaid', 'paid', 'refunded'];
        $paymentMethods = ['COD', 'Bank Transfer', 'Credit Card', 'Momo', 'ZaloPay'];

        // Tạo đơn hàng cho mỗi người dùng
        foreach ($users as $user) {
            // Tạo 1-3 đơn hàng cho mỗi người dùng
            $orderCount = rand(1, 3);

            for ($i = 0; $i < $orderCount; $i++) {
                $status = $statuses[array_rand($statuses)];
                $paymentStatus = $paymentStatuses[array_rand($paymentStatuses)];

                // Nếu đơn hàng đã hoàn thành, thanh toán thường là đã trả
                if ($status === 'completed') {
                    $paymentStatus = 'paid';
                }

                // Nếu đơn hàng bị hủy, thanh toán có thể là chưa trả hoặc đã hoàn tiền
                if ($status === 'cancelled') {
                    $paymentStatus = rand(0, 1) ? 'unpaid' : 'refunded';
                }

                Order::create([
                    'user_id' => $user->id,
                    'total_price' => rand(50000, 1000000) / 100 * 100, // Làm tròn đến hàng trăm
                    'status' => $status,
                    'payment_status' => $paymentStatus,
                    'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                    'address' => $user->address ?? 'Địa chỉ mặc định, Quận 1, TP.HCM',
                    'delivery_date' => $status === 'pending' || $status === 'processing' ?
                                       now()->addDays(rand(1, 7)) :
                                       ($status === 'completed' ? now()->subDays(rand(1, 30)) : null),
                ]);
            }
        }
    }
}
