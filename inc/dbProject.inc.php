<?php

function dbSetupSQL(): array {
    $queries = array();

    $queries['createRolle'] = "
        CREATE OR REPLACE TABLE BrukerRolle (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            navn Varchar(100) NOT NULL
        );
    ";
    $queries['createBruker'] = "
        CREATE OR REPLACE TABLE Bruker (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            epost VARCHAR(100) NOT NULL UNIQUE,
            passord VARCHAR(500) NOT NULL,  
            opprettet DATETIME DEFAULT CURRENT_TIMESTAMP,
            rolleId INT DEFAULT 1,
            locked_until DATETIME DEFAULT NULL,
            FOREIGN KEY (rolleId) REFERENCES BrukerRolle(id)
        );
    ";

    $queries['createProfil'] = "
        CREATE OR REPLACE TABLE Profil (
            brukerId INT PRIMARY KEY,
            navn VARCHAR(50) NOT NULL,
            etternavn VARCHAR(50) NOT NULL,
            adresse VARCHAR(100) DEFAULT NULL,
            mobilNummer VARCHAR(15) DEFAULT NULL,   
            kjonn ENUM('M', 'F', 'O') DEFAULT NULL,
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
            navn VARCHAR(50) NOT NULL,
            etasje INT NOT NULL,
            beskrivelse VARCHAR(255) NOT NULL,
            rtid INT NOT NULL,
            FOREIGN KEY (rtid) REFERENCES RomType(id)
        );
    ";

    $queries['createBooking'] = "
        CREATE OR REPLACE TABLE Booking (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            bid INT NOT NULL,
            rid INT NOT NULL,
            antallVoksne INT NOT NULL,
            antallBarn INT DEFAULT 0,
            startPeriode DATE NOT NULL,
            sluttPeriode DATE NOT NULL,
            totalPris DECIMAL(10, 2) NOT NULL,
            status ENUM('confirmed', 'canceled', 'pending') DEFAULT 'pending',  -- Added status column
            FOREIGN KEY (bid) REFERENCES Bruker(id),
            FOREIGN KEY (rid) REFERENCES Rom(id)
        );
    ";

    $queries['creatingLoginAttempts'] = "
        CREATE OR REPLACE TABLE LoginAttempts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            brukerId INT,
            timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (brukerId) REFERENCES Bruker(id)
        );
    ";

    /*$queries['createRolleRegister'] = "
    Fremtidig tabell for å kunne gi brukere flere roller samtidig
        CREATE OR REPLACE TABLE Rolle_register (
            rolleId INT NOT NULL,
            brukerId INT NOT NULL,
            PRIMARY KEY (rolleId, brukerId),
            FOREIGN KEY (rolleId) REFERENCES Rolle(rolleId),
            FOREIGN KEY (brukerId) REFERENCES Bruker(brukerId)
        );
    ";*/

    /*$queries['createLoyaltyProgram'] = "
    Fremtidig tabell for å kunne lagre loyalitet data
        CREATE OR REPLACE TABLE LoyaltyProgram (
            loyaltyId INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            nivåNavn VARCHAR(50) NOT NULL,
            beskrivelse VARCHAR(255) DEFAULT ' ',
            poengKrav INT NOT NULL DEFAULT 0
        );
    ";*/

    /*$queries['createBetaling'] = "
    Fremtidig tabell for bettalinglagring
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

    $queries['insertRomTypes'] = "
        INSERT INTO RomType (navn, beskrivelse, pris, maxGjester) VALUES 
        ('Standard', 'One room with doublebed and a bathroom.', 750, 2),
        ('Double', 'Two bedrooms and a living room for with a sleeping couch two one bathroom.', 1250, 5),
        ('Suite', 'Luxurious room with separate living and sleeping areas 3 bedrooms.', 1750, 6);
    ";

    $queries['insertRom'] = "
    INSERT INTO Rom (navn, etasje, beskrivelse, rtid) VALUES 
        ('101', 1, 'standard room, first on the right', 1),
        ('102', 1, 'standard room, first on the left', 1),
        ('103', 1, 'double room, second on the right', 2),
        ('104', 1, 'double room, second on the left', 2),
        ('105', 1, 'suite for wealthy people', 3),
        ('201', 2, 'standard room, first on the right', 1),
        ('202', 2, 'standard room, first on the left', 1),
        ('203', 2, 'double room, second on the right', 2),
        ('204', 2, 'double room, second on the left', 2),
        ('205', 2, 'suite for wealthy people', 3),
        ('301', 3, 'standard room, first on the right', 1),
        ('302', 3, 'standard room, first on the left', 1),
        ('303', 3, 'double room, second on the right', 2),
        ('304', 3, 'double room, second on the left', 2),
        ('305', 3, 'suite for wealthy people', 3),
        ('401', 4, 'standard room, first on the right', 1),
        ('402', 4, 'standard room, first on the left', 1),
        ('403', 4, 'double room, second on the right', 2),
        ('404', 4, 'double room, second on the left', 2),
        ('405', 4, 'suite for wealthy people', 3),
        ('501', 5, 'standard room, first on the right', 1),
        ('502', 5, 'standard room, first on the left', 1),
        ('503', 5, 'double room, second on the right', 2),
        ('504', 5, 'double room, second on the left', 2),
        ('505', 5, 'suite for wealthy people', 3)
    ";


    $queries['insertRoller'] = "
        INSERT INTO BrukerRolle (navn) VALUES ('gjest'), ('admin');
    ";
    $password = password_hash('Admin123', PASSWORD_DEFAULT);
    $queries['insertBruker'] = "
        INSERT INTO Bruker (epost, passord, opprettet, rolleId, locked_until) VALUES ('admin@gmail.com', '$password', '', '2', '');
    ";
    $queries['insertProfil'] = "
        INSERT INTO Profil (brukerId, navn, etternavn, adresse, mobilNummer, kjonn) VALUES ('1', 'Admin', 'Administrator', '', '', '');
    ";

    return $queries;
}