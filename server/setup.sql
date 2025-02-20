CREATE DATABASE IF NOT EXISTS mikephp;
USE mikephp;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    role ENUM('customer', 'admin') DEFAULT 'customer',
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
    size VARCHAR(50) NOT NULL, -- Thêm cột size
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
    size VARCHAR(50) NOT NULL, -- Thêm cột size
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

INSERT IGNORE INTO categories (id, name, description) VALUES 
(1, 'Sneakers', 'Giày thể thao'), 
(2, 'Boots', 'Giày bốt'), 
(3, 'Sandals', 'Dép và sandal');

INSERT IGNORE INTO products (id, name, description, price, size, category_id, image_url) VALUES 
(1, 'Nike Air Force 1', 'Giày sneaker kinh điển', 120.00, '42', 1, 'nike_af1.jpg'),
(2, 'Nike Air Force 1', 'Giày sneaker kinh điển', 120.00, '43', 1, 'nike_af1.jpg'),
(3, 'Adidas Ultraboost', 'Giày chạy bộ thoải mái', 150.00, '41', 1, 'adidas_ultraboost.jpg');

INSERT IGNORE INTO inventory (product_id, size, stock) VALUES
(1, '42', 50),
(2, '43', 30),
(3, '41', 20);

INSERT IGNORE INTO users (id, name, email, password, phone, role) VALUES 
(1, 'Nguyễn Văn A', 'nguyenvana@example.com', 'hashedpassword1', '0123456789', 'customer'),
(2, 'Trần Thị B', 'tranthib@example.com', 'hashedpassword2', '0987654321', 'admin');
-- Thêm dữ liệu mẫu vào bảng addresses
INSERT IGNORE INTO addresses (id, user_id, full_name, phone, address, city, country, is_default) VALUES
(1, 1, 'Nguyễn Văn A', '0123456789', '123 Đường ABC, Phường X, Quận Y', 'Hà Nội', 'Vietnam', TRUE),
(2, 2, 'Trần Thị B', '0987654321', '456 Đường DEF, Phường M, Quận N', 'TP. Hồ Chí Minh', 'Vietnam', TRUE);

-- Thêm dữ liệu mẫu vào bảng orders
INSERT IGNORE INTO orders (id, user_id, address_id, total, status_id) VALUES
(1, 1, 1, 270.00, 2), -- Đơn hàng đang xử lý
(2, 2, 2, 150.00, 1); -- Đơn hàng đang chờ xử lý

-- Thêm dữ liệu mẫu vào bảng order_items
INSERT IGNORE INTO order_items (id, order_id, product_id, quantity, price) VALUES
(1, 1, 1, 1, 120.00),
(2, 1, 2, 1, 150.00),
(3, 2, 2, 1, 150.00);

-- Thêm dữ liệu mẫu vào bảng payments
INSERT IGNORE INTO payments (id, order_id, payment_method, payment_status, transaction_id) VALUES
(1, 1, 'credit_card', 'completed', 'TXN123456'),
(2, 2, 'paypal', 'pending', 'TXN987654');

-- Thêm dữ liệu mẫu vào bảng reviews
INSERT IGNORE INTO reviews (id, user_id, product_id, rating, comment) VALUES
(1, 1, 1, 5, 'Giày cực kỳ êm chân!'),
(2, 2, 2, 4, 'Thiết kế đẹp, nhưng hơi chật.');

INSERT IGNORE INTO cart (id, user_id, product_id, quantity, size) VALUES
(1, 1, 3, 1, 'M'),  -- Người dùng 1 thêm sản phẩm 3 vào giỏ hàng với size M
(2, 2, 1, 2, 'L');  -- Người dùng 2 thêm sản phẩm 1 vào giỏ hàng với size L

-- Thêm dữ liệu mẫu vào bảng discount_codes
INSERT IGNORE INTO discount_codes (id, code, discount_percentage, expiry_date, is_active) VALUES
(1, 'SUMMER10', 10.00, '2025-12-31', TRUE),
(2, 'BLACKFRIDAY', 20.00, '2025-11-30', TRUE);

-- Thêm dữ liệu mẫu vào bảng order_discounts
INSERT IGNORE INTO order_discounts (id, order_id, discount_code_id, discount_amount) VALUES
(1, 1, 1, 27.00);

-- Thêm dữ liệu mẫu vào bảng wishlist
INSERT IGNORE INTO wishlist (id, user_id, product_id) VALUES
(1, 1, 2),
(2, 2, 3);

-- Thêm dữ liệu mẫu vào bảng login_history
INSERT IGNORE INTO login_history (id, user_id, login_time, ip_address) VALUES
(1, 1, NOW(), '192.168.1.1'),
(2, 2, NOW(), '192.168.1.2');


INSERT INTO orders (user_id, address_id, total, status_id) VALUES (1, 1, 120.00, 1);

INSERT INTO order_items (order_id, product_id, size, quantity, price) VALUES
(1, 1, '42', 1, 120.00);