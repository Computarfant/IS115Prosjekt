<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../setup/configTestdb.inc.php'; 
require_once __DIR__ . '/../setup/dbTestProjectSQL.inc.php'; 
require_once __DIR__ . '/../setup/initTest.inc.php';
require_once __DIR__ . '/../../service/userService.inc.php';

class userServiceTest extends TestCase
{
    protected $conn;

    public function setUp(): void
{
 
    $this->conn = databaseTest();

    $this->conn->query("SET FOREIGN_KEY_CHECKS = 0");
  
    $this->conn->query("TRUNCATE TABLE Booking");
    $this->conn->query("TRUNCATE TABLE Profil");
    $this->conn->query("TRUNCATE TABLE Bruker");
    $this->conn->query("TRUNCATE TABLE Rom");
    $this->conn->query("TRUNCATE TABLE RomType");
    $this->conn->query("TRUNCATE TABLE BrukerRolle");

   
    seedDatabase($this->conn);
}
    public function testCreateUser()
    {
       
        $epost = "testuser@example.com";
        $passord = "password123";
        $navn = "Test";
        $etternavn = "User";
        $adresse = "Test Street 123";
        $mobilnummer = "43299323";
        $kjonn = "M";

        $result = createUser($epost, $passord, $navn, $etternavn, $adresse, $mobilnummer, $kjonn);
        $this->assertTrue($result, "createUser should return true when the user is successfully created.");

        $user = getUserById(mysqli_insert_id($this -> conn));
        echo "Actual email: " . $user['epost'] . "\n";  // Debugging line
        $this->assertNotNull($user, "User should exist in the database.");
        $this->assertEquals($epost, $user['epost'], "User's email should match.");
        $this->assertEquals($navn, $user['navn'], "User's name should match.");
    }

    public function testGetAllUsers()
    {
        $users = getAllUsers();
        $this->assertIsArray($users, "getAllUsers should return an array.");
        $this->assertNotEmpty($users, "getAllUsers should not return an empty array.");
    }

    public function testGetUserById()
    {
      
        $user = getUserById(1);
        $this->assertNotNull($user, "getUserById should return a user.");
        $this->assertEquals(1, $user['id'], "User ID should match the queried ID.");
    }

    public function testGetUserByIdNotFound()
    {
       
        $user = getUserById(9999);
        $this->assertNull($user, "getUserById should return null for a non-existing user ID.");
    }

    public function testUpdateUser()
    {
       
        $epost = "updateduser@example.com";
        $passord = "newpassword123";
        $navn = "Updated";
        $etternavn = "User";
        $adresse = "Updated Street 456";
        $mobilnummer = "97654321";
        $kjonn = "M";

        updateUser(1, $epost, $passord, $navn, $etternavn, $adresse, $mobilnummer, $kjonn);

       
        $user = getUserById(1);
        $this->assertEquals($epost, $user['epost'], "User's email should be updated.");
        $this->assertEquals($navn, $user['navn'], "User's name should be updated.");
        $this->assertEquals($adresse, $user['adresse'], "User's address should be updated.");
    }

    public function testDeleteUser()
    {
        $userId = 1;

       
        $user = getUserById($userId);
        $this->assertNotNull($user, "User should exist before deletion.");

        $result = deleteUser($userId);
        $this->assertTrue($result, "deleteUser should return true when the user is successfully deleted.");

      
        $deletedUser = getUserById($userId);
        $this->assertNull($deletedUser, "Deleted user should no longer exist.");
    }

    public static function tearDownAfterClass(): void
    {
        if (self::$conn) {
            self::$conn->close();
        }
    }
}
