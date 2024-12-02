<?php

// Check if user is logged in through a valid rolleId
if (isset($_SESSION['rolleId'])) {
    $rolleId = $_SESSION['rolleId'];
} else {
    // Not logged in redirect to login page
    header("Location: views/authentication/login.php");
    exit();
}
?>

<div class="navbar">
    <?php if ($rolleId == 1): ?>
        <!-- User Navbar -->
        <a href="/IS115Prosjekt/views/bookingLogic/booking.php">Booking</a>
        <a href="/IS115Prosjekt/views/userLogic/profil.php">Din Profil</a>
        <a href="/IS115Prosjekt/views/authentication/logout.php">logout</a>
    <?php elseif ($rolleId == 2): ?>
        <!-- Admin Navbar -->
        <a href="/IS115Prosjekt/views/userLogic/logOversikt.php">Log</a>
        <a href="/IS115Prosjekt/views/userLogic/brukerOversikt.php">Bruker oversikt</a>
        <a href="/IS115Prosjekt/views/roomAdminLogic/romOversikt.php">Rom administrering</a>
        <a href="/IS115Prosjekt/views/bookingLogic/booking.php">Booking</a>
        <a href="/IS115Prosjekt/views/userLogic/profil.php">Din Profil</a>
        <a href="/IS115Prosjekt/views/authentication/logout.php">logout</a>
    <?php else: ?>
        <!-- Optionally, handle unknown roles here -->
        <p>Unauthorized role</p>
    <?php endif; ?>
</div>