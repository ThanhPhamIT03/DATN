@extends('web.pages.information.layouts.master')

@section('script')
    <script type="module">
        $(document).ready(function() {
            $(document).on('click', '#btn-fillter', function() {
                $('#filterForm').submit();
            });
        });
    </script>
@stop

@section('title', 'Lịch sử mua hàng')

@section('content')
    @include('web.pages.information.components.history')
@stop
    