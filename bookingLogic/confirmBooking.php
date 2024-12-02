<?php
require_once '../service/bookingService.inc.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$brukerId = $_SESSION['brukerId'];
$roomId = $_GET['roomId'] ?? null;
$innsjekking = $_GET['innsjekking'] ?? null;
$utsjekking = $_GET['utsjekking'] ?? null;
$antallVoksne = $_POST['antallVoksne'] ?? 0; 
$antallBarn = $_POST['antallBarn'] ?? 0; 

// Check if essential booking information is present
if (!$roomId || !$innsjekking || !$utsjekking) {
    echo "<p>Missing booking information. Please return to the booking page.</p>";
    exit;
}

// Fetch room details by roomId and calculate total price
$room = getRoomById($roomId);
$days = (strtotime($utsjekking) - strtotime($innsjekking)) / 86400;
$totalPrice = $room->romType->pris * $days;

$error = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $totalGuests = $_POST['antallVoksne'] + $_POST['antallBarn'];
    if ($totalGuests > $room->romType->maxGjester) {
    
        $error = "The maximum number of guests for this room is " . $room->romType->maxGjester . ". Please adjust the number of guests.";
    } else {
        $success = processBooking($brukerId, $roomId, $_POST['antallVoksne'], $_POST['antallBarn'], $innsjekking, $utsjekking);
        
        if ($success) {
            writeLog('User: ' . $brukerId . ' booked the room: ' . $roomId . ' from ' . $innsjekking . ' to ' . $utsjekking);
            header("Location: bookingSuccess.php?roomId=$roomId&innsjekking=$innsjekking&utsjekking=$utsjekking&totalPris=$totalPrice&antallVoksne=$antallVoksne&antallBarn=$antallBarn");
            exit;
        } else {
            $error = "The room is no longer available for these dates.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="no">
<head>
    <title>Confirm Booking</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<div class="tilbakeKnapp">
    <a href="booking.php">
        <button type="button">Tilbake til bruker oversikt</button>
        <br>
    </a>
    <br>
</div>

    <h1>Confirm Booking</h1>
    <p>Room Number: <?= htmlspecialchars($room->navn ?? "Unknown Room"); ?></p>
    <p>Check-in: <?= htmlspecialchars($innsjekking); ?></p>
    <p>Check-out: <?= htmlspecialchars($utsjekking); ?></p>
    <p>Total Price: <?= htmlspecialchars($totalPrice ?? 0); ?> NOK</p>

    <form method="POST">
        <label for="antallVoksne">Adults</label>
        <input type="number" name="antallVoksne" id="antallVoksne" required>

        <label for="antallBarn">Children</label>
        <input type="number" name="antallBarn" id="antallBarn">

        <button type="submit">Confirm Booking</button>
    </form>

    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</body>
</html>
