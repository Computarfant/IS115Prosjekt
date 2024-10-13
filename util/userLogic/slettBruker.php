<?php
include "../../../assets/inc/dbFunctions.inc.php";

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
    exit();
} else {
    // Feilmelding hvis det ikke er blitt gitt brukerID
    header("Location: brukerOversikt.php?error=No+user+ID+provided");
    exit();
}