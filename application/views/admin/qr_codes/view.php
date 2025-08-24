 <div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-eye me-2"></i>
                Detail QR Code
            </h1>
            <div>
                <a href="<?= base_url('admin/edit_qr_code/' . $qr_code->id) ?>" class="btn btn-primary me-2">
                    <i class="fas fa-edit me-2"></i>
                    Edit
                </a>
                <a href="<?= base_url('admin/qr_codes') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- QR Code Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informasi QR Code
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="150"><strong>ID:</strong></td>
                                <td><span class="badge bg-secondary"><?= $qr_code->id ?></span></td>
                            </tr>
                            <tr>
                                <td><strong>Kode:</strong></td>
                                <td><span class="badge bg-primary"><?= $qr_code->code ?></span></td>
                            </tr>
                            <tr>
                                <td><strong>Nama:</strong></td>
                                <td><strong><?= $qr_code->name ?></strong></td>
                            </tr>
                            <tr>
                                <td><strong>Lokasi:</strong></td>
                                <td><span class="badge bg-info"><?= $qr_code->location ?: 'N/A' ?></span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="150"><strong>Status:</strong></td>
                                <td>
                                    <?php if ($qr_code->is_active): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Tipe:</strong></td>
                                <td>
                                    <?php 
                                        $type_class = 'bg-secondary';
                                        $type_text = 'Unknown';
                                        
                                        // Check if qr_type field exists, otherwise use default
                                        if (isset($qr_code->qr_type) && $qr_code->qr_type) {
                                            switch ($qr_code->qr_type) {
                                                case 'attendance':
                                                    $type_class = 'bg-success';
                                                    $type_text = 'Absensi';
                                                    break;
                                                case 'checkpoint':
                                                    $type_class = 'bg-info';
                                                    $type_text = 'Checkpoint';
                                                    break;
                                                case 'access':
                                                    $type_class = 'bg-warning';
                                                    $type_text = 'Akses';
                                                    break;
                                                case 'information':
                                                    $type_class = 'bg-primary';
                                                    $type_text = 'Informasi';
                                                    break;
                                            }
                                        } else {
                                            $type_class = 'bg-primary';
                                            $type_text = 'Absensi';
                                        }
                                    ?>
                                    <span class="badge <?= $type_class ?>"><?= $type_text ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Masa Berlaku:</strong></td>
                                <td>
                                    <?php 
                                        $validity_class = 'bg-success';
                                        $validity_text = 'Tidak Terbatas';
                                        
                                        // Check if validity_period field exists, otherwise use default
                                        if (isset($qr_code->validity_period) && $qr_code->validity_period) {
                                            switch ($qr_code->validity_period) {
                                                case 'daily':
                                                    $validity_class = 'bg-warning';
                                                    $validity_text = 'Harian';
                                                    break;
                                                case 'weekly':
                                                    $validity_class = 'bg-info';
                                                    $validity_text = 'Mingguan';
                                                    break;
                                                case 'monthly':
                                                    $validity_class = 'bg-primary';
                                                    $validity_text = 'Bulanan';
                                                    break;
                                                case 'yearly':
                                                    $validity_class = 'bg-secondary';
                                                    $validity_text = 'Tahunan';
                                                    break;
                                            }
                                        }
                                    ?>
                                    <span class="badge <?= $validity_class ?>"><?= $validity_text ?></span>
                                </td>
                            </tr>
                            <tr>
                                <!-- <td><strong>Dibuat Oleh:</strong></td>
                                <td><?= $qr_code->created_by ? ($qr_code->created_by_name ?: 'Admin') : 'System' ?></td> -->
                            </tr>
                        </table>
                    </div>
                </div>
                
                <?php if ($qr_code->description): ?>
                    <hr>
                    <div class="mb-3">
                        <label class="form-label"><strong>Deskripsi:</strong></label>
                        <div class="p-3 bg-light rounded">
                            <?= nl2br($qr_code->description) ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><strong>Tanggal Mulai Berlaku:</strong></label>
                            <div class="p-2 bg-light rounded">
                                <?= (isset($qr_code->start_date) && $qr_code->start_date) ? date('d/m/Y', strtotime($qr_code->start_date)) : 'Tidak ditentukan' ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><strong>Tanggal Berakhir:</strong></label>
                            <div class="p-2 bg-light rounded">
                                <?= (isset($qr_code->end_date) && $qr_code->end_date) ? date('d/m/Y', strtotime($qr_code->end_date)) : 'Tidak terbatas' ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><strong>Tanggal Dibuat:</strong></label>
                            <div class="p-2 bg-light rounded">
                                <?= date('d/m/Y H:i:s', strtotime($qr_code->created_at)) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><strong>Terakhir Diupdate:</strong></label>
                            <div class="p-2 bg-light rounded">
                                <?= $qr_code->updated_at ? date('d/m/Y H:i:s', strtotime($qr_code->updated_at)) : 'Belum pernah diupdate' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Usage Statistics -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    Statistik Penggunaan
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3 mb-3">
                        <div class="h4 text-primary"><?= $usage_stats->total_scans ?? 0 ?></div>
                        <small class="text-muted">Total Scan</small>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="h4 text-success"><?= $usage_stats->unique_users ?? 0 ?></div>
                        <small class="text-muted">Pengguna Unik</small>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="h4 text-info"><?= $usage_stats->today_scans ?? 0 ?></div>
                        <small class="text-muted">Scan Hari Ini</small>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="h4 text-warning"><?= $usage_stats->this_week_scans ?? 0 ?></div>
                        <small class="text-muted">Scan Minggu Ini</small>
                    </div>
                </div>
                
                <?php if (isset($usage_stats->last_scan)): ?>
                    <hr>
                    <div class="text-center">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            Scan terakhir: <?= date('d/m/Y H:i:s', strtotime($usage_stats->last_scan)) ?>
                        </small>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Recent Usage -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-history me-2"></i>
                    Penggunaan Terbaru
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($recent_usage)): ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Pengguna</th>
                                    <th>Waktu</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_usage as $usage): ?>
                                    <tr>
                                        <td><?= date('d/m/Y', strtotime($usage->created_at)) ?></td>
                                        <td>
                                            <strong><?= $usage->full_name ?></strong>
                                            <br>
                                            <small class="text-muted"><?= $usage->username ?></small>
                                        </td>
                                        <td><?= date('H:i:s', strtotime($usage->created_at)) ?></td>
                                        <td>
                                            <?php if ($usage->status == 'present'): ?>
                                                <span class="badge bg-success">Hadir</span>
                                            <?php elseif ($usage->status == 'late'): ?>
                                                <span class="badge bg-warning">Terlambat</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary"><?= ucfirst($usage->status) ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="text-center mt-3">
                        <a href="<?= base_url('admin/qr_code_usage/' . $qr_code->id) ?>" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-chart-bar me-2"></i>
                            Lihat Semua Riwayat
                        </a>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-2x text-muted mb-3"></i>
                        <h6 class="text-muted">Belum ada penggunaan</h6>
                        <p class="text-muted">QR Code ini belum pernah digunakan</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- QR Code Preview -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-qrcode me-2"></i>
                    Preview QR Code
                </h5>
            </div>
            <div class="card-body text-center">
                <div class="qr-code-preview mb-3">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=<?= urlencode($qr_code->code) ?>" 
                         alt="QR Code" 
                         class="img-fluid"
                         style="max-width: 250px;">
                </div>
                <div class="mb-3">
                    <strong class="text-primary"><?= $qr_code->code ?></strong>
                </div>
                <div class="mb-3">
                    <a href="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=<?= urlencode($qr_code->code) ?>" 
                       class="btn btn-outline-primary btn-sm me-2"
                       target="_blank"
                       download="qr_code_<?= $qr_code->code ?>.png">
                        <i class="fas fa-download me-2"></i>
                        Download
                    </a>
                    <button type="button" 
                            class="btn btn-outline-info btn-sm"
                            onclick="copyQRCode('<?= $qr_code->code ?>')">
                        <i class="fas fa-copy me-2"></i>
                        Copy Kode
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    Aksi Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <?php if ($qr_code->is_active): ?>
                        <a href="<?= base_url('admin/toggle_qr_code_status/' . $qr_code->id . '/0') ?>" 
                           class="btn btn-outline-warning btn-sm"
                           onclick="return confirm('Apakah Anda yakin ingin menonaktifkan QR Code ini?')">
                            <i class="fas fa-ban me-2"></i>
                            Nonaktifkan
                        </a>
                    <?php else: ?>
                        <a href="<?= base_url('admin/toggle_qr_code_status/' . $qr_code->id . '/1') ?>" 
                           class="btn btn-outline-success btn-sm"
                           onclick="return confirm('Apakah Anda yakin ingin mengaktifkan QR Code ini?')">
                            <i class="fas fa-check me-2"></i>
                            Aktifkan
                        </a>
                    <?php endif; ?>
                    
                    <a href="<?= base_url('admin/duplicate_qr_code/' . $qr_code->id) ?>" 
                       class="btn btn-outline-info btn-sm">
                        <i class="fas fa-copy me-2"></i>
                        Duplikat
                    </a>
                    
                    <button type="button" 
                            class="btn btn-outline-danger btn-sm"
                            onclick="deleteQRCode(<?= $qr_code->id ?>, '<?= $qr_code->name ?>')">
                        <i class="fas fa-trash me-2"></i>
                        Hapus
                    </button>
                </div>
            </div>
        </div>
        
        <!-- QR Code Status -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-shield-alt me-2"></i>
                    Status QR Code
                </h5>
            </div>
            <div class="card-body">
                <?php 
                    $current_date = date('Y-m-d');
                    $is_expired = false;
                    $is_not_started = false;
                    
                    // Check if end_date field exists and is not null
                    if (isset($qr_code->end_date) && $qr_code->end_date && $current_date > $qr_code->end_date) {
                        $is_expired = true;
                    }
                    
                    // Check if start_date field exists and is not null
                    if (isset($qr_code->start_date) && $qr_code->start_date && $current_date < $qr_code->start_date) {
                        $is_not_started = true;
                    }
                ?>
                
                <div class="mb-3">
                    <strong>Status Aktif:</strong>
                    <?php if ($qr_code->is_active): ?>
                        <span class="badge bg-success">Aktif</span>
                    <?php else: ?>
                        <span class="badge bg-danger">Nonaktif</span>
                    <?php endif; ?>
                </div>
                
                <div class="mb-3">
                    <strong>Validitas:</strong>
                    <?php if ($is_expired): ?>
                        <span class="badge bg-danger">Kadaluarsa</span>
                    <?php elseif ($is_not_started): ?>
                        <span class="badge bg-warning">Belum Berlaku</span>
                    <?php else: ?>
                        <span class="badge bg-success">Berlaku</span>
                    <?php endif; ?>
                </div>
                
                <?php if ($is_expired): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>QR Code telah kadaluarsa!</strong><br>
                        Tanggal berakhir: <?= date('d/m/Y', strtotime($qr_code->end_date)) ?>
                    </div>
                <?php elseif ($is_not_started): ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-clock me-2"></i>
                        <strong>QR Code belum berlaku!</strong><br>
                        Mulai berlaku: <?= date('d/m/Y', strtotime($qr_code->start_date)) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
// Copy QR code to clipboard
function copyQRCode(code) {
    navigator.clipboard.writeText(code).then(function() {
        // Show success message
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
        button.classList.remove('btn-outline-info');
        button.classList.add('btn-success');
        
        setTimeout(function() {
            button.innerHTML = originalText;
            button.classList.remove('btn-success');
            button.classList.add('btn-outline-info');
        }, 2000);
    }).catch(function(err) {
        console.error('Could not copy text: ', err);
        alert('Gagal menyalin kode QR');
    });
}

// Delete QR code confirmation
function deleteQRCode(qrId, qrName) {
    if (confirm(`Apakah Anda yakin ingin menghapus QR Code "${qrName}"?\n\nTindakan ini tidak dapat dibatalkan!`)) {
        window.location.href = `<?= base_url('admin/delete_qr_code/') ?>${qrId}`;
    }
}
</script>
