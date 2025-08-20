<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QRCode_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Get all QR codes
    public function get_all_qr_codes() {
        $this->db->select('q.*, u.full_name as created_by_name');
        $this->db->from('qr_codes q');
        $this->db->join('users u', 'u.id = q.created_by', 'left');
        $this->db->order_by('q.created_at', 'DESC');
        return $this->db->get()->result();
    }
    
    // Get active QR codes
    public function get_active_qr_codes() {
        $this->db->select('*');
        $this->db->from('qr_codes');
        $this->db->where('is_active', 1);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result();
    }
    
    // Get QR code by ID
    public function get_qr_code_by_id($id) {
        $this->db->select('*');
        $this->db->from('qr_codes');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }
    
    // Get QR code by code
    public function get_qr_code_by_code($code) {
        $this->db->select('*');
        $this->db->from('qr_codes');
        $this->db->where('code', $code);
        $this->db->where('is_active', 1);
        return $this->db->get()->row();
    }
    
    // Create new QR code
    public function create_qr_code($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->insert('qr_codes', $data);
        return $this->db->insert_id();
    }
    
    // Update QR code
    public function update_qr_code($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', $id);
        return $this->db->update('qr_codes', $data);
    }
    
    // Delete QR code
    public function delete_qr_code($id) {
        $this->db->where('id', $id);
        return $this->db->delete('qr_codes');
    }
    
    // Toggle QR code status
    public function toggle_qr_code_status($id, $status) {
        $this->db->where('id', $id);
        return $this->db->update('qr_codes', array('is_active' => $status, 'updated_at' => date('Y-m-d H:i:s')));
    }
    
    // Generate unique QR code
    public function generate_unique_code() {
        $prefix = 'QR_' . date('Ymd_His');
        $random = strtoupper(substr(md5(uniqid()), 0, 8));
        $code = $prefix . '_' . $random;
        
        // Check if code already exists
        while ($this->code_exists($code)) {
            $random = strtoupper(substr(md5(uniqid()), 0, 8));
            $code = $prefix . '_' . $random;
        }
        
        return $code;
    }
    
    // Check if code exists
    private function code_exists($code) {
        $this->db->where('code', $code);
        return $this->db->count_all_results('qr_codes') > 0;
    }
    
    // Get QR code usage statistics
    public function get_qr_code_usage($qr_code_id, $start_date = null, $end_date = null) {
        $this->db->select('COUNT(*) as total_scans');
        $this->db->select('COUNT(DISTINCT user_id) as unique_users');
        $this->db->from('attendance');
        $this->db->where('qr_code_id', $qr_code_id);
        
        if ($start_date && $end_date) {
            $this->db->where('DATE(created_at) >=', $start_date);
            $this->db->where('DATE(created_at) <=', $end_date);
        }
        
        return $this->db->get()->row();
    }
    
    // Get total QR codes
    public function get_total_qr_codes() {
        return $this->db->count_all('qr_codes');
    }
    
    // Get active QR codes count
    public function get_active_qr_codes_count() {
        $this->db->where('is_active', 1);
        return $this->db->count_all_results('qr_codes');
    }
}
