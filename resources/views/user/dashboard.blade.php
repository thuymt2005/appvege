@extends('layouts.app')

@section('content')
<div class="container">
    {{-- <h1>Chào mừng, {{ Auth::user()->name }}!</h1> --}}
    <p>Đây là Dashboard của người dùng.</p>

    {{-- Ví dụ nội dung --}}
    <ul>
        <li>Xem thông tin cá nhân</li>
        <li>Giỏ hàng</li>
        <li>Lịch sử đơn hàng</li>
    </ul>
</div>
@endsection
