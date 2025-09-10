@extends('web.layouts.master-empty')

@section('title', 'Truy cập bị từ chối')

@section('content')
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="error-container text-center p-5" style="max-width: 700px; width: 90%;" data-aos="zoom-in">
            <div class="error-icon mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-x-circle"
                    viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
                    <path
                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg>
            </div>
            <h1 class="mb-3">Truy cập bị từ chối</h1>
            <p class="text-danger mb-4">{{ $message }}</p>
            <a href="{{ route('home.index') }}" class="btn btn-danger btn-lg">Quay về trang chủ</a>
        </div>
    </div>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .error-container {
            max-width: 500px;
            margin: 80px auto;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .error-icon {
            font-size: 80px;
            color: #dc3545;
            margin-bottom: 20px;
        }
    </style>
@stop
