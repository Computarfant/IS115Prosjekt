<?php
session_start();
include '../../inc/config.inc.php';
include '../../inc/init.inc.php';
require '../../service/loggingService.inc.php';


if (isset($_GET['logout']) && $_GET['logout'] === 'success') {
    echo '<p style="color: #3def3d;">Bruker logget ut</p>';
}
if (isset($_GET['register']) && $_GET['register'] === 'success') {
    echo '<p style="color: #3def3d;">Registration Successfully</p>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $epost = $_POST['epost'];
    $passord = $_POST['passord'];
    global $conn;

    mysqli_begin_transaction($conn);
    // Prepare SQL statement to find the user based on email
    $stmt = $conn->prepare("SELECT id, epost, passord, rolleId FROM bruker WHERE epost = ?");
    $stmt->bind_param("s", $epost);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $bruker = $result->fetch_assoc();

        if ($bruker) {
            // Check if password matches
            if (password_verify($passord, $bruker['passord'])) {
                $_SESSION['brukerId'] = $bruker['id'];
                $_SESSION['epost'] = $bruker['epost'];
                $_SESSION['rolleId'] = $bruker['rolleId'];
                writeLog($_SESSION['epost'] . ' logged in');
                header("Location: ../../index.php");

                exit;
                } else {
                    echo "Ukjent brukerrolle.";
                }
            } else {
                // Incorrect password
                echo "Feil brukernavn eller passord.";
            }
        } else {
            echo "Database error: " . $stmt->error;
        }
        // Close statement
        $stmt->close();
}
?>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <title>Logg inn</title>
    <link rel="stylesheet" href="../../css/main.css">
</head>
<body>

<div style='max-width: 500px; margin: auto; text-align: center;'>
    <form method="post" action="login.php">
        <h1>Logg inn</h1>
        <label for="epost">Email:</label><br>
        <input required type="email" id="epost" name="epost" value="<?= htmlspecialchars($_POST['epost'] ?? '') ?>">
        <span class="error"><?php echo $errors['epost'] ?? ''; ?></span><br>

        <label for="passord">Passord:</label><br>
        <input required type="password" id="passord" name="passord" value="<?= htmlspecialchars($_POST['passord'] ?? '')?>">
        <span class="error"><?php echo $errors['passord'] ?? ''; ?></span><br>
        <button type="submit">Logg inn</button>
    </form>
    <a href="register.php"><button>Ingen Konto? Registrer deg her</button></a>
    <br>
    <a href="dbSetup.php"><button>Sett opp databasen</button></a>
</div>
</body>
</html>