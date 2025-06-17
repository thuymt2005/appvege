<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        $categories = Category::all();

        $allProducts = $products->map(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'unit' => $product->unit,
                'stock_quantity' => $product->stock_quantity,
                'category' => [
                    'name' => $product->category->name ?? 'Không rõ',
                    'slug' => $product->category->slug ?? 'unknown',
                ],
                'image_url' => asset($product->image_url ?? 'images/default.jpg'),
                'views' => $product->views ?? 0,
                'created_at' => $product->created_at->format('Y-m-d'),
            ];
        });

        return view('products.index', compact('products', 'categories', 'allProducts'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }


    public function create()
    {
        // Logic to show the form for creating a new product
        return view('products.create');
    }

    public function store(Request $request)
    {
        // Logic to store a new product
        // Validate and save the product data
        return redirect()->route('products.index');
    }
}
