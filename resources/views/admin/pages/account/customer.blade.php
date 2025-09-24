@extends('admin.layouts.master')

@section('title', 'Quản lý tài khoản khách hàng')

@section('script')
    <script type="module"></script>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Quản lý tài khoản</a></li>
    <li class="breadcrumb-item" aria-current="page">Tài khoản khách hàng</li>
@stop

@section('content')
    <div class="container mt-2 pb-4">
        <h3 class="mb-4">Quản lý tài khoản khách hàng</h3>
    </div>
@stop
