<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-user-chart me-2"></i>
                Laporan Detail Pengguna
            </h1>
            <div>
                <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary me-2">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali
                </a>
                <a href="<?= base_url('admin/export_user_report') ?>?user_id=<?= $user->id ?>&start_date=<?= $start_date ?>&end_date=<?= $end_date ?>" class="btn btn-success">
                    <i class="fas fa-download me-2"></i>
                    Export CSV
                </a>
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
                                <td><?= $user->full_name ?></td>
                            </tr>
                            <tr>
                                <td><strong>Username:</strong></td>
                                <td><?= $user->username ?></td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td><?= $user->email ?></td>
                            </tr>
                            <tr>
                                <td><strong>NIP/NIDN:</strong></td>
                                <td><?= $user->nip_nidn ?: 'N/A' ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="150"><strong>Departemen:</strong></td>
                                <td><?= $user->department ?: 'N/A' ?></td>
                            </tr>
                            <tr>
                                <td><strong>Role:</strong></td>
                                <td><span class="badge bg-info"><?= ucfirst($user->role) ?></span></td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    <?php if ($user->is_active): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Tidak Aktif</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Bergabung:</strong></td>
                                <td><?= date('d/m/Y', strtotime($user->created_at)) ?></td>
                            </tr>
                        </table>
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
                    Filter Periode
                </h5>
            </div>
            <div class="card-body">
                <form method="GET" action="<?= base_url('admin/user_report') ?>" class="row">
                    <input type="hidden" name="user_id" value="<?= $user->id ?>">
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
                        <a href="<?= base_url('admin/user_report?user_id=' . $user->id) ?>" class="btn btn-outline-secondary">
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
                <i class="fas fa-calendar-check fa-2x mb-2"></i>
                <h4 class="card-title"><?= $summary->total_days ?? 0 ?></h4>
                <p class="card-text">Total Hari Kerja</p>
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
                        <table class="table table-striped table-hover" id="userAttendanceTable">
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($attendance_history as $row): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <strong><?= date('d/m/Y', strtotime($row->created_at)) ?></strong>
                                        </td>
                                        <td>
                                            <?= date('l', strtotime($row->created_at)) ?>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTable
    if (typeof $.fn.DataTable !== 'undefined') {
        $('#userAttendanceTable').DataTable({
            pageLength: 25,
            order: [[1, 'desc']], // Sort by date
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
            }
        });
    }
});
</script>
