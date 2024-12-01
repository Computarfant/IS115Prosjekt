<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'configTestdb.inc.php';  


if (!isset($config) || empty($config)) {
    die("<h1>Configuration error</h1><p>Please ensure that configTest.inc.php is set up correctly for the test environment.</p>");
}

function database(): mysqli {
    global $conn; 

    if (!$conn) {
        die("Connection is not established.");
    }

    return $conn;
}

function seedDatabase(mysqli $conn) {
    require_once 'dbTestProjectSQL.inc.php'; 
    $queries = dbSetupSQL();

    foreach ($queries as $key => $query) {
        if ($conn->query($query) === TRUE) {
            echo "Query '$key' executed successfully.\n";
        } else {
            echo "Error executing query '$key': " . $conn->error . "\n";
        }
    }
}

$conn = database();
seedDatabase($conn);
return $conn;
