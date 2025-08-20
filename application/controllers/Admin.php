<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Attendance_model');
        $this->load->model('QRCode_model');
        $this->load->library('session');
        $this->load->helper('url');
        
        // Check if user is logged in and is admin
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        
        if ($this->session->userdata('role') !== 'admin') {
            redirect('dashboard');
        }
    }
    
    // User Management
    public function users() {
        $data['title'] = 'Manajemen Pengguna';
        $data['users'] = $this->User_model->get_all_users();
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/users/index', $data);
        $this->load->view('templates/footer');
    }
    
    public function add_user() {
        $data['title'] = 'Tambah Pengguna';
        
        if ($this->input->post()) {
            $user_data = array(
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'email' => $this->input->post('email'),
                'full_name' => $this->input->post('full_name'),
                'role' => $this->input->post('role'),
                'nip_nidn' => $this->input->post('nip_nidn'),
                'department' => $this->input->post('department'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address')
            );
            
            if ($this->User_model->create_user($user_data)) {
                $this->session->set_flashdata('success', 'Pengguna berhasil ditambahkan');
                redirect('admin/users');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan pengguna');
            }
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/users/add', $data);
        $this->load->view('templates/footer');
    }
    
    public function edit_user($id) {
        $data['title'] = 'Edit Pengguna';
        $data['user'] = $this->User_model->get_user_by_id($id);
        
        if (!$data['user']) {
            show_404();
        }
        
        if ($this->input->post()) {
            $update_data = array(
                'email' => $this->input->post('email'),
                'full_name' => $this->input->post('full_name'),
                'role' => $this->input->post('role'),
                'nip_nidn' => $this->input->post('nip_nidn'),
                'department' => $this->input->post('department'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address')
            );
            
            if ($this->input->post('password')) {
                $update_data['password'] = $this->input->post('password');
            }
            
            if ($this->User_model->update_user($id, $update_data)) {
                $this->session->set_flashdata('success', 'Pengguna berhasil diperbarui');
                redirect('admin/users');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui pengguna');
            }
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/users/edit', $data);
        $this->load->view('templates/footer');
    }
    
    public function delete_user($id) {
        if ($this->User_model->delete_user($id)) {
            $this->session->set_flashdata('success', 'Pengguna berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus pengguna');
        }
        redirect('admin/users');
    }
    
    public function toggle_user_status($id, $status) {
        if ($this->User_model->toggle_user_status($id, $status)) {
            $this->session->set_flashdata('success', 'Status pengguna berhasil diubah');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengubah status pengguna');
        }
        redirect('admin/users');
    }
    
    // QR Code Management
    public function qr_codes() {
        $data['title'] = 'Manajemen QR Code';
        $data['qr_codes'] = $this->QRCode_model->get_all_qr_codes();
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/qr_codes/index', $data);
        $this->load->view('templates/footer');
    }
    
    public function add_qr_code() {
        $data['title'] = 'Tambah QR Code';
        
        if ($this->input->post()) {
            $qr_data = array(
                'code' => $this->QRCode_model->generate_unique_code(),
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'location' => $this->input->post('location'),
                'created_by' => $this->session->userdata('user_id')
            );
            
            if ($this->QRCode_model->create_qr_code($qr_data)) {
                $this->session->set_flashdata('success', 'QR Code berhasil ditambahkan');
                redirect('admin/qr_codes');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan QR Code');
            }
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/qr_codes/add', $data);
        $this->load->view('templates/footer');
    }
    
    public function edit_qr_code($id) {
        $data['title'] = 'Edit QR Code';
        $data['qr_code'] = $this->QRCode_model->get_qr_code_by_id($id);
        
        if (!$data['qr_code']) {
            show_404();
        }
        
        if ($this->input->post()) {
            $update_data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'location' => $this->input->post('location')
            );
            
            if ($this->QRCode_model->update_qr_code($id, $update_data)) {
                $this->session->set_flashdata('success', 'QR Code berhasil diperbarui');
                redirect('admin/qr_codes');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui QR Code');
            }
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/qr_codes/edit', $data);
        $this->load->view('templates/footer');
    }
    
    public function delete_qr_code($id) {
        if ($this->QRCode_model->delete_qr_code($id)) {
            $this->session->set_flashdata('success', 'QR Code berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus QR Code');
        }
        redirect('admin/qr_codes');
    }
    
    public function toggle_qr_code_status($id, $status) {
        if ($this->QRCode_model->toggle_qr_code_status($id, $status)) {
            $this->session->set_flashdata('success', 'Status QR Code berhasil diubah');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengubah status QR Code');
        }
        redirect('admin/qr_codes');
    }
    
    // Reports
    public function reports() {
        $data['title'] = 'Laporan Absensi';
        $data['stats'] = $this->Attendance_model->get_overall_statistics();
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/reports/index', $data);
        $this->load->view('templates/footer');
    }
    
    public function weekly_report() {
        $data['title'] = 'Laporan Mingguan';
        
        $start_date = $this->input->get('start_date') ?: date('Y-m-d', strtotime('monday this week'));
        $end_date = $this->input->get('end_date') ?: date('Y-m-d', strtotime('sunday this week'));
        
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['weekly_data'] = $this->Attendance_model->get_weekly_report($start_date, $end_date);
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/reports/weekly', $data);
        $this->load->view('templates/footer');
    }
    
    public function monthly_report() {
        $data['title'] = 'Laporan Bulanan';
        
        $year = $this->input->get('year') ?: date('Y');
        $month = $this->input->get('month') ?: date('m');
        
        $data['year'] = $year;
        $data['month'] = $month;
        $data['monthly_data'] = $this->Attendance_model->get_monthly_report($year, $month);
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/reports/monthly', $data);
        $this->load->view('templates/footer');
    }
    
    public function export_weekly_report() {
        $start_date = $this->input->get('start_date') ?: date('Y-m-d', strtotime('monday this week'));
        $end_date = $this->input->get('end_date') ?: date('Y-m-d', strtotime('sunday this week'));
        
        $data = $this->Attendance_model->get_weekly_report($start_date, $end_date);
        
        // Export to CSV
        $filename = 'laporan_mingguan_' . $start_date . '_' . $end_date . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // CSV headers
        fputcsv($output, array('Nama', 'Departemen', 'Role', 'Total Hari', 'Hadir', 'Terlambat', 'Tidak Hadir', 'Total Jam'));
        
        // CSV data
        foreach ($data as $row) {
            fputcsv($output, array(
                $row->full_name,
                $row->department,
                $row->role,
                $row->total_days,
                $row->present_days,
                $row->late_days,
                $row->absent_days,
                $row->total_hours
            ));
        }
        
        fclose($output);
    }
    
    public function export_monthly_report() {
        $year = $this->input->get('year') ?: date('Y');
        $month = $this->input->get('month') ?: date('m');
        
        $data = $this->Attendance_model->get_monthly_report($year, $month);
        
        // Export to CSV
        $filename = 'laporan_bulanan_' . $year . '_' . str_pad($month, 2, '0', STR_PAD_LEFT) . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // CSV headers
        fputcsv($output, array('Nama', 'Departemen', 'Role', 'Total Hari', 'Hadir', 'Terlambat', 'Tidak Hadir', 'Total Jam'));
        
        // CSV data
        foreach ($data as $row) {
            fputcsv($output, array(
                $row->full_name,
                $row->department,
                $row->role,
                $row->total_days,
                $row->present_days,
                $row->late_days,
                $row->absent_days,
                $row->total_hours
            ));
        }
        
        fclose($output);
    }
    
    public function daily_report() {
        $data['title'] = 'Laporan Harian';
        
        $date = $this->input->get('date') ?: date('Y-m-d');
        
        $data['date'] = $date;
        $data['daily_data'] = $this->Attendance_model->get_daily_report($date);
        $data['summary'] = $this->Attendance_model->get_today_attendance_summary();
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/reports/daily', $data);
        $this->load->view('templates/footer');
    }
    
    public function export_daily_report() {
        $date = $this->input->get('date') ?: date('Y-m-d');
        
        $data = $this->Attendance_model->get_daily_report($date);
        
        // Export to CSV
        $filename = 'laporan_harian_' . $date . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // CSV headers
        fputcsv($output, array('Nama', 'Departemen', 'Role', 'Jam Masuk', 'Jam Pulang', 'Jam Kerja', 'Status', 'Lokasi'));
        
        // CSV data
        foreach ($data as $row) {
            fputcsv($output, array(
                $row->full_name,
                $row->department,
                $row->role,
                $row->check_in ? date('H:i', strtotime($row->check_in)) : '-',
                $row->check_out ? date('H:i', strtotime($row->check_out)) : '-',
                $row->work_hours ? $row->work_hours . ' jam' : '-',
                $row->status,
                $row->location ?: 'N/A'
            ));
        }
        
        fclose($output);
    }
    
    public function user_report() {
        $data['title'] = 'Laporan Detail Pengguna';
        
        $user_id = $this->input->get('user_id');
        $start_date = $this->input->get('start_date') ?: date('Y-m-d', strtotime('-30 days'));
        $end_date = $this->input->get('end_date') ?: date('Y-m-d');
        
        if (!$user_id) {
            show_404();
        }
        
        $data['user'] = $this->User_model->get_user_by_id($user_id);
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['attendance_history'] = $this->Attendance_model->get_user_attendance_history($user_id, $start_date, $end_date);
        
        // Calculate summary
        $data['summary'] = (object) [
            'total_days' => count($data['attendance_history']),
            'present_days' => count(array_filter($data['attendance_history'], function($item) { return $item->status == 'present'; })),
            'late_days' => count(array_filter($data['attendance_history'], function($item) { return $item->status == 'late'; })),
            'total_hours' => array_sum(array_column($data['attendance_history'], 'work_hours'))
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/reports/user_detail', $data);
        $this->load->view('templates/footer');
    }
    
    public function export_user_report() {
        $user_id = $this->input->get('user_id');
        $start_date = $this->input->get('start_date') ?: date('Y-m-d', strtotime('-30 days'));
        $end_date = $this->input->get('end_date') ?: date('Y-m-d');
        
        if (!$user_id) {
            show_404();
        }
        
        $user = $this->User_model->get_user_by_id($user_id);
        $data = $this->Attendance_model->get_user_attendance_history($user_id, $start_date, $end_date);
        
        // Export to CSV
        $filename = 'laporan_' . strtolower(str_replace(' ', '_', $user->full_name)) . '_' . $start_date . '_' . $end_date . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // CSV headers
        fputcsv($output, array('Tanggal', 'Jam Masuk', 'Jam Pulang', 'Jam Kerja', 'Status', 'Lokasi'));
        
        // CSV data
        foreach ($data as $row) {
            fputcsv($output, array(
                date('d/m/Y', strtotime($row->created_at)),
                $row->check_in ? date('H:i', strtotime($row->check_in)) : '-',
                $row->check_out ? date('H:i', strtotime($row->check_out)) : '-',
                $row->work_hours ? $row->work_hours . ' jam' : '-',
                $row->status,
                $row->location ?: 'N/A'
            ));
        }
        
        fclose($output);
    }
}
