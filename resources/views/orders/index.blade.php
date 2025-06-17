@extends('layouts.app')

@section('title', 'Đơn hàng của tôi')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Đơn hàng của tôi</h1>
            <p class="text-gray-600 mt-1">Theo dõi và quản lý các đơn hàng của bạn</p>
        </div>
        <a href="{{ route('home') }}"
           class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Đặt hàng mới
        </a>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <div class="relative">
                    <input type="text"
                           placeholder="Tìm kiếm theo mã đơn hàng..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           id="searchOrder">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Status Filter -->
            <div class="md:w-48">
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" id="statusFilter">
                    <option value="">Tất cả trạng thái</option>
                    <option value="pending">Chờ xử lý</option>
                    <option value="confirmed">Đã xác nhận</option>
                    <option value="shipping">Đang giao</option>
                    <option value="delivered">Đã giao</option>
                    <option value="cancelled">Đã hủy</option>
                </select>
            </div>

            <!-- Date Range -->
            <div class="md:w-48">
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" id="dateFilter">
                    <option value="">Tất cả thời gian</option>
                    <option value="today">Hôm nay</option>
                    <option value="week">7 ngày qua</option>
                    <option value="month">30 ngày qua</option>
                    <option value="3months">3 tháng qua</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Orders List -->
    <div class="space-y-4" id="ordersList">
        @forelse($orders ?? [] as $order)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                <!-- Order Header -->
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="flex items-center space-x-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">
                                    Đơn hàng #{{ $order->id ?? 'DH001' }}
                                </h3>
                                <p class="text-sm text-gray-600">
                                    Đặt ngày {{ isset($order) ? $order->created_at->format('d/m/Y H:i') : '15/06/2025 14:30' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4 mt-2 md:mt-0">
                            <!-- Status Badge -->
                            @php
                                $status = $order->status ?? 'pending';
                                $statusConfig = [
                                    'pending' => ['text' => 'Chờ xử lý', 'class' => 'bg-yellow-100 text-yellow-800'],
                                    'confirmed' => ['text' => 'Đã xác nhận', 'class' => 'bg-blue-100 text-blue-800'],
                                    'shipping' => ['text' => 'Đang giao', 'class' => 'bg-purple-100 text-purple-800'],
                                    'delivered' => ['text' => 'Đã giao', 'class' => 'bg-green-100 text-green-800'],
                                    'cancelled' => ['text' => 'Đã hủy', 'class' => 'bg-red-100 text-red-800'],
                                ];
                            @endphp

                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium {{ $statusConfig[$status]['class'] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $statusConfig[$status]['text'] ?? 'Chờ xử lý' }}
                            </span>

                            <!-- Total Amount -->
                            <div class="text-right">
                                <p class="text-lg font-bold text-green-600">
                                    {{ isset($order) ? number_format($order->total_amount, 0, ',', '.') : '250.000' }}₫
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ isset($order) ? $order->items_count : 3 }} sản phẩm
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items Preview -->
                <div class="px-6 py-4">
                    <div class="flex items-center space-x-4">
                        <!-- Sample Product Images -->
                        <div class="flex -space-x-2">
                            @for($i = 1; $i <= 3; $i++)
                                <div class="w-12 h-12 rounded-lg bg-gray-100 border-2 border-white flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                            @endfor
                        </div>

                        <!-- Product Names -->
                        <div class="flex-1">
                            <p class="text-sm text-gray-600">
                                {{ isset($order) ? $order->items_preview : 'Cà rốt hữu cơ, Rau cải xanh, Cà chua bi...' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Order Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-2 sm:space-y-0">
                        <!-- Delivery Info -->
                        <div class="text-sm text-gray-600">
                            <p><strong>Giao đến:</strong> {{ isset($order) ? Str::limit($order->delivery_address, 40) : '123 Đường ABC, Quận 1, TP.HCM' }}</p>
                            <p><strong>Thanh toán:</strong> {{ isset($order) ? $order->payment_method : 'Thanh toán khi nhận hàng' }}</p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-2">
                            <a href="{{ route('orders.show', $order->id ?? 1) }}"
                               class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Chi tiết
                            </a>

                            @if(($order->status ?? 'pending') === 'delivered')
                                <button class="inline-flex items-center px-3 py-2 border border-green-300 rounded-md text-sm font-medium text-green-700 bg-green-50 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Mua lại
                                </button>
                            @elseif(($order->status ?? 'pending') === 'pending')
                                <button class="inline-flex items-center px-3 py-2 border border-red-300 rounded-md text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                        onclick="confirmCancel({{ $order->id ?? 1 }})">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Hủy đơn
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Chưa có đơn hàng nào</h3>
                <p class="text-gray-500 mb-6">Bạn chưa có đơn hàng nào. Hãy bắt đầu mua sắm ngay!</p>
                <a href="{{ route('home') }}"
                   class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Bắt đầu mua sắm
                </a>
            </div>
        @endforelse

        <!-- Sample Orders (for demo when no orders exist) -->
        @if(!isset($orders) || count($orders ?? []) === 0)
            @for($i = 1; $i <= 3; $i++)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                    <!-- Order Header -->
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="flex items-center space-x-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Đơn hàng #DH00{{ $i }}</h3>
                                    <p class="text-sm text-gray-600">Đặt ngày {{ date('d/m/Y H:i', strtotime("-{$i} days")) }}</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4 mt-2 md:mt-0">
                                @php
                                    $sampleStatuses = ['pending', 'confirmed', 'delivered'];
                                    $status = $sampleStatuses[$i - 1];
                                    $statusConfig = [
                                        'pending' => ['text' => 'Chờ xử lý', 'class' => 'bg-yellow-100 text-yellow-800'],
                                        'confirmed' => ['text' => 'Đã xác nhận', 'class' => 'bg-blue-100 text-blue-800'],
                                        'delivered' => ['text' => 'Đã giao', 'class' => 'bg-green-100 text-green-800'],
                                    ];
                                @endphp

                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium {{ $statusConfig[$status]['class'] }}">
                                    {{ $statusConfig[$status]['text'] }}
                                </span>

                                <div class="text-right">
                                    <p class="text-lg font-bold text-green-600">{{ number_format((150 + $i * 50) * 1000, 0, ',', '.') }}₫</p>
                                    <p class="text-xs text-gray-500">{{ 2 + $i }} sản phẩm</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items Preview -->
                    <div class="px-6 py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex -space-x-2">
                                @for($j = 1; $j <= 3; $j++)
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 border-2 border-white flex items-center justify-center">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                @endfor
                            </div>

                            <div class="flex-1">
                                <p class="text-sm text-gray-600">
                                    @if($i === 1) Cà rốt hữu cơ, Rau cải xanh, Cà chua bi...
                                    @elseif($i === 2) Khoai tây, Bắp cải, Dưa chuột...
                                    @else Súp lơ xanh, Cà tím, Ớt chuông...
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Actions -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-2 sm:space-y-0">
                            <div class="text-sm text-gray-600">
                                <p><strong>Giao đến:</strong> 123 Đường ABC, Quận {{ $i }}, TP.HCM</p>
                                <p><strong>Thanh toán:</strong>
                                    @if($i === 1) Thanh toán khi nhận hàng
                                    @elseif($i === 2) Chuyển khoản
                                    @else Ví điện tử
                                    @endif
                                </p>
                            </div>

                            <div class="flex space-x-2">
                                <a href="{{ route('orders.show', $i) }}"
                                   class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Chi tiết
                                </a>

                                @if($status === 'delivered')
                                    <button class="inline-flex items-center px-3 py-2 border border-green-300 rounded-md text-sm font-medium text-green-700 bg-green-50 hover:bg-green-100">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        Mua lại
                                    </button>
                                @elseif($status === 'pending')
                                    <button class="inline-flex items-center px-3 py-2 border border-red-300 rounded-md text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100"
                                            onclick="confirmCancel({{ $i }})">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Hủy đơn
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        @endif
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
            <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                <span class="sr-only">Previous</span>
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            </a>
            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">1</a>
            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-green-50 text-sm font-medium text-green-600">2</a>
            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">3</a>
            <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                <span class="sr-only">Next</span>
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </a>
        </nav>
    </div>
</div>

<!-- Cancel Confirmation Modal -->
<div id="cancelModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">Xác nhận hủy đơn hàng</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">Bạn có chắc chắn muốn hủy đơn hàng này không? Hành động này không thể hoàn tác.</p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="confirmCancelBtn" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                    Hủy đơn
                </button>
                <button id="closeCancelModal" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Đóng
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let orderToCancel = null;

function confirmCancel(orderId) {
    orderToCancel = orderId;
    document.getElementById('cancelModal').classList.remove('hidden');
}

document.getElementById('closeCancelModal').addEventListener('click', function() {
    document.getElementById('cancelModal').classList.add('hidden');
    orderToCancel = null;
});

document.getElementById('confirmCancelBtn').addEventListener('click', function() {
    if (orderToCancel) {
        // Here you would typically send an AJAX request to cancel the order
        console.log('Cancelling order:', orderToCancel);

        // For demo purposes, just hide the modal and show success message
        document.getElementById('cancelModal').classList.add('hidden');

        // You can add actual cancellation logic here
        // Example: window.location.href = '/orders/' + orderToCancel + '/cancel';

        alert('Đơn hàng đã được hủy thành công!');
        location.reload();
    }
});

// Search functionality
document.getElementById('searchOrder').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    filterOrders();
});

// Status filter
document.getElementById('statusFilter').addEventListener('change', function() {
    filterOrders();
});

// Date filter
document.getElementById('dateFilter').addEventListener('change', function() {
    filterOrders();
});

function filterOrders() {
    const searchTerm = document.getElementById('searchOrder').value.toLowerCase();
    const statusFilter = document.getElementById('statusFilter').value;
    const dateFilter = document.getElementById('dateFilter').value;

    // This would typically be handled by backend
    // For demo purposes, just console log the filters
    console.log('Filtering orders:', { searchTerm, statusFilter, dateFilter });
}

// Close modal when clicking outside
document.getElementById('cancelModal').addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.add('hidden');
        orderToCancel = null;
    }
});
</script>
@endsection
