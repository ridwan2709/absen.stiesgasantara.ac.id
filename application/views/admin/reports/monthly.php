<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-calendar-alt me-2"></i>
                Laporan Bulanan
            </h1>
            <div>
                <a href="<?= base_url('admin/reports') ?>" class="btn btn-secondary me-2">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali
                </a>
                <a href="<?= base_url('admin/export_monthly_report') ?>?year=<?= $year ?>&month=<?= $month ?>" class="btn btn-success">
                    <i class="fas fa-download me-2"></i>
                    Export CSV
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.attendance-image {
    transition: transform 0.2s ease-in-out;
    border: 2px solid #dee2e6;
}

.attendance-image:hover {
    transform: scale(1.05);
    border-color: #007bff;
    box-shadow: 0 4px 8px rgba(0,123,255,0.3);
}

.subject-badge {
    font-size: 0.75rem;
    margin-bottom: 0.25rem;
}

.modal-image {
    max-height: 70vh;
    object-fit: contain;
}

.table-responsive {
    overflow-x: auto;
}

@media (max-width: 768px) {
    .attendance-image {
        width: 40px !important;
        height: 40px !important;
    }
    
    .subject-badge {
        font-size: 0.7rem;
    }
}
</style>

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
                <form method="GET" action="<?= base_url('admin/monthly_report') ?>" class="row">
                    <div class="col-md-4">
                        <label for="year" class="form-label">Tahun</label>
                        <select class="form-control" id="year" name="year" required>
                            <?php for ($y = date('Y'); $y >= date('Y') - 5; $y--): ?>
                                <option value="<?= $y ?>" <?= $y == $year ? 'selected' : '' ?>>
                                    <?= $y ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="month" class="form-label">Bulan</label>
                        <select class="form-control" id="month" name="month" required>
                            <?php 
                                $months = [
                                    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                                    '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                                    '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                                    '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                ];
                                foreach ($months as $key => $value):
                            ?>
                                <option value="<?= $key ?>" <?= $key == $month ? 'selected' : '' ?>>
                                    <?= $value ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search me-2"></i>
                            Filter
                        </button>
                        <a href="<?= base_url('admin/monthly_report') ?>" class="btn btn-outline-secondary">
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
                <h4 class="card-title"><?= count($monthly_data) ?></h4>
                <p class="card-text">Total Karyawan</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <i class="fas fa-check-circle fa-2x mb-2"></i>
                <h4 class="card-title">
                    <?= array_sum(array_column($monthly_data, 'present_days')) ?>
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
                    <?= array_sum(array_column($monthly_data, 'late_days')) ?>
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
                    <?= round(array_sum(array_column($monthly_data, 'total_hours')), 1) ?>
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
                    Data Absensi Bulanan
                </h5>
                <small class="text-muted">
                    Periode: <?= $months[$month] ?> <?= $year ?>
                </small>
            </div>
            <div class="card-body">
                <?php if (empty($monthly_data)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak ada data absensi</h5>
                        <p class="text-muted">Tidak ada data absensi untuk bulan yang dipilih.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="monthlyReportTable">
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
                                    <th>Mata Kuliah</th>
                                    <th>Foto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($monthly_data as $row): ?>
                                    <?php 
                                        $total_days = $row->total_days ?: 0;
                                        $present_days = $row->present_days ?: 0;
                                        $late_days = $row->late_days ?: 0;
                                        $absent_days = $row->absent_days ?: 0;
                                        $total_hours = $row->total_hours ?: 0;
                                        
                                        // Calculate working days in the month
                                        $working_days = 0;
                                        $current_month = new DateTime($year . '-' . $month . '-01');
                                        $last_day = new DateTime($year . '-' . $month . '-' . $current_month->format('t'));
                                        
                                        $current = clone $current_month;
                                        while ($current <= $last_day) {
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
                                        <td>
                                            <?php if ($row->subjects): ?>
                                                <?php 
                                                    $subjects = explode(',', $row->subjects);
                                                    $class_names = explode(',', $row->class_names);
                                                    foreach ($subjects as $index => $subject):
                                                        $class_name = isset($class_names[$index]) ? $class_names[$index] : '';
                                                ?>
                                                    <div class="mb-1">
                                                        <small class="badge bg-info subject-badge">
                                                            <?= trim($subject) ?>
                                                            <?php if ($class_name): ?>
                                                                (<?= trim($class_name) ?>)
                                                            <?php endif; ?>
                                                        </small>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($row->photos): ?>
                                                <?php 
                                                    $photos = explode(',', $row->photos);
                                                    foreach ($photos as $photo):
                                                        if (trim($photo)):
                                                ?>
                                                    <div class="mb-1">
                                                        <img src="<?= base_url(trim($photo)) ?>" 
                                                             alt="Foto Kuliah" 
                                                             class="img-thumbnail attendance-image"
                                                             onclick="showImageModal('<?= base_url(trim($photo)) ?>', '<?= trim($photo) ?>')">
                                                    </div>
                                                <?php 
                                                        endif;
                                                    endforeach; 
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

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Foto Kuliah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Foto Kuliah" class="img-fluid modal-image">
                <p class="mt-2 text-muted" id="modalImageName"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a id="downloadImage" href="" download class="btn btn-primary">
                    <i class="fas fa-download me-2"></i>Download
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTable
    if (typeof $.fn.DataTable !== 'undefined') {
        $('#monthlyReportTable').DataTable({
            pageLength: 25,
            order: [[9, 'desc']], // Sort by percentage
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
            },
            columnDefs: [
                { targets: [10, 11], orderable: false } // Disable sorting for image and subject columns
            ]
        });
    }
});

// Function to show image modal
function showImageModal(imageSrc, imageName) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('modalImageName').textContent = imageName;
    document.getElementById('downloadImage').href = imageSrc;
    
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
}
</script>
