<?php
session_start();
require '../../service/loggingService.inc.php';
writeLog($_SESSION['epost'] . ' logged out');
session_unset();
session_destroy();
header("Location: login.php?logout=success");

exit;