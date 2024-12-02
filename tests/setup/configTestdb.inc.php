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
?>



