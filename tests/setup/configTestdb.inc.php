<?php

$config["db"]["host"] = "localhost:3306";
$config["db"]["user"] = "root";
$config["db"]["pass"] = "";
$config["db"]["database"] = "TESTDatabase";

global $conn; 

var_dump($config["db"]["host"]);
var_dump($config["db"]["user"]);
var_dump($config["db"]["pass"]);
var_dump($config["db"]["database"]);


$conn = new mysqli(
    $config["db"]["host"],
    $config["db"]["user"],
    $config["db"]["pass"],
    $config["db"]["database"]
);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Database connected successfully ";
}
?>

