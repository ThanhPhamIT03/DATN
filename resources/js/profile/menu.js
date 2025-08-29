$(document).ready(function () {
    // Hàm set trạng thái view
    function setView(view) {
        if (view === "history") {
            $("#over-view").addClass("d-none").removeClass("d-block");
            $("#bought-history").removeClass("d-none").addClass("d-block");

            $("#over-view-btn").removeClass("active");
            $("#bought-history-btn").addClass("active");
        } else {
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