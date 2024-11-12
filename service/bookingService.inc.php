<?php
require '../inc/init.inc.php';
require '../models/romType.php';
require '../models/rom.php';

function searchAvailableRooms($innsjekking, $utsjekking): array
{
    $db = database();

    $sql = $db->prepare("
        SELECT r.*, rt.navn AS romTypeNavn, rt.beskrivelse AS romTypeBeskrivelse, 
               rt.pris AS romTypePris, rt.maxGjester AS romTypeMaxGjester
        FROM Rom AS r
        INNER JOIN romType rt ON r.rtid = rt.id
        WHERE r.id NOT IN (
            SELECT rid FROM booking
            WHERE startPeriode <= ? AND sluttPeriode >= ?
        )
    ");

    $sql->bind_param("ss", $innsjekking, $utsjekking);
    $sql->execute();

    $rows = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    
    // Map each row to a room instance, with nested room type information
    $availableRooms = [];
    foreach ($rows as $row) {
        $romType = new romType(
            $row['rtid'], 
            $row['romTypeNavn'], 
            $row['romTypeBeskrivelse'], 
            $row['romTypePris'], 
            $row['romTypeMaxGjester'], 
            null
        );

        $availableRooms[] = new rom(
            $row['id'],
            $row['navn'],
            $row['beskrivelse'],
            $row['etasje'],
            $row['rtid'],
            $romType
        );
    }

    return $availableRooms;
}


function isRoomAvailable($roomId, $startDate, $endDate) {
    global $conn;

    // Prepare a query to find overlapping bookings for the same room
    $stmt = $conn->prepare("
        SELECT * FROM Booking 
        WHERE rid = ? 
        AND status = 'confirmed' 
        AND (
            (startPeriode < ? AND sluttPeriode > ?)   -- Booking starts before and ends after requested period
            OR (startPeriode >= ? AND startPeriode < ?)  -- Booking starts within requested period
            OR (sluttPeriode > ? AND sluttPeriode <= ?)  -- Booking ends within requested period
        )
    ");
    $stmt->bind_param("issssss", $roomId, $endDate, $startDate, $startDate, $endDate, $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows === 0;
}

function processBooking($brukerId, $roomId, $numAdults, $numChildren, $startDate, $endDate) {
    global $conn;

    if (!isRoomAvailable($roomId, $startDate, $endDate)) {
        return false;
    }

    $room = getRoomById($roomId);
    if (!$room || !$room->romType) {
        return false;
    }
    // Calculate total price using the nested romType's price
    $days = (strtotime($endDate) - strtotime($startDate)) / 86400;
    $totalPrice = $room->romType->pris * $days;

    $stmt = $conn->prepare("
        INSERT INTO Booking (bid, rid, antallVoksne, antallBarn, startPeriode, sluttPeriode, totalPris, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, 'confirmed')
    ");
    $stmt->bind_param("iiiissd", $brukerId, $roomId, $numAdults, $numChildren, $startDate, $endDate, $totalPrice);
    $stmt->execute();

    return $stmt->affected_rows > 0;
}

//Denne kan bli brukt på din profil side for å avbestille bookinger/ordre oversikt
function cancelBooking($bookingId) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE Booking SET status = 'canceled' WHERE id = :bookingId");
    $stmt->execute([':bookingId' => $bookingId]);

    return $stmt->rowCount() > 0;
}

function getRoomById($roomId) {
    global $conn;

    // Join `Rom` and `RomType` tables to retrieve all details in one query
    $sql = "
        SELECT r.*, rt.navn AS romTypeNavn, rt.beskrivelse AS romTypeBeskrivelse, rt.pris AS romTypePris, 
               rt.maxGjester AS romTypeMaxGjester, rt.id AS romTypeId
        FROM rom AS r
        INNER JOIN RomType AS rt ON r.rtid = rt.id
        WHERE r.id = ?
    ";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $roomId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Instantiate `romType` with data from the joined query
        $romType = new romType(
            $row['romTypeId'],
            $row['romTypeNavn'],
            $row['romTypeBeskrivelse'],
            $row['romTypePris'],
            $row['romTypeMaxGjester'],
            null // ledigeRom is null as it might need a separate calculation
        );

        // Instantiate `rom` and assign the `romType` instance
        return new rom(
            $row['id'],
            $row['navn'],
            $row['beskrivelse'],
            $row['etasje'],
            $row['rtid'],
            $romType
        );
    }

    return null;
}


function getRoomTypeById($romTypeId) {
    global $conn;
    $sql = "SELECT * FROM RomType WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $romTypeId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt); 
    
    if ($row = mysqli_fetch_assoc($result)) {
        // Returnerer en instans av romType-klassen

        //Debugging
        //echo "<p>Debug: Room Type ID = $romTypeId</p>";
        //echo "<p>Debug: Room Type Name = " . htmlspecialchars($row['navn']) . "</p>";

        return new romType($row['id'], $row['navn'], $row['beskrivelse'], $row['pris'], $row['maxGjester'], null);
    }
    return null; 
}

