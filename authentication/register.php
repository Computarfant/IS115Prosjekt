<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>

<div style='max-width: 500px; margin: auto; text-align: center;'>
    <h1>Registrer</h1>

    <form action='register.php' method='POST'>
        <label for="navn">First Name:</label><br>
        <input required type="text" id="navn" name="navn" value="<?= htmlspecialchars($_POST['navn'] ?? '') ?>">
        <span class="error"><?php echo $errors['navn'] ?? ''; ?></span><br>

        <label for="etternavn">Last Name:</label><br>
        <input required type="text" id="etternavn" name="etternavn" value="<?= htmlspecialchars($_POST['etternavn'] ?? '') ?>">
        <span class="error"><?php echo $errors['etternavn'] ?? ''; ?></span><br>

        <label for="epost">Email:</label><br>
        <input required type="email" id="epost" name="epost" value="<?= htmlspecialchars($_POST['epost'] ?? '') ?>">
        <span class="error"><?php echo $errors['epost'] ?? ''; ?></span><br>

        <label for="password">Password:</label><br>
        <input required type="password" id="password" name="passord" minlength="10" value="<?= htmlspecialchars($_POST['passord'] ?? '') ?>">
        <span class="error"><?php echo $errors['passord'] ?? ''; ?></span><br>

        <button type="submit" name="registrer">Opprett Konto</button>
    </form>
    <a href="login.php"><button>Allerede Registrert</button></a>
</body>
</html>

<?php
session_start();
// Include database connection file
require_once '../inc/config.inc.php'; // Adjust the path as needed
require_once '../service/profilService.inc.php'; // File where createUser function is defined
require '../service/loggingService.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrer'])) {
    // Get form inputs
    $epost = $_POST['epost'];
    $passord = password_hash($_POST['passord'], PASSWORD_DEFAULT); // Hash the password for security
    $navn = $_POST['navn'];
    $etternavn = $_POST['etternavn'];
    $adresse = null;
    $mobilnummer = null;
    $kjonn = null;

    // Call the createUser function
    if (createUser($epost, $passord, $navn, $etternavn, $adresse, $mobilnummer, $kjonn)) {
        echo "<p>Registration successful! You can now <a href='login.php'>log in</a>.</p>";
        writeLog('User ' . $epost . ' Created');
    } else {
        echo "<p>Registration failed. Please try again.</p>";
    }
}
?>