# Fitur Tampilan Gambar di Laporan

## Deskripsi
Fitur ini memungkinkan admin untuk melihat foto kuliah yang diambil oleh dosen saat absen di laporan bulanan, mingguan, dan harian.

## Fitur yang Ditambahkan

### 1. Kolom Mata Kuliah
- Menampilkan nama mata kuliah yang diajar oleh dosen
- Menampilkan nama kelas (jika ada)
- Menggunakan badge berwarna biru untuk tampilan yang menarik

### 2. Kolom Foto
- Menampilkan thumbnail foto kuliah (50x50 pixel)
- Foto dapat diklik untuk melihat dalam ukuran penuh
- Mendukung multiple foto jika ada beberapa sesi kuliah

### 3. Modal Gambar
- Modal Bootstrap untuk menampilkan foto dalam ukuran penuh
- Tombol download untuk mengunduh foto
- Responsive design untuk berbagai ukuran layar

### 4. Styling yang Ditingkatkan
- Hover effect pada thumbnail foto
- Transisi smooth saat hover
- Responsive design untuk mobile
- Custom CSS untuk tampilan yang konsisten

## File yang Dimodifikasi

### Model
- `application/models/Attendance_model.php`
  - Menambahkan field `subjects`, `class_names`, dan `photos` di method `get_weekly_report()`
  - Method `get_monthly_report()` menggunakan data dari `get_weekly_report()`

### Views
- `application/views/admin/reports/monthly.php`
- `application/views/admin/reports/weekly.php`
- `application/views/admin/reports/daily.php`

### Fitur yang Ditambahkan di Setiap View
1. **Kolom Header Baru:**
   - Mata Kuliah
   - Foto

2. **Data yang Ditampilkan:**
   - Nama mata kuliah dengan badge
   - Nama kelas (jika ada)
   - Thumbnail foto dengan hover effect

3. **Modal Gambar:**
   - Bootstrap modal untuk tampilan foto penuh
   - Tombol download
   - Nama file foto

4. **JavaScript:**
   - Function `showImageModal()` untuk menampilkan modal
   - Konfigurasi DataTable untuk kolom baru
   - Disable sorting untuk kolom gambar dan mata kuliah

## Cara Penggunaan

### 1. Melihat Foto
- Klik pada thumbnail foto di kolom Foto
- Foto akan ditampilkan dalam modal ukuran penuh
- Gunakan tombol download untuk mengunduh foto

### 2. Melihat Informasi Mata Kuliah
- Informasi mata kuliah ditampilkan dalam badge biru
- Format: "Nama Mata Kuliah (Nama Kelas)"
- Jika ada multiple mata kuliah, akan ditampilkan dalam baris terpisah

### 3. Responsive Design
- Pada layar mobile, ukuran foto akan otomatis menyesuaikan
- Tabel dapat di-scroll horizontal jika diperlukan
- Modal gambar responsive untuk berbagai ukuran layar

## Struktur Data

### Field Baru di Model
```php
'subjects' => 'GROUP_CONCAT(DISTINCT a.subject)',
'class_names' => 'GROUP_CONCAT(DISTINCT a.class_name)',
'photos' => 'GROUP_CONCAT(DISTINCT a.lecture_photo)'
```

### Format Data
- **subjects**: String yang dipisahkan koma (contoh: "Matematika, Fisika")
- **class_names**: String yang dipisahkan koma (contoh: "Kelas A, Kelas B")
- **photos**: String yang dipisahkan koma (contoh: "foto1.jpg, foto2.jpg")

## Keamanan
- Path foto dibatasi hanya ke folder `uploads/lecture_photos/`
- Validasi file extension dilakukan di level upload
- Tidak ada akses langsung ke file system

## Performa
- Foto di-load secara lazy (hanya saat dibutuhkan)
- Thumbnail ukuran kecil untuk performa tabel
- Modal gambar di-load saat diklik

## Browser Support
- Modern browsers dengan dukungan CSS3 dan ES6
- Bootstrap 5 untuk modal dan styling
- DataTables untuk tabel interaktif

## Dependencies
- Bootstrap 5 CSS dan JS
- DataTables library
- Font Awesome untuk icons
- Chart.js untuk grafik (di laporan mingguan)

## Catatan Implementasi
- Semua perubahan backward compatible
- Tidak mengubah struktur database yang ada
- Menggunakan GROUP_CONCAT untuk aggregasi data
- Responsive design untuk semua ukuran layar
