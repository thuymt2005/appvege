@extends('layouts.app')

@section('title', 'Trang chủ - Cửa hàng rau củ quả sạch')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="alert alert-success">
            <h4>Xin chào, {{ Auth::user()->name }}!</h4>
            <p>Chào mừng bạn quay trở lại với cửa hàng rau củ quả sạch của chúng tôi.</p>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-shopping-bag me-2"></i> Đơn hàng của tôi</h5>
                <p class="card-text">Xem và quản lý các đơn hàng của bạn.</p>
                <a href="{{ route("orders.index") }}" class="btn btn-outline-primary">Xem đơn hàng</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-user me-2"></i> Thông tin cá nhân</h5>
                <p class="card-text">Cập nhật thông tin cá nhân và địa chỉ giao hàng.</p>
                <a href="{{ url('/profile') }}" class="btn btn-outline-primary">Cập nhật thông tin</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-heart me-2"></i> Sản phẩm yêu thích</h5>
                <p class="card-text">Xem danh sách sản phẩm bạn đã đánh dấu yêu thích.</p>
                <a href="" class="btn btn-outline-primary">Xem yêu thích</a>
            </div>
        </div>
    </div>
</div>

{{-- don hang de xuat --}}
{{-- <div class="featured-products mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Sản phẩm đề xuất cho bạn</h2>
        <a href="{{ url('/products') }}" class="btn btn-outline-success">Xem tất cả</a>
    </div>

    <div class="row">
        @for ($i = 1; $i <= 4; $i++)
        <div class="col-md-3 mb-4">
            <div class="card product-card h-100">
                <div class="badge bg-danger position-absolute top-0 end-0 m-2">-{{ rand(5, 20) }}%</div>
                <img src="{{ asset('images/products/product' . ($i + 8) . '.jpg') }}" class="card-img-top" alt="Sản phẩm {{ $i + 8 }}">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Sản phẩm đề xuất {{ $i }}</h5>
                    <p class="card-text text-muted mb-1">Danh mục: Rau xanh</p>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <div>
                            <span class="text-danger fw-bold">{{ number_format(rand(20, 100) * 1000) }}đ</span>
                            <span class="text-muted text-decoration-line-through">{{ number_format(rand(101, 150) * 1000) }}đ</span>
                        </div>
                        <div class="rating">
                            @for ($j = 1; $j <= 5; $j++)
                                <i class="fas fa-star {{ $j <= 4 ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                        </div>
                    </div>
                    <div class="mt-auto pt-3">
                        <div class="d-flex justify-content-between">
                            <a href="{{ url('/products/' . ($i + 8)) }}" class="btn btn-sm btn-outline-secondary">Chi tiết</a>
                            <button class="btn btn-sm btn-success add-to-cart" data-id="{{ $i + 8 }}">
                                <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endfor
    </div>
</div> --}}

{{-- don hang gan day --}}
{{-- <div class="recent-orders mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Đơn hàng gần đây</h2>
        <a href="{{ url('/orders') }}" class="btn btn-outline-success">Xem tất cả</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Ngày đặt</th>
                    <th>Trạng thái</th>
                    <th>Tổng tiền</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#ORD-{{ rand(1000, 9999) }}</td>
                    <td>{{ date('d/m/Y', strtotime('-2 days')) }}</td>
                    <td><span class="badge bg-success">Đã giao hàng</span></td>
                    <td>{{ number_format(rand(100, 500) * 1000) }}đ</td>
                    <td><a href="{{ url('/orders/1') }}" class="btn btn-sm btn-outline-primary">Chi tiết</a></td>
                </tr>
                <tr>
                    <td>#ORD-{{ rand(1000, 9999) }}</td>
                    <td>{{ date('d/m/Y', strtotime('-5 days')) }}</td>
                    <td><span class="badge bg-warning text-dark">Đang giao hàng</span></td>
                    <td>{{ number_format(rand(100, 500) * 1000) }}đ</td>
                    <td><a href="{{ url('/orders/2') }}" class="btn btn-sm btn-outline-primary">Chi tiết</a></td>
                </tr>
                <tr>
                    <td>#ORD-{{ rand(1000, 9999) }}</td>
                    <td>{{ date('d/m/Y', strtotime('-10 days')) }}</td>
                    <td><span class="badge bg-success">Đã giao hàng</span></td>
                    <td>{{ number_format(rand(100, 500) * 1000) }}đ</td>
                    <td><a href="{{ url('/orders/3') }}" class="btn btn-sm btn-outline-primary">Chi tiết</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div> --}}

{{-- uu dai dac biet --}}
<div class="special-offers mb-5">
    <h2 class="mb-4">Ưu đãi đặc biệt</h2>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="{{ asset('images/banners/dis15%.jpg') }}" class="img-fluid rounded-start h-100" alt="Ưu đãi">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Giảm 15% cho đơn hàng đầu tiên</h5>
                            <p class="card-text">Nhập mã <strong>WELCOME15</strong> để được giảm 15% cho đơn hàng đầu tiên của bạn.</p>
                            <p class="card-text"><small class="text-muted">Có hiệu lực đến {{ date('d/m/Y', strtotime('+30 days')) }}</small></p>
                            <a href="{{ url('/products') }}" class="btn btn-success">Mua ngay</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="{{ asset('images/banners/freeship.png') }}" class="img-fluid rounded-start h-100" alt="Ưu đãi">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Miễn phí giao hàng</h5>
                            <p class="card-text">Miễn phí giao hàng cho đơn hàng từ 200.000đ trong khu vực nội thành.</p>
                            <p class="card-text"><small class="text-muted">Áp dụng mọi lúc</small></p>
                            <a href="{{ url('/products') }}" class="btn btn-success">Mua ngay</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Script để xử lý thêm vào giỏ hàng
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            // Thêm sản phẩm vào giỏ hàng (sẽ xử lý bằng AJAX)
            alert('Đã thêm sản phẩm vào giỏ hàng!');
        });
    });
</script>
@endsection
