
<?php
require_once '../service/bookingService.inc.php';

$roomId = $_GET['roomId'] ?? null;
$innsjekking = $_GET['innsjekking'] ?? null;
$utsjekking = $_GET['utsjekking'] ?? null;
$antallVoksne = $_POST['antallVoksne'] ?? 0;  // From the form submission
$antallBarn = $_POST['antallBarn'] ?? 0; // From the form submission

// Check if essential booking information is present
if (!$roomId || !$innsjekking || !$utsjekking) {
    echo "<p>Missing booking information. Please return to the booking page.</p>";
    exit;
}

// Fetch room details by roomId and calculate total price
$room = getRoomById($roomId); // Retrieves specific room details
$days = (strtotime($utsjekking) - strtotime($innsjekking)) / 86400;
$totalPrice = $room->romType->pris * $days;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $brukerId = 1; // Replace with actual user ID from session or login
    $success = processBooking($brukerId, $roomId, $_POST['antallVoksne'], $_POST['antallBarn'], $innsjekking, $utsjekking);

    


    if ($success) {
        header("Location: bookingSuccess.php?roomId=$roomId&innsjekking=$innsjekking&utsjekking=$utsjekking&totalPris=$totalPrice&antallVoksne=$antallVoksne&antallBarn=$antallBarn");
        exit;
    } else {
        $error = "The room is no longer available for these dates.";
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

