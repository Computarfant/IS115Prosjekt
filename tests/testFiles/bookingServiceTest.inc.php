<?php


use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../setup/configTestdb.inc.php';
require_once __DIR__ . '/../../service/bookingService.inc.php';
require_once __DIR__ . '/../../models/rom.php';
require_once __DIR__ . '/../../models/romType.php';
require_once __DIR__ . '/../setup/dbTestProjectSQL.inc.php';
require_once __DIR__ . '/../setup/initTest.inc.php';

class bookingServiceTest extends TestCase
{   
    protected $conn;

    public function setUp(): void
{
 
    $this->conn = database();

 
    $this->conn->query("TRUNCATE TABLE Booking");
    $this->conn->query("TRUNCATE TABLE Profil");
    $this->conn->query("TRUNCATE TABLE Bruker");
    $this->conn->query("TRUNCATE TABLE Rom");
    $this->conn->query("TRUNCATE TABLE RomType");
    $this->conn->query("TRUNCATE TABLE BrukerRolle");

   
    seedDatabase($this->conn);
}

    

    public function testIsRoomAvailable()
    {
        global $conn;
        $roomId = 1;
        $startDate = '2023-01-01';
        $endDate = '2023-01-07';
        
        $this->assertFalse(isRoomAvailable($roomId, $startDate, $endDate));

        $startDate = '2023-01-10';
        $endDate = '2023-01-15';
        $this->assertTrue(isRoomAvailable($roomId, $startDate, $endDate));
    }


    public function testProcessBooking()
    {

        global $conn;

        $brukerId = 1;
        $roomId = 3;
        $numAdults = 2;
        $numChildren = 1;
        $startDate = '2023-02-01';
        $endDate = '2023-02-05';
        
        $result = processBooking($brukerId, $roomId, $numAdults, $numChildren, $startDate, $endDate);
        $this->assertTrue($result);

        $booking = getBookingForUserAndRoom($brukerId, $roomId, $startDate, $endDate);
        $this->assertEquals(3000, $booking['totalPris']);
    }


    public function testCancelBooking()
    {

        global $conn;

        $bookingId = 1; 
        $result = cancelBooking($bookingId);
        $this->assertTrue($result);

        
        $booking = getBookingById($bookingId);
        $this->assertEquals('canceled', $booking['status']);
    }


    public function testGetRoomById()
    {
        global $conn;

        $roomId = 3; 
        $room = getRoomById($roomId);
        $this->assertInstanceOf(rom::class, $room);
        $this->assertEquals($roomId, $room->getId());


        $this->assertInstanceOf(romType::class, $room->getRomType());
        $this->assertEquals(1250, $room->getRomType()->getPris());
    }


    }

    ?>