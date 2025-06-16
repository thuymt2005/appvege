<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
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

        // Tạo giỏ hàng cho mỗi người dùng
        foreach ($users as $user) {
            Cart::create([
                'user_id' => $user->id,
                'is_active' => true,
            ]);
        }
    }
}
