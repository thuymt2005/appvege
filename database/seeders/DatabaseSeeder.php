<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Gọi các seeder ở đây
        $this->call([
            AccountSeeder::class,
        ]);
    }
}
