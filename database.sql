-- Database Schema for The Organic Breath (Bank Sampah)
-- Version 1.1 (Hierarchy Support)

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    whatsapp VARCHAR(20) UNIQUE,
    email VARCHAR(100) NULL,
    password VARCHAR(255) NULL,
    role ENUM('USER', 'ADMIN') DEFAULT 'USER',
    balance DECIMAL(15, 2) DEFAULT 0.00,
    total_kg DECIMAL(10, 2) DEFAULT 0.00,
    tier ENUM('Bronze', 'Silver', 'Gold') DEFAULT 'Bronze',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS waste_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    price_per_kg DECIMAL(10, 2) NOT NULL,
    icon VARCHAR(50) DEFAULT 'recycling',
    image_url TEXT,
    is_popular BOOLEAN DEFAULT FALSE,
    parent_id INT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES waste_categories(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    category_id INT NOT NULL,
    weight_est DECIMAL(10, 2) NOT NULL,
    weight_actual DECIMAL(10, 2),
    total_payout DECIMAL(15, 2),
    status ENUM('PENDING', 'VERIFIED', 'REJECTED') DEFAULT 'PENDING',
    type ENUM('PICKUP', 'DROPOFF') DEFAULT 'DROPOFF',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES waste_categories(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    type ENUM('PICKUP', 'CONSULT', 'TRAINING', 'COMPOST') DEFAULT 'PICKUP',
    image_url TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    subtitle VARCHAR(255),
    content TEXT NOT NULL,
    category ENUM('AGENDA', 'EDUKASI', 'KARIR') NOT NULL,
    image_url TEXT,
    event_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed Initial Categories (Hierarchy Example)
-- Categories (parent_id is NULL)
INSERT INTO waste_categories (id, name, slug, description, price_per_kg, icon, is_popular, parent_id) VALUES
(1, 'Plastik', 'plastik', 'Berbagai jenis sampah berbahan dasar plastik.', 0, 'local_drink', TRUE, NULL),
(2, 'Kertas', 'kertas', 'Sampah kertas, kardus, dan sejenisnya.', 0, 'description', TRUE, NULL),
(3, 'Logam', 'logam', 'Sampah besi, aluminium, dan logam lainnya.', 0, 'hardware', TRUE, NULL);

-- Products (Item Unit, parent_id links to parent)
INSERT INTO waste_categories (name, slug, description, price_per_kg, icon, is_popular, parent_id) VALUES
('Botol PET Bening', 'botol-pet', 'Botol plastik transparan bekas minuman.', 4500, 'local_drink', TRUE, 1),
('Gelas Plastik Bersih', 'gelas-plastik', 'Gelas mineral bersih tanpa tutup.', 3500, 'coffee', FALSE, 1),
('Kardus Bekas', 'kardus-bekas', 'Kardus coklat bersih dan kering.', 2800, 'inventory_2', TRUE, 2),
('HVS/A4 Putih', 'kertas-hvs', 'Kertas putih kantor bersih.', 3200, 'description', FALSE, 2),
('Aluminium Can', 'aluminium-can', 'Kaleng minuman ringan aluminium.', 12000, 'can', TRUE, 3),
('Besi Tebal', 'besi-tebal', 'Potongan besi konstruksi atau plat tebal.', 6500, 'hardware', FALSE, 3);
