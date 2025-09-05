import Swal from 'sweetalert2';
window.Swal = Swal;

document.addEventListener('DOMContentLoaded', () => {
    // ==== Hiển thị alert từ session (gửi từ Laravel) ====
    if (window.LaravelSwalMessage) {
        const { type, message } = window.LaravelSwalMessage;

        let title = {
            success: 'Thành công!',
            error: 'Lỗi!',
            warning: 'Cảnh báo!',
            info: 'Thông tin',
        }[type] || 'Thông báo';

        Swal.fire({
            icon: type, 
            title: title,
            text: message,
            confirmButtonText: 'OK',
        });
    }

    // ==== Xử lý xác nhận hành động ====
    document.querySelectorAll('.swal-confirm').forEach(el => {
        el.addEventListener('click', function (e) {
            e.preventDefault();

            const title = el.dataset.title || 'Bạn có chắc chắn?';
            const text = el.dataset.text || 'Hành động này không thể hoàn tác!';
            const confirmText = el.dataset.confirmText || 'Đồng ý';
            const cancelText = el.dataset.cancelText || 'Hủy';
            const href = el.getAttribute('href') || el.dataset.href;
            const formId = el.dataset.form;

            Swal.fire({
                icon: 'warning',
                title,
                text,
                showCancelButton: true,
                confirmButtonText: confirmText,
                cancelButtonText: cancelText,
            }).then((result) => {
                if (result.isConfirmed) {
                    if (href) {
                        window.location.href = href;
                    } else if (formId) {
                        document.getElementById(formId)?.submit();
                    }
                }
            });
        });
    });
});
