@extends('layouts.app')

@section('title', 'Trang cá nhân')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="avatar mb-3">
                            <i class="fas fa-user-circle fa-5x text-primary"></i>
                        </div>
                        <h5>{{ Auth::user()->name }}</h5>
                        <p class="text-muted">{{ Auth::user()->email }}</p>
                    </div>

                    <div class="list-group list-group-flush">
                        <a href="{{ route('user.dashboard') }}" class="list-group-item list-group-item-action active">
                            <i class="fas fa-tachometer-alt me-2"></i> Tổng quan
                        </a>
                        <a href="{{ route('user.profile') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-user-edit me-2"></i> Thông tin cá nhân
                        </a>
                        <a href="" class="list-group-item list-group-item-action">
                            <i class="fas fa-shopping-bag me-2"></i> Đơn hàng của tôi
                        </a>
                        <a href="" class="list-group-item list-group-item-action">
                            <i class="fas fa-shopping-cart me-2"></i> Giỏ hàng
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h4 class="card-title mb-4">Xin chào, {{ Auth::user()->name }}!</h4>
                    <p>Chào mừng bạn đến với trang quản lý tài khoản VegMarket.</p>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Đơn hàng gần đây</h5>
                </div>
                <div class="card-body">
                    @if(count($recentOrders ?? []) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Ngày đặt</th>
                                        <th>Trạng thái</th>
                                        <th>Tổng tiền</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            @if($order->status == 'pending')
                                                <span class="badge bg-warning">Chờ xác nhận</span>
                                            @elseif($order->status == 'processing')
                                                <span class="badge bg-info">Đang xử lý</span>
                                            @elseif($order->status == 'shipped')
                                                <span class="badge bg-primary">Đang giao</span>
                                            @elseif($order->status == 'delivered')
                                                <span class="badge bg-success">Đã giao</span>
                                            @elseif($order->status == 'cancelled')
                                                <span class="badge bg-danger">Đã hủy</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($order->total, 0, ',', '.') }}đ</td>
                                        <td>
                                            <a href="" class="btn btn-sm btn-outline-primary">
                                                Chi tiết
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end">
                            <a href="" class="btn btn-link text-decoration-none">
                                Xem tất cả đơn hàng <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                            <p>Bạn chưa có đơn hàng nào.</p>
                            <a href="{{ url('/') }}" class="btn btn-primary mt-2">
                                Mua sắm ngay
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recommended Products -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Có thể bạn sẽ thích</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($recommendedProducts ?? [] as $product)
                        <div class="col-md-4 mb-3">
                            <div class="card product-card h-100">
                                <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $product->name }}</h6>
                                    <p class="text-primary fw-bold">{{ number_format($product->price, 0, ',', '.') }}đ</p>
                                    <a href="" class="btn btn-sm btn-outline-primary">
                                        Xem chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
