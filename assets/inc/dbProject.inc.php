<?php

function dbSetupSQL($email = "default@gmail.com", $pass = "password"): array {
    $queries = array();

    $queries['createBruker'] = "
        CREATE OR REPLACE TABLE Bruker (
            brukerId INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            epost VARCHAR(100) NOT NULL UNIQUE,
            passord VARCHAR(500) NOT NULL,
            opprettet DATETIME DEFAULT CURRENT_TIMESTAMP,
            ckey VARCHAR(100) NOT NULL DEFAULT ' ',
            ctime VARCHAR(100) NOT NULL DEFAULT ' '
        );
    ";

    $queries['createProfil'] = "
        CREATE OR REPLACE TABLE Profil (
            brukerId INT PRIMARY KEY,
            navn VARCHAR(50) NOT NULL,
            etternavn VARCHAR(50) NOT NULL,
            adresse VARCHAR(100),
            mobilNummer VARCHAR(15),
            kjønn ENUM('M', 'F', 'O') NOT NULL,
            FOREIGN KEY (brukerId) REFERENCES Bruker(brukerId)
        );
    ";

    $queries['createRomType'] = "
        CREATE OR REPLACE TABLE RomType (
            typeId INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            typeNavn VARCHAR(50) NOT NULL,
            beskrivelse VARCHAR(255) DEFAULT ' '
        );
    ";

    $queries['createRom'] = "
        CREATE OR REPLACE TABLE Rom (
            romId INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            etasje INT NOT NULL,
            typeId INT NOT NULL,
            døgnPris DECIMAL(10, 2),
            antallSenger INT NOT NULL,
            tilgjengelig BOOLEAN NOT NULL DEFAULT TRUE,
            FOREIGN KEY (typeId) REFERENCES RomType(typeId)
        );
    ";

    $queries['createBooking'] = "
        CREATE OR REPLACE TABLE Booking (
            bookingId INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            brukerId INT NOT NULL,
            romId INT NOT NULL,
            antallVoksne INT NOT NULL,
            antallBarn INT DEFAULT 0,
            startPeriode DATE NOT NULL,
            sluttPeriode DATE NOT NULL,
            totalPris DECIMAL(10, 2) NOT NULL,
            FOREIGN KEY (brukerId) REFERENCES Bruker(brukerId),
            FOREIGN KEY (romId) REFERENCES Rom(romId)
        );
    ";

    $queries['createRolle'] = "
        CREATE OR REPLACE TABLE Rolle (
            rolleId INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            rolleNavn ENUM('gjest', 'bruker', 'administrativ') NOT NULL
        );
    ";

    $queries['createRolleRegister'] = "
        CREATE OR REPLACE TABLE Rolle_register (
            rolleId INT NOT NULL,
            brukerId INT NOT NULL,
            PRIMARY KEY (rolleId, brukerId),
            FOREIGN KEY (rolleId) REFERENCES Rolle(rolleId),
            FOREIGN KEY (brukerId) REFERENCES Bruker(brukerId)
        );
    ";

    /*$queries['createLoyaltyProgram'] = "
        CREATE OR REPLACE TABLE LoyaltyProgram (
            loyaltyId INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            nivåNavn VARCHAR(50) NOT NULL,
            beskrivelse VARCHAR(255) DEFAULT ' ',
            poengKrav INT NOT NULL DEFAULT 0
        );
    ";*/

    /*$queries['createBetaling'] = "
        CREATE OR REPLACE TABLE betaling (
            betId INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            bookingId INT NOT NULL,
            betMethod ENUM('CREDIT_CARD', 'DEBIT_CARD', 'PAYPAL', 'CASH') NOT NULL,
            amount DECIMAL(10, 2) NOT NULL,
            betDate DATETIME DEFAULT CURRENT_TIMESTAMP,
            transaksjonId VARCHAR(100) DEFAULT NULL,
            FOREIGN KEY (bookingId) REFERENCES Booking(bookingId)
        );
    ";*/

    $queries['insertRoomTypes'] = "
        INSERT INTO RomType (typeNavn, beskrivelse) VALUES 
        ('Single Room', 'A room assigned to one person.'),
        ('Double Room', 'A room assigned to two people.'),
        ('Suite', 'A larger room with separate living and sleeping areas.');
    ";

    /*$queries['insertLoyaltyPrograms'] = "
        INSERT INTO LoyaltyProgram (nivåNavn, beskrivelse, poengkrav) VALUES
        ('Silver', 'Basic loyalty program for frequent customers.', 100),
        ('Gold', 'Advanced loyalty program with added perks.', 500),
        ('Platinum', 'Top-tier loyalty program for VIPs.', 1000);
    ";*/

    $password = password_hash($pass, PASSWORD_DEFAULT);
    $queries['insertBruker'] = "
        INSERT INTO Bruker (epost, passord, opprettet, ckey, ctime) VALUES ('$email', '$password', '', '', '');
    ";

    $queries['insertRoller'] = "
        INSERT INTO Rolle (rolleNavn) VALUES ('gjest'), ('bruker'), ('administrativ');
    ";

    /*$queries['insertRolleRegister'] = "
        INSERT INTO Rolle_register (rolleId, brukerId) VALUES 
        (1, 1), gjest
        (2, 3),  admin
    ";*/

    return $queries;
}
