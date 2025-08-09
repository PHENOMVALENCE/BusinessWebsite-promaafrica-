-- Create database
CREATE DATABASE IF NOT EXISTS property_cms;
USE property_cms;

-- Properties table
CREATE TABLE IF NOT EXISTS properties (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    property_type ENUM('house', 'apartment', 'land', 'commercial') NOT NULL,
    location VARCHAR(255) NOT NULL,
    price DECIMAL(15,2) NOT NULL,
    bedrooms INT DEFAULT 0,
    bathrooms INT DEFAULT 0,
    area DECIMAL(10,2) DEFAULT 0,
    images JSON,
    featured BOOLEAN DEFAULT FALSE,
    status ENUM('available', 'sold', 'pending') DEFAULT 'available',
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Settings table
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Admin users table
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    role ENUM('admin', 'editor') DEFAULT 'editor',
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Inquiries table
CREATE TABLE IF NOT EXISTS inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    property_id INT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    message TEXT NOT NULL,
    status ENUM('new', 'read', 'replied') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE SET NULL
);

-- Page visits tracking table
CREATE TABLE IF NOT EXISTS page_visits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_name VARCHAR(100) NOT NULL,
    visit_data JSON,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin user (password: admin123)
INSERT INTO admin_users (username, email, password, full_name, role) VALUES 
('admin', 'admin@promaafrica.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'System Administrator', 'admin');

-- Insert default settings
INSERT INTO settings (setting_key, setting_value) VALUES 
('contact_phone', '+255756069451'),
('contact_email', 'info@promaafrica.com'),
('whatsapp_number', '255756069451'),
('company_address', 'Dar es Salaam, Tanzania'),
('site_title', 'Proma Africa - Property Sales'),
('site_description', 'Premium properties for sale in Tanzania');

-- Insert sample properties
INSERT INTO properties (title, description, property_type, location, price, bedrooms, bathrooms, area, featured, images) VALUES 
('Modern 3BR House in Mikocheni', 'Beautiful modern house with spacious rooms and modern amenities. Perfect for families looking for comfort and style.', 'house', 'Dar es Salaam', 450000000, 3, 2, 250, TRUE, '["sample-house-1.jpg", "sample-house-2.jpg"]'),
('Luxury Apartment in Stone Town', 'Stunning apartment in the heart of Stone Town with ocean views and traditional architecture.', 'apartment', 'Zanzibar', 280000000, 2, 2, 120, FALSE, '["sample-apartment-1.jpg"]'),
('Commercial Plot in Arusha', 'Prime commercial land in the business district of Arusha. Perfect for development projects.', 'land', 'Arusha', 150000000, 0, 0, 1000, TRUE, '["sample-land-1.jpg"]'),
('Beachfront Villa in Kendwa', 'Exclusive beachfront villa with private beach access and luxury amenities.', 'house', 'Zanzibar', 850000000, 4, 3, 350, TRUE, '["sample-villa-1.jpg", "sample-villa-2.jpg", "sample-villa-3.jpg"]');
