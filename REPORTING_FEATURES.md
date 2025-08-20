# Fitur Laporan Sistem Manajemen Absensi

## Overview
Sistem manajemen absensi telah dilengkapi dengan fitur laporan yang komprehensif untuk memantau dan menganalisis data kehadiran karyawan.

## Fitur Laporan yang Tersedia

### 1. Laporan Mingguan
- **Lokasi**: `/admin/weekly_report`
- **Fitur**:
  - Filter berdasarkan rentang tanggal
  - Ringkasan statistik kehadiran
  - Tabel data absensi per karyawan
  - Export ke format CSV
  - Grafik distribusi kehadiran
  - Perbandingan antar departemen

### 2. Laporan Bulanan
- **Lokasi**: `/admin/monthly_report`
- **Fitur**:
  - Filter berdasarkan tahun dan bulan
  - Statistik bulanan lengkap
  - Tabel data absensi bulanan
  - Export ke format CSV
  - Perhitungan persentase kehadiran

### 3. Laporan Harian
- **Lokasi**: `/admin/daily_report`
- **Fitur**:
  - Filter berdasarkan tanggal spesifik
  - Detail waktu masuk dan pulang
  - Statistik per departemen
  - Analisis waktu keterlambatan
  - Export ke format CSV

### 4. Laporan Detail Pengguna
- **Lokasi**: `/admin/user_report`
- **Fitur**:
  - Riwayat absensi individual
  - Filter periode waktu
  - Statistik performa per pengguna
  - Export data personal

## Cara Mengakses

### Melalui Menu Admin
1. Login sebagai admin
2. Klik menu "Laporan Absensi"
3. Pilih jenis laporan yang diinginkan

### Melalui Manajemen Pengguna
1. Buka menu "Manajemen Pengguna"
2. Klik tombol "Laporan Absensi" pada baris pengguna
3. Lihat laporan detail pengguna tersebut

## Fitur Export

Semua laporan dapat diexport ke format CSV dengan fitur:
- Nama file otomatis sesuai periode
- Header kolom yang informatif
- Data terformat dengan baik
- Kompatibel dengan Excel dan aplikasi spreadsheet

## Statistik yang Tersedia

### Statistik Umum
- Total karyawan aktif
- Total kehadiran harian
- Total keterlambatan
- Total jam kerja

### Statistik Per Departemen
- Kehadiran per departemen
- Perbandingan performa
- Analisis tren

### Statistik Individual
- Riwayat kehadiran
- Tingkat ketepatan waktu
- Jam kerja rata-rata
- Evaluasi performa

## Filter dan Pencarian

### Filter Waktu
- **Harian**: Pilih tanggal spesifik
- **Mingguan**: Pilih rentang tanggal
- **Bulanan**: Pilih tahun dan bulan

### Filter Data
- Berdasarkan departemen
- Berdasarkan role pengguna
- Berdasarkan status kehadiran

## Grafik dan Visualisasi

### Chart.js Integration
- Grafik pie untuk distribusi kehadiran
- Grafik bar untuk perbandingan departemen
- Grafik line untuk trend kehadiran

### Responsive Design
- Chart yang responsif
- Optimized untuk mobile dan desktop
- Interactive tooltips

## DataTables Integration

Semua tabel laporan menggunakan DataTables dengan fitur:
- Pagination otomatis
- Sorting berdasarkan kolom
- Search dan filter
- Export data
- Bahasa Indonesia

## Keamanan

### Access Control
- Hanya admin yang dapat mengakses laporan
- Validasi session dan role
- Proteksi terhadap unauthorized access

### Data Privacy
- Data personal terlindungi
- Export terbatas pada data yang relevan
- Logging untuk audit trail

## Customization

### Pengaturan Waktu
- Jam kerja standar: 08:00 - 17:00
- Toleransi keterlambatan: 15 menit
- Dapat disesuaikan melalui konfigurasi

### Threshold Performa
- Excellent: ≥90%
- Good: 80-89%
- Fair: 70-79%
- Poor: <70%

## Troubleshooting

### Masalah Umum
1. **Data tidak muncul**: Periksa filter tanggal
2. **Export gagal**: Pastikan permission folder write
3. **Chart tidak load**: Periksa koneksi internet untuk CDN

### Log dan Debug
- Periksa error log PHP
- Debug mode untuk development
- Validasi data input

## Future Enhancements

### Fitur yang Direncanakan
- Laporan real-time
- Dashboard executive
- Alert dan notifikasi
- Integration dengan sistem HR
- Mobile app untuk laporan

### Performance Optimization
- Caching untuk laporan besar
- Pagination untuk data massal
- Background processing untuk export
- Database optimization

## Support

Untuk bantuan teknis atau pertanyaan tentang fitur laporan:
- Dokumentasi lengkap tersedia di sistem
- Hubungi administrator sistem
- Periksa log error untuk debugging
