-- Script untuk mengisi data dosen dari file data_dosen.txt
-- Password di-hash menggunakan bcrypt (password_hash PHP)
-- Role otomatis diset sebagai 'dosen'
-- Field is_default_password otomatis diset sebagai 1

-- Hapus data dosen yang mungkin sudah ada (optional)
-- DELETE FROM users WHERE role = 'dosen';

-- Insert data dosen
INSERT INTO users (username, password, email, full_name, role, nip_nidn, phone, is_active, is_default_password, created_at, updated_at) VALUES
-- Data dosen dengan NIDN/NIP lengkap
('2103078204', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'drrochmatlc@gmail.com', 'Dr. Rochmat, Lc, MA', 'dosen', '2103078204', NULL, 1, 1, NOW(), NOW()),
('2112068603', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'purwantinaratasatisei@gmail.com', 'Purwanti Naratasati, SEI.,ME', 'dosen', '2112068603', NULL, 1, 1, NOW(), NOW()),
('2123086801', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'idensuhudse@gmail.com', 'Iden Suhud, SE.,MM', 'dosen', '2123086801', NULL, 1, 1, NOW(), NOW()),
('2105038604', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'drcmogiedemsioemarsemecbpaawp@gmail.com', 'Dr (C). Mogie Demsi Oemar, SE. ME. CBPA. AWP. CDMP.', 'dosen', '2105038604', NULL, 1, 1, NOW(), NOW()),
('8161743644230060', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'nanirochaeni@gmail.com', 'Nani Rochaeni, MM', 'dosen', '8161743644230060', NULL, 1, 1, NOW(), NOW()),
('0402056603', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'dadangazse@gmail.com', 'Dadang AZ,SE,MM', 'dosen', '0402056603', NULL, 1, 1, NOW(), NOW()),
('7352764665130343', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'okiidrissafarispd@gmail.com', 'Oki Idris Safari, S.Pd.,MM', 'dosen', '7352764665130343', NULL, 1, 1, NOW(), NOW()),

-- Data dosen dengan kode pendek
('001', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'deninurman@gmail.com', 'Deni Nurman, SE', 'dosen', '001', '08123456789', 1, 1, NOW(), NOW()),
('002', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'helminam@gmail.com', 'Helmina, M.Pd', 'dosen', '002', NULL, 1, 1, NOW(), NOW()),
('003', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'choerulhudamae@gmail.com', 'Choerul Huda, ma.,E.S', 'dosen', '003', NULL, 1, 1, NOW(), NOW()),
('005', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'rifaatulmahmudahm@gmail.com', 'Rifaatul Mahmudah,M.Pd', 'dosen', '005', NULL, 1, 1, NOW(), NOW()),
('006', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'anwarsanusi@gmail.com', 'Anwar Sanusi, SE', 'dosen', '006', NULL, 1, 1, NOW(), NOW()),
('007', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hmuhammadhelmisutiknommmba@gmail.com', 'H. Muhammad Helmi Sutikno, MM.,MBA.,CQM', 'dosen', '007', NULL, 1, 1, NOW(), NOW()),
('008', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'aderidwan@gmail.com', 'Ade Ridwan, MM', 'dosen', '008', NULL, 1, 1, NOW(), NOW()),
('009', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'anjarnugrahast@gmail.com', 'Anjar Nugraha, ST.,MM', 'dosen', '009', NULL, 1, 1, NOW(), NOW()),
('010', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'atinurhayatise@gmail.com', 'Ati Nurhayati, SE,ME', 'dosen', '010', NULL, 1, 1, NOW(), NOW()),
('011', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'zainurrys@gmail.com', 'Zainurry, S.sos', 'dosen', '011', NULL, 1, 1, NOW(), NOW()),
('012', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'adedian@gmail.com', 'Ade Dian, MM', 'dosen', '012', NULL, 1, 1, NOW(), NOW());

-- Verifikasi data yang berhasil diinsert
SELECT 
    username, 
    full_name, 
    role, 
    nip_nidn, 
    email, 
    phone,
    is_active,
    is_default_password,
    created_at
FROM users 
WHERE role = 'dosen' 
ORDER BY username;
