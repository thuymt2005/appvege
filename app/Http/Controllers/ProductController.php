<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(12); // hoặc all()

        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        // Logic to retrieve a single product by ID
        return view('products.show', ['product' => $id]);
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
