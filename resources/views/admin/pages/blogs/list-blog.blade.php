@extends('admin.layouts.master')

@section('title', 'Danh sách bài viết')

@section('script')

@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Quản lý bài viết</a></li>
    <li class="breadcrumb-item" aria-current="page">Danh sách bài viết</li>
@stop

@section('content')

@stop