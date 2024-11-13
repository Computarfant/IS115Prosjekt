<?php

// Include the test database configuration
$conn = include 'configTestdb.inc.php';
include 'dbTestProjectSQL.inc.php';  // This file will contain the `dbSetupSQL()` function

// Get the list of queries for creating tables and inserting seed data
$queries = dbSetupSQL();

foreach ($queries as $queryName => $query) {
    if (mysqli_query($conn, $query)) {
        echo "$queryName executed successfully.\n";
    } else {
        echo "Error executing $queryName: " . mysqli_error($conn) . "\n";
    }
}

// Close the connection
mysqli_close($conn);
?>
