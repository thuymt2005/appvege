@extends('layouts.app')

@section('title', 'Sản phẩm')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Sản phẩm tươi ngon</h1>
        <p class="text-gray-600">Khám phá những sản phẩm rau củ quả tươi ngon nhất</p>
    </div>

    <!-- Filter and Sort Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <!-- Category Filter -->
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium text-gray-700">Danh mục:</label>
                    <select class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Tất cả</option>
                        <option value="vegetables">Rau xanh</option>
                        <option value="fruits">Trái cây</option>
                        <option value="roots">Củ quả</option>
                        <option value="herbs">Rau gia vị</option>
                    </select>
                </div>

                <!-- Price Range -->
                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium text-gray-700">Giá:</label>
                    <select class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Tất cả</option>
                        <option value="0-50000">Dưới 50,000đ</option>
                        <option value="50000-100000">50,000đ - 100,000đ</option>
                        <option value="100000-200000">100,000đ - 200,000đ</option>
                        <option value="200000+">Trên 200,000đ</option>
                    </select>
                </div>
            </div>

            <!-- Sort Options -->
            <div class="flex items-center gap-2">
                <label class="text-sm font-medium text-gray-700">Sắp xếp:</label>
                <select class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="latest">Mới nhất</option>
                    <option value="price_asc">Giá thấp đến cao</option>
                    <option value="price_desc">Giá cao đến thấp</option>
                    <option value="name_asc">Tên A-Z</option>
                    <option value="popular">Phổ biến</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
        @forelse($products ?? [] as $product)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <!-- Product Image -->
            <div class="relative">
                <img src="{{ asset('images/products/' . ($product->image ?? 'default.jpg')) }}"
                     alt="{{ $product->name ?? 'Sản phẩm' }}"
                     class="w-full h-48 object-cover">

                <!-- Discount Badge -->
                @if(isset($product->discount) && $product->discount > 0)
                <div class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                    -{{ $product->discount }}%
                </div>
                @endif

                <!-- Quick View Button -->
                <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center opacity-0 hover:opacity-100">
                    <a href="{{ route('products.show', $product->id ?? 1) }}"
                       class="bg-white text-gray-800 px-4 py-2 rounded-full text-sm font-medium hover:bg-gray-100 transition-colors">
                        Xem nhanh
                    </a>
                </div>
            </div>

            <!-- Product Info -->
            <div class="p-4">
                <div class="mb-2">
                    <span class="text-xs text-gray-500 uppercase tracking-wide">
                        {{ $product->category->name ?? 'Rau củ quả' }}
                    </span>
                </div>

                <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2">
                    {{ $product->name ?? 'Rau xanh tươi ngon' }}
                </h3>

                <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                    {{ $product->description ?? 'Sản phẩm rau củ quả tươi ngon, chất lượng cao, được chọn lọc kỹ càng.' }}
                </p>

                <!-- Price -->
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        @if(isset($product->original_price) && $product->original_price > ($product->price ?? 0))
                        <span class="text-gray-400 line-through text-sm">
                            {{ number_format($product->original_price) }}đ
                        </span>
                        @endif
                        <span class="text-green-600 font-bold text-lg">
                            {{ number_format($product->price ?? 50000) }}đ
                        </span>
                    </div>
                    <span class="text-xs text-gray-500">
                        /{{ $product->unit ?? 'kg' }}
                    </span>
                </div>

                <!-- Stock Status -->
                <div class="mb-3">
                    @if(($product->stock ?? 10) > 0)
                    <span class="text-green-600 text-xs font-medium">
                        <i class="fas fa-check-circle mr-1"></i>
                        Còn hàng ({{ $product->stock ?? 10 }})
                    </span>
                    @else
                    <span class="text-red-600 text-xs font-medium">
                        <i class="fas fa-times-circle mr-1"></i>
                        Hết hàng
                    </span>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <button class="flex-1 bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-green-700 transition-colors flex items-center justify-center gap-2"
                            onclick="addToCart({{ $product->id ?? 1 }})">
                        <i class="fas fa-shopping-cart"></i>
                        Thêm vào giỏ
                    </button>
                    <a href="{{ route('products.show', $product->id ?? 1) }}"
                       class="px-3 py-2 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <!-- Empty State -->
        <div class="col-span-full text-center py-12">
            <div class="mb-4">
                <i class="fas fa-seedling text-6xl text-gray-300"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Không tìm thấy sản phẩm</h3>
            <p class="text-gray-500 mb-4">Hiện tại chưa có sản phẩm nào trong danh mục này.</p>
            <a href="{{ route('home') }}" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition-colors">
                Về trang chủ
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(isset($products) && method_exists($products, 'links'))
    <div class="flex justify-center">
        {{ $products->links() }}
    </div>
    @endif
</div>

<!-- Add to Cart Modal -->
<div id="cartModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg p-6 max-w-sm w-full">
            <div class="text-center">
                <div class="mb-4">
                    <i class="fas fa-check-circle text-green-500 text-4xl"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">Đã thêm vào giỏ hàng!</h3>
                <p class="text-gray-600 mb-4">Sản phẩm đã được thêm vào giỏ hàng của bạn.</p>
                <div class="flex gap-2">
                    <button onclick="closeCartModal()" class="flex-1 px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Tiếp tục mua
                    </button>
                    <a href="" class="flex-1 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-center">
                        Xem giỏ hàng
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

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
