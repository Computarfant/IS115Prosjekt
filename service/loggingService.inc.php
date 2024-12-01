<?php
//include '../inc/init.inc.php';

$log = '../service/log.txt';

function writeLog($message): void
{
    global $log;

    // Append the log message to the file with a timestamp
    $timestamp = date('Y-m-d H:i:s');
    $logLine = "[$timestamp] $message" . PHP_EOL;

    file_put_contents($log, $logLine, FILE_APPEND);
}

function getChosenLog($logs): bool|array
{
    global $log;

    // Checks that the file exists
    if (!file_exists($log)) {
        return [];
    }
    // Reads the file as arrays of lines
    $lines = file($log, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Returns the chosen amount of resent lines
    return array_slice($lines, - $logs);
}