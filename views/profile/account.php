<div class="profile-main_acount">
            <div class="profile-main__account-inner">
                <h2>Hồ Sơ Của Tôi</h2>
                <form method="post">
                    <label>Tên Đăng Nhập</label>
                    <input type="text" value="">

                    <label>Email:</label>
                    <input type="email" value="">

                    <label for="password">Mật Khẩu</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" required>
                        <button type="button" id="togglePassword">
                            <i class="eye-icon">👁️</i>
                        </button>
                    </div>

                    <label for="phone">Số Điện Thoại</label>
                    <input type="text" id="phone" name="phone" required
                        pattern="[0-9]{10,11}"
                        inputmode="numeric"
                        title="Số điện thoại chỉ được chứa 10-11 chữ số"
                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">

                    <div class="gender-container">
                        <label class="gender-label">Giới Tính</label>
                        <div class="gender-group">
                            <label for="male">
                                <input type="radio" id="male" name="gender" value="Nam" required>
                                Nam
                            </label>
                            <label for="female">
                                <input type="radio" id="female" name="gender" value="Nữ">
                                Nữ
                            </label>
                            <label for="other">
                                <input type="radio" id="other" name="gender" value="Khác">
                                Khác
                            </label>
                        </div>
                    </div>

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