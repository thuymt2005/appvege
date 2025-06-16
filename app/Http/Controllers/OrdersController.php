<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        // Logic to retrieve and display orders
        return view('orders.index');
    }

    public function show($orderId)
    {
        // Logic to retrieve and display a specific order
        return view('orders.show', ['orderId' => $orderId]);
    }
}
