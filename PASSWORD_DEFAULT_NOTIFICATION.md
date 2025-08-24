# 🔐 Fitur Notifikasi Password Default

## 📋 **Deskripsi Fitur**
Fitur ini memberikan notifikasi peringatan keamanan kepada user yang masih menggunakan password default (001) setelah login pertama kali. Notifikasi akan muncul di semua halaman sampai user mengganti password mereka.

## 🎯 **Tujuan**
- Meningkatkan keamanan akun user
- Memaksa user untuk mengganti password default
- Memberikan peringatan visual yang jelas dan tidak mengganggu
- Tracking status password user

## 🗄️ **Database Changes**

### 1. **Field Baru di Tabel `users`**
```sql
ALTER TABLE users 
ADD COLUMN is_default_password TINYINT(1) DEFAULT 1 AFTER is_active;
```

### 2. **Script Update Database**
File: `database_update_password_default.sql`

## 🔧 **File yang Dimodifikasi**

### 1. **Models**
- `application/models/User_model.php`
  - Method `create_user()`: Set `is_default_password = 1` untuk user baru
  - Method `update_user()`: Set `is_default_password = 0` ketika password diubah

### 2. **Controllers**
- `application/controllers/Auth.php`
  - Method `login()`: Set session `is_default_password`
- `application/controllers/Dashboard.php`
  - Method `index()`: Pass data `show_password_warning`

### 3. **Views**
- `application/views/dashboard/index.php`
  - Tambah notifikasi warning di dashboard
- `application/views/templates/header.php`
  - Tambah notifikasi global di semua halaman

## 📱 **Tampilan Notifikasi**

### **1. Notifikasi di Dashboard**
- Muncul di bagian atas dashboard
- Alert warning dengan icon ⚠️
- Tombol "Ganti Password Sekarang" yang mengarah ke halaman change password
- Tombol "Tutup" untuk dismiss notifikasi

### **2. Notifikasi Global (Header)**
- Muncul di semua halaman yang menggunakan template header
- Posisi di bawah flash messages
- Design yang konsisten dengan dashboard

### **3. Design Notifikasi**
```html
<div class="alert alert-warning alert-dismissible fade show">
    <div class="d-flex align-items-center">
        <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
        <div class="flex-grow-1">
            <h6 class="alert-heading mb-1">
                <strong>⚠️ Peringatan Keamanan!</strong>
            </h6>
            <p class="mb-2">
                Anda masih menggunakan password default. Untuk keamanan akun, 
                <strong>segera ganti password Anda</strong> dengan password yang lebih kuat.
            </p>
            <div class="d-flex gap-2">
                <a href="dashboard/change_password" class="btn btn-warning btn-sm">
                    <i class="fas fa-key me-2"></i>
                    Ganti Password Sekarang
                </a>
                <button type="button" class="btn btn-outline-warning btn-sm" data-bs-dismiss="alert">
                    <i class="fas fa-times me-2"></i>
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
```

## 🔄 **Flow Kerja**

### **1. Login Pertama Kali**
1. User login dengan password default (001)
2. System set session `is_default_password = 1`
3. Notifikasi warning muncul di semua halaman

### **2. Ganti Password**
1. User klik "Ganti Password Sekarang"
2. User mengisi form change password
3. System update password dan set `is_default_password = 0`
4. Notifikasi warning hilang otomatis

### **3. Login Setelah Ganti Password**
1. User login dengan password baru
2. System set session `is_default_password = 0`
3. Tidak ada notifikasi warning

## 📊 **Status Tracking**

### **Field `is_default_password`**
- `1` = User masih menggunakan password default
- `0` = User sudah mengganti password

### **Session Data**
```php
$session_data = array(
    'user_id' => $user->id,
    'username' => $user->username,
    'full_name' => $user->full_name,
    'role' => $user->role,
    'department' => $user->department,
    'is_default_password' => $user->is_default_password, // ← Field baru
    'logged_in' => TRUE
);
```

## 🚀 **Cara Implementasi**

### **1. Update Database**
```bash
# Jalankan script SQL
mysql -u username -p database_name < database_update_password_default.sql
```

### **2. Upload File yang Dimodifikasi**
- Upload semua file yang sudah dimodifikasi
- Pastikan tidak ada error syntax

### **3. Test Fitur**
1. Login dengan user dosen (password: 001)
2. Pastikan notifikasi warning muncul
3. Ganti password
4. Pastikan notifikasi hilang
5. Logout dan login ulang dengan password baru

## ⚠️ **Troubleshooting**

### **1. Notifikasi Tidak Muncul**
- Cek field `is_default_password` di database
- Cek session data `is_default_password`
- Cek apakah user menggunakan password default

### **2. Notifikasi Tidak Hilang Setelah Ganti Password**
- Cek method `update_user()` di User_model
- Pastikan field `is_default_password` ter-update ke 0
- Cek session data setelah update

### **3. Error Database**
- Pastikan field `is_default_password` sudah ditambahkan
- Cek struktur tabel `users`
- Jalankan ulang script SQL jika perlu

## 🔒 **Keamanan**

### **1. Password Hashing**
- Password tetap di-hash menggunakan bcrypt
- Field `is_default_password` hanya untuk tracking

### **2. Session Security**
- Session `is_default_password` tidak menyimpan password
- Hanya boolean flag untuk status

### **3. Access Control**
- Notifikasi hanya muncul untuk user yang login
- Tidak ada informasi sensitif yang terekspos

## 📝 **Catatan Penting**

1. **Field `is_default_password`** harus ditambahkan ke database terlebih dahulu
2. **Password default** tetap "001" untuk semua dosen
3. **Notifikasi** akan muncul di semua halaman sampai password diganti
4. **User baru** otomatis set `is_default_password = 1`
5. **Update password** otomatis set `is_default_password = 0`

## ✅ **Status Implementasi**
- ✅ Database schema update
- ✅ Model modifications
- ✅ Controller updates
- ✅ View modifications
- ✅ Session handling
- ✅ Password tracking
- ✅ Security implementation

Fitur notifikasi password default telah berhasil diimplementasikan dan siap digunakan!
