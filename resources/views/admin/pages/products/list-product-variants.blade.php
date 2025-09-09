@extends('admin.layouts.master')

@section('title', 'Danh sách biến thể sản phẩm')

@section('script')

@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Sản phẩm</a></li>
    <li class="breadcrumb-item" aria-current="page">Danh sách biến thể sản phẩm</li>
@stop