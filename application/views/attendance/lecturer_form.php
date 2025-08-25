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
                
                <?= form_open_multipart('attendance/submit_lecturer_attendance', ['id' => 'lecturerAttendanceForm', 'class' => 'needs-validation', 'novalidate' => '']) ?>
                    
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
                                    id="cameraBtn">
                                <i class="fas fa-camera me-2"></i>
                                Buka Kamera
                            </button>
                            <span class="input-group-text photo-status" id="photoStatus">
                                <i class="fas fa-exclamation-circle text-warning"></i>
                                Belum ada foto
                            </span>
                        </div>
                        <div class="form-text">
                            Klik tombol "Buka Kamera" untuk langsung membuka kamera dan mengambil foto kegiatan mengajar
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
                    <li>Foto kegiatan mengajar wajib diambil langsung dari kamera untuk dokumentasi kegiatan</li>
                    <li>Kamera akan langsung terbuka tanpa opsi pilih dari galeri</li>
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
    
    // Form submission with photo
    document.getElementById('lecturerAttendanceForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        console.log('Form submission started');
        
        // Get form elements
        const form = this;
        const submitBtn = document.getElementById('submitBtn');
        const originalText = submitBtn.innerHTML;
        
        // Validate required fields
        const subject = document.getElementById('subject').value.trim();
        const className = document.getElementById('class_name').value.trim();
        const photoFile = document.getElementById('lecture_photo').files[0];
        
        if (!subject) {
            showAlert('Mata kuliah wajib diisi', 'danger');
            document.getElementById('subject').focus();
            return;
        }
        
        if (!className) {
            showAlert('Kelas wajib diisi', 'danger');
            document.getElementById('class_name').focus();
            return;
        }
        
        if (!photoFile) {
            showAlert('Foto kegiatan mengajar wajib diambil', 'danger');
            document.getElementById('cameraBtn').focus();
            return;
        }
        
        // Validate photo file
        if (!photoFile.type.startsWith('image/')) {
            showAlert('File yang dipilih bukan gambar', 'danger');
            return;
        }
        
        if (photoFile.size > 5 * 1024 * 1024) { // 5MB
            showAlert('Ukuran foto terlalu besar. Maksimal 5MB', 'danger');
            return;
        }
        
        // Show loading state
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
        submitBtn.disabled = true;
        
        // Create FormData for file upload
        const formData = new FormData(form);
        
        // Log form data for debugging
        console.log('Form data being sent:');
        for (let [key, value] of formData.entries()) {
            if (key === 'lecture_photo') {
                console.log(key, 'File:', value.name, 'Size:', value.size, 'Type:', value.type);
            } else {
                console.log(key, value);
            }
        }
        
        // Submit form with photo
        fetch('<?= base_url('attendance/submit_lecturer_attendance') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log('Server response:', data);
            
            if (data.success) {
                showAlert(data.message, 'success');
                
                // Redirect after delay
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 2000);
            } else {
                showAlert(data.message || 'Terjadi kesalahan. Silakan coba lagi.', 'danger');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error submitting form:', error);
            showAlert('Terjadi kesalahan jaringan. Silakan coba lagi.', 'danger');
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });
    
    // Show alert function
    function showAlert(message, type) {
        const iconClass = type === 'success' ? 'check-circle' : 'exclamation-triangle';
        const alertHtml = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
            '<i class="fas fa-' + iconClass + ' me-2"></i>' +
            message +
            '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
            '</div>';
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
    
    // Handle photo file selection/change
    document.getElementById('lecture_photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const photoStatus = document.getElementById('photoStatus');
        const photoPreview = document.getElementById('photoPreview');
        const previewImg = document.getElementById('previewImage');
        const retakeBtn = document.getElementById('retakeBtn');
        
        if (file) {
            console.log('File selected:', file.name, file.size, file.type);
            
            // Validate file type
            if (!file.type.startsWith('image/')) {
                showAlert('File yang dipilih bukan gambar. Silakan pilih file gambar.', 'danger');
                this.value = ''; // Clear input
                return;
            }
            
            // Validate file size (max 5MB)
            if (file.size > 5 * 1024 * 1024) {
                showAlert('Ukuran file terlalu besar. Maksimal 5MB.', 'danger');
                this.value = ''; // Clear input
                return;
            }
            
            // Show photo preview
            if (photoPreview && previewImg) {
                photoPreview.style.display = 'block';
                
                // Create preview URL
                const previewUrl = URL.createObjectURL(file);
                previewImg.src = previewUrl;
                previewImg.alt = 'Preview Foto Kegiatan';
                
                // Update status
                if (photoStatus) {
                    photoStatus.innerHTML = `
                        <i class="fas fa-check-circle text-success me-2"></i>
                        Foto berhasil dipilih: ${file.name} (${(file.size / 1024).toFixed(1)} KB)
                    `;
                    photoStatus.className = 'photo-status text-success';
                }
                
                // Show retake button
                if (retakeBtn) {
                    retakeBtn.style.display = 'inline-block';
                }
                
                console.log('Photo preview displayed successfully');
            }
        } else {
            // No file selected
            if (photoPreview) {
                photoPreview.style.display = 'none';
            }
            if (photoStatus) {
                photoStatus.innerHTML = '<i class="fas fa-info-circle text-info me-2"></i>Belum ada foto yang dipilih';
                photoStatus.className = 'photo-status text-info';
            }
            if (retakeBtn) {
                retakeBtn.style.display = 'none';
            }
        }
    });
    
    // Retake photo functionality
    document.getElementById('retakeBtn').addEventListener('click', function() {
        console.log('Retake photo button clicked');
        
        // Clear current photo
        const fileInput = document.getElementById('lecture_photo');
        fileInput.value = '';
        
        // Hide preview
        const photoPreview = document.getElementById('photoPreview');
        if (photoPreview) {
            photoPreview.style.display = 'none';
        }
        
        // Reset status
        const photoStatus = document.getElementById('photoStatus');
        if (photoStatus) {
            photoStatus.innerHTML = '<i class="fas fa-info-circle text-info me-2"></i>Belum ada foto yang dipilih';
            photoStatus.className = 'photo-status text-info';
        }
        
        // Hide retake button
        this.style.display = 'none';
        
        // Open camera again
        openCamera();
    });
    
    // Open camera function - direct camera access only (no file picker)
    function openCamera() {
        console.log('openCamera function called');
        
        const cameraBtn = document.getElementById('cameraBtn');
        const fileInput = document.getElementById('lecture_photo');
        
        if (!cameraBtn || !fileInput) {
            console.error('Required elements not found:', { cameraBtn, fileInput });
            return;
        }
        
        const originalText = cameraBtn.innerHTML;
        
        // Show loading state
        cameraBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Membuka Kamera...';
        cameraBtn.disabled = true;
        
        console.log('Device type:', isMobileDevice() ? 'Mobile' : 'Desktop');
        console.log('User Agent:', navigator.userAgent);
        
        // Always try to use camera directly, no file picker fallback
        if (supportsMediaDevices()) {
            console.log('Using MediaDevices API for direct camera access');
            openCameraWithMediaDevices(cameraBtn, originalText);
        } else {
            console.log('MediaDevices not supported, using camera-only file input');
            openCameraOnlyFileInput(fileInput, cameraBtn, originalText);
        }
    }
    
    // Check if MediaDevices API is supported
    function supportsMediaDevices() {
        return !!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia);
    }
    
    // Open camera using MediaDevices API (direct camera access)
    function openCameraWithMediaDevices(cameraBtn, originalText) {
        const constraints = {
            video: {
                facingMode: 'environment', // Use back camera for better quality
                width: { ideal: 1920, min: 1280 },
                height: { ideal: 1080, min: 720 }
            },
            audio: false
        };
        
        console.log('Requesting direct camera access with constraints:', constraints);
        
        navigator.mediaDevices.getUserMedia(constraints)
            .then(function(stream) {
                console.log('Direct camera access granted, showing camera interface');
                showCameraInterface(stream, cameraBtn, originalText);
            })
            .catch(function(error) {
                console.error('Direct camera access denied:', error);
                
                // Try alternative constraints (front camera)
                const altConstraints = {
                    video: { facingMode: 'user' },
                    audio: false
                };
                
                console.log('Trying front camera as fallback');
                navigator.mediaDevices.getUserMedia(altConstraints)
                    .then(function(stream) {
                        console.log('Front camera access granted');
                        showCameraInterface(stream, cameraBtn, originalText);
                    })
                    .catch(function(altError) {
                        console.error('All camera access denied:', altError);
                        showAlert('Tidak dapat mengakses kamera. Pastikan izin kamera diberikan dan coba lagi.', 'error');
                        cameraBtn.innerHTML = originalText;
                        cameraBtn.disabled = false;
                    });
            });
    }
    
    // Show camera interface with live preview (scan-like interface)
    function showCameraInterface(stream, cameraBtn, originalText) {
        // Create camera modal with scan-like interface
        const cameraModal = document.createElement('div');
        cameraModal.className = 'camera-modal';
        cameraModal.innerHTML = `
            <div class="camera-modal-content">
                <div class="camera-header">
                    <h5><i class="fas fa-camera me-2"></i>Ambil Foto Kegiatan</h5>
                    <button type="button" class="btn-close" onclick="closeCameraModal()"></button>
                </div>
                <div class="camera-body">
                    <div class="camera-viewfinder">
                        <video id="cameraVideo" autoplay playsinline muted></video>
                        <div class="scan-overlay">
                            <div class="scan-frame"></div>
                            <div class="scan-instruction">Posisikan kegiatan mengajar dalam kotak</div>
                        </div>
                    </div>
                    <div class="camera-controls">
                        <button type="button" class="btn btn-primary btn-lg" onclick="capturePhoto()">
                            <i class="fas fa-camera me-2"></i>Ambil Foto
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="switchCamera()">
                            <i class="fas fa-sync me-2"></i>Ganti Kamera
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="closeCameraModal()">
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        // Add enhanced styles for scan-like interface
        const cameraStyles = document.createElement('style');
        cameraStyles.textContent = `
            .camera-modal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.95);
                z-index: 9999;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .camera-modal-content {
                background: white;
                border-radius: 15px;
                max-width: 95vw;
                max-height: 95vh;
                overflow: hidden;
                box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            }
            .camera-header {
                padding: 20px;
                border-bottom: 1px solid #dee2e6;
                display: flex;
                justify-content: space-between;
                align-items: center;
                background: #f8f9fa;
            }
            .camera-header h5 {
                margin: 0;
                color: #333;
            }
            .camera-body {
                padding: 20px;
                text-align: center;
            }
            .camera-viewfinder {
                position: relative;
                margin-bottom: 20px;
            }
            #cameraVideo {
                width: 100%;
                max-width: 640px;
                height: auto;
                border-radius: 12px;
                border: 3px solid #fff;
                box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            }
            .scan-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                pointer-events: none;
            }
            .scan-frame {
                width: 80%;
                height: 60%;
                border: 3px solid #00ff00;
                border-radius: 8px;
                box-shadow: 0 0 20px rgba(0,255,0,0.5);
                animation: scanPulse 2s infinite;
            }
            .scan-instruction {
                margin-top: 15px;
                color: #fff;
                background: rgba(0,0,0,0.7);
                padding: 8px 16px;
                border-radius: 20px;
                font-size: 14px;
                font-weight: 500;
                text-shadow: 0 1px 2px rgba(0,0,0,0.8);
            }
            @keyframes scanPulse {
                0%, 100% { border-color: #00ff00; box-shadow: 0 0 20px rgba(0,255,0,0.5); }
                50% { border-color: #00cc00; box-shadow: 0 0 30px rgba(0,255,0,0.8); }
            }
            .camera-controls {
                display: flex;
                gap: 12px;
                justify-content: center;
                flex-wrap: wrap;
            }
            .camera-controls .btn {
                min-width: 120px;
                border-radius: 25px;
                font-weight: 500;
            }
            .btn-primary {
                background: linear-gradient(45deg, #007bff, #0056b3);
                border: none;
                box-shadow: 0 4px 12px rgba(0,123,255,0.3);
            }
            .btn-primary:hover {
                background: linear-gradient(45deg, #0056b3, #004085);
                transform: translateY(-2px);
                box-shadow: 0 6px 16px rgba(0,123,255,0.4);
            }
        `;
        
        document.head.appendChild(cameraStyles);
        document.body.appendChild(cameraModal);
        
        // Start video stream
        const video = document.getElementById('cameraVideo');
        video.srcObject = stream;
        
        // Store stream for later use
        window.currentCameraStream = stream;
        window.currentFacingMode = 'environment';
        
        // Reset button
        cameraBtn.innerHTML = originalText;
        cameraBtn.disabled = false;
        
        console.log('Camera interface shown with scan-like overlay');
    }
    
    // Capture photo from camera stream
    function capturePhoto() {
        const video = document.getElementById('cameraVideo');
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');
        
        if (!video || !video.videoWidth || !video.videoHeight) {
            console.error('Video not ready for capture');
            showAlert('Kamera belum siap. Silakan tunggu sebentar.', 'warning');
            return;
        }
        
        // Set canvas size to video size
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        
        console.log('Capturing photo from video:', video.videoWidth, 'x', video.videoHeight);
        
        try {
            // Draw video frame to canvas
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            // Convert to blob with high quality
            canvas.toBlob(function(blob) {
                if (blob) {
                    console.log('Photo captured successfully, size:', blob.size, 'bytes');
                    
                    // Create file from blob with timestamp
                    const timestamp = new Date().toISOString().replace(/[:.]/g, '-');
                    const filename = `kegiatan_mengajar_${timestamp}.jpg`;
                    const file = new File([blob], filename, {
                        type: 'image/jpeg',
                        lastModified: Date.now()
                    });
                    
                    console.log('Created file object:', file.name, file.size, file.type);
                    
                    // Set file to input using DataTransfer
                    const fileInput = document.getElementById('lecture_photo');
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    fileInput.files = dataTransfer.files;
                    
                    console.log('File set to input, files count:', fileInput.files.length);
                    
                    // Trigger change event to show preview
                    const changeEvent = new Event('change', { bubbles: true });
                    fileInput.dispatchEvent(changeEvent);
                    
                    // Close camera modal
                    closeCameraModal();
                    
                    showAlert('Foto kegiatan berhasil diambil!', 'success');
                    
                    // Update photo status
                    updatePhotoStatus(file);
                } else {
                    console.error('Failed to create blob from canvas');
                    showAlert('Gagal mengambil foto. Silakan coba lagi.', 'danger');
                }
            }, 'image/jpeg', 0.9); // Higher quality (90%)
            
        } catch (error) {
            console.error('Error capturing photo:', error);
            showAlert('Terjadi kesalahan saat mengambil foto. Silakan coba lagi.', 'danger');
        }
    }
    
    // Update photo status display
    function updatePhotoStatus(file) {
        const photoStatus = document.getElementById('photoStatus');
        const photoPreview = document.getElementById('photoPreview');
        const previewImg = document.getElementById('previewImage');
        const retakeBtn = document.getElementById('retakeBtn');
        
        if (photoStatus && photoPreview && previewImg && retakeBtn) {
            // Show photo preview
            photoPreview.style.display = 'block';
            
            // Create preview URL
            const previewUrl = URL.createObjectURL(file);
            previewImg.src = previewUrl;
            previewImg.alt = 'Preview Foto Kegiatan';
            
            // Update status text
            photoStatus.innerHTML = `
                <i class="fas fa-check-circle text-success me-2"></i>
                Foto berhasil diambil: ${file.name} (${(file.size / 1024).toFixed(1)} KB)
            `;
            photoStatus.className = 'photo-status text-success';
            
            // Show retake button
            retakeBtn.style.display = 'inline-block';
            
            console.log('Photo status updated successfully');
        } else {
            console.error('Photo status elements not found');
        }
    }
    
    // Switch between front and back camera
    function switchCamera() {
        if (window.currentCameraStream) {
            // Stop current stream
            window.currentCameraStream.getTracks().forEach(track => track.stop());
            
            // Try opposite facing mode
            const currentFacingMode = window.currentFacingMode || 'environment';
            const newFacingMode = currentFacingMode === 'environment' ? 'user' : 'environment';
            window.currentFacingMode = newFacingMode;
            
            const constraints = {
                video: { 
                    facingMode: newFacingMode,
                    width: { ideal: 1920, min: 1280 },
                    height: { ideal: 1080, min: 720 }
                },
                audio: false
            };
            
            navigator.mediaDevices.getUserMedia(constraints)
                .then(function(stream) {
                    const video = document.getElementById('cameraVideo');
                    video.srcObject = stream;
                    window.currentCameraStream = stream;
                    console.log('Camera switched to:', newFacingMode);
                    
                    // Update instruction text
                    const instruction = document.querySelector('.scan-instruction');
                    if (instruction) {
                        instruction.textContent = newFacingMode === 'environment' 
                            ? 'Posisikan kegiatan mengajar dalam kotak' 
                            : 'Posisikan wajah dalam kotak';
                    }
                })
                .catch(function(error) {
                    console.error('Failed to switch camera:', error);
                    showAlert('Gagal mengganti kamera.', 'warning');
                });
        }
    }
    
    // Close camera modal
    function closeCameraModal() {
        if (window.currentCameraStream) {
            window.currentCameraStream.getTracks().forEach(track => track.stop());
            window.currentCameraStream = null;
        }
        
        const modal = document.querySelector('.camera-modal');
        if (modal) {
            modal.remove();
        }
        
        console.log('Camera modal closed');
    }
    
    // Camera-only file input (no gallery access)
    function openCameraOnlyFileInput(fileInput, cameraBtn, originalText) {
        console.log('Using camera-only file input (no gallery access)');
        
        // Force camera-only mode
        fileInput.setAttribute('capture', 'environment');
        fileInput.setAttribute('accept', 'image/*');
        
        // Add event listener to prevent gallery access
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                console.log('Photo captured via file input, size:', file.size);
                showAlert('Foto kegiatan berhasil diambil!', 'success');
            }
        });
        
        // Click the input to open camera
        setTimeout(() => {
            fileInput.click();
        }, 100);
        
        // Reset button after delay
        setTimeout(function() {
            cameraBtn.innerHTML = originalText;
            cameraBtn.disabled = false;
        }, 3000);
    }
    
    // Check if device is mobile with better detection
    function isMobileDevice() {
        const userAgent = navigator.userAgent;
        const mobileKeywords = [
            'Android', 'webOS', 'iPhone', 'iPad', 'iPod', 
            'BlackBerry', 'IEMobile', 'Opera Mini', 'Mobile'
        ];
        
        const isMobile = mobileKeywords.some(keyword => 
            userAgent.includes(keyword)
        );
        
        // Additional check for touch capability
        const hasTouch = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
        
        console.log('Mobile detection:', { userAgent, isMobile, hasTouch });
        
        return isMobile || hasTouch;
    }
    
    // Update UI based on device with camera-only focus
    function updateCameraUI() {
        const cameraBtn = document.getElementById('cameraBtn');
        const fileInput = document.getElementById('lecture_photo');
        
        if (!cameraBtn || !fileInput) {
            console.error('Elements not found for UI update');
            return;
        }
        
        const isMobile = isMobileDevice();
        const hasMediaDevices = supportsMediaDevices();
        console.log('Updating UI for device:', { isMobile, hasMediaDevices });
        
        if (isMobile && hasMediaDevices) {
            // Mobile device with camera support - show camera button
            cameraBtn.classList.remove('btn-secondary');
            cameraBtn.classList.add('btn-primary');
            cameraBtn.innerHTML = '<i class="fas fa-camera me-2"></i>Buka Kamera';
            
            // Set initial attributes for mobile camera-only
            fileInput.setAttribute('accept', 'image/*');
            fileInput.setAttribute('capture', 'environment');
        } else if (isMobile) {
            // Mobile device without camera API - show camera button with camera-only fallback
            cameraBtn.classList.remove('btn-secondary');
            cameraBtn.classList.add('btn-primary');
            cameraBtn.innerHTML = '<i class="fas fa-camera me-2"></i>Buka Kamera';
            
            // Set attributes for mobile camera-only fallback
            fileInput.setAttribute('accept', 'image/*');
            fileInput.setAttribute('capture', 'environment');
        } else {
            // Desktop device - show camera button (will use MediaDevices API)
            cameraBtn.classList.remove('btn-secondary');
            cameraBtn.classList.add('btn-primary');
            cameraBtn.innerHTML = '<i class="fas fa-camera me-2"></i>Buka Kamera';
            
            // Set attributes for desktop camera access
            fileInput.setAttribute('accept', 'image/*');
            fileInput.removeAttribute('capture');
        }
    }
    
    // Initialize
    updateCameraUI();
    
    // Add event listener for camera button
    const cameraBtn = document.getElementById('cameraBtn');
    if (cameraBtn) {
        cameraBtn.addEventListener('click', function() {
            console.log('Camera button clicked');
            openCamera();
        });
        console.log('Camera button event listener added');
    } else {
        console.error('Camera button not found');
    }
    
    // Update on resize
    window.addEventListener('resize', function() {
        setTimeout(updateCameraUI, 100);
    });
    
    // Test camera functionality on load
    console.log('=== Camera Functionality Test ===');
    console.log('Device Info:', {
        userAgent: navigator.userAgent,
        platform: navigator.platform,
        vendor: navigator.vendor,
        maxTouchPoints: navigator.maxTouchPoints,
        onTouchStart: 'ontouchstart' in window,
        onTouchMove: 'ontouchmove' in window,
        onTouchEnd: 'ontouchend' in window
    });
    
    console.log('Camera API Support:', {
        hasMediaDevices: supportsMediaDevices(),
        hasGetUserMedia: 'getUserMedia' in navigator,
        hasMediaDevicesGetUserMedia: !!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia),
        hasVideoDevices: !!(navigator.mediaDevices && navigator.mediaDevices.enumerateDevices)
    });
    
    console.log('File Input Support:', {
        hasFileInput: 'File' in window,
        hasFileReader: 'FileReader' in window,
        hasCapture: 'capture' in document.createElement('input'),
        hasAccept: 'accept' in document.createElement('input'),
        hasDataTransfer: 'DataTransfer' in window
    });
    
    console.log('Camera functionality initialized successfully');
    
    // Add manual test button for debugging (only in development)
    if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
        const debugDiv = document.createElement('div');
        debugDiv.innerHTML = `
            <div class="mt-3 p-3 bg-light border rounded">
                <h6>Debug Info (Development Only)</h6>
                <button type="button" class="btn btn-sm btn-outline-info me-2" onclick="testCameraAPI()">
                    Test Camera API
                </button>
                <button type="button" class="btn btn-sm btn-outline-warning me-2" onclick="showDeviceInfo()">
                    Show Device Info
                </button>
                <button type="button" class="btn btn-sm btn-outline-success me-2" onclick="testFileInput()">
                    Test File Input
                </button>
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="testMediaDevices()">
                    Test MediaDevices
                </button>
            </div>
        `;
        document.querySelector('.card-body').appendChild(debugDiv);
        
        // Debug functions
        window.testCameraAPI = function() {
            console.log('=== Testing Camera API ===');
            console.log('MediaDevices support:', supportsMediaDevices());
            console.log('getUserMedia support:', 'getUserMedia' in navigator);
            
            if (supportsMediaDevices()) {
                console.log('Testing MediaDevices API...');
                navigator.mediaDevices.enumerateDevices()
                    .then(devices => {
                        const videoDevices = devices.filter(device => device.kind === 'videoinput');
                        console.log('Video devices found:', videoDevices);
                        
                        if (videoDevices.length > 0) {
                            console.log('Testing camera access...');
                            navigator.mediaDevices.getUserMedia({ video: true, audio: false })
                                .then(stream => {
                                    console.log('Camera access successful!');
                                    stream.getTracks().forEach(track => track.stop());
                                })
                                .catch(error => {
                                    console.error('Camera access failed:', error);
                                });
                        } else {
                            console.log('No video devices found');
                        }
                    })
                    .catch(error => {
                        console.error('Failed to enumerate devices:', error);
                    });
            } else {
                console.log('MediaDevices API not supported');
            }
        };
        
        window.showDeviceInfo = function() {
            const info = {
                'User Agent': navigator.userAgent,
                'Platform': navigator.platform,
                'Is Mobile': isMobileDevice(),
                'Touch Support': 'ontouchstart' in window,
                'MediaDevices Support': supportsMediaDevices(),
                'Camera API': supportsMediaDevices() ? 'Available' : 'Not Available'
            };
            
            let infoText = 'Device Info:\n';
            for (const [key, value] of Object.entries(info)) {
                infoText += key + ': ' + value + '\n';
            }
            
            alert(infoText);
        };
        
        window.testFileInput = function() {
            const fileInput = document.getElementById('lecture_photo');
            console.log('Testing file input...');
            console.log('File input element:', fileInput);
            console.log('Current attributes:', {
                capture: fileInput.getAttribute('capture'),
                accept: fileInput.getAttribute('accept'),
                type: fileInput.type
            });
            fileInput.click();
        };
        
        window.testMediaDevices = function() {
            if (supportsMediaDevices()) {
                console.log('Testing MediaDevices API...');
                navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' }, audio: false })
                    .then(stream => {
                        console.log('Back camera access successful!');
                        showAlert('Back camera test successful!', 'success');
                        stream.getTracks().forEach(track => track.stop());
                    })
                    .catch(error => {
                        console.error('Back camera test failed:', error);
                        showAlert('Back camera test failed: ' + error.message, 'danger');
                    });
            } else {
                showAlert('MediaDevices API not supported', 'warning');
            }
        };
    }
    });
</script>
