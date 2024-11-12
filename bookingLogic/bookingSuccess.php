<?php
require_once '../service/bookingService.inc.php';

$roomId = $_GET['roomId'] ?? null;
$innsjekking = $_GET['innsjekking'] ?? null;
$utsjekking = $_GET['utsjekking'] ?? null;
$totalPris = $_GET['totalPris'] ?? null;

$antallVoksne = $_GET['antallVoksne'] ?? 0; 
$antallBarn = $_GET['antallBarn'] ?? 0; 

if (!$roomId || !$innsjekking || !$utsjekking || !$totalPris) {
    echo "<p>Booking details are missing. Please return to the booking page.</p>";
    exit;
}

$room = getRoomById($roomId); // Fetch room details from the database

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Success</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/bookingsuccess.css">
</head>
<body>

<div class="tilbakeKnapp">
    <a href="../index.php">
        <button type="button">Tilbake til start</button>
        <br>
    </a>
    <br>
</div>
    <div class="container">
        <h1>Booking Confirmed!</h1>
        <p>Thank you for your reservation. Here are your booking details:</p>
        <div class="booking-summary">
            <p><strong>Room Number:</strong> <?= htmlspecialchars($room->navn); ?></p>
            <p><strong>Room Type:</strong> <?= htmlspecialchars($room->romType->navn); ?></p>
            <p><strong>Check-in Date:</strong> <?= htmlspecialchars($innsjekking); ?></p>
            <p><strong>Check-out Date:</strong> <?= htmlspecialchars($utsjekking); ?></p>
            <p><strong>Total Price:</strong> <?= htmlspecialchars($totalPris); ?> NOK</p>
            <p><strong>Adults:</strong> <?= htmlspecialchars($antallVoksne); ?></p>
            <p><strong>Children:</strong> <?= htmlspecialchars($antallBarn); ?></p>
        </div>

        <div class="success-actions">
            <br></br>
            <br></br>
            <a href="booking.php"><button>Make Another Booking</button></a>
            <br></br>
            <a href="../userLogic/profil.php"><button>View My Bookings</button></a>
            
        </div>
    </div>

</body>
</html>
