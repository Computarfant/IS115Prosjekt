<?php
require_once '../../components/adminCheck.php';
require_once '../../service/loggingService.inc.php';

$defaultLogLines = 20;
$displayedLogs = [];
$error = null;

// Request from form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fetch'])) {
    $logs = $_POST['logLines'];

    // Validates that it is a positive Number
    if (!is_numeric($logs) || $logs <= 0) {
        $error = "Only Positive Numbers allowed.";
    } else {
        $displayedLogs = getChosenLog((int)$logs);
    }
} else {
    // Load default 20 lines on initial page load
    $displayedLogs = getChosenLog($defaultLogLines);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log</title>
    <link rel="stylesheet" href="../../css/main.css">
</head>
<body>
<div class="tilbakeKnapp">
    <a href="../../index.php">
        <button type="button">Tilbake til start</button>
        <br>
    </a>
    <br>
</div>

<form action="logOversikt.php" method="POST">
    <label for="logLines">Recent Logs Displayed:</label><br>
    <input type="number" id="logLines" name="logLines" value="<?= htmlspecialchars($_POST['logLines'] ?? $defaultLogLines) ?>"><br>
    <button type="submit" name="fetch">Fetch Lines</button>
</form>


<?php if (isset($error)): //Put validation in validationService.inc.php?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<?php if (!empty($displayedLogs)): ?>
    <h2>Recent Logs:</h2>
    <pre style="text-align: left; padding: 20px; border: 2px solid #ffffff;">
<?= htmlspecialchars(implode("\n", $displayedLogs)) ?>
    </pre>
<?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <p>No logs available to display.</p>
<?php endif; ?>
</body>
</html>
