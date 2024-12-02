<?php

require_once __DIR__ . "/../inc/config.inc.php";

// Creates a new user with an associated profile
/**
 * @param $epost
 * @param $passord
 * @param $navn
 * @param $etternavn
 * @param $adresse
 * @param $mobilnummer
 * @param $kjonn
 * @return bool         // Returns True if the user was created
 */
function createUser($epost, $passord, $navn, $etternavn, $adresse, $mobilnummer, $kjonn)
{
    global $conn;

    mysqli_begin_transaction($conn);

    try {
        // Insert into the User table
        $sqlBruker = "INSERT INTO Bruker (epost, passord, rolleId) VALUES (?, ?, '1')";
        $stmtBruker = mysqli_prepare($conn, $sqlBruker);
        mysqli_stmt_bind_param($stmtBruker, "ss", $epost, $passord);
        mysqli_stmt_execute($stmtBruker);
        
        $brukerId = mysqli_insert_id($conn);

        // Insert into the Profile table
        $sqlProfil = "INSERT INTO Profil (brukerId, navn, etternavn, adresse, mobilNummer, kjonn) VALUES (?, ?, ?, ?, ?, ?)";
        $stmtProfil = mysqli_prepare($conn, $sqlProfil);
        mysqli_stmt_bind_param($stmtProfil, "isssss", $brukerId, $navn, $etternavn, $adresse, $mobilnummer, $kjonn);
        mysqli_stmt_execute($stmtProfil);

        mysqli_commit($conn);
        
        return true;
    } catch (Exception $e) {
        // Rollback transaction if something goes wrong
        mysqli_rollback($conn);
        return false;
    }
}


/** Retrieves all users
 *
 * @return array        Returns all users in an array
 */
function getAllUsers() {
    global $conn;
    $sql = "SELECT b.id, b.epost, p.navn, p.etternavn, p.adresse, p.mobilNummer, p.kjonn 
            FROM Bruker b LEFT JOIN Profil p ON b.id = p.brukerId";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}


/** Retrieves user by the selected userId
 *
 * @param $brukerId
 * @return array|false|null
 */
function getUserById($brukerId) {
    global $conn;

    $sql = "SELECT b.id, b.epost, p.navn, p.etternavn, p.adresse, p.mobilNummer, p.kjonn 
            FROM Bruker b 
            LEFT JOIN Profil p ON b.id = p.brukerId
            WHERE b.id = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $brukerId);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    
    return mysqli_fetch_assoc($result);
}


/** Updates the user and the corresponding profile
 *
 * @param $brukerId
 * @param $epost
 * @param $passord
 * @param $navn
 * @param $etternavn
 * @param $adresse
 * @param $mobilNummer
 * @param $kjonn
 * @return void
 */
function updateUser($brukerId, $epost, $passord, $navn, $etternavn, $adresse, $mobilNummer, $kjonn) {
    global $conn;

    // Updates the User table (email and password)
    $sqlUpdateBruker = "UPDATE Bruker SET epost = ?, passord = ? WHERE id = ?";
    $stmtUpdateBruker = mysqli_prepare($conn, $sqlUpdateBruker);
    mysqli_stmt_bind_param($stmtUpdateBruker, "ssi", $epost, $passord, $brukerId);
    mysqli_stmt_execute($stmtUpdateBruker);

    // Updates the Profile table (name, last name, address, mobile number, gender)
    $sqlUpdateProfil = "UPDATE Profil SET navn = ?, etternavn = ?, adresse = ?, mobilNummer = ?, kjonn = ? WHERE brukerId = ?";
    $stmtUpdateProfil = mysqli_prepare($conn, $sqlUpdateProfil);
    mysqli_stmt_bind_param($stmtUpdateProfil, "sssssi", $navn, $etternavn, $adresse, $mobilNummer, $kjonn, $brukerId);
    mysqli_stmt_execute($stmtUpdateProfil);
}


/** Deletes from the user table by userId
 * @param $brukerId         // Id of the user you wish to delete
 * @return bool             // Returns true if the user was deleted
 */
function deleteUser($brukerId) {
    global $conn;

    mysqli_begin_transaction($conn);

    try {
        // Deletes from the Profile table first to avoid foreign key constraints
        $sqlProfil = "DELETE FROM Profil WHERE brukerId = ?";
        $stmtProfil = mysqli_prepare($conn, $sqlProfil);
        mysqli_stmt_bind_param($stmtProfil, "i", $brukerId);
        mysqli_stmt_execute($stmtProfil);

        // Deletes from the User table
        $sqlBruker = "DELETE FROM Bruker WHERE id = ?";
        $stmtBruker = mysqli_prepare($conn, $sqlBruker);
        mysqli_stmt_bind_param($stmtBruker, "i", $brukerId);
        mysqli_stmt_execute($stmtBruker);

        mysqli_commit($conn);
        return true;
    } catch (Exception $e) {
        // Rollback transaction if something goes wrong
        mysqli_rollback($conn);
        return false;
    }
}
