@extends('layouts.app')

@section('title', $product->name ?? 'Chi tiết sản phẩm')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-green-600">
                    <i class="fas fa-home mr-2"></i>Trang chủ
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-green-600">Sản phẩm</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-gray-500">{{ $product->category->name ?? 'Rau củ quả' }}</span>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-gray-500">{{ $product->name ?? 'Chi tiết sản phẩm' }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        <!-- Product Images -->
        <div class="space-y-4">
            <!-- Main Image -->
            <div class="relative bg-gray-100 rounded-lg overflow-hidden">
                <img id="mainImage"
                     src="{{ asset('images/products/' . ($product->image ?? 'default.jpg')) }}"
                     alt="{{ $product->name ?? 'Sản phẩm' }}"
                     class="w-full h-96 object-cover">

                <!-- Discount Badge -->
                @if(isset($product->discount) && $product->discount > 0)
                <div class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                    -{{ $product->discount }}%
                </div>
                @endif

                <!-- Stock Badge -->
                <div class="absolute top-4 right-4">
                    @if(($product->stock ?? 10) > 0)
                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                        Còn hàng
                    </span>
                    @else
                    <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                        Hết hàng
                    </span>
                    @endif
                </div>
            </div>

            <!-- Thumbnail Images -->
            <div class="flex gap-2 overflow-x-auto">
                <img src="{{ asset('images/products/' . ($product->image ?? 'default.jpg')) }}"
                     alt="Thumbnail 1"
                     class="w-20 h-20 object-cover rounded-md border-2 border-green-500 cursor-pointer"
                     onclick="changeMainImage(this.src)">
                <img src="{{ asset('images/products/product-2.jpg') }}"
                     alt="Thumbnail 2"
                     class="w-20 h-20 object-cover rounded-md border-2 border-gray-200 hover:border-green-500 cursor-pointer"
                     onclick="changeMainImage(this.src)">
                <img src="{{ asset('images/products/product-3.jpg') }}"
                     alt="Thumbnail 3"
                     class="w-20 h-20 object-cover rounded-md border-2 border-gray-200 hover:border-green-500 cursor-pointer"
                     onclick="changeMainImage(this.src)">
                <img src="{{ asset('images/products/product-4.jpg') }}"
                     alt="Thumbnail 4"
                     class="w-20 h-20 object-cover rounded-md border-2 border-gray-200 hover:border-green-500 cursor-pointer"
                     onclick="changeMainImage(this.src)">
            </div>
        </div>

        <!-- Product Info -->
        <div class="space-y-6">
            <!-- Product Title and Category -->
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">
                        {{ $product->category->name ?? 'Rau củ quả' }}
                    </span>
                    <div class="flex items-center">
                        @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= ($product->rating ?? 4) ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                        @endfor
                        <span class="ml-2 text-sm text-gray-600">({{ $product->reviews_count ?? 24 }} đánh giá)</span>
                    </div>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name ?? 'Rau xanh tươi ngon' }}</h1>
                <p class="text-lg text-gray-600">{{ $product->short_description ?? 'Sản phẩm rau củ quả tươi ngon, chất lượng cao' }}</p>
            </div>

            <!-- Price -->
            <div class="border-t border-b border-gray-200 py-4">
                <div class="flex items-center gap-4 mb-2">
                    @if(isset($product->original_price) && $product->original_price > ($product->price ?? 0))
                    <span class="text-2xl text-gray-400 line-through">
                        {{ number_format($product->original_price) }}đ
                    </span>
                    @endif
                    <span class="text-3xl font-bold text-green-600">
                        {{ number_format($product->price ?? 50000) }}đ
                    </span>
                    <span class="text-gray-500">/{{ $product->unit ?? 'kg' }}</span>
                </div>
                @if(isset($product->original_price) && $product->original_price > ($product->price ?? 0))
                <p class="text-sm text-green-600 font-medium">
                    Tiết kiệm: {{ number_format($product->original_price - ($product->price ?? 0)) }}đ
                </p>
                @endif
            </div>

            <!-- Product Attributes -->
            <div class="space-y-3">
                <div class="flex items-center">
                    <span class="w-24 text-gray-600 font-medium">Xuất xứ:</span>
                    <span class="text-gray-800">{{ $product->origin ?? 'Việt Nam' }}</span>
                </div>
                <div class="flex items-center">
                    <span class="w-24 text-gray-600 font-medium">Tình trạng:</span>
                    @if(($product->stock ?? 10) > 0)
                    <span class="text-green-600 font-medium">Còn {{ $product->stock ?? 10 }} sản phẩm</span>
                    @else
                    <span class="text-red-600 font-medium">Hết hàng</span>
                    @endif
                </div>
                <div class="flex items-center">
                    <span class="w-24 text-gray-600 font-medium">Thương hiệu:</span>
                    <span class="text-gray-800">{{ $product->brand ?? 'Fresh Garden' }}</span>
                </div>
                <div class="flex items-center">
                    <span class="w-24 text-gray-600 font-medium">Hạn sử dụng:</span>
                    <span class="text-gray-800">{{ $product->expiry ?? '3-5 ngày khi bảo quản lạnh' }}</span>
                </div>
            </div>

            <!-- Quantity and Add to Cart -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center gap-4 mb-4">
                    <label class="font-medium text-gray-700">Số lượng:</label>
                    <div class="flex items-center border border-gray-300 rounded-md">
                        <button onclick="decreaseQuantity()" class="px-3 py-2 text-gray-600 hover:bg-gray-100">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock ?? 10 }}"
                               class="w-16 text-center border-0 focus:ring-0">
                        <button onclick="increaseQuantity()" class="px-3 py-2 text-gray-600 hover:bg-gray-100">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <span class="text-sm text-gray-500">(Tối đa {{ $product->stock ?? 10 }})</span>
                </div>

                <div class="flex gap-3">
                    <button onclick="addToCart({{ $product->id ?? 1 }})"
                            class="flex-1 bg-green-600 text-white px-6 py-3 rounded-md font-medium hover:bg-green-700 transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-shopping-cart"></i>
                        Thêm vào giỏ hàng
                    </button>
                    <button onclick="buyNow({{ $product->id ?? 1 }})"
                            class="flex-1 bg-orange-600 text-white px-6 py-3 rounded-md font-medium hover:bg-orange-700 transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-bolt"></i>
                        Mua ngay
                    </button>
                </div>

                <div class="flex items-center gap-4 mt-3 text-sm">
                    <button class="text-gray-600 hover:text-red-500 flex items-center gap-1">
                        <i class="far fa-heart"></i>
                        Yêu thích
                    </button>
                    <button class="text-gray-600 hover:text-blue-500 flex items-center gap-1">
                        <i class="fas fa-share-alt"></i>
                        Chia sẻ
                    </button>
                </div>
            </div>

            <!-- Features -->
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div class="flex items-center gap-2 text-green-600">
                    <i class="fas fa-leaf"></i>
                    <span>100% tự nhiên</span>
                </div>
                <div class="flex items-center gap-2 text-green-600">
                    <i class="fas fa-truck"></i>
                    <span>Giao hàng nhanh</span>
                </div>
                <div class="flex items-center gap-2 text-green-600">
                    <i class="fas fa-shield-alt"></i>
                    <span>Đảm bảo chất lượng</span>
                </div>
                <div class="flex items-center gap-2 text-green-600">
                    <i class="fas fa-undo"></i>
                    <span>Đổi trả dễ dàng</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Details Tabs -->
    <div class="bg-white rounded-lg shadow-sm mb-8">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <button onclick="showTab('description')"
                        class="tab-button py-4 px-1 border-b-2 border-green-500 font-medium text-sm text-green-600"
                        id="description-tab">
                    Mô tả sản phẩm
                </button>
                <button onclick="showTab('nutritional')"
                        class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700"
                        id="nutritional-tab">
                    Thông tin dinh dưỡng
                </button>
                <button onclick="showTab('reviews')"
                        class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700"
                        id="reviews-tab">
                    Đánh giá ({{ $product->reviews_count ?? 24 }})
                </button>
                <button onclick="showTab('shipping')"
                        class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700"
                        id="shipping-tab">
                    Giao hàng & Đổi trả
                </button>
            </nav>
        </div>

        <div class="p-6">
            <!-- Description Tab -->
            <div id="description-content" class="tab-content">
                <div class="prose max-w-none">
                    <h3 class="text-lg font-semibold mb-4">Mô tả chi tiết</h3>
                    <p class="text-gray-700 mb-4">
                        {{ $product->description ?? 'Sản phẩm rau củ quả tươi ngon được chọn lọc kỹ càng từ những vườn rau sạch, đảm bảo chất lượng và độ tươi ngon cao nhất. Sản phẩm giàu vitamin và khoáng chất, tốt cho sức khỏe.' }}
                    </p>

                    <h4 class="font-semibold mb-2">Đặc điểm nổi bật:</h4>
                    <ul class="list-disc list-inside space-y-2 text-gray-700 mb-4">
                        <li>Tươi ngon, được thu hoạch trong ngày</li>
                        <li>Không sử dụng hóa chất độc hại</li>
                        <li>Giàu vitamin và chất xơ</li>
                        <li>Được kiểm tra chất lượng nghiêm ngặt</li>
                        <li>Bao bì thân thiện với môi trường</li>
                    </ul>

                    <h4 class="font-semibold mb-2">Cách bảo quản:</h4>
                    <p class="text-gray-700">
                        Bảo quản trong ngăn mát tủ lạnh ở nhiệt độ 2-8°C. Sử dụng trong vòng 3-5 ngày để đảm bảo độ tươi ngon tốt nhất.
                    </p>
                </div>
            </div>

            <!-- Nutritional Tab -->
            <div id="nutritional-content" class="tab-content hidden">
                <h3 class="text-lg font-semibold mb-4">Thông tin dinh dưỡng</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-600 mb-4">Giá trị dinh dưỡng trên 100g sản phẩm:</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-700">Năng lượng:</span>
                                <span class="font-medium">25 kcal</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-700">Protein:</span>
                                <span class="font-medium">2.5g</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-700">Carbohydrate:</span>
                                <span class="font-medium">4.5g</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-700">Chất béo:</span>
                                <span class="font-medium">0.2g</span>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-700">Chất xơ:</span>
                                <span class="font-medium">2.8g</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-700">Vitamin C:</span>
                                <span class="font-medium">80mg</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-700">Canxi:</span>
                                <span class="font-medium">40mg</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-700">Sắt:</span>
                                <span class="font-medium">1.2mg</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reviews Tab -->
            <div id="reviews-content" class="tab-content hidden">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold">Đánh giá khách hàng</h3>
                    <button class="bg-green-600 text-white px-4 py-2 rounded-md text-sm hover:bg-green-700">
                        Viết đánh giá
                    </button>
                </div>

                <!-- Rating Summary -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <div class="flex items-center gap-4">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-gray-900">{{ $product->rating ?? 4.5 }}</div>
                            <div class="flex items-center justify-center mb-1">
                                @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= ($product->rating ?? 4) ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                @endfor
                            </div>
                            <div class="text-sm text-gray-600">{{ $product->reviews_count ?? 24 }} đánh giá</div>
                        </div>
                        <div class="flex-1">
                            <div class="space-y-2">
                                @for($i = 5; $i >= 1; $i--)
                                <div class="flex items-center gap-2">
                                    <span class="text-sm w-8">{{ $i }} sao</span>
                                    <div class="flex-1 bg-gray-200 rounded-full h-2">
                                        <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ rand(10, 80) }}%"></div>
                                    </div>
                                    <span class="text-sm text-gray-600 w-8">{{ rand(1, 15) }}</span>
                                </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Individual Reviews -->
                <div class="space-y-4">
                    @for($i = 1; $i <= 3; $i++)
                    <div class="border-b border-gray-200 pb-4">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <span class="text-green-600 font-semibold">{{ chr(64 + $i) }}</span>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="font-medium">Khách hàng {{ chr(64 + $i) }}</span>
                                    <div class="flex items-center">
                                        @for($j = 1; $j <= 5; $j++)
                                        <i class="fas fa-star {{ $j <= rand(4, 5) ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                                        @endfor
                                    </div>
                                    <span class="text-sm text-gray-500">{{ rand(1, 30) }} ngày trước</span>
                                </div>
                                <p class="text-gray-700 mb-2">
                                    @if($i == 1)
                                    Sản phẩm rất tươi ngon, giao hàng nhanh. Tôi sẽ mua lại lần sau.
                                    @elseif($i == 2)
                                    Chất lượng tốt, đóng gói cẩn thận. Rau rất xanh và tươi.
                                    @else
                                    Giá cả hợp lý, sản phẩm đúng như mô tả. Rất hài lòng.
                                    @endif
                                </p>
                                <button class="text-sm text-gray-500 hover:text-gray-700">
                                    <i class="far fa-thumbs-up mr-1"></i>Hữu ích ({{ rand(1, 10) }})
                                </button>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>

                <div class="text-center mt-6">
                    <button class="text-green-600 hover:text-green-700 font-medium">
                        Xem thêm đánh giá
                    </button>
                </div>
            </div>

            <!-- Shipping Tab -->
            <div id="shipping-content" class="tab-content hidden">
                <h3 class="text-lg font-semibold mb-4">Chính sách giao hàng & đổi trả</h3>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold mb-3 text-green-600">
                            <i class="fas fa-truck mr-2"></i>Giao hàng
                        </h4>
                        <ul class="space-y-2 text-gray-700">
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-green-500 mt-1"></i>
                                <span>Giao hàng miễn phí cho đơn hàng từ 200,000đ</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-green-500 mt-1"></i>
                                <span>Giao hàng trong vòng 2-4 giờ tại nội thành</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-green-500 mt-1"></i>
                                <span>Giao hàng trong ngày tại các tỉnh lân cận</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-green-500 mt-1"></i>
                                <span>Đóng gói cẩn thận, giữ độ tươi ngon</span>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-semibold mb-3 text-orange-600">
                            <i class="fas fa-undo mr-2"></i>Đổi trả
                        </h4>
                        <ul class="space-y-2 text-gray-700">
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-green-500 mt-1"></i>
                                <span>Đổi trả trong vòng 2 giờ sau khi nhận hàng</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-green-500 mt-1"></i>
                                <span>Hoàn tiền 100% nếu sản phẩm không tươi</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-green-500 mt-1"></i>
                                <span>Hỗ trợ đổi hàng miễn phí</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-green-500 mt-1"></i>
                                <span>Chăm sóc khách hàng 24/7</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Sản phẩm liên quan</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @for($i = 1; $i <= 4; $i++)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="relative">
                    <img src="{{ asset('images/products/related-' . $i . '.jpg') }}"
                         alt="Sản phẩm liên quan {{ $i }}"
                         class="w-full h-48 object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center opacity-0 hover:opacity-100">
                        <a href="#" class="bg-white text-gray-800 px-4 py-2 rounded-full text-sm font-medium hover:bg-gray-100">
                            Xem nhanh
                        </a>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-800 mb-2">Sản phẩm liên quan {{ $i }}</h3>
                    <div class="flex items-center justify-between">
                        <span class="text-green-600 font-bold">{{ number_format(rand(30000, 80000)) }}đ</span>
                        <button class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                            <i class="fas fa-cart-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</div>

<script>
let currentQuantity = 1;
const maxQuantity = {{ $product->stock ?? 10 }};

function changeMainImage(src) {
    document.getElementById('mainImage').src = src;

    // Update thumbnail borders
    document.querySelectorAll('.w-20').forEach(thumb => {
        thumb.classList.remove('border-green-500');
        thumb.classList.add('border-gray-200');
    });
    event.target.classList.remove('border-gray-200');
    event.target.classList.add('border-green-500');
}

function increaseQuantity() {
    if (currentQuantity < maxQuantity) {
        currentQuantity++;
        document.getElementById('quantity').value = currentQuantity;
    }
}

function decreaseQuantity() {
    if (currentQuantity > 1) {
        currentQuantity--;
        document.getElementById('quantity').value = currentQuantity;
    }
}

function addToCart(productId) {
    const quantity = document.getElementById('quantity').value;
    // Add to cart logic here
    alert(`Đã thêm ${quantity} sản phẩm vào giỏ hàng!`);
}

function buyNow(productId) {
    const quantity = document.getElementById('quantity').value;
    // Buy now logic here
    window.location.href = `/checkout?product=${productId}&quantity=${quantity}`;
}

function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });

    // Remove active class from all tabs
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('border-green-500', 'text-green-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });

    // Show selected tab content
    document.getElementById(tabName + '-content').classList.remove('hidden');

    // Add active class to selected tab
    const activeTab = document.getElementById(tabName + '-tab');
    activeTab.classList.remove('border-transparent', 'text-gray-500');
    activeTab.classList.add('border-green-500', 'text-green-600');
}

// Update quantity when input changes
document.getElementById('quantity').addEventListener('change', function() {
    const value = parseInt(this.value);
    if (value > maxQuantity) {
        this.value = maxQuantity;
        currentQuantity = maxQuantity;
    } else if (value < 1) {
        this.value = 1;
        currentQuantity = 1;
    } else {
        currentQuantity = value;
    }
});
</script>
@endsection
