<?php
// Only start the session if it’s not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$brukerId = $_SESSION['brukerId'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/profil.css">
    <title>Profil</title>
</head>
<body>
<div class="tilbakeKnapp">
    <a href="../index.php">
        <button type="button">Tilbake til start</button>
        <br>
    </a>
    <br>
</div>
<div class="profilTittel">
    <h1>Velkommen til din Profil</h1>
</div>

<?php
include '../service/userService.inc.php';
include '../service/bookingService.inc.php';
$bookings = getBookingByUser($brukerId); // Calls the getAllbookings function
$user = getUserById($_SESSION['brukerId']);
?>
<!-- User Profile Table -->
<div class="container mt-5">
    <h3>Bruker Informasjon:</h3>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Address</th>
            <th>Mobile Number</th>
            <th>Gender</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($user)): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['epost']; ?></td>
                <td><?php echo $user['navn']; ?></td>
                <td><?php echo $user['etternavn']; ?></td>
                <td><?php echo $user['adresse']; ?></td>
                <td><?php echo $user['mobilNummer']; ?></td>
                <td><?php echo $user['kjonn']; ?></td>
                <td>
                    <a href="redigerBruker.php?id=<?php echo $user['id']; ?>" class="btn btn-primary">Edit</a>
                    <a href="slettBruker.php?id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('Er du sikker på at du vil slette denne brukeren?');">Delete</a>
                </td>
            </tr>
        <?php else: ?>
            <tr>
                <td colspan="8" class="text-center">No users found</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<br>

<!-- Bookings Table -->
<div class="container mt-5">
    <h3>Mine Bookinger:</h3>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>BookingNr</th>
            <th>Rom</th>
            <th>Beskrivelse</th>
            <th>Etasje</th>
            <th>Voksne</th>
            <th>Barn</th>
            <th>Start</th>
            <th>Slutt</th>
            <th>Kostnad</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($bookings)): ?>
            <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?php echo $booking->id; ?></td>
                    <td><?php echo $booking->room->navn; ?></td>
                    <td><?php echo $booking->room->beskrivelse; ?></td>
                    <td><?php echo $booking->room->etasje; ?></td>
                    <td><?php echo $booking->antallVoksne; ?></td>
                    <td><?php echo $booking->antallBarn; ?></td>
                    <td><?php echo $booking->startPeriode; ?></td>
                    <td><?php echo $booking->sluttPeriode; ?></td>
                    <td><?php echo $booking->totalPris; ?></td>
                    <td><?php echo $booking->status; ?></td>
                    <td>
                        <?php if ($booking->status == 'confirmed'): ?>
                            <a href="cancelBooking.php?id=<?php echo $booking->id; ?>" class="btn btn-danger btn-sm"
                               onclick="return confirm('Er du sikker på at du vil kansellere denne bookingen?');">Cancel</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="11" class="text-center">Ingen Bookinger Funnet</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
