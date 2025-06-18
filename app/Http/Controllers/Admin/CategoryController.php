<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    #index
    public function index()
    {
        // Logic to list categories
        return view('admin.categories.index');
    }
}
