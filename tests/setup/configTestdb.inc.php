<?php
// Configuration file for the test database
$config["db"]["host"] = "localhost:3306";
$config["db"]["user"] = "root";
$config["db"]["pass"] = "";
$config["db"]["database"] = "TESTDatabase";

// Establish a connection using the object-oriented style
$conn = new mysqli(
    $config["db"]["host"],
    $config["db"]["user"],
    $config["db"]["pass"],
    $config["db"]["database"]
);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Database connected successfully ";
}

return $conn;

?>

