<?php

include "../inc/config.inc.php";

// Lager ny bruker med tilknyttet profil
function createUser($epost, $passord, $navn, $etternavn, $adresse, $mobilnummer, $kjonn)
{
    global $conn;

    mysqli_begin_transaction($conn);

    try {
        // Insert i Bruker tabellen
        $sqlBruker = "INSERT INTO Bruker (epost, passord, rolleId) VALUES (?, ?, '1')";
        $stmtBruker = mysqli_prepare($conn, $sqlBruker);
        mysqli_stmt_bind_param($stmtBruker, "ss", $epost, $passord);
        mysqli_stmt_execute($stmtBruker);
        
        $brukerId = mysqli_insert_id($conn);

        // Insert i Profil tabellen
        $sqlProfil = "INSERT INTO Profil (brukerId, navn, etternavn, adresse, mobilNummer, kjonn) VALUES (?, ?, ?, ?, ?, ?)";
        $stmtProfil = mysqli_prepare($conn, $sqlProfil);
        mysqli_stmt_bind_param($stmtProfil, "isssss", $brukerId, $navn, $etternavn, $adresse, $mobilnummer, $kjonn);
        mysqli_stmt_execute($stmtProfil);

        mysqli_commit($conn);
        
        return true;
    } catch (Exception $e) {
        // Rollback transaction hvis noe går galt.
        mysqli_rollback($conn);
        return false;
    }
}


function getAllUsers() {
    global $conn;
    $sql = "SELECT b.id, b.epost, p.navn, p.etternavn, p.adresse, p.mobilNummer, p.kjonn 
            FROM Bruker b LEFT JOIN Profil p ON b.id = p.brukerId";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}


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


function updateUser($brukerId, $epost, $passord, $navn, $etternavn, $adresse, $mobilNummer, $kjonn) {
    global $conn;

    // Oppdaterer Bruker tabellen (email and password)
    $sqlUpdateBruker = "UPDATE Bruker SET epost = ?, passord = ? WHERE id = ?";
    $stmtUpdateBruker = mysqli_prepare($conn, $sqlUpdateBruker);
    mysqli_stmt_bind_param($stmtUpdateBruker, "ssi", $epost, $passord, $brukerId);
    mysqli_stmt_execute($stmtUpdateBruker);

    // Oppdaterer Profil tabellen (name, last name, address, mobile number, gender)
    $sqlUpdateProfil = "UPDATE Profil SET navn = ?, etternavn = ?, adresse = ?, mobilNummer = ?, kjonn = ? WHERE brukerId = ?";
    $stmtUpdateProfil = mysqli_prepare($conn, $sqlUpdateProfil);
    mysqli_stmt_bind_param($stmtUpdateProfil, "sssssi", $navn, $etternavn, $adresse, $mobilNummer, $kjonn, $brukerId);
    mysqli_stmt_execute($stmtUpdateProfil);
}


function deleteUser($brukerId) {
    global $conn;

    mysqli_begin_transaction($conn);

    try {
        // Sletter fra Profil tabellen først, for å unngå foreign key constraints
        $sqlProfil = "DELETE FROM Profil WHERE brukerId = ?";
        $stmtProfil = mysqli_prepare($conn, $sqlProfil);
        mysqli_stmt_bind_param($stmtProfil, "i", $brukerId);
        mysqli_stmt_execute($stmtProfil);

        // Sletter fra Bruker tabellen
        $sqlBruker = "DELETE FROM Bruker WHERE id = ?";
        $stmtBruker = mysqli_prepare($conn, $sqlBruker);
        mysqli_stmt_bind_param($stmtBruker, "i", $brukerId);
        mysqli_stmt_execute($stmtBruker);

        mysqli_commit($conn);
        return true;
    } catch (Exception $e) {
        // Rollback transaction hvis noe går galt.
        mysqli_rollback($conn);
        return false;
    }
}


//Forbedringer:
//Tester til funksjonene.




