-- Database Update: Menambahkan field foto untuk absensi dosen
-- File: database_update_lecturer_photo.sql
-- Tanggal: 2024

USE attendance_management;

-- 1. Tambahkan field lecture_photo ke tabel attendance
ALTER TABLE attendance 
ADD COLUMN lecture_photo VARCHAR(255) NULL COMMENT 'Path file foto kegiatan mengajar' AFTER lecture_notes;

-- 2. Tambahkan field photo_filename untuk nama file asli
ALTER TABLE attendance 
ADD COLUMN photo_filename VARCHAR(255) NULL COMMENT 'Nama file foto asli' AFTER lecture_photo;

-- 3. Tambahkan field photo_timestamp untuk timestamp pengambilan foto
ALTER TABLE attendance 
ADD COLUMN photo_timestamp TIMESTAMP NULL COMMENT 'Timestamp pengambilan foto' AFTER photo_filename;

-- 4. Update struktur tabel untuk memastikan kompatibilitas
ALTER TABLE attendance 
MODIFY COLUMN lecture_notes TEXT NULL COMMENT 'Catatan tambahan (opsional)',
MODIFY COLUMN subject VARCHAR(100) NULL COMMENT 'Nama mata kuliah',
MODIFY COLUMN class_name VARCHAR(50) NULL COMMENT 'Nama kelas';

-- 5. Buat index untuk optimasi query foto
CREATE INDEX idx_lecture_photo ON attendance(lecture_photo);
CREATE INDEX idx_photo_timestamp ON attendance(photo_timestamp);

-- 6. Tambahkan komentar untuk field yang sudah ada
ALTER TABLE attendance 
MODIFY COLUMN id INT AUTO_INCREMENT COMMENT 'Primary key',
MODIFY COLUMN user_id INT NOT NULL COMMENT 'Foreign key ke users.id',
MODIFY COLUMN qr_code_id INT NOT NULL COMMENT 'Foreign key ke qr_codes.id',
MODIFY COLUMN check_in DATETIME NULL COMMENT 'Waktu check-in/absensi masuk',
MODIFY COLUMN check_out DATETIME NULL COMMENT 'Waktu check-out/absensi pulang',
MODIFY COLUMN work_hours DECIMAL(4,2) DEFAULT 0.00 COMMENT 'Total jam kerja',
MODIFY COLUMN status ENUM('present', 'late', 'absent', 'half_day') DEFAULT 'present' COMMENT 'Status kehadiran',
MODIFY COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Waktu pembuatan record',
MODIFY COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Waktu update terakhir';

-- 7. Verifikasi struktur tabel
DESCRIBE attendance;

-- 8. Tampilkan sample data (jika ada)
SELECT id, user_id, subject, class_name, lecture_notes, lecture_photo, photo_filename, photo_timestamp, created_at 
FROM attendance 
WHERE subject IS NOT NULL 
LIMIT 5;
