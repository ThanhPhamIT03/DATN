@extends('admin.layouts.master')

@section('title', 'Chi tiết đơn hàng')

@section('script')
    <script type="module"></script>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.order.list.index') }}">Đơn hàng</a></li>
    <li class="breadcrumb-item" aria-current="page">Chi tiết đơn hàng</li>
@stop

@section('content')

@stop