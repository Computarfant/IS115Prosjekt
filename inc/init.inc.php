<?php
//lånt kode
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once 'config.inc.php';

//Error om config.inc.php ikke er opprettet.
if(!isset($config) || empty($config)){
    die("<h1>Configuration error</h1><p>Copy the webdata/config.inc.sample.php file to webdata/config.inc.php and fill out your connection settings.</p>");
}

$projectRoot = $config["general"]["projectRoot"];

//Henter en configurasjon variabel
function getConfig($val, $group = "general"){
    global $config;

    if(isset($config[$group][ $val ])){
        return $config[$group][$val];
    }
    return false;
}

//Konfigurer en ny databasetilkobling og returnerer et mysqli objekt
function database():mysqli{
    global $config;

    $db = new mysqli($config["db"]["host"], $config["db"]["user"], $config["db"]["pass"], $config["db"]["database"]);

    if($db->connect_error){
        die("Connection failed: " . $db->connect_error);
    }

    return $db;
}
