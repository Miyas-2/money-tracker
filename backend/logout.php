<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Set success message in session flash
session_start(); // Start a new session
$_SESSION['logout_message'] = "Successfully logged out!";

// Redirect to login page
header("Location: ../frontend/login.php");
exit();
?>