<?php
require '../service/romAdmin.inc.php';
require_once '../components/adminCheck.php';

if (isset($_GET['id'])) {
    $roomId = $_GET['id'];

    // Call the deleteRoom function to delete the room
    if (deleteRoom($roomId)) {
            
        // Redirect to a success page or show a success message
        header('Location: romOversikt.php?message=Rom slettet');
    } else {
        // Handle failure, for example, show an error message
        echo "Feil oppstod. Kunne ikke slette rommet.";
    }
} else {
    // Handle the case where the room ID was not provided
    echo "Ingen rom-ID spesifisert.";
}
?>