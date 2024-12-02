<?php
require_once __DIR__ . '/../models/romType.php';
require_once __DIR__ . '/../models/rom.php';
require_once __DIR__ . '/../inc/config.inc.php';
//^Her var det inc/inc før en test endring


/** Retrieves all rooms and returns an array of room objects
 *
 * @return array
 */
function getAllRooms() {
    global $conn;

    // SQL query to fetch room information
    $sql = "SELECT id, navn, beskrivelse, etasje, rtId 
            FROM Rom"; 

    $result = mysqli_query($conn, $sql);
    
    $rooms = []; // Array to hold room objects

    // Fetch the results and create room objects
    while ($row = mysqli_fetch_assoc($result)) {
        // Create a room object for the data retrieved
        $rooms[] = new rom($row['id'], $row['navn'], $row['beskrivelse'], $row['etasje'], $row['rtId'], null); // Setting romType to null for now
    }

    return $rooms; // Return the array of room objects
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
        // Fetch roomType data
        $romType = getRoomTypeById($row['rtid']); 
        // Return room object with roomType data
        return new rom($row['id'], $row['navn'], $row['beskrivelse'], $row['etasje'], $row['rtid'], $romType);
    }
    // Return null if roomType does not exist
    return null; 
}

/** Fetches roomType by romType.id
 *
 * @param $rtid         // romTypeId
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
        // Returns an instance of the romType class
        // Debugging
        // echo "<p>Debug: Room Type ID = $romTypeId</p>";
        // echo "<p>Debug: Room Type Name = " . htmlspecialchars($row['navn']) . "</p>";
        return new romType($row['id'], $row['navn'], $row['beskrivelse'], $row['pris'], $row['maxGjester'], null);
    }
    // Return null if roomType does not exist
    return null; 
}

/**
 * Fetches all room types from the database and returns them as an array of romType objects.
 *
 * @return array An array of `romType` objects, each representing a room type.
 *               If there are no room types, it returns an empty array.
 */
function getAllRoomTypes() {
    global $conn;
    $sql = "SELECT * FROM RomType";
    $result = mysqli_query($conn, $sql);
    $romTypes = [];
    while ($row = mysqli_fetch_assoc($result)) {
        // Create and add an instance of romType for each row
        $romTypes[] = new romType($row['id'], $row['navn'], $row['beskrivelse'], $row['pris'], $row['maxGjester'], null);
    }
    return $romTypes;
}



/** Updates a specific room and its details
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


/** Creates a new room and returns a room object
 *
 * @param $navn
 * @param $beskrivelse
 * @param $etasje
 * @param $rtid
 * @return rom|null
 */
function createRoom($navn, $beskrivelse, $etasje, $rtid, ) {
    global $conn;
    
    // Insert new room into the room table in the database
    $sqlInsertRoom = "INSERT INTO rom (navn, beskrivelse, etasje, rtid) VALUES (?, ?, ?, ?)";
    
    $stmtInsertRoom = mysqli_prepare($conn, $sqlInsertRoom);
    mysqli_stmt_bind_param($stmtInsertRoom, "ssii", $navn, $beskrivelse, $etasje, $rtid);
    
    
    if (mysqli_stmt_execute($stmtInsertRoom)) {
        // Fetch the ID of the newly created room
        $newRoomId = mysqli_insert_id($conn);
        
        // Return the new room object
        return new rom($newRoomId, $navn, $beskrivelse, $etasje, $rtid, null);
    } else {
        
        return null; 
    }
}


/** Deletes a room by ID and returns a boolean
 * @param $roomId
 * @return bool
 */
function deleteRoom($roomId) {
    global $conn;
    // Query to delete a room using its ID
    $sqlDeleteRoom = "DELETE FROM rom WHERE id = ?";
    
    $stmtDeleteRoom = mysqli_prepare($conn, $sqlDeleteRoom);
    mysqli_stmt_bind_param($stmtDeleteRoom, "i", $roomId);

    if (mysqli_stmt_execute($stmtDeleteRoom)) {
        return true; // Returns true if the deletion was successful
    } else {
        return false; // Returns false if the deletion failed
    }
}

// Improvements:
// Tests for the functions.
