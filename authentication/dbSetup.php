<?php
//lånt kode
$err = array();
$msg = array();


require_once "../inc/dbProject.inc.php";
require_once '../inc/config.inc.php';

global $config;
$pRoot = $config["general"]["projectRoot"] ?? '';

if(isset($_POST['brukerDatabase'])){
    require '../inc/init.inc.php';
    $db = database();

    $db->query("DROP DATABASE IF EXISTS {$config["db"]["database"]};");
    $db->query("CREATE DATABASE {$config["db"]["database"]};");
    $db->query("USE {$config["db"]["database"]};");

    foreach (dbSetupSQL() as $table => $query) {
        $db->query($query);
        if ($temp = $db->error) {
            $err[] = "Database error while trying $table: " . $temp;
        } else {
            $msg[] = "$table query fullførte";
        }
    }
}

?><!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <title>Setup</title>
</head>
<body>
<div style='max-width: 500px; margin: auto; text-align: center;'>
    <h1>Setup</h1>
    <?php
    if(!empty($err)){
        foreach ($err as $e) {
            echo "<div>$e</div>";
        }
    }
    if(!empty($msg)){
        foreach ($msg as $m) {
            echo "<div>$m</div>";
        }
    }
    if(isset($fatalErr)){
        die();
    }
    ?>
    <form action='dbSetup.php' method='POST'>
        <p><button name="brukerDatabase">Sett opp databasen</button></p>
    </form>

    <br>
    <p><a href="../index.php"><button>Tilbake til Prosjektet</button></a></p>
</body>
</html>
