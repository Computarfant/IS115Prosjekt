<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bruker.css">
   

</head>
<body>

<?php
include "../service/romAdmin.inc.php";
// Kaller getAllRooms funksjonen
$rom = getAllRooms(); 
?>

<div class="tilbakeKnapp">
    <a href="../index.php">
        <button type="button">Tilbake til start</button>
        <br></br>
    </a>
    <br>
</div>

<h4>Rom administrering:</h4>

<div class="container mt-5">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Rom ID</th>
                <th>Navn</th>
                <th>Beskrivelse</th>
                <th>Etasje</th>
                <th>Rom Type ID</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($rom)): ?>
                <?php foreach ($rom as $room): ?> 
                    <tr>
                        <td><?php echo $room->id; ?></td> <!-- Henter rom objektets egenskaper -->
                        <td><?php echo $room->navn; ?></td>
                        <td><?php echo $room->beskrivelse; ?></td>
                        <td><?php echo $room->etasje; ?></td>
                        <td><?php echo $room->rtid; ?></td>
                        <td>
                            <a href="redigerRom.php?id=<?php echo $room->id; ?>" class="btn btn-primary">Edit</a>

                            <a href="slettRom.php?id=<?php echo $room ->id; ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('Er du sikker på at du vil slette dette rommet?');">Delete</a>



                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No rooms found</td> 
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="navbar">
    <a href="opprettRom.php">Opprett nytt Rom</a>
    <br></br>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>