<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper('url');
    }
    
    public function index() {
        // Redirect to login if not logged in
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        
        $this->load->view('auth/login');
    }
    
    public function login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        
        if (empty($username) || empty($password)) {
            $this->session->set_flashdata('error', 'Username dan password harus diisi');
            redirect('auth');
        }
        
        $user = $this->User_model->get_user_by_username($username);

        if (password_verify($password, $user->password)) {
            if (!$user->is_active) {
                $this->session->set_flashdata('error', 'Akun Anda telah dinonaktifkan');
                redirect('auth');
            }
            
            // Set session data
            $session_data = array(
                'user_id' => $user->id,
                'username' => $user->username,
                'full_name' => $user->full_name,
                'role' => $user->role,
                'department' => $user->department,
                'is_default_password' => $user->is_default_password,
                'logged_in' => TRUE
            );
            
            $this->session->set_userdata($session_data);
            
            // Log login activity
            log_message('info', 'User ' . $username . ' logged in successfully');
            
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', 'Username atau password salah');
            redirect('auth');
        }
    }
    
    public function logout() {
        $username = $this->session->userdata('username');
        
        // Log logout activity
        if ($username) {
            log_message('info', 'User ' . $username . ' logged out');
        }
        
        // Destroy session
        $this->session->sess_destroy();
        
        $this->session->set_flashdata('success', 'Anda telah berhasil logout');
        redirect('auth');
    }
    
    public function change_password() {
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        
        if ($this->input->post()) {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password');
            $confirm_password = $this->input->post('confirm_password');
            
            // Validation
            if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
                $this->session->set_flashdata('error', 'Semua field harus diisi');
                redirect('auth/change_password');
            }
            
            if ($new_password !== $confirm_password) {
                $this->session->set_flashdata('error', 'Password baru dan konfirmasi password tidak cocok');
                redirect('auth/change_password');
            }
            
            if (strlen($new_password) < 6) {
                $this->session->set_flashdata('error', 'Password minimal 6 karakter');
                redirect('auth/change_password');
            }
            
            // Verify current password
            $user = $this->User_model->get_user_by_id($this->session->userdata('user_id'));
            if (!password_verify($current_password, $user->password)) {
                $this->session->set_flashdata('error', 'Password saat ini salah');
                redirect('auth/change_password');
            }
            
            // Update password
            $update_data = array('password' => $new_password);
            if ($this->User_model->update_user($user->id, $update_data)) {
                $this->session->set_flashdata('success', 'Password berhasil diubah');
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengubah password');
                redirect('auth/change_password');
            }
        }
        
        $this->load->view('auth/change_password');
    }
    
    public function forgot_password() {
        if ($this->input->post()) {
            $email = $this->input->post('email');
            
            if (empty($email)) {
                $this->session->set_flashdata('error', 'Email harus diisi');
                redirect('auth/forgot_password');
            }
            
            // Check if email exists
            $user = $this->db->where('email', $email)->get('users')->row();
            if ($user) {
                // Generate reset token (simple implementation)
                $reset_token = md5(uniqid() . time());
                $this->db->where('id', $user->id)->update('users', array('reset_token' => $reset_token));
                
                // Send email (implement email functionality)
                $this->session->set_flashdata('success', 'Link reset password telah dikirim ke email Anda');
            } else {
                $this->session->set_flashdata('error', 'Email tidak ditemukan');
            }
            
            redirect('auth/forgot_password');
        }
        
        $this->load->view('auth/forgot_password');
    }
}
