<?php
require_once '../components/adminCheck.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="../css/main.css">
</head>

<body>
    
<?php
include "../service/romAdmin.inc.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Henter form data
    $navn = $_POST['navn'];
    $beskrivelse = $_POST['beskrivelse'];
    $etasje = $_POST['etasje'];
    $romTypeId = $_POST['romTypeId'];
    
    // kaller createUser funksjonen fra db functions
    if (createRoom($navn, $beskrivelse, $etasje, $romTypeId)) {
        echo "Rom opprettet!";
        header("Location: romOversikt.php");
    } else {
        echo "Error: Klarte ikke å opprette rom.";
    }
}
?>


<div class="tilbakeKnapp">
    <a href="romOversikt.php">
        <button type="button">Tilbake til rom administrering</button>
        <br></br>
    </a>
    <br>
</div>


<div class = "container2">
    <h5>Opprett nytt rom:</h5>
</div>

<div class="form">
    <form action="" method="post">
        <div class = "row">
            <div class ="col">
                <label class ="form-label">
                <input type="text" class="form-control" name="navn" placeholder="Navn"></label>
            </div>
            <div class ="col">
                <label class ="form-label">
                <input type="text" class="form-control" name="beskrivelse" placeholder="Beskrivelse"></label>
            </div>
            <div class ="col">
                <label class ="form-label">
                <input type="text" class="form-control" name="etasje" placeholder="Etasje"></label>
            </div>
            <div class ="col">
                <label class ="form-label">
                <input type="text" class="form-control" name="romTypeId" placeholder="romTypeId"></label>
            </div>
        </div>

            <div>
                <button type = "submit" class ="btn-btn-success" name="submit">Lag Rom</button>
                <br></br>
            </div>
            <div class = "avbryt">
                <a href=romOversikt.php class ="btn-btn-danger">Avbryt</a>
            </div>
    </form> 
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>



</body>
</html>
