<?php

function RomTypeCard(romType $romType)
{
    echo "<div>";
    echo "<h1>".$romType->navn."</h1>";
    echo "<p>".$romType->beskrivelse."</p>";
    echo "</div>";
}