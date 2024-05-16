-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2024 at 04:37 PM
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
-- Database: `bas`
--

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE `artikel` (
  `artId` int(11) NOT NULL,
  `artOmschrijving` varchar(12) NOT NULL,
  `artInkoop` decimal(5,2) DEFAULT NULL,
  `artVerkoop` decimal(5,2) DEFAULT NULL,
  `artVoorraad` int(11) NOT NULL,
  `artMinVoorraad` int(11) NOT NULL,
  `artMaxVoorraad` int(11) NOT NULL,
  `artLocatie` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`artId`, `artOmschrijving`, `artInkoop`, `artVerkoop`, `artVoorraad`, `artMinVoorraad`, `artMaxVoorraad`, `artLocatie`) VALUES
(1, 'Appel', 0.50, 0.75, 200, 15, 200, 4),
(2, 'Banaan', 0.40, 0.60, 180, 20, 180, 5),
(3, 'Perzik', 0.60, 0.90, 150, 10, 150, 6),
(4, 'Ananas', 1.00, 1.50, 120, 25, 120, 7),
(5, 'Kiwi', 0.75, 1.25, 170, 30, 170, 8);

-- --------------------------------------------------------

--
-- Table structure for table `inkooporder`
--

CREATE TABLE `inkooporder` (
  `inkOrdId` int(11) NOT NULL,
  `levId` int(11) DEFAULT NULL,
  `artId` int(11) DEFAULT NULL,
  `inkOrdDatum` date DEFAULT NULL,
  `inkOrdBestAantal` int(11) DEFAULT NULL,
  `inkOrdStatus` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inkooporder`
--

INSERT INTO `inkooporder` (`inkOrdId`, `levId`, `artId`, `inkOrdDatum`, `inkOrdBestAantal`, `inkOrdStatus`) VALUES
(1, 1, 1, '2024-05-24', 100, 0),
(2, 2, 2, '2024-05-25', 120, 0),
(3, 3, 3, '2024-05-26', 80, 0),
(4, 4, 4, '2024-05-27', 70, 0),
(5, 5, 5, '2024-05-28', 90, 0);

-- --------------------------------------------------------

--
-- Table structure for table `klant`
--

CREATE TABLE `klant` (
  `klantId` int(11) NOT NULL,
  `klantNaam` varchar(20) NOT NULL,
  `klantEmail` varchar(30) NOT NULL,
  `klantAdres` varchar(30) NOT NULL,
  `klantPostcode` varchar(6) DEFAULT NULL,
  `klantWoonplaats` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `klant`
--

INSERT INTO `klant` (`klantId`, `klantNaam`, `klantEmail`, `klantAdres`, `klantPostcode`, `klantWoonplaats`) VALUES
(1, 'Emma', 'emma@example.com', '123 Parkstraat', '12345', 'Groningen'),
(2, 'Sophie', 'sophie@example.com', '456 Boulevard', '67890', 'Maastricht'),
(3, 'Liam', 'liam@example.com', '789 Pleinweg', '13579', 'Utrecht'),
(4, 'Noah', 'noah@example.com', '1011 Dorpsstraat', '24680', 'Rotterdam'),
(5, 'Olivia', 'olivia@example.com', '1212 Hoofdweg', '34567', 'Amsterdam');

-- --------------------------------------------------------

--
-- Table structure for table `leverancier`
--

CREATE TABLE `leverancier` (
  `levId` int(11) NOT NULL,
  `levNaam` varchar(15) NOT NULL,
  `levContact` varchar(20) DEFAULT NULL,
  `levEmail` varchar(30) NOT NULL,
  `levAdres` varchar(30) DEFAULT NULL,
  `levPostcode` varchar(6) DEFAULT NULL,
  `levWoonplaats` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leverancier`
--

INSERT INTO `leverancier` (`levId`, `levNaam`, `levContact`, `levEmail`, `levAdres`, `levPostcode`, `levWoonplaats`) VALUES
(1, 'Fruit Groothand', 'Jan de Vries', 'jan@fruitgroothandel.com', '789 Fruitweg', '54321', 'Utrecht'),
(2, 'Groente BV', 'Piet Bakker', 'piet@groentebv.nl', '456 Groentestraat', '98765', 'Den Haag'),
(3, 'Zuivelhandel', 'Henk Jansen', 'henk@zuivelhandel.nl', '123 Zuivelplein', '12345', 'Amsterdam'),
(4, 'Bakkerij', 'Maria van Dijk', 'maria@bakkerijvandijk.com', '321 Bakkersweg', '67890', 'Rotterdam'),
(5, 'Vleeshandel', 'Theo Visser', 'theo@vleesxl.com', '567 Slagerijstraat', '54321', 'Eindhoven');

-- --------------------------------------------------------

--
-- Table structure for table `verkooporder`
--

CREATE TABLE `verkooporder` (
  `verkOrdId` int(11) NOT NULL,
  `klantId` int(11) DEFAULT NULL,
  `artId` int(11) DEFAULT NULL,
  `verkOrdDatum` date DEFAULT NULL,
  `verkOrdBestAantal` int(11) DEFAULT NULL,
  `verkOrdStatus` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `verkooporder`
--

INSERT INTO `verkooporder` (`verkOrdId`, `klantId`, `artId`, `verkOrdDatum`, `verkOrdBestAantal`, `verkOrdStatus`) VALUES
(1, 1, 1, '2024-05-24', 10, 1),
(2, 2, 2, '2024-05-25', 15, 1),
(3, 3, 3, '2024-05-26', 20, 1),
(4, 4, 4, '2024-05-27', 25, 1),
(5, 5, 5, '2024-05-28', 30, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`artId`);

--
-- Indexes for table `inkooporder`
--
ALTER TABLE `inkooporder`
  ADD PRIMARY KEY (`inkOrdId`),
  ADD KEY `levId` (`levId`),
  ADD KEY `artId` (`artId`);

--
-- Indexes for table `klant`
--
ALTER TABLE `klant`
  ADD PRIMARY KEY (`klantId`);

--
-- Indexes for table `leverancier`
--
ALTER TABLE `leverancier`
  ADD PRIMARY KEY (`levId`);

--
-- Indexes for table `verkooporder`
--
ALTER TABLE `verkooporder`
  ADD PRIMARY KEY (`verkOrdId`),
  ADD KEY `klantId` (`klantId`),
  ADD KEY `artId` (`artId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `artId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `inkooporder`
--
ALTER TABLE `inkooporder`
  MODIFY `inkOrdId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `klant`
--
ALTER TABLE `klant`
  MODIFY `klantId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `leverancier`
--
ALTER TABLE `leverancier`
  MODIFY `levId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `verkooporder`
--
ALTER TABLE `verkooporder`
  MODIFY `verkOrdId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inkooporder`
--
ALTER TABLE `inkooporder`
  ADD CONSTRAINT `inkooporder_ibfk_1` FOREIGN KEY (`levId`) REFERENCES `leverancier` (`levId`),
  ADD CONSTRAINT `inkooporder_ibfk_2` FOREIGN KEY (`artId`) REFERENCES `artikel` (`artId`);

--
-- Constraints for table `verkooporder`
--
ALTER TABLE `verkooporder`
  ADD CONSTRAINT `verkooporder_ibfk_1` FOREIGN KEY (`klantId`) REFERENCES `klant` (`klantId`),
  ADD CONSTRAINT `verkooporder_ibfk_2` FOREIGN KEY (`artId`) REFERENCES `artikel` (`artId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
