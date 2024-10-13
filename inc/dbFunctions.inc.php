<?php

include "config.inc.php"; 

// Lager ny bruker med tilknyttet profil
function createUser($epost, $passord, $navn, $etternavn, $adresse, $mobilnummer, $kjønn) {
    global $conn;

    mysqli_begin_transaction($conn);

    try {
        // Insert i Bruker tabellen
        $sqlBruker = "INSERT INTO Bruker (epost, passord, ckey, ctime) VALUES (?, ?, '', '')";
        $stmtBruker = mysqli_prepare($conn, $sqlBruker);
        mysqli_stmt_bind_param($stmtBruker, "ss", $epost, $passord);
        mysqli_stmt_execute($stmtBruker);
        
        $brukerId = mysqli_insert_id($conn);

        // Insert i Profil tabellen
        $sqlProfil = "INSERT INTO Profil (brukerId, navn, etternavn, adresse, mobilNummer, kjønn) VALUES (?, ?, ?, ?, ?, ?)";
        $stmtProfil = mysqli_prepare($conn, $sqlProfil);
        mysqli_stmt_bind_param($stmtProfil, "isssss", $brukerId, $navn, $etternavn, $adresse, $mobilnummer, $kjønn);
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
    $sql = "SELECT b.brukerId, b.epost, p.navn, p.etternavn, p.adresse, p.mobilNummer, p.kjønn 
            FROM Bruker b JOIN Profil p ON b.brukerId = p.brukerId";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}




function getUserById($brukerId) {
    global $conn;

    $sql = "SELECT b.brukerId, b.epost, p.navn, p.etternavn, p.adresse, p.mobilNummer, p.kjønn 
            FROM Bruker b 
            JOIN Profil p ON b.brukerId = p.brukerId
            WHERE b.brukerId = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $brukerId);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    
    return mysqli_fetch_assoc($result);
}

function updateUser($brukerId, $epost, $passord, $navn, $etternavn, $adresse, $mobilNummer, $kjønn) {
    global $conn;

    // Oppdaterer Bruker tabellen (email and password)
    $sqlUpdateBruker = "UPDATE Bruker SET epost = ?, passord = ? WHERE brukerId = ?";
    $stmtUpdateBruker = mysqli_prepare($conn, $sqlUpdateBruker);
    mysqli_stmt_bind_param($stmtUpdateBruker, "ssi", $epost, $passord, $brukerId);
    mysqli_stmt_execute($stmtUpdateBruker);

    // Oppdaterer Profil tabellen (name, last name, address, mobile number, gender)
    $sqlUpdateProfil = "UPDATE Profil SET navn = ?, etternavn = ?, adresse = ?, mobilNummer = ?, kjønn = ? WHERE brukerId = ?";
    $stmtUpdateProfil = mysqli_prepare($conn, $sqlUpdateProfil);
    mysqli_stmt_bind_param($stmtUpdateProfil, "sssssi", $navn, $etternavn, $adresse, $mobilNummer, $kjønn, $brukerId);
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
        $sqlBruker = "DELETE FROM Bruker WHERE brukerId = ?";
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



?>


