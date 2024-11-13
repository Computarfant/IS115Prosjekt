<?php
function dbSetupSQL(): array {
    $queries = array();

    $queries['createRolle'] = "
        CREATE TABLE IF NOT EXISTS BrukerRolle (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            navn VARCHAR(100) NOT NULL
        );
    ";
    $queries['createBruker'] = "
        CREATE TABLE IF NOT EXISTS Bruker (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            epost VARCHAR(100) NOT NULL UNIQUE,
            passord VARCHAR(500) NOT NULL,  
            opprettet DATETIME DEFAULT CURRENT_TIMESTAMP,
            rolleId INT DEFAULT 1,
            FOREIGN KEY (rolleId) REFERENCES BrukerRolle(id)
        );
    ";
    $queries['createProfil'] = "
        CREATE TABLE IF NOT EXISTS Profil (
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
        CREATE TABLE IF NOT EXISTS RomType (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            navn VARCHAR(50) NOT NULL,
            beskrivelse VARCHAR(255) DEFAULT ' ',
            pris DECIMAL(10, 2),
            maxGjester INT NOT NULL
        );
    ";
    $queries['createRom'] = "
        CREATE TABLE IF NOT EXISTS Rom (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            navn VARCHAR(50) NOT NULL,
            etasje INT NOT NULL,
            beskrivelse VARCHAR(255) NOT NULL,
            rtid INT NOT NULL,
            FOREIGN KEY (rtid) REFERENCES RomType(id)
        );
    ";
    $queries['createBooking'] = "
        CREATE TABLE IF NOT EXISTS Booking (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            bid INT NOT NULL,
            rid INT NOT NULL,
            antallVoksne INT NOT NULL,
            antallBarn INT DEFAULT 0,
            startPeriode DATE NOT NULL,
            sluttPeriode DATE NOT NULL,
            totalPris DECIMAL(10, 2) NOT NULL,
            status ENUM('confirmed', 'canceled', 'pending') DEFAULT 'pending',
            FOREIGN KEY (bid) REFERENCES Bruker(id),
            FOREIGN KEY (rid) REFERENCES Rom(id)
        );
    ";
    $queries['insertRomTypes'] = "
        INSERT INTO RomType (navn, beskrivelse, pris, maxGjester) VALUES 
        ('Standard', 'One room with doublebed and a bathroom.', 750, 2),
        ('Double', 'Two bedrooms and a living room for with a sleeping couch two one bathroom.', 1250, 5),
        ('Suite', 'Luxurious room with separate living and sleeping areas 3 bedrooms.', 1750, 6)
        ON DUPLICATE KEY UPDATE pris=VALUES(pris);
    ";
    $queries['insertRom'] = "
        INSERT INTO Rom (navn, etasje, beskrivelse, rtid) VALUES 
        ('101', 1, 'standard fattigmans rom', 1),
        ('102', 1, 'standard au', 1),
        ('103', 1, 'double 1', 2),
        ('104', 1, 'double 2', 2),
        ('105', 1, 'suite rik gutt', 3),
        ('201', 2, 'standard fattigmans rom', 1),
        ('202', 2, 'standard au', 1),
        ('203', 2, 'double 1', 2),
        ('204', 2, 'double 2', 2),
        ('205', 2, 'suite rik gutt', 3),
        ('301', 3, 'standard fattigmans rom', 1),
        ('302', 3, 'standard au', 1),
        ('303', 3, 'double 1', 2),
        ('304', 3, 'double 2', 2),
        ('305', 3, 'suite rik gutt', 3),
        ('401', 4, 'standard fattigmans rom', 1),
        ('402', 4, 'standard au', 1),
        ('403', 4, 'double 1', 2),
        ('404', 4, 'double 2', 2),
        ('405', 4, 'suite rik gutt', 3),
        ('501', 5, 'standard fattigmans rom', 1),
        ('502', 5, 'standard au', 1),
        ('503', 5, 'double 1', 2),
        ('504', 5, 'double 2', 2),
        ('505', 5, 'suite rik gutt', 3)
        ";

    $queries['insertRoller'] = "
        INSERT INTO BrukerRolle (navn) VALUES ('gjest'), ('admin')
        ON DUPLICATE KEY UPDATE navn=VALUES(navn);
    ";


    $queries['insertUsers'] = "
    INSERT INTO Bruker (epost, passord, rolleId) VALUES 
    ('guest1@example.com', 'hashedpassword1', 1),
    ('guest2@example.com', 'hashedpassword2', 1),
    ('admin1@example.com', 'hashedpassword3', 2),
    ('admin2@example.com', 'hashedpassword4', 2)
    ON DUPLICATE KEY UPDATE passord=VALUES(passord);
    ";

    $queries['insertProfiles'] = "
        INSERT INTO Profil (brukerId, navn, etternavn, adresse, mobilNummer, kjonn) VALUES 
        (1, 'John', 'Doe', 'Street 123', '12345678', 'M'),
        (2, 'Jane', 'Doe', 'Street 456', '87654321', 'F'),
        (3, 'Admin', 'User1', NULL, NULL, 'O'),
        (4, 'Admin', 'User2', 'Street 789', NULL, NULL)
        ON DUPLICATE KEY UPDATE navn=VALUES(navn);
    ";

    $queries['insertBookings'] = "
        INSERT INTO Booking (bid, rid, antallVoksne, antallBarn, startPeriode, sluttPeriode, totalPris, status) VALUES 
        (1, 1, 2, 0, '2025-01-01', '2025-01-07', 5250, 'confirmed'), 
        (2, 2, 1, 1, '2025-01-05', '2025-01-10', 6250, 'canceled'), 
        (1, 3, 2, 0, '2025-02-01', '2025-02-05', 3000, 'pending'),
        (2, 4, 3, 2, '2025-02-10', '2025-02-15', 8750, 'confirmed')
        ON DUPLICATE KEY UPDATE totalPris=VALUES(totalPris);
    ";


    return $queries;
}




?>
