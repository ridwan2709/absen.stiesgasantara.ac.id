<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-qrcode me-2"></i>
                Manajemen QR Code
            </h1>
            <a href="<?= base_url('admin/add_qr_code') ?>" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Tambah QR Code
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-list me-2"></i>
            Daftar QR Code
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>QR Code</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Dibuat Oleh</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($qr_codes)): ?>
                        <?php foreach ($qr_codes as $index => $qr): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="qr-code-preview me-3">
                                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=50x50&data=<?= urlencode($qr->code) ?>" 
                                                 alt="QR Code" 
                                                 class="img-fluid"
                                                 style="max-width: 50px;">
                                        </div>
                                        <div>
                                            <div class="fw-bold"><?= $qr->code ?></div>
                                            <small class="text-muted">ID: <?= $qr->id ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <strong><?= $qr->name ?></strong>
                                </td>
                                <td>
                                    <?php if ($qr->description): ?>
                                        <span class="text-muted"><?= $qr->description ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?= $qr->location ?: 'N/A' ?></span>
                                </td>
                                <td>
                                    <?php if ($qr->is_active): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($qr->created_by): ?>
                                        <span class="text-muted"><?= $qr->created_by_name ?: 'Admin' ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">System</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="fw-bold"><?= date('d/m/Y', strtotime($qr->created_at)) ?></div>
                                    <small class="text-muted"><?= date('H:i', strtotime($qr->created_at)) ?></small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('admin/edit_qr_code/' . $qr->id) ?>" 
                                           class="btn btn-sm btn-outline-primary" 
                                           data-bs-toggle="tooltip" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <a href="<?= base_url('admin/view_qr_code/' . $qr->id) ?>" 
                                           class="btn btn-sm btn-outline-info" 
                                           data-bs-toggle="tooltip" 
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <?php if ($qr->is_active): ?>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-warning" 
                                                    onclick="toggleQRStatus(<?= $qr->id ?>, 0)"
                                                    data-bs-toggle="tooltip" 
                                                    title="Nonaktifkan">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        <?php else: ?>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-success" 
                                                    onclick="toggleQRStatus(<?= $qr->id ?>, 1)"
                                                    data-bs-toggle="tooltip" 
                                                    title="Aktifkan">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        <?php endif; ?>
                                        
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                onclick="deleteQRCode(<?= $qr->id ?>, '<?= $qr->name ?>')"
                                                data-bs-toggle="tooltip" 
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="fas fa-qrcode fa-2x mb-3"></i>
                                <div>Belum ada data QR Code</div>
                                <small class="text-muted">Klik tombol "Tambah QR Code" untuk membuat QR Code pertama</small>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- QR Code Statistics -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <i class="fas fa-qrcode fa-2x mb-2"></i>
                <h4 class="card-title"><?= count($qr_codes) ?></h4>
                <p class="card-text">Total QR Code</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <i class="fas fa-check-circle fa-2x mb-2"></i>
                <h4 class="card-title">
                    <?= count(array_filter($qr_codes, function($qr) { return $qr->is_active; })) ?>
                </h4>
                <p class="card-text">QR Code Aktif</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <i class="fas fa-ban fa-2x mb-2"></i>
                <h4 class="card-title">
                    <?= count(array_filter($qr_codes, function($qr) { return !$qr->is_active; })) ?>
                </h4>
                <p class="card-text">QR Code Nonaktif</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <i class="fas fa-map-marker-alt fa-2x mb-2"></i>
                <h4 class="card-title">
                    <?= count(array_unique(array_column($qr_codes, 'location'))) ?>
                </h4>
                <p class="card-text">Lokasi Unik</p>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle QR code status
function toggleQRStatus(qrId, status) {
    const action = status ? 'mengaktifkan' : 'menonaktifkan';
    const qrName = event.target.closest('tr').querySelector('td:nth-child(3) strong').textContent;
    
    if (confirm(`Apakah Anda yakin ingin ${action} QR Code "${qrName}"?`)) {
        window.location.href = `<?= base_url('admin/toggle_qr_code_status/') ?>${qrId}/${status}`;
    }
}

// Delete QR code
function deleteQRCode(qrId, qrName) {
    if (confirm(`Apakah Anda yakin ingin menghapus QR Code "${qrName}"?\n\nTindakan ini tidak dapat dibatalkan!`)) {
        window.location.href = `<?= base_url('admin/delete_qr_code/') ?>${qrId}`;
    }
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
