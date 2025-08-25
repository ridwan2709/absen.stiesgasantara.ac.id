<?php
// Debug Dashboard Issues
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Dashboard Debug</h2>";

// Simulate session data
$user = [
    'user_id' => 1,
    'role' => 'admin',
    'logged_in' => true,
    'full_name' => 'Admin User',
    'email' => 'admin@example.com'
];

echo "<h3>Session Data:</h3>";
echo "<pre>" . print_r($user, true) . "</pre>";

try {
    // Test database connection
    $mysqli = new mysqli('127.0.0.1', 'root', 'root', 'attendance_management');
    
    if ($mysqli->connect_error) {
        throw new Exception("Connection failed: " . $mysqli->connect_error);
    }
    
    echo "<p style='color: green;'>✓ Database connection successful!</p>";
    
    // Test all dashboard data retrieval
    echo "<h3>Dashboard Data Test:</h3>";
    
    // 1. Test admin dashboard data
    if ($user['role'] == 'admin') {
        echo "<h4>Admin Dashboard Data:</h4>";
        
        // Total users
        $result = $mysqli->query("SELECT COUNT(*) as count FROM users");
        if ($result) {
            $row = $result->fetch_assoc();
            $total_users = $row['count'];
            echo "<p>✓ Total users: " . $total_users . "</p>";
        } else {
            echo "<p style='color: red;'>✗ Error getting total users: " . $mysqli->error . "</p>";
            $total_users = 0;
        }
        
        // Staff count
        $result = $mysqli->query("SELECT COUNT(*) as count FROM users WHERE role = 'staff' AND is_active = 1");
        if ($result) {
            $row = $result->fetch_assoc();
            $total_staff = $row['count'];
            echo "<p>✓ Total staff: " . $total_staff . "</p>";
        } else {
            echo "<p style='color: red;'>✗ Error getting staff count: " . $mysqli->error . "</p>";
            $total_staff = 0;
        }
        
        // Dosen count
        $result = $mysqli->query("SELECT COUNT(*) as count FROM users WHERE role = 'dosen' AND is_active = 1");
        if ($result) {
            $row = $result->fetch_assoc();
            $total_dosen = $row['count'];
            echo "<p>✓ Total dosen: " . $total_dosen . "</p>";
        } else {
            echo "<p style='color: red;'>✗ Error getting dosen count: " . $mysqli->error . "</p>";
            $total_dosen = 0;
        }
        
        // QR codes count
        $result = $mysqli->query("SELECT COUNT(*) as count FROM qr_codes");
        if ($result) {
            $row = $result->fetch_assoc();
            $total_qr_codes = $row['count'];
            echo "<p>✓ Total QR codes: " . $total_qr_codes . "</p>";
        } else {
            echo "<p style='color: red;'>✗ Error getting QR codes count: " . $mysqli->error . "</p>";
            $total_qr_codes = 0;
        }
        
        // Active QR codes count
        $result = $mysqli->query("SELECT COUNT(*) as count FROM qr_codes WHERE is_active = 1");
        if ($result) {
            $row = $result->fetch_assoc();
            $active_qr_codes = $row['count'];
            echo "<p>✓ Active QR codes: " . $active_qr_codes . "</p>";
        } else {
            echo "<p style='color: red;'>✗ Error getting active QR codes: " . $mysqli->error . "</p>";
            $active_qr_codes = 0;
        }
        
        // Today's summary
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
            $today_summary = $row;
            echo "<p>✓ Today's summary:</p>";
            echo "<ul>";
            echo "<li>Total users: " . $today_summary['total_users'] . "</li>";
            echo "<li>Present users: " . $today_summary['present_users'] . "</li>";
            echo "<li>Late users: " . $today_summary['late_users'] . "</li>";
            echo "</ul>";
        } else {
            echo "<p style='color: red;'>✗ Error in today's summary: " . $mysqli->error . "</p>";
            $today_summary = ['total_users' => 0, 'present_users' => 0, 'late_users' => 0];
        }
        
        // Recent attendance
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
            $recent_attendance = [];
            while ($row = $result->fetch_assoc()) {
                $recent_attendance[] = $row;
            }
            echo "<p>✓ Recent attendance: " . count($recent_attendance) . " records</p>";
        } else {
            echo "<p style='color: red;'>✗ Error in recent attendance: " . $mysqli->error . "</p>";
            $recent_attendance = [];
        }
        
        // Simulate dashboard view data
        echo "<h4>Dashboard View Data:</h4>";
        echo "<pre>";
        echo "Data that would be passed to view:\n";
        echo "total_users: " . $total_users . "\n";
        echo "total_staff: " . $total_staff . "\n";
        echo "total_dosen: " . $total_dosen . "\n";
        echo "total_qr_codes: " . $total_qr_codes . "\n";
        echo "active_qr_codes: " . $active_qr_codes . "\n";
        echo "today_summary: " . print_r($today_summary, true) . "\n";
        echo "recent_attendance count: " . count($recent_attendance) . "\n";
        echo "</pre>";
        
    } else {
        // Test staff/dosen dashboard data
        echo "<h4>Staff/Dosen Dashboard Data:</h4>";
        
        $user_id = $user['user_id'];
        
        // Today's attendance
        $today = date('Y-m-d');
        $query = "
            SELECT * FROM attendance 
            WHERE user_id = $user_id 
            AND DATE(created_at) = '$today'
        ";
        
        $result = $mysqli->query($query);
        if ($result) {
            $today_attendance = $result->fetch_assoc();
            if ($today_attendance) {
                echo "<p>✓ Today's attendance found</p>";
                echo "<pre>" . print_r($today_attendance, true) . "</pre>";
            } else {
                echo "<p>✓ No attendance today</p>";
                $today_attendance = null;
            }
        } else {
            echo "<p style='color: red;'>✗ Error getting today's attendance: " . $mysqli->error . "</p>";
            $today_attendance = null;
        }
        
        // Weekly summary
        $start_date = date('Y-m-d', strtotime('monday this week'));
        $end_date = date('Y-m-d', strtotime('sunday this week'));
        
        $query = "
            SELECT 
                COUNT(*) as total_days,
                SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present_days,
                SUM(CASE WHEN status = 'late' THEN 1 ELSE 0 END) as late_days,
                SUM(COALESCE(work_hours, 0)) as total_hours
            FROM attendance
            WHERE user_id = $user_id
            AND DATE(created_at) >= '$start_date'
            AND DATE(created_at) <= '$end_date'
        ";
        
        $result = $mysqli->query($query);
        if ($result) {
            $weekly_summary = $result->fetch_assoc();
            echo "<p>✓ Weekly summary:</p>";
            echo "<pre>" . print_r($weekly_summary, true) . "</pre>";
        } else {
            echo "<p style='color: red;'>✗ Error in weekly summary: " . $mysqli->error . "</p>";
            $weekly_summary = null;
        }
    }
    
    $mysqli->close();
    
    echo "<p style='color: green;'>✓ Debug completed!</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Exception: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h3>Common Dashboard Issues:</h3>";
echo "<ul>";
echo "<li>Missing database connection</li>";
echo "<li>Table doesn't exist</li>";
echo "<li>Column doesn't exist</li>";
echo "<li>Permission denied</li>";
echo "<li>Syntax error in SQL</li>";
echo "<li>Missing required data</li>";
echo "<li>Session expired</li>";
echo "</ul>";

echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li>Check browser console for JavaScript errors</li>";
echo "<li>Check server error logs</li>";
echo "<li>Verify database tables exist</li>";
echo "<li>Check user permissions</li>";
echo "<li>Test individual queries</li>";
echo "</ol>";
?>
