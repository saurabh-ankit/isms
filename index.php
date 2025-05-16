<?php 
//echo"hi ";die;
require_once('config.php'); 

// Always redirect to login page - this is what you requested
header('Location: '.base_url.'admin/login.php');
exit;

// The code below is replaced with direct redirect to login page
// // Check if user is logged in
// if(isset($_SESSION['userdata']) && $_SESSION['userdata']['login_type'] == 1) {
//     redirect('admin/index.php');
// } else {
//     redirect('admin/login.php');
// }
?>