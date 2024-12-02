<?php
require_once '../../service/loggingService.inc.php';
require_once '../../service/userService.inc.php'; // File where createUser function is defined
require_once '../../service/validationServices.inc.php';

$errors = [];

// Handle form submission
$form_submitted = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $form_submitted = true;

    // Runs the $_POST values through the validation functions
    $errors['navn'] = validateFirstName($_POST['navn'] ?? '');
    $errors['etternavn'] = validateLastName($_POST['etternavn'] ?? '');
    $errors['epost'] = validateEmail($_POST['epost'] ?? '');
    $errors['passord'] = validatePassword($_POST['passord'] ?? '');
    $errors['adresse'] = validateAdresse($_POST['adresse'] ?? '');
    $errors['mobilnummer'] = validateMobilnummer($_POST['mobilnummer'] ?? '');

    // Filter out null values from errors
    $errors = array_filter($errors);

    // If no errors, process registration
    if (empty($errors)) {
        $navn = $_POST['navn'];
        $etternavn = $_POST['etternavn'];
        $epost = $_POST['epost'];
        $passord = password_hash($_POST['passord'], PASSWORD_DEFAULT);
        $adresse = $_POST['adresse'];
        $mobilnummer = $_POST['mobilnummer'];
        $kjonn = $_POST['kjonn'];

        // kaller createUser funksjonen fra db functions
        if (createUser($epost, $passord, $navn, $etternavn, $adresse, $mobilnummer, $kjonn)) {
            echo "User created successfully!";
            header("Location: brukerOversikt.php");
            exit;
        } else {
            $errors['general'] = "Failed to Create User.";
        }
    }
}
?>

<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oppret Bruker</title>
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

<div style='max-width: 500px; margin: auto; text-align: center;'>
    <h1>Create User</h1>

    <form action='opprettBruker.php' method='POST'>
        <label for="navn">First Name:</label><br>
        <input type="text" id="navn" name="navn" value="<?= htmlspecialchars($_POST['navn'] ?? '') ?>"><br>
        <span class="error"><?= $form_submitted ? ($errors['navn'] ?? '') : '' ?><br></span>

        <label for="etternavn">Last Name:</label><br>
        <input type="text" id="etternavn" name="etternavn" value="<?= htmlspecialchars($_POST['etternavn'] ?? '') ?>"><br>
        <span class="error"><?php echo $errors['etternavn'] ?? ''; ?></span><br>

        <label for="epost">Email:</label><br>
        <input type="text" id="epost" name="epost" value="<?= htmlspecialchars($_POST['epost'] ?? '') ?>"><br>
        <span class="error"><?php echo $errors['epost'] ?? ''; ?></span><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="passord" value="<?= htmlspecialchars($_POST['passord'] ?? '') ?>"><br>
        <span class="error"><?php echo $errors['passord'] ?? ''; ?></span><br>

        <label for="adresse">Adresse:</label><br>
        <input type="text" id="adresse" name="adresse" value="<?= htmlspecialchars($_POST['adresse'] ?? '') ?>"><br>
        <span class="error"><?= $form_submitted ? ($errors['adresse'] ?? '') : '' ?><br></span>

        <label for="mobilnummer">Phone Number:</label><br>
        <input type="text" id="mobilnummer" name="mobilnummer" value="<?= htmlspecialchars($_POST['mobilnummer'] ?? '') ?>"><br>
        <span class="error"><?= $form_submitted ? ($errors['mobilnummer'] ?? '') : '' ?><br></span>

        <div class="col">
            <label class="form-label"></label>
            <label>
                <select class="form-control" name="kjonn" >
                    <option value="" disabled selected>Velg kjonn</option>
                    <option value="F">Female</option>
                    <option value="M">Male</option>
                    <option value="O">Other</option>
                </select>
            </label>
        </div>
        <button type="submit" name="create">Opprett Bruker</button>
    </form>
</div>
</body>
</html>


