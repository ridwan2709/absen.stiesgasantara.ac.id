<style>
.camera-container {
    position: relative;
    overflow: hidden;
}

#photoPreview {
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    padding: 15px;
    text-align: center;
    background-color: #f8f9fa;
}

#photoPreview img {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    border-radius: 8px;
}

.camera-btn {
    transition: all 0.3s ease;
}

.camera-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.photo-status {
    min-width: 150px;
}

@media (max-width: 768px) {
    .input-group {
        flex-direction: column;
    }
    
    .input-group > * {
        margin-bottom: 10px;
        border-radius: 4px !important;
    }
    
    .photo-status {
        min-width: auto;
        text-align: center;
    }
}
</style>

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
                
                <?= form_open('', ['id' => 'lecturerAttendanceForm', 'class' => 'row g-3', 'enctype' => 'multipart/form-data']) ?>
                    
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
                        <label for="lecture_photo" class="form-label">
                            <i class="fas fa-camera me-2"></i>
                            Foto Kegiatan <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="file" 
                                   class="form-control" 
                                   id="lecture_photo" 
                                   name="lecture_photo" 
                                   accept="image/*" 
                                   capture="environment"
                                   style="display: none;"
                                   required>
                            <button type="button" 
                                    class="btn btn-primary camera-btn" 
                                    id="cameraBtn"
                                    onclick="openCamera()">
                                <i class="fas fa-camera me-2"></i>
                                Buka Kamera
                            </button>
                            <span class="input-group-text photo-status" id="photoStatus">
                                <i class="fas fa-exclamation-circle text-warning"></i>
                                Belum ada foto
                            </span>
                        </div>
                        <div class="form-text">
                            Klik tombol "Buka Kamera" untuk langsung mengambil foto kegiatan mengajar
                        </div>
                        <div id="photoPreview" class="mt-3 camera-container" style="display: none;">
                            <img id="previewImage" class="img-fluid rounded" style="max-height: 200px;" alt="Preview Foto">
                            <div class="mt-2">
                                <button type="button" class="btn btn-sm btn-outline-danger" id="retakeBtn">
                                    <i class="fas fa-redo me-1"></i>
                                    Ambil Ulang
                                </button>
                            </div>
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
                    <li>Foto kegiatan mengajar wajib diambil untuk dokumentasi kegiatan</li>
                    <li>Pastikan foto jelas dan menunjukkan kegiatan mengajar yang sedang berlangsung</li>
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
        
        // Add photo file
        const photoFile = document.getElementById('lecture_photo').files[0];
        if (photoFile) {
            formData.append('lecture_photo', photoFile);
        } else {
            showAlert('Mohon pilih foto kegiatan mengajar!', 'danger');
            submitBtn.innerHTML = originalHtml;
            submitBtn.disabled = false;
            return;
        }
        
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
    
    // Photo preview functionality
    document.getElementById('lecture_photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('photoPreview');
        const previewImage = document.getElementById('previewImage');
        const photoStatus = document.getElementById('photoStatus');
        
        if (file) {
            // Validate file type
            if (!file.type.startsWith('image/')) {
                showAlert('File yang dipilih bukan gambar!', 'danger');
                this.value = '';
                preview.style.display = 'none';
                photoStatus.innerHTML = '<i class="fas fa-exclamation-circle text-warning"></i> Belum ada foto';
                return;
            }
            
            // Validate file size (max 5MB)
            if (file.size > 5 * 1024 * 1024) {
                showAlert('Ukuran file terlalu besar! Maksimal 5MB.', 'danger');
                this.value = '';
                preview.style.display = 'none';
                photoStatus.innerHTML = '<i class="fas fa-exclamation-circle text-warning"></i> Belum ada foto';
                return;
            }
            
            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                preview.style.display = 'block';
                photoStatus.innerHTML = '<i class="fas fa-check-circle text-success"></i> Foto sudah ada';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
            photoStatus.innerHTML = '<i class="fas fa-exclamation-circle text-warning"></i> Belum ada foto';
        }
    });
    
    // Retake button handler
    document.getElementById('retakeBtn').addEventListener('click', function() {
        openCamera();
    });
    
    // Open camera function
    function openCamera() {
        const cameraBtn = document.getElementById('cameraBtn');
        const originalText = cameraBtn.innerHTML;
        
        // Show loading state
        cameraBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Membuka Kamera...';
        cameraBtn.disabled = true;
        
        // Trigger file input
        document.getElementById('lecture_photo').click();
        
        // Reset button after a short delay
        setTimeout(function() {
            cameraBtn.innerHTML = originalText;
            cameraBtn.disabled = false;
        }, 2000);
    }
    
    // Check if device supports camera
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        // Device supports camera
        document.getElementById('cameraBtn').classList.add('btn-primary');
    } else {
        // Device doesn't support camera, fallback to file input
        document.getElementById('cameraBtn').classList.add('btn-secondary');
        document.getElementById('cameraBtn').innerHTML = '<i class="fas fa-image me-2"></i>Pilih Foto';
        document.getElementById('lecture_photo').removeAttribute('capture');
    }
});
</script>
