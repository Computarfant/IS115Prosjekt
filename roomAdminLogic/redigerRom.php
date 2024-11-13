<?php
require_once '../components/adminCheck.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Room</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>

<?php
include "../service/romAdmin.inc.php"; 

// Henter romID fra URL
$roomId = $_GET['id'];

// Henter romdata
$room = getRoomById($roomId);

// Henter romtype data
$romType = getRoomTypeById($room->rtid);

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Henter oppdatert data fra formen
    $navn = $_POST['navn'];
    $beskrivelse = $_POST['beskrivelse'];
    $etasje = $_POST['etasje'];
    $romTypeId = $_POST['romTypeId'];

    updateRoom($roomId, $navn, $beskrivelse, $etasje, $romTypeId);

    // Henter oppdatert romdata og romtype data
    $room = getRoomById($roomId);
    $romType = getRoomTypeById($room->rtid);

    $message = "Rommet er oppdatert!";
}
?>

<div class="tilbakeKnapp">
    <a href="romOversikt.php">
        <button type="button">Tilbake til rom oversikt</button>
        <br>
    </a>
    <br>
</div>

<div class="edit-form1">
    <h4>Rediger rom:</h4>
    <?php if ($message): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    <br>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="etasje" class="form-label">Etasje</label>
            <input type="number" class="form-control" id="etasje" name="etasje" value="<?php echo $room->etasje; ?>" required>
        </div>

        <div class="mb-3">
            <label for="beskrivelse" class="form-label">Beskrivelse</label>
            <input type="text" class="form-control" id="beskrivelse" name="beskrivelse" value="<?php echo htmlspecialchars($romType->beskrivelse); ?>" readonly>
        </div>

        <div class="mb-3">
            <label for="pris" class="form-label">Pris</label>
            <input type="number" class="form-control" id="pris" name="pris" value="<?php echo $romType->pris; ?>" readonly>
        </div>

        <div class="mb-3">
            <label for="maxGjester" class="form-label">Max gjester</label>
            <input type="number" class="form-control" id="maxGjester" name="maxGjester" value="<?php echo $romType->maxGjester; ?>" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Romtype ID</label>
            <input type="number" class="form-control" id="romTypeId" name="romTypeId" value="<?php echo $romType->id; ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Oppdater</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
