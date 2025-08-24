<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-tachometer-alt me-2"></i>
                Dashboard
            </h1>
            <div class="text-muted">
                <i class="fas fa-calendar me-2"></i>
                <?= date('l, d F Y') ?>
            </div>
        </div>
    </div>
</div>

<?php if ($user['role'] == 'admin'): ?>
    <!-- Admin Dashboard -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-white-50">Total Pengguna</div>
                            <div class="h2 mb-0 text-white"><?= $total_users ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-white-50">Total Staff</div>
                            <div class="h2 mb-0 text-white"><?= $total_staff ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-white-50">Total Dosen</div>
                            <div class="h2 mb-0 text-white"><?= $total_dosen ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-white-50">QR Code Aktif</div>
                            <div class="h2 mb-0 text-white"><?= $active_qr_codes ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-qrcode stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Today's Summary -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie me-2"></i>
                        Ringkasan Hari Ini
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="h3 text-primary"><?= $today_summary->total_users ?></div>
                            <div class="text-muted">Total Pengguna</div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="h3 text-success"><?= $today_summary->present_users ?></div>
                            <div class="text-muted">Hadir Hari Ini</div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="h3 text-warning"><?= $today_summary->late_users ?></div>
                            <div class="text-muted">Terlambat</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Attendance -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-history me-2"></i>
                        Absensi Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Departemen</th>
                                    <th>QR Code</th>
                                    <th>Waktu Masuk</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($recent_attendance)): ?>
                                    <?php foreach ($recent_attendance as $attendance): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold"><?= $attendance->full_name ?></div>
                                                        <small class="text-muted"><?= ucfirst($attendance->role) ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= $attendance->department ?: '-' ?></td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <i class="fas fa-qrcode me-1"></i>
                                                    <?= $attendance->qr_name ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($attendance->check_in): ?>
                                                    <div class="fw-bold"><?= date('H:i', strtotime($attendance->check_in)) ?></div>
                                                    <small class="text-muted"><?= date('d/m/Y', strtotime($attendance->check_in)) ?></small>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $status_class = 'bg-success';
                                                $status_text = 'Hadir';
                                                
                                                if ($attendance->status == 'late') {
                                                    $status_class = 'bg-warning';
                                                    $status_text = 'Terlambat';
                                                } elseif ($attendance->status == 'absent') {
                                                    $status_class = 'bg-danger';
                                                    $status_text = 'Tidak Hadir';
                                                }
                                                ?>
                                                <span class="badge <?= $status_class ?>">
                                                    <?= $status_text ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-2x mb-3"></i>
                                            <div>Belum ada data absensi hari ini</div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php else: ?>
    <!-- Staff/Dosen Dashboard -->
    <div class="row mb-4">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calendar-check me-2"></i>
                        Status Hari Ini
                    </h5>
                </div>
                <div class="card-body">
                    <?php if ($today_attendance): ?>
                        <div class="text-center">
                            <?php if ($today_attendance->check_in && !$today_attendance->check_out): ?>
                                <div class="h1 text-success mb-3">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <h4 class="text-success">Sudah Absen Masuk</h4>
                                <p class="text-muted">
                                    Waktu masuk: <?= date('H:i', strtotime($today_attendance->check_in)) ?>
                                </p>
                                <a href="<?= base_url('dashboard/scan_qr') ?>" class="btn btn-primary">
                                    <i class="fas fa-qrcode me-2"></i>
                                    Absen
                                </a>
                            <?php elseif ($today_attendance->check_in && $today_attendance->check_out): ?>
                                <div class="h1 text-info mb-3">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <h4 class="text-info">Absensi Selesai</h4>
                                <p class="text-muted">
                                    Masuk: <?= date('H:i', strtotime($today_attendance->check_in)) ?><br>
                                    Pulang: <?= date('H:i', strtotime($today_attendance->check_out)) ?><br>
                                    Total jam: <?= $today_attendance->work_hours ?> jam
                                </p>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Anda telah menyelesaikan absensi hari ini
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center">
                            <div class="h1 text-warning mb-3">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <h4 class="text-warning">Belum Absen</h4>
                            <p class="text-muted">Anda belum melakukan absensi hari ini</p>
                            <a href="<?= base_url('dashboard/scan_qr') ?>" class="btn btn-primary">
                                <i class="fas fa-qrcode me-2"></i>
                                Absen Sekarang
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>
                        Ringkasan Minggu Ini
                    </h5>
                </div>
                <div class="card-body">
                    <?php if ($weekly_summary): ?>
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="h3 text-success"><?= $weekly_summary->present_days ?></div>
                                <div class="text-muted">Hadir</div>
                            </div>
                            <div class="col-4">
                                <div class="h3 text-warning"><?= $weekly_summary->late_days ?></div>
                                <div class="text-muted">Terlambat</div>
                            </div>
                            <div class="col-4">
                                <div class="h3 text-primary"><?= $weekly_summary->total_hours ?></div>
                                <div class="text-muted">Total Jam</div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-chart-bar fa-2x mb-3"></i>
                            <div>Belum ada data minggu ini</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent History -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-history me-2"></i>
                        Riwayat Terbaru
                    </h5>
                    <a href="<?= base_url('dashboard/attendance_history') ?>" class="btn btn-sm btn-outline-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>QR Code</th>
                                    <th>Masuk</th>
                                    <th>Pulang</th>
                                    <th>Jam Kerja</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($recent_history)): ?>
                                    <?php foreach (array_slice($recent_history, 0, 5) as $history): ?>
                                        <tr>
                                            <td>
                                                <div class="fw-bold"><?= date('d/m/Y', strtotime($history->created_at)) ?></div>
                                                <small class="text-muted"><?= date('l', strtotime($history->created_at)) ?></small>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <i class="fas fa-qrcode me-1"></i>
                                                    <?= $history->qr_name ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($history->check_in): ?>
                                                    <div class="fw-bold"><?= date('H:i', strtotime($history->check_in)) ?></div>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($history->check_out): ?>
                                                    <div class="fw-bold"><?= date('H:i', strtotime($history->check_out)) ?></div>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($history->work_hours): ?>
                                                    <span class="fw-bold"><?= $history->work_hours ?> jam</span>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $status_class = 'bg-success';
                                                $status_text = 'Hadir';
                                                
                                                if ($history->status == 'late') {
                                                    $status_class = 'bg-warning';
                                                    $status_text = 'Terlambat';
                                                } elseif ($history->status == 'absent') {
                                                    $status_class = 'bg-danger';
                                                    $status_text = 'Tidak Hadir';
                                                }
                                                ?>
                                                <span class="badge <?= $status_class ?>">
                                                    <?= $status_text ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-2x mb-3"></i>
                                            <div>Belum ada riwayat absensi</div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

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
                    <div class="col-md-3 mb-3">
                        <a href="<?= base_url('dashboard/scan_qr') ?>" class="btn btn-primary w-100">
                            <i class="fas fa-qrcode me-2"></i>
                            Scan QR Code
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?= base_url('dashboard/attendance_history') ?>" class="btn btn-outline-primary w-100">
                            <i class="fas fa-history me-2"></i>
                            Riwayat Absensi
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?= base_url('dashboard/profile') ?>" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-user me-2"></i>
                            Profil Saya
                        </a>
                    </div>
                    <?php if ($user['role'] == 'admin'): ?>
                    <div class="col-md-3 mb-3">
                        <a href="<?= base_url('admin/reports') ?>" class="btn btn-outline-success w-100">
                            <i class="fas fa-chart-bar me-2"></i>
                            Laporan
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
