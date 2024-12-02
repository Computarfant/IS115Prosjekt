<?php

function RomTypeCard($room, $innsjekking, $utsjekking)
{
    $roomId = $room->id;
    $romType = $room->romType;

    echo "<div class='card' style='background-image: url(../../assets/image/{$romType->navn}.jpg);'>";
    echo "<div class='card-content'>";
    echo "<h1>" . htmlspecialchars($romType->navn) . "</h1>";
    echo "<p>Room number: " . htmlspecialchars($room->navn) . "</p>";  // Unique room ID for each card
    echo "<p>Max Guests: " . htmlspecialchars($romType->maxGjester) . "</p>";
    echo "<p>" . htmlspecialchars($romType->beskrivelse) . "</p>";
    
    // Pass specific roomId to the booking confirmation link
    echo "<a href='confirmBooking.php?roomId={$roomId}&innsjekking=$innsjekking&utsjekking=$utsjekking' class='book-now-button'>";
    echo "<button type='button'>Book Now</button>";
    echo "</a>";

    echo "</div>";
    echo "</div>";
}
?>
