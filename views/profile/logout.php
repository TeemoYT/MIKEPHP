<div class="logout-container">

<div id="logout-confirm" class="logout-modal">
    <div class="logout-modal-content">
        <p>Bạn có chắc chắn muốn đăng xuất không?</p>
        <button id="confirm-logout">Đồng ý</button>
        <button id="cancel-logout">Hủy</button>
    </div>
</div>

<script>
    document.getElementById("logout-button").addEventListener("click", function() {
        document.getElementById("logout-confirm").style.display = "flex";
    });
    
    document.getElementById("confirm-logout").addEventListener("click", function() {
        window.location.href = "/logout.php"; // Điều hướng đến trang xử lý đăng xuất
    });
    
    document.getElementById("cancel-logout").addEventListener("click", function() {
        document.getElementById("logout-confirm").style.display = "none";
    });
</script>