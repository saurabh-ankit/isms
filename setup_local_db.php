<?php
// Local database setup helper
require_once('initialize.php');

echo "<h1>ISMS Local Database Setup</h1>";

// Check if we're in the correct environment
if (ENV != 'localhost') {
    die("<p style='color:red;'>This script is intended for localhost setup only. Current environment: " . ENV . "</p>");
}

// Function to run SQL queries from a file
function runSQLFile($conn, $sqlFile) {
    echo "<p>Executing SQL from file: $sqlFile</p>";
    
    // Read the file
    $sql = file_get_contents($sqlFile);
    if (!$sql) {
        echo "<p style='color:red;'>Error: Could not read SQL file</p>";
        return false;
    }
    
    // Split the SQL file into individual statements
    $statements = explode(';', $sql);
    $success = true;
    
    // Execute each statement
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement)) {
            if (!$conn->query($statement)) {
                echo "<p style='color:red;'>Error executing SQL: " . $conn->error . "</p>";
                echo "<p>Statement: " . htmlspecialchars($statement) . "</p>";
                $success = false;
            }
        }
    }
    
    return $success;
}

try {
    // Step 1: Connect to MySQL server without selecting a database
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    
    if ($conn->connect_error) {
        throw new Exception("Connection to MySQL server failed: " . $conn->connect_error);
    }
    
    echo "<p style='color:green;'>✅ Connected to MySQL server</p>";
    
    // Step 2: Create the database if it doesn't exist
    $dbName = DB_NAME;
    if ($conn->query("CREATE DATABASE IF NOT EXISTS $dbName")) {
        echo "<p style='color:green;'>✅ Database '$dbName' created or already exists</p>";
    } else {
        throw new Exception("Failed to create database: " . $conn->error);
    }
    
    // Step 3: Select the database
    if ($conn->select_db($dbName)) {
        echo "<p style='color:green;'>✅ Database '$dbName' selected</p>";
    } else {
        throw new Exception("Failed to select database: " . $conn->error);
    }
    
    // Step 4: Check if essential tables exist
    $result = $conn->query("SHOW TABLES LIKE 'users'");
    $tablesExist = $result->num_rows > 0;
    
    if ($tablesExist) {
        echo "<p style='color:green;'>✅ Database tables already exist</p>";
    } else {
        echo "<p>Database tables not found, importing schema...</p>";
        
        // Step 5: Import the schema
        if (file_exists('isms_db.sql')) {
            if (runSQLFile($conn, 'isms_db.sql')) {
                echo "<p style='color:green;'>✅ Database schema imported successfully</p>";
            } else {
                throw new Exception("Error importing database schema");
            }
        } else {
            throw new Exception("Schema file isms_db.sql not found");
        }
    }
    
    // Step 6: Create default admin user if doesn't exist
    $result = $conn->query("SELECT * FROM users WHERE username='admin'");
    if ($result->num_rows == 0) {
        $adminPassword = md5('admin123'); // Default password: admin123
        $sql = "INSERT INTO users (firstname, lastname, username, password, type) VALUES ('System', 'Administrator', 'admin', '$adminPassword', 1)";
        
        if ($conn->query($sql)) {
            echo "<p style='color:green;'>✅ Default admin user created (username: admin, password: admin123)</p>";
        } else {
            echo "<p style='color:red;'>Error creating admin user: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color:green;'>✅ Admin user already exists</p>";
    }
    
    // Close connection
    $conn->close();
    
    echo "<h2 style='color:green;'>Setup Complete!</h2>";
    echo "<p>You can now access your local ISMS installation at: <a href='" . base_url . "'>" . base_url . "</a></p>";
    echo "<p>Login with username: <strong>admin</strong>, password: <strong>admin123</strong> (if you used the default)</p>";
    
} catch (Exception $e) {
    echo "<p style='color:red;'>❌ " . $e->getMessage() . "</p>";
    echo "<h2>Troubleshooting Steps:</h2>";
    echo "<ol>";
    echo "<li>Make sure your MySQL server is running</li>";
    echo "<li>Verify the database credentials in initialize.php</li>";
    echo "<li>Ensure you have the correct permissions to create databases and tables</li>";
    echo "<li>Check if the isms_db.sql file exists in the root directory</li>";
    echo "</ol>";
}
?> 