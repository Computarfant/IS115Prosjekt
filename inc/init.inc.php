<?php
// Include the central configuration file
require_once __DIR__ . '/config.inc.php';

// Ensure the database connection is established
if (!$conn) {
    die("<h1>Configuration error</h1><p>Could not connect to the database. Please check your connection settings.</p>");
}

// Define the project root for use in the application
$projectRoot = getEnvVar('PROJECT_ROOT', '/');
?>
