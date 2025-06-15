@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold">Chào mừng, {{ Auth::user()->name }}!</h2>
                    <p class="text-muted mb-0">Quản lý tài khoản và đơn hàng của bạn</p>
                </div>
                <div class="text-end">
                    <small class="text-muted">Lần đăng nhập cuối: {{ Auth::user()->updated_at->format('d/m/Y H:i') }}</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Tổng đơn hàng</h6>
                            <h3 class="mb-0">{{ $totalOrders ?? 0 }}</h3>
                        </div>
                        <div class="opacity-75">
                            <i class="fas fa-shopping-bag fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Đã hoàn thành</h6>
                            <h3 class="mb-0">{{ $completedOrders ?? 0 }}</h3>
                        </div>
                        <div class="opacity-75">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Đang xử lý</h6>
                            <h3 class="mb-0">{{ $pendingOrders ?? 0 }}</h3>
                        </div>
                        <div class="opacity-75">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Tổng chi tiêu</h6>
                            <h3 class="mb-0">{{ number_format($totalSpent ?? 0) }}đ</h3>
                        </div>
                        <div class="opacity-75">
                            <i class="fas fa-wallet fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Quick Actions -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>Thao tác nhanh
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('user.search') }}" class="btn btn-success">
                            <i class="fas fa-shopping-cart me-2"></i>Mua sắm ngay
                        </a>
                        <a href=" " class="btn btn-outline-primary">
                            <i class="fas fa-list me-2"></i>Xem đơn hàng
                        </a>
                        <a href="{{ route('user.profile') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-user-edit me-2"></i>Cập nhật hồ sơ
                        </a>
                        <a href=" " class="btn btn-outline-info">
                            <i class="fas fa-shopping-basket me-2"></i>Giỏ hàng
                            @if(session('cart') && count(session('cart')) > 0)
                                <span class="badge bg-danger">{{ count(session('cart')) }}</span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-history me-2"></i>Đơn hàng gần đây
                    </h5>
                    <a href=" " class="btn btn-sm btn-outline-primary">
                        Xem tất cả
                    </a>
                </div>
                <div class="card-body">
                    @if(isset($recentOrders) && $recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Ngày đặt</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                    <tr>
                                        <td>
                                            <strong>#{{ $order->id }}</strong>
                                        </td>
                                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="text-success fw-bold">
                                                {{ number_format($order->total_amount) }}đ
                                            </span>
                                        </td>
                                        <td>
                                            @switch($order->status)
                                                @case('pending')
                                                    <span class="badge bg-warning">Chờ xử lý</span>
                                                    @break
                                                @case('processing')
                                                    <span class="badge bg-info">Đang xử lý</span>
                                                    @break
                                                @case('shipped')
                                                    <span class="badge bg-primary">Đang giao</span>
                                                    @break
                                                @case('delivered')
                                                    <span class="badge bg-success">Đã giao</span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="badge bg-danger">Đã hủy</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary">Không xác định</span>
                                            @endswitch
                                        </td>
                                        <td>
                                            <a href=" "
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">Bạn chưa có đơn hàng nào</h6>
                            <a href="{{ route('user.search') }}" class="btn btn-success mt-2">
                                <i class="fas fa-shopping-cart me-2"></i>Bắt đầu mua sắm
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Account Information -->
    <div class="row g-4 mt-2">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i>Thông tin tài khoản
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="text-center">
                                <div class="avatar-circle bg-success bg-opacity-10 text-success d-inline-flex align-items-center justify-content-center rounded-circle mb-2" style="width: 60px; height: 60px;">
                                    <i class="fas fa-user fa-2x"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <h6 class="fw-bold">{{ Auth::user()->name }}</h6>
                            <p class="text-muted mb-1">
                                <i class="fas fa-envelope me-2"></i>{{ Auth::user()->email }}
                            </p>
                            @if(Auth::user()->phone)
                                <p class="text-muted mb-1">
                                    <i class="fas fa-phone me-2"></i>{{ Auth::user()->phone }}
                                </p>
                            @endif
                            @if(Auth::user()->address)
                                <p class="text-muted mb-1">
                                    <i class="fas fa-map-marker-alt me-2"></i>{{ Str::limit(Auth::user()->address, 50) }}
                                </p>
                            @endif
                            <a href="{{ route('user.profile') }}" class="btn btn-sm btn-outline-success mt-2">
                                <i class="fas fa-edit me-1"></i>Chỉnh sửa
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Promotional Banner -->
        <div class="col-md-6">
            <div class="card bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white">
                    <h5 class="card-title">
                        <i class="fas fa-gift me-2"></i>Ưu đãi đặc biệt
                    </h5>
                    <p class="card-text">
                        Miễn phí giao hàng cho đơn hàng từ 200,000đ.
                        Áp dụng đến hết tháng này!
                    </p>
                    <a href="{{ route('user.search') }}" class="btn btn-light">
                        <i class="fas fa-shopping-cart me-2"></i>Mua ngay
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
