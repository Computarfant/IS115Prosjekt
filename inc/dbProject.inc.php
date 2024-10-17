<?php

function dbSetupSQL($email = "default@gmail.com", $pass = "password"): array {
    $queries = array();

    $queries['createBruker'] = "
        CREATE OR REPLACE TABLE Bruker (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            epost VARCHAR(100) NOT NULL UNIQUE,
            passord VARCHAR(500) NOT NULL,
            opprettet DATETIME DEFAULT CURRENT_TIMESTAMP,
            ckey VARCHAR(100) NOT NULL DEFAULT ' ',
            ctime VARCHAR(100) NOT NULL DEFAULT ' '
        );
    ";

    $queries['createRolle'] = "
        CREATE OR REPLACE TABLE BrukerRolle (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            navn Varchar(100) NOT NULL
        );
    ";

    $queries['createProfil'] = "
        CREATE OR REPLACE TABLE Profil (
            brukerId INT PRIMARY KEY,
            navn VARCHAR(50) NOT NULL,
            etternavn VARCHAR(50) NOT NULL,
            adresse VARCHAR(100),
            mobilNummer VARCHAR(15),
            kjonn ENUM('M', 'F', 'O') NOT NULL,
            FOREIGN KEY (brukerId) REFERENCES Bruker(id)
        );
    ";

    $queries['createRomType'] = "
        CREATE OR REPLACE TABLE RomType (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            navn VARCHAR(50) NOT NULL,
            beskrivelse VARCHAR(255) DEFAULT ' ',
            pris DECIMAL(10, 2),
            maxGjester INT NOT NULL
        );
    ";

    $queries['createRom'] = "
        CREATE OR REPLACE TABLE Rom (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            etasje INT NOT NULL,
            romTypeId INT NOT NULL,
            FOREIGN KEY (romTypeId) REFERENCES RomType(id)
        );
    ";

    $queries['createBooking'] = "
        CREATE OR REPLACE TABLE Booking (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            brukerId INT NOT NULL,
            romId INT NOT NULL,
            antallVoksne INT NOT NULL,
            antallBarn INT DEFAULT 0,
            startPeriode DATE NOT NULL,
            sluttPeriode DATE NOT NULL,
            totalPris DECIMAL(10, 2) NOT NULL,
            FOREIGN KEY (brukerId) REFERENCES Bruker(id),
            FOREIGN KEY (romId) REFERENCES Rom(id)
        );
    ";


    /*$queries['createRolleRegister'] = "
        CREATE OR REPLACE TABLE Rolle_register (
            rolleId INT NOT NULL,
            brukerId INT NOT NULL,
            PRIMARY KEY (rolleId, brukerId),
            FOREIGN KEY (rolleId) REFERENCES Rolle(rolleId),
            FOREIGN KEY (brukerId) REFERENCES Bruker(brukerId)
        );
    ";*/

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
        INSERT INTO RomType (navn, beskrivelse, pris, maxGjester) VALUES 
        ('Standard', 'One room with doublebed and a bathroom.', 750, 2),
        ('Double', 'Two bedrooms and a living room for with a sleeping couch two one bathroom.', 1250, 5),
        ('Suite', 'Luxurious room with separate living and sleeping areas 3 bedrooms.', 1750, 6);
    ";

    $queries['insertRoom'] = "
        INSERT INTO Rom (etasje, romTypeId) VALUES 
        (1, 1),
        (1, 1),
        (1, 1),
        (1, 2),
        (1, 3),
        (2, 1),
        (2, 1),
        (2, 2),
        (2, 2),
        (2, 3),
        (3, 1),
        (3, 1),
        (3, 2),
        (3, 2),
        (3, 3),
        (4, 1),
        (4, 2),
        (4, 2),
        (4, 3),
        (4, 3),
        (5, 2),
        (5, 2),
        (5, 3),
        (5, 3),
        (5, 3)
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
        INSERT INTO BrukerRolle (navn) VALUES ('gjest'), ('bruker'), ('admin');
    ";

    /*$queries['insertRolleRegister'] = "
        INSERT INTO Rolle_register (rolleId, brukerId) VALUES 
        (1, 1), gjest
        (2, 3),  admin
    ";*/

    return $queries;
}
