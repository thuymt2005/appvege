<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tạo tài khoản admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'address' => '123 Admin Street, Admin City',
            'phone' => '0123456789',
            'role' => 'admin',
        ]);

        // Tạo một số tài khoản người dùng thông thường
        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'address' => '456 User Avenue, User Town',
            'phone' => '0987654321',
            'role' => 'user',
        ]);

        // Tạo thêm 10 người dùng ngẫu nhiên
        // User::factory()->count(10)->create();
    }
}
