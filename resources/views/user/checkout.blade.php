@extends('layouts.app')

@section('title', 'Thanh toán')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Thanh toán</h2>

    <form action="" method="POST">
        @csrf
        <div class="row">
            <!-- Shipping Information -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Thông tin giao hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Họ và tên</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="address" class="form-label">Địa chỉ giao hàng</label>
                                <textarea class="form-control @error('address') is-invalid @enderror"
                                    id="address" name="address" rows="3" required>{{ old('address', Auth::user()->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="note" class="form-label">Ghi chú (tùy chọn)</label>
                                <textarea class="form-control" id="note" name="note" rows="2">{{ old('note') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Phương thức thanh toán</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method"
                                id="cod" value="cod" checked>
                            <label class="form-check-label" for="cod">
                                <i class="fas fa-money-bill-wave me-2"></i>Thanh toán khi nhận hàng (COD)
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method"
                                id="bank_transfer" value="bank_transfer">
                            <label class="form-check-label" for="bank_transfer">
                                <i class="fas fa-university me-2"></i>Chuyển khoản ngân hàng
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method"
                                id="momo" value="momo">
                            <label class="form-check-label" for="momo">
                                <i class="fas fa-wallet me-2"></i>Ví MoMo
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method"
                                id="vnpay" value="vnpay">
                            <label class="form-check-label" for="vnpay">
                                <i class="fas fa-credit-card me-2"></i>VNPay
                            </label>
                        </div>

                        <div id="bank_transfer_details" class="mt-3 p-3 bg-light rounded" style="display: none;">
                            <h6>Thông tin chuyển khoản</h6>
                            <p class="mb-1">Ngân hàng: <strong>Vietcombank</strong></p>
                            <p class="mb-1">Số tài khoản: <strong>1234567890</strong></p>
                            <p class="mb-1">Chủ tài khoản: <strong>CÔNG TY TNHH VEGMARKET</strong></p>
                            <p class="mb-0">Nội dung: <strong>Thanh toan VegMarket - [Tên của bạn]</strong></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Đơn hàng của bạn</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            @foreach(session('cart') as $id => $item)
                                <div class="d-flex justify-content-between mb-2">
                                    <div>
                                        <span class="fw-medium">{{ $item['name'] }}</span>
                                        <small class="text-muted d-block">{{ $item['quantity'] }} x {{ number_format($item['price'], 0, ',', '.') }}đ</small>
                                    </div>
                                    <span>{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ</span>
                                </div>
                            @endforeach
                        </div>

                        <hr>

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

                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold">Tổng cộng:</span>
                            <span class="fw-bold text-primary fs-5">{{ number_format(
                                array_sum(array_map(function($item) {
                                    return $item['price'] * $item['quantity'];
                                }, session('cart'))) + ($shippingFee ?? 30000) - ($discount ?? 0),
                                0, ',', '.') }}đ</span>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">
                                Tôi đã đọc và đồng ý với <a href="#">điều khoản dịch vụ</a>
                            </label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-check-circle me-2"></i>Đặt hàng
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <a href="{{ route('user.cart') }}" class="text-decoration-none">
                                <i class="fas fa-arrow-left me-1"></i>Quay lại giỏ hàng
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
        const bankTransferDetails = document.getElementById('bank_transfer_details');

        paymentMethods.forEach(method => {
            method.addEventListener('change', function() {
                if (this.value === 'bank_transfer') {
                    bankTransferDetails.style.display = 'block';
                } else {
                    bankTransferDetails.style.display = 'none';
                }
            });
        });
    });
</script>
@endpush
@endsection
