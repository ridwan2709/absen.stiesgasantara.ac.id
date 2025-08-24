-- Script untuk menambahkan field is_default_password ke tabel users
-- Field ini akan digunakan untuk tracking apakah user masih menggunakan password default

ALTER TABLE users 
ADD COLUMN is_default_password TINYINT(1) DEFAULT 1 AFTER is_active;

-- Update semua user yang sudah ada (set is_default_password = 0)
UPDATE users SET is_default_password = 0 WHERE id > 0;

-- Update user dengan password default (001) yang baru dibuat
UPDATE users SET is_default_password = 1 WHERE password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
