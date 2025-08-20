<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-plus me-2"></i>
                Input Manual Absensi
            </h1>
            <a href="<?= base_url('admin/attendance') ?>" class="btn btn-secondary">
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
                    Form Input Manual Absensi
                </h5>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= $error ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($success)): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        <?= $success ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="<?= base_url('admin/attendance/manual_entry') ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="user_id" class="form-label">Pilih Pengguna <span class="text-danger">*</span></label>
                                <select class="form-control <?= form_error('user_id') ? 'is-invalid' : '' ?>" 
                                        id="user_id" 
                                        name="user_id" 
                                        required>
                                    <option value="">Pilih Pengguna</option>
                                    <?php if (!empty($users)): ?>
                                        <?php foreach ($users as $user): ?>
                                            <option value="<?= $user->id ?>" <?= set_select('user_id', $user->id) ?>>
                                                <?= $user->full_name ?> (<?= $user->username ?>) - <?= $user->department ?: 'N/A' ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <?php if (form_error('user_id')): ?>
                                    <div class="invalid-feedback">
                                        <?= form_error('user_id') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="qr_code_id" class="form-label">QR Code</label>
                                <select class="form-control" id="qr_code_id" name="qr_code_id">
                                    <option value="">Pilih QR Code</option>
                                    <?php if (!empty($qr_codes)): ?>
                                        <?php foreach ($qr_codes as $qr): ?>
                                            <option value="<?= $qr->id ?>" <?= set_select('qr_code_id', $qr->id) ?>>
                                                <?= $qr->name ?> - <?= $qr->location ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="form-text">
                                    Pilih QR Code jika ada, atau biarkan kosong untuk input manual
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="attendance_date" class="form-label">Tanggal Absensi <span class="text-danger">*</span></label>
                                <input type="date" 
                                       class="form-control <?= form_error('attendance_date') ? 'is-invalid' : '' ?>" 
                                       id="attendance_date" 
                                       name="attendance_date" 
                                       value="<?= set_value('attendance_date', date('Y-m-d')) ?>" 
                                       required>
                                <?php if (form_error('attendance_date')): ?>
                                    <div class="invalid-feedback">
                                        <?= form_error('attendance_date') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-control <?= form_error('status') ? 'is-invalid' : '' ?>" 
                                        id="status" 
                                        name="status" 
                                        required>
                                    <option value="">Pilih Status</option>
                                    <option value="present" <?= set_select('status', 'present') ?>>Hadir</option>
                                    <option value="late" <?= set_select('status', 'late') ?>>Terlambat</option>
                                    <option value="absent" <?= set_select('status', 'absent') ?>>Tidak Hadir</option>
                                    <option value="sick" <?= set_select('status', 'sick') ?>>Sakit</option>
                                    <option value="leave" <?= set_select('status', 'leave') ?>>Cuti</option>
                                </select>
                                <?php if (form_error('status')): ?>
                                    <div class="invalid-feedback">
                                        <?= form_error('status') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="check_in_time" class="form-label">Jam Masuk</label>
                                <input type="time" 
                                       class="form-control" 
                                       id="check_in_time" 
                                       name="check_in_time" 
                                       value="<?= set_value('check_in_time') ?>">
                                <div class="form-text">
                                    Kosongkan jika tidak ada check-in
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="check_out_time" class="form-label">Jam Pulang</label>
                                <input type="time" 
                                       class="form-control" 
                                       id="check_out_time" 
                                       name="check_out_time" 
                                       value="<?= set_value('check_out_time') ?>">
                                <div class="form-text">
                                    Kosongkan jika tidak ada check-out
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="work_hours" class="form-label">Jam Kerja</label>
                                <input type="number" 
                                       class="form-control" 
                                       id="work_hours" 
                                       name="work_hours" 
                                       value="<?= set_value('work_hours') ?>" 
                                       min="0" 
                                       step="0.5">
                                <div class="form-text">
                                    Jam kerja dalam format desimal (contoh: 8.5 untuk 8 jam 30 menit)
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="location" class="form-label">Lokasi</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="location" 
                                       name="location" 
                                       value="<?= set_value('location') ?>" 
                                       placeholder="Contoh: Kantor Pusat, WFH, dll">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan</label>
                        <textarea class="form-control" 
                                  id="notes" 
                                  name="notes" 
                                  rows="3" 
                                  placeholder="Catatan tambahan tentang absensi ini..."><?= set_value('notes') ?></textarea>
                        <div class="form-text">
                            Catatan opsional untuk memberikan informasi tambahan
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="override_existing" name="override_existing" value="1" <?= set_checkbox('override_existing', '1') ?>>
                            <label class="form-check-label" for="override_existing">
                                Override data yang sudah ada
                            </label>
                        </div>
                        <div class="form-text">
                            Jika dicentang, akan mengganti data absensi yang sudah ada untuk tanggal yang sama
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
                            Simpan Absensi
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
                    Informasi Input Manual
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6 class="alert-heading">
                        <i class="fas fa-lightbulb me-2"></i>
                        Tips Input Manual
                    </h6>
                    <ul class="mb-0">
                        <li>Pilih pengguna yang akan diinput absensinya</li>
                        <li>Tanggal absensi wajib diisi</li>
                        <li>Status menentukan jenis kehadiran</li>
                        <li>Jam masuk dan pulang opsional</li>
                        <li>Jam kerja dapat dihitung otomatis</li>
                    </ul>
                </div>
                
                <h6 class="text-primary">
                    <i class="fas fa-list me-2"></i>
                    Status Absensi
                </h6>
                <ul class="text-muted small">
                    <li><strong>Hadir:</strong> Pengguna hadir tepat waktu</li>
                    <li><strong>Terlambat:</strong> Pengguna hadir terlambat</li>
                    <li><strong>Tidak Hadir:</strong> Pengguna tidak hadir</li>
                    <li><strong>Sakit:</strong> Pengguna tidak hadir karena sakit</li>
                    <li><strong>Cuti:</strong> Pengguna tidak hadir karena cuti</li>
                </ul>
                
                <h6 class="text-primary">
                    <i class="fas fa-clock me-2"></i>
                    Jam Kerja
                </h6>
                <ul class="text-muted small">
                    <li>Format: 8.5 = 8 jam 30 menit</li>
                    <li>Dapat dihitung otomatis dari check-in/out</li>
                    <li>Atau input manual sesuai kebutuhan</li>
                </ul>
                
                <hr>
                
                <div class="text-center">
                    <a href="<?= base_url('admin/attendance/bulk_import') ?>" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-upload me-2"></i>
                        Import Bulk
                    </a>
                    <a href="<?= base_url('admin/attendance/template') ?>" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-download me-2"></i>
                        Download Template
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Perhatian
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <h6 class="alert-heading">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Penting!
                    </h6>
                    <ul class="mb-0 small">
                        <li>Input manual hanya untuk data yang tidak terekam otomatis</li>
                        <li>Pastikan data yang diinput akurat dan valid</li>
                        <li>Data manual akan tercatat dalam log sistem</li>
                        <li>Gunakan fitur override dengan hati-hati</li>
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
        const userId = document.getElementById('user_id').value;
        const attendanceDate = document.getElementById('attendance_date').value;
        const status = document.getElementById('status').value;
        
        if (!userId || !attendanceDate || !status) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi!');
            return false;
        }
        
        // Validate date not in the future
        const selectedDate = new Date(attendanceDate);
        const today = new Date();
        today.setHours(23, 59, 59, 999); // End of today
        
        if (selectedDate > today) {
            e.preventDefault();
            alert('Tanggal absensi tidak boleh di masa depan!');
            return false;
        }
    });
    
    // Auto-calculate work hours
    const checkInTime = document.getElementById('check_in_time');
    const checkOutTime = document.getElementById('check_out_time');
    const workHours = document.getElementById('work_hours');
    
    function calculateWorkHours() {
        if (checkInTime.value && checkOutTime.value) {
            const checkIn = new Date(`2000-01-01T${checkInTime.value}`);
            const checkOut = new Date(`2000-01-01T${checkOutTime.value}`);
            
            if (checkOut > checkIn) {
                const diffMs = checkOut - checkIn;
                const diffHours = diffMs / (1000 * 60 * 60);
                workHours.value = Math.round(diffHours * 10) / 10; // Round to 1 decimal
            } else {
                workHours.value = '';
            }
        }
    }
    
    checkInTime.addEventListener('change', calculateWorkHours);
    checkOutTime.addEventListener('change', calculateWorkHours);
    
    // Status change handler
    const statusSelect = document.getElementById('status');
    statusSelect.addEventListener('change', function() {
        const status = this.value;
        const checkInTime = document.getElementById('check_in_time');
        const checkOutTime = document.getElementById('check_out_time');
        const workHours = document.getElementById('work_hours');
        
        if (status === 'absent' || status === 'sick' || status === 'leave') {
            checkInTime.value = '';
            checkOutTime.value = '';
            workHours.value = '';
            checkInTime.disabled = true;
            checkOutTime.disabled = true;
            workHours.disabled = true;
        } else {
            checkInTime.disabled = false;
            checkOutTime.disabled = false;
            workHours.disabled = false;
        }
    });
});
</script>
