<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    #index
    public function index()
    {
        // Logic to list orders
        return view('admin.orders.index');
    }
    #show
    public function show($id)
    {
        // Logic to show a specific order
        return view('admin.orders.show', ['orderId' => $id]);
    }
}
