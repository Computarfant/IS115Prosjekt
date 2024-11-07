<?php

function RomTypeCard(romType $romType)
{
    $romTypeId = $romType->id; // Assuming `romType` has an `id` property.
    echo "<a href='booking.php?romTypeId={$romTypeId}' class='card-link'>";
    echo "<div class='card' style='background-image: url(../assets/image/{$romType->navn}.jpg);'>";
    echo "<div class='card-content'>";
    echo "<h1>".$romType->navn."</h1>";
    echo "<p>Max Guests: " . $romType->maxGjester . "</p>";
    echo "<p>".$romType->beskrivelse."</p>";
    echo "<h3>Available rooms: " . $romType->ledigeRom . "</h3>";
    echo "</div>";
    echo "</div>";
    echo "</a>";
}