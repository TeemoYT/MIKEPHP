<div class="profile-container">
    <div class="profile-layout">
        <div class="profile-sidebar">
            <div class="profile-sidebar-user">
                <a class="profile-sidebar--thumb" href="#">
                    <div class="profile-avatar">
                        <img class="profile-avatar-img" src="/MIKEPHP/img/149071.png" width="50" height="50" alt="">
                    </div>
                    <div class="profile-sidebar-info" style="margin-top: 18px;">
                        <div><a class="profile-sidebar-info-btn" href="#">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                Chỉnh sửa hồ sơ
                            </a></div>
                    </div>
                </a>
            </div>
            <div class="profile-sidebar-menu">
                <div class="stardust-dropdown">
                    <div class="stardust-dropdown-item">
                        <a class="profile-sidebar--menu-item" href="/profile">
                            <div>
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span class="profile-sidebar-menu-item-text">Tài khoản của tôi</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="stardust-dropdown">
                    <div class="stardust-dropdown-item">
                        <a class="profile-sidebar--menu-item" href="#">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                            <span>Đơn mua</span>
                        </a>
                    </div>
                </div>
                <div class="stardust-dropdown">
                    <div class="stardust-dropdown-item">
                        <a class="profile-sidebar--menu-item" href="#">
                            <i class="fa fa-bell" aria-hidden="true"></i>
                            <span>Thông báo</span>
                        </a>
                    </div>
                </div>
                <div class="stardust-dropdown">
                    <div class="stardust-dropdown-item">
                        <a class="profile-sidebar--menu-item" href="#">
                            <i class="fa fa-star-o" aria-hidden="true"></i>
                            <span>Sản phẩm yếu thích</span>
                        </a>
                    </div>
                </div>
                <div class="stardust-dropdown">
                    <div class="stardust-dropdown-item">
                        <a class="profile-sidebar--menu-item" href="#" id="logout-button">
                            <i class="fa fa-power-off" aria-hidden="true"></i>
                            <span>Đăng xuất</span>
                        </a>
                    </div>
                </div>
                <div id="logout-confirm" class="logout-modal">
                    <div class="logout-modal-content">
                        <p>Bạn có chắc chắn muốn đăng xuất không?</p>
                        <button id="confirm-logout">Đồng ý</button>
                        <button id="cancel-logout">Hủy</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="profile-main">
        <?php require_once __DIR__ . '/profile/logout.php' ?>

    </div>
</div>

<script>
    document.getElementById("togglePassword").addEventListener("click", function() {
        let passwordInput = document.getElementById("password");
        let eyeIcon = this.querySelector(".eye-icon");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.textContent = "👁️‍🗨️"; // Icon mắt mở
        } else {
            passwordInput.type = "password";
            eyeIcon.textContent = "👁️"; // Icon mắt đóng
        }
    });
    document.getElementById("logout-button").addEventListener("click" , function(event){
        event.preventDefault();
        document.getElementById("logout-comfirm").style.display="flex";
    });
    document.getElementById("comfirm-logout").addEventListener("click", function(){
        window.location.href = "/logout.php";
    });
    document.getElementById("cancel-logout").addEventListener("click" , function(){
        document.getElementById("logout-comfirm").style.display = "none";
    });
</script>