<?php
require_once '../components/adminCheck.php'
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="../css/main.css">
</head>

<body>
    
<div class="tilbakeKnapp">
    <a href="brukerOversikt.php">
        <button type="button">Tilbake til bruker oversikt</button>
        <br></br>
    </a>
    <br>
</div>


<div class = "container2">
    <h5>Legg til ny bruker:</h5>
</div>

<div class="form">
    <form action="" method="post">
        <div class = "row">
            <div class ="col">
                <label class ="form-label"></label>
                <input type="email" class="form-control" name="Epost" placeholder="Epost">
            </div>
            <div class ="col">
                <label class ="form-label"></label>
                <input type="text" class="form-control" name="Passord" placeholder="Passord">
            </div>
        </div>
        <div>
            <div class ="col">
                    <label class ="form-label"></label>
                    <input type="text" class="form-control" name="Navn" placeholder="Navn">
                </div>
            </div>
            <div class ="col">
                    <label class ="form-label"></label>
                    <input type="text" class="form-control" name="Etternavn" placeholder="Etternavn">
                </div>
            </div>
            <div class ="col">
                    <label class ="form-label"></label>
                    <input type="text" class="form-control" name="Adresse" placeholder="Adresse">
                </div>
            </div>
            <div class ="col">
                    <label class ="form-label"></label>
                    <input type="text" class="form-control" name="Mobilnummer" placeholder="Mobilnummer">
                </div>
            </div>
            <div class="col">
                <label class="form-label"></label>
                <select class="form-control" name="kjonn" required>
                    <option value="" disabled selected>Velg kjonn</option>
                    <option value="F">Kvinne</option>
                    <option value="M">Mann</option>
                    <option value="O">Annet</option>
                </select>
            </div>
            <div>
                <button type = "submit" class ="btn-btn-success" name="submit">Lag bruker</button>
                <a href=brukerOversikt.php class ="btn-btn-danger">Avbryt</a>
            </div>
    </form> 
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


<?php
include "../service/profilService.inc.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Henter form data
    $epost = $_POST['Epost'];
    $passord = password_hash($_POST['Passord'], PASSWORD_DEFAULT); // Hasher passordet
    $navn = $_POST['Navn'];
    $etternavn = $_POST['Etternavn'];
    $adresse = $_POST['Adresse'];
    $mobilnummer = $_POST['Mobilnummer'];
    $kjonn = $_POST['kjonn'];

    // kaller createUser funksjonen fra db functions
    if (createUser($epost, $passord, $navn, $etternavn, $adresse, $mobilnummer, $kjonn)) {
        echo "User created successfully!";
        header("Location: brukerOversikt.php");
    } else {
        echo "Error: Unable to create user.";
    }
}
?>

</body>
</html>
