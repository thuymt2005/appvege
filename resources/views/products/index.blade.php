@extends('layouts.app')

@section('title', 'Sản phẩm')

@section('content')
<div class="container mx-auto px-4 py-8">
<!-- Page Header -->
<div class="mb-4">
    <h1 class="h3 fw-bold text-dark mb-2">Sản phẩm tươi ngon</h1>
    <p class="text-muted">Khám phá những sản phẩm rau củ quả tươi ngon nhất</p>
</div>

<!-- Filter and Sort Section -->
<div class="bg-white rounded shadow-sm p-4 mb-4 border">
    <div class="row gy-3 align-items-center justify-content-between">
        <!-- Category and Price Filter -->
        <div class="col-lg-8">
            <div class="row g-3">
                <!-- Category Filter -->
                <div class="col-sm-6 col-md-4">
                    <label class="form-label fw-medium text-dark">Danh mục:</label>
                    <select class="form-select form-select-sm">
                        <option value="">Tất cả</option>
                        <option value="vegetables">Rau xanh</option>
                        <option value="fruits">Trái cây</option>
                        <option value="roots">Củ quả</option>
                        <option value="herbs">Rau gia vị</option>
                    </select>
                </div>

                <!-- Price Filter -->
                <div class="col-sm-6 col-md-4">
                    <label class="form-label fw-medium text-dark">Giá:</label>
                    <select class="form-select form-select-sm">
                        <option value="">Tất cả</option>
                        <option value="0-50000">Dưới 50,000đ</option>
                        <option value="50000-100000">50,000đ - 100,000đ</option>
                        <option value="100000-200000">100,000đ - 200,000đ</option>
                        <option value="200000+">Trên 200,000đ</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Sort Options -->
        <div class="col-lg-4">
            <div class="row g-2 align-items-center">
                <div class="col-auto">
                    <label class="form-label fw-medium text-dark mb-0">Sắp xếp:</label>
                </div>
                <div class="col">
                    <select class="form-select form-select-sm">
                        <option value="latest">Mới nhất</option>
                        <option value="price_asc">Giá thấp đến cao</option>
                        <option value="price_desc">Giá cao đến thấp</option>
                        <option value="name_asc">Tên A-Z</option>
                        <option value="popular">Phổ biến</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Products Grid -->
    <div class="row g-4 mb-5">
        @forelse($products ?? [] as $product)
        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
            <div class="card h-100 shadow-sm product-card">
                <!-- Product Image -->
                <div class="position-relative product-image-container">
                    <img src="{{ asset($product->image_url ?? 'images/products/default.jpg') }}"
                         alt="{{ $product->name }}"
                         class="card-img-top product-image">

                    <!-- Quick View Button -->
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center product-overlay">
                        <a href="{{ route('products.show', $product->id) }}"
                           class="btn btn-light btn-sm quick-view-btn">
                            <i class="fas fa-eye me-1"></i>
                            Xem nhanh
                        </a>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="card-body d-flex flex-column">
                    <div class="mb-2">
                        <span class="badge bg-light text-dark text-uppercase small">
                            {{ $product->category->name ?? 'Chưa phân loại' }}
                        </span>
                    </div>

                    <h5 class="card-title fw-semibold text-truncate-2 mb-2">
                        {{ $product->name }}
                    </h5>

                    <p class="card-text text-muted small text-truncate-2 mb-3">
                        {{ $product->description }}
                    </p>

                    <!-- Price -->
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center">
                            <span class="text-success fw-bold fs-5 me-1">
                                {{ number_format($product->price, 0, ',', '.') }}đ
                            </span>
                        </div>
                        <span class="text-muted small">
                            /{{ $product->unit }}
                        </span>
                    </div>

                    <!-- Stock Status -->
                    <div class="mb-3">
                        @if($product->stock_quantity > 0)
                        <span class="text-success small fw-medium">
                            <i class="fas fa-check-circle me-1"></i>
                            Còn hàng ({{ $product->stock_quantity }})
                        </span>
                        @else
                        <span class="text-danger small fw-medium">
                            <i class="fas fa-times-circle me-1"></i>
                            Hết hàng
                        </span>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-auto">
                        <div class="d-flex gap-2">
                            <button class="btn btn-success btn-sm flex-fill"
                                    onclick="addToCart({{ $product->id }})"
                                    {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
                                <i class="fas fa-shopping-cart me-1"></i>
                                Thêm vào giỏ
                            </button>
                            <a href="{{ route('products.show', $product->id) }}"
                               class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <!-- Empty State -->
        <div class="col-12">
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-seedling display-1 text-muted opacity-50"></i>
                </div>
                <h3 class="h4 text-muted mb-3">Không tìm thấy sản phẩm</h3>
                <p class="text-muted mb-4">Hiện tại chưa có sản phẩm nào trong danh mục này.</p>
                <a href="{{ route('home') }}" class="btn btn-success">
                    <i class="fas fa-home me-2"></i>
                    Về trang chủ
                </a>
            </div>
        </div>
        @endforelse
    </div>

<style>
.product-card {
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,.125);
}

.product-card:hover {
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15) !important;
    transform: translateY(-2px);
}

.product-image-container {
    overflow: hidden;
    height: 200px;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image {
    transform: scale(1.05);
}

.product-overlay {
    background: rgba(0,0,0,0);
    transition: all 0.3s ease;
    opacity: 0;
}

.product-card:hover .product-overlay {
    background: rgba(0,0,0,0.2);
    opacity: 1;
}

.quick-view-btn {
    transform: translateY(10px);
    transition: all 0.3s ease;
}

.product-card:hover .quick-view-btn {
    transform: translateY(0);
}

.text-truncate-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.4;
    max-height: 2.8em;
}

.gap-2 {
    gap: 0.5rem;
}

@media (max-width: 576px) {
    .product-image-container {
        height: 150px;
    }
}
</style>

<!-- Pagination -->
@if(isset($products) && method_exists($products, 'links'))
<div class="flex justify-center">
    {{ $products->links() }}
</div>
@endif

<script>
function addToCart(productId) {
    // Add to cart logic here
    document.getElementById('cartModal').classList.remove('hidden');
}

function closeCartModal() {
    document.getElementById('cartModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('cartModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCartModal();
    }
});
</script>
@endsection
