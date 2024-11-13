<?php
// Configuration file for the test database

$config["db"]["host"] = "localhost:3306";
$config["db"]["user"] = "root";
$config["db"]["pass"] = "";
$config["db"]["database"] = "TESTDatabase";

$conn = mysqli_connect(
    $config["db"]["host"],
    $config["db"]["user"],
    $config["db"]["pass"],
    $config["db"]["database"]
);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Return the connection object for use in the setup script
return $conn;
?>

