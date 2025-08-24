<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Sistem Manajemen Absensi</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin: 0.25rem 0;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background: rgba(255,255,255,0.1);
            transform: translateX(5px);
        }
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
        }
        .main-content {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .stat-card .stat-icon {
            font-size: 2.5rem;
            opacity: 0.8;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        .alert {
            border-radius: 10px;
            border: none;
        }
        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid #e9ecef;
        }
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white">
                            <i class="fas fa-clock"></i>
                            AbsensiKu
                        </h4>
                    </div>
                    
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?= $this->uri->segment(1) == 'dashboard' ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>">
                                <i class="fas fa-tachometer-alt"></i>
                                Dashboard
                            </a>
                        </li>
                        
                        <?php if ($this->session->userdata('role') == 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $this->uri->segment(1) == 'admin' && $this->uri->segment(2) == 'users' ? 'active' : '' ?>" href="<?= base_url('admin/users') ?>">
                                <i class="fas fa-users"></i>
                                Manajemen Pengguna
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $this->uri->segment(1) == 'admin' && $this->uri->segment(2) == 'qr_codes' ? 'active' : '' ?>" href="<?= base_url('admin/qr_codes') ?>">
                                <i class="fas fa-qrcode"></i>
                                Manajemen QR Code
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $this->uri->segment(1) == 'admin' && $this->uri->segment(2) == 'reports' ? 'active' : '' ?>" href="<?= base_url('admin/reports') ?>">
                                <i class="fas fa-chart-bar"></i>
                                Laporan
                            </a>
                        </li>
                        <?php endif; ?>
                        
                        <li class="nav-item">
                            <a class="nav-link <?= $this->uri->segment(1) == 'dashboard' && $this->uri->segment(2) == 'scan_qr' ? 'active' : '' ?>" href="<?= base_url('dashboard/scan_qr') ?>">
                                <i class="fas fa-qrcode"></i>
                                Scan QR Code
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link <?= $this->uri->segment(1) == 'dashboard' && $this->uri->segment(2) == 'attendance_history' ? 'active' : '' ?>" href="<?= base_url('dashboard/attendance_history') ?>">
                                <i class="fas fa-history"></i>
                                Riwayat Absensi
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link <?= $this->uri->segment(1) == 'dashboard' && $this->uri->segment(2) == 'profile' ? 'active' : '' ?>" href="<?= base_url('dashboard/profile') ?>">
                                <i class="fas fa-user"></i>
                                Profil Saya
                            </a>
                        </li>
                        
                        <li class="nav-item mt-4">
                            <a class="nav-link text-danger" href="<?= base_url('auth/logout') ?>" onclick="return confirm('Apakah Anda yakin ingin logout?')">
                                <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            
            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <!-- Top navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm rounded-3 mt-3 mb-4">
                    <div class="container-fluid">
                        <button class="navbar-toggler d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target=".sidebar">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        
                        <div class="navbar-nav ms-auto">
                            <div class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle me-2"></i>
                                    <?= $this->session->userdata('full_name') ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?= base_url('dashboard/profile') ?>">
                                        <i class="fas fa-user me-2"></i>Profil
                                    </a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('dashboard/change_password') ?>">
                                        <i class="fas fa-key me-2"></i>Ubah Password
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="<?= base_url('auth/logout') ?>">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
                
                <!-- Flash messages -->
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <?= $this->session->flashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= $this->session->flashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <!-- Page content -->
                <div class="container-fluid">
