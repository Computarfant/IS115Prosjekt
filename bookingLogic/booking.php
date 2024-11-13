<?php
    require_once '../service/bookingService.inc.php';
    require_once '../components/romTypeCard.php';

    $ledigeRomTyper = [];
    $innsjekking = "";
    $utsjekking = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $innsjekking = $_POST['Innsjekking'];
    $utsjekking = $_POST['Utsjekking'];

    $ledigeRomTyper = searchAvailableRooms($innsjekking, $utsjekking);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Booking</title>
        <link rel="stylesheet" href="../css/main.css">
        <link rel="stylesheet" href="../css/romTypeCard.css">
</head>
<body>

<div class="tilbakeKnapp">
    <a href="../index.php">
        <button type="button">Tilbake til start</button>
        <br>
    </a>
    <br>

<div class="container">
    <h1>Booking</h1>
</div>

<form method="POST">
    <label for="Innsjekking">Innsjekking</label>
    <input type="date" name="Innsjekking" id="Innsjekking" value="<?= htmlspecialchars($innsjekking); ?>">

    <label for="Utsjekking">Utsjekking</label>
    <input type="date" name="Utsjekking" id="Utsjekking" value="<?= htmlspecialchars($utsjekking); ?>">
    <input type="hidden" id="selectedRoomType" name="roomType" value="">
    <button type="submit">Search</button>
</form>


<div class="room-type-selection">
    <button onclick="filterRooms('Standard')">Standard</button>
    <button onclick="filterRooms('Double')">Double</button>
    <button onclick="filterRooms('Suite')">Suite</button>
</div>

<div id="availableRooms">
    <?php
    // Group rooms by type to display in separate tabs
    $groupedRooms = ['Standard' => [], 'Double' => [], 'Suite' => []];
    foreach ($ledigeRomTyper as $rom) {
        $groupedRooms[$rom->romType->navn][] = $rom;
    }

    foreach ($groupedRooms as $roomType => $rooms) {
        echo "<div class='room-type-container' id='$roomType' style='display:none;'>";
        foreach ($rooms as $rom) {
            RomTypeCard($rom, $innsjekking, $utsjekking);
        }
        echo "</div>";
    }
    ?>
</div>


<script>
// JavaScript to filter rooms based on the room type
function filterRooms(roomType) {
    const allRooms = document.querySelectorAll('.room-type-container');
    allRooms.forEach(container => {
        container.style.display = 'none';
    });
    const selectedRoom = document.getElementById(roomType);
    if (selectedRoom) {
        selectedRoom.style.display = 'block';
    }
}

// Default to show Standard rooms initially
filterRooms('Standard');
</script>

</body>
</html>
