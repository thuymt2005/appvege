@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng')

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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">Chi tiết đơn hàng #{{ $order->id }}</h4>
                    <p class="text-muted mb-0">Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                </a>
            </div>

            <!-- Order Status -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Trạng thái đơn hàng</h5>

                    <div class="position-relative mb-4">
                        <div class="progress" style="height: 3px;">
                            @if($order->status == 'pending')
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 20%"></div>
                            @elseif($order->status == 'processing')
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 40%"></div>
                            @elseif($order->status == 'shipped')
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%"></div>
                            @elseif($order->status == 'delivered')
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
                            @elseif($order->status == 'cancelled')
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 100%"></div>
                            @endif
                        </div>

                        <div class="position-absolute top-0 start-0 translate-middle" style="margin-top: 3px;">
                            <div class="rounded-circle {{ $order->status != 'cancelled' ? 'bg-primary' : 'bg-secondary' }}" style="width: 15px; height: 15px;"></div>
                        </div>
                        <div class="position-absolute top-0 start-25 translate-middle" style="margin-top: 3px;">
                            <div class="rounded-circle {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'bg-primary' : 'bg-secondary' }}" style="width: 15px; height: 15px;"></div>
                        </div>
                        <div class="position-absolute top-0 start-50 translate-middle" style="margin-top: 3px;">
                            <div class="rounded-circle {{ in_array($order->status, ['shipped', 'delivered']) ? 'bg-primary' : 'bg-secondary' }}" style="width: 15px; height: 15px;"></div>
                        </div>
                        <div class="position-absolute top-0 start-75 translate-middle" style="margin-top: 3px;">
                            <div class="rounded-circle {{ $order->status == 'delivered' ? 'bg-primary' : 'bg-secondary' }}" style="width: 15px; height: 15px;"></div>
                        </div>
                        <div class="position-absolute top-0 start-100 translate-middle" style="margin-top: 3px;">
                            <div class="rounded-circle {{ $order->status == 'cancelled' ? 'bg-danger' : 'bg-secondary' }}" style="width: 15px; height: 15px;"></div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between text-center">
                        <div>
                            <div class="text-muted small">Đặt hàng</div>
                        </div>
                        <div>
                            <div class="text-muted small">Xác nhận</div>
                        </div>
                        <div>
                            <div class="text-muted small">Đang giao</div>
                        </div>
                        <div>
                            <div class="text-muted small">Đã giao</div>
                        </div>
                        <div>
                            <div class="text-muted small">Đã hủy</div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="d-flex align-items-center">
                            @if($order->status == 'pending')
                                <span class="badge bg-warning me-2">Chờ xác nhận</span>
                            @elseif($order->status == 'processing')
                                <span class="badge bg-info me-2">Đang xử lý</span>
                            @elseif($order->status == 'shipped')
                                <span class="badge bg-primary me-2">Đang giao</span>
                            @elseif($order->status == 'delivered')
                                <span class="badge bg-success me-2">Đã giao</span>
                            @elseif($order->status == 'cancelled')
                                <span class="badge bg-danger me-2">Đã hủy</span>
                            @endif

                            <span class="text-muted">Cập nhật lần cuối: {{ $order->updated_at->format('d/m/Y H:i') }}</span>
                        </div>

                        @if($order->status == 'pending')
                            <div class="mt-3">
                                <form action="" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-outline-danger"
                                        onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')">
                                        <i class="fas fa-times me-2"></i>Hủy đơn hàng
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Sản phẩm đã đặt</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 80px">Sản phẩm</th>
                                    <th>Tên</th>
                                    <th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}"
                                            class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <h6 class="mb-0">{{ $item->product->name }}</h6>
                                        <small class="text-muted">{{ $item->product->unit }}</small>
                                    </td>
                                    <td>{{ number_format($item->price, 0, ',', '.') }}đ</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="text-end">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end">Tạm tính:</td>
                                    <td class="text-end">{{ number_format($order->subtotal, 0, ',', '.') }}đ</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end">Phí vận chuyển:</td>
                                    <td class="text-end">{{ number_format($order->shipping_fee, 0, ',', '.') }}đ</td>
                                </tr>
                                @if($order->discount > 0)
                                <tr>
                                    <td colspan="4" class="text-end">Giảm giá:</td>
                                    <td class="text-end text-success">-{{ number_format($order->discount, 0, ',', '.') }}đ</td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="4" class="text-end fw-bold">Tổng cộng:</td>
                                    <td class="text-end fw-bold">{{ number_format($order->total, 0, ',', '.') }}đ</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Shipping Information -->
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Thông tin giao hàng</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-1"><strong>Người nhận:</strong> {{ $order->name }}</p>
                            <p class="mb-1"><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
                            <p class="mb-1"><strong>Email:</strong> {{ $order->email }}</p>
                            <p class="mb-0"><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Thông tin thanh toán</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-1">
                                <strong>Phương thức:</strong>
                                @if($order->payment_method == 'cod')
                                    Thanh toán khi nhận hàng (COD)
                                @elseif($order->payment_method == 'bank_transfer')
                                    Chuyển khoản ngân hàng
                                @elseif($order->payment_method == 'momo')
                                    Ví MoMo
                                @elseif($order->payment_method == 'vnpay')
                                    VNPay
                                @endif
                            </p>
                            <p class="mb-1">
                                <strong>Trạng thái:</strong>
                                @if($order->payment_status == 'paid')
                                    <span class="badge bg-success">Đã thanh toán</span>
                                @else
                                    <span class="badge bg-warning">Chưa thanh toán</span>
                                @endif
                            </p>

                            @if($order->payment_method == 'bank_transfer' && $order->payment_status != 'paid')
                                <div class="mt-3 p-3 bg-light rounded">
                                    <h6>Thông tin chuyển khoản</h6>
                                    <p class="mb-1">Ngân hàng: <strong>Vietcombank</strong></p>
                                    <p class="mb-1">Số tài khoản: <strong>1234567890</strong></p>
                                    <p class="mb-1">Chủ tài khoản: <strong>CÔNG TY TNHH VEGMARKET</strong></p>
                                    <p class="mb-0">Nội dung: <strong>Thanh toan #{{ $order->id }}</strong></p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if($order->note)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Ghi chú</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $order->note }}</p>
                    </div>
                </div>
            @endif

            <div class="text-center mt-4">
                <a href="{{ route('orders.index') }}" class="btn btn-outline-primary me-2">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách đơn hàng
                </a>

                @if($order->status == 'delivered')
                    <a href="{{ url('/') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-basket me-2"></i>Mua lại
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
