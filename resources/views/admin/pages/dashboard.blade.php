@extends('admin.layouts.master')

@section('script')
    <script type="module">
        $(function() {
            var path = window.location.pathname;

            $('.admin-menu .collapse .list-group-item').each(function() {
                if ($(this).attr('href') === path) {
                    $(this).addClass('active-item');

                    $(this).closest('.collapse').addClass('show')
                        .prev('a.list-group-item').addClass('active-item-parent').attr('aria-expanded',
                            true);
                }
            });
        });
    </script>
@endsection
