-- Create database (run this first)
CREATE DATABASE IF NOT EXISTS proma_africa;
USE proma_africa;

-- Create properties table
CREATE TABLE IF NOT EXISTS properties (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(15,2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    bedrooms INT DEFAULT 0,
    bathrooms INT DEFAULT 0,
    area DECIMAL(10,2) DEFAULT 0,
    property_type ENUM('house', 'apartment', 'land', 'commercial') DEFAULT 'house',
    status ENUM('available', 'sold', 'pending') DEFAULT 'available',
    featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create admin users table
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin user (password: admin123)
INSERT IGNORE INTO admin_users (username, password, email) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@promaafrica.com');

-- Insert sample properties (optional)
INSERT IGNORE INTO properties (title, description, price, image, location, bedrooms, bathrooms, area, property_type, status, featured) VALUES
('3-Bedroom House in Makongo Juu', 'Beautiful modern house with spacious rooms, modern kitchen, and secure compound. Perfect for families looking for comfort and security.', 150000000, 'placeholder.jpg', 'Makongo Juu, Kinondoni', 3, 2, 250.5, 'house', 'available', 1),
('2-Bedroom Apartment in Masaki', 'Luxury apartment with ocean view, modern amenities, and 24/7 security. Located in the heart of Masaki diplomatic area.', 85000000, 'placeholder.jpg', 'Masaki, Kinondoni', 2, 2, 120.0, 'apartment', 'available', 1),
('Commercial Plot in Mbezi Beach', 'Prime commercial land suitable for shopping mall, office complex, or mixed-use development. Strategic location with high traffic.', 200000000, 'placeholder.jpg', 'Mbezi Beach, Kinondoni', 0, 0, 1000.0, 'land', 'available', 0);
-- Insert default admin user
INSERT IGNORE INTO admin_users (username, password, email) 
VALUES ('Baraka', '$2y$10$nGqnQlhm5.BQhZ5fnhEL9eBPRbzcvyya.4biuLf7GdvA7w4rPvHiy', 'info@promaafrica.com');