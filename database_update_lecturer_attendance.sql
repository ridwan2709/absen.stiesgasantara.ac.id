-- Update untuk menambah fitur absensi per kelas untuk dosen
-- Jalankan query ini untuk menambah field baru ke tabel attendance

ALTER TABLE attendance 
ADD COLUMN subject VARCHAR(100) AFTER notes,
ADD COLUMN class_name VARCHAR(50) AFTER subject,
ADD COLUMN lecture_notes TEXT AFTER class_name;

-- Update index untuk performa yang lebih baik
CREATE INDEX idx_user_date ON attendance (user_id, DATE(created_at));
CREATE INDEX idx_subject_class ON attendance (subject, class_name);
