<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Attendance_model');
        $this->load->model('QRCode_model');
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }
    
    public function index() {
        $data['user'] = $this->session->userdata();
        $data['title'] = 'Dashboard';
        
        // Check if user is using default password
        $data['show_password_warning'] = $this->session->userdata('is_default_password') == 1;
        
        // Get data based on user role
        switch ($data['user']['role']) {
            case 'admin':
                $data['total_users'] = $this->User_model->get_total_users();
                $data['total_staff'] = $this->User_model->count_users_by_role('staff');
                $data['total_dosen'] = $this->User_model->count_users_by_role('dosen');
                $data['total_qr_codes'] = $this->QRCode_model->get_total_qr_codes();
                $data['active_qr_codes'] = $this->QRCode_model->get_active_qr_codes_count();
                $data['today_summary'] = $this->Attendance_model->get_today_attendance_summary();
                $data['recent_attendance'] = $this->get_recent_attendance();
                break;
                
            case 'staff':
            case 'dosen':
                $data['today_attendance'] = $this->Attendance_model->get_attendance_by_user_date(
                    $data['user']['user_id'], 
                    date('Y-m-d')
                );
                $data['weekly_summary'] = $this->get_weekly_summary($data['user']['user_id']);
                $data['recent_history'] = $this->Attendance_model->get_user_attendance_history(
                    $data['user']['user_id'], 
                    null, 
                    null
                );
                break;
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }
    
    private function get_recent_attendance($limit = 10) {
        $this->db->select('a.*, u.full_name, u.department, q.name as qr_name');
        $this->db->from('attendance a');
        $this->db->join('users u', 'u.id = a.user_id');
        $this->db->join('qr_codes q', 'q.id = a.qr_code_id');
        $this->db->order_by('a.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
    
    private function get_weekly_summary($user_id) {
        $start_date = date('Y-m-d', strtotime('monday this week'));
        $end_date = date('Y-m-d', strtotime('sunday this week'));
        
        $this->db->select('COUNT(*) as total_days');
        $this->db->select('SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present_days');
        $this->db->select('SUM(CASE WHEN status = "late" THEN 1 ELSE 0 END) as late_days');
        $this->db->select('SUM(work_hours) as total_hours');
        $this->db->from('attendance');
        $this->db->where('user_id', $user_id);
        $this->db->where('DATE(created_at) >=', $start_date);
        $this->db->where('DATE(created_at) <=', $end_date);
        
        return $this->db->get()->row();
    }
    
    public function profile() {
        $data['title'] = 'Profile Saya';
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->User_model->get_user_by_id($user_id);
        
        if (!$data['user']) {
            show_404();
        }
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('full_name', 'Nama Lengkap', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
            $this->form_validation->set_rules('phone', 'Nomor Telepon', 'trim');
            $this->form_validation->set_rules('address', 'Alamat', 'trim');
            
            if ($this->form_validation->run() == TRUE) {
                // Check if email is already used by another user
                $this->db->where('email', $this->input->post('email'));
                $this->db->where('id !=', $user_id);
                $existing_email = $this->db->get('users')->row();
                
                if ($existing_email) {
                    $this->session->set_flashdata('error', 'Email sudah digunakan oleh pengguna lain');
                } else {
                    $update_data = array(
                        'full_name' => $this->input->post('full_name'),
                        'email' => $this->input->post('email'),
                        'phone' => $this->input->post('phone'),
                        'address' => $this->input->post('address')
                    );
                    
                    if ($this->User_model->update_user($user_id, $update_data)) {
                        // Update session data
                        $this->session->set_userdata('full_name', $update_data['full_name']);
                        $this->session->set_userdata('email', $update_data['email']);
                        
                        $this->session->set_flashdata('success', 'Profile berhasil diperbarui');
                        redirect('dashboard/profile');
                    } else {
                        $this->session->set_flashdata('error', 'Gagal memperbarui profile');
                    }
                }
            }
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/profile', $data);
        $this->load->view('templates/footer');
    }
    
    public function change_password() {
        $data['title'] = 'Ganti Password';
        $user_id = $this->session->userdata('user_id');
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('current_password', 'Password Saat Ini', 'required');
            $this->form_validation->set_rules('new_password', 'Password Baru', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[new_password]');
            
            if ($this->form_validation->run() == TRUE) {
                // Get current user data
                $this->db->where('id', $user_id);
                $user = $this->db->get('users')->row();
                
                // Verify current password
                if (password_verify($this->input->post('current_password'), $user->password)) {
                    $update_data = array(
                        'password' => $this->input->post('new_password')
                    );
                    
                    if ($this->User_model->update_user($user_id, $update_data)) {
                        $this->session->set_flashdata('success', 'Password berhasil diubah');
                        redirect('auth/logout');
                    } else {
                        $this->session->set_flashdata('error', 'Gagal mengubah password');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Password saat ini tidak benar');
                }
            }
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/change_password', $data);
        $this->load->view('templates/footer');
    }
    
    public function attendance_history() {
        $data['user'] = $this->session->userdata();
        $data['title'] = 'Riwayat Absensi';
        
        $start_date = $this->input->get('start_date') ?: date('Y-m-01');
        $end_date = $this->input->get('end_date') ?: date('Y-m-t');
        
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['attendance_history'] = $this->Attendance_model->get_user_attendance_history(
            $data['user']['user_id'],
            $start_date,
            $end_date
        );
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/attendance/index', $data);
        $this->load->view('templates/footer');
    }
    
    public function scan_qr() {
        $data['user'] = $this->session->userdata();
        $data['title'] = 'Scan QR Code';
        
        // Check if user already has attendance today
        $today_attendance = $this->Attendance_model->get_attendance_by_user_date(
            $data['user']['user_id'], 
            date('Y-m-d')
        );
        
        $data['today_attendance'] = $today_attendance;
        $data['qr_codes'] = $this->QRCode_model->get_active_qr_codes();
        
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/scan_qr', $data);
        $this->load->view('templates/footer');
    }
    
}
