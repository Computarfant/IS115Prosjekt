<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../models/rom.php';
require_once __DIR__ . '/../../models/romType.php';
require_once __DIR__ . '/../setup/dbTestProjectSQL.inc.php';
require_once __DIR__ . '/../setup/initTest.inc.php';
require_once __DIR__ . '/../../service/roomAdmin.inc.php';

/** 
 * Unit tests for the roomAdmin service
 * 
 * This class tests various functionalities in the roomAdmin service, including 
 * fetching room and room type details, deleting rooms, and ensuring the integrity 
 * of the database after operations.
 */
class roomAdminTest extends TestCase
{
    protected $conn;

    /**
     * Sets up the database connection and resets tables before each test.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->conn = databaseTest();
        
        // Disable foreign key checks to allow truncation of tables
        $this->conn->query("SET FOREIGN_KEY_CHECKS = 0");

        // Truncate the relevant tables to ensure a clean state for each test
        $this->conn->query("TRUNCATE TABLE Booking");
        $this->conn->query("TRUNCATE TABLE Profil");
        $this->conn->query("TRUNCATE TABLE Bruker");
        $this->conn->query("TRUNCATE TABLE Rom");
        $this->conn->query("TRUNCATE TABLE RomType");
        $this->conn->query("TRUNCATE TABLE BrukerRolle");
        
        // Seed the database with test data
        seedDatabase($this->conn);
    }

    /** 
     * Tests the `getAllRooms` function that retrieves all rooms from the database.
     * 
     * @return void
     */
    public function testGetAllRooms()
    {
        // Fetch all rooms
        $rooms = getAllRooms();
        
        // Ensure the result is an array and not empty
        $this->assertIsArray($rooms, "getAllRooms should return an array.");
        $this->assertNotEmpty($rooms, "getAllRooms should not return an empty array.");
        
        // Ensure each element is an instance of the `rom` class
        $this->assertInstanceOf(rom::class, $rooms[0], "Each element in the array should be an instance of the rom class.");
    }

    /** 
     * Tests the `getRoomById` function to fetch a room by its ID.
     * 
     * @return void
     */
    public function testGetRoomById()
    {
        // Fetch room with ID 1
        $room = getRoomById(1);
        
        // Ensure the result is an instance of `rom`
        $this->assertInstanceOf(rom::class, $room, "getRoomById should return an instance of the rom class.");
        
        // Ensure the room ID matches the queried ID
        $this->assertEquals(1, $room->getId(), "Room ID should match the queried ID.");
    }

    /** 
     * Tests the `getRoomById` function with a non-existent room ID to ensure it returns `null`.
     * 
     * @return void
     */
    public function testGetRoomByIdNotFound()
    {
        // Attempt to fetch a non-existent room with ID 9999
        $room = getRoomById(9999);
        
        // Ensure the result is null, indicating no room was found
        $this->assertNull($room, "getRoomById should return null for a non-existing room ID.");
    }

    /** 
     * Tests the `getRoomTypeById` function to fetch a room type by its ID.
     * 
     * @return void
     */
    public function testGetRoomTypeById()
    {
        // Fetch room type with ID 1
        $roomType = getRoomTypeById(1);
        
        // Ensure the result is an instance of `romType`
        $this->assertInstanceOf(romType::class, $roomType, "getRoomTypeById should return an instance of the romType class.");
        
        // Ensure the room type ID matches the queried ID
        $this->assertEquals(1, $roomType->getId(), "RoomType ID should match the queried ID.");
    }

    /** 
     * Tests the `getAllRoomTypes` function to fetch all room types.
     * 
     * @return void
     */
    public function testGetAllRomTypes()
    {
        // Fetch all room types
        $roomTypes = getAllRoomTypes();
        
        // Ensure the result is an array and not empty
        $this->assertIsArray($roomTypes, "getAllRomTypes should return an array.");
        $this->assertNotEmpty($roomTypes, "getAllRomTypes should not return an empty array.");
        
        // Ensure each element is an instance of the `romType` class
        $this->assertInstanceOf(romType::class, $roomTypes[0], "Each element in the array should be an instance of the romType class.");
    }

    /** 
     * Tests the `deleteRoom` function to delete a room by its ID.
     * 
     * @return void
     */
    public function testDeleteRoom()
    {
        // Room ID to delete
        $roomId = 1;
        
        // Ensure the room is deleted successfully
        $this->assertTrue(deleteRoom($roomId), "deleteRoom should return true on successful deletion.");
        
        // Ensure the room no longer exists
        $deletedRoom = getRoomById($roomId);
        $this->assertNull($deletedRoom, "Deleted room should no longer exist.");
    }

    /** 
     * Cleans up resources after all tests have been executed.
     *
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        if (self::$conn) {
            self::$conn->close();  // Close the database connection
        }
    }
}
