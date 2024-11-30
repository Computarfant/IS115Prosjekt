<?php

// Check if user is logged in through a valid rolleId
if (isset($_SESSION['rolleId'])) {
    $rolleId = $_SESSION['rolleId'];
} else {
    // Not logged in redirect to login page
    header("Location: authentication/login.php");
    exit();
}
?>

<div class="navbar">
    <?php if ($rolleId == 1): ?>
        <!-- User Navbar -->
        <a href="bookingLogic/booking.php">Booking</a>
        <a href="userLogic/profil.php">Din Profil</a>
        <a href="authentication/logout.php">logout</a>
    <?php elseif ($rolleId == 2): ?>
        <!-- Admin Navbar -->
        <a href="userLogic/brukerOversikt.php">Bruker oversikt</a>
        <a href="roomAdminLogic/romOversikt.php">Rom administrering</a>
        <a href="bookingLogic/">Booking</a>
        <a href="authentication/dbsetup.php">Sett opp DB</a>
        <a href="authentication/logout.php">logout</a>
    <?php else: ?>
        <!-- Optionally, handle unknown roles here -->
        <p>Unauthorized role</p>
    <?php endif; ?>
</div>