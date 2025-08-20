<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-chart-bar me-2"></i>
                Riwayat Penggunaan QR Code
            </h1>
            <div>
                <a href="<?= base_url('admin/view_qr_code/' . $qr_code->id) ?>" class="btn btn-primary me-2">
                    <i class="fas fa-eye me-2"></i>
                    Lihat Detail
                </a>
                <a href="<?= base_url('admin/qr_codes') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<!-- QR Code Info Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=<?= urlencode($qr_code->code) ?>" 
                             alt="QR Code" 
                             class="img-fluid"
                             style="max-width: 100px;">
                    </div>
                    <div class="col-md-7">
                        <h5 class="mb-1"><?= $qr_code->name ?></h5>
                        <p class="text-muted mb-1">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            <?= $qr_code->location ?: 'N/A' ?>
                        </p>
                        <p class="text-muted mb-0">
                            <i class="fas fa-qrcode me-1"></i>
                            Kode: <?= $qr_code->code ?>
                        </p>
                    </div>
                    <div class="col-md-3 text-end">
                        <div class="mb-2">
                            <?php if ($qr_code->is_active): ?>
                                <span class="badge bg-success">Aktif</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Nonaktif</span>
                            <?php endif; ?>
                        </div>
                        <div class="text-muted small">
                            Dibuat: <?= date('d/m/Y', strtotime($qr_code->created_at)) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-filter me-2"></i>
                    Filter Data
                </h5>
            </div>
            <div class="card-body">
                <form method="GET" action="<?= base_url('admin/qr_code_usage/' . $qr_code->id) ?>" class="row">
                    <div class="col-md-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $start_date ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label for="end_date" class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $end_date ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">Semua Status</option>
                            <option value="present" <?= $status == 'present' ? 'selected' : '' ?>>Hadir</option>
                            <option value="late" <?= $status == 'late' ? 'selected' : '' ?>>Terlambat</option>
                            <option value="absent" <?= $status == 'absent' ? 'selected' : '' ?>>Tidak Hadir</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search me-2"></i>
                            Filter
                        </button>
                        <a href="<?= base_url('admin/qr_code_usage/' . $qr_code->id) ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-refresh me-2"></i>
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <i class="fas fa-qrcode fa-2x mb-2"></i>
                <h4 class="card-title"><?= $usage_stats->total_scans ?? 0 ?></h4>
                <p class="card-text">Total Scan</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <i class="fas fa-users fa-2x mb-2"></i>
                <h4 class="card-title"><?= $usage_stats->unique_users ?? 0 ?></h4>
                <p class="card-text">Pengguna Unik</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <i class="fas fa-calendar-day fa-2x mb-2"></i>
                <h4 class="card-title"><?= $usage_stats->today_scans ?? 0 ?></h4>
                <p class="card-text">Scan Hari Ini</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <i class="fas fa-calendar-week fa-2x mb-2"></i>
                <h4 class="card-title"><?= $usage_stats->this_week_scans ?? 0 ?></h4>
                <p class="card-text">Scan Minggu Ini</p>
            </div>
        </div>
    </div>
</div>

<!-- Usage Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-table me-2"></i>
                    Data Penggunaan
                </h5>
                <small class="text-muted">
                    Periode: <?= date('d/m/Y', strtotime($start_date)) ?> - <?= date('d/m/Y', strtotime($end_date)) ?>
                </small>
            </div>
            <div class="card-body">
                <?php if (empty($usage_data)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak ada data penggunaan</h5>
                        <p class="text-muted">Tidak ada data penggunaan untuk periode yang dipilih.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="usageTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Pengguna</th>
                                    <th>Departemen</th>
                                    <th>Waktu Scan</th>
                                    <th>Status</th>
                                    <th>Jam Kerja</th>
                                    <th>Lokasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($usage_data as $usage): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <strong><?= date('d/m/Y', strtotime($usage->created_at)) ?></strong>
                                            <br>
                                            <small class="text-muted"><?= date('l', strtotime($usage->created_at)) ?></small>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold"><?= $usage->full_name ?></div>
                                                    <small class="text-muted"><?= $usage->username ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary"><?= $usage->department ?: 'N/A' ?></span>
                                        </td>
                                        <td>
                                            <div class="fw-bold"><?= date('H:i:s', strtotime($usage->created_at)) ?></div>
                                            <?php if ($usage->check_in): ?>
                                                <small class="text-muted">
                                                    Check-in: <?= date('H:i', strtotime($usage->check_in)) ?>
                                                </small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php 
                                                $status_class = 'bg-secondary';
                                                $status_text = 'Unknown';
                                                
                                                switch ($usage->status) {
                                                    case 'present':
                                                        $status_class = 'bg-success';
                                                        $status_text = 'Hadir';
                                                        break;
                                                    case 'late':
                                                        $status_class = 'bg-warning';
                                                        $status_text = 'Terlambat';
                                                        break;
                                                    case 'absent':
                                                        $status_class = 'bg-danger';
                                                        $status_text = 'Tidak Hadir';
                                                        break;
                                                }
                                            ?>
                                            <span class="badge <?= $status_class ?>"><?= $status_text ?></span>
                                        </td>
                                        <td>
                                            <?php if ($usage->work_hours): ?>
                                                <span class="badge bg-primary">
                                                    <?= $usage->work_hours ?> jam
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <small class="text-muted"><?= $usage->location ?: 'N/A' ?></small>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-pie me-2"></i>
                    Distribusi Status
                </h5>
            </div>
            <div class="card-body">
                <canvas id="statusChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    Penggunaan per Hari
                </h5>
            </div>
            <div class="card-body">
                <canvas id="dailyChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Export Section -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-download me-2"></i>
                    Export Data
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">Export ke CSV</h6>
                        <p class="text-muted">Download data penggunaan dalam format CSV untuk analisis lebih lanjut.</p>
                        <a href="<?= base_url('admin/export_qr_usage') ?>?qr_id=<?= $qr_code->id ?>&start_date=<?= $start_date ?>&end_date=<?= $end_date ?>&status=<?= $status ?>" 
                           class="btn btn-success">
                            <i class="fas fa-download me-2"></i>
                            Export CSV
                        </a>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary">Print Report</h6>
                        <p class="text-muted">Cetak laporan penggunaan QR Code untuk dokumentasi.</p>
                        <button type="button" class="btn btn-primary" onclick="window.print()">
                            <i class="fas fa-print me-2"></i>
                            Print Report
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Status Distribution Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    
    // Count status occurrences
    const statusCounts = {};
    <?php foreach ($usage_data as $usage): ?>
        const status = '<?= $usage->status ?>';
        statusCounts[status] = (statusCounts[status] || 0) + 1;
    <?php endforeach; ?>
    
    const statusLabels = Object.keys(statusCounts).map(status => {
        switch(status) {
            case 'present': return 'Hadir';
            case 'late': return 'Terlambat';
            case 'absent': return 'Tidak Hadir';
            default: return status;
        }
    });
    const statusData = Object.values(statusCounts);
    
    const statusChart = new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusData,
                backgroundColor: [
                    '#28a745', // Success (Hadir)
                    '#ffc107', // Warning (Terlambat)
                    '#dc3545'  // Danger (Tidak Hadir)
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Daily Usage Chart
    const dailyCtx = document.getElementById('dailyChart').getContext('2d');
    
    // Group by date
    const dailyCounts = {};
    <?php foreach ($usage_data as $usage): ?>
        const date = '<?= date('d/m', strtotime($usage->created_at)) ?>';
        dailyCounts[date] = (dailyCounts[date] || 0) + 1;
    <?php endforeach; ?>
    
    const dailyLabels = Object.keys(dailyCounts);
    const dailyData = Object.values(dailyCounts);
    
    const dailyChart = new Chart(dailyCtx, {
        type: 'bar',
        data: {
            labels: dailyLabels,
            datasets: [{
                label: 'Jumlah Scan',
                data: dailyData,
                backgroundColor: '#007bff',
                borderColor: '#0056b3',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Initialize DataTable
    if (typeof $.fn.DataTable !== 'undefined') {
        $('#usageTable').DataTable({
            pageLength: 25,
            order: [[1, 'desc'], [4, 'desc']], // Sort by date, then time
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
            }
        });
    }
});
</script>
