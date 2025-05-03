<?php
// Database configuration
$host = '127.0.0.1';
$port = '3306';
$username = 'root';
$password = 'CHiheb2004';
$database = 'project_management';

// Create connection
try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$database", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<h2>Database Connection Status</h2>";
    echo "<p style='color: green;'>✅ Successfully connected to the database!</p>";
    
    // Test query
    $stmt = $conn->query("SELECT VERSION()");
    $version = $stmt->fetchColumn();
    echo "<p>MySQL Version: " . $version . "</p>";
    
} catch(PDOException $e) {
    echo "<h2>Database Connection Status</h2>";
    echo "<p style='color: red;'>❌ Connection failed: " . $e->getMessage() . $e->getTraceAsString() . "</p>";
    echo "<p>Please check your database configuration and make sure MySQL is running.</p>";
}
?> 