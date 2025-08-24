<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-history me-2"></i>
                Riwayat Absensi
            </h1>
            <div>
                <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary me-2">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali
                </a>
                <a href="<?= base_url('admin/export_attendance_history') ?>?user_id=<?= $user->id ?>&start_date=<?= $start_date ?>&end_date=<?= $end_date ?>" class="btn btn-success">
                    <i class="fas fa-download me-2"></i>
                    Export CSV
                </a>
            </div>
        </div>
    </div>
</div>

<!-- User Information Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center">
                        <div class="avatar-lg bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto">
                            <i class="fas fa-user fa-3x text-white"></i>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <h5 class="mb-1"><?= $user->full_name ?></h5>
                        <p class="text-muted mb-1">
                            <i class="fas fa-user me-1"></i>
                            <?= $user->username ?> | <?= ucfirst($user->role) ?>
                        </p>
                        <p class="text-muted mb-0">
                            <i class="fas fa-building me-1"></i>
                            <?= $user->department ?: 'N/A' ?>
                        </p>
                    </div>
                    <div class="col-md-3 text-end">
                        <div class="mb-2">
                            <?php if ($user->is_active): ?>
                                <span class="badge bg-success">Aktif</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Nonaktif</span>
                            <?php endif; ?>
                        </div>
                        <div class="text-muted small">
                            Bergabung: <?= date('d/m/Y', strtotime($user->created_at)) ?>
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
                    Filter Riwayat
                </h5>
            </div>
            <div class="card-body">
                <form method="GET" action="<?= base_url('admin/attendance_history') ?>" class="row">
                    <input type="hidden" name="user_id" value="<?= $user->id ?>">
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
                        <a href="<?= base_url('admin/attendance_history?user_id=' . $user->id) ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-refresh me-2"></i>
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Summary Statistics -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <i class="fas fa-calendar-check fa-2x mb-2"></i>
                <h4 class="card-title"><?= $summary->total_days ?? 0 ?></h4>
                <p class="card-text">Total Hari</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <i class="fas fa-check-circle fa-2x mb-2"></i>
                <h4 class="card-title"><?= $summary->present_days ?? 0 ?></h4>
                <p class="card-text">Hadir</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <i class="fas fa-clock fa-2x mb-2"></i>
                <h4 class="card-title"><?= $summary->late_days ?? 0 ?></h4>
                <p class="card-text">Terlambat</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <i class="fas fa-hourglass-half fa-2x mb-2"></i>
                <h4 class="card-title"><?= round($summary->total_hours ?? 0, 1) ?></h4>
                <p class="card-text">Total Jam</p>
            </div>
        </div>
    </div>
</div>

<!-- Performance Summary -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-pie me-2"></i>
                    Ringkasan Performa
                </h5>
            </div>
            <div class="card-body">
                <?php 
                    $total_days = $summary->total_days ?? 0;
                    $present_days = $summary->present_days ?? 0;
                    $late_days = $summary->late_days ?? 0;
                    $absent_days = $total_days - $present_days - $late_days;
                    
                    $attendance_rate = $total_days > 0 ? round(($present_days / $total_days) * 100, 1) : 0;
                    $punctuality_rate = $total_days > 0 ? round((($present_days + $late_days) / $total_days) * 100, 1) : 0;
                    $average_hours = $total_days > 0 ? round(($summary->total_hours ?? 0) / $total_days, 1) : 0;
                ?>
                
                <div class="row text-center mb-3">
                    <div class="col-4">
                        <div class="h4 text-primary"><?= $attendance_rate ?>%</div>
                        <small class="text-muted">Kehadiran</small>
                    </div>
                    <div class="col-4">
                        <div class="h4 text-success"><?= $punctuality_rate ?>%</div>
                        <small class="text-muted">Ketepatan</small>
                    </div>
                    <div class="col-4">
                        <div class="h4 text-info"><?= $average_hours ?> jam</div>
                        <small class="text-muted">Rata-rata</small>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Distribusi Kehadiran:</strong></label>
                    <?php if ($total_days > 0): ?>
                        <div class="progress mb-2" style="height: 20px;">
                            <div class="progress-bar bg-success" style="width: <?= $attendance_rate ?>%">
                                Hadir: <?= $present_days ?>
                            </div>
                        </div>
                        <div class="progress mb-2" style="height: 20px;">
                            <div class="progress-bar bg-warning" style="width: <?= ($late_days / $total_days) * 100 ?>%">
                                Terlambat: <?= $late_days ?>
                            </div>
                        </div>
                        <div class="progress mb-2" style="height: 20px;">
                            <div class="progress-bar bg-danger" style="width: <?= ($absent_days / $total_days) * 100 ?>%">
                                Tidak Hadir: <?= $absent_days ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Tidak ada data untuk ditampilkan</p>
                    <?php endif; ?>
                </div>
                
                <div class="text-center">
                    <?php if ($attendance_rate >= 90): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-star me-2"></i>
                            <strong>Excellent!</strong> Tingkat kehadiran sangat baik.
                        </div>
                    <?php elseif ($attendance_rate >= 80): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-thumbs-up me-2"></i>
                            <strong>Good!</strong> Tingkat kehadiran baik.
                        </div>
                    <?php elseif ($attendance_rate >= 70): ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Fair!</strong> Tingkat kehadiran cukup.
                        </div>
                    <?php else: ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Poor!</strong> Tingkat kehadiran perlu ditingkatkan.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-clock me-2"></i>
                    Analisis Waktu
                </h5>
            </div>
            <div class="card-body">
                <?php 
                    $early_birds = 0;
                    $on_time = 0;
                    $late_comers = 0;
                    $very_late = 0;
                    
                    if (!empty($attendance_history)) {
                        foreach ($attendance_history as $record) {
                            if ($record->check_in) {
                                $check_in_time = date('H:i', strtotime($record->check_in));
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
                
                <hr>
                
                <div class="text-center">
                    <h6 class="text-primary">Jam Kerja Rata-rata</h6>
                    <div class="h3 text-info"><?= $average_hours ?> jam</div>
                    <small class="text-muted">per hari kerja</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Attendance History Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-table me-2"></i>
                    Riwayat Absensi Detail
                </h5>
                <small class="text-muted">
                    Periode: <?= date('d/m/Y', strtotime($start_date)) ?> - <?= date('d/m/Y', strtotime($end_date)) ?>
                </small>
            </div>
            <div class="card-body">
                <?php if (empty($attendance_history)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak ada data absensi</h5>
                        <p class="text-muted">Tidak ada data absensi untuk periode yang dipilih.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="attendanceHistoryTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Hari</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                    <th>Jam Kerja</th>
                                    <th>Status</th>
                                    <th>Lokasi</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($attendance_history as $record): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <strong><?= date('d/m/Y', strtotime($record->created_at)) ?></strong>
                                        </td>
                                        <td>
                                            <?= date('l', strtotime($record->created_at)) ?>
                                        </td>
                                        <td>
                                            <?php if ($record->check_in): ?>
                                                <span class="badge bg-success">
                                                    <?= date('H:i', strtotime($record->check_in)) ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($record->check_out): ?>
                                                <span class="badge bg-info">
                                                    <?= date('H:i', strtotime($record->check_out)) ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-warning">Belum Pulang</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($record->work_hours): ?>
                                                <span class="badge bg-primary">
                                                    <?= $record->work_hours ?> jam
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php 
                                                $status_class = 'bg-secondary';
                                                $status_text = 'Unknown';
                                                
                                                switch ($record->status) {
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
                                            <small class="text-muted"><?= $record->location ?: 'N/A' ?></small>
                                        </td>
                                        <td>
                                            <?php if ($record->check_in): ?>
                                                <?php 
                                                    $check_in_time = date('H:i', strtotime($record->check_in));
                                                    if ($check_in_time <= '07:30') {
                                                        echo '<span class="badge bg-success">Datang Awal</span>';
                                                    } elseif ($check_in_time <= '08:15') {
                                                        echo '<span class="badge bg-primary">Tepat Waktu</span>';
                                                    } elseif ($check_in_time <= '08:45') {
                                                        echo '<span class="badge bg-warning">Terlambat</span>';
                                                    } else {
                                                        echo '<span class="badge bg-danger">Terlambat</span>';
                                                    }
                                                ?>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
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
                    Distribusi Kehadiran
                </h5>
            </div>
            <div class="card-body">
                <canvas id="attendanceChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    Trend Kehadiran
                </h5>
            </div>
            <div class="card-body">
                <canvas id="trendChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Attendance Distribution Chart
    const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
    
    const attendanceChart = new Chart(attendanceCtx, {
        type: 'doughnut',
        data: {
            labels: ['Hadir', 'Terlambat', 'Tidak Hadir'],
            datasets: [{
                data: [
                    <?= $summary->present_days ?? 0 ?>,
                    <?= $summary->late_days ?? 0 ?>,
                    <?= ($summary->total_days ?? 0) - ($summary->present_days ?? 0) - ($summary->late_days ?? 0) ?>
                ],
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

    // Trend Chart
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    
    // Group by date for trend
    const dateData = {};
    <?php if (!empty($attendance_history)): ?>
        <?php foreach ($attendance_history as $record): ?>
            const date = '<?= date('d/m', strtotime($record->created_at)) ?>';
            if (!dateData[date]) {
                dateData[date] = { present: 0, late: 0, absent: 0 };
            }
            if ('<?= $record->status ?>' === 'present') {
                dateData[date].present++;
            } else if ('<?= $record->status ?>' === 'late') {
                dateData[date].late++;
            } else {
                dateData[date].absent++;
            }
        <?php endforeach; ?>
    <?php endif; ?>
    
    const trendLabels = Object.keys(dateData);
    const presentData = trendLabels.map(date => dateData[date].present);
    const lateData = trendLabels.map(date => dateData[date].late);
    const absentData = trendLabels.map(date => dateData[date].absent);
    
    const trendChart = new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: trendLabels,
            datasets: [{
                label: 'Hadir',
                data: presentData,
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Terlambat',
                data: lateData,
                borderColor: '#ffc107',
                backgroundColor: 'rgba(255, 193, 7, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Tidak Hadir',
                data: absentData,
                borderColor: '#dc3545',
                backgroundColor: 'rgba(220, 53, 69, 0.1)',
                tension: 0.4,
                fill: true
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
                    position: 'top'
                }
            }
        }
    });

    // Initialize DataTable
    if (typeof $.fn.DataTable !== 'undefined') {
        $('#attendanceHistoryTable').DataTable({
            pageLength: 25,
            order: [[1, 'desc'], [3, 'asc']], // Sort by date, then check-in time
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
            }
        });
    }
});
</script>
