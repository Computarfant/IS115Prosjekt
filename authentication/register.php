<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
<div style='max-width: 500px; margin: auto; text-align: center;'>
    <h1>Registrer</h1>
    <?php
    if(!empty($err)){
        foreach ($err as $e) {
            echo "<div>$e</div>";
        }
    }
    if(!empty($msg)){
        foreach ($msg as $m) {
            echo "<div>$m</div>";
        }
    }
    if(isset($fatalErr)){
        die();
    }
    ?>
    <form action='register.php' method='POST'>
        <label for="navn">First Name:</label><br>
        <input required type="text" id="navn" name="navn" value="<?= htmlspecialchars($_POST['navn'] ?? '') ?>"><br>

        <label for="etternavn">Last Name:</label><br>
        <input required type="text" id="etternavn" name="etternavn" value="<?= htmlspecialchars($_POST['etternavn'] ?? '') ?>"><br>

        <label for="epost">epost:</label><br>
        <input required type="email" id="epost" name="epost" value="<?= htmlspecialchars($_POST['epost'] ?? '') ?>"><br>

        <label for="password">Password:</label><br>
        <input required type="password" id="password" name="passord" value="<?= htmlspecialchars($_POST['passord'] ?? '') ?>"><br>

        <!--<label for="adresse"></label><br>
        <input type="hidden" id="adresse" name="adresse" value="<?= htmlspecialchars($_POST['adresse'] ?? '') ?>"><br>
        <label for="mobilnummer"></label><br>
        <input type="hidden" id="mobilnummer" name="mobilnummer" value="<?= htmlspecialchars($_POST['mobilnummer'] ?? '') ?>"><br>
        <label for="kjonn"></label><br>
        <input type="hidden" id="kjonn" name="kjonn" value="<?= htmlspecialchars($_POST['kjonn'] ?? '') ?>"><br> -->

        <button type="submit" name="registrer">Opprett Konto</button>
    </form>

    <br>
    <p><a href="login.php"><button>Allerede Registrert</button></a></p>
</body>
</html>

<?php
// Include database connection file
require_once '../inc/config.inc.php'; // Adjust the path as needed
require_once '../service/profilService.inc.php'; // File where createUser function is defined

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
    } else {
        echo "<p>Registration failed. Please try again.</p>";
    }
}
?>