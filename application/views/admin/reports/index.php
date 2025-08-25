<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-chart-bar me-2"></i>
                Laporan Absensi
            </h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar-week me-2"></i>
                    Laporan Mingguan
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    Lihat laporan absensi berdasarkan rentang waktu mingguan yang dapat disesuaikan.
                </p>
                <a href="<?= base_url('admin/weekly_report') ?>" class="btn btn-primary w-100">
                    <i class="fas fa-eye me-2"></i>
                    Lihat Laporan
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Laporan Bulanan
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    Laporan absensi bulanan dengan ringkasan statistik yang lengkap.
                </p>
                <a href="<?= base_url('admin/monthly_report') ?>" class="btn btn-primary w-100">
                    <i class="fas fa-eye me-2"></i>
                    Lihat Laporan
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar-day me-2"></i>
                    Laporan Harian
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    Laporan absensi harian dengan detail waktu masuk, pulang, dan jam kerja.
                </p>
                <a href="<?= base_url('admin/daily_report') ?>" class="btn btn-primary w-100">
                    <i class="fas fa-eye me-2"></i>
                    Lihat Laporan
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chalkboard-teacher me-2"></i>
                    Laporan Dosen
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    Laporan khusus absensi mengajar dosen dengan detail mata kuliah dan kelas.
                </p>
                <a href="<?= base_url('admin/lecturer_report') ?>" class="btn btn-info w-100">
                    <i class="fas fa-eye me-2"></i>
                    Lihat Laporan
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-upload me-2"></i>
                    Import Data
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    Import data absensi dari file CSV untuk data yang tidak terekam otomatis.
                </p>
                <a href="<?= base_url('admin/bulk_import') ?>" class="btn btn-warning w-100">
                    <i class="fas fa-upload me-2"></i>
                    Import CSV
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-history me-2"></i>
                    Riwayat Absensi
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    Lihat riwayat absensi detail untuk pengguna tertentu dengan filter periode.
                </p>
                <a href="<?= base_url('dashboard/attendance_history') ?>" class="btn btn-info w-100">
                    <i class="fas fa-eye me-2"></i>
                    Lihat Riwayat
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    Statistik Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center mb-3">
                        <div class="h2 text-primary"><?= date('W') ?></div>
                        <div class="text-muted">Minggu Ini</div>
                    </div>
                    <div class="col-md-3 text-center mb-3">
                        <div class="h2 text-success"><?= date('m') ?></div>
                        <div class="text-muted">Bulan Ini</div>
                    </div>
                    <div class="col-md-3 text-center mb-3">
                        <div class="h2 text-info"><?= date('Y') ?></div>
                        <div class="text-muted">Tahun Ini</div>
                    </div>
                    <div class="col-md-3 text-center mb-3">
                        <div class="h2 text-warning"><?= date('d') ?></div>
                        <div class="text-muted">Hari Ini</div>
                    </div>
                </div>
                
                <hr class="my-3">
                
                <div class="row">
                    <div class="col-md-4 text-center mb-3">
                        <div class="h4 text-success"><?= $stats->today->present_users ?? 0 ?></div>
                        <small class="text-muted">Hadir Hari Ini</small>
                    </div>
                    <div class="col-md-4 text-center mb-3">
                        <div class="h4 text-warning"><?= $stats->today->late_users ?? 0 ?></div>
                        <small class="text-muted">Terlambat Hari Ini</small>
                    </div>
                    <div class="col-md-4 text-center mb-3">
                        <div class="h4 text-info"><?= round($stats->monthly->total_hours ?? 0, 1) ?></div>
                        <small class="text-muted">Total Jam Bulan Ini</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Panduan Laporan
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">
                            <i class="fas fa-calendar-week me-2"></i>
                            Laporan Mingguan
                        </h6>
                        <ul class="text-muted">
                            <li>Dapat melihat absensi per minggu</li>
                            <li>Filter berdasarkan rentang tanggal</li>
                            <li>Export ke format CSV</li>
                            <li>Statistik kehadiran dan keterlambatan</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary">
                            <i class="fas fa-calendar-alt me-2"></i>
                            Laporan Bulanan
                        </h6>
                        <ul class="text-muted">
                            <li>Ringkasan absensi per bulan</li>
                            <li>Perbandingan antar bulan</li>
                            <li>Trend kehadiran karyawan</li>
                            <li>Analisis performa departemen</li>
                        </ul>
                    </div>
                </div>
                
                <hr class="my-3">
                
                <div class="alert alert-info">
                    <h6 class="alert-heading">
                        <i class="fas fa-lightbulb me-2"></i>
                        Tips Penggunaan
                    </h6>
                    <ul class="mb-0">
                        <li>Gunakan filter tanggal untuk mendapatkan data yang lebih spesifik</li>
                        <li>Export laporan untuk analisis lebih lanjut</li>
                        <li>Periksa data secara berkala untuk monitoring yang efektif</li>
                        <li>Gunakan fitur input manual untuk data yang tidak terekam otomatis</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-cog me-2"></i>
                    Pengaturan Laporan
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Waktu Kerja Standar</h6>
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Jam Masuk</label>
                                <input type="time" class="form-control" value="08:00" readonly>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Jam Pulang</label>
                                <input type="time" class="form-control" value="17:00" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>Toleransi Keterlambatan</h6>
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Menit</label>
                                <input type="number" class="form-control" value="15" readonly>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Status</label>
                                <input type="text" class="form-control" value="Terlambat" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-3">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Pengaturan ini dapat diubah melalui konfigurasi sistem
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
