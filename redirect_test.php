<?php
// Simple redirect tester for ISMS

// Start by including the config
require_once('config.php');

echo "<h1>ISMS Redirect Test</h1>";

// Check if redirecting to login works
echo "<p>We'll attempt to redirect to the login page in 5 seconds...</p>";

// Display current session info
echo "<h2>Current Session Info:</h2>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

// Show current environment 
echo "<p>Current environment: " . ENV . "</p>";
echo "<p>Base URL: " . base_url . "</p>";

// Set a sleep so we can see this page before redirect
echo "<p>Redirecting in 5 seconds...</p>";
echo "<p>Or <a href='index.php'>click here</a> to redirect now.</p>";

// Add script to redirect after 5 seconds
echo "<script>
setTimeout(function() {
    window.location.href = 'index.php';
}, 5000);
</script>";
?> 