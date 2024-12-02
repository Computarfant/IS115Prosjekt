<?php

use PHPUnit\Framework\TestCase;

// Required files for configuration, model definitions, and service functions
require_once __DIR__ . '/../../models/rom.php';
require_once __DIR__ . '/../../models/romType.php';
require_once __DIR__ . '/../setup/dbTestProjectSQL.inc.php';
require_once __DIR__ . '/../setup/initTest.inc.php';
require_once __DIR__ . '/../../service/bookingService.inc.php';

/**
 * Class bookingServiceTest
 * 
 * This class contains unit tests for the Booking Service functionality.
 * It uses PHPUnit to validate the methods related to room availability, 
 * booking processing, cancellation, and fetching room details.
 */
class bookingServiceTest extends TestCase
{
    protected $conn;

    /**
     * Sets up the database for testing by initializing a test database connection
     * and seeding it with test data.
     * 
     * @return void
     */
    public function setUp(): void
    {
        $this->conn = databaseTest(); // Initializes the test database connection.

        // Disable foreign key checks and truncate tables for a clean test state
        $this->conn->query("SET FOREIGN_KEY_CHECKS = 0");
        $this->conn->query("TRUNCATE TABLE Booking");
        $this->conn->query("TRUNCATE TABLE Profil");
        $this->conn->query("TRUNCATE TABLE Bruker");
        $this->conn->query("TRUNCATE TABLE Rom");
        $this->conn->query("TRUNCATE TABLE RomType");
        $this->conn->query("TRUNCATE TABLE BrukerRolle");

        // Seed the database with predefined test data
        seedDatabase($this->conn);
    }

    /**
     * Tests the `isRoomAvailable` function to check if a room is available
     * for a given date range.
     * 
     * @return void
     */
    public function testIsRoomAvailable()
    {
        global $conn;

        $roomId = 1;
        $startDate = '2025-01-01';
        $endDate = '2025-01-07';

        // Assert that the room is unavailable for an overlapping date range
        $this->assertFalse(isRoomAvailable($roomId, $startDate, $endDate));

        $startDate = '2025-01-10';
        $endDate = '2025-01-15';

        // Assert that the room is available for a non-overlapping date range
        $this->assertTrue(isRoomAvailable($roomId, $startDate, $endDate));
    }

    /**
     * Tests the `processBooking` function to ensure booking is processed
     * correctly and calculates the total price.
     * 
     * @return void
     */
    public function testProcessBooking()
    {
        global $conn;

        $brukerId = 1;
        $roomId = 3;
        $numAdults = 2;
        $numChildren = 1;
        $startDate = '2025-02-01';
        $endDate = '2025-02-05';

        // Assert that the booking is successfully processed
        $result = processBooking($brukerId, $roomId, $numAdults, $numChildren, $startDate, $endDate);
        $this->assertTrue($result);

        // Validate the booking details and total price
        $booking = getBookingForUserAndRoom($brukerId, $roomId, $startDate, $endDate);
        $this->assertEquals(3000, $booking['totalPris']);
    }

    /**
     * Tests the `cancelBooking` function to ensure bookings can be canceled.
     * 
     * @return void
     */
    public function testCancelBooking()
    {
        global $conn;

        $bookingId = 1;

        // Assert that the booking is successfully canceled
        $result = cancelBooking($bookingId);
        $this->assertTrue($result);

        // Validate the booking status after cancellation
        $booking = getBookingById($bookingId);
        $this->assertEquals('canceled', $booking['status']);
    }

    /**
     * Tests the `getRoomById` function to fetch room details and verify the 
     * associated room type and its price.
     * 
     * @return void
     */
    public function testGetRoomById()
    {
        global $conn;

        $roomId = 3;

        // Fetch the room and validate its type and attributes
        $room = getRoomById($roomId);
        $this->assertInstanceOf(rom::class, $room);
        $this->assertEquals($roomId, $room->getId());

        // Validate the associated room type
        $this->assertInstanceOf(romType::class, $room->getRomType());
        $this->assertEquals(1250, $room->getRomType()->getPris());
    }
}
?>
