@extends('layouts.app')

@section('title', 'Đơn hàng của tôi')

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
                        <a href="{{ route('user.dashboard') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-tachometer-alt me-2"></i> Tổng quan
                        </a>
                        <a href="{{ route('user.profile') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-user-edit me-2"></i> Thông tin cá nhân
                        </a>
                        <a href="{{ route('orders.index') }}" class="list-group-item list-group-item-action active">
                            <i class="fas fa-shopping-bag me-2"></i> Đơn hàng của tôi
                        </a>
                        <a href="{{ route('cart.index') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-shopping-cart me-2"></i> Giỏ hàng
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Đơn hàng của tôi</h5>

                    <div class="btn-group">
                        <a href="" class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline-primary' }}">
                            Tất cả
                        </a>
                        <a href="" class="btn btn-sm {{ request('status') == 'pending' ? 'btn-primary' : 'btn-outline-primary' }}">
                            Chờ xác nhận
                        </a>
                        <a href="" class="btn btn-sm {{ request('status') == 'processing' ? 'btn-primary' : 'btn-outline-primary' }}">
                            Đang xử lý
                        </a>
                        <a href="" class="btn btn-sm {{ request('status') == 'shipped' ? 'btn-primary' : 'btn-outline-primary' }}">
                            Đang giao
                        </a>
                        <a href="" class="btn btn-sm {{ request('status') == 'delivered' ? 'btn-primary' : 'btn-outline-primary' }}">
                            Đã giao
                        </a>
                        <a href="" class="btn btn-sm {{ request('status') == 'cancelled' ? 'btn-primary' : 'btn-outline-primary' }}">
                            Đã hủy
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(count($orders ?? []) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Ngày đặt</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Thanh toán</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ number_format($order->total, 0, ',', '.') }}đ</td>
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
                                        <td>
                                            @if($order->payment_status == 'paid')
                                                <span class="badge bg-success">Đã thanh toán</span>
                                            @else
                                                <span class="badge bg-warning">Chưa thanh toán</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="" class="btn btn-sm btn-outline-primary me-2">
                                                    Chi tiết
                                                </a>

                                                @if($order->status == 'pending')
                                                    <form action="" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')">
                                                            Hủy
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $orders->withQueryString()->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                            <h5>Không có đơn hàng nào</h5>
                            <p class="text-muted">Bạn chưa có đơn hàng nào trong mục này</p>
                            <a href="{{ url('/') }}" class="btn btn-primary mt-2">
                                Mua sắm ngay
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
