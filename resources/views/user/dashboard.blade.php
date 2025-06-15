<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - {{ Auth::user()->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.6s ease-out',
                        'bounce-slow': 'bounce 2s infinite',
                        'wiggle': 'wiggle 1s ease-in-out infinite',
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        @keyframes wiggle {
            0%, 100% { transform: rotate(-3deg); }
            50% { transform: rotate(3deg); }
        }
        .gradient-bg {
            background: linear-gradient(135deg, #4ade80 0%, #22c55e 50%, #16a34a 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .leaf-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%234ade80' fill-opacity='0.1'%3E%3Cpath d='M30 30c0-11.046-8.954-20-20-20s-20 8.954-20 20 8.954 20 20 20 20-8.954 20-20zm-20 15c-8.284 0-15-6.716-15-15s6.716-15 15-15 15 6.716 15 15-6.716 15-15 15z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="bg-gradient-to-br from-green-50 to-emerald-50 leaf-pattern">
    <!-- Header -->
    <header class="gradient-bg text-white shadow-lg">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center animate-wiggle">
                        <i class="fas fa-seedling text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold animate-fade-in">Chào mừng, {{ Auth::user()->name }}!</h1>
                        <p class="text-white/80">🌱 Khám phá thế giới rau củ quả tươi ngon</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="hidden md:flex items-center space-x-2 bg-white/20 px-4 py-2 rounded-full">
                        <i class="fas fa-calendar-alt"></i>
                        <span id="current-date"></span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Đăng xuất</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 card-hover animate-slide-up border-l-4 border-green-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Tổng đơn hàng</p>
                        <p class="text-2xl font-bold text-green-600">12</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-shopping-basket text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 card-hover animate-slide-up border-l-4 border-orange-400" style="animation-delay: 0.1s;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Đang chuẩn bị</p>
                        <p class="text-2xl font-bold text-orange-600">3</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-box-open text-orange-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 card-hover animate-slide-up border-l-4 border-blue-400" style="animation-delay: 0.2s;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Đã giao</p>
                        <p class="text-2xl font-bold text-blue-600">8</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-truck text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 card-hover animate-slide-up border-l-4 border-purple-400" style="animation-delay: 0.3s;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Giỏ hàng</p>
                        <p class="text-2xl font-bold text-purple-600">5</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-shopping-cart text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8 animate-slide-up" style="animation-delay: 0.4s;">
            <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-leaf text-green-500 mr-2"></i>
                Mua sắm nhanh
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="" class="group bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white p-4 rounded-lg transition-all duration-200 transform hover:scale-105">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-search text-xl"></i>
                        <span class="font-medium">Tìm rau củ quả</span>
                    </div>
                </a>

                <a href=" " class="group bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white p-4 rounded-lg transition-all duration-200 transform hover:scale-105">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span class="font-medium">Giỏ hàng của tôi</span>
                    </div>
                </a>

                <a href="" class="group bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white p-4 rounded-lg transition-all duration-200 transform hover:scale-105">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-clipboard-list text-xl"></i>
                        <span class="font-medium">Đơn hàng của tôi</span>
                    </div>
                </a>

                <a href="{{ route("user.profile") }}" class="group bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white p-4 rounded-lg transition-all duration-200 transform hover:scale-105">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-user-edit text-xl"></i>
                        <span class="font-medium">Thông tin cá nhân</span>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Orders & Featured Products -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Orders -->
            <div class="bg-white rounded-xl shadow-lg p-6 animate-slide-up" style="animation-delay: 0.5s;">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-history text-green-500 mr-2"></i>
                        Đơn hàng gần đây
                    </h2>
                    <a href=" " class="text-green-600 hover:text-green-800 text-sm font-medium">
                        Xem tất cả →
                    </a>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors duration-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-carrot text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">#RCQ-001</p>
                                <p class="text-sm text-gray-600">Cà rốt Đà Lạt, Bắp cải tươi</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-800">125,000đ</p>
                            <span class="inline-block px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Đã giao</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors duration-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-truck text-orange-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">#RCQ-002</p>
                                <p class="text-sm text-gray-600">Táo Fuji, Cam sành</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-800">89,000đ</p>
                            <span class="inline-block px-2 py-1 bg-orange-100 text-orange-800 text-xs rounded-full">Đang giao</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors duration-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-clock text-yellow-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">#RCQ-003</p>
                                <p class="text-sm text-gray-600">Rau muống, Cải thìa</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-800">45,000đ</p>
                            <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Đang chuẩn bị</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Featured Products -->
            <div class="bg-white rounded-xl shadow-lg p-6 animate-slide-up" style="animation-delay: 0.6s;">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-star text-yellow-500 mr-2"></i>
                        Rau củ quả tươi ngon
                    </h2>
                    <a href=" " class="text-green-600 hover:text-green-800 text-sm font-medium">
                        Xem thêm →
                    </a>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center space-x-4 p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors duration-200 cursor-pointer group">
                        <div class="w-16 h-16 bg-gradient-to-br from-red-400 to-red-500 rounded-lg flex items-center justify-center text-white text-2xl">
                            🍎
                        </div>
                        <div class="flex-1">
                            <h3 class="font-medium text-gray-800">Táo Envy New Zealand</h3>
                            <p class="text-sm text-gray-600">Táo ngọt, giòn, nhập khẩu</p>
                            <p class="text-lg font-bold text-green-600 mt-1">85,000đ/kg</p>
                        </div>
                        <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 group-hover:scale-105">
                            <i class="fas fa-cart-plus"></i>
                        </button>
                    </div>

                    <div class="flex items-center space-x-4 p-4 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors duration-200 cursor-pointer group">
                        <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-orange-500 rounded-lg flex items-center justify-center text-white text-2xl">
                            🥕
                        </div>
                        <div class="flex-1">
                            <h3 class="font-medium text-gray-800">Cà rốt Đà Lạt</h3>
                            <p class="text-sm text-gray-600">Cà rốt tươi, ngọt, giàu vitamin</p>
                            <p class="text-lg font-bold text-green-600 mt-1">25,000đ/kg</p>
                        </div>
                        <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 group-hover:scale-105">
                            <i class="fas fa-cart-plus"></i>
                        </button>
                    </div>

                    <div class="flex items-center space-x-4 p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors duration-200 cursor-pointer group">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-500 rounded-lg flex items-center justify-center text-white text-2xl">
                            🥬
                        </div>
                        <div class="flex-1">
                            <h3 class="font-medium text-gray-800">Rau cải thìa hữu cơ</h3>
                            <p class="text-sm text-gray-600">Rau sạch, không thuốc trừ sâu</p>
                            <p class="text-lg font-bold text-green-600 mt-1">15,000đ/bó</p>
                        </div>
                        <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 group-hover:scale-105">
                            <i class="fas fa-cart-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Special Offers -->
        <div class="bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 rounded-xl shadow-lg p-6 mt-8 text-white animate-slide-up relative overflow-hidden" style="animation-delay: 0.7s;">
            <div class="absolute top-0 right-0 text-9xl opacity-10">🍃</div>
            <div class="flex items-center justify-between relative z-10">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center animate-bounce-slow text-2xl">
                        🎉
                    </div>
                    <div>
                        <h3 class="text-xl font-bold">Tuần lễ rau củ quả tươi ngon!</h3>
                        <p class="text-white/90">🥗 Giảm giá 15% cho tất cả rau củ quả hữu cơ. Miễn phí giao hàng đơn từ 200k</p>
                        <p class="text-sm text-white/80 mt-1">⏰ Áp dụng từ 15/06 - 22/06/2025</p>
                    </div>
                </div>
                <button class="bg-white/20 hover:bg-white/30 px-6 py-3 rounded-lg transition-colors duration-200 font-medium">
                    Mua ngay 🛒
                </button>
            </div>
        </div>

        <!-- Health Tips -->
        <div class="bg-white rounded-xl shadow-lg p-6 mt-8 animate-slide-up" style="animation-delay: 0.8s;">
            <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-heart text-red-500 mr-2"></i>
                Mẹo sức khỏe hôm nay
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-4 rounded-lg border-l-4 border-green-400">
                    <div class="text-3xl mb-2">🥕</div>
                    <h3 class="font-semibold text-gray-800 mb-2">Cà rốt tốt cho mắt</h3>
                    <p class="text-sm text-gray-600">Beta-carotene trong cà rốt giúp cải thiện thị lực và bảo vệ mắt khỏi tổn thương.</p>
                </div>
                <div class="bg-gradient-to-br from-red-50 to-pink-50 p-4 rounded-lg border-l-4 border-red-400">
                    <div class="text-3xl mb-2">🍎</div>
                    <h3 class="font-semibold text-gray-800 mb-2">Táo ngừa bệnh tim</h3>
                    <p class="text-sm text-gray-600">Ăn táo thường xuyên giúp giảm cholesterol và ngăn ngừa các bệnh về tim mạch.</p>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-lime-50 p-4 rounded-lg border-l-4 border-lime-400">
                    <div class="text-3xl mb-2">🥬</div>
                    <h3 class="font-semibold text-gray-800 mb-2">Rau xanh giàu sắt</h3>
                    <p class="text-sm text-gray-600">Rau xanh lá cung cấp sắt và folate, tốt cho máu và hệ thần kinh.</p>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Hiển thị ngày hiện tại
        document.getElementById('current-date').textContent = new Date().toLocaleDateString('vi-VN', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        // Thêm hiệu ứng hover cho các card
        document.querySelectorAll('.card-hover').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Tự động chuyển màu cho banner khuyến mãi
        setInterval(() => {
            const banner = document.querySelector('.bg-gradient-to-r');
            if (banner) {
                banner.style.background = `linear-gradient(135deg,
                    hsl(${Math.random() * 60 + 100}, 70%, 50%),
                    hsl(${Math.random() * 60 + 120}, 70%, 50%),
                    hsl(${Math.random() * 60 + 140}, 70%, 50%))`;
            }
        }, 5000);
    </script>
</body>
</html>
