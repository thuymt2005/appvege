<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'), // đổi nếu cần
            'is_admin' => true,
            'phone' => '0123456789',
            'address' => '123 Admin Street',
        ]);

        // Tạo User thường
        User::create([
            'name' => 'Normal User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user'), // đổi nếu cần
            'is_admin' => false,
            'phone' => '0987654321',
            'address' => '456 User Avenue',
        ]);

        // Tạo nhiều user ngẫu nhiên (factory)
        // User::factory()->count(10)->create();
    }
}
