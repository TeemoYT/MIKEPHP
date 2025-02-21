CREATE DATABASE IF NOT EXISTS mikephp;
USE mikephp;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    role ENUM('user', 'admin','manager','','god') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS addresses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    address TEXT NOT NULL,
    city VARCHAR(100) NOT NULL,
    country VARCHAR(100) NOT NULL DEFAULT 'Vietnam',
    is_default BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image_url VARCHAR(255),
    category_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    size VARCHAR(50) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS order_status (
    id INT AUTO_INCREMENT PRIMARY KEY,
    status_name VARCHAR(50) NOT NULL UNIQUE
);

INSERT IGNORE INTO order_status (id, status_name) VALUES 
(1, 'pending'), (2, 'processing'), (3, 'shipped'), (4, 'delivered'), (5, 'canceled');

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    address_id INT,
    total DECIMAL(10,2) NOT NULL,
    status_id INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (address_id) REFERENCES addresses(id) ON DELETE SET NULL,
    FOREIGN KEY (status_id) REFERENCES order_status(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    size VARCHAR(50) NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    payment_method ENUM('credit_card', 'paypal', 'cod') NOT NULL,
    payment_status ENUM('pending', 'completed', 'failed', 'refunded') DEFAULT 'pending',
    transaction_id VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    size VARCHAR(50) NOT NULL, -- Thêm cột size
    quantity INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS discount_codes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) UNIQUE NOT NULL,
    discount_percentage DECIMAL(5,2) NOT NULL,
    expiry_date DATE NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS order_discounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    discount_code_id INT,
    discount_amount DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (discount_code_id) REFERENCES discount_codes(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS wishlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS login_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    login_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(45),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
-- Cập nhật dữ liệu bảng categories nếu đã tồn tại
INSERT INTO categories (id, name, description) VALUES 
(1, 'Sneakers', 'Giày thể thao'), 
(2, 'Boots', 'Giày bốt'), 
(3, 'Sandals', 'Dép và sandal')
ON DUPLICATE KEY UPDATE name = VALUES(name), description = VALUES(description);

-- Cập nhật dữ liệu bảng products
INSERT INTO products (id, name, description, price, category_id, image_url) VALUES 
(1, 'Nike Air Force 1', 'Giày sneaker kinh điển', 120.00, 1, 'nike_af1.jpg'),
(2, 'Adidas Ultraboost', 'Giày chạy bộ thoải mái', 150.00, 1, 'adidas_ultraboost.jpg')
ON DUPLICATE KEY UPDATE 
name = VALUES(name), 
description = VALUES(description), 
price = VALUES(price), 
category_id = VALUES(category_id), 
image_url = VALUES(image_url);

-- Cập nhật thông tin người dùng
INSERT INTO users (id, name, email, password, phone, role) VALUES 
(1, 'Nguyễn Văn A', 'nguyenvana@example.com', 'hashedpassword1', '0123456789', 'customer'),
(2, 'Trần Thị B', 'tranthib@example.com', 'hashedpassword2', '0987654321', 'admin')
ON DUPLICATE KEY UPDATE 
name = VALUES(name), 
email = VALUES(email), 
password = VALUES(password), 
phone = VALUES(phone), 
role = VALUES(role);

-- Cập nhật địa chỉ người dùng
INSERT INTO addresses (id, user_id, full_name, phone, address, city, country, is_default) VALUES
(1, 1, 'Nguyễn Văn A', '0123456789', '123 Đường ABC, Phường X, Quận Y', 'Hà Nội', 'Vietnam', TRUE),
(2, 2, 'Trần Thị B', '0987654321', '456 Đường DEF, Phường M, Quận N', 'TP. Hồ Chí Minh', 'Vietnam', TRUE)
ON DUPLICATE KEY UPDATE 
full_name = VALUES(full_name), 
phone = VALUES(phone), 
address = VALUES(address), 
city = VALUES(city), 
country = VALUES(country), 
is_default = VALUES(is_default);

-- Cập nhật đơn hàng
INSERT INTO orders (id, user_id, address_id, total, status_id) VALUES
(1, 1, 1, 270.00, 2),
(2, 2, 2, 150.00, 1) 
ON DUPLICATE KEY UPDATE 
user_id = VALUES(user_id), 
address_id = VALUES(address_id), 
total = VALUES(total), 
status_id = VALUES(status_id);

-- Cập nhật chi tiết đơn hàng
INSERT INTO order_items (id, order_id, product_id, quantity, price) VALUES
(1, 1, 1, 1, 120.00),
(2, 1, 2, 1, 150.00),
(3, 2, 2, 1, 150.00)
ON DUPLICATE KEY UPDATE 
order_id = VALUES(order_id), 
product_id = VALUES(product_id), 
quantity = VALUES(quantity), 
price = VALUES(price);

-- Cập nhật thông tin thanh toán
INSERT INTO payments (id, order_id, payment_method, payment_status, transaction_id) VALUES
(1, 1, 'credit_card', 'completed', 'TXN123456'),
(2, 2, 'paypal', 'pending', 'TXN987654')
ON DUPLICATE KEY UPDATE 
order_id = VALUES(order_id), 
payment_method = VALUES(payment_method), 
payment_status = VALUES(payment_status), 
transaction_id = VALUES(transaction_id);

-- Cập nhật đánh giá sản phẩm
INSERT INTO reviews (id, user_id, product_id, rating, comment) VALUES
(1, 1, 1, 5, 'Giày cực kỳ êm chân!'),
(2, 2, 2, 4, 'Thiết kế đẹp, nhưng hơi chật.')
ON DUPLICATE KEY UPDATE 
user_id = VALUES(user_id), 
product_id = VALUES(product_id), 
rating = VALUES(rating), 
comment = VALUES(comment);

-- Cập nhật giỏ hàng
INSERT INTO cart (id, user_id, product_id, quantity, size) VALUES
(1, 1, 2, 1, 'M'), 
(2, 2, 1, 2, 'L')
ON DUPLICATE KEY UPDATE 
user_id = VALUES(user_id), 
product_id = VALUES(product_id), 
quantity = VALUES(quantity), 
size = VALUES(size);

-- Cập nhật mã giảm giá
INSERT INTO discount_codes (id, code, discount_percentage, expiry_date, is_active) VALUES
(1, 'SUMMER10', 10.00, '2025-12-31', TRUE),
(2, 'BLACKFRIDAY', 20.00, '2025-11-30', TRUE)
ON DUPLICATE KEY UPDATE 
code = VALUES(code), 
discount_percentage = VALUES(discount_percentage), 
expiry_date = VALUES(expiry_date), 
is_active = VALUES(is_active);

-- Cập nhật giảm giá cho đơn hàng
INSERT INTO order_discounts (id, order_id, discount_code_id, discount_amount) VALUES
(1, 1, 1, 27.00)
ON DUPLICATE KEY UPDATE 
order_id = VALUES(order_id), 
discount_code_id = VALUES(discount_code_id), 
discount_amount = VALUES(discount_amount);

-- Cập nhật danh sách yêu thích
INSERT INTO wishlist (id, user_id, product_id) VALUES
(1, 1, 2),
(2, 2, 1)
ON DUPLICATE KEY UPDATE 
user_id = VALUES(user_id), 
product_id = VALUES(product_id);

-- Cập nhật lịch sử đăng nhập
INSERT INTO login_history (id, user_id, login_time, ip_address) VALUES
(1, 1, NOW(), '192.168.1.1'),
(2, 2, NOW(), '192.168.1.2')
ON DUPLICATE KEY UPDATE 
user_id = VALUES(user_id), 
login_time = VALUES(login_time), 
ip_address = VALUES(ip_address);
ALTER TABLE products DROP COLUMN IF EXISTS slug;
ALTER TABLE products ADD COLUMN slug VARCHAR(255) UNIQUE;


