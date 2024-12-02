<?php

// Include the database configuration
require_once __DIR__ . '/configTestdb.inc.php';

// Seed the database (optional, for testing purposes)
function seedDatabase(mysqli $conn) {
    // Include the required SQL setup file
    require_once __DIR__ . '/dbTestProjectSQL.inc.php'; 

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

/**
 * Returns the database connection for test operations.
 * 
 * @return mysqli The test database connection
 */
function databaseTest(): mysqli {
    global $conn;

    if (!$conn) {
        die("Connection is not established.");
    }

    return $conn;
}
?>
