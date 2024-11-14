<?php


use PHPUnit\Framework\TestCase;

require_once "../../service/bookingService.inc.php";
require_once "../../models/rom.php";
require_once "../../models/romType.php";


class bookingTest extends TestCase
{

public function testIsRoomAvailable()
{
    $roomId = 1;
    $startDate = '2023-01-01';
    $endDate = '2023-01-07';
    
    // Room should not be available due to an existing booking
    $this->assertFalse(isRoomAvailable($roomId, $startDate, $endDate));

    // Check availability for a different, non-overlapping period
    $startDate = '2023-01-10';
    $endDate = '2023-01-15';
    $this->assertTrue(isRoomAvailable($roomId, $startDate, $endDate));
}


public function testProcessBooking()
{
    $brukerId = 1;
    $roomId = 3;
    $numAdults = 2;
    $numChildren = 1;
    $startDate = '2023-02-01';
    $endDate = '2023-02-05';
    
    $result = processBooking($brukerId, $roomId, $numAdults, $numChildren, $startDate, $endDate);
    $this->assertTrue($result);

    // Check that booking is stored with correct total price
    $booking = getBookingForUserAndRoom($brukerId, $roomId, $startDate, $endDate);
    $this->assertEquals(3000, $booking['totalPris']);
}


public function testCancelBooking()
{
    $bookingId = 1; // Assume booking ID 1 exists and is confirmed
    $result = cancelBooking($bookingId);
    $this->assertTrue($result);

    // Verify the booking status is now 'canceled'
    $booking = getBookingById($bookingId);
    $this->assertEquals('canceled', $booking['status']);
}


public function testGetRoomById()
{
    $roomId = 3; // Assume room ID 3 exists
    $room = getRoomById($roomId);
    $this->assertInstanceOf(rom::class, $room);
    $this->assertEquals($roomId, $room->getId());

    // Check the nested room type details
    $this->assertInstanceOf(romType::class, $room->getRomType());
    $this->assertEquals(1250, $room->getRomType()->getPris());
}


public function testGetRoomTypeById()
{
    $romTypeId = 1; // Assume room type ID 1 exists
    $romType = getRoomTypeById($romTypeId);
    $this->assertInstanceOf(romType::class, $romType);
    $this->assertEquals('Standard', $romType->getNavn());

    // Test for a non-existent ID
    $romType = getRoomTypeById(9999);
    $this->assertNull($romType);
}

}

?>