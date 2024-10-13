<?php
    require_once 'service/bookingService.inc.php';
    require_once 'components/romTypeCard.php';

    $ledigeRomTyper = [];
    $innsjekking = "";
    $utsjekking = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $antallBarn = $_POST['Barn'];
    $antallVoksne = $_POST['Voksne'];
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


</head>
<body>

<form method="POST">
    <label for="Barn">Antall Barn</label>
    <input type="number" name="Barn" id="Barn">

    <label for="Voksne">Voksne</label>
    <input type="number" name="Voksne" id="Voksne">

    <label for="Innsjekking">Innsjekking</label>
    <input type="date" name="Innsjekking" id="Innsjekking">

    <label for="Utsjekking">Utsjekking</label>
    <input type="date" name="Utsjekking" id="Utsjekking">

    <button type="submit">Search</button>
</form>
<?php
foreach ($ledigeRomTyper as $rom) {
    RomTypeCard($rom);
}
?>
</body>
</html>