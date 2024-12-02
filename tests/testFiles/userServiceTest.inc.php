<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../setup/dbTestProjectSQL.inc.php'; 
require_once __DIR__ . '/../setup/initTest.inc.php';
require_once __DIR__ . '/../../service/userService.inc.php';

/** 
 * Unit tests for the userService
 * 
 * This class tests various functionalities provided by the `userService`, 
 * including creating, fetching, updating, and deleting user records in the database.
 */
class userServiceTest extends TestCase
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
     * Tests the `createUser` function for creating a new user.
     *
     * @return void
     */
    public function testCreateUser()
    {
        $epost = "testuser@example.com";
        $passord = "password123";
        $navn = "Test";
        $etternavn = "User";
        $adresse = "Test Street 123";
        $mobilnummer = "43299323";
        $kjonn = "M";

        // Create a new user
        $result = createUser($epost, $passord, $navn, $etternavn, $adresse, $mobilnummer, $kjonn);
        $this->assertTrue($result, "createUser should return true when the user is successfully created.");

        // Fetch the created user
        $user = getUserById(mysqli_insert_id($this->conn));
        $this->assertNotNull($user, "User should exist in the database.");
        $this->assertEquals($epost, $user['epost'], "User's email should match.");
        $this->assertEquals($navn, $user['navn'], "User's name should match.");
    }

    /** 
     * Tests the `getAllUsers` function to fetch all users.
     *
     * @return void
     */
    public function testGetAllUsers()
    {
        // Fetch all users
        $users = getAllUsers();

        // Ensure the result is an array and not empty
        $this->assertIsArray($users, "getAllUsers should return an array.");
        $this->assertNotEmpty($users, "getAllUsers should not return an empty array.");
    }

    /** 
     * Tests the `getUserById` function to fetch a user by ID.
     *
     * @return void
     */
    public function testGetUserById()
    {
        // Fetch user with ID 1
        $user = getUserById(1);

        // Ensure the user exists and the ID matches
        $this->assertNotNull($user, "getUserById should return a user.");
        $this->assertEquals(1, $user['id'], "User ID should match the queried ID.");
    }

    /** 
     * Tests the `getUserById` function for a non-existent user ID.
     *
     * @return void
     */
    public function testGetUserByIdNotFound()
    {
        // Attempt to fetch a non-existent user
        $user = getUserById(9999);

        // Ensure the result is null
        $this->assertNull($user, "getUserById should return null for a non-existing user ID.");
    }

    /** 
     * Tests the `updateUser` function for updating user details.
     *
     * @return void
     */
    public function testUpdateUser()
    {
        $epost = "updateduser@example.com";
        $passord = "newpassword123";
        $navn = "Updated";
        $etternavn = "User";
        $adresse = "Updated Street 456";
        $mobilnummer = "97654321";
        $kjonn = "M";
        $rolleId ="1";

        // Update user details
        updateUser(1, $epost, $passord, $rolleId, $navn, $etternavn, $adresse, $mobilnummer, $kjonn);

        // Fetch the updated user
        $user = getUserById(1);

        // Verify the updates
        $this->assertEquals($epost, $user['epost'], "User's email should be updated.");
        $this->assertEquals($navn, $user['navn'], "User's name should be updated.");
        $this->assertEquals($adresse, $user['adresse'], "User's address should be updated.");
    }

    /** 
     * Tests the `deleteUser` function for deleting a user by ID.
     *
     * @return void
     */
    public function testDeleteUser()
    {
        $userId = 1;

        // Ensure the user exists before deletion
        $user = getUserById($userId);
        $this->assertNotNull($user, "User should exist before deletion.");

        // Delete the user
        $result = deleteUser($userId);
        $this->assertTrue($result, "deleteUser should return true when the user is successfully deleted.");

        // Verify the user no longer exists
        $deletedUser = getUserById($userId);
        $this->assertNull($deletedUser, "Deleted user should no longer exist.");
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
