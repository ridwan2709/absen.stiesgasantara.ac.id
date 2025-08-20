<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Attendance_model');
        $this->load->model('QRCode_model');
        $this->load->library('session');
        $this->load->helper('url');
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }
    
    // Check in process
    public function check_in() {
        $response = array('success' => false, 'message' => '');
        
        if ($this->input->post()) {
            $qr_code = $this->input->post('qr_code');
            $user_id = $this->session->userdata('user_id');
            
            if (empty($qr_code)) {
                $response['message'] = 'QR Code tidak valid';
                echo json_encode($response);
                return;
            }
            
            // Verify QR code
            $qr_data = $this->QRCode_model->get_qr_code_by_code($qr_code);
            if (!$qr_data) {
                $response['message'] = 'QR Code tidak valid atau sudah tidak aktif';
                echo json_encode($response);
                return;
            }
            
            // Check if user already has attendance today
            $today_attendance = $this->Attendance_model->get_attendance_by_user_date($user_id, date('Y-m-d'));
            
            if ($today_attendance) {
                if ($today_attendance->check_out) {
                    $response['message'] = 'Anda sudah melakukan absensi masuk dan pulang hari ini';
                } else {
                    $response['message'] = 'Anda sudah melakukan absensi masuk hari ini';
                }
                echo json_encode($response);
                return;
            }
            
            // Create check-in record
            $attendance_id = $this->Attendance_model->create_check_in($user_id, $qr_data->id);
            
            if ($attendance_id) {
                $response['success'] = true;
                $response['message'] = 'Absensi masuk berhasil dicatat';
                $response['attendance_id'] = $attendance_id;
                $response['check_in_time'] = date('Y-m-d H:i:s');
            } else {
                $response['message'] = 'Gagal mencatat absensi masuk';
            }
        }
        
        echo json_encode($response);
    }
    
    // Check out process
    public function check_out() {
        $response = array('success' => false, 'message' => '');
        
        if ($this->input->post()) {
            $qr_code = $this->input->post('qr_code');
            $user_id = $this->session->userdata('user_id');
            
            if (empty($qr_code)) {
                $response['message'] = 'QR Code tidak valid';
                echo json_encode($response);
                return;
            }
            
            // Verify QR code
            $qr_data = $this->QRCode_model->get_qr_code_by_code($qr_code);
            if (!$qr_data) {
                $response['message'] = 'QR Code tidak valid atau sudah tidak aktif';
                echo json_encode($response);
                return;
            }
            
            // Check if user has attendance today
            $today_attendance = $this->Attendance_model->get_attendance_by_user_date($user_id, date('Y-m-d'));
            
            if (!$today_attendance) {
                $response['message'] = 'Anda belum melakukan absensi masuk hari ini';
                echo json_encode($response);
                return;
            }
            
            if ($today_attendance->check_out) {
                $response['message'] = 'Anda sudah melakukan absensi pulang hari ini';
                echo json_encode($response);
                return;
            }
            
            // Update check-out record
            if ($this->Attendance_model->update_check_out($today_attendance->id)) {
                $response['success'] = true;
                $response['message'] = 'Absensi pulang berhasil dicatat';
                $response['check_out_time'] = date('Y-m-d H:i:s');
                
                // Get updated attendance data
                $updated_attendance = $this->Attendance_model->get_attendance_by_id($today_attendance->id);
                $response['work_hours'] = $updated_attendance->work_hours;
            } else {
                $response['message'] = 'Gagal mencatat absensi pulang';
            }
        }
        
        echo json_encode($response);
    }
    
    // Get attendance status for today
    public function get_today_status() {
        $response = array('success' => false, 'data' => null);
        
        $user_id = $this->session->userdata('user_id');
        $today_attendance = $this->Attendance_model->get_attendance_by_user_date($user_id, date('Y-m-d'));
        
        if ($today_attendance) {
            $response['success'] = true;
            $response['data'] = array(
                'check_in' => $today_attendance->check_in,
                'check_out' => $today_attendance->check_out,
                'status' => $today_attendance->status,
                'work_hours' => $today_attendance->work_hours
            );
        }
        
        echo json_encode($response);
    }
    
    // Manual attendance entry (for admin)
    public function manual_entry() {
        // Check if user is admin
        if ($this->session->userdata('role') !== 'admin') {
            redirect('dashboard');
        }
        
        $data['title'] = 'Input Absensi Manual';
        $data['users'] = $this->db->where('role !=', 'admin')->where('is_active', 1)->get('users')->result();
        $data['qr_codes'] = $this->QRCode_model->get_active_qr_codes();
        
        if ($this->input->post()) {
            $user_id = $this->input->post('user_id');
            $qr_code_id = $this->input->post('qr_code_id');
            $check_in = $this->input->post('check_in');
            $check_out = $this->input->post('check_out');
            $status = $this->input->post('status');
            $notes = $this->input->post('notes');
            
            // Check if attendance already exists for the date
            $attendance_date = date('Y-m-d', strtotime($check_in));
            $existing_attendance = $this->Attendance_model->get_attendance_by_user_date($user_id, $attendance_date);
            
            if ($existing_attendance) {
                $this->session->set_flashdata('error', 'Absensi untuk tanggal tersebut sudah ada');
            } else {
                $attendance_data = array(
                    'user_id' => $user_id,
                    'qr_code_id' => $qr_code_id,
                    'check_in' => $check_in,
                    'check_out' => $check_out ?: null,
                    'status' => $status,
                    'notes' => $notes,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                );
                
                // Calculate work hours if check-out is provided
                if ($check_out) {
                    $check_in_time = new DateTime($check_in);
                    $check_out_time = new DateTime($check_out);
                    $interval = $check_in_time->diff($check_out_time);
                    $attendance_data['work_hours'] = round($interval->h + ($interval->i / 60), 2);
                }
                
                if ($this->db->insert('attendance', $attendance_data)) {
                    $this->session->set_flashdata('success', 'Absensi berhasil ditambahkan');
                    redirect('admin/reports');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambahkan absensi');
                }
            }
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/attendance/manual_entry', $data);
        $this->load->view('templates/footer');
    }
    
    // Bulk attendance import (for admin)
    public function bulk_import() {
        // Check if user is admin
        if ($this->session->userdata('role') !== 'admin') {
            redirect('dashboard');
        }
        
        $data['title'] = 'Import Absensi Bulk';
        
        if ($this->input->post()) {
            // Handle file upload and CSV processing
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'csv';
            $config['max_size'] = 2048;
            
            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload('csv_file')) {
                $upload_data = $this->upload->data();
                $file_path = $upload_data['full_path'];
                
                // Process CSV file
                $imported = 0;
                $errors = 0;
                
                if (($handle = fopen($file_path, "r")) !== FALSE) {
                    $row = 1;
                    while (($data_csv = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        if ($row == 1) { // Skip header
                            $row++;
                            continue;
                        }
                        
                        // Process each row
                        $user_id = $data_csv[0];
                        $qr_code_id = $data_csv[1];
                        $check_in = $data_csv[2];
                        $check_out = $data_csv[3];
                        $status = $data_csv[4];
                        
                        // Validate data
                        if ($this->validate_attendance_data($user_id, $qr_code_id, $check_in, $check_out, $status)) {
                            $attendance_data = array(
                                'user_id' => $user_id,
                                'qr_code_id' => $qr_code_id,
                                'check_in' => $check_in,
                                'check_out' => $check_out ?: null,
                                'status' => $status,
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s')
                            );
                            
                            if ($this->db->insert('attendance', $attendance_data)) {
                                $imported++;
                            } else {
                                $errors++;
                            }
                        } else {
                            $errors++;
                        }
                        
                        $row++;
                    }
                    fclose($handle);
                }
                
                // Clean up uploaded file
                unlink($file_path);
                
                $this->session->set_flashdata('success', "Import selesai. Berhasil: $imported, Gagal: $errors");
                redirect('admin/reports');
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
            }
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/attendance/bulk_import', $data);
        $this->load->view('templates/footer');
    }
    
    // Validate attendance data for import
    private function validate_attendance_data($user_id, $qr_code_id, $check_in, $check_out, $status) {
        // Check if user exists and is active
        $user = $this->db->where('id', $user_id)->where('is_active', 1)->get('users')->row();
        if (!$user) return false;
        
        // Check if QR code exists and is active
        $qr_code = $this->db->where('id', $qr_code_id)->where('is_active', 1)->get('qr_codes')->row();
        if (!$qr_code) return false;
        
        // Validate dates
        if (!strtotime($check_in)) return false;
        if ($check_out && !strtotime($check_out)) return false;
        
        // Validate status
        $valid_statuses = array('present', 'late', 'absent', 'half_day');
        if (!in_array($status, $valid_statuses)) return false;
        
        return true;
    }
}
