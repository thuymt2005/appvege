@extends('layouts.app')

@section('title', 'Thông tin cá nhân')

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
                        <a href="{{ route('user.profile') }}" class="list-group-item list-group-item-action active">
                            <i class="fas fa-user-edit me-2"></i> Thông tin cá nhân
                        </a>
                        <a href="{{ route("orders.index") }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-shopping-bag me-2"></i> Đơn hàng của tôi
                        </a>
                        <a href="{{ route("cart.index") }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-shopping-cart me-2"></i> Giỏ hàng
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Thông tin cá nhân</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Họ và tên</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', Auth::user()->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" value="{{ Auth::user()->email }}" disabled>
                                <small class="text-muted">Email không thể thay đổi</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <textarea class="form-control @error('address') is-invalid @enderror"
                                    id="address" name="address" rows="3">{{ old('address', Auth::user()->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Lưu thay đổi
                            </button>
                        </div>
                    </form>

                    <hr>

                    <h5 class="mb-4">Đổi mật khẩu</h5>
                    <form method="POST" action="">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                    id="current_password" name="current_password">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6"></div>

                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Mật khẩu mới</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                                <input type="password" class="form-control"
                                    id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-key me-2"></i>Đổi mật khẩu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
