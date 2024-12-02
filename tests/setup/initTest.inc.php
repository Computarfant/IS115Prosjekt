<?php

// Set environment variables from $_ENV or default values
$environment = $_ENV['ENVIRONMENT'] ?? 'production';

if ($environment === 'test') {
    // Test Database Configuration using environment variables
    $dbHost = $_ENV['TEST_DB_HOST'] ?? 'localhost:3306';
    $dbUser = $_ENV['TEST_DB_USER'] ?? 'root';
    $dbPass = $_ENV['TEST_DB_PASS'] ?? '';
    $dbName = $_ENV['TEST_DB_NAME'] ?? 'TESTDatabase';
} else {
    // Main Database Configuration using environment variables
    $dbHost = $_ENV['DB_HOST'] ?? 'localhost:3306';
    $dbUser = $_ENV['DB_USER'] ?? 'root';
    $dbPass = $_ENV['DB_PASS'] ?? '';
    $dbName = $_ENV['DB_NAME'] ?? 'IS115Database';
}

global $conn;

// Debugging to confirm which environment is active
echo "Current Environment: " . $environment . PHP_EOL;
echo "Database: " . $dbName . PHP_EOL;

// Establish connection
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Database connected successfully ";
}

// Seed the database if needed (optional, for testing purposes)
function seedDatabase(mysqli $conn) {
    // Make sure to include the required SQL setup file
    require_once 'dbTestProjectSQL.inc.php'; 

    // Retrieve the SQL queries for seeding the database
    $queries = dbSetupSQL();

    // Iterate over each query and execute it
    foreach ($queries as $key => $query) {
        if ($conn->query($query) === TRUE) {
            echo "Query '$key' executed successfully.\n";
        } else {
            echo "Error executing query '$key': " . $conn->error . "\n";
        }
    }
}

function databaseTest(): mysqli {
    global $conn; 

    if (!$conn) {
        die("Connection is not established.");
    }

    return $conn;
}

// Optionally, you can call the seed function like so:
// seedDatabase($conn);
?>

