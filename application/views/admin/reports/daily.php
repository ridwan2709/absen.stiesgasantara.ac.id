<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-calendar-day me-2"></i>
                Laporan Harian
            </h1>
            <div>
                <a href="<?= base_url('admin/reports') ?>" class="btn btn-secondary me-2">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali
                </a>
                <a href="<?= base_url('admin/export_daily_report') ?>?date=<?= $date ?>" class="btn btn-success">
                    <i class="fas fa-download me-2"></i>
                    Export CSV
                </a>
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
                    Filter Laporan
                </h5>
            </div>
            <div class="card-body">
                <form method="GET" action="<?= base_url('admin/daily_report') ?>" class="row">
                    <div class="col-md-6">
                        <label for="date" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="date" name="date" value="<?= $date ?>" required>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search me-2"></i>
                            Filter
                        </button>
                        <a href="<?= base_url('admin/daily_report') ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-refresh me-2"></i>
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <i class="fas fa-users fa-2x mb-2"></i>
                <h4 class="card-title"><?= $summary->total_users ?? 0 ?></h4>
                <p class="card-text">Total Karyawan</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <i class="fas fa-check-circle fa-2x mb-2"></i>
                <h4 class="card-title"><?= $summary->present_users ?? 0 ?></h4>
                <p class="card-text">Hadir</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <i class="fas fa-clock fa-2x mb-2"></i>
                <h4 class="card-title"><?= $summary->late_users ?? 0 ?></h4>
                <p class="card-text">Terlambat</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body text-center">
                <i class="fas fa-times-circle fa-2x mb-2"></i>
                <h4 class="card-title"><?= ($summary->total_users ?? 0) - ($summary->present_users ?? 0) - ($summary->late_users ?? 0) ?></h4>
                <p class="card-text">Tidak Hadir</p>
            </div>
        </div>
    </div>
</div>

<!-- Report Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-table me-2"></i>
                    Data Absensi Harian
                </h5>
                <small class="text-muted">
                    Tanggal: <?= date('d/m/Y', strtotime($date)) ?>
                </small>
            </div>
            <div class="card-body">
                <?php if (empty($daily_data)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak ada data absensi</h5>
                        <p class="text-muted">Tidak ada data absensi untuk tanggal yang dipilih.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="dailyReportTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Departemen</th>
                                    <th>Role</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                    <th>Jam Kerja</th>
                                    <th>Status</th>
                                    <th>Lokasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($daily_data as $row): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <strong><?= $row->full_name ?></strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary"><?= $row->department ?: 'N/A' ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info"><?= ucfirst($row->role) ?></span>
                                        </td>
                                        <td>
                                            <?php if ($row->check_in): ?>
                                                <span class="badge bg-success">
                                                    <?= date('H:i', strtotime($row->check_in)) ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($row->check_out): ?>
                                                <span class="badge bg-info">
                                                    <?= date('H:i', strtotime($row->check_out)) ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-warning">Belum Pulang</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($row->work_hours): ?>
                                                <span class="badge bg-primary">
                                                    <?= $row->work_hours ?> jam
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php 
                                                $status_class = 'bg-secondary';
                                                $status_text = 'Unknown';
                                                
                                                switch ($row->status) {
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
                                            <small class="text-muted"><?= $row->location ?: 'N/A' ?></small>
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

<!-- Department Summary -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-pie me-2"></i>
                    Kehadiran per Departemen
                </h5>
            </div>
            <div class="card-body">
                <?php 
                    $dept_summary = [];
                    foreach ($daily_data as $row) {
                        $dept = $row->department ?: 'N/A';
                        if (!isset($dept_summary[$dept])) {
                            $dept_summary[$dept] = ['total' => 0, 'present' => 0, 'late' => 0, 'absent' => 0];
                        }
                        $dept_summary[$dept]['total']++;
                        
                        if ($row->status == 'present') {
                            $dept_summary[$dept]['present']++;
                        } elseif ($row->status == 'late') {
                            $dept_summary[$dept]['late']++;
                        } else {
                            $dept_summary[$dept]['absent']++;
                        }
                    }
                ?>
                
                <?php foreach ($dept_summary as $dept => $stats): ?>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <strong><?= $dept ?></strong>
                            <span class="badge bg-primary"><?= $stats['total'] ?> orang</span>
                        </div>
                        <div class="progress mb-2" style="height: 8px;">
                            <?php 
                                $present_percent = $stats['total'] > 0 ? ($stats['present'] / $stats['total']) * 100 : 0;
                                $late_percent = $stats['total'] > 0 ? ($stats['late'] / $stats['total']) * 100 : 0;
                                $absent_percent = $stats['total'] > 0 ? ($stats['absent'] / $stats['total']) * 100 : 0;
                            ?>
                            <div class="progress-bar bg-success" style="width: <?= $present_percent ?>%"></div>
                            <div class="progress-bar bg-warning" style="width: <?= $late_percent ?>%"></div>
                            <div class="progress-bar bg-danger" style="width: <?= $absent_percent ?>%"></div>
                        </div>
                        <div class="d-flex justify-content-between small text-muted">
                            <span>Hadir: <?= $stats['present'] ?></span>
                            <span>Terlambat: <?= $stats['late'] ?></span>
                            <span>Tidak Hadir: <?= $stats['absent'] ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-clock me-2"></i>
                    Statistik Waktu
                </h5>
            </div>
            <div class="card-body">
                <?php 
                    $early_birds = 0;
                    $on_time = 0;
                    $late_comers = 0;
                    $very_late = 0;
                    
                    foreach ($daily_data as $row) {
                        if ($row->check_in) {
                            $check_in_time = date('H:i', strtotime($row->check_in));
                            if ($check_in_time <= '07:30') {
                                $early_birds++;
                            } elseif ($check_in_time <= '08:00') {
                                $on_time++;
                            } elseif ($check_in_time <= '08:30') {
                                $late_comers++;
                            } else {
                                $very_late++;
                            }
                        }
                    }
                ?>
                
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="h4 text-success"><?= $early_birds ?></div>
                        <small class="text-muted">Datang Awal (≤07:30)</small>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="h4 text-primary"><?= $on_time ?></div>
                        <small class="text-muted">Tepat Waktu (07:31-08:00)</small>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="h4 text-warning"><?= $late_comers ?></div>
                        <small class="text-muted">Terlambat (08:01-08:30)</small>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="h4 text-danger"><?= $very_late ?></div>
                        <small class="text-muted">Sangat Terlambat (>08:30)</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTable
    if (typeof $.fn.DataTable !== 'undefined') {
        $('#dailyReportTable').DataTable({
            pageLength: 25,
            order: [[4, 'asc']], // Sort by check-in time
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
            }
        });
    }
});
</script>
