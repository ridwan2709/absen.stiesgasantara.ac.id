<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-history me-2"></i>
                Riwayat Absensi
                <?php if (isset($target_user)): ?>
                    - <?= $target_user->full_name ?>
                <?php endif; ?>
            </h1>
            <div>
                <a href="<?= base_url('admin/reports') ?>" class="btn btn-secondary me-2">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali ke Laporan
                </a>
                <?php if (isset($target_user)): ?>
                    <a href="<?= base_url('admin/export_user_report') ?>?user_id=<?= $target_user->id ?>&start_date=<?= $start_date ?>&end_date=<?= $end_date ?>" class="btn btn-success">
                        <i class="fas fa-download me-2"></i>
                        Export CSV
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- User Selection (Admin Only) -->
<?php if ($is_admin && !isset($target_user)): ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user me-2"></i>
                    Pilih Pengguna
                </h5>
            </div>
            <div class="card-body">
                <form method="GET" action="<?= base_url('dashboard/attendance_history') ?>" class="row">
                    <div class="col-md-6">
                        <label for="user_id" class="form-label">Pilih Pengguna</label>
                        <select class="form-control" id="user_id" name="user_id" required>
                            <option value="">-- Pilih Pengguna --</option>
                            <?php 
                            // Get all active non-admin users
                            $this->db->where('role !=', 'admin');
                            $this->db->where('is_active', 1);
                            $this->db->order_by('full_name', 'ASC');
                            $users = $this->db->get('users')->result();
                            foreach ($users as $user): 
                            ?>
                                <option value="<?= $user->id ?>"><?= $user->full_name ?> (<?= ucfirst($user->role) ?> - <?= $user->department ?: 'N/A' ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>
                            Lihat Riwayat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Filter Section -->
<?php if (isset($target_user)): ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-filter me-2"></i>
                    Filter Periode
                </h5>
            </div>
            <div class="card-body">
                <form method="GET" action="<?= base_url('dashboard/attendance_history') ?>" class="row">
                    <input type="hidden" name="user_id" value="<?= $target_user->id ?>">
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
                        <a href="<?= base_url('dashboard/attendance_history') ?>?user_id=<?= $target_user->id ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-refresh me-2"></i>
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- User Information -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user me-2"></i>
                    Informasi Pengguna
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="150"><strong>Nama Lengkap:</strong></td>
                                <td><?= $target_user->full_name ?></td>
                            </tr>
                            <tr>
                                <td><strong>Username:</strong></td>
                                <td><?= $target_user->username ?></td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td><?= $target_user->email ?></td>
                            </tr>
                            <tr>
                                <td><strong>NIP/NIDN:</strong></td>
                                <td><?= $target_user->nip_nidn ?: 'N/A' ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="150"><strong>Departemen:</strong></td>
                                <td><?= $target_user->department ?: 'N/A' ?></td>
                            </tr>
                            <tr>
                                <td><strong>Role:</strong></td>
                                <td><span class="badge bg-info"><?= ucfirst($target_user->role) ?></span></td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    <?php if ($target_user->is_active): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Tidak Aktif</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Bergabung:</strong></td>
                                <td><?= date('d/m/Y', strtotime($target_user->created_at)) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Summary Statistics -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <i class="fas fa-calendar-check fa-2x mb-2"></i>
                <h4 class="card-title"><?= count($attendance_history) ?></h4>
                <p class="card-text">Total Hari</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <i class="fas fa-check-circle fa-2x mb-2"></i>
                <h4 class="card-title"><?= count(array_filter($attendance_history, function($item) { return $item->status == 'present'; })) ?></h4>
                <p class="card-text">Hadir Tepat Waktu</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <i class="fas fa-clock fa-2x mb-2"></i>
                <h4 class="card-title"><?= count(array_filter($attendance_history, function($item) { return $item->status == 'late'; })) ?></h4>
                <p class="card-text">Terlambat</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <i class="fas fa-hourglass-half fa-2x mb-2"></i>
                <h4 class="card-title"><?= round(array_sum(array_column($attendance_history, 'work_hours')), 1) ?></h4>
                <p class="card-text">Total Jam Kerja</p>
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
                    Riwayat Absensi
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
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                    <th>Jam Kerja</th>
                                    <th>Status</th>
                                    <th>Lokasi</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($attendance_history as $record): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                <?= date('d/m/Y', strtotime($record->created_at)) ?>
                                            </span>
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
                                            <small class="text-muted">
                                                <?php if (isset($record->subject) && $record->subject): ?>
                                                    <?= $record->subject ?> - <?= $record->class_name ?: 'N/A' ?>
                                                <?php elseif (isset($record->notes) && $record->notes): ?>
                                                    <?= $record->notes ?>
                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </small>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('admin/edit_attendance/' . $record->id) ?>" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   data-bs-toggle="tooltip" 
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        onclick="deleteAttendance(<?= $record->id ?>, '<?= $target_user->full_name ?>')"
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
<?php endif; ?>

<script>
// Delete attendance confirmation
function deleteAttendance(attendanceId, userName) {
    if (confirm(`Apakah Anda yakin ingin menghapus data absensi untuk "${userName}"?\n\nTindakan ini tidak dapat dibatalkan!`)) {
        window.location.href = `<?= base_url('admin/delete_attendance/') ?>${attendanceId}`;
    }
}

// Initialize tooltips and DataTable
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Initialize DataTable
    if (typeof $.fn.DataTable !== 'undefined' && document.getElementById('attendanceHistoryTable')) {
        $('#attendanceHistoryTable').DataTable({
            pageLength: 25,
            order: [[1, 'desc']], // Sort by date descending
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
            }
        });
    }
});
</script>
