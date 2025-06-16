<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Rau củ quả',
            'Trái cây',
            'Thịt tươi',
            'Hải sản',
            'Thực phẩm khô',
            'Đồ uống',
            'Bánh kẹo',
            'Sữa và các sản phẩm từ sữa',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
            ]);
        }
    }
}
