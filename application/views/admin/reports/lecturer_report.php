<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-chalkboard-teacher me-2"></i>
                Laporan Absensi Dosen
            </h1>
            <div>
                <a href="<?= base_url('admin/export_lecturer_report') ?>?start_date=<?= $start_date ?>&end_date=<?= $end_date ?>" 
                   class="btn btn-success me-2">
                    <i class="fas fa-download me-2"></i>
                    Export CSV
                </a>
                <a href="<?= base_url('admin/reports') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Filter Card -->
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
                <form method="GET" action="<?= base_url('admin/lecturer_report') ?>" class="row g-3">
                    <div class="col-md-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" 
                               value="<?= $start_date ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label for="end_date" class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" 
                               value="<?= $end_date ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label for="lecturer" class="form-label">Dosen</label>
                        <select class="form-control" id="lecturer" name="lecturer">
                            <option value="">Semua Dosen</option>
                            <?php foreach ($lecturers as $lecturer): ?>
                                <option value="<?= $lecturer->id ?>" 
                                        <?= ($selected_lecturer == $lecturer->id) ? 'selected' : '' ?>>
                                    <?= $lecturer->full_name ?> (<?= $lecturer->nip_nidn ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="subject" class="form-label">Mata Kuliah</label>
                        <select class="form-control" id="subject" name="subject">
                            <option value="">Semua Mata Kuliah</option>
                            <?php foreach ($subjects as $subject): ?>
                                <option value="<?= $subject->subject ?>" 
                                        <?= ($selected_subject == $subject->subject) ? 'selected' : '' ?>>
                                    <?= $subject->subject ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>
                            Filter Data
                        </button>
                        <a href="<?= base_url('admin/lecturer_report') ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-refresh me-2"></i>
                            Reset Filter
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
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Total Sesi</h5>
                        <h3><?= $summary->total_sessions ?></h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-chalkboard-teacher fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Mata Kuliah</h5>
                        <h3><?= $summary->total_subjects ?></h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-book fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Kelas</h5>
                        <h3><?= $summary->total_classes ?></h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Dosen Aktif</h5>
                        <h3><?= $summary->active_lecturers ?></h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-tie fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lecturer Report Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-table me-2"></i>
                    Data Absensi Dosen
                </h5>
                <small class="text-muted">
                    Periode: <?= date('d/m/Y', strtotime($start_date)) ?> - <?= date('d/m/Y', strtotime($end_date)) ?>
                </small>
            </div>
            <div class="card-body">
                <?php if (!empty($lecturer_attendance)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="lecturerTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Dosen</th>
                                    <th>NIP/NIDN</th>
                                    <th>Mata Kuliah</th>
                                    <th>Kelas</th>
                                    <th>Waktu</th>
                                    <th>Status</th>
                                    <th>Lokasi</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($lecturer_attendance as $record): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= date('d/m/Y', strtotime($record->created_at)) ?></td>
                                        <td>
                                            <strong><?= $record->full_name ?></strong>
                                        </td>
                                        <td><?= $record->nip_nidn ?: '-' ?></td>
                                        <td>
                                            <span class="badge bg-primary"><?= $record->subject ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info"><?= $record->class_name ?></span>
                                        </td>
                                        <td><?= date('H:i', strtotime($record->check_in)) ?></td>
                                        <td>
                                            <?php if ($record->status == 'present'): ?>
                                                <span class="badge bg-success">Tepat Waktu</span>
                                            <?php elseif ($record->status == 'late'): ?>
                                                <span class="badge bg-warning">Terlambat</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary"><?= ucfirst($record->status) ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <small class="text-muted"><?= $record->location ?></small>
                                        </td>
                                        <td>
                                            <?php if ($record->lecture_notes): ?>
                                                <small class="text-muted" title="<?= $record->lecture_notes ?>">
                                                    <?= strlen($record->lecture_notes) > 50 ? 
                                                        substr($record->lecture_notes, 0, 50) . '...' : 
                                                        $record->lecture_notes ?>
                                                </small>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak Ada Data</h5>
                        <p class="text-muted">Tidak ada data absensi dosen untuk periode yang dipilih.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Subject Summary -->
<?php if (!empty($subject_summary)): ?>
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-pie me-2"></i>
                    Ringkasan Per Mata Kuliah
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Mata Kuliah</th>
                                <th>Jumlah Kelas</th>
                                <th>Total Sesi</th>
                                <th>Dosen</th>
                                <th>Rata-rata Sesi/Hari</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($subject_summary as $subject): ?>
                                <tr>
                                    <td><strong><?= $subject->subject ?></strong></td>
                                    <td><?= $subject->total_classes ?></td>
                                    <td><?= $subject->total_sessions ?></td>
                                    <td><?= $subject->lecturer_count ?></td>
                                    <td><?= number_format($subject->avg_sessions_per_day, 1) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#lecturerTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
        },
        "pageLength": 25,
        "order": [[1, "desc"]],
        "columnDefs": [
            { "orderable": false, "targets": [0, 9] }
        ]
    });
    
    // Set max date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('end_date').setAttribute('max', today);
    
    // Date validation
    document.getElementById('start_date').addEventListener('change', function() {
        const startDate = this.value;
        document.getElementById('end_date').setAttribute('min', startDate);
    });
    
    // Auto-submit form when lecturer or subject changes
    document.getElementById('lecturer').addEventListener('change', function() {
        this.form.submit();
    });
    
    document.getElementById('subject').addEventListener('change', function() {
        this.form.submit();
    });
});
</script>
