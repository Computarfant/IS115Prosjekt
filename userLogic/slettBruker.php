<?php
include "../service/profilService.inc.php";

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in and has the correct role
if (!isset($_SESSION['rolleId']) || $_SESSION['rolleId'] != 2) {
    // If user is not logged in or does not have admin role (roleId = 2)
    header("Location: index.php"); // Index.php || access_denied.php needs to be created
    exit();
}

// Sjekker om en bruker ID er gitt
if (isset($_GET['id'])) {
    $brukerId = $_GET['id'];

    // Kaller deleteUser funksjonen fra dbFunctions
    $isDeleted = deleteUser($brukerId);

    if ($isDeleted) {
        header("Location: brukerOversikt.php?message=User+deleted+successfully");
    } else {
        echo "Error deleting user.";
    }
} else {
    // Feilmelding hvis det ikke er blitt gitt brukerID
    header("Location: brukerOversikt.php?error=No+user+ID+provided");
}
exit();