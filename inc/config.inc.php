<?php
//lånt kode
//Database configs
$config["db"]["host"] = "localhost:3306";
$config["db"]["user"] = "root";
$config["db"]["pass"] = "";
$config["db"]["database"] = "IS115Database";

//Server configs
$config["general"]["projectRoot"] = "";
$config["general"]["pepper"] = "IAmBadAtSecurity";

//Mail configs
/*$config["mail"]["smtpServer"] = "smtp.gmail.com";
$config["mail"]["username"] = "mail";
$config["mail"]["password"] = "password";*/

$conn = mysqli_connect($config["db"]["host"], $config["db"]["user"], $config["db"]["pass"], $config["db"]["database"]);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
