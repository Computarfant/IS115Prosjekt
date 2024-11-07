<?php
require '../inc/init.inc.php';
require '../models/romType.php';

function mapTilModel($rad) {
    return new romType(
        $rad['id'],
        $rad['navn'],
        $rad['beskrivelse'],
        $rad['pris'],
        $rad['maxGjester'],
        $rad['ledigeRom']
    );
}
function searchAvailebleRooms($innsjekking, $utsjekking): array
{
    $db = database();

    $sql = $db->prepare("SELECT rt.*, COUNT(r.id) AS ledigeRom
                                FROM Rom AS r
                                INNER JOIN romType rt ON r.rtid = rt.id
                                WHERE r.id NOT IN (
                                    SELECT rid 
                                    FROM booking 
                                        WHERE startPeriode <= ? 
                                        AND sluttPeriode >= ?
                                )
                                GROUP BY r.rtid");

    $sql->bind_param("ss", $innsjekking, $utsjekking);
    $sql->execute();

    $rows = $sql
        ->get_result()
        ->fetch_all(MYSQLI_ASSOC);

    return array_map("mapTilModel", $rows);
}
