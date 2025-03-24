CREATE DATABASE IF NOT EXISTS mikephp;
USE mikephp;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    role ENUM('user', 'admin', 'manager', 'god') DEFAULT 'user',
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
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    parent_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS trademarks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);
INSERT INTO trademarks (id,name) VALUES (1,'Mike'), (2,'Adisas')
ON DUPLICATE KEY UPDATE
id = VALUES(id),
name = VALUES(name);
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image_url VARCHAR(255),
    trademark_id INT,  
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (trademark_id) REFERENCES trademarks(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS product_categories (
    product_id INT,
    category_id INT,
    PRIMARY KEY (product_id, category_id),
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS product_colors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    color_name VARCHAR(100) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS product_sizes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_color_id INT,
    size VARCHAR(10) NOT NULL,
    stock INT DEFAULT 0,
    FOREIGN KEY (product_color_id) REFERENCES product_colors(id) ON DELETE CASCADE
);
ALTER TABLE product_sizes ADD COLUMN disabled BOOLEAN DEFAULT FALSE;

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
    product_color_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_color_id) REFERENCES product_colors(id) ON DELETE CASCADE,
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
    size VARCHAR(50) NOT NULL,
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
INSERT INTO categories (id, name, slug, description, parent_id) VALUES
(1, 'Giá ưu đãi', 'gia-uu-dai', 'Sản phẩm giá ưu đãi', NULL),  
(2, '50k-100k', '50k-100k', 'Sản phẩm giá từ 50k đến 100k', 1),  
(3, '500k', '500k', 'Sản phẩm giá 500k', 1),  
(4, 'Giày cao gót bít mũi', 'giay-cao-got-bit-mui', 'Loại giày cao gót bít mũi', 2),  
(5, 'Cao gót sandal', 'cao-got-sandal', 'Loại giày cao gót sandal', 2);

ALTER TABLE products ADD COLUMN IF NOT EXISTS slug VARCHAR(255) UNIQUE;
ALTER TABLE products ADD COLUMN IF NOT EXISTS image_json TEXT;

-- Cập nhật thông tin người dùng
INSERT INTO users (id, name, email, password, phone, role) VALUES 
(1, 'Nguyễn Văn A', 'admin@gmail.com', '$2y$10$VLkuyzJj9wigZls63PlcN.0PA6Niq5l41ur.twBRcV5jXo6ZcXKeS', '0123456789', 'admin'),
(2, 'Trần Thị B', 'user@gmail.com', '$2y$10$VLkuyzJj9wigZls63PlcN.0PA6Niq5l41ur.twBRcV5jXo6ZcXKeS', '0987654321', 'user')
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

-- Cập nhật mã giảm giá
INSERT INTO discount_codes (id, code, discount_percentage, expiry_date, is_active) VALUES
(1, 'SUMMER10', 10.00, '2025-12-31', TRUE),
(2, 'BLACKFRIDAY', 20.00, '2025-11-30', TRUE)
ON DUPLICATE KEY UPDATE 
code = VALUES(code), 
discount_percentage = VALUES(discount_percentage), 
expiry_date = VALUES(expiry_date), 
is_active = VALUES(is_active);

INSERT INTO login_history (id, user_id, login_time, ip_address) VALUES
(1, 1, NOW(), '192.168.1.1'),
(2, 2, NOW(), '192.168.1.2')
ON DUPLICATE KEY UPDATE 
user_id = VALUES(user_id), 
login_time = VALUES(login_time), 
ip_address = VALUES(ip_address);




