<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/main.css">
</head>
<body>


<?php
include "../../../assets/inc/dbFunctions.inc.php";

// Henter  brukerID fra URL
$brukerId = $_GET['id'];

// Henter brukerdata med ID'en
$user = getUserById($brukerId);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Henter oppdatert data fra formen
    $epost = $_POST['epost'];
    $passord = $_POST['passord'];
    $navn = $_POST['navn'];
    $etternavn = $_POST['etternavn'];
    $adresse = $_POST['adresse'];
    $mobilNummer = $_POST['mobilNummer'];
    $kjønn = $_POST['kjønn'];

    // Kaller updateUser funksjonen for å gjøre endringene
    updateUser($brukerId, $epost, $passord, $navn, $etternavn, $adresse, $mobilNummer, $kjønn);
    header("Location: brukerOversikt.php");
    exit();
}
?>

<div class="tilbakeKnapp">
    <a href="brukerOversikt.php">
        <button type="button">Tilbake til bruker oversikt</button>
        <br></br>
    </a>
    <br>
</div>


<div class="edit-form1">
    <h4>Rediger bruker:</h4>
    <br></br>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="epost" class="form-label">Email</label>
            <input type="email" class="form-control" id="epost" name="epost" value="<?php echo $user['epost']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="passord" class="form-label">Password</label>
            <input type="password" class="form-control" id="passord" name="passord" value="">
        </div>
        <div class="mb-3">
            <label for="navn" class="form-label">First Name</label>
            <input type="text" class="form-control" id="navn" name="navn" value="<?php echo $user['navn']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="etternavn" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="etternavn" name="etternavn" value="<?php echo $user['etternavn']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="adresse" class="form-label">Address</label>
            <input type="text" class="form-control" id="adresse" name="adresse" value="<?php echo $user['adresse']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="mobilNummer" class="form-label">Mobile Number</label>
            <input type="text" class="form-control" id="mobilNummer" name="mobilNummer" value="<?php echo $user['mobilNummer']; ?>" required>
        </div>
        <div class="col">
                <label class="form-label"></label>
                <select class="form-control" name="Kjønn" required>
                    <option value="" disabled selected>Velg kjønn</option>
                    <option value="Women">Kvinne</option>
                    <option value="Men">Mann</option>
                    <option value="Other">Annet</option>
                </select>
            </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>





</body>
</html>