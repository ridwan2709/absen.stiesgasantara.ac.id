<?php
// Test database connection and identify errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Database Connection Test</h2>";

// Test basic database connection
try {
    $host = '127.0.0.1';
    $username = 'root';
    $password = 'root';
    $database = 'attendance_management';
    
    $mysqli = new mysqli($host, $username, $password, $database);
    
    if ($mysqli->connect_error) {
        echo "<p style='color: red;'>Connection failed: " . $mysqli->connect_error . "</p>";
    } else {
        echo "<p style='color: green;'>Database connection successful!</p>";
        
        // Test basic queries
        echo "<h3>Testing Basic Queries:</h3>";
        
        // Test users table
        $result = $mysqli->query("SELECT COUNT(*) as count FROM users");
        if ($result) {
            $row = $result->fetch_assoc();
            echo "<p>Users table: " . $row['count'] . " records</p>";
        } else {
            echo "<p style='color: red;'>Error querying users table: " . $mysqli->error . "</p>";
        }
        
        // Test attendance table
        $result = $mysqli->query("SELECT COUNT(*) as count FROM attendance");
        if ($result) {
            $row = $result->fetch_assoc();
            echo "<p>Attendance table: " . $row['count'] . " records</p>";
        } else {
            echo "<p style='color: red;'>Error querying attendance table: " . $mysqli->error . "</p>";
        }
        
        // Test qr_codes table
        $result = $mysqli->query("SELECT COUNT(*) as count FROM qr_codes");
        if ($result) {
            $row = $result->fetch_assoc();
            echo "<p>QR Codes table: " . $row['count'] . " records</p>";
        } else {
            echo "<p style='color: red;'>Error querying qr_codes table: " . $mysqli->error . "</p>";
        }
        
        // Test the problematic query from get_today_attendance_summary
        echo "<h3>Testing Problematic Query:</h3>";
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
            echo "<p>Today's summary query successful:</p>";
            echo "<ul>";
            echo "<li>Total users: " . $row['total_users'] . "</li>";
            echo "<li>Present users: " . $row['present_users'] . "</li>";
            echo "<li>Late users: " . $row['late_users'] . "</li>";
            echo "</ul>";
        } else {
            echo "<p style='color: red;'>Error in today's summary query: " . $mysqli->error . "</p>";
        }
        
        // Test table structure
        echo "<h3>Table Structure:</h3>";
        
        // Users table structure
        $result = $mysqli->query("DESCRIBE users");
        if ($result) {
            echo "<p><strong>Users table structure:</strong></p>";
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . $row['Field'] . " - " . $row['Type'] . " - " . $row['Null'] . " - " . $row['Key'] . "</li>";
            }
            echo "</ul>";
        }
        
        // Attendance table structure
        $result = $mysqli->query("DESCRIBE attendance");
        if ($result) {
            echo "<p><strong>Attendance table structure:</strong></p>";
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . $row['Field'] . " - " . $row['Type'] . " - " . $row['Null'] . " - " . $row['Key'] . "</li>";
            }
            echo "</ul>";
        }
        
        $mysqli->close();
        
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Exception: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h3>PHP Info:</h3>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>MySQL Extension: " . (extension_loaded('mysqli') ? 'Loaded' : 'Not Loaded') . "</p>";
echo "<p>Error Reporting: " . (error_reporting() ? 'Enabled' : 'Disabled') . "</p>";
?>
