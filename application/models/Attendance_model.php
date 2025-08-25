<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Get attendance by user ID and date
    public function get_attendance_by_user_date($user_id, $date) {
        $this->db->select('*');
        $this->db->from('attendance');
        $this->db->where('user_id', $user_id);
        $this->db->where('DATE(created_at)', $date);
        return $this->db->get()->row();
    }
    
    // Create check-in
    public function create_check_in($user_id, $qr_code_id) {
        $data = array(
            'user_id' => $user_id,
            'qr_code_id' => $qr_code_id,
            'check_in' => date('Y-m-d H:i:s'),
            'status' => $this->determine_status(),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        
        $this->db->insert('attendance', $data);
        return $this->db->insert_id();
    }
    
    // Update check-out
    public function update_check_out($attendance_id) {
        $check_out_time = date('Y-m-d H:i:s');
        
        // Get check-in time to calculate work hours
        $attendance = $this->get_attendance_by_id($attendance_id);
        if ($attendance) {
            $check_in = new DateTime($attendance->check_in);
            $check_out = new DateTime($check_out_time);
            $interval = $check_in->diff($check_out);
            $work_hours = $interval->h + ($interval->i / 60);
            
            $data = array(
                'check_out' => $check_out_time,
                'work_hours' => round($work_hours, 2),
                'updated_at' => date('Y-m-d H:i:s')
            );
            
            $this->db->where('id', $attendance_id);
            return $this->db->update('attendance', $data);
        }
        return false;
    }
    
    // Get attendance by ID
    public function get_attendance_by_id($id) {
        $this->db->select('*');
        $this->db->from('attendance');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }
    
    // Get user attendance history
    public function get_user_attendance_history($user_id, $start_date = null, $end_date = null) {
        $this->db->select('a.*, q.name as qr_name, q.location');
        $this->db->from('attendance a');
        $this->db->join('qr_codes q', 'q.id = a.qr_code_id');
        $this->db->where('a.user_id', $user_id);
        
        if ($start_date && $end_date) {
            $this->db->where('DATE(a.created_at) >=', $start_date);
            $this->db->where('DATE(a.created_at) <=', $end_date);
        }
        
        $this->db->order_by('a.created_at', 'DESC');
        return $this->db->get()->result();
    }
    
    // Get weekly report
    public function get_weekly_report($start_date, $end_date) {
        $this->db->select('u.id, u.full_name, u.department, u.role');
        $this->db->select('COUNT(a.id) as total_days');
        $this->db->select('SUM(CASE WHEN a.status = "present" THEN 1 ELSE 0 END) as present_days');
        $this->db->select('SUM(CASE WHEN a.status = "late" THEN 1 ELSE 0 END) as late_days');
        $this->db->select('SUM(CASE WHEN a.status = "absent" THEN 1 ELSE 0 END) as absent_days');
        $this->db->select('SUM(a.work_hours) as total_hours');
        $this->db->from('users u');
        $this->db->join('attendance a', 'u.id = a.user_id', 'left');
        $this->db->where('u.role !=', 'admin');
        $this->db->where('u.is_active', 1);
        $this->db->where('DATE(a.created_at) >=', $start_date);
        $this->db->where('DATE(a.created_at) <=', $end_date);
        $this->db->group_by('u.id');
        $this->db->order_by('u.full_name', 'ASC');
        return $this->db->get()->result();
    }
    
    // Get monthly report
    public function get_monthly_report($year, $month) {
        $start_date = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01';
        $end_date = date('Y-m-t', strtotime($start_date));
        
        return $this->get_weekly_report($start_date, $end_date);
    }
    
    // Get today's attendance summary
    public function get_today_attendance_summary() {
        $today = date('Y-m-d');
        
        $this->db->select('COUNT(DISTINCT u.id) as total_users');
        $this->db->select('COUNT(DISTINCT a.user_id) as present_users');
        $this->db->select('COUNT(CASE WHEN a.status = "late" THEN 1 END) as late_users');
        $this->db->from('users u');
        $this->db->join('attendance a', 'u.id = a.user_id AND DATE(a.created_at) = "' . $today . '"', 'left');
        $this->db->where('u.role !=', 'admin');
        $this->db->where('u.is_active', 1);
        
        return $this->db->get()->row();
    }
    
    // Get daily report for specific date
    public function get_daily_report($date) {
        $this->db->select('a.*, u.full_name, u.department, u.role, q.location');
        $this->db->from('attendance a');
        $this->db->join('users u', 'u.id = a.user_id');
        $this->db->join('qr_codes q', 'q.id = a.qr_code_id', 'left');
        $this->db->where('DATE(a.created_at)', $date);
        $this->db->order_by('a.check_in', 'ASC');
        return $this->db->get()->result();
    }
    
    // Get daily report with all users (including absent)
    public function get_daily_report_complete($date) {
        // Get all active users
        $this->db->select('u.id, u.full_name, u.department, u.role');
        $this->db->from('users u');
        $this->db->where('u.role !=', 'admin');
        $this->db->where('u.is_active', 1);
        $users = $this->db->get()->result();
        
        $result = array();
        foreach ($users as $user) {
            // Get attendance for this user on this date
            $attendance = $this->get_attendance_by_user_date($user->id, $date);
            
            if ($attendance) {
                $user->check_in = $attendance->check_in;
                $user->check_out = $attendance->check_out;
                $user->work_hours = $attendance->work_hours;
                $user->status = $attendance->status;
                $user->location = $attendance->location;
            } else {
                $user->check_in = null;
                $user->check_out = null;
                $user->work_hours = null;
                $user->status = 'absent';
                $user->location = null;
            }
            
            $result[] = $user;
        }
        
        return $result;
    }
    
    // Get overall attendance statistics
    public function get_overall_statistics() {
        $today = date('Y-m-d');
        $this_month = date('Y-m');
        $this_year = date('Y');
        
        // Today's statistics
        $today_stats = $this->get_today_attendance_summary();
        
        // This month's statistics
        $monthly_data = $this->get_monthly_report(date('Y'), date('m'));
        $monthly_stats = (object) [
            'total_users' => count($monthly_data),
            'total_attendance' => array_sum(array_column($monthly_data, 'present_days')),
            'total_late' => array_sum(array_column($monthly_data, 'late_days')),
            'total_hours' => array_sum(array_column($monthly_data, 'total_hours'))
        ];
        
        // This year's statistics
        $year_start = $this_year . '-01-01';
        $year_end = $this_year . '-12-31';
        $yearly_data = $this->get_weekly_report($year_start, $year_end);
        $yearly_stats = (object) [
            'total_users' => count($yearly_data),
            'total_attendance' => array_sum(array_column($yearly_data, 'present_days')),
            'total_late' => array_sum(array_column($yearly_data, 'late_days')),
            'total_hours' => array_sum(array_column($yearly_data, 'total_hours'))
        ];
        
        return (object) [
            'today' => $today_stats,
            'monthly' => $monthly_stats,
            'yearly' => $yearly_stats
        ];
    }
    
    // Determine attendance status based on time
    private function determine_status() {
        $current_time = date('H:i:s');
        $work_start = $this->get_setting('work_start_time');
        $late_threshold = $this->get_setting('late_threshold');
        
        if ($current_time <= $work_start) {
            return 'present';
        } else {
            $start_time = strtotime($work_start);
            $current_timestamp = strtotime($current_time);
            $diff_minutes = ($current_timestamp - $start_time) / 60;
            
            if ($diff_minutes <= $late_threshold) {
                return 'late';
            } else {
                return 'late';
            }
        }
    }
    
    // Get setting value
    private function get_setting($key) {
        $this->db->select('setting_value');
        $this->db->from('settings');
        $this->db->where('setting_key', $key);
        $result = $this->db->get()->row();
        return $result ? $result->setting_value : null;
    }
    
    // Create lecturer attendance with subject and class info
    public function create_lecturer_attendance($data) {
        // Ensure required fields are present
        $required_fields = ['user_id', 'qr_code_id', 'subject', 'class_name', 'lecture_photo'];
        foreach ($required_fields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                log_message('error', 'Missing required field: ' . $field . ' in create_lecturer_attendance');
                return false;
            }
        }
        
        // Log the data being inserted
        log_message('info', 'Creating lecturer attendance: ' . json_encode($data));
        
        $this->db->insert('attendance', $data);
        $insert_id = $this->db->insert_id();
        
        if ($insert_id) {
            log_message('info', 'Lecturer attendance created successfully with ID: ' . $insert_id);
            return $insert_id;
        } else {
            log_message('error', 'Failed to create lecturer attendance: ' . $this->db->error()['message']);
            return false;
        }
    }
    
    // Get lecturer attendance for today with specific subject and class
    public function get_lecturer_attendance_today($user_id, $subject, $class_name, $date) {
        $this->db->select('*');
        $this->db->from('attendance');
        $this->db->where('user_id', $user_id);
        $this->db->where('subject', $subject);
        $this->db->where('class_name', $class_name);
        $this->db->where('DATE(created_at)', $date);
        return $this->db->get()->row();
    }
    
    // Get lecturer attendance history with subject and class details
    public function get_lecturer_attendance_history($user_id, $start_date = null, $end_date = null) {
        $this->db->select('a.*, q.name as qr_name, q.location');
        $this->db->from('attendance a');
        $this->db->join('qr_codes q', 'q.id = a.qr_code_id');
        $this->db->where('a.user_id', $user_id);
        $this->db->where('a.subject IS NOT NULL'); // Only lecturer attendance
        
        if ($start_date && $end_date) {
            $this->db->where('DATE(a.created_at) >=', $start_date);
            $this->db->where('DATE(a.created_at) <=', $end_date);
        }
        
        $this->db->order_by('a.created_at', 'DESC');
        return $this->db->get()->result();
    }
    
    // Get lecturer teaching statistics
    public function get_lecturer_teaching_stats($user_id, $start_date = null, $end_date = null) {
        $this->db->select('COUNT(*) as total_classes');
        $this->db->select('COUNT(DISTINCT subject) as total_subjects');
        $this->db->select('COUNT(DISTINCT class_name) as total_class_names');
        $this->db->select('COUNT(DISTINCT CONCAT(subject, "_", class_name)) as unique_subject_class');
        $this->db->from('attendance');
        $this->db->where('user_id', $user_id);
        $this->db->where('subject IS NOT NULL');
        
        if ($start_date && $end_date) {
            $this->db->where('DATE(created_at) >=', $start_date);
            $this->db->where('DATE(created_at) <=', $end_date);
        }
        
        return $this->db->get()->row();
    }
    
    // Get subject and class list for a lecturer
    public function get_lecturer_subjects_classes($user_id, $start_date = null, $end_date = null) {
        $this->db->select('subject, class_name, COUNT(*) as total_sessions');
        $this->db->select('MIN(created_at) as first_session');
        $this->db->select('MAX(created_at) as last_session');
        $this->db->from('attendance');
        $this->db->where('user_id', $user_id);
        $this->db->where('subject IS NOT NULL');
        
        if ($start_date && $end_date) {
            $this->db->where('DATE(created_at) >=', $start_date);
            $this->db->where('DATE(created_at) <=', $end_date);
        }
        
        $this->db->group_by(['subject', 'class_name']);
        $this->db->order_by('subject', 'ASC');
        $this->db->order_by('class_name', 'ASC');
        
        return $this->db->get()->result();
    }
    
    // Get all lecturer attendance records (for admin reports)
    public function get_all_lecturer_attendance($start_date = null, $end_date = null) {
        $this->db->select('a.*, u.full_name, u.nip_nidn, q.name as qr_name, q.location');
        $this->db->from('attendance a');
        $this->db->join('users u', 'u.id = a.user_id');
        $this->db->join('qr_codes q', 'q.id = a.qr_code_id');
        $this->db->where('u.role', 'dosen');
        $this->db->where('a.subject IS NOT NULL');
        
        if ($start_date && $end_date) {
            $this->db->where('DATE(a.created_at) >=', $start_date);
            $this->db->where('DATE(a.created_at) <=', $end_date);
        }
        
        $this->db->order_by('a.created_at', 'DESC');
        return $this->db->get()->result();
    }
    
    // Get all unique subjects from attendance
    public function get_all_subjects() {
        $this->db->select('DISTINCT subject');
        $this->db->from('attendance');
        $this->db->where('subject IS NOT NULL');
        $this->db->where('subject !=', '');
        $this->db->order_by('subject', 'ASC');
        return $this->db->get()->result();
    }
    
    // Get filtered lecturer attendance
    public function get_filtered_lecturer_attendance($start_date, $end_date, $lecturer_id = '', $subject = '') {
        $this->db->select('a.*, u.full_name, u.nip_nidn, q.name as qr_name, q.location');
        $this->db->from('attendance a');
        $this->db->join('users u', 'u.id = a.user_id');
        $this->db->join('qr_codes q', 'q.id = a.qr_code_id');
        $this->db->where('u.role', 'dosen');
        $this->db->where('a.subject IS NOT NULL');
        $this->db->where('DATE(a.created_at) >=', $start_date);
        $this->db->where('DATE(a.created_at) <=', $end_date);
        
        if ($lecturer_id) {
            $this->db->where('a.user_id', $lecturer_id);
        }
        
        if ($subject) {
            $this->db->where('a.subject', $subject);
        }
        
        $this->db->order_by('a.created_at', 'DESC');
        return $this->db->get()->result();
    }
    
    // Get lecturer summary statistics
    public function get_lecturer_summary_stats($start_date, $end_date, $lecturer_id = '', $subject = '') {
        $this->db->select('COUNT(*) as total_sessions');
        $this->db->select('COUNT(DISTINCT a.subject) as total_subjects');
        $this->db->select('COUNT(DISTINCT a.class_name) as total_classes');
        $this->db->select('COUNT(DISTINCT a.user_id) as active_lecturers');
        $this->db->from('attendance a');
        $this->db->join('users u', 'u.id = a.user_id');
        $this->db->where('u.role', 'dosen');
        $this->db->where('a.subject IS NOT NULL');
        $this->db->where('DATE(a.created_at) >=', $start_date);
        $this->db->where('DATE(a.created_at) <=', $end_date);
        
        if ($lecturer_id) {
            $this->db->where('a.user_id', $lecturer_id);
        }
        
        if ($subject) {
            $this->db->where('a.subject', $subject);
        }
        
        return $this->db->get()->row();
    }
    
    // Get subject summary statistics
    public function get_subject_summary_stats($start_date, $end_date, $lecturer_id = '') {
        $days_diff = (strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24) + 1;
        
        $this->db->select('a.subject');
        $this->db->select('COUNT(DISTINCT a.class_name) as total_classes');
        $this->db->select('COUNT(*) as total_sessions');
        $this->db->select('COUNT(DISTINCT a.user_id) as lecturer_count');
        $this->db->select('ROUND(COUNT(*) / ' . $days_diff . ', 1) as avg_sessions_per_day');
        $this->db->from('attendance a');
        $this->db->join('users u', 'u.id = a.user_id');
        $this->db->where('u.role', 'dosen');
        $this->db->where('a.subject IS NOT NULL');
        $this->db->where('DATE(a.created_at) >=', $start_date);
        $this->db->where('DATE(a.created_at) <=', $end_date);
        
        if ($lecturer_id) {
            $this->db->where('a.user_id', $lecturer_id);
        }
        
        $this->db->group_by('a.subject');
        $this->db->order_by('total_sessions', 'DESC');
        
        return $this->db->get()->result();
    }
}
