<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-calendar-week me-2"></i>
                Laporan Mingguan
            </h1>
            <div>
                <a href="<?= base_url('admin/reports') ?>" class="btn btn-secondary me-2">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali
                </a>
                <a href="<?= base_url('admin/export_weekly_report') ?>?start_date=<?= $start_date ?>&end_date=<?= $end_date ?>" class="btn btn-success">
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
                <form method="GET" action="<?= base_url('admin/weekly_report') ?>" class="row">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $start_date ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $end_date ?>" required>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search me-2"></i>
                            Filter
                        </button>
                        <a href="<?= base_url('admin/weekly_report') ?>" class="btn btn-outline-secondary">
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
                <h4 class="card-title"><?= count($weekly_data) ?></h4>
                <p class="card-text">Total Karyawan</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <i class="fas fa-check-circle fa-2x mb-2"></i>
                <h4 class="card-title">
                    <?= array_sum(array_column($weekly_data, 'present_days')) ?>
                </h4>
                <p class="card-text">Total Kehadiran</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <i class="fas fa-clock fa-2x mb-2"></i>
                <h4 class="card-title">
                    <?= array_sum(array_column($weekly_data, 'late_days')) ?>
                </h4>
                <p class="card-text">Total Keterlambatan</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <i class="fas fa-hourglass-half fa-2x mb-2"></i>
                <h4 class="card-title">
                    <?= round(array_sum(array_column($weekly_data, 'total_hours')), 1) ?>
                </h4>
                <p class="card-text">Total Jam Kerja</p>
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
                    Data Absensi Mingguan
                </h5>
                <small class="text-muted">
                    Periode: <?= date('d/m/Y', strtotime($start_date)) ?> - <?= date('d/m/Y', strtotime($end_date)) ?>
                </small>
            </div>
            <div class="card-body">
                <?php if (empty($weekly_data)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak ada data absensi</h5>
                        <p class="text-muted">Tidak ada data absensi untuk periode yang dipilih.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="weeklyReportTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Departemen</th>
                                    <th>Role</th>
                                    <th>Total Hari</th>
                                    <th>Hadir</th>
                                    <th>Terlambat</th>
                                    <th>Tidak Hadir</th>
                                    <th>Total Jam</th>
                                    <th>Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($weekly_data as $row): ?>
                                    <?php 
                                        $total_days = $row->total_days ?: 0;
                                        $present_days = $row->present_days ?: 0;
                                        $late_days = $row->late_days ?: 0;
                                        $absent_days = $row->absent_days ?: 0;
                                        $total_hours = $row->total_hours ?: 0;
                                        
                                        // Calculate working days in the period
                                        $start = new DateTime($start_date);
                                        $end = new DateTime($end_date);
                                        $working_days = 0;
                                        $current = clone $start;
                                        
                                        while ($current <= $end) {
                                            if ($current->format('N') < 6) { // Monday to Friday
                                                $working_days++;
                                            }
                                            $current->add(new DateInterval('P1D'));
                                        }
                                        
                                        $attendance_percentage = $working_days > 0 ? round(($present_days / $working_days) * 100, 1) : 0;
                                    ?>
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
                                            <span class="badge bg-primary"><?= $total_days ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success"><?= $present_days ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning"><?= $late_days ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-danger"><?= $absent_days ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info"><?= $total_hours ?> jam</span>
                                        </td>
                                        <td>
                                            <?php if ($attendance_percentage >= 90): ?>
                                                <span class="badge bg-success"><?= $attendance_percentage ?>%</span>
                                            <?php elseif ($attendance_percentage >= 75): ?>
                                                <span class="badge bg-warning"><?= $attendance_percentage ?>%</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger"><?= $attendance_percentage ?>%</span>
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

<!-- Chart Section -->
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
                    <i class="fas fa-chart-bar me-2"></i>
                    Perbandingan Departemen
                </h5>
            </div>
            <div class="card-body">
                <canvas id="departmentChart" width="400" height="200"></canvas>
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
                    <?= array_sum(array_column($weekly_data, 'present_days')) ?>,
                    <?= array_sum(array_column($weekly_data, 'late_days')) ?>,
                    <?= array_sum(array_column($weekly_data, 'absent_days')) ?>
                ],
                backgroundColor: [
                    '#28a745',
                    '#ffc107',
                    '#dc3545'
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

    // Department Comparison Chart
    const departmentCtx = document.getElementById('departmentChart').getContext('2d');
    
    // Group data by department
    const departmentData = {};
    <?php foreach ($weekly_data as $row): ?>
        const dept = '<?= $row->department ?: 'N/A' ?>';
        if (!departmentData[dept]) {
            departmentData[dept] = { present: 0, late: 0, absent: 0 };
        }
        departmentData[dept].present += <?= $row->present_days ?: 0 ?>;
        departmentData[dept].late += <?= $row->late_days ?: 0 ?>;
        departmentData[dept].absent += <?= $row->absent_days ?: 0 ?>;
    <?php endforeach; ?>

    const departments = Object.keys(departmentData);
    const presentData = departments.map(dept => departmentData[dept].present);
    const lateData = departments.map(dept => departmentData[dept].late);
    const absentData = departments.map(dept => departmentData[dept].absent);

    const departmentChart = new Chart(departmentCtx, {
        type: 'bar',
        data: {
            labels: departments,
            datasets: [{
                label: 'Hadir',
                data: presentData,
                backgroundColor: '#28a745'
            }, {
                label: 'Terlambat',
                data: lateData,
                backgroundColor: '#ffc107'
            }, {
                label: 'Tidak Hadir',
                data: absentData,
                backgroundColor: '#dc3545'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
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
        $('#weeklyReportTable').DataTable({
            pageLength: 25,
            order: [[4, 'desc']],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
            }
        });
    }
});
</script>
