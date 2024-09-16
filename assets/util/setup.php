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

    $email = $db->real_escape_string($_POST['email']);
    $pass = $db->real_escape_string($_POST['pass']);

    foreach (dbSetupSQL($email, $pass) as $table => $query) {
        $db->query($query);
        if ($temp = $db->error) {
            $err[] = "Database error while trying $table: " . $temp;
        } else {
            $msg[] = "$table query fullførte";
        }
    }
}
/*elseif(isset($_POST['insettPostnumre'])){
    require '../inc/init.inc.php';
    $db = database();

    $sql = file_get_contents('../lib/postnummersql.sql');
    $db->multi_query($sql);
    if($error = $db->error){
        $err[] = "Fikk ikke satt inn postnumre: ".$error;
    }
    else {
        $msg[] = "Satte inn alle postnumre.";
    }
}*/

?><!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup</title>
</head>
<body>
<div style='max-width: 500px; margin: auto; text-align: center;'>
    <h1>Setup</h1>
    <?php
    if(!empty($err)){
        foreach ($err as $e) {
            echo "<div class='alert alert-danger'>$e</div>";
        }
    }
    if(!empty($msg)){
        foreach ($msg as $m) {
            echo "<div class='alert alert-success'>$m</div>";
        }
    }
    if(isset($fatalErr)){
        die();
    }
    ?>
    <form action='setup.php' method='POST'>
        <p><label>E-post:<input type="email" name="email" required></label></p>
        <p><label>Passord:<input type="password" name="pass" required></label></p>
        <p><button name="brukerDatabase">Sett opp databasen</button></p>
    </form>

    <br>
    <p><a href="<?=$pRoot;?>/"><button>Tilbake til Prosjektet</button></a></p>
</body>
</html>
