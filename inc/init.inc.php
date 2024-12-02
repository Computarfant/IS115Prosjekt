<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database configuration (this will load environment variables and set up $conn)
require_once __DIR__ . '/config.inc.php';

// Check if database connection is established correctly
if (!$conn) {
    die("<h1>Configuration error</h1><p>Could not connect to the database. Please check your connection settings.</p>");
}

$projectRoot = $_ENV['PROJECT_ROOT'] ?? '/'; 

// Function to retrieve configuration values from environment variables
function getEnvVar($key, $default = null) {
    return $_ENV[$key] ?? $default;
}

// Function to configure a new database connection and return a mysqli object (using environment variables)
function database(): mysqli {
    // Use environment variables directly
    $dbHost = $_ENV['DB_HOST'] ?? 'localhost:3306';
    $dbUser = $_ENV['DB_USER'] ?? 'root';
    $dbPass = $_ENV['DB_PASS'] ?? '';
    $dbName = $_ENV['DB_NAME'] ?? 'IS115Database';

    // Create a new connection using the environment variables
    $db = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    return $db;
}
