<?php
require '../inc/init.inc.php';
require '../models/romType.php';
require '../models/rom.php';

/** Retrives all rooms and returns a matrix of room objects
 *
 * @return array
 */
function getAllRooms() {
    global $conn;

    // SQL spørring for å hente rom informasjon
    $sql = "SELECT id, navn, beskrivelse, etasje, rtId 
            FROM Rom"; 

    $result = mysqli_query($conn, $sql);
    
    $rooms = []; // Array/matrise for å holde rom objekter

    // Henter resultatene og lager rom objekter
    while ($row = mysqli_fetch_assoc($result)) {
        // Lager et rom objekt for dataen som har blitt innhentet
        $rooms[] = new rom($row['id'],$row['navn'],$row['beskrivelse'], $row['etasje'], $row['rtId'], null); // Setting romType to null for now
    }

    return $rooms; // Return the array of rom objects
}


/** Get room by rom.id
 *
 * @param $roomId
 * @return rom|null
 */
function getRoomById($roomId) {
    global $conn;
    $sql = "SELECT * FROM rom WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $roomId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        // Henter romType-data
        $romType = getRoomTypeById($row['rtid']); 
        // Returner rom-objekt med romType-data
        return new rom($row['id'], $row['navn'],$row['beskrivelse'], $row['etasje'], $row['rtid'], $romType);
    }
    // Returner null hvis romType ikke finnes
    return null; 
}

/** Fetches roomType by romType.id
 *
 * @param $rtid         //romTypeId
 * @return romType|null
 */
function getRoomTypeById($rtid): ?romType
{
    global $conn;
    $sql = "SELECT * FROM RomType WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $rtid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt); 
    
    if ($row = mysqli_fetch_assoc($result)) {
        // Returnerer en instans av romType-klassen
        //Debugging
        //echo "<p>Debug: Room Type ID = $romTypeId</p>";
        //echo "<p>Debug: Room Type Name = " . htmlspecialchars($row['navn']) . "</p>";
        return new romType($row['id'], $row['navn'], $row['beskrivelse'], $row['pris'], $row['maxGjester'], null);
    }
    // Returner null hvis romType ikke finnes
    return null; 
}

/**Fetches all rooms
 *
 * @return array
 */
function getAllRomTypes() {
    global $conn;
    $sql = "SELECT * FROM RomType";
    $result = mysqli_query($conn, $sql);
    $romTypes = [];
    while ($row = mysqli_fetch_object($result)) {
        $romTypes[] = $row; 
    }
    return $romTypes;
}

/** Updates specific room and its details
 *
 * @param $roomId
 * @param $navn
 * @param $beskrivelse
 * @param $etasje
 * @param $rtid
 * @return void
 */
function updateRoom($roomId, $navn, $beskrivelse, $etasje, $rtid) {
    global $conn;
    $sqlUpdateRoom = "UPDATE rom SET etasje = ?, rtid = ? WHERE id = ?";
    $stmtUpdateRoom = mysqli_prepare($conn, $sqlUpdateRoom);
    mysqli_stmt_bind_param($stmtUpdateRoom, "ssiii", $navn, $beskrivelse, $etasje, $rtid, $roomId);
    mysqli_stmt_execute($stmtUpdateRoom);
}


/** Creates new room and returns rom object
 *
 * @param $navn
 * @param $beskrivelse
 * @param $etasje
 * @param $rtid
 * @return rom|null
 */
function createRoom($navn, $beskrivelse, $etasje, $rtid, ) {
    global $conn;
    
    // Injecter nytt rom i rom tabellen i databasen
    $sqlInsertRoom = "INSERT INTO rom (navn, beskrivelse, etasje, rtid) VALUES (?, ?, ?, ?)";
    
    $stmtInsertRoom = mysqli_prepare($conn, $sqlInsertRoom);
    mysqli_stmt_bind_param($stmtInsertRoom, "ssii", $navn, $beskrivelse, $etasje, $rtid);
    
    
    if (mysqli_stmt_execute($stmtInsertRoom)) {
        // Henter ID'en til det nyskapte rommet
        $newRoomId = mysqli_insert_id($conn);
        
        // Returnerer det nye rom objektet 
        return new rom($newRoomId, $navn, $beskrivelse, $etasje, $rtid, null);
    } else {
        
        return null; 
    }
}


/** Delete room by ID and return boolean
 * @param $roomId
 * @return bool
 */
function deleteRoom($roomId) {
    global $conn;
    // Spørring for å slette et rom med bruk av ID'en
    $sqlDeleteRoom = "DELETE FROM rom WHERE id = ?";
    
    $stmtDeleteRoom = mysqli_prepare($conn, $sqlDeleteRoom);
    mysqli_stmt_bind_param($stmtDeleteRoom, "i", $roomId);

    if (mysqli_stmt_execute($stmtDeleteRoom)) {
        return true; // Returnerer true hvis slettingen var suksessfull
    } else {
        return false; // Returnerer false hvis slettingen feilet
    }
}

//Forbedringer:
//Tester til funksjonene.