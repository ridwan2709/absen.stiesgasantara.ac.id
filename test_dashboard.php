<?php
// Test Dashboard Controller functionality
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Dashboard Controller Test</h2>";

// Simulate CodeIgniter environment
define('BASEPATH', true);

// Include necessary files
require_once 'application/config/database.php';
require_once 'application/models/User_model.php';
require_once 'application/models/Attendance_model.php';
require_once 'application/models/QRCode_model.php';

try {
    // Test database connection
    $mysqli = new mysqli('127.0.0.1', 'root', 'root', 'attendance_management');
    
    if ($mysqli->connect_error) {
        throw new Exception("Connection failed: " . $mysqli->connect_error);
    }
    
    echo "<p style='color: green;'>Database connection successful!</p>";
    
    // Test User_model methods
    echo "<h3>Testing User Model:</h3>";
    
    // Test get_total_users
    $result = $mysqli->query("SELECT COUNT(*) as count FROM users");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "<p>Total users: " . $row['count'] . "</p>";
    }
    
    // Test count_users_by_role for staff
    $result = $mysqli->query("SELECT COUNT(*) as count FROM users WHERE role = 'staff' AND is_active = 1");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "<p>Total staff: " . $row['count'] . "</p>";
    }
    
    // Test count_users_by_role for dosen
    $result = $mysqli->query("SELECT COUNT(*) as count FROM users WHERE role = 'dosen' AND is_active = 1");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "<p>Total dosen: " . $row['count'] . "</p>";
    }
    
    // Test QRCode_model methods
    echo "<h3>Testing QR Code Model:</h3>";
    
    // Test get_total_qr_codes
    $result = $mysqli->query("SELECT COUNT(*) as count FROM qr_codes");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "<p>Total QR codes: " . $row['count'] . "</p>";
    }
    
    // Test get_active_qr_codes_count
    $result = $mysqli->query("SELECT COUNT(*) as count FROM qr_codes WHERE is_active = 1");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "<p>Active QR codes: " . $row['count'] . "</p>";
    }
    
    // Test Attendance_model methods
    echo "<h3>Testing Attendance Model:</h3>";
    
    // Test get_today_attendance_summary
    $today = date('Y-m-d');
    $query = "
        SELECT 
            COUNT(DISTINCT u.id) as total_users,
            COUNT(DISTINCT a.user_id) as present_users,
            COUNT(CASE WHEN a.status = 'late' THEN 1 END) as late_users
        FROM users u
        LEFT JOIN attendance a ON u.id = a.user_id AND DATE(a.created_at) = '$today'
        WHERE u.role != 'admin'
        AND u.is_active = 1
    ";
    
    $result = $mysqli->query($query);
    if ($result) {
        $row = $result->fetch_assoc();
        echo "<p>Today's summary:</p>";
        echo "<ul>";
        echo "<li>Total users: " . $row['total_users'] . "</li>";
        echo "<li>Present users: " . $row['present_users'] . "</li>";
        echo "<li>Late users: " . $row['late_users'] . "</li>";
        echo "</ul>";
    }
    
    // Test get_recent_attendance query
    echo "<h3>Testing Recent Attendance Query:</h3>";
    $query = "
        SELECT a.*, u.full_name, u.role, u.department, q.name as qr_name
        FROM attendance a
        JOIN users u ON u.id = a.user_id
        JOIN qr_codes q ON q.id = a.qr_code_id
        ORDER BY a.created_at DESC
        LIMIT 10
    ";
    
    $result = $mysqli->query($query);
    if ($result) {
        $count = $result->num_rows;
        echo "<p>Recent attendance records: " . $count . "</p>";
        
        if ($count > 0) {
            echo "<p>Sample data:</p>";
            $row = $result->fetch_assoc();
            echo "<ul>";
            echo "<li>Name: " . $row['full_name'] . "</li>";
            echo "<li>Role: " . $row['role'] . "</li>";
            echo "<li>Department: " . ($row['department'] ?: 'N/A') . "</li>";
            echo "<li>QR Code: " . $row['qr_name'] . "</li>";
            echo "<li>Check-in: " . ($row['check_in'] ?: 'N/A') . "</li>";
            echo "<li>Status: " . ($row['status'] ?: 'N/A') . "</li>";
            echo "</ul>";
        }
    } else {
        echo "<p style='color: red;'>Error in recent attendance query: " . $mysqli->error . "</p>";
    }
    
    // Test weekly summary query
    echo "<h3>Testing Weekly Summary Query:</h3>";
    $start_date = date('Y-m-d', strtotime('monday this week'));
    $end_date = date('Y-m-d', strtotime('sunday this week'));
    
    $query = "
        SELECT 
            COUNT(*) as total_days,
            SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present_days,
            SUM(CASE WHEN status = 'late' THEN 1 ELSE 0 END) as late_days,
            SUM(work_hours) as total_hours
        FROM attendance
        WHERE user_id = 1
        AND DATE(created_at) >= '$start_date'
        AND DATE(created_at) <= '$end_date'
    ";
    
    $result = $mysqli->query($query);
    if ($result) {
        $row = $result->fetch_assoc();
        echo "<p>Weekly summary for user ID 1:</p>";
        echo "<ul>";
        echo "<li>Total days: " . $row['total_days'] . "</li>";
        echo "<li>Present days: " . $row['present_days'] . "</li>";
        echo "<li>Late days: " . $row['late_days'] . "</li>";
        echo "<li>Total hours: " . ($row['total_hours'] ?: '0') . "</li>";
        echo "</ul>";
    } else {
        echo "<p style='color: red;'>Error in weekly summary query: " . $mysqli->close();
    }
    
    $mysqli->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Exception: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h3>Environment Check:</h3>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>MySQL Extension: " . (extension_loaded('mysqli') ? 'Loaded' : 'Not Loaded') . "</p>";
echo "<p>Current Date: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>Monday this week: " . date('Y-m-d', strtotime('monday this week')) . "</p>";
echo "<p>Sunday this week: " . date('Y-m-d', strtotime('sunday this week')) . "</p>";
?>
