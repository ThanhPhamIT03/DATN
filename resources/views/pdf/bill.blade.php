<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .file-header {
            display: flex;
            justify-content: space-between;
            /* Logo bên trái, info bên phải */
            align-items: center;
            /* Căn giữa theo chiều dọc */
            border-bottom: 2px solid #000;
            /* Đường gạch dưới header */
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .file-header-logo h2 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .file-header-info {
            text-align: left;
            /* Căn chữ sang phải */
        }

        .file-header-info h5 {
            margin: 0 0 5px 0;
        }

        .file-header-info p {
            margin: 2px 0;
            font-size: 14px;
        }

        .file-title {
            text-align: center;
            /* Căn giữa theo chiều ngang */
            margin: 20px 0;
            /* Khoảng cách trên dưới */
        }

        .file-title h2 {
            margin: 0;
            font-size: 26px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .file-title span {
            display: block;
            /* Xuống dòng dưới h2 */
            margin-top: 5px;
            font-size: 16px;
            font-weight: normal;
        }

        .file-footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #000;
        }
    </style>
</head>

<body>
    <div class="file-header">
        <div class="file-header-info">
            <h2>SƠN THẢO MOBILE - HỆ THỐNG BÁN LẺ ĐIỆN THOẠI DI ĐỘNG</h2>
            <p><strong>Cơ sở 1: </strong>3 P. Phạm Khắc Quảng, Giang Biên, Long Biên, Hà Nội</p>
            <p><strong>Cơ sở 2: </strong>KIOT 01 Chợ Phúc Lợi - Long Biên - Hà Nội</p>
            <p><strong>Cơ sở 3: </strong>15 P. Việt Hưng, Việt Hưng, Long Biên, Hà Nội</p>
            <p><strong>Website: </strong>https://sonthao.mobile.com</p>
        </div>
    </div>
    <div class="file-title">
        <h2>HÓA ĐƠN BÁN HÀNG</h2> <span>{{ $billCode }}</span>
    </div>
    <div class="file-customer-info">
        <p><strong>Mã đơn hàng:</strong> #{{ $order->order_code }}</p>
        <p><strong>Khách hàng:</strong> {{ $customerInfo['name'] }}</p>
        <p><strong>SĐT:</strong> {{ $customerInfo['phone'] }}</p>
        <p><strong>Email:</strong> {{ $customerInfo['email'] }}</p>
        <p><strong>Địa chỉ:</strong> {{ $customerInfo['address'] }}</p>
    </div>
    <div class="file-detail-order">
        <h4>Chi tiết đơn hàng</h4>
        <table>
            <thead>
                <tr>
                    <th style="text-align: center;">Sản phẩm</th>
                    <th style="text-align: center;">Dung lượng</th>
                    <th style="text-align: center;">Màu</th>
                    <th style="text-align: center;">Số lượng</th>
                    <th style="text-align: center;">Đơn giá</th>
                    <th style="text-align: center;">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderItems as $item)
                    <tr>
                        <td style="text-align: center;">{{ $item->product_name }}</td>
                        <td style="text-align: center;">{{ $item->variant['ram'] }} - {{ $item->variant['rom'] }}</td>
                        <td style="text-align: center;">{{ $item->variant['color'] }}</td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td class="text-right">{{ number_format($item->price, 0, ',', '.') }} đ</td>
                        <td class="text-right">{{ number_format($item->total_price, 0, ',', '.') }} đ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h3 style="text-align:right; margin-top: 20px; color: red;"> Tổng cộng:
            {{ number_format($total, 0, ',', '.') }} đ </h3>
    </div>
    <div class="file-info">
        <p><strong>10 ngày đầu tiên: </strong>hỗ trợ đổi máy theo nhu cầu khách hàng.</p>
        <p><strong>20 ngày tiếp theo: </strong>hỗ trợ đổi máy với lỗi phần cứng do nhà sản xuất.</p>
        <p><strong>(Tất cả bảo hành không bao gồm lỗi do người dùng).</strong></p> <br>
        {{-- <h4>Điều kiện bảo hành: </h4>
        <ul>
            <li>Bảo hành theo tiêu chuẩn nhà sản xuất.</li>
            <li>Từ chối bảo hành với những trường hợp sau: </li>
            <p>* Hết hạn bảo hành hoặc tem bảo hành của cửa hàng bị rách, mất.</p>
            <p>* Các lỗi do người dùng sử dụng: rơi vỡ, vào nước, sai nguồn điện, ẩm mốc, ...</p>
        </ul>
        <h4>Quy định về bàn giao sản phẩm:</h4>
        <h5>1. Đối với sản phẩm mới:</h5>
        <p><strong>- Mua tại cửa hàng: </strong>Quý khách vui lòng kiểm tra tình trạng sản phẩm trước khi mua. Sau khi
            bàn giao xong, sau này các lỗi hình thức như xước, rạn nứt, cong vênh, ... nếu có sẽ là lỗi do quá trình sử
            dụng của người dùng.</p>
        <p><strong>- Mua hàng online: </strong>Đối với khách hàng mua online và tự tay bóc máy ở ngoài khu vực cửa hàng.
            Quý khách vui lòng quay lại quá trình bóc seal và kiểm tra hình thức máy ngay tại thời điểm bóc seal. Nếu
            hình thức sản phẩm có lỗi, người dùng vui lòng gửi video cho cửa hàng để được hỗ trợ, trong trường hợp không
            quay lại video thì các lỗi hình thức như xước, rạn nứt, cong vênh, ... nếu có sẽ là lỗi do quá trình sử dụng
            của người dùng. </p>
        <h5>2. Đối với sản phẩm đã qua sử dụng: </h5>
        <p>Hình thức sản phẩm được mô tả ở phần ghi chú trên hoá đơn. Quý khác vui lòng kiểm tra đối chiếu lại với tình
            trạng sản phẩm tại thời điểm bàn giao nhận máy. Nếu tại thời điểm đó quý khác đã đối chiều xong và không có
            phản hồi về hình thức thì các lỗi hình thức sau đó (không có trong mô tả) sẽ là lỗi do quá trình sử dụng của
            người dùng. </p> --}}
    </div>
    <div class="file-footer">
        <table style="width:100%; text-align:center; border:none; border-collapse:collapse;">
            <tr style="border:none;">
                <td style="width:50%; vertical-align:top; text-align:center; border:none;">
                    <h4 style="margin-bottom:60px;">KHÁCH HÀNG</h4>
                    <strong>{{ $customerInfo['name'] }}</strong>
                </td>
                <td style="width:50%; vertical-align:top; text-align:center; border:none;">
                    <h4 style="margin-bottom:60px;">THU NGÂN</h4>
                    @if($order->payment_method == 'cod')
                        <strong>Thanh toán khi nhận hàng</strong>
                    @else
                        <strong style="color: red;">ĐẪ THANH TOÁN</strong>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
