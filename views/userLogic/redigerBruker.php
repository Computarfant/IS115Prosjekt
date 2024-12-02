<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../../service/userService.inc.php";
require_once "../../service/validationServices.inc.php";

// Henter brukerID fra URL
$brukerId = $_GET['id'];

// Henter brukerdata med ID'en
$user = getUserById($brukerId);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Henter oppdatert data fra formen
    $epost = $_POST['epost'];
    $passord = password_hash($_POST['passord'], PASSWORD_DEFAULT);
    $navn = $_POST['navn'];
    $etternavn = $_POST['etternavn'];
    $adresse = $_POST['adresse'];
    $mobilNummer = $_POST['mobilNummer'];
    $rolleId = $_POST['rolleId'];
    $kjonn = $_POST['kjonn'];

    // Kaller updateUser funksjonen for å gjøre endringene
    updateUser($brukerId, $epost, $passord, $rolleId, $navn, $etternavn, $adresse, $mobilNummer, $kjonn);
    header("Location: brukerOversikt.php");
    exit();
}

?>
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
<div class="tilbakeKnapp">
    <a href="brukerOversikt.php">
        <button type="button">Tilbake til bruker oversikt</button>
        <br>
    </a>
    <br>
</div>


<div class="edit-form1">
    <h4>Edit User:</h4>
    <br>
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
            <label id="kjonn">
                <select class="form-control" name="kjonn" required>
                    <option value="" disabled selected>Velg kjonn</option>
                    <option value="F">Kvinne</option>
                    <option value="M">Mann</option>
                    <option value="O">Annet</option>
                </select>
            </label>
        </div>
        <div class="col">
            <label class="form-label"></label>
            <label id="rolleId">
                <select class="form-control" name="rolleId" required>
                    <option value="" disabled selected>Velg Rolle</option>
                    <option value="1">Bruker</option>
                    <option value="2">Admin</option>
                </select>
            </label>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
