<?php
// Debug file to help identify session and redirection issues

// Start session only if one doesn't exist
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Turn on error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check session status
echo "<h2>Session Status Check</h2>";
echo "Session ID: " . session_id() . "<br>";
echo "Session Status: " . (session_status() == PHP_SESSION_ACTIVE ? 'Active' : 'Not Active') . "<br>";

// Display session data
echo "<h2>Session Data</h2>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

// Check headers not sent
echo "<h2>Headers Status</h2>";
echo "Headers already sent: " . (headers_sent() ? 'Yes' : 'No') . "<br>";
if (headers_sent($file, $line)) {
    echo "Headers sent in file: $file on line: $line<br>";
}

// Output server info
echo "<h2>Server Info</h2>";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "HTTP_HOST: " . $_SERVER['HTTP_HOST'] . "<br>";

// Test session writing
echo "<h2>Session Write Test</h2>";
$_SESSION['test_key'] = 'test_value_' . time();
echo "Written test value: " . $_SESSION['test_key'] . "<br>";

// Check environment variables
echo "<h2>Environment Variables</h2>";
require_once('initialize.php');

echo "Environment: " . ENV . "<br>";
echo "BASE_URL: " . BASE_URL . "<br>";
echo "base_url: " . base_url . "<br>";
echo "DB_SERVER: " . DB_SERVER . "<br>";
echo "DB_NAME: " . DB_NAME . "<br>";

// Test redirect function
echo "<h2>Redirect Test</h2>";
echo "<a href='index.php'>Test Redirect to Login</a>";
?> 