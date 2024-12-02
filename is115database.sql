-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2024 at 11:48 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `is115database`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `bid` int(11) NOT NULL,
  `rid` int(11) NOT NULL,
  `antallVoksne` int(11) NOT NULL,
  `antallBarn` int(11) DEFAULT 0,
  `startPeriode` date NOT NULL,
  `sluttPeriode` date NOT NULL,
  `totalPris` decimal(10,2) NOT NULL,
  `status` enum('confirmed','canceled','pending') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bruker`
--

CREATE TABLE `bruker` (
  `id` int(11) NOT NULL,
  `epost` varchar(100) NOT NULL,
  `passord` varchar(500) NOT NULL,
  `opprettet` datetime DEFAULT current_timestamp(),
  `rolleId` int(11) DEFAULT 1,
  `locked_until` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bruker`
--

INSERT INTO `bruker` (`id`, `epost`, `passord`, `opprettet`, `rolleId`, `locked_until`) VALUES
(1, 'admin@gmail.com', '$2y$10$6TTKXmZSVsIdh28F2u/uneMYd.w56Ox/IitPo0lA8ZFBdPCYxMNP.', '0000-00-00 00:00:00', 2, '0000-00-00 00:00:00'),
(2, 'bruker@gmail.com', '$2y$10$y9AkYa4POBdEZDh0gHhSM.mv0L15q9YJt/seh2B09wt76.ch6BR3G', '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `brukerrolle`
--

CREATE TABLE `brukerrolle` (
  `id` int(11) NOT NULL,
  `navn` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brukerrolle`
--

INSERT INTO `brukerrolle` (`id`, `navn`) VALUES
(1, 'gjest'),
(2, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `loginattempts`
--

CREATE TABLE `loginattempts` (
  `id` int(11) NOT NULL,
  `brukerId` int(11) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profil`
--

CREATE TABLE `profil` (
  `brukerId` int(11) NOT NULL,
  `navn` varchar(50) NOT NULL,
  `etternavn` varchar(50) NOT NULL,
  `adresse` varchar(100) DEFAULT NULL,
  `mobilNummer` varchar(15) DEFAULT NULL,
  `kjonn` enum('M','F','O') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profil`
--

INSERT INTO `profil` (`brukerId`, `navn`, `etternavn`, `adresse`, `mobilNummer`, `kjonn`) VALUES
(1, 'Admin', 'Administrator', 'ikke Oppgitt', '000000000', 'O'),
(2, 'Bruker', 'Brukeren', 'ikke Oppgitt', '000000000', 'O');

-- --------------------------------------------------------

--
-- Table structure for table `rom`
--

CREATE TABLE `rom` (
  `id` int(11) NOT NULL,
  `navn` varchar(50) NOT NULL,
  `etasje` int(11) NOT NULL,
  `beskrivelse` varchar(255) NOT NULL,
  `rtid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rom`
--

INSERT INTO `rom` (`id`, `navn`, `etasje`, `beskrivelse`, `rtid`) VALUES
(1, '101', 1, 'standard room, first on the right', 1),
(2, '102', 1, 'standard room, first on the left', 1),
(3, '103', 1, 'double room, second on the right', 2),
(4, '104', 1, 'double room, second on the left', 2),
(5, '105', 1, 'suite for wealthy people', 3),
(6, '201', 2, 'standard room, first on the right', 1),
(7, '202', 2, 'standard room, first on the left', 1),
(8, '203', 2, 'double room, second on the right', 2),
(9, '204', 2, 'double room, second on the left', 2),
(10, '205', 2, 'suite for wealthy people', 3),
(11, '301', 3, 'standard room, first on the right', 1),
(12, '302', 3, 'standard room, first on the left', 1),
(13, '303', 3, 'double room, second on the right', 2),
(14, '304', 3, 'double room, second on the left', 2),
(15, '305', 3, 'suite for wealthy people', 3),
(16, '401', 4, 'standard room, first on the right', 1),
(17, '402', 4, 'standard room, first on the left', 1),
(18, '403', 4, 'double room, second on the right', 2),
(19, '404', 4, 'double room, second on the left', 2),
(20, '405', 4, 'suite for wealthy people', 3),
(21, '501', 5, 'standard room, first on the right', 1),
(22, '502', 5, 'standard room, first on the left', 1),
(23, '503', 5, 'double room, second on the right', 2),
(24, '504', 5, 'double room, second on the left', 2),
(25, '505', 5, 'suite for wealthy people', 3);

-- --------------------------------------------------------

--
-- Table structure for table `romtype`
--

CREATE TABLE `romtype` (
  `id` int(11) NOT NULL,
  `navn` varchar(50) NOT NULL,
  `beskrivelse` varchar(255) DEFAULT ' ',
  `pris` decimal(10,2) DEFAULT NULL,
  `maxGjester` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `romtype`
--

INSERT INTO `romtype` (`id`, `navn`, `beskrivelse`, `pris`, `maxGjester`) VALUES
(1, 'Standard', 'One room with doublebed and a bathroom.', 750.00, 2),
(2, 'Double', 'Two bedrooms and a living room for with a sleeping couch two one bathroom.', 1250.00, 5),
(3, 'Suite', 'Luxurious room with separate living and sleeping areas 3 bedrooms.', 1750.00, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bid` (`bid`),
  ADD KEY `rid` (`rid`);

--
-- Indexes for table `bruker`
--
ALTER TABLE `bruker`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `epost` (`epost`),
  ADD KEY `rolleId` (`rolleId`);

--
-- Indexes for table `brukerrolle`
--
ALTER TABLE `brukerrolle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loginattempts`
--
ALTER TABLE `loginattempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brukerId` (`brukerId`);

--
-- Indexes for table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`brukerId`);

--
-- Indexes for table `rom`
--
ALTER TABLE `rom`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rtid` (`rtid`);

--
-- Indexes for table `romtype`
--
ALTER TABLE `romtype`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bruker`
--
ALTER TABLE `bruker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `brukerrolle`
--
ALTER TABLE `brukerrolle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `loginattempts`
--
ALTER TABLE `loginattempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rom`
--
ALTER TABLE `rom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `romtype`
--
ALTER TABLE `romtype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`bid`) REFERENCES `bruker` (`id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`rid`) REFERENCES `rom` (`id`);

--
-- Constraints for table `bruker`
--
ALTER TABLE `bruker`
  ADD CONSTRAINT `bruker_ibfk_1` FOREIGN KEY (`rolleId`) REFERENCES `brukerrolle` (`id`);

--
-- Constraints for table `loginattempts`
--
ALTER TABLE `loginattempts`
  ADD CONSTRAINT `loginattempts_ibfk_1` FOREIGN KEY (`brukerId`) REFERENCES `bruker` (`id`);

--
-- Constraints for table `profil`
--
ALTER TABLE `profil`
  ADD CONSTRAINT `profil_ibfk_1` FOREIGN KEY (`brukerId`) REFERENCES `bruker` (`id`);

--
-- Constraints for table `rom`
--
ALTER TABLE `rom`
  ADD CONSTRAINT `rom_ibfk_1` FOREIGN KEY (`rtid`) REFERENCES `romtype` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
