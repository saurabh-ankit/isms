<?php 
// No need to start session here as it's already done in config.php
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }

// Get current URL
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
    $link = "https"; 
else
    $link = "http"; 
$link .= "://"; 
$link .= $_SERVER['HTTP_HOST']; 
$link .= $_SERVER['REQUEST_URI'];

// For login page, if user is already logged in, redirect to admin index
if(strpos($link, 'login.php') !== false) {
    if(isset($_SESSION['userdata']) && isset($_SESSION['userdata']['login_type'])) {
        header('Location: '.base_url.'admin/index.php');
        exit;
    }
}
// Skip other checks for login page - we only need to check if already logged in
else {
    // For other pages, check if user is logged in
    if(!isset($_SESSION['userdata']) || !isset($_SESSION['userdata']['login_type'])) {
        header('Location: '.base_url.'admin/login.php');
        exit;
    }
    
    // Check user type/role for access control
    $module = array('','admin','tutor');
    if(isset($_SESSION['userdata']['login_type']) && $_SESSION['userdata']['login_type'] !=  1) {
        echo "<script>alert('Access Denied!');location.replace('".base_url.$module[$_SESSION['userdata']['login_type']]."');</script>";
        exit;
    }
}
