<?php

function RomTypeCard(romType $romType)
{
    echo "<div class='card' style='background-image: url(../assets/image/{$romType->navn}.jpg);'>";
    echo "<div class='card-content'>";
    echo "<h1>".$romType->navn."</h1>";
    echo "<p>Max Guests: " . $romType->maxGjester . "</p>";
    echo "<p>".$romType->beskrivelse."</p>";
    echo "<h3>Available rooms: " . $romType->ledigeRom . "</h3>";
    echo "</div>";
    echo "</div>";
}