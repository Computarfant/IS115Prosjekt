<?php
    require_once '../service/roomService.inc.php';
    require_once '../components/romTypeCard.php';
    //require_once 'assets/image';

    $ledigeRomTyper = [];
    $innsjekking = "";
    $utsjekking = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //$antallBarn = $_POST['Barn'];
    //$antallVoksne = $_POST['Voksne'];
    $innsjekking = $_POST['Innsjekking'];
    $utsjekking = $_POST['Utsjekking'];

    $ledigeRomTyper = searchAvailebleRooms($innsjekking, $utsjekking);
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
        <br></br>
    </a>
    <br>


<div class="container">
    <h1>Booking</h1>
</div>

<div class="navbar">
    <a href="booking.php">Booking</a>
    <a href="../userLogic/brukerOversikt.php">Bruker oversikt</a>
    <a href="../userLogic/profil.php">Profil</a>
</div>

<form method="POST">
    <!--<label for="Barn">Antall Barn</label>
    <input type="number" name="Barn" id="Barn">

    <label for="Voksne">Voksne</label>
    <input type="number" name="Voksne" id="Voksne">-->

    <label for="Innsjekking">Innsjekking</label>
    <input type="date" name="Innsjekking" id="Innsjekking">

    <label for="Utsjekking">Utsjekking</label>
    <input type="date" name="Utsjekking" id="Utsjekking">

    <button type="submit">Search</button>
</form>
<div class="cards-container">
    <?php
    foreach ($ledigeRomTyper as $rom) {
        RomTypeCard($rom);
    }
    ?>
</div>
</body>
</html>