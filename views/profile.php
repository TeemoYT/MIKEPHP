<div class="profile-container">
    <div class="profile-layout">
        <div class="profile-sidebar">
            <div class="profile-sidebar-user">
                <a class="profile-sidebar--thumb" href="#">
                    <div class="profile-avatar">
                        <img class="profile-avatar-img" src="/MIKEPHP/img/149071.png" width="50" height="50" alt="">
                    </div>
                    <div class="profile-sidebar-info" style="margin-top: 18px;">
                        <div><a class="profile-sidebar-info-btn" href="#" >
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
                    <div class="stardust-dropdown-item-body">
                        <div class="profile-sidebar--submenu">
                            <a class="profile-sidebar--submenu-item " href="">
                                <span class="profile-sidebar-submenu-item-text">
                                    Hồ sơ
                                </span>
                            </a>
                            <a class="profile-sidebar--submenu-item " id="password" href="">
                                <span class="profile-sidebar-submenu-item-text">
                                    Đổi mật khẩu
                                </span>
                            </a>
                        </div>
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
                            <i class="fa fa-ticket" aria-hidden="true"></i>
                            <span>Kho voucher</span>
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
                        <a class="profile-sidebar--menu-item" href="#">
                            <i class="fa fa-power-off" aria-hidden="true"></i>
                            <span>Đăng xuất</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


<div class="profile-main">
    <div class="profile-main_acount">
        <div class="profile-main__account-inner">
            <h2>Hồ Sơ Của Tôi</h2>
            <form method="post">
                <label>Tên Đăng Nhập</label>
                <input type="text" value="">

                <label>Email:</label>
                <input type="email" value="">

                <label>Số Điện Thoại</label>
                <input type="text" name="phone" value="" required>

                <label>Giới Tính</label>
                <select name="gender">
                    <option value="Nam">Nam</option>
                    <option value="Nữ">Nữ</option>
                    <option value="Khác">Khác</option>
                </select>

                <label>Ngày Sinh</label>
                <input type="date" name="dob">

                <h3>Thông tin nhận hàng</h3>
                <label>Tỉnh/Thành Phố</label>
                <input type="text" name="province" value="" required>

                <label>Quận/Huyện</label>
                <input type="text" name="district" value="" required>

                <label>Phường/Xã</label>
                <input type="text" name="ward" value="" required>

                <label>Địa Chỉ</label>
                <input type="text" name="address" value="" required>

                <button type="submit">Lưu Thay Đổi</button>
            </form>

        </div>

    </div>

</div>
</div>