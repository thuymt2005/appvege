@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
<!-- Hero Section -->
<section class="bg-success text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Rau Củ Quả Tươi Ngon</h1>
                <p class="lead mb-4">Chúng tôi cung cấp những sản phẩm rau củ quả tươi ngon nhất, được chọn lọc kỹ càng từ các trang trại uy tín.</p>
                <div class="d-flex gap-3">
                    <a href=" " class="btn btn-light btn-lg">
                        <i class="fas fa-shopping-basket me-2"></i>Mua sắm ngay
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">Đăng ký</a>
                    @endguest
                </div>
            </div>
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80"
                     alt="Fresh Vegetables" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="fw-bold">Tại sao chọn chúng tôi?</h2>
                <p class="text-muted">Những lý do khiến khách hàng tin tưởng VegMarket</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-leaf fa-2x text-success"></i>
                    </div>
                    <h5>Tươi ngon tự nhiên</h5>
                    <p class="text-muted">Tất cả sản phẩm đều được thu hoạch tươi mỗi ngày từ các trang trại hữu cơ.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-truck fa-2x text-success"></i>
                    </div>
                    <h5>Giao hàng nhanh chóng</h5>
                    <p class="text-muted">Giao hàng trong ngày tại khu vực nội thành, đảm bảo độ tươi ngon.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-shield-alt fa-2x text-success"></i>
                    </div>
                    <h5>Chất lượng đảm bảo</h5>
                    <p class="text-muted">Cam kết hoàn tiền 100% nếu không hài lòng về chất lượng sản phẩm.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Popular Products -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="fw-bold">Sản phẩm nổi bật</h2>
                <p class="text-muted">Những sản phẩm được khách hàng yêu thích nhất</p>
            </div>
        </div>
        <div class="row g-4">
            @php
                $featured_products = [
                    [
                        'name' => 'Cà chua bi hữu cơ',
                        'price' => '25,000',
                        'image' => 'https://images.unsplash.com/photo-1592841200221-a6898f307baa?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80',
                        'discount' => '15%'
                    ],
                    [
                        'name' => 'Rau cải bó xôi',
                        'price' => '15,000',
                        'image' => 'https://images.unsplash.com/photo-1576045057995-568f588f82fb?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80'
                    ],
                    [
                        'name' => 'Táo Fuji nhập khẩu',
                        'price' => '45,000',
                        'image' => 'https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80'
                    ],
                    [
                        'name' => 'Cà rót tím',
                        'price' => '18,000',
                        'image' => 'https://images.unsplash.com/photo-1659261200833-ec8761558af7?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80'
                    ]
                ];
            @endphp

            @foreach($featured_products as $product)
            <div class="col-lg-3 col-md-6">
                <div class="card product-card h-100">
                    @if(isset($product['discount']))
                        <div class="position-relative">
                            <img src="{{ $product['image'] }}" class="card-img-top" alt="{{ $product['name'] }}" style="height: 200px; object-fit: cover;">
                            <span class="badge bg-danger position-absolute top-0 end-0 m-2">-{{ $product['discount'] }}</span>
                        </div>
                    @else
                        <img src="{{ $product['image'] }}" class="card-img-top" alt="{{ $product['name'] }}" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">{{ $product['name'] }}</h6>
                        <p class="card-text text-success fw-bold fs-5 mt-auto">{{ $product['price'] }}đ/kg</p>
                        <div class="d-flex gap-2">
                            <button class="btn btn-success btn-sm flex-fill">
                                <i class="fas fa-cart-plus me-1"></i>Thêm vào giỏ
                            </button>
                            <button class="btn btn-outline-success btn-sm">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="" class="btn btn-success btn-lg">
                Xem tất cả sản phẩm <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5 bg-success text-white">
    <div class="container text-center">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2 class="fw-bold mb-4">Bắt đầu mua sắm ngay hôm nay!</h2>
                <p class="lead mb-4">Đăng ký tài khoản để nhận được những ưu đãi đặc biệt và giao hàng miễn phí cho đơn hàng đầu tiên.</p>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg me-3">
                        <i class="fas fa-user-plus me-2"></i>Đăng ký ngay
                    </a>
                @else
                    <a href="" class="btn btn-light btn-lg me-3">
                        <i class="fas fa-shopping-cart me-2"></i>Mua sắm ngay
                    </a>
                @endguest
                <a href="#" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-phone me-2"></i>Liên hệ: 0123 456 789
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
