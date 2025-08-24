<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-qrcode me-2"></i>
                Scan QR Code
            </h1>
            <div class="text-muted">
                <i class="fas fa-clock me-2"></i>
                <?= date('l, d F Y H:i') ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-camera me-2"></i>
                    Scanner Kamera
                </h5>
            </div>
            <div class="card-body">
                <div id="qr-reader" style="width: 100%; height: 400px;"></div>
                <div id="qr-reader-results" class="mt-3"></div>
                
                <div class="text-center mt-3">
                    <button class="btn btn-primary" id="startScanner">
                        <i class="fas fa-play me-2"></i>
                        Mulai Scanner
                    </button>
                    <button class="btn btn-secondary" id="stopScanner" style="display: none;">
                        <i class="fas fa-stop me-2"></i>
                        Stop Scanner
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Status Absensi Hari Ini
                </h5>
            </div>
            <div class="card-body">
                <?php if ($this->session->userdata('role') == 'dosen'): ?>
                    <!-- Lecturer specific status -->
                    <div class="alert alert-info">
                        <h6 class="alert-heading">
                            <i class="fas fa-chalkboard-teacher me-2"></i>
                            Mode Dosen
                        </h6>
                        <p class="mb-0">
                            Scan QR code untuk absensi mengajar. Anda akan diminta mengisi detail mata kuliah dan kelas setelah scan.
                        </p>
                    </div>
                    
                    <!-- Show today's teaching sessions if any -->
                    <?php 
                    $today_lectures = $this->Attendance_model->get_lecturer_attendance_history(
                        $this->session->userdata('user_id'), 
                        date('Y-m-d'), 
                        date('Y-m-d')
                    );
                    ?>
                    
                    <?php if (!empty($today_lectures)): ?>
                        <div class="card border-success">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-check-circle me-2"></i>
                                    Absensi Mengajar Hari Ini
                                </h6>
                            </div>
                            <div class="card-body">
                                <?php foreach ($today_lectures as $lecture): ?>
                                    <div class="border rounded p-2 mb-2">
                                        <div class="row">
                                            <div class="col-8">
                                                <strong><?= $lecture->subject ?></strong><br>
                                                <small class="text-muted">Kelas: <?= $lecture->class_name ?></small>
                                            </div>
                                            <div class="col-4 text-end">
                                                <small class="text-success">
                                                    <?= date('H:i', strtotime($lecture->check_in)) ?>
                                                </small>
                                            </div>
                                        </div>
                                        <?php if ($lecture->lecture_notes): ?>
                                            <small class="text-muted d-block mt-1">
                                                <i class="fas fa-sticky-note me-1"></i>
                                                <?= $lecture->lecture_notes ?>
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                <?php else: ?>
                    <!-- Staff specific status -->
                    <?php if ($today_attendance): ?>
                        <?php if ($today_attendance->check_in && !$today_attendance->check_out): ?>
                            <div class="alert alert-success">
                                <h6 class="alert-heading">
                                    <i class="fas fa-check-circle me-2"></i>
                                    Sudah Absen Masuk
                                </h6>
                                <p class="mb-2">
                                    <strong>Waktu Masuk:</strong><br>
                                    <?= date('H:i', strtotime($today_attendance->check_in)) ?>
                                </p>
                                <p class="mb-0">
                                    <strong>Status:</strong>
                                    <span class="badge bg-success"><?= ucfirst($today_attendance->status) ?></span>
                                </p>
                            </div>
                            
                            <div class="text-center">
                                <button class="btn btn-warning btn-lg w-100" id="checkOutBtn">
                                    <i class="fas fa-sign-out-alt me-2"></i>
                                    Absen Pulang
                                </button>
                            </div>
                            
                        <?php elseif ($today_attendance->check_in && $today_attendance->check_out): ?>
                            <div class="alert alert-info">
                                <h6 class="alert-heading">
                                    <i class="fas fa-clock me-2"></i>
                                    Absensi Selesai
                                </h6>
                                <p class="mb-2">
                                    <strong>Waktu Masuk:</strong> <?= date('H:i', strtotime($today_attendance->check_in)) ?><br>
                                    <strong>Waktu Pulang:</strong> <?= date('H:i', strtotime($today_attendance->check_out)) ?><br>
                                    <strong>Total Jam:</strong> <?= $today_attendance->work_hours ?> jam
                                </p>
                            </div>
                            
                            <div class="text-center">
                                <div class="alert alert-warning">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Anda telah menyelesaikan absensi hari ini
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <h6 class="alert-heading">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Belum Absen
                            </h6>
                            <p class="mb-0">
                                Anda belum melakukan absensi hari ini. Silakan scan QR code untuk absen masuk.
                            </p>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-qrcode me-2"></i>
                    QR Code Tersedia
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($qr_codes)): ?>
                    <?php foreach ($qr_codes as $qr): ?>
                        <div class="d-flex align-items-center p-2 border rounded mb-2">
                            <div class="flex-shrink-0">
                                <i class="fas fa-qrcode text-primary fa-2x"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1"><?= $qr->name ?></h6>
                                <small class="text-muted">
                                    <?= $qr->location ?: 'Lokasi tidak ditentukan' ?>
                                </small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-qrcode fa-2x mb-2"></i>
                        <div>Tidak ada QR code tersedia</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Manual Input Modal -->
<div class="modal fade" id="manualInputModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-keyboard me-2"></i>
                    Input Manual QR Code
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="manualQRCode" class="form-label">Kode QR Code</label>
                    <input type="text" class="form-control" id="manualQRCode" placeholder="Masukkan kode QR code">
                </div>
                <div class="text-center">
                    <button type="button" class="btn btn-primary" id="submitManualQR">
                        <i class="fas fa-check me-2"></i>
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-check-circle me-2"></i>
                    Absensi Berhasil
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <div class="h1 text-success mb-3">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h4 id="successMessage">Absensi berhasil dicatat!</h4>
                <p class="text-muted" id="successDetails"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery if not already included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include HTML5 QR Code Scanner -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
let html5QrcodeScanner = null;
let isScanning = false;

// Initialize QR Scanner
function initQRScanner() {
    html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader",
        { 
            fps: 10, 
            qrbox: { width: 250, height: 250 },
            aspectRatio: 1.0
        },
        false
    );
    
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
}

// Start scanner
document.getElementById('startScanner').addEventListener('click', function() {
    if (!html5QrcodeScanner) {
        initQRScanner();
    }
    
    this.style.display = 'none';
    document.getElementById('stopScanner').style.display = 'inline-block';
    isScanning = true;
});

// Stop scanner
document.getElementById('stopScanner').addEventListener('click', function() {
    if (html5QrcodeScanner) {
        html5QrcodeScanner.clear();
        html5QrcodeScanner = null;
    }
    
    this.style.display = 'none';
    document.getElementById('startScanner').style.display = 'inline-block';
    isScanning = false;
});

// QR Code scan success
function onScanSuccess(decodedText, decodedResult) {
    if (isScanning) {
        // Stop scanner
        document.getElementById('stopScanner').click();
        
        // Process QR code
        processQRCode(decodedText);
    }
}

// QR Code scan failure
function onScanFailure(error) {
    // Handle scan failure silently
}

// Process QR Code
function processQRCode(qrCode) {
    const userRole = '<?= $this->session->userdata('role') ?>';
    const todayAttendance = <?= json_encode($today_attendance) ?>;
    
    // For lecturers or new attendance, use new process_qr_scan endpoint
    if (userRole === 'dosen' || !todayAttendance) {
        performQRScan(qrCode);
    } else if (todayAttendance) {
        if (todayAttendance.check_in && !todayAttendance.check_out) {
            // Check out for staff
            performCheckOut(qrCode);
        } else if (todayAttendance.check_in && todayAttendance.check_out) {
            showError('Anda telah menyelesaikan absensi hari ini');
        }
    }
}

// Perform QR scan (new unified endpoint)
function performQRScan(qrCode) {
    $.ajax({
        url: '<?= base_url('attendance/process_qr_scan') ?>',
        type: 'POST',
        data: { qr_code: qrCode },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                if (response.redirect) {
                    // Redirect to lecturer form
                    window.location.href = response.redirect;
                } else {
                    // Show success for staff
                    showSuccessModal('Absensi masuk berhasil dicatat!', 
                        'Waktu masuk: ' + response.check_in_time);
                    
                    // Reload page after 2 seconds
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            } else {
                showError(response.message);
            }
        },
        error: function() {
            showError('Terjadi kesalahan pada server. Silakan coba lagi.');
        }
    });
}

// Legacy check in for staff (fallback)
function performCheckIn(qrCode) {
    performQRScan(qrCode);
}

// Perform check out
function performCheckOut(qrCode) {
    $.ajax({
        url: '<?= base_url('attendance/check_out') ?>',
        type: 'POST',
        data: { qr_code: qrCode },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                showSuccessModal('Absensi pulang berhasil dicatat!', 
                    'Waktu pulang: ' + response.check_out_time + '<br>Total jam kerja: ' + response.work_hours + ' jam');
                
                // Reload page after 2 seconds
                setTimeout(function() {
                    location.reload();
                }, 2000);
            } else {
                showError(response.message);
            }
        },
        error: function() {
            console.log('Terjadi kesalahan pada server. Silakan coba lagi.');
        }
    });
}

// Manual check out button
document.getElementById('checkOutBtn').addEventListener('click', function() {
    const qrCode = prompt('Masukkan kode QR code untuk absen pulang:');
    if (qrCode) {
        performCheckOut(qrCode);
    }
});

// Show success modal
function showSuccessModal(message, details) {
    document.getElementById('successMessage').textContent = message;
    document.getElementById('successDetails').innerHTML = details;
    
    const modal = new bootstrap.Modal(document.getElementById('successModal'));
    modal.show();
}

// Show error message
function showError(message) {
    const alertHtml = `
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    document.querySelector('.card-body').insertAdjacentHTML('afterbegin', alertHtml);
    
    // Auto-hide after 5 seconds
    setTimeout(function() {
        const alert = document.querySelector('.alert-danger');
        if (alert) {
            alert.remove();
        }
    }, 5000);
}

// Initialize scanner on page load
document.addEventListener('DOMContentLoaded', function() {
    // Auto-start scanner if no attendance today
    const todayAttendance = <?= json_encode($today_attendance) ?>;
    if (!todayAttendance || (todayAttendance.check_in && !todayAttendance.check_out)) {
        setTimeout(function() {
            document.getElementById('startScanner').click();
        }, 1000);
    }
});

// Handle page visibility change
document.addEventListener('visibilitychange', function() {
    if (document.hidden && isScanning) {
        // Stop scanner when page is hidden
        document.getElementById('stopScanner').click();
    }
});
</script>
