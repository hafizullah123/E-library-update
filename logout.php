<?php
// Clear the session identifier cookie
//setcookie('session_id', '', time() - 3600, "/");

// Redirect to the login page
//header("Location: index.php");
//exit();

// Clear the session identifier cookie
session_start();
session_unset();

// Redirect to the login page
header("Location: login.php");
exit();
?>

