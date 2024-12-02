<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in and has the correct role
if (!isset($_SESSION['rolleId']) || $_SESSION['rolleId'] != 2) {
    // If user is not logged in or does not have admin role (rolleId = 2)
    header("Location: ../../index.php?message=Access Denied!"); // Index.php || access_denied.php needs to be created
    exit();
}
?>