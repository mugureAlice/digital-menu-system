-- Simple Digital Menu & Order Kiosk
-- Database Schema

CREATE DATABASE IF NOT EXISTS menu_kiosk;
USE menu_kiosk;

-- 1. USERS (Admin & Customer roles)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'customer') NOT NULL DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. MENU ITEMS (CRUD: Name, Price, Category, Image)
CREATE TABLE menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    category VARCHAR(80) NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. ORDERS (Table # + status tracking)
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    table_number VARCHAR(10) NOT NULL,
    status ENUM('Pending', 'Prepared', 'Served') NOT NULL DEFAULT 'Pending',
    total DECIMAL(10,2) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 4. ORDER ITEMS (line items per order)
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    menu_item_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    price DECIMAL(10,2) NOT NULL, -- price at time of order
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (menu_item_id) REFERENCES menu_items(id) ON DELETE CASCADE
);

-- Seed an admin account: email admin@kiosk.com / password: admin123
-- (password hash generated with PHP password_hash, see includes/auth.php notes)
INSERT INTO users (name, email, password, role) VALUES
('Admin', 'admin@kiosk.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
-- NOTE: this hash corresponds to "admin123" (bcrypt). Change it after first login.

