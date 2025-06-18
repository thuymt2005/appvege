<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //index
    public function index()
    {
        // Logic to list products
        return view('admin.products.index');
    }
}
