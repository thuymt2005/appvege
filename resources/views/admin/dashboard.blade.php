@extends('layouts.admin')

@section('content')
<h1>Welcome Admin</h1>
<!-- Nút Logout -->
<form action="{{ route('logout') }}" method="POST" style="display:inline;">
    @csrf
    <button type="submit">Logout</button>
</form>
@endsection
