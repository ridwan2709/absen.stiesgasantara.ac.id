<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-users me-2"></i>
                Manajemen Pengguna
            </h1>
            <a href="<?= base_url('admin/add_user') ?>" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Tambah Pengguna
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-list me-2"></i>
            Daftar Pengguna
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Departemen</th>
                        <th>Status</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $index => $user): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold"><?= $user->full_name ?></div>
                                            <small class="text-muted"><?= $user->nip_nidn ?: 'N/A' ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary"><?= $user->username ?></span>
                                </td>
                                <td><?= $user->email ?></td>
                                <td>
                                    <?php
                                    $role_class = 'bg-primary';
                                    $role_text = 'Admin';
                                    
                                    if ($user->role == 'staff') {
                                        $role_class = 'bg-info';
                                        $role_text = 'Staff';
                                    } elseif ($user->role == 'dosen') {
                                        $role_class = 'bg-success';
                                        $role_text = 'Dosen';
                                    }
                                    ?>
                                    <span class="badge <?= $role_class ?>"><?= $role_text ?></span>
                                </td>
                                <td><?= $user->department ?: '-' ?></td>
                                <td>
                                    <?php if ($user->is_active): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="fw-bold"><?= date('d/m/Y', strtotime($user->created_at)) ?></div>
                                    <small class="text-muted"><?= date('H:i', strtotime($user->created_at)) ?></small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('admin/edit_user/' . $user->id) ?>" 
                                           class="btn btn-sm btn-outline-primary" 
                                           data-bs-toggle="tooltip" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <a href="<?= base_url('admin/user_report?user_id=' . $user->id) ?>" 
                                           class="btn btn-sm btn-outline-info" 
                                           data-bs-toggle="tooltip" 
                                           title="Laporan Absensi">
                                            <i class="fas fa-chart-bar"></i>
                                        </a>
                                        
                                        <?php if ($user->is_active): ?>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-warning" 
                                                    onclick="toggleUserStatus(<?= $user->id ?>, 0)"
                                                    data-bs-toggle="tooltip" 
                                                    title="Nonaktifkan">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        <?php else: ?>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-success" 
                                                    onclick="toggleUserStatus(<?= $user->id ?>, 1)"
                                                    data-bs-toggle="tooltip" 
                                                    title="Aktifkan">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        <?php endif; ?>
                                        
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                onclick="deleteUser(<?= $user->id ?>, '<?= $user->full_name ?>')"
                                                data-bs-toggle="tooltip" 
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="fas fa-users fa-2x mb-3"></i>
                                <div>Belum ada data pengguna</div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// Toggle user status
function toggleUserStatus(userId, status) {
    const action = status ? 'mengaktifkan' : 'menonaktifkan';
    const userName = event.target.closest('tr').querySelector('td:nth-child(2) .fw-bold').textContent;
    
    if (confirm(`Apakah Anda yakin ingin ${action} pengguna "${userName}"?`)) {
        window.location.href = `<?= base_url('admin/toggle_user_status/') ?>${userId}/${status}`;
    }
}

// Delete user
function deleteUser(userId, userName) {
    if (confirm(`Apakah Anda yakin ingin menghapus pengguna "${userName}"?\n\nTindakan ini tidak dapat dibatalkan!`)) {
        window.location.href = `<?= base_url('admin/delete_user/') ?>${userId}`;
    }
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
