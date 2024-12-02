<?php
// Initialize error and message arrays
$err = array();
$msg = array();

// Include the database configuration and init file
require_once "../../inc/dbProject.inc.php";
require_once '../../inc/config.inc.php'; // This file is still needed for environment setup

global $conn;

// Get database details from environment variables
$dbHost = $_ENV['DB_HOST'] ?? 'localhost:3306';
$dbUser = $_ENV['DB_USER'] ?? 'root';
$dbPass = $_ENV['DB_PASS'] ?? '';
$dbName = $_ENV['DB_NAME'] ?? 'IS115Database'; // Or use $_ENV['TEST_DB_NAME'] if you're setting up a test environment

if (isset($_POST['brukerDatabase'])) {
    // Initialize the database connection
    require '../../inc/init.inc.php';
    
    // Use the environment variables directly
    $db = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    // Ensure connection is successful
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Execute SQL to drop and recreate the database
    $db->query("DROP DATABASE IF EXISTS $dbName;");
    $db->query("CREATE DATABASE $dbName;");
    $db->query("USE $dbName;");

    // Loop through queries to set up tables
    foreach (dbSetupSQL() as $table => $query) {
        $db->query($query);
        if ($temp = $db->error) {
            $err[] = "Database error while trying $table: " . $temp;
        } else {
            $msg[] = "$table query fullførte";
        }
    }
}

?><!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/main.css">
    <title>Setup</title>
</head>
<body>
<div style='max-width: 500px; margin: auto; text-align: center;'>
    <h1>Database Setup</h1>
    <?php
    if (!empty($err)) {
        foreach ($err as $e) {
            echo "<div>$e</div>";
        }
    }
    if (!empty($msg)) {
        foreach ($msg as $m) {
            echo "<div>$m</div>";
        }
    }
    if (isset($fatalErr)) {
        die();
    }
    ?>
    <form action='dbSetup.php' method='POST'>
        <p>Opprett en database og rediger config settings før en trykker på knappen</p>
        <p><button name="brukerDatabase">Sett opp databasen</button></p>
    </form>

    <br>
    <p><a href="../../index.php"><button>Tilbake til Prosjektet</button></a></p>
</body>
</html>

