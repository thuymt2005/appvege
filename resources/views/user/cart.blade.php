@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Giỏ hàng của bạn</h2>

    @if(session('cart') && count(session('cart')) > 0)
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th style="width: 100px">Sản phẩm</th>
                                        <th>Tên</th>
                                        <th>Đơn giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(session('cart') as $id => $item)
                                        <tr>
                                            <td>
                                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                                    class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                            </td>
                                            <td>
                                                <h6 class="mb-0">{{ $item['name'] }}</h6>
                                                <small class="text-muted">{{ $item['unit'] }}</small>
                                            </td>
                                            <td>{{ number_format($item['price'], 0, ',', '.') }}đ</td>
                                            <td>
                                                <div class="input-group input-group-sm" style="width: 120px">
                                                    <form action="" method="POST" class="d-flex">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $id }}">
                                                        <button type="submit" name="change_quantity" value="decrease"
                                                            class="btn btn-outline-secondary">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                        <input type="text" class="form-control text-center"
                                                            value="{{ $item['quantity'] }}" readonly>
                                                        <button type="submit" name="change_quantity" value="increase"
                                                            class="btn btn-outline-secondary">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="fw-bold">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ</td>
                                            <td>
                                                <form action="" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $id }}">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ url('/') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua sắm
                            </a>
                            <form action="" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-trash me-2"></i>Xóa giỏ hàng
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Tóm tắt đơn hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tạm tính:</span>
                            <span>{{ number_format(array_sum(array_map(function($item) {
                                return $item['price'] * $item['quantity'];
                            }, session('cart'))), 0, ',', '.') }}đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Phí vận chuyển:</span>
                            <span>{{ number_format($shippingFee ?? 30000, 0, ',', '.') }}đ</span>
                        </div>

                        @if(isset($discount) && $discount > 0)
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span>Giảm giá:</span>
                                <span>-{{ number_format($discount, 0, ',', '.') }}đ</span>
                            </div>
                        @endif

                        <hr>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-bold">Tổng cộng:</span>
                            <span class="fw-bold text-primary fs-5">{{ number_format(
                                array_sum(array_map(function($item) {
                                    return $item['price'] * $item['quantity'];
                                }, session('cart'))) + ($shippingFee ?? 30000) - ($discount ?? 0),
                                0, ',', '.') }}đ</span>
                        </div>

                        <div class="mb-3">
                            <label for="coupon" class="form-label">Mã giảm giá</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="coupon" name="coupon"
                                    placeholder="Nhập mã giảm giá">
                                <button class="btn btn-outline-primary" type="button">Áp dụng</button>
                            </div>
                        </div>

                        <div class="d-grid">
                            <a href="" class="btn btn-primary btn-lg">
                                <i class="fas fa-shopping-bag me-2"></i>Tiến hành thanh toán
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
            <h4>Giỏ hàng của bạn đang trống</h4>
            <p class="text-muted">Hãy thêm một số sản phẩm vào giỏ hàng của bạn và quay lại đây nhé!</p>
            <a href="{{ url('/') }}" class="btn btn-primary mt-3">
                <i class="fas fa-shopping-basket me-2"></i>Mua sắm ngay
            </a>
        </div>
    @endif
</div>
@endsection
