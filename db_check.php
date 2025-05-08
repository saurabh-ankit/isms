<?php
// Database connection checker
require_once('initialize.php');

echo "<h1>Database Connection Test</h1>";
echo "<p>Environment: " . ENV . "</p>";
echo "<p>DB Server: " . DB_SERVER . "</p>";
echo "<p>DB Name: " . DB_NAME . "</p>";
echo "<p>DB Username: " . DB_USERNAME . "</p>";

// Attempt to connect to the database
try {
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    echo "<p style='color:green;'>✅ Database connection successful!</p>";
    
    // Check if necessary tables exist
    $tables_to_check = ["users", "system_info"];
    echo "<h2>Checking Required Tables:</h2>";
    echo "<ul>";
    
    foreach ($tables_to_check as $table) {
        $result = $conn->query("SHOW TABLES LIKE '$table'");
        if ($result->num_rows > 0) {
            echo "<li style='color:green;'>✅ Table '$table' exists</li>";
        } else {
            echo "<li style='color:red;'>❌ Table '$table' does not exist</li>";
        }
    }
    
    echo "</ul>";
    
    // Close connection
    $conn->close();
    
} catch (Exception $e) {
    echo "<p style='color:red;'>❌ " . $e->getMessage() . "</p>";
    echo "<h2>Troubleshooting Steps:</h2>";
    echo "<ol>";
    echo "<li>Make sure your MySQL server is running</li>";
    echo "<li>Verify the database credentials in initialize.php</li>";
    echo "<li>Create the database if it doesn't exist: <code>CREATE DATABASE IF NOT EXISTS " . DB_NAME . ";</code></li>";
    echo "<li>Import the database schema from isms_db.sql file</li>";
    echo "</ol>";
}
?> 