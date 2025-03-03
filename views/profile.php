<?php
session_start();

// Giả lập dữ liệu người dùng (thay bằng truy vấn DB thực tế)
$user = [
    "name" => "Nguyễn Văn A",
    "email" => "nguyenvana@example.com",
    "phone" => "0123456789",
    "address" => "123 Đường ABC, TP.HCM"
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Cập nhật thông tin người dùng từ form
    $user["name"] = $_POST["name"];
    $user["email"] = $_POST["email"];
    $user["phone"] = $_POST["phone"];
    $user["address"] = $_POST["address"];
    // Thực tế sẽ lưu vào DB ở đây
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ sơ cá nhân</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="profile-container">
        <h2>Hồ sơ cá nhân</h2>
        <img src="avatar.png" alt="Avatar" class="avatar">
        <form method="POST">
            <label>Họ tên:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            
            <label>Số điện thoại:</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            
            <label>Địa chỉ:</label>
            <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
            
            <button type="submit">Lưu</button>
        </form>
    </div>
</body>
</html>
