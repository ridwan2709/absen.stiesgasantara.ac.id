<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-key me-2"></i>
                Ganti Password
            </h1>
            <div>
                <a href="<?= base_url('dashboard/profile') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali ke Profile
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
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-shield-alt me-2"></i>
                    Form Ganti Password
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Petunjuk Keamanan:</strong>
                    <ul class="mb-0 mt-2">
                        <li>Password harus minimal 6 karakter</li>
                        <li>Gunakan kombinasi huruf, angka, dan simbol</li>
                        <li>Jangan gunakan password yang mudah ditebak</li>
                        <li>Jangan bagikan password kepada siapapun</li>
                    </ul>
                </div>
                
                <?= form_open('dashboard/change_password', ['class' => 'row g-3', 'id' => 'changePasswordForm']) ?>
                    
                    <div class="col-12">
                        <label for="current_password" class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" 
                                   class="form-control <?= form_error('current_password') ? 'is-invalid' : '' ?>" 
                                   id="current_password" 
                                   name="current_password" 
                                   required
                                   placeholder="Masukkan password saat ini">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
                                <i class="fas fa-eye" id="current_password_icon"></i>
                            </button>
                            <?php if (form_error('current_password')): ?>
                                <div class="invalid-feedback">
                                    <?= form_error('current_password') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <label for="new_password" class="form-label">Password Baru <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" 
                                   class="form-control <?= form_error('new_password') ? 'is-invalid' : '' ?>" 
                                   id="new_password" 
                                   name="new_password" 
                                   required
                                   minlength="6"
                                   placeholder="Masukkan password baru (min. 6 karakter)">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password')">
                                <i class="fas fa-eye" id="new_password_icon"></i>
                            </button>
                            <?php if (form_error('new_password')): ?>
                                <div class="invalid-feedback">
                                    <?= form_error('new_password') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-text">
                            <div id="password_strength" class="mt-2"></div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <label for="confirm_password" class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" 
                                   class="form-control <?= form_error('confirm_password') ? 'is-invalid' : '' ?>" 
                                   id="confirm_password" 
                                   name="confirm_password" 
                                   required
                                   placeholder="Ulangi password baru">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm_password')">
                                <i class="fas fa-eye" id="confirm_password_icon"></i>
                            </button>
                            <?php if (form_error('confirm_password')): ?>
                                <div class="invalid-feedback">
                                    <?= form_error('confirm_password') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div id="password_match" class="form-text"></div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="col-12 mt-4">
                        <hr>
                        <div class="d-flex justify-content-between">
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Semua field wajib diisi
                                </small>
                            </div>
                            <div>
                                <button type="reset" class="btn btn-secondary me-2">
                                    <i class="fas fa-undo me-2"></i>
                                    Reset
                                </button>
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="fas fa-save me-2"></i>
                                    Ganti Password
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

// Toggle password visibility
function togglePassword(fieldId) {
    var field = document.getElementById(fieldId);
    var icon = document.getElementById(fieldId + '_icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        field.type = 'password';
        icon.className = 'fas fa-eye';
    }
}

// Password strength checker
document.getElementById('new_password').addEventListener('input', function() {
    var password = this.value;
    var strengthDiv = document.getElementById('password_strength');
    var strength = checkPasswordStrength(password);
    
    strengthDiv.innerHTML = '<small class="' + strength.class + '">' + strength.text + '</small>';
});

function checkPasswordStrength(password) {
    if (password.length === 0) {
        return { class: '', text: '' };
    }
    
    var score = 0;
    var feedback = [];
    
    // Length check
    if (password.length >= 8) {
        score += 2;
    } else if (password.length >= 6) {
        score += 1;
        feedback.push('Minimal 8 karakter untuk keamanan yang lebih baik');
    } else {
        feedback.push('Terlalu pendek (minimal 6 karakter)');
    }
    
    // Character variety checks
    if (/[a-z]/.test(password)) score += 1;
    if (/[A-Z]/.test(password)) score += 1;
    if (/[0-9]/.test(password)) score += 1;
    if (/[^A-Za-z0-9]/.test(password)) score += 1;
    
    if (score < 3) {
        return { 
            class: 'text-danger', 
            text: '<i class="fas fa-times-circle me-1"></i>Password lemah ' + (feedback.length > 0 ? '- ' + feedback.join(', ') : '')
        };
    } else if (score < 5) {
        return { 
            class: 'text-warning', 
            text: '<i class="fas fa-exclamation-circle me-1"></i>Password sedang'
        };
    } else {
        return { 
            class: 'text-success', 
            text: '<i class="fas fa-check-circle me-1"></i>Password kuat'
        };
    }
}

// Password match checker
document.getElementById('confirm_password').addEventListener('input', function() {
    var newPassword = document.getElementById('new_password').value;
    var confirmPassword = this.value;
    var matchDiv = document.getElementById('password_match');
    
    if (confirmPassword.length === 0) {
        matchDiv.innerHTML = '';
        return;
    }
    
    if (newPassword === confirmPassword) {
        matchDiv.innerHTML = '<small class="text-success"><i class="fas fa-check-circle me-1"></i>Password cocok</small>';
    } else {
        matchDiv.innerHTML = '<small class="text-danger"><i class="fas fa-times-circle me-1"></i>Password tidak cocok</small>';
    }
});

// Form validation
document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
    var currentPassword = document.getElementById('current_password').value.trim();
    var newPassword = document.getElementById('new_password').value;
    var confirmPassword = document.getElementById('confirm_password').value;
    
    if (!currentPassword) {
        e.preventDefault();
        alert('Password saat ini harus diisi!');
        document.getElementById('current_password').focus();
        return false;
    }
    
    if (newPassword.length < 6) {
        e.preventDefault();
        alert('Password baru harus minimal 6 karakter!');
        document.getElementById('new_password').focus();
        return false;
    }
    
    if (newPassword !== confirmPassword) {
        e.preventDefault();
        alert('Konfirmasi password tidak cocok!');
        document.getElementById('confirm_password').focus();
        return false;
    }
    
    if (currentPassword === newPassword) {
        e.preventDefault();
        alert('Password baru harus berbeda dengan password saat ini!');
        document.getElementById('new_password').focus();
        return false;
    }
    
    // Show loading state
    var submitBtn = document.getElementById('submitBtn');
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
    submitBtn.disabled = true;
});

// Reset form
document.querySelector('button[type="reset"]').addEventListener('click', function() {
    document.getElementById('password_strength').innerHTML = '';
    document.getElementById('password_match').innerHTML = '';
});
</script>
