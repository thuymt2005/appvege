<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    #index
    public function index()
    {
        // Doanh thu tháng này (theo created_at và status = 'completed')
        $monthlyRevenue = Order::where('status', 'completed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_price');

        // Các dữ liệu khác
        $totalOrders = Order::count();
        $completedOrders = Order::where('status', 'completed')->count();
        $orders = Order::latest()->paginate(10); // dùng phân trang nếu cần

        return view('admin.orders.index', compact(
            'monthlyRevenue',
            'totalOrders',
            'completedOrders',
            'orders'
        ));
    }
    #show
    public function show($id)
    {
        // Logic to show a specific order
        return view('admin.orders.show', ['orderId' => $id]);
    }
}
