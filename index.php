<?php
// Only start the session if it’s not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_GET['message']) && $_GET['message'] === 'Access Denied!') {
    echo '<p style="color: red;">Access Denied!</p>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <title>Homepage</title>
</head>
<body>

<div class="container">
    <h1>Motel Booking Tjeneste</h1>
</div>

<?php
include 'components/navbar.php';
?>

<div class="container">
    <p>Velkommen til vår motell-booking tjeneste :)</p>
</div>

<div class="image-container">
    <img src="assets/image/MOTEL.jpeg" alt="Description of the image" style="max-width: 100%; height: auto;">
</div>
</body>
</html>