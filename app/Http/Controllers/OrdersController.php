<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        // Logic to retrieve and display orders
        return view('user.orders.index');
    }
}
