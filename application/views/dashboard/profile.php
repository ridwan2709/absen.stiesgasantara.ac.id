<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-user me-2"></i>
                Profile Saya
            </h1>
            <div>
                <a href="<?= base_url('dashboard/change_password') ?>" class="btn btn-warning">
                    <i class="fas fa-key me-2"></i>
                    Ganti Password
                </a>
                <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <?= $this->session->flashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit me-2"></i>
                    Edit Profile
                </h5>
            </div>
            <div class="card-body">
                <?= form_open('dashboard/profile', ['class' => 'row g-3']) ?>
                    
                    <!-- Informasi Akun -->
                    <div class="col-12">
                        <h6 class="border-bottom pb-2 mb-3">
                            <i class="fas fa-user-circle me-2"></i>
                            Informasi Akun
                        </h6>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" 
                               class="form-control" 
                               id="username" 
                               value="<?= $user->username ?>" 
                               readonly>
                        <div class="form-text">Username tidak dapat diubah</div>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="role" class="form-label">Role</label>
                        <input type="text" 
                               class="form-control" 
                               id="role" 
                               value="<?= ucfirst($user->role) ?>" 
                               readonly>
                        <div class="form-text">Role ditentukan oleh administrator</div>
                    </div>
                    
                    <!-- Data Pribadi -->
                    <div class="col-12 mt-4">
                        <h6 class="border-bottom pb-2 mb-3">
                            <i class="fas fa-id-card me-2"></i>
                            Data Pribadi
                        </h6>
                    </div>
                    
                    <div class="col-md-12">
                        <label for="full_name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control <?= form_error('full_name') ? 'is-invalid' : '' ?>" 
                               id="full_name" 
                               name="full_name" 
                               value="<?= set_value('full_name', $user->full_name) ?>" 
                               required>
                        <?php if (form_error('full_name')): ?>
                            <div class="invalid-feedback">
                                <?= form_error('full_name') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" 
                               class="form-control <?= form_error('email') ? 'is-invalid' : '' ?>" 
                               id="email" 
                               name="email" 
                               value="<?= set_value('email', $user->email) ?>" 
                               required>
                        <?php if (form_error('email')): ?>
                            <div class="invalid-feedback">
                                <?= form_error('email') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="nip_nidn" class="form-label">NIP/NIDN</label>
                        <input type="text" 
                               class="form-control" 
                               id="nip_nidn" 
                               value="<?= $user->nip_nidn ?: 'Belum diatur' ?>" 
                               readonly>
                        <div class="form-text">NIP/NIDN diatur oleh administrator</div>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="department" class="form-label">Departemen</label>
                        <input type="text" 
                               class="form-control" 
                               id="department" 
                               value="<?= $user->department ?: 'Belum diatur' ?>" 
                               readonly>
                        <div class="form-text">Departemen diatur oleh administrator</div>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Nomor Telepon</label>
                        <input type="text" 
                               class="form-control <?= form_error('phone') ? 'is-invalid' : '' ?>" 
                               id="phone" 
                               name="phone" 
                               value="<?= set_value('phone', $user->phone) ?>" 
                               placeholder="Contoh: 08123456789">
                        <?php if (form_error('phone')): ?>
                            <div class="invalid-feedback">
                                <?= form_error('phone') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-12">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-control <?= form_error('address') ? 'is-invalid' : '' ?>" 
                                  id="address" 
                                  name="address" 
                                  rows="3" 
                                  placeholder="Masukkan alamat lengkap"><?= set_value('address', $user->address) ?></textarea>
                        <?php if (form_error('address')): ?>
                            <div class="invalid-feedback">
                                <?= form_error('address') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Informasi Akun -->
                    <div class="col-12 mt-4">
                        <h6 class="border-bottom pb-2 mb-3">
                            <i class="fas fa-info-circle me-2"></i>
                            Informasi Akun
                        </h6>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Status Akun</label>
                        <div class="form-control-plaintext">
                            <?php if ($user->is_active): ?>
                                <span class="badge bg-success">Aktif</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Nonaktif</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Bergabung</label>
                        <div class="form-control-plaintext">
                            <?= date('d/m/Y H:i:s', strtotime($user->created_at)) ?>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="col-12 mt-4">
                        <hr>
                        <div class="d-flex justify-content-between">
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Field yang bertanda <span class="text-danger">*</span> wajib diisi
                                </small>
                            </div>
                            <div>
                                <button type="reset" class="btn btn-secondary me-2">
                                    <i class="fas fa-undo me-2"></i>
                                    Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </div>
                    
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-dismiss alerts after 5 seconds
setTimeout(function() {
    var alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        var bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    var fullName = document.getElementById('full_name').value.trim();
    var email = document.getElementById('email').value.trim();
    
    if (!fullName) {
        e.preventDefault();
        alert('Nama lengkap harus diisi!');
        document.getElementById('full_name').focus();
        return false;
    }
    
    if (!email) {
        e.preventDefault();
        alert('Email harus diisi!');
        document.getElementById('email').focus();
        return false;
    }
    
    // Email validation
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        e.preventDefault();
        alert('Format email tidak valid!');
        document.getElementById('email').focus();
        return false;
    }
});
</script>