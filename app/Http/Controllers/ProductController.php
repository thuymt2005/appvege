<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Logic to retrieve and display products
        return view('products.index');
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
