-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 22, 2024 alle 09:25
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stazioni_biciclette`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `admin`
--

CREATE TABLE `admin` (
  `ID` int(11) NOT NULL,
  `email` varchar(64) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nome` varchar(32) DEFAULT NULL,
  `cognome` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `admin`
--

INSERT INTO `admin` (`ID`, `email`, `username`, `password`, `nome`, `cognome`) VALUES
(1, 'admin@example.com', 'admin.', '21232f297a57a5a743894a0e4a801fc3', 'Admin', 'AdminSurname'),
(2, 'user1@example.com', 'user1', 'pass123', 'User1', 'User1Surname'),
(3, 'user2@example.com', 'user2', 'pass456', 'User2', 'User2Surname'),
(4, 'user3@example.com', 'user3', 'pass789', 'User3', 'User3Surname'),
(5, 'user4@example.com', 'user4', 'passabc', 'User4', 'User4Surname');

-- --------------------------------------------------------

--
-- Struttura della tabella `bicicletta`
--

CREATE TABLE `bicicletta` (
  `ID` int(11) NOT NULL,
  `distanza_percorsa` float DEFAULT NULL,
  `latitudine` varchar(10) NOT NULL,
  `longitudine` varchar(10) NOT NULL,
  `gps` varchar(16) NOT NULL,
  `stato` tinyint(4) NOT NULL,
  `RFID` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `bicicletta`
--

INSERT INTO `bicicletta` (`ID`, `distanza_percorsa`, `latitudine`, `longitudine`, `gps`, `stato`, `RFID`) VALUES
(1, 100.5, '45.6789', '9.1234', 'GPS123456789', 1, 'RFID123456789'),
(2, 75.25, '45.6781', '9.1236', 'GPS987654321', 0, 'RFID987654321'),
(3, 150.75, '45.6790', '9.1240', 'GPS246813579', 1, 'RFID246813579'),
(4, 50, '45.6775', '9.1220', 'GPS369258147', 1, 'RFID369258147'),
(5, 80.3, '45.6770', '9.1215', 'GPS135792468', 0, 'RFID135792468');

-- --------------------------------------------------------

--
-- Struttura della tabella `clienti`
--

CREATE TABLE `clienti` (
  `ID` int(11) NOT NULL,
  `email` varchar(64) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nome` varchar(32) DEFAULT NULL,
  `cognome` varchar(32) DEFAULT NULL,
  `numeroTessera` int(11) NOT NULL,
  `carta_credito` varchar(16) NOT NULL,
  `regione` varchar(32) DEFAULT NULL,
  `provincia` varchar(32) DEFAULT NULL,
  `citta` varchar(32) DEFAULT NULL,
  `cap` int(5) DEFAULT NULL,
  `via` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `clienti`
--

INSERT INTO `clienti` (`ID`, `email`, `username`, `password`, `nome`, `cognome`, `numeroTessera`, `carta_credito`, `regione`, `provincia`, `citta`, `cap`, `via`) VALUES
(1, 'cliente1@example.com', 'mario_', 'de2f15d014d40b93578d255e6221fd60', 'Mario', 'Rossi', 1001, '2147483647', 'Lombardia', 'Como', 'Cernobbio', 22012, 'Via Roma 1'),
(2, 'cliente2@example.com', 'cliente2', '73a054cc528f91ca1bbdda3589b6a22d', 'Luigi', 'Verdi', 1002, '2147483646', 'Lombardia', 'Como', 'Como', 22100, 'Via Garibaldi 10'),
(3, 'cliente3@example.com', 'cliente3', 'ba1b5d9d26dd50164b5fb53a948e5cdf', 'Giovanna', 'Bianchi', 1003, '2147483641', 'Lombardia', 'Como', 'Como', 22100, 'Via Alessandro Volta 5'),
(4, 'cliente4@example.com', 'cliente4', 'e38561d99e538eb7d936acb92bd847b0', 'Anna', 'Neri', 1004, '2147483642', 'Lombardia', 'Como', 'Como', 22100, 'Via Milano 20'),
(5, 'cliente5@example.com', 'cliente5', '1dac2d5e70b56800ba9cdf6e877d519b', 'Paolo', 'Gialli', 1005, '2147483643', 'Lombardia', 'Como', 'Como', 22100, 'Via Como 15'),
(6, 'luigi@', 'luigi_', 'e9da82f4c252e7f1745ae88f2624fc07', 'luigi', 'verdi', 1006, '0000000000000000', 'Lombardia', 'Como', 'Cantù', 22063, 'via verona 8');

--
-- Trigger `clienti`
--
DELIMITER $$
CREATE TRIGGER `test` BEFORE INSERT ON `clienti` FOR EACH ROW BEGIN
SET NEW.numeroTessera = IFNULL((SELECT MAX(numeroTessera) + 1 FROM clienti), 1001);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `operazione`
--

CREATE TABLE `operazione` (
  `ID` int(11) NOT NULL,
  `distanza_percorsa` float NOT NULL,
  `tipo` enum('noleggio','riconsegna') NOT NULL,
  `tariffa` float DEFAULT NULL,
  `data_ora` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_cliente` int(11) NOT NULL,
  `id_bicicletta` int(11) NOT NULL,
  `id_stazione` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `operazione`
--

INSERT INTO `operazione` (`ID`, `distanza_percorsa`, `tipo`, `tariffa`, `data_ora`, `id_cliente`, `id_bicicletta`, `id_stazione`) VALUES
(1, 10.75, 'noleggio', 5.5, '2024-05-10 06:20:33', 1, 1, 1),
(2, 8.2, 'noleggio', 4, '2024-05-10 06:20:33', 2, 2, 2),
(3, 15.5, 'riconsegna', 0, '2024-05-10 06:20:33', 3, 3, 3),
(4, 5.3, 'noleggio', 3.25, '2024-05-10 06:20:33', 4, 4, 4),
(5, 20.1, 'riconsegna', 0, '2024-05-10 06:20:33', 5, 5, 5);

-- --------------------------------------------------------

--
-- Struttura della tabella `stazione`
--

CREATE TABLE `stazione` (
  `codice` int(11) NOT NULL,
  `slot` int(11) DEFAULT NULL,
  `regione` varchar(32) NOT NULL,
  `provincia` varchar(32) NOT NULL,
  `citta` varchar(32) NOT NULL,
  `cap` int(5) NOT NULL,
  `via` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `bicicletta`
--
ALTER TABLE `bicicletta`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `clienti`
--
ALTER TABLE `clienti`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `numeroTessera` (`numeroTessera`),
  ADD UNIQUE KEY `carta_credito` (`carta_credito`);

--
-- Indici per le tabelle `operazione`
--
ALTER TABLE `operazione`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_cliente` (`id_cliente`,`id_bicicletta`,`id_stazione`),
  ADD KEY `operazione_bicicletta` (`id_bicicletta`),
  ADD KEY `id_stazione` (`id_stazione`);

--
-- Indici per le tabelle `stazione`
--
ALTER TABLE `stazione`
  ADD PRIMARY KEY (`codice`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `admin`
--
ALTER TABLE `admin`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `bicicletta`
--
ALTER TABLE `bicicletta`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `clienti`
--
ALTER TABLE `clienti`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `operazione`
--
ALTER TABLE `operazione`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `stazione`
--
ALTER TABLE `stazione`
  MODIFY `codice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `operazione`
--
ALTER TABLE `operazione`
  ADD CONSTRAINT `operazione_bicicletta` FOREIGN KEY (`id_bicicletta`) REFERENCES `bicicletta` (`ID`),
  ADD CONSTRAINT `operazione_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clienti` (`ID`);

--
-- Limiti per la tabella `stazione`
--
ALTER TABLE `stazione`
  ADD CONSTRAINT `stazione_ibfk_1` FOREIGN KEY (`codice`) REFERENCES `operazione` (`id_stazione`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
