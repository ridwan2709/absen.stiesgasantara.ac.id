<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Attendance_model');
        $this->load->model('QRCode_model');
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        
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
    
    public function duplicate_qr_code($id) {
        $original_qr = $this->QRCode_model->get_qr_code_by_id($id);
        
        if (!$original_qr) {
            show_404();
        }
        
        $qr_data = array(
            'code' => $this->QRCode_model->generate_unique_code(),
            'name' => $original_qr->name . ' (Copy)',
            'description' => $original_qr->description,
            'location' => $original_qr->location,
            'created_by' => $this->session->userdata('user_id')
        );
        
        if ($this->QRCode_model->create_qr_code($qr_data)) {
            $this->session->set_flashdata('success', 'QR Code berhasil diduplikasi');
        } else {
            $this->session->set_flashdata('error', 'Gagal menduplikasi QR Code');
        }
        redirect('admin/qr_codes');
    }

    public function view_qr_code($id) {
        $data['title'] = 'Lihat QR Code';
        $data['qr_code'] = $this->QRCode_model->get_qr_code_by_id($id);
        
        if (!$data['qr_code']) {
            show_404();
        }
        
        // Get usage statistics
        $data['usage_stats'] = $this->QRCode_model->get_qr_code_detailed_stats($id);
        
        // Get recent usage
        $data['recent_usage'] = $this->QRCode_model->get_qr_code_recent_usage($id, 10);

        $this->load->view('templates/header', $data);
        $this->load->view('admin/qr_codes/view', $data);
        $this->load->view('templates/footer');
    }
    
    public function qr_code_usage($qr_code_id) {
        $data['title'] = 'Riwayat Penggunaan QR Code';
        $data['qr_code'] = $this->QRCode_model->get_qr_code_by_id($qr_code_id);
        
        if (!$data['qr_code']) {
            show_404();
        }
        
        // Get date range from GET parameters
        $start_date = $this->input->get('start_date') ?: date('Y-m-d', strtotime('-30 days'));
        $end_date = $this->input->get('end_date') ?: date('Y-m-d');
        
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        
        // Get usage statistics for the date range
        $data['usage_stats'] = $this->QRCode_model->get_qr_code_usage($qr_code_id, $start_date, $end_date);
        
        // Get all usage records for the date range
        $data['usage_records'] = $this->QRCode_model->get_qr_code_recent_usage($qr_code_id, 1000); // Large limit to get all records
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/qr_codes/usage', $data);
        $this->load->view('templates/footer');
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
    
    // Lecturer Report
    public function lecturer_report() {
        $data['title'] = 'Laporan Absensi Dosen';
        
        // Date range
        $start_date = $this->input->get('start_date') ?: date('Y-m-01');
        $end_date = $this->input->get('end_date') ?: date('Y-m-d');
        $selected_lecturer = $this->input->get('lecturer') ?: '';
        $selected_subject = $this->input->get('subject') ?: '';
        
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['selected_lecturer'] = $selected_lecturer;
        $data['selected_subject'] = $selected_subject;
        
        // Get all lecturers
        $data['lecturers'] = $this->User_model->get_users_by_role('dosen');
        
        // Get all subjects
        $data['subjects'] = $this->Attendance_model->get_all_subjects();
        
        // Get lecturer attendance with filters
        $data['lecturer_attendance'] = $this->Attendance_model->get_filtered_lecturer_attendance(
            $start_date, $end_date, $selected_lecturer, $selected_subject
        );
        
        // Summary statistics
        $data['summary'] = $this->Attendance_model->get_lecturer_summary_stats(
            $start_date, $end_date, $selected_lecturer, $selected_subject
        );
        
        // Subject summary
        $data['subject_summary'] = $this->Attendance_model->get_subject_summary_stats(
            $start_date, $end_date, $selected_lecturer
        );
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/reports/lecturer_report', $data);
        $this->load->view('templates/footer');
    }
    
    // Export lecturer report to CSV
    public function export_lecturer_report() {
        $start_date = $this->input->get('start_date') ?: date('Y-m-01');
        $end_date = $this->input->get('end_date') ?: date('Y-m-d');
        $selected_lecturer = $this->input->get('lecturer') ?: '';
        $selected_subject = $this->input->get('subject') ?: '';
        
        $data = $this->Attendance_model->get_filtered_lecturer_attendance(
            $start_date, $end_date, $selected_lecturer, $selected_subject
        );
        
        // Set headers for CSV download
        $filename = 'laporan_dosen_' . date('Y-m-d_H-i-s') . '.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        // Create file pointer
        $output = fopen('php://output', 'w');
        
        // Add BOM for UTF-8
        fputs($output, "\xEF\xBB\xBF");
        
        // CSV Headers
        fputcsv($output, [
            'No',
            'Tanggal',
            'Dosen',
            'NIP/NIDN',
            'Mata Kuliah',
            'Kelas',
            'Waktu',
            'Status',
            'Lokasi',
            'Keterangan'
        ]);
        
        // CSV Data
        $no = 1;
        foreach ($data as $record) {
            fputcsv($output, [
                $no++,
                date('d/m/Y', strtotime($record->created_at)),
                $record->full_name,
                $record->nip_nidn ?: '-',
                $record->subject,
                $record->class_name,
                date('H:i', strtotime($record->check_in)),
                $record->status == 'present' ? 'Tepat Waktu' : 
                    ($record->status == 'late' ? 'Terlambat' : ucfirst($record->status)),
                $record->location,
                $record->lecture_notes ?: '-'
            ]);
        }
        
        fclose($output);
    }
}
