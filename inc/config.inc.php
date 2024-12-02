<?php
// Database configuration
require_once __DIR__ . '/../vendor/autoload.php';  // Ensure you've installed vlucas/phpdotenv

use Dotenv\Dotenv;

// Load environment variables from .env file
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Read environment variables
$dbHost = $_ENV['DB_HOST'] ?? 'localhost:3306';  // Default to localhost if not set
$dbUser = $_ENV['DB_USER'] ?? 'root';            // Default to root if not set
$dbPass = $_ENV['DB_PASS'] ?? '';                // Default to empty password if not set
$dbName = $_ENV['DB_NAME'] ?? 'IS115Database';   // Default to IS115Database if not set

// Initialize the database connection based on environment variables
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
