$(document).ready(function () {
    // Hàm set trạng thái view
    function setView(view) {
        if (view === "history") {
            $("#over-view").addClass("d-none").removeClass("d-block");
            $("#bought-history").removeClass("d-none").addClass("d-block");

            $("#over-view-btn").removeClass("active");
            $("#bought-history-btn").addClass("active");
        }
        else {
            $("#over-view").removeClass("d-none").addClass("d-block");
            $("#bought-history").addClass("d-none").removeClass("d-block");

            $("#bought-history-btn").removeClass("active");
            $("#over-view-btn").addClass("active");
        }
    }

    // Khi bấm Lịch sử mua hàng
    $("#bought-history-btn").on("click", function (e) {
        e.preventDefault();
        setView("history");
        localStorage.setItem("currentView", "history");
    });

    // Khi bấm nút Thông tin cá nhân
    $("#info-btn").on("click", function (e) {
        e.preventDefault();
        setView("info");
        localStorage.setItem("currentView", "info");
    });

    // Khi bấm nút Tra cứu bảo hành
    $("#warranty-btn").on("click", function (e) {
        e.preventDefault();
        setView("warranty");
        localStorage.setItem("currentView", "warranty");
    });

    // Khi bấm nút Chính sách bảo hành
    $("#warranty-policy-btn").on("click", function (e) {
        e.preventDefault();
        setView("warranty-policy");
        localStorage.setItem("currentView", "warranty-policy");
    });

    // Khi bấm nút Góp ý - Phản hồi
    $("#support-btn").on("click", function (e) {
        e.preventDefault();
        setView("support");
        localStorage.setItem("currentView", "support");
    });

    // Khi bấm nút Điều khoản sử dụng
    $("#policy-btn").on("click", function (e) {
        e.preventDefault();
        setView("policy");
        localStorage.setItem("currentView", "policy");
    });

    // Khi bấm Tổng quan
    $("#over-view-btn").on("click", function (e) {
        e.preventDefault();
        setView("overview");
        localStorage.setItem("currentView", "overview");
    });

    // Khi load lại trang, lấy trạng thái đã lưu
    let currentView = localStorage.getItem("currentView") || "overview";
    setView(currentView);
});