<?php

require_once '../../service/loggingService.inc.php';
require_once '../../service/userService.inc.php'; // File where createUser function is defined
require_once '../../service/validationServices.inc.php';

$errors = [];

// Handle form submission
$form_submitted = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrer'])) {
    $form_submitted = true;

    // Runs the $_POST values through the validation functions
    $errors['navn'] = validateFirstName($_POST['navn'] ?? '');
    $errors['etternavn'] = validateLastName($_POST['etternavn'] ?? '');
    $errors['epost'] = validateEmail($_POST['epost'] ?? '');
    $errors['passord'] = validatePassword($_POST['passord'] ?? '');

    // Filter out null values from errors
    $errors = array_filter($errors);

    // If no errors, process registration
    if (empty($errors)) {
        $navn = $_POST['navn'];
        $etternavn = $_POST['etternavn'];
        $epost = $_POST['epost'];
        $passord = password_hash($_POST['passord'], PASSWORD_DEFAULT);

        // Attempt to create user
        if (createUser($epost, $passord, $navn, $etternavn, null, null, null)) {
            header("Location: login.php?register=success");
            exit;
        } else {
            $errors['general'] = "Registration failed. Please try again.";
        }
    }
}
?>

<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../../css/main.css">
</head>
<body>

<div style='max-width: 500px; margin: auto; text-align: center;'>
    <h1>Registrer</h1>

    <form action='register.php' method='POST'>
        <label for="navn">First Name:</label><br>
        <input required type="text" id="navn" name="navn" value="<?= htmlspecialchars($_POST['navn'] ?? '') ?>"><br>
        <span class="error"><?= $form_submitted ? ($errors['navn'] ?? '') : '' ?><br></span>

        <label for="etternavn">Last Name:</label><br>
        <input required type="text" id="etternavn" name="etternavn" value="<?= htmlspecialchars($_POST['etternavn'] ?? '') ?>"><br>
        <span class="error"><?php echo $errors['etternavn'] ?? ''; ?></span><br>

        <label for="epost">Email:</label><br>
        <input required type="text" id="epost" name="epost" value="<?= htmlspecialchars($_POST['epost'] ?? '') ?>"><br>
        <span class="error"><?php echo $errors['epost'] ?? ''; ?></span><br>

        <label for="password">Password:</label><br>
        <input required type="password" id="password" name="passord" value="<?= htmlspecialchars($_POST['passord'] ?? '') ?>"><br>
        <span class="error"><?php echo $errors['passord'] ?? ''; ?></span><br>

        <button type="submit" name="registrer">Opprett Konto</button>
    </form>
    <a href="login.php"><button>Allerede Registrert</button></a>
</body>
</html>
