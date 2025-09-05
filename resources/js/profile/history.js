
$(document).ready(function () {
    function setStatus(view) {
        // Map các trạng thái
        const views = {
            processing: { id: "#status-processing", cls: "status-processing" },
            all: { id: "#status-all", cls: "status-all" },
            delivery: { id: "#status-delivery", cls: "status-delivery" },
            delivered: { id: "#status-delivered", cls: "status-delivered" },
            cancel: { id: "#status-cancel", cls: "status-cancel" }
        };

        // Reset tất cả class
        for (let key in views) {
            $(views[key].id).removeClass(views[key].cls);
        }

        // Nếu view tồn tại trong map thì add lại class
        if (views[view]) {
            $(views[view].id).addClass(views[view].cls);
        }
    }

    // Khi bấm nút trạng thái processing
    $("#status-processing").on("click", function (e) {
        e.preventDefault();
        setStatus("processing");
        localStorage.setItem("currentStatus", "processing");
    });
    // Khi bấm nút trạng thái delivery
    $("#status-delivery").on("click", function (e) {
        e.preventDefault();
        setStatus("delivery");
        localStorage.setItem("currentStatus", "delivery");
    });
    // Khi bấm nút trạng thái delivered
    $("#status-delivered").on("click", function (e) {
        e.preventDefault();
        setStatus("delivered");
        localStorage.setItem("currentStatus", "delivered");
    });
    // Khi bấm nút trạng thái cancel
    $("#status-cancel").on("click", function (e) {
        e.preventDefault();
        setStatus("cancel");
        localStorage.setItem("currentStatus", "cancel");
    });

    // Khi bấm nút Tất cả
    $("#status-all").on("click", function (e) {
        e.preventDefault();
        setStatus("all");
        localStorage.setItem("currentStatus", "all");
    });

    // Lấy trạng thái đã lưu khi load lại trang
    let currentStatus = localStorage.getItem("currentStatus") || "all";
    setStatus(currentStatus);
});