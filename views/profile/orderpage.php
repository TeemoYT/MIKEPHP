<div class="profile-main profile-main--no-border">
    <div class="orders-page">
        <!-- Thanh điều hướng tab -->
        <div class="custom-tab-nav">
            <a class="custom-tab-nav-item custom-tab-nav-item--active" href="#" data-target="#order-tab-all">
                <span>Tất cả</span>
            </a>
            <a class="custom-tab-nav-item" href="#" data-target="#order-tab-pending-confirm">
                <span>Chờ xác nhận</span>
            </a>
            <a class="custom-tab-nav-item" href="#" data-target="#order-tab-pending-pickup">
                <span>Chờ lấy hàng</span>
            </a>
            <a class="custom-tab-nav-item" href="#" data-target="#order-tab-process">
                <span>Đang giao</span>
            </a>
            <a class="custom-tab-nav-item" href="#" data-target="#order-tab-done">
                <span>Đã giao</span>
            </a>
            <a class="custom-tab-nav-item" href="#" data-target="#order-tab-cancel">
                <span>Đã hủy</span>
            </a>
        </div>

        <!-- Nội dung danh sách đơn hàng -->
        <div class="orders-content">
            <div id="order-tab-all" class="order-content">
                <h2>Tất cả đơn hàng</h2>
                <div class="order-list">
        <div class="order-item" data-status="delivered">
            <div class="shop-info">
                <span class="shop-name">NhượmTóc TạiNhà-HòaTóc</span>
                <button class="chat-btn">Chat</button>
                <button class="view-shop-btn">Xem Shop</button>
                <div class="order-status">
                    <span>🚚 Giao hàng thành công</span>
                    <a href="#" class="review">ĐÁNH GIÁ</a>
                </div>
            </div>
            <div class="order-details">
                <img src="/MIKEPHP/img/149071.png" alt="Combo Nhuộm Tóc">
                <div class="order-info">
                    <p class="product-name">Combo Full Dụng Cụ Nhuộm Tóc Cao Cấp Memecolor</p>
                    <p class="product-type">Phân loại hàng: Full Dụng Cụ</p>
                    <p class="quantity">x1</p>
                </div>
                <div class="price">
                    <span class="old-price">40.000đ</span>
                    <span class="new-price">17.600đ</span>
                </div>
            </div>
            <div class="order-actions">
                <span class="total-price">Thành tiền: <b>23.100đ</b></span>
                <button class="buy-again">Mua Lại</button>
                <button class="contact-seller">Liên Hệ Người Bán</button>
                <button class="view-review">Xem Đánh Giá Shop</button>
            </div>
        </div>
    </div>
</div>
            </div>
            <div id="order-tab-pending-confirm" class="order-content">
                <h2>Chờ xác nhận</h2>
                <p>Các đơn hàng đang chờ xác nhận...</p>
            </div>
            <div id="order-tab-pending-pickup" class="order-content">
                <h2>Chờ lấy hàng</h2>
                <p>Danh sách đơn hàng chờ lấy hàng...</p>
            </div>
            <div id="order-tab-process" class="order-content">
                <h2>Đang giao</h2>
                <p>Các đơn hàng đang trong quá trình vận chuyển...</p>
            </div>
            <div id="order-tab-done" class="order-content">
                <h2>Đã giao</h2>
                <p>Danh sách đơn hàng đã giao thành công...</p>
            </div>
            <div id="order-tab-cancel" class="order-content">
                <h2>Đã hủy</h2>
                <p>Các đơn hàng đã bị hủy...</p>
            </div>
        </div>
    </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const tabs = document.querySelectorAll(".custom-tab-nav-item");
    const contents = document.querySelectorAll(".order-content");

    tabs.forEach(tab => {
        tab.addEventListener("click", function (event) {
            event.preventDefault();

            // Xóa class active khỏi tất cả tab
            tabs.forEach(item => item.classList.remove("custom-tab-nav-item--active"));
            this.classList.add("custom-tab-nav-item--active");

            // Ẩn tất cả nội dung
            contents.forEach(content => content.style.display = "none");

            // Hiển thị nội dung tương ứng
            const target = this.getAttribute("data-target");
            document.querySelector(target).style.display = "block";
        });
    });

    // Kích hoạt tab đầu tiên khi tải trang
    document.querySelector(".custom-tab-nav-item--active").click();
});

</script>