<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="VegMarket - Cung cấp rau củ quả tươi ngon, chất lượng cao với giá cả hợp lý">
    <meta name="keywords" content="rau củ, trái cây, thực phẩm sạch, rau hữu cơ">

    <title>{{ config('app.name', 'VegMarket') }} - @yield('title', 'Rau Củ Quả Tươi Ngon')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-green: #2d5016;
            --light-green: #4caf50;
            --orange: #ff6b35;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-green) !important;
        }

        .btn-primary {
            background-color: var(--light-green);
            border-color: var(--light-green);
        }

        .btn-primary:hover {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }

        .btn-outline-primary {
            color: var(--light-green);
            border-color: var(--light-green);
        }

        .btn-outline-primary:hover {
            background-color: var(--light-green);
            border-color: var(--light-green);
        }

        .text-primary {
            color: var(--light-green) !important;
        }

        .bg-primary {
            background-color: var(--light-green) !important;
        }

        .product-card {
            transition: transform 0.2s;
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        .cart-badge {
            background-color: var(--orange);
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.75rem;
        }

        footer {
            background-color: var(--primary-green);
        }

        .list-group-item.active {
            background-color: var(--light-green);
            border-color: var(--light-green);
        }

        .progress-bar {
            background-color: var(--light-green);
        }

        .badge.bg-success {
            background-color: var(--light-green) !important;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-leaf me-2"></i>VegMarket
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('products*') ? 'active' : '' }}" href="{{ url('/products') }}">Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('about*') ? 'active' : '' }}" href="{{ url('/about') }}">Về chúng tôi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('contact*') ? 'active' : '' }}" href="{{ url('/contact') }}">Liên hệ</a>
                    </li>
                </ul>

                <!-- Search Form -->
                <form class="d-flex me-3" action="{{ url('/search') }}" method="GET">
                    <div class="input-group">
                        <input type="search" name="q" class="form-control" placeholder="Tìm sản phẩm..." aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Đăng nhập</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Đăng ký</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="cart-badge position-absolute top-0 start-100 translate-middle text-white">
                                    {{ session('cart') ? count(session('cart')) : 0 }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.profile') }}">Thông tin cá nhân</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}">Đơn hàng</a></li>
                                <li><hr class="dropdown-divider"></li>
                                @if(Auth::user()->is_admin)
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Quản trị</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Đăng xuất</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="fas fa-leaf me-2"></i>VegMarket</h5>
                    <p>Cung cấp rau củ quả tươi ngon, chất lượng cao với giá cả hợp lý.</p>
                    <div class="mt-3">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-2">
                    <h6>Danh mục</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/products/vegetables') }}" class="text-white-50">Rau xanh</a></li>
                        <li><a href="{{ url('/products/fruits') }}" class="text-white-50">Trái cây</a></li>
                        <li><a href="{{ url('/products/roots') }}" class="text-white-50">Củ quả</a></li>
                        <li><a href="{{ url('/products/organic') }}" class="text-white-50">Hữu cơ</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Thông tin</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/about') }}" class="text-white-50">Về chúng tôi</a></li>
                        <li><a href="{{ url('/policy/shipping') }}" class="text-white-50">Chính sách vận chuyển</a></li>
                        <li><a href="{{ url('/policy/return') }}" class="text-white-50">Chính sách đổi trả</a></li>
                        <li><a href="{{ url('/policy/privacy') }}" class="text-white-50">Chính sách bảo mật</a></li>
                        <li><a href="{{ url('/contact') }}" class="text-white-50">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Liên hệ</h6>
                    <p class="text-white-50 mb-1"><i class="fas fa-map-marker-alt me-2"></i>123 Nguyễn Văn Linh, Quận 7, TP.HCM</p>
                    <p class="text-white-50 mb-1"><i class="fas fa-phone me-2"></i>0123 456 789</p>
                    <p class="text-white-50"><i class="fas fa-envelope me-2"></i>info@vegmarket.com</p>
                </div>
            </div>
            <hr class="text-white-50">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} VegMarket. Tất cả quyền được bảo lưu.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>

    @stack('scripts')
</body>
</html>
