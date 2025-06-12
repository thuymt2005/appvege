@extends('layouts.user')

@section('content')
<h1>Welcome User {{ Auth::user()->name }}</h1>
<!-- Nút Logout -->
<form action="{{ route('logout') }}" method="POST" style="display:inline;">
    @csrf
    <button type="submit">Logout</button>
</form>
@endsection
