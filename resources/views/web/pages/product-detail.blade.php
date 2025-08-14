@extends('web.layouts.master')

@section('title', 'Chi tiết sản phẩm')

@section('script')
    <script type="module">

    </script>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
    <li class="breadcrumb-item"><a href="#">Sản phẩm</a></li>
    <li class="breadcrumb-item" aria-current="page">Chi tiết sản phẩm</li>
@endsection

@section('content')
    <div class="container-xl vh-100">
        <div class="row">
            <div class="col-md-6">
                <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('./images/iphone-16-pro-max.webp') }}" class="d-block mx-auto" alt="iPhone 16 Pro Max">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('./images/iphone-16-pro-max-titan-den.webp') }}" class="d-block mx-auto" alt="iPhone 16 Pro Max Titan Đen">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('./images/iphone-16-pro-max-titan-tu-nhien.webp') }}" class="d-block mx-auto" alt="iPhone 16 Pro Max Titan Tự Nhiên">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                        <i class="bi bi-chevron-left icon-prev"></i>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                        <i class="bi bi-chevron-right icon-next"></i>
                        <span class="visually-hidden">Next</span>
                    </button>
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                
            </div>
        </div>
    </div>
    <div class="overlay" style="display: none;"></div> 
@stop