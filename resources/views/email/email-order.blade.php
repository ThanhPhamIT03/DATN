<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Thông báo đơn hàng</title>
</head>

<body>
    <p>Xin chào,</p>

    <p>Bạn đã đặt đơn hàng tại <strong>Sơn Thảo Mobile</strong> với mã đơn: <strong>{{ $order_code }}</strong>.</p>

    <p>
        Bấm vào hóa đơn: <a href="{{ $attachmentPath }}" target="_blank">{{ $attachmentName }}</a> để xem chi tiết đơn
        hàng.
    </p>

    <p>Cảm ơn bạn đã mua sắm tại Sơn Thảo Mobile!</p>

    <p>Truy cập website: <a href="https://sonthao.mobile.com">https://sonthao.mobile.com</a> để xem thêm thông tin!</p>
    <p>Số điện thoại: <strong>0337.005.347</strong></p>
</body>

</html>
