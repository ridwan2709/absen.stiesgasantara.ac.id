<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-clock me-2"></i>
                Manajemen Absensi
            </h1>
            <div>
                <a href="<?= base_url('admin/attendance/manual_entry') ?>" class="btn btn-primary me-2">
                    <i class="fas fa-plus me-2"></i>
                    Input Manual
                </a>
                <a href="<?= base_url('admin/attendance/export') ?>" class="btn btn-success">
                    <i class="fas fa-download me-2"></i>
                    Export Data
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
                    Filter Data Absensi
                </h5>
            </div>
            <div class="card-body">
                <form method="GET" action="<?= base_url('admin/attendance') ?>" class="row">
                    <div class="col-md-2">
                        <label for="date" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="date" name="date" value="<?= $date ?? date('Y-m-d') ?>" required>
                    </div>
                    <div class="col-md-2">
                        <label for="department" class="form-label">Departemen</label>
                        <select class="form-control" id="department" name="department">
                            <option value="">Semua Dept</option>
                            <?php if (!empty($departments)): ?>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?= $dept ?>" <?= ($department ?? '') == $dept ? 'selected' : '' ?>>
                                        <?= $dept ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">Semua Status</option>
                            <option value="present" <?= ($status ?? '') == 'present' ? 'selected' : '' ?>>Hadir</option>
                            <option value="late" <?= ($status ?? '') == 'late' ? 'selected' : '' ?>>Terlambat</option>
                            <option value="absent" <?= ($status ?? '') == 'absent' ? 'selected' : '' ?>>Tidak Hadir</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="user" class="form-label">Pengguna</label>
                        <select class="form-control" id="user" name="user">
                            <option value="">Semua User</option>
                            <?php if (!empty($users)): ?>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user->id ?>" <?= ($selected_user ?? '') == $user->id ? 'selected' : '' ?>>
                                        <?= $user->full_name ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search me-2"></i>
                            Filter
                        </button>
                        <a href="<?= base_url('admin/attendance') ?>" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-refresh me-2"></i>
                            Reset
                        </a>
                        <button type="button" class="btn btn-outline-info" onclick="showAdvancedFilter()">
                            <i class="fas fa-cog me-2"></i>
                            Advanced
                        </button>
                    </div>
                </form>
                
                <!-- Advanced Filter (Hidden by default) -->
                <div id="advancedFilter" class="mt-3" style="display: none;">
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="start_time" class="form-label">Jam Mulai</label>
                            <input type="time" class="form-control" id="start_time" name="start_time" value="<?= $start_time ?? '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="end_time" class="form-label">Jam Akhir</label>
                            <input type="time" class="form-control" id="end_time" name="end_time" value="<?= $end_time ?? '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="min_hours" class="form-label">Min Jam Kerja</label>
                            <input type="number" class="form-control" id="min_hours" name="min_hours" value="<?= $min_hours ?? '' ?>" min="0" step="0.5">
                        </div>
                        <div class="col-md-3">
                            <label for="max_hours" class="form-label">Max Jam Kerja</label>
                            <input type="number" class="form-control" id="max_hours" name="max_hours" value="<?= $max_hours ?? '' ?>" min="0" step="0.5">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Summary Statistics -->
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

<!-- Department Summary -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    Ringkasan per Departemen
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($department_summary)): ?>
                    <div class="row">
                        <?php foreach ($department_summary as $dept => $stats): ?>
                            <div class="col-md-4 mb-3">
                                <div class="card border">
                                    <div class="card-body">
                                        <h6 class="card-title text-primary"><?= $dept ?: 'N/A' ?></h6>
                                        <div class="row text-center">
                                            <div class="col-4">
                                                <div class="h5 text-success"><?= $stats['present'] ?? 0 ?></div>
                                                <small class="text-muted">Hadir</small>
                                            </div>
                                            <div class="col-4">
                                                <div class="h5 text-warning"><?= $stats['late'] ?? 0 ?></div>
                                                <small class="text-muted">Terlambat</small>
                                            </div>
                                            <div class="col-4">
                                                <div class="h5 text-danger"><?= $stats['absent'] ?? 0 ?></div>
                                                <small class="text-muted">Tidak Hadir</small>
                                            </div>
                                        </div>
                                        <?php 
                                            $total = ($stats['present'] ?? 0) + ($stats['late'] ?? 0) + ($stats['absent'] ?? 0);
                                            if ($total > 0):
                                                $present_percent = ($stats['present'] ?? 0) / $total * 100;
                                                $late_percent = ($stats['late'] ?? 0) / $total * 100;
                                                $absent_percent = ($stats['absent'] ?? 0) / $total * 100;
                                        ?>
                                            <div class="progress mt-2" style="height: 8px;">
                                                <div class="progress-bar bg-success" style="width: <?= $present_percent ?>%"></div>
                                                <div class="progress-bar bg-warning" style="width: <?= $late_percent ?>%"></div>
                                                <div class="progress-bar bg-danger" style="width: <?= $absent_percent ?>%"></div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-3">
                        <p class="text-muted">Tidak ada data departemen</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Attendance Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-table me-2"></i>
                    Data Absensi
                </h5>
                <small class="text-muted">
                    Tanggal: <?= date('d/m/Y', strtotime($date ?? date('Y-m-d'))) ?>
                </small>
            </div>
            <div class="card-body">
                <?php if (empty($attendance_data)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak ada data absensi</h5>
                        <p class="text-muted">Tidak ada data absensi untuk tanggal yang dipilih.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="attendanceTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Pengguna</th>
                                    <th>Departemen</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                    <th>Jam Kerja</th>
                                    <th>Status</th>
                                    <th>Lokasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($attendance_data as $record): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold"><?= $record->full_name ?? 'N/A' ?></div>
                                                    <small class="text-muted"><?= $record->username ?? 'N/A' ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary"><?= $record->department ?: 'N/A' ?></span>
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
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('admin/attendance_history?user_id=' . ($record->user_id ?? 0)) ?>" 
                                                   class="btn btn-sm btn-outline-info" 
                                                   data-bs-toggle="tooltip" 
                                                   title="Lihat Riwayat">
                                                    <i class="fas fa-history"></i>
                                                </a>
                                                <a href="<?= base_url('admin/edit_attendance/' . ($record->id ?? 0)) ?>" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   data-bs-toggle="tooltip" 
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        onclick="deleteAttendance(<?= $record->id ?? 0 ?>, '<?= $record->full_name ?? 'Unknown' ?>')"
                                                        data-bs-toggle="tooltip" 
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
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

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    Aksi Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <a href="<?= base_url('admin/attendance/manual_entry') ?>" class="btn btn-outline-primary w-100 mb-2">
                            <i class="fas fa-plus me-2"></i>
                            Input Manual
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="<?= base_url('admin/attendance/bulk_import') ?>" class="btn btn-outline-success w-100 mb-2">
                            <i class="fas fa-upload me-2"></i>
                            Import Bulk
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="<?= base_url('admin/attendance/settings') ?>" class="btn btn-outline-warning w-100 mb-2">
                            <i class="fas fa-cog me-2"></i>
                            Pengaturan
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="<?= base_url('admin/reports') ?>" class="btn btn-outline-info w-100 mb-2">
                            <i class="fas fa-chart-bar me-2"></i>
                            Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle advanced filter
function showAdvancedFilter() {
    const advancedFilter = document.getElementById('advancedFilter');
    if (advancedFilter.style.display === 'none') {
        advancedFilter.style.display = 'block';
    } else {
        advancedFilter.style.display = 'none';
    }
}

// Delete attendance confirmation
function deleteAttendance(attendanceId, userName) {
    if (confirm(`Apakah Anda yakin ingin menghapus data absensi untuk "${userName}"?\n\nTindakan ini tidak dapat dibatalkan!`)) {
        window.location.href = `<?= base_url('admin/delete_attendance/') ?>${attendanceId}`;
    }
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Initialize DataTable
    if (typeof $.fn.DataTable !== 'undefined') {
        $('#attendanceTable').DataTable({
            pageLength: 25,
            order: [[3, 'asc']], // Sort by check-in time
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
            }
        });
    }
});
</script>
