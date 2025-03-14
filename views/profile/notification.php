<div class="notification-container" style="overflow-y: auto; height: 598px;">
<h2>Thông báo</h2>
    <div class="notification-list">
        <div class="notification-item unread">
            <p><strong>Khuyến mãi đặc biệt!</strong> Giảm giá 20% cho đơn hàng hôm nay.</p>
            <span class="notification-time">10 phút trước</span>
            <button class="delete-notification">Xóa</button>
        </div>
        <div class="notification-item">
            <p>Đơn hàng #12345 của bạn đã được giao thành công.</p>
            <span class="notification-time">1 giờ trước</span>
            <button class="delete-notification">Xóa</button>
        </div>
        <div class="notification-item">
            <p>Hệ thống vừa cập nhật chính sách mới, vui lòng kiểm tra.</p>
            <span class="notification-time">Hôm qua</span>
            <button class="delete-notification">Xóa</button>
        </div>
    </div>
    <div class="notification-list">
        <div class="notification-item unread">
            <p><strong>Khuyến mãi đặc biệt!</strong> Giảm giá 20% cho đơn hàng hôm nay.</p>
            <span class="notification-time">10 phút trước</span>
            <button class="delete-notification">Xóa</button>
        </div>
        <div class="notification-item">
            <p>Đơn hàng #12345 của bạn đã được giao thành công.</p>
            <span class="notification-time">1 giờ trước</span>
            <button class="delete-notification">Xóa</button>
        </div>
        <div class="notification-item">
            <p>Hệ thống vừa cập nhật chính sách mới, vui lòng kiểm tra.</p>
            <span class="notification-time">Hôm qua</span>
            <button class="delete-notification">Xóa</button>
        </div>
    </div>
    <div class="notification-list">
        <div class="notification-item unread">
            <p><strong>Khuyến mãi đặc biệt!</strong> Giảm giá 20% cho đơn hàng hôm nay.</p>
            <span class="notification-time">10 phút trước</span>
            <button class="delete-notification">Xóa</button>
        </div>
        <div class="notification-item">
            <p>Đơn hàng #12345 của bạn đã được giao thành công.</p>
            <span class="notification-time">1 giờ trước</span>
            <button class="delete-notification">Xóa</button>
        </div>
        <div class="notification-item">
            <p>Hệ thống vừa cập nhật chính sách mới, vui lòng kiểm tra.</p>
            <span class="notification-time">Hôm qua</span>
            <button class="delete-notification">Xóa</button>
        </div>
    </div>
    <div class="notification-list">
        <div class="notification-item unread">
            <p><strong>Khuyến mãi đặc biệt!</strong> Giảm giá 20% cho đơn hàng hôm nay.</p>
            <span class="notification-time">10 phút trước</span>
            <button class="delete-notification">Xóa</button>
        </div>
        <div class="notification-item">
            <p>Đơn hàng #12345 của bạn đã được giao thành công.</p>
            <span class="notification-time">1 giờ trước</span>
            <button class="delete-notification">Xóa</button>
        </div>
        <div class="notification-item">
            <p>Hệ thống vừa cập nhật chính sách mới, vui lòng kiểm tra.</p>
            <span class="notification-time">Hôm qua</span>
            <button class="delete-notification">Xóa</button>
        </div>
    </div>
    <div class="notification-list">
        <div class="notification-item unread">
            <p><strong>Khuyến mãi đặc biệt!</strong> Giảm giá 20% cho đơn hàng hôm nay.</p>
            <span class="notification-time">10 phút trước</span>
            <button class="delete-notification">Xóa</button>
        </div>
        <div class="notification-item">
            <p>Đơn hàng #12345 của bạn đã được giao thành công.</p>
            <span class="notification-time">1 giờ trước</span>
            <button class="delete-notification">Xóa</button>
        </div>
        <div class="notification-item">
            <p>Hệ thống vừa cập nhật chính sách mới, vui lòng kiểm tra.</p>
            <span class="notification-time">Hôm qua</span>
            <button class="delete-notification">Xóa</button>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll(".notification-item").forEach(item => {
        item.addEventListener("click", function() {
            this.classList.remove("unread");
        });
    });
    
    document.querySelectorAll(".delete-notification").forEach(button => {
        button.addEventListener("click", function(event) {
            event.stopPropagation(); // Ngăn chặn sự kiện click vào thông báo
            this.closest(".notification-item").remove();
        });
    });
</script>