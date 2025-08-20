<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-plus me-2"></i>
                Tambah QR Code
            </h1>
            <a href="<?= base_url('admin/qr_codes') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Kembali
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit me-2"></i>
                    Form Tambah QR Code
                </h5>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= $error ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="<?= base_url('admin/add_qr_code') ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama QR Code <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control <?= form_error('name') ? 'is-invalid' : '' ?>" 
                                       id="name" 
                                       name="name" 
                                       value="<?= set_value('name') ?>" 
                                       placeholder="Contoh: Gerbang Utama, Ruang Meeting, dll"
                                       required>
                                <?php if (form_error('name')): ?>
                                    <div class="invalid-feedback">
                                        <?= form_error('name') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="location" class="form-label">Lokasi <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control <?= form_error('location') ? 'is-invalid' : '' ?>" 
                                       id="location" 
                                       name="location" 
                                       value="<?= set_value('location') ?>" 
                                       placeholder="Contoh: Lantai 1, Gedung A, dll"
                                       required>
                                <?php if (form_error('location')): ?>
                                    <div class="invalid-feedback">
                                        <?= form_error('location') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control <?= form_error('description') ? 'is-invalid' : '' ?>" 
                                  id="description" 
                                  name="description" 
                                  rows="3" 
                                  placeholder="Deskripsi detail tentang QR Code ini..."><?= set_value('description') ?></textarea>
                        <?php if (form_error('description')): ?>
                            <div class="invalid-feedback">
                                <?= form_error('description') ?>
                            </div>
                        <?php endif; ?>
                        <div class="form-text">
                            Deskripsi opsional untuk memberikan informasi tambahan tentang QR Code
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="qr_type" class="form-label">Tipe QR Code</label>
                                <select class="form-control" id="qr_type" name="qr_type">
                                    <option value="attendance" <?= set_select('qr_type', 'attendance', TRUE) ?>>Absensi</option>
                                    <option value="checkpoint" <?= set_select('qr_type', 'checkpoint') ?>>Checkpoint</option>
                                    <option value="access" <?= set_select('qr_type', 'access') ?>>Akses</option>
                                    <option value="information" <?= set_select('qr_type', 'information') ?>>Informasi</option>
                                </select>
                                <div class="form-text">
                                    Pilih tipe QR Code sesuai fungsinya
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="validity_period" class="form-label">Masa Berlaku</label>
                                <select class="form-control" id="validity_period" name="validity_period">
                                    <option value="unlimited" <?= set_select('validity_period', 'unlimited', TRUE) ?>>Tidak Terbatas</option>
                                    <option value="daily" <?= set_select('validity_period', 'daily') ?>>Harian</option>
                                    <option value="weekly" <?= set_select('validity_period', 'weekly') ?>>Mingguan</option>
                                    <option value="monthly" <?= set_select('validity_period', 'monthly') ?>>Bulanan</option>
                                    <option value="yearly" <?= set_select('validity_period', 'yearly') ?>>Tahunan</option>
                                </select>
                                <div class="form-text">
                                    Periode validitas QR Code
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Tanggal Mulai Berlaku</label>
                                <input type="date" 
                                       class="form-control" 
                                       id="start_date" 
                                       name="start_date" 
                                       value="<?= set_value('start_date', date('Y-m-d')) ?>">
                                <div class="form-text">
                                    Tanggal mulai QR Code dapat digunakan
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">Tanggal Berakhir</label>
                                <input type="date" 
                                       class="form-control" 
                                       id="end_date" 
                                       name="end_date" 
                                       value="<?= set_value('end_date') ?>">
                                <div class="form-text">
                                    Tanggal berakhir QR Code (kosongkan jika tidak terbatas)
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?= set_checkbox('is_active', '1', TRUE) ?>>
                            <label class="form-check-label" for="is_active">
                                Aktifkan QR Code setelah dibuat
                            </label>
                        </div>
                        <div class="form-text">
                            QR Code yang tidak aktif tidak dapat digunakan untuk absensi
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-flex justify-content-end">
                        <button type="reset" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-undo me-2"></i>
                            Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Simpan QR Code
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informasi QR Code
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6 class="alert-heading">
                        <i class="fas fa-lightbulb me-2"></i>
                        Tips Membuat QR Code
                    </h6>
                    <ul class="mb-0">
                        <li>Berikan nama yang jelas dan mudah diingat</li>
                        <li>Lokasi harus spesifik dan akurat</li>
                        <li>Deskripsi membantu pengguna memahami fungsi</li>
                        <li>Pilih tipe sesuai kebutuhan</li>
                        <li>Atur masa berlaku jika diperlukan</li>
                    </ul>
                </div>
                
                <h6 class="text-primary">
                    <i class="fas fa-qrcode me-2"></i>
                    Tipe QR Code
                </h6>
                <ul class="text-muted small">
                    <li><strong>Absensi:</strong> Untuk check-in/check-out karyawan</li>
                    <li><strong>Checkpoint:</strong> Untuk tracking lokasi</li>
                    <li><strong>Akses:</strong> Untuk membuka pintu/area tertentu</li>
                    <li><strong>Informasi:</strong> Untuk memberikan informasi</li>
                </ul>
                
                <h6 class="text-primary">
                    <i class="fas fa-calendar me-2"></i>
                    Masa Berlaku
                </h6>
                <ul class="text-muted small">
                    <li><strong>Tidak Terbatas:</strong> QR Code berlaku selamanya</li>
                    <li><strong>Harian:</strong> Hanya berlaku pada hari yang sama</li>
                    <li><strong>Mingguan:</strong> Berlaku selama seminggu</li>
                    <li><strong>Bulanan:</strong> Berlaku selama sebulan</li>
                    <li><strong>Tahunan:</strong> Berlaku selama setahun</li>
                </ul>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-shield-alt me-2"></i>
                    Keamanan
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <h6 class="alert-heading">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Penting!
                    </h6>
                    <ul class="mb-0 small">
                        <li>QR Code akan dibuat otomatis dengan kode unik</li>
                        <li>Simpan QR Code dengan aman</li>
                        <li>Jangan bagikan QR Code kepada pihak yang tidak berwenang</li>
                        <li>Monitor penggunaan QR Code secara berkala</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            if (!alert.classList.contains('alert-warning')) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            }
        });
    }, 5000);
    
    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const name = document.getElementById('name').value.trim();
        const location = document.getElementById('location').value.trim();
        
        if (!name || !location) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi!');
            return false;
        }
    });
    
    // Date validation
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');
    
    startDate.addEventListener('change', function() {
        if (endDate.value && startDate.value > endDate.value) {
            endDate.value = startDate.value;
        }
    });
    
    endDate.addEventListener('change', function() {
        if (startDate.value && endDate.value < startDate.value) {
            alert('Tanggal berakhir tidak boleh lebih awal dari tanggal mulai!');
            endDate.value = '';
        }
    });
});
</script>
