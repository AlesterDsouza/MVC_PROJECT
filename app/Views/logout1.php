<?php
// Start session to destroy
session_start();

// Destroy session and unset session variables
session_unset();
session_destroy();

// Redirect to login page
// header("Location: user_list1.php");
header("Location: user_list1.php");
exit();
?>