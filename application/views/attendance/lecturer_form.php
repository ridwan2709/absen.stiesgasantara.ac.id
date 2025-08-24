<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-chalkboard-teacher me-2"></i>
                Detail Absensi Mengajar
            </h1>
            <div>
                <a href="<?= base_url('dashboard/scan_qr') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<!-- QR Code Info -->
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-success">
            <h6 class="alert-heading">
                <i class="fas fa-check-circle me-2"></i>
                QR Code Valid
            </h6>
            <p class="mb-2">
                <strong>Lokasi:</strong> <?= $qr_data->location ?><br>
                <strong>Kode QR:</strong> <?= $qr_data->code ?><br>
                <strong>Deskripsi:</strong> <?= $qr_data->description ?: 'Tidak ada deskripsi' ?>
            </p>
            <hr>
            <p class="mb-0 small">
                <i class="fas fa-info-circle me-1"></i>
                Silakan lengkapi detail absensi mengajar Anda di bawah ini.
            </p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-clipboard-list me-2"></i>
                    Form Absensi Mengajar
                </h5>
            </div>
            <div class="card-body">
                <!-- Alert for messages -->
                <div id="alert-container"></div>
                
                <?= form_open('', ['id' => 'lecturerAttendanceForm', 'class' => 'row g-3']) ?>
                    
                    <!-- Mata Kuliah -->
                    <div class="col-md-6">
                        <label for="subject" class="form-label">
                            <i class="fas fa-book me-2"></i>
                            Mata Kuliah <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="subject" 
                               name="subject" 
                               placeholder="Contoh: Basis Data, Pemrograman Web, dll"
                               required>
                        <div class="form-text">
                            Nama mata kuliah yang diajarkan
                        </div>
                    </div>
                    
                    <!-- Kelas -->
                    <div class="col-md-6">
                        <label for="class_name" class="form-label">
                            <i class="fas fa-users me-2"></i>
                            Kelas <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="class_name" 
                               name="class_name" 
                               placeholder="Contoh: TI-3A, SI-2B, dll"
                               required>
                        <div class="form-text">
                            Kelas yang diajarkan
                        </div>
                    </div>
                    
                    <!-- Keterangan -->
                    <div class="col-12">
                        <label for="lecture_notes" class="form-label">
                            <i class="fas fa-sticky-note me-2"></i>
                            Keterangan <span class="text-muted">(Opsional)</span>
                        </label>
                        <textarea class="form-control" 
                                  id="lecture_notes" 
                                  name="lecture_notes" 
                                  rows="4" 
                                  placeholder="Contoh: Materi hari ini membahas tentang normalisasi database, praktikum membuat ERD, dll"></textarea>
                        <div class="form-text">
                            Keterangan tambahan tentang kegiatan mengajar hari ini
                        </div>
                    </div>
                    
                    <!-- Informasi Tambahan -->
                    <div class="col-12">
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Informasi Absensi
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-2">
                                            <strong>Tanggal:</strong> <?= date('d/m/Y') ?>
                                        </p>
                                        <p class="mb-2">
                                            <strong>Waktu:</strong> <?= date('H:i:s') ?>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2">
                                            <strong>Dosen:</strong> <?= $this->session->userdata('full_name') ?>
                                        </p>
                                        <p class="mb-2">
                                            <strong>NIP/NIDN:</strong> <?= $this->session->userdata('nip_nidn') ?: 'Tidak diatur' ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="col-12">
                        <hr>
                        <div class="d-flex justify-content-between">
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    Field yang bertanda <span class="text-danger">*</span> wajib diisi
                                </small>
                            </div>
                            <div>
                                <a href="<?= base_url('dashboard/scan_qr') ?>" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-times me-2"></i>
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="fas fa-save me-2"></i>
                                    Simpan Absensi
                                </button>
                            </div>
                        </div>
                    </div>
                    
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<!-- Tips Card -->
<div class="row mt-4">
    <div class="col-lg-8 mx-auto">
        <div class="card border-info">
            <div class="card-header bg-info text-white">
                <h6 class="card-title mb-0">
                    <i class="fas fa-lightbulb me-2"></i>
                    Tips Pengisian Absensi
                </h6>
            </div>
            <div class="card-body">
                <ul class="mb-0 small">
                    <li>Pastikan mata kuliah dan kelas sudah benar sebelum menyimpan</li>
                    <li>Anda dapat melakukan absensi untuk mata kuliah dan kelas yang berbeda di hari yang sama</li>
                    <li>Keterangan bersifat opsional, namun disarankan untuk dicantumkan sebagai catatan kegiatan mengajar</li>
                    <li>Data absensi akan tercatat dengan lokasi dan waktu scan QR Code</li>
                    <li>Jika terjadi kesalahan, hubungi administrator untuk melakukan koreksi</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('lecturerAttendanceForm');
    const submitBtn = document.getElementById('submitBtn');
    const alertContainer = document.getElementById('alert-container');
    
    // Auto-focus pada field pertama
    document.getElementById('subject').focus();
    
    // Form submit handler
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const subject = document.getElementById('subject').value.trim();
        const className = document.getElementById('class_name').value.trim();
        
        // Basic validation
        if (!subject || !className) {
            showAlert('Mohon lengkapi mata kuliah dan kelas!', 'danger');
            return;
        }
        
        // Show loading state
        const originalHtml = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
        submitBtn.disabled = true;
        
        // Prepare form data
        const formData = new FormData();
        formData.append('subject', subject);
        formData.append('class_name', className);
        formData.append('lecture_notes', document.getElementById('lecture_notes').value.trim());
        
        // Submit via AJAX
        fetch('<?= base_url('attendance/submit_lecturer_attendance') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert(data.message, 'success');
                setTimeout(function() {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        window.location.href = '<?= base_url('dashboard') ?>';
                    }
                }, 2000);
            } else {
                showAlert(data.message, 'danger');
                // Reset button
                submitBtn.innerHTML = originalHtml;
                submitBtn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Terjadi kesalahan. Silakan coba lagi.', 'danger');
            // Reset button
            submitBtn.innerHTML = originalHtml;
            submitBtn.disabled = false;
        });
    });
    
    // Show alert function
    function showAlert(message, type) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        alertContainer.innerHTML = alertHtml;
        
        // Auto-dismiss after 5 seconds
        setTimeout(function() {
            const alert = alertContainer.querySelector('.alert');
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    }
    
    // Input helpers
    document.getElementById('subject').addEventListener('input', function() {
        // Auto-capitalize first letter
        this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);
    });
    
    document.getElementById('class_name').addEventListener('input', function() {
        // Auto-uppercase
        this.value = this.value.toUpperCase();
    });
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl+Enter to submit
        if (e.ctrlKey && e.key === 'Enter') {
            e.preventDefault();
            form.dispatchEvent(new Event('submit'));
        }
        
        // Escape to cancel
        if (e.key === 'Escape') {
            if (confirm('Apakah Anda yakin ingin membatalkan absensi?')) {
                window.location.href = '<?= base_url('dashboard/scan_qr') ?>';
            }
        }
    });
});
</script>
