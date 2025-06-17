@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng #' . $order->id)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2>Chi tiết đơn hàng #{{ $order->id }}</h2>
                    <p class="text-muted mb-0">Đặt hàng ngày {{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại danh sách
                </a>
            </div>

            <div class="row">
                <!-- Thông tin đơn hàng -->
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-box"></i> Sản phẩm đã đặt
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th class="text-center">Số lượng</th>
                                            <th class="text-end">Đơn giá</th>
                                            <th class="text-end">Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->orderDetails as $detail)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        @if($detail->product->image)
                                                            <img src="{{ asset('storage/products/' . $detail->product->image) }}"
                                                                 alt="{{ $detail->product->name }}"
                                                                 class="rounded"
                                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                                        @else
                                                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                                 style="width: 60px; height: 60px;">
                                                                <i class="fas fa-image text-muted"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1">{{ $detail->product->name }}</h6>
                                                        <small class="text-muted">
                                                            {{ $detail->product->category->name ?? 'Chưa phân loại' }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center align-middle">
                                                <span class="badge bg-light text-dark">{{ $detail->quantity }}</span>
                                            </td>
                                            <td class="text-end align-middle">
                                                {{ number_format($detail->price, 0, ',', '.') }}đ
                                            </td>
                                            <td class="text-end align-middle">
                                                <strong>{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}đ</strong>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Thông tin giao hàng -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-truck"></i> Thông tin giao hàng
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-2">Người nhận</h6>
                                    <p class="mb-3">
                                        <strong>{{ $order->shipping_name }}</strong><br>
                                        <i class="fas fa-phone text-muted me-1"></i> {{ $order->shipping_phone }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-2">Địa chỉ giao hàng</h6>
                                    <p class="mb-3">
                                        <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                        {{ $order->shipping_address }}
                                    </p>
                                </div>
                            </div>

                            @if($order->notes)
                            <div class="mt-3">
                                <h6 class="text-muted mb-2">Ghi chú</h6>
                                <p class="mb-0 p-3 bg-light rounded">
                                    <i class="fas fa-sticky-note text-muted me-1"></i>
                                    {{ $order->notes }}
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar thông tin tổng quan -->
                <div class="col-md-4">
                    <!-- Trạng thái đơn hàng -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-info-circle"></i> Trạng thái đơn hàng
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                @php
                                    $statusConfig = [
                                        'pending' => ['class' => 'warning', 'icon' => 'clock', 'text' => 'Chờ xác nhận'],
                                        'confirmed' => ['class' => 'info', 'icon' => 'check-circle', 'text' => 'Đã xác nhận'],
                                        'shipping' => ['class' => 'primary', 'icon' => 'truck', 'text' => 'Đang giao hàng'],
                                        'delivered' => ['class' => 'success', 'icon' => 'check-double', 'text' => 'Đã giao hàng'],
                                        'cancelled' => ['class' => 'danger', 'icon' => 'times-circle', 'text' => 'Đã hủy']
                                    ];
                                    $status = $statusConfig[$order->status] ?? $statusConfig['pending'];
                                @endphp

                                <div class="mb-3">
                                    <i class="fas fa-{{ $status['icon'] }} fa-3x text-{{ $status['class'] }}"></i>
                                </div>
                                <h5 class="text-{{ $status['class'] }}">{{ $status['text'] }}</h5>
                            </div>

                            <!-- Timeline trạng thái -->
                            <div class="status-timeline">
                                <div class="timeline-item {{ in_array($order->status, ['pending', 'confirmed', 'shipping', 'delivered']) ? 'completed' : '' }}">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <small class="text-muted">Đặt hàng</small>
                                        <div class="text-sm">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                                    </div>
                                </div>

                                <div class="timeline-item {{ in_array($order->status, ['confirmed', 'shipping', 'delivered']) ? 'completed' : '' }}">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <small class="text-muted">Xác nhận</small>
                                        @if(in_array($order->status, ['confirmed', 'shipping', 'delivered']))
                                            <div class="text-sm">{{ $order->updated_at->format('d/m/Y H:i') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="timeline-item {{ in_array($order->status, ['shipping', 'delivered']) ? 'completed' : '' }}">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <small class="text-muted">Giao hàng</small>
                                        @if(in_array($order->status, ['shipping', 'delivered']))
                                            <div class="text-sm">Đang xử lý</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="timeline-item {{ $order->status == 'delivered' ? 'completed' : '' }}">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <small class="text-muted">Hoàn thành</small>
                                        @if($order->status == 'delivered')
                                            <div class="text-sm">{{ $order->updated_at->format('d/m/Y H:i') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tổng tiền -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-calculator"></i> Tổng cộng
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tạm tính:</span>
                                <span>{{ number_format($order->total_amount - $order->shipping_fee, 0, ',', '.') }}đ</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Phí vận chuyển:</span>
                                <span>{{ number_format($order->shipping_fee ?? 0, 0, ',', '.') }}đ</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Tổng cộng:</strong>
                                <strong class="text-danger fs-5">{{ number_format($order->total_amount, 0, ',', '.') }}đ</strong>
                            </div>

                            <div class="mt-3 pt-3 border-top">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Phương thức thanh toán:</span>
                                    <span>
                                        @if($order->payment_method == 'cod')
                                            <i class="fas fa-money-bill text-warning me-1"></i>
                                            Thanh toán khi nhận hàng
                                        @elseif($order->payment_method == 'bank')
                                            <i class="fas fa-university text-primary me-1"></i>
                                            Chuyển khoản
                                        @else
                                            <i class="fas fa-credit-card text-info me-1"></i>
                                            Thẻ tín dụng
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hành động -->
                    @if($order->status == 'pending')
                    <div class="card">
                        <div class="card-body text-center">
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">
                                <i class="fas fa-times"></i> Hủy đơn hàng
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal hủy đơn hàng -->
@if($order->status == 'pending')
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận hủy đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn hủy đơn hàng #{{ $order->id }}?</p>
                <p class="text-muted small">Lưu ý: Đơn hàng đã hủy không thể khôi phục.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Không</button>
                <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<style>
.status-timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-item:before {
    content: '';
    position: absolute;
    left: -23px;
    top: 8px;
    bottom: -12px;
    width: 2px;
    background: #e9ecef;
}

.timeline-item:last-child:before {
    display: none;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #e9ecef;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-item.completed .timeline-marker {
    background: #28a745;
    box-shadow: 0 0 0 2px #28a745;
}

.timeline-item.completed:before {
    background: #28a745;
}

.timeline-content {
    padding-left: 0;
}

.text-sm {
    font-size: 0.875rem;
}
</style>
@endsection
