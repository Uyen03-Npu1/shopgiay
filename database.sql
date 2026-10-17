CREATE DATABASE IF NOT EXISTS quan_ly_ban_giay CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE quan_ly_ban_giay;

DROP TABLE IF EXISTS order_details;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('customer','admin') NOT NULL DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(180) NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    image_url TEXT NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(12,2) NOT NULL,
    address TEXT NOT NULL,
    phone VARCHAR(30) NOT NULL,
    status ENUM('pending','confirmed','shipping','completed','cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE order_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

INSERT INTO users(name,email,password,role) VALUES
('Quản trị viên','admin@shoestore.local','$2y$12$AmwOWWITnKRSdv.l60IW3OH6EyaRl.6sSjjeoa7Z1gesFTSoBg2Pu','admin');

INSERT INTO categories(name) VALUES
('Sneaker'),('Running'),('Thể thao'),('Thời trang');

INSERT INTO products(category_id,name,price,stock,image_url,description) VALUES
(1,'Red Street Sneaker',1290000,20,'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=85','Sneaker phong cách đường phố, phù hợp đi học và đi chơi.'),
(1,'Classic White Sneaker',1490000,18,'https://images.unsplash.com/photo-1552346154-21d32810aba3?auto=format&fit=crop&w=900&q=85','Thiết kế trắng tối giản, dễ phối đồ.'),
(2,'Daily Running Pro',1790000,15,'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?auto=format&fit=crop&w=900&q=85','Giày chạy bộ nhẹ, phù hợp luyện tập hằng ngày.'),
(3,'Sport Trainer',1590000,16,'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?auto=format&fit=crop&w=900&q=85','Giày thể thao năng động cho nhiều hoạt động.'),
(4,'Urban Black Shoes',1890000,12,'https://images.unsplash.com/photo-1549298916-b41d501d3772?auto=format&fit=crop&w=900&q=85','Mẫu giày màu đen hiện đại, dễ phối trang phục.'),
(1,'Light Sneaker',1190000,22,'https://images.unsplash.com/photo-1495555961986-6d4c1ecb7be3?auto=format&fit=crop&w=900&q=85','Kiểu dáng nhẹ và trẻ trung.');

-- Tài khoản admin mặc định:
-- Email: admin@shoestore.local
-- Mật khẩu: 123456
