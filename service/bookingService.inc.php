<?php
require_once __DIR__ . '/../inc/init.inc.php';
require_once __DIR__ . '/../models/romType.php';
require_once __DIR__ . '/../models/rom.php';
require_once __DIR__ . '/../models/booking.php';
require 'loggingService.inc.php';

/** Searches the database for all rooms available for the period of time.
 *
 * @param $innsjekking      //Value for start date
 * @param $utsjekking       //Value for end date
 * @return array            //Returns array of all rooms available
 */
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


/** Checks if room is available and returns boolean value
 *
 * @param $roomId
 * @param $startDate
 * @param $endDate
 * @return bool
 */
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

/** Processes booking and returns boolean
 *
 * @param $brukerId
 * @param $roomId
 * @param $numAdults
 * @param $numChildren
 * @param $startDate
 * @param $endDate
 * @return bool
 */
function processBooking($brukerId, $roomId, $numAdults, $numChildren, $startDate, $endDate) {
    global $conn;

    $room = getRoomById($roomId);
    if (!$room || !$room->romType) {
        return false;
    }

    // Validate if the total number of guests exceeds the max allowed for this room type
    $totalGuests = $numAdults + $numChildren;
    if ($totalGuests > $room->romType->maxGjester) {
        return false; 
    }

    // Check room availability for the specified dates
    if (!isRoomAvailable($roomId, $startDate, $endDate)) {
        return false;
    }

    // Calculate total price based on the room type's price and duration of stay
    $days = (strtotime($endDate) - strtotime($startDate)) / 86400;
    $totalPrice = $room->romType->pris * $days;

    // Proceed with inserting the booking into the database
    $stmt = $conn->prepare("
        INSERT INTO Booking (bid, rid, antallVoksne, antallBarn, startPeriode, sluttPeriode, totalPris, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, 'confirmed')
    ");
    $stmt->bind_param("iiiissd", $brukerId, $roomId, $numAdults, $numChildren, $startDate, $endDate, $totalPrice);
    $stmt->execute();

    return $stmt->affected_rows > 0;
}


/** Cancels booking
 *
 * @param $bookingId
 * @return bool
 */
function cancelBooking($bookingId) {
    global $conn;

    $stmt = $conn->prepare("UPDATE Booking SET status = 'canceled' WHERE id = ?");
    $stmt->bind_param("i", $bookingId);  // Bind the bookingId parameter to the prepared statement
    $stmt->execute();

    // For mysqli, you can use `affected_rows` to check how many rows were affected by the query
    return $stmt->affected_rows > 0;  // Return true if at least one row was updated
}



/** Fetches room and type using roomId
 *
 * @param $roomId
 * @return rom|null
 */
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

function getBookingByUser($brukerId): array
{
    $db = database(); // Assume this initializes a `mysqli` connection

    $sql = $db->prepare("
        SELECT 
            b.id AS bookingId,
            b.bid,
            b.rid,
            b.antallVoksne,
            b.antallBarn,
            b.startPeriode,
            b.sluttPeriode,
            b.totalPris,
            b.status,
            r.id AS romId,
            r.navn AS romNavn,
            r.beskrivelse AS romBeskrivelse,
            r.etasje,
            r.rtid
        FROM 
            Booking b
        LEFT JOIN 
            Rom r ON b.rid = r.id
        WHERE 
            b.bid = ?
        ORDER BY 
            b.startPeriode DESC;
    ");

    $sql->bind_param("i", $brukerId); // Bind brukerId
    $sql->execute();

    $rows = $sql->get_result()->fetch_all(MYSQLI_ASSOC);


    // Map each row to a booking instance with nested room information
    $yourBooking = [];
    foreach ($rows as $row) {
        $booking = new booking(
            $row['bookingId'],
            $row['bid'],
            $row['rid'],
            $row['antallVoksne'],
            $row['antallBarn'],
            $row['startPeriode'],
            $row['sluttPeriode'],
            $row['totalPris'],
            $row['status']
        );

        $booking->room = new rom(
            $row['romId'],
            $row['romNavn'],
            $row['romBeskrivelse'],
            $row['etasje'],
            $row['rtid'],
            null,
        );
        $yourBooking[] = $booking;
    }
    return $yourBooking;
}


/** Retrieves booking for a specific user and room in the given period
 *
 * @param $userId
 * @param $roomId
 * @param $startDate
 * @param $endDate
 * @return array|null       // Returns the booking record or null if not found
 */
function getBookingForUserAndRoom($userId, $roomId, $startDate, $endDate) {
    global $conn;

    $sql = "
        SELECT * FROM Booking 
        WHERE bid = ? 
        AND rid = ? 
        AND startPeriode <= ? 
        AND sluttPeriode >= ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $userId, $roomId, $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        return $row; // Returning the booking record as an associative array
    }
    
    return null; // Return null if no booking is found
}


/** Fetches booking by its ID
 *
 * @param $bookingId
 * @return array|null       // Returns the booking record or null if not found
 */
function getBookingById($bookingId) {
    global $conn;

    $sql = "SELECT * FROM Booking WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookingId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        return $row; // Return the booking as an associative array
    }
    
    return null; // Return null if no booking is found
}

