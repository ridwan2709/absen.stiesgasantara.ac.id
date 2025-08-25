<?php
// Simple Dashboard Test
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Simple Dashboard Test</h2>";

try {
    // Test database connection
    $mysqli = new mysqli('127.0.0.1', 'root', 'root', 'attendance_management');
    
    if ($mysqli->connect_error) {
        throw new Exception("Connection failed: " . $mysqli->connect_error);
    }
    
    echo "<p style='color: green;'>Database connection successful!</p>";
    
    // Test all the queries that dashboard uses
    echo "<h3>Testing Dashboard Queries:</h3>";
    
    // 1. Test total users
    $result = $mysqli->query("SELECT COUNT(*) as count FROM users");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "<p>✓ Total users: " . $row['count'] . "</p>";
    } else {
        echo "<p style='color: red;'>✗ Error getting total users: " . $mysqli->error . "</p>";
    }
    
    // 2. Test staff count
    $result = $mysqli->query("SELECT COUNT(*) as count FROM users WHERE role = 'staff' AND is_active = 1");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "<p>✓ Total staff: " . $row['count'] . "</p>";
    } else {
        echo "<p style='color: red;'>✗ Error getting staff count: " . $mysqli->error . "</p>";
    }
    
    // 3. Test dosen count
    $result = $mysqli->query("SELECT COUNT(*) as count FROM users WHERE role = 'dosen' AND is_active = 1");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "<p>✓ Total dosen: " . $row['count'] . "</p>";
    } else {
        echo "<p style='color: red;'>✗ Error getting dosen count: " . $mysqli->error . "</p>";
    }
    
    // 4. Test total QR codes
    $result = $mysqli->query("SELECT COUNT(*) as count FROM qr_codes");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "<p>✓ Total QR codes: " . $row['count'] . "</p>";
    } else {
        echo "<p style='color: red;'>✗ Error getting QR codes count: " . $mysqli->error . "</p>";
    }
    
    // 5. Test active QR codes
    $result = $mysqli->query("SELECT COUNT(*) as count FROM qr_codes WHERE is_active = 1");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "<p>✓ Active QR codes: " . $row['count'] . "</p>";
    } else {
        echo "<p style='color: red;'>✗ Error getting active QR codes: " . $mysqli->error . "</p>";
    }
    
    // 6. Test today's attendance summary
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
        echo "<p>✓ Today's summary:</p>";
        echo "<ul>";
        echo "<li>Total users: " . $row['total_users'] . "</li>";
        echo "<li>Present users: " . $row['present_users'] . "</li>";
        echo "<li>Late users: " . $row['late_users'] . "</li>";
        echo "</ul>";
    } else {
        echo "<p style='color: red;'>✗ Error in today's summary: " . $mysqli->error . "</p>";
    }
    
    // 7. Test recent attendance
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
        echo "<p>✓ Recent attendance: " . $count . " records</p>";
        
        if ($count > 0) {
            echo "<p>Sample record:</p>";
            $row = $result->fetch_assoc();
            echo "<ul>";
            echo "<li>Name: " . $row['full_name'] . "</li>";
            echo "<li>Role: " . $row['role'] . "</li>";
            echo "<li>Department: " . ($row['department'] ?: 'N/A') . "</li>";
            echo "<li>QR Code: " . $row['qr_name'] . "</li>";
            echo "<li>Status: " . ($row['status'] ?: 'N/A') . "</li>";
            echo "</ul>";
        }
    } else {
        echo "<p style='color: red;'>✗ Error in recent attendance: " . $mysqli->error . "</p>";
    }
    
    // 8. Test weekly summary
    $start_date = date('Y-m-d', strtotime('monday this week'));
    $end_date = date('Y-m-d', strtotime('sunday this week'));
    
    $query = "
        SELECT 
            COUNT(*) as total_days,
            SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present_days,
            SUM(CASE WHEN status = 'late' THEN 1 ELSE 0 END) as late_days,
            SUM(COALESCE(work_hours, 0)) as total_hours
        FROM attendance
        WHERE user_id = 1
        AND DATE(created_at) >= '$start_date'
        AND DATE(created_at) <= '$end_date'
    ";
    
    $result = $mysqli->query($query);
    if ($result) {
        $row = $result->fetch_assoc();
        echo "<p>✓ Weekly summary for user ID 1:</p>";
        echo "<ul>";
        echo "<li>Total days: " . $row['total_days'] . "</li>";
        echo "<li>Present days: " . $row['present_days'] . "</li>";
        echo "<li>Late days: " . $row['late_days'] . "</li>";
        echo "<li>Total hours: " . ($row['total_hours'] ?: '0') . "</li>";
        echo "</ul>";
    } else {
        echo "<p style='color: red;'>✗ Error in weekly summary: " . $mysqli->error . "</p>";
    }
    
    // 9. Test user attendance by date
    $query = "
        SELECT * FROM attendance 
        WHERE user_id = 1 
        AND DATE(created_at) = '$today'
    ";
    
    $result = $mysqli->query($query);
    if ($result) {
        $count = $result->num_rows;
        echo "<p>✓ Today's attendance for user ID 1: " . $count . " records</p>";
    } else {
        echo "<p style='color: red;'>✗ Error in user attendance by date: " . $mysqli->error . "</p>";
    }
    
    // 10. Test user attendance history
    $query = "
        SELECT a.*, q.name as qr_name, q.location
        FROM attendance a
        JOIN qr_codes q ON q.id = a.qr_code_id
        WHERE a.user_id = 1
        ORDER BY a.created_at DESC
        LIMIT 5
    ";
    
    $result = $mysqli->query($query);
    if ($result) {
        $count = $result->num_rows;
        echo "<p>✓ User attendance history: " . $count . " records</p>";
    } else {
        echo "<p style='color: red;'>✗ Error in user attendance history: " . $mysqli->error . "</p>";
    }
    
    $mysqli->close();
    
    echo "<p style='color: green;'>✓ All tests completed!</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Exception: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h3>Environment Info:</h3>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>MySQL Extension: " . (extension_loaded('mysqli') ? 'Loaded' : 'Not Loaded') . "</p>";
echo "<p>Current Date: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>Week Range: " . date('Y-m-d', strtotime('monday this week')) . " to " . date('Y-m-d', strtotime('sunday this week')) . "</p>";
?>
