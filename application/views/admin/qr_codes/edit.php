<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-edit me-2"></i>
                Edit QR Code
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
                    Form Edit QR Code
                </h5>
                <small class="text-muted">
                    ID: <?= $qr_code->id ?> | Kode: <?= $qr_code->code ?>
                </small>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= $error ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="<?= base_url('admin/edit_qr_code/' . $qr_code->id) ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama QR Code <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control <?= form_error('name') ? 'is-invalid' : '' ?>" 
                                       id="name" 
                                       name="name" 
                                       value="<?= set_value('name', $qr_code->name) ?>" 
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
                                       value="<?= set_value('location', $qr_code->location) ?>" 
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
                                  placeholder="Deskripsi detail tentang QR Code ini..."><?= set_value('description', $qr_code->description) ?></textarea>
                        <?php if (form_error('description')): ?>
                            <div class="invalid-feedback">
                                <?= form_error('description') ?>
                            </div>
                        <?php endif; ?>
                        <div class="form-text">
                            Deskripsi opsional untuk memberikan informasi tambahan tentang QR Code
                        </div>
                    </div>
                    
                    <!-- Field-field ini tidak tersedia di database saat ini -->
                    <!-- 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="qr_type" class="form-label">Tipe QR Code</label>
                                <select class="form-control" id="qr_type" name="qr_type">
                                    <option value="attendance" selected>Absensi</option>
                                    <option value="checkpoint">Checkpoint</option>
                                    <option value="access">Akses</option>
                                    <option value="information">Informasi</option>
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
                                    <option value="unlimited" selected>Tidak Terbatas</option>
                                    <option value="daily">Harian</option>
                                    <option value="weekly">Mingguan</option>
                                    <option value="monthly">Bulanan</option>
                                    <option value="yearly">Tahunan</option>
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
                                       value="<?= date('Y-m-d') ?>">
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
                                       name="end_date">
                                <div class="form-text">
                                    Tanggal berakhir QR Code (kosongkan jika tidak terbatas)
                                </div>
                            </div>
                        </div>
                    </div>
                    -->
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?= set_checkbox('is_active', '1', $qr_code->is_active) ?>>
                            <label class="form-check-label" for="is_active">
                                Aktifkan QR Code
                            </label>
                        </div>
                        <div class="form-text">
                            QR Code yang tidak aktif tidak dapat digunakan untuk absensi
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-flex justify-content-end">
                        <a href="<?= base_url('admin/qr_codes') ?>" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-times me-2"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Update QR Code
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
                    <i class="fas fa-qrcode me-2"></i>
                    Preview QR Code
                </h5>
            </div>
            <div class="card-body text-center">
                <div class="qr-code-preview mb-3">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= urlencode($qr_code->code) ?>" 
                         alt="QR Code" 
                         class="img-fluid"
                         style="max-width: 200px;">
                </div>
                <div class="mb-3">
                    <strong class="text-primary"><?= $qr_code->code ?></strong>
                </div>
                <div class="mb-3">
                    <a href="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=<?= urlencode($qr_code->code) ?>" 
                       class="btn btn-outline-primary btn-sm"
                       target="_blank"
                       download="qr_code_<?= $qr_code->code ?>.png">
                        <i class="fas fa-download me-2"></i>
                        Download QR Code
                    </a>
                </div>
                <hr>
                <div class="text-start">
                    <h6 class="text-primary">Informasi QR Code</h6>
                    <table class="table table-sm">
                        <tr>
                            <td><strong>ID:</strong></td>
                            <td><?= $qr_code->id ?></td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat:</strong></td>
                            <td><?= date('d/m/Y H:i', strtotime($qr_code->created_at)) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Diupdate:</strong></td>
                            <td><?= $qr_code->updated_at ? date('d/m/Y H:i', strtotime($qr_code->updated_at)) : 'Belum pernah diupdate' ?></td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat Oleh:</strong></td>
                            <td><?= $qr_code->created_by ? 'Admin' : 'System' ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Tips Edit
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6 class="alert-heading">
                        <i class="fas fa-lightbulb me-2"></i>
                        Tips Mengedit QR Code
                    </h6>
                    <ul class="mb-0 small">
                        <li>Kode QR tidak dapat diubah setelah dibuat</li>
                        <li>Perubahan nama dan lokasi akan mempengaruhi tampilan</li>
                        <li>Status aktif/nonaktif dapat diubah kapan saja</li>
                        <li>Masa berlaku dapat diperpanjang atau diperpendek</li>
                        <li>Simpan perubahan secara berkala</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-history me-2"></i>
                    Riwayat Penggunaan
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <a href="<?= base_url('admin/qr_code_usage/' . $qr_code->id) ?>" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-chart-bar me-2"></i>
                        Lihat Riwayat Penggunaan
                    </a>
                </div>
                <div class="text-muted small mt-2">
                    Lihat statistik dan riwayat penggunaan QR Code ini
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
            if (!alert.classList.contains('alert-info')) {
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
    
    // Date validation - disabled karena field tidak tersedia di database
    /*
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
    */
});
</script>
