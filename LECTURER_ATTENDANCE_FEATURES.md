# Fitur Absensi Dosen Per Kelas

## Deskripsi
Fitur ini memungkinkan dosen untuk melakukan absensi mengajar per kelas dengan mengisi detail mata kuliah, kelas, dan keterangan setelah melakukan scan QR code.

## Alur Proses

### 1. Scan QR Code
- Dosen melakukan scan QR code seperti biasa
- Sistem mendeteksi bahwa user adalah dosen (`role = 'dosen'`)
- Setelah QR code valid, dosen diarahkan ke form input detail absensi

### 2. Form Input Detail Absensi
- **Mata Kuliah**: Field wajib untuk nama mata kuliah yang diajarkan
- **Kelas**: Field wajib untuk kelas yang diajarkan (contoh: TI-3A, SI-2B)
- **Keterangan**: Field opsional untuk catatan kegiatan mengajar

### 3. Penyimpanan Data
- Data disimpan ke tabel `attendance` dengan field tambahan:
  - `subject`: Mata kuliah
  - `class_name`: Nama kelas
  - `lecture_notes`: Keterangan dari dosen

## Perubahan Database

### Tabel `attendance` (Field Baru)
```sql
ALTER TABLE attendance 
ADD COLUMN subject VARCHAR(100) AFTER notes,
ADD COLUMN class_name VARCHAR(50) AFTER subject,
ADD COLUMN lecture_notes TEXT AFTER class_name;

-- Index untuk performa
CREATE INDEX idx_user_date ON attendance (user_id, DATE(created_at));
CREATE INDEX idx_subject_class ON attendance (subject, class_name);
```

## File yang Dibuat/Dimodifikasi

### 1. Controller
- **`application/controllers/Attendance.php`**
  - `process_qr_scan()`: Method baru untuk menangani scan QR berdasarkan role user
  - `lecturer_form()`: Menampilkan form input detail absensi dosen
  - `submit_lecturer_attendance()`: Memproses submit form absensi dosen
  - `process_staff_attendance()`: Method private untuk staff attendance

### 2. Model
- **`application/models/Attendance_model.php`**
  - `create_lecturer_attendance()`: Insert data absensi dosen
  - `get_lecturer_attendance_today()`: Cek apakah dosen sudah absen untuk mata kuliah dan kelas tertentu
  - `get_lecturer_attendance_history()`: Riwayat absensi dosen dengan filter
  - `get_lecturer_teaching_stats()`: Statistik mengajar dosen
  - `get_lecturer_subjects_classes()`: Daftar mata kuliah dan kelas dosen
  - `get_all_lecturer_attendance()`: Semua data absensi dosen (untuk admin)
  - `get_all_subjects()`: Daftar semua mata kuliah
  - `get_filtered_lecturer_attendance()`: Data absensi dosen dengan filter
  - `get_lecturer_summary_stats()`: Statistik ringkasan dosen
  - `get_subject_summary_stats()`: Statistik per mata kuliah

### 3. Views
- **`application/views/attendance/lecturer_form.php`**: Form input detail absensi dosen
- **`application/views/admin/reports/lecturer_report.php`**: Laporan absensi dosen untuk admin
- **`application/views/dashboard/scan_qr.php`**: Dimodifikasi untuk mendukung alur dosen

### 4. Admin Controller
- **`application/controllers/Admin.php`**
  - `lecturer_report()`: Halaman laporan absensi dosen
  - `export_lecturer_report()`: Export laporan dosen ke CSV

## Fitur Laporan Dosen

### Filter Laporan
- **Periode**: Tanggal mulai dan akhir
- **Dosen**: Filter berdasarkan dosen tertentu
- **Mata Kuliah**: Filter berdasarkan mata kuliah

### Statistik Ringkasan
- Total sesi mengajar
- Jumlah mata kuliah
- Jumlah kelas
- Dosen aktif

### Data Laporan
- Tanggal dan waktu mengajar
- Nama dosen dan NIP/NIDN
- Mata kuliah dan kelas
- Status (tepat waktu/terlambat)
- Lokasi QR code
- Keterangan dari dosen

### Export
- Export data ke format CSV
- Include semua field dengan format yang rapi

## Keunggulan Fitur

### 1. Fleksibilitas
- Dosen dapat mengajar multiple mata kuliah dalam satu hari
- Dapat absen untuk kelas yang berbeda secara terpisah
- Tidak ada konflik dengan sistem absensi staff

### 2. Validasi
- Mencegah duplikasi absensi untuk mata kuliah dan kelas yang sama
- Validasi QR code dan session management
- Form validation untuk field wajib

### 3. Pelaporan Lengkap
- Dashboard khusus untuk melihat absensi mengajar hari ini
- Laporan detail untuk admin dengan berbagai filter
- Statistik per mata kuliah dan dosen

### 4. User Experience
- Form yang intuitif dan user-friendly
- Auto-complete dan validation
- Feedback yang jelas
- Keyboard shortcuts (Ctrl+Enter untuk submit, Escape untuk cancel)

## Cara Penggunaan

### Untuk Dosen:
1. Login ke sistem
2. Pergi ke halaman "Scan QR Code"
3. Scan QR code yang tersedia
4. Isi form detail absensi (mata kuliah, kelas, keterangan)
5. Submit form
6. Sistem menyimpan data absensi mengajar

### Untuk Admin:
1. Login sebagai admin
2. Pergi ke menu "Laporan" > "Laporan Dosen"
3. Set filter sesuai kebutuhan (periode, dosen, mata kuliah)
4. Lihat data dan statistik
5. Export ke CSV jika diperlukan

## Kompatibilitas
- Sistem tetap mendukung absensi staff seperti biasa
- Tidak ada perubahan pada flow absensi staff
- Backward compatible dengan sistem yang sudah ada

## Instalasi

### 1. Update Database
```bash
# Jalankan file SQL untuk update tabel
mysql -u username -p database_name < database_update_lecturer_attendance.sql
```

### 2. Update Files
- Copy semua file yang telah dimodifikasi ke server
- Pastikan permission file sesuai

### 3. Test
- Test flow absensi dosen
- Test flow absensi staff (harus tetap normal)
- Test laporan admin

## Troubleshooting

### Masalah: Form tidak muncul setelah scan QR
- **Solusi**: Pastikan user login sebagai dosen (`role = 'dosen'`)
- Cek session dan role user

### Masalah: Error saat submit form
- **Solusi**: Pastikan field `subject` dan `class_name` sudah ada di database
- Cek form validation dan field requirements

### Masalah: Laporan tidak menampilkan data
- **Solusi**: Pastikan ada data absensi dosen dengan field `subject` tidak NULL
- Cek filter tanggal dan parameter lainnya
