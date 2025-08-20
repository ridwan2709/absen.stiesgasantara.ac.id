-- Database: attendance_management
-- Aplikasi Manajemen Absensi menggunakan CodeIgniter 3

-- Buat database
CREATE DATABASE IF NOT EXISTS attendance_management;
USE attendance_management;

-- Tabel users (pengguna)
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    role ENUM('admin', 'staff', 'dosen') NOT NULL DEFAULT 'staff',
    nip_nidn VARCHAR(20),
    department VARCHAR(100),
    phone VARCHAR(20),
    address TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel qr_codes
CREATE TABLE qr_codes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(255) UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    location VARCHAR(200),
    is_active BOOLEAN DEFAULT TRUE,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Tabel attendance (absensi)
CREATE TABLE attendance (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    qr_code_id INT NOT NULL,
    check_in DATETIME,
    check_out DATETIME,
    work_hours DECIMAL(4,2) DEFAULT 0.00,
    status ENUM('present', 'late', 'absent', 'half_day') DEFAULT 'present',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (qr_code_id) REFERENCES qr_codes(id) ON DELETE CASCADE
);

-- Tabel settings (pengaturan sistem)
CREATE TABLE settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert data awal
-- Admin default (password: admin123)
INSERT INTO users (username, password, email, full_name, role, nip_nidn, department) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@example.com', 'Administrator', 'admin', 'ADM001', 'IT Department');

-- QR Code default
INSERT INTO qr_codes (code, name, description, location, created_by) VALUES
('DEFAULT_QR_CODE_2024', 'QR Code Utama', 'QR Code untuk absensi harian', 'Gedung Utama Lantai 1', 1);

-- Pengaturan default
INSERT INTO settings (setting_key, setting_value, description) VALUES
('work_start_time', '08:00:00', 'Waktu mulai kerja'),
('work_end_time', '17:00:00', 'Waktu selesai kerja'),
('late_threshold', '15', 'Toleransi keterlambatan dalam menit'),
('qr_code_expiry', '24', 'Masa berlaku QR Code dalam jam');
