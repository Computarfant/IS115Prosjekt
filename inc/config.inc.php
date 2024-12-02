<?php
// Load environment variables using vlucas/phpdotenv
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Database configuration from environment variables
$dbHost = $_ENV['DB_HOST'] ?? 'localhost:3306';
$dbUser = $_ENV['DB_USER'] ?? 'root';
$dbPass = $_ENV['DB_PASS'] ?? '';
$dbName = $_ENV['DB_NAME'] ?? 'IS115Database';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize the database connection
global $conn;
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/**
 * Helper function to get an environment variable with a default fallback.
 *
 * @param string $key The environment variable key.
 * @param mixed $default Default value if the variable is not set.
 * @return mixed The value of the environment variable or the default.
 */
function getEnvVar(string $key, $default = null) {
    return $_ENV[$key] ?? $default;
}

/**
 * Returns a new database connection using the environment variables.
 *
 * @return mysqli The database connection.
 */
function database(): mysqli {
    $dbHost = $_ENV['DB_HOST'] ?? 'localhost:3306';
    $dbUser = $_ENV['DB_USER'] ?? 'root';
    $dbPass = $_ENV['DB_PASS'] ?? '';
    $dbName = $_ENV['DB_NAME'] ?? 'IS115Database';

    $db = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    return $db;
}
?>


