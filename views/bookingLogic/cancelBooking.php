<?php
require_once __DIR__ . '/../../service/bookingService.inc.php';

if (isset($_GET['id'])) {
    $bookingId = $_GET['id'];

    // Call the cancelBooking function
    if (cancelBooking($bookingId)) {
        echo "<script>alert('Booking canceled successfully.'); window.location.href = '../userLogic/profil.php';</script>";
    } else {
        echo "<script>alert('Failed to cancel the booking.'); window.location.href = '../userLogic/profil.php';</script>";
    }
    exit;
} else {
    echo "No booking ID provided.";
}

