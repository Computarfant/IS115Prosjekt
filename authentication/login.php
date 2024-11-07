<?php
include '../inc/config.inc.php';
include '../inc/init.inc.php';
session_start();

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

                // Redirect based on user role
                $redirectPage = match ($bruker['rolleId']) {
                    2 => '../userLogic/brukerOversikt.php',
                    1 => '../index.php',
                    default => null
                };

                if ($redirectPage) {
                    header("Location: $redirectPage");
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
}
?>

<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <title>Logg inn</title>
</head>
<body>
<div style='max-width: 500px; margin: auto; text-align: center;'>
    <div>
        <form method="post" action="login.php">
            <h1>Logg inn</h1>
            <label for="epost">epost:<input type="email" name="epost" required><br></label>

            <label for="passord">Passord:<input type="password" name="passord" required><br></label>

            <button type="submit">Logg inn</button>
        </form>
        <p><a href="register.php"><button>Ingen Konto? Registrer deg her</button></a></p>

        <p><a href="dbSetup.php"><button>Generate Database</button></a></p>
    </div>
</div>
</body>
</html>