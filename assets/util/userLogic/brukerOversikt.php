
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../cssDesign/bruker.css">
   

</head>
<body>

<?php
include "../../../assets/inc/dbFunctions.inc.php";
$users = getAllUsers(); // Calls the getAllUsers function
?>

<div class="tilbakeKnapp">
    <a href="../index.php">
        <button type="button">Tilbake til start</button>
        <br></br>
    </a>
    <br>
</div>


<h4>Bruker liste:</h4>

<div class="container mt-5">
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
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['brukerId']; ?></td>
                        <td><?php echo $user['epost']; ?></td>
                        <td><?php echo $user['navn']; ?></td>
                        <td><?php echo $user['etternavn']; ?></td>
                        <td><?php echo $user['adresse']; ?></td>
                        <td><?php echo $user['mobilNummer']; ?></td>
                        <td><?php echo $user['kjønn']; ?></td>
                        <td>
                            <a href="redigerBruker.php?id=<?php echo $user['brukerId']; ?>" class="btn btn-primary">Edit</a>

                            <a href="slettBruker.php?id=<?php echo $user['brukerId']; ?>" class="btn btn-danger btn-sm" 
                              onclick="return confirm('Er du sikker på at du vil slette denne brukeren?');">Delete</a>

                        </td>
                    
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">No users found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="navbar">
    <a href="opprettBruker.php">Opprett ny bruker</a>
    <br></br>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>