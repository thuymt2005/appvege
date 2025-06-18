@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Đơn hàng của tôi</h2>

    @if($orders->isEmpty())
        <div class="alert alert-info">Bạn chưa có đơn hàng nào.</div>
    @else
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Ngày đặt</th>
                    <th>Trạng thái</th>
                    <th>Thanh toán</th>
                    <th>Tổng tiền</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td><span class="badge bg-secondary">{{ ucfirst($order->status) }}</span></td>
                    <td><span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                        {{ ucfirst($order->payment_status) }}
                    </span></td>
                    <td>{{ number_format($order->total_price, 0, ',', '.') }} đ</td>
                    <td>
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                            Xem
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
