<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(12);
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
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
