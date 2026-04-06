-- database.sql - MotionVault Marketplace Database Schema

-- 1. Create Database
CREATE DATABASE IF NOT EXISTS motionvault_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE motionvault_db;

-- 2. Create Users Table
-- Roles: 'admin', 'creator' (penjual), 'customer' (pembeli)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'creator', 'customer') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 3. Create Assets Table
-- Assets adalah produk digital yang dijual oleh creator
CREATE TABLE IF NOT EXISTS assets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(12, 2) DEFAULT 0.00,
    file_path VARCHAR(255) NOT NULL, -- Path ke file asli (zip/mp4/dsb)
    thumbnail VARCHAR(255),          -- Path ke gambar preview
    preview_video VARCHAR(255),      -- Path ke video preview singkat
    category VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Relasi: Satu asset dimiliki oleh satu creator (user)
    CONSTRAINT fk_asset_user FOREIGN KEY (user_id) 
        REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 4. Create Orders Table
-- Orders mencatat transaksi pembelian asset oleh customer
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,  -- Customer yang membeli
    asset_id INT NOT NULL, -- Asset yang dibeli
    status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    -- Relasi: Pembeli (user)
    CONSTRAINT fk_order_user FOREIGN KEY (user_id) 
        REFERENCES users(id) ON DELETE CASCADE,
        
    -- Relasi: Asset yang dibeli
    CONSTRAINT fk_order_asset FOREIGN KEY (asset_id) 
        REFERENCES assets(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 5. Contoh Data (Opsional)
INSERT INTO users (username, email, password, role) VALUES 
('admin_mv', 'admin@motionvault.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('creator_one', 'creator@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'creator');

INSERT INTO assets (user_id, title, description, price, file_path, category) VALUES 
(2, 'Cinematic Transitions', 'Paket transisi video cinematic kualitas 4K.', 50000.00, 'uploads/assets/transitions.zip', 'Transition');
