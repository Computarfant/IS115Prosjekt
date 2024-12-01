<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../setup/configTestdb.inc.php';
require_once __DIR__ . '/../../service/roomAdmin.inc.php';
require_once __DIR__ . '/../../models/rom.php';
require_once __DIR__ . '/../../models/romType.php';
require_once __DIR__ . '/../setup/dbTestProjectSQL.inc.php';
require_once __DIR__ . '/../setup/initTest.inc.php';
class roomAdminTest extends TestCase
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

    public function testGetAllRooms()
    {
        $rooms = getAllRooms();
        $this->assertIsArray($rooms, "getAllRooms should return an array.");
        $this->assertNotEmpty($rooms, "getAllRooms should not return an empty array.");
        $this->assertInstanceOf(rom::class, $rooms[0], "Each element in the array should be an instance of the rom class.");
    }

    public function testGetRoomById()
    {
        $room = getRoomById(1); 
        $this->assertInstanceOf(rom::class, $room, "getRoomById should return an instance of the rom class.");
        $this->assertEquals(1, $room->getId(), "Room ID should match the queried ID.");
    }

    public function testGetRoomByIdNotFound()
    {
        $room = getRoomById(9999); 
        $this->assertNull($room, "getRoomById should return null for a non-existing room ID.");
    }

    public function testGetRoomTypeById()
    {
        $roomType = getRoomTypeById(1);
        $this->assertInstanceOf(romType::class, $roomType, "getRoomTypeById should return an instance of the romType class.");
        $this->assertEquals(1, $roomType->getId(), "RoomType ID should match the queried ID.");
    }

    public function testGetAllRomTypes()
    {
        $roomTypes = getAllRomTypes();
        $this->assertIsArray($roomTypes, "getAllRomTypes should return an array.");
        $this->assertNotEmpty($roomTypes, "getAllRomTypes should not return an empty array.");
        $this->assertInstanceOf(romType::class, $roomTypes[0], "Each element in the array should be an instance of the romType class.");
    }

    public function testDeleteRoom()
    {
        $roomId = 1;
        $this->assertTrue(deleteRoom($roomId), "deleteRoom should return true on successful deletion.");
        $deletedRoom = getRoomById($roomId);
        $this->assertNull($deletedRoom, "Deleted room should no longer exist.");
    }

    public static function tearDownAfterClass(): void
    {
        if (self::$conn) {
            self::$conn->close();
        }
    }
}
