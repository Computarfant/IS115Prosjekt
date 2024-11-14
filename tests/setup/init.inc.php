<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Load the same config file (or an equivalent one for tests)
require_once 'configTestdb.inc.php';  // Use the appropriate config file for the test

// Check if the config is loaded correctly
if (!isset($config) || empty($config)) {
    die("<h1>Configuration error</h1><p>Please ensure that configTest.inc.php is set up correctly for the test environment.</p>");
}

// Use the same method to create a database connection
function database(): mysqli {
    global $config;

    $db = new mysqli(
        $config["db"]["host"],
        $config["db"]["user"],
        $config["db"]["pass"],
        $config["db"]["database"]
    );

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    return $db;
}


function seedDatabase(mysqli $conn) {
    require_once 'dbTestProjectSQL.inc.php'; // Load the SQL queries
    $queries = dbSetupSQL(); // Fetch the seed queries

    // Execute each query
    foreach ($queries as $key => $query) {
        if ($conn->query($query) === TRUE) {
            echo "Query '$key' executed successfully.\n";
        } else {
            echo "Error executing query '$key': " . $conn->error . "\n";
        }
    }
}


// Return the database connection for use in tests
$conn = database();
seedDatabase($conn);
return $conn;
