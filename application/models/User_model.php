<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Get all users
    public function get_all_users() {
        $this->db->select('id, username, email, full_name, role, nip_nidn, department, phone, address, is_active, created_at');
        $this->db->from('users');
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result();
    }
    
    // Get user by ID
    public function get_user_by_id($id) {
        $this->db->select('id, username, email, full_name, role, nip_nidn, department, phone, address, is_active, created_at');
        $this->db->from('users');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }
    
    // Get user by username
    public function get_user_by_username($username) {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('username', $username);
        $this->db->where('is_active', 1);
        return $this->db->get()->row();
    }
    
    // Get users by role
    public function get_users_by_role($role) {
        $this->db->select('id, username, email, full_name, role, nip_nidn, department, phone, address, is_active, created_at');
        $this->db->from('users');
        $this->db->where('role', $role);
        $this->db->where('is_active', 1);
        $this->db->order_by('full_name', 'ASC');
        return $this->db->get()->result();
    }
    
    // Create new user
    public function create_user($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }
    
    // Update user
    public function update_user($id, $data) {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }
    
    // Delete user
    public function delete_user($id) {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }
    
    // Activate/Deactivate user
    public function toggle_user_status($id, $status) {
        $this->db->where('id', $id);
        return $this->db->update('users', array('is_active' => $status, 'updated_at' => date('Y-m-d H:i:s')));
    }
    
    // Count users by role
    public function count_users_by_role($role) {
        $this->db->where('role', $role);
        $this->db->where('is_active', 1);
        return $this->db->count_all_results('users');
    }
    
    // Get total users
    public function get_total_users() {
        return $this->db->count_all('users');
    }
}
