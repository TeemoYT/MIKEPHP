<div class="favorite-products-container" style="overflow-y: auto;">
    <h2>Sản phẩm yêu thích</h2>
    <div class="favorite-products-list">
        <div class="favorite-product-item">
            <img src="/MIKEPHP/img/149071.png" alt="Sản phẩm 1">
            <div class="product-info">
                <h3>Tên sản phẩm 1</h3>
                <p>Giá: 500.000đ</p>
                <button class="remove-favorite">Xóa khỏi danh sách</button>
            </div>
        </div>
        <div class="favorite-product-item">
            <img src="/MIKEPHP/img/149071.png" alt="Sản phẩm 2">
            <div class="product-info">
                <h3>Tên sản phẩm 2</h3>
                <p>Giá: 700.000đ</p>
                <button class="remove-favorite">Xóa khỏi danh sách</button>
            </div>
        </div>
        <div class="favorite-product-item">
            <img src="/MIKEPHP/img/149071.png" alt="Sản phẩm 2">
            <div class="product-info">
                <h3>Tên sản phẩm 2</h3>
                <p>Giá: 700.000đ</p>
                <button class="remove-favorite">Xóa khỏi danh sách</button>
            </div>
        </div>
        <div class="favorite-product-item">
            <img src="/MIKEPHP/img/149071.png" alt="Sản phẩm 2">
            <div class="product-info">
                <h3>Tên sản phẩm 2</h3>
                <p>Giá: 700.000đ</p>
                <button class="remove-favorite">Xóa khỏi danh sách</button>
            </div>
        </div>
        <div class="favorite-product-item">
            <img src="/MIKEPHP/img/149071.png" alt="Sản phẩm 2">
            <div class="product-info">
                <h3>Tên sản phẩm 2</h3>
                <p>Giá: 700.000đ</p>
                <button class="remove-favorite">Xóa khỏi danh sách</button>
            </div>
        </div>
        <div class="favorite-product-item">
            <img src="/MIKEPHP/img/149071.png" alt="Sản phẩm 2">
            <div class="product-info">
                <h3>Tên sản phẩm 2</h3>
                <p>Giá: 700.000đ</p>
                <button class="remove-favorite">Xóa khỏi danh sách</button>
            </div>
        </div>
        <!-- Có thể thêm nhiều sản phẩm khác -->
    </div>
</div>

<script>
    document.querySelectorAll(".remove-favorite").forEach(button => {
        button.addEventListener("click", function() {
            this.closest(".favorite-product-item").remove();
        });
    });
</script>