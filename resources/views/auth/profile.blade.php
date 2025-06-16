@extends('layouts.app')

@section('title', 'Thông tin cá nhân - Cửa hàng rau củ quả sạch')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card mb-4">
            <div class="card-body text-center">
                <img src="{{ asset('images/avatars/default.jpg') }}" alt="Avatar" class="rounded-circle img-fluid" style="width: 150px;">
                <h5 class="my-3">{{ Auth::user()->name }}</h5>
                <p class="text-muted mb-1">Khách hàng</p>
                <p class="text-muted mb-4">{{ Auth::user()->email }}</p>
                <div class="d-flex justify-content-center mb-2">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#changeAvatarModal">
                        Đổi ảnh đại diện
                    </button>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                        <a href="{{ url('/profile') }}" class="text-decoration-none text-dark w-100">
                            <i class="fas fa-user fa-fw me-3"></i>Thông tin cá nhân
                        </a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                        <a href="{{ url('/orders') }}" class="text-decoration-none text-dark w-100">
                            <i class="fas fa-shopping-bag fa-fw me-3"></i>Đơn hàng của tôi
                        </a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                        <a href="{{ url('/addresses') }}" class="text-decoration-none text-dark w-100">
                            <i class="fas fa-map-marker-alt fa-fw me-3"></i>Địa chỉ giao hàng
                        </a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                        <a href="{{ url('/change-password') }}" class="text-decoration-none text-dark w-100">
                            <i class="fas fa-lock fa-fw me-3"></i>Đổi mật khẩu
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Thông tin cá nhân</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{ url('/profile') }}">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Họ và tên</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" value="{{ Auth::user()->email }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="birthday" class="form-label">Ngày sinh</label>
                            <input type="date" class="form-control @error('birthday') is-invalid @enderror" id="birthday" name="birthday" value="{{ old('birthday', Auth::user()->birthday) }}">
                            @error('birthday')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block">Giới tính</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="male" value="male" {{ old('gender', Auth::user()->gender) == 'male' ? 'checked' : '' }}>
                            <label class="form-check-label" for="male">Nam</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="female" value="female" {{ old('gender', Auth::user()->gender) == 'female' ? 'checked' : '' }}>
                            <label class="form-check-label" for="female">Nữ</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="other" value="other" {{ old('gender', Auth::user()->gender) == 'other' ? 'checked' : '' }}>
                            <label class="form-check-label" for="other">Khác</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Cập nhật thông tin</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Địa chỉ mặc định</h5>
            </div>
            <div class="card-body">
                @if(isset($defaultAddress))
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Họ tên:</strong> {{ $defaultAddress->name }}</p>
                            <p><strong>Số điện thoại:</strong> {{ $defaultAddress->phone }}</p>
                            <p><strong>Địa chỉ:</strong> {{ $defaultAddress->address }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Phường/Xã:</strong> {{ $defaultAddress->ward }}</p>
                            <p><strong>Quận/Huyện:</strong> {{ $defaultAddress->district }}</p>
                            <p><strong>Tỉnh/Thành phố:</strong> {{ $defaultAddress->province }}</p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ url('/addresses') }}" class="btn btn-outline-primary">Quản lý địa chỉ</a>
                    </div>
                @else
                    <p>Bạn chưa có địa chỉ mặc định.</p>
                    <a href="{{ url('/addresses/create') }}" class="btn btn-primary">Thêm địa chỉ mới</a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal đổi ảnh đại diện -->
<div class="modal fade" id="changeAvatarModal" tabindex="-1" aria-labelledby="changeAvatarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeAvatarModalLabel">Đổi ảnh đại diện</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ url('/profile/avatar') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Chọn ảnh đại diện mới</label>
                        <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*" required>
                        <div class="form-text">Chỉ chấp nhận file ảnh (JPG, PNG, GIF). Kích thước tối đa 2MB.</div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Cập nhật</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
