<?php
/**
 * Database Update Script for Lecturer Photo Feature
 * Run this script to update your database structure
 */

// Database configuration for MAMP
$host = '127.0.0.1';
$username = 'root';  // MAMP default username
$password = 'root';  // MAMP default password
$database = 'attendance_management';
$socket = '/Applications/MAMP/tmp/mysql/mysql.sock';  // MAMP socket path

try {
    // Create connection with MAMP socket
    $dsn = "mysql:host=$host;unix_socket=$socket;dbname=$database;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to database successfully!\n";
    echo "Updating database structure...\n\n";
    
    // 1. Add lecture_photo field
    try {
        $sql = "ALTER TABLE attendance ADD COLUMN lecture_photo VARCHAR(255) NULL COMMENT 'Path file foto kegiatan mengajar' AFTER lecture_notes";
        $pdo->exec($sql);
        echo "✓ Added lecture_photo field\n";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
            echo "✓ lecture_photo field already exists\n";
        } else {
            echo "✗ Error adding lecture_photo field: " . $e->getMessage() . "\n";
        }
    }
    
    // 2. Add photo_filename field
    try {
        $sql = "ALTER TABLE attendance ADD COLUMN photo_filename VARCHAR(255) NULL COMMENT 'Nama file foto asli' AFTER lecture_photo";
        $pdo->exec($sql);
        echo "✓ Added photo_filename field\n";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
            echo "✓ photo_filename field already exists\n";
        } else {
            echo "✗ Error adding photo_filename field: " . $e->getMessage() . "\n";
        }
    }
    
    // 3. Add photo_timestamp field
    try {
        $sql = "ALTER TABLE attendance ADD COLUMN photo_timestamp TIMESTAMP NULL COMMENT 'Timestamp pengambilan foto' AFTER photo_filename";
        $pdo->exec($sql);
        echo "✓ Added photo_timestamp field\n";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
            echo "✓ photo_timestamp field already exists\n";
        } else {
            echo "✗ photo_timestamp field already exists\n";
        }
    }
    
    // 4. Create indexes
    try {
        $sql = "CREATE INDEX idx_lecture_photo ON attendance(lecture_photo)";
        $pdo->exec($sql);
        echo "✓ Created index on lecture_photo\n";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate key name') !== false) {
            echo "✓ Index on lecture_photo already exists\n";
        } else {
            echo "✗ Error creating index: " . $e->getMessage() . "\n";
        }
    }
    
    try {
        $sql = "CREATE INDEX idx_photo_timestamp ON attendance(photo_timestamp)";
        $pdo->exec($sql);
        echo "✓ Created index on photo_timestamp\n";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate key name') !== false) {
            echo "✓ Index on photo_timestamp already exists\n";
        } else {
            echo "✗ Error creating index: " . $e->getMessage() . "\n";
        }
    }
    
    // 5. Show current table structure
    echo "\nCurrent table structure:\n";
    $sql = "DESCRIBE attendance";
    $stmt = $pdo->query($sql);
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $column) {
        echo sprintf("%-20s %-15s %-10s %-10s %-10s %-10s\n", 
            $column['Field'], 
            $column['Type'], 
            $column['Null'], 
            $column['Key'], 
            $column['Default'], 
            $column['Extra']
        );
    }
    
    echo "\n✓ Database update completed successfully!\n";
    echo "You can now use the photo feature in your application.\n";
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
    echo "Please check your database configuration.\n";
    echo "Make sure MAMP is running and MySQL is accessible via socket: $socket\n";
}
?>
