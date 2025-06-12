@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    {{-- <p>Xin chào quản trị viên: {{ Auth::user()->name }}</p> --}}

    {{-- Ví dụ nội dung --}}
    <ul>
        <li>Quản lý người dùng</li>
        <li>Quản lý sản phẩm</li>
        <li>Thống kê đơn hàng</li>
    </ul>
</div>
@endsection
