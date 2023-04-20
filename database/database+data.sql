-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 20 apr 2023 om 14:48
-- Serverversie: 10.4.27-MariaDB
-- PHP-versie: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `beeway`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `beeway`
--

CREATE TABLE `beeway` (
  `beewayid` int(11) NOT NULL,
  `schoolid` int(11) NOT NULL,
  `groepenid` varchar(11) NOT NULL,
  `beewaynaam` varchar(155) NOT NULL,
  `begoed` varchar(3) DEFAULT NULL,
  `bevoldoende` varchar(3) DEFAULT NULL,
  `beonvoldoende` varchar(3) DEFAULT NULL,
  `hoofdthemaid` varchar(11) NOT NULL,
  `vakgebiedid` varchar(11) NOT NULL,
  `concreetdoel` varchar(2500) DEFAULT NULL,
  `createdat` datetime NOT NULL DEFAULT current_timestamp(),
  `createdby` int(11) DEFAULT NULL,
  `updatedat` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedby` int(11) DEFAULT NULL,
  `archive` tinyint(4) NOT NULL DEFAULT 0,
  `deletedat` datetime DEFAULT NULL,
  `deletedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `beeway`
--

INSERT INTO `beeway` (`beewayid`, `schoolid`, `groepenid`, `beewaynaam`, `begoed`, `bevoldoende`, `beonvoldoende`, `hoofdthemaid`, `vakgebiedid`, `concreetdoel`, `createdat`, `createdby`, `updatedat`, `updatedby`, `archive`, `deletedat`, `deletedby`) VALUES
(15, 1, '1', 'test beeway', '12', '13', '14', '3', '2', 'doel doel', '2023-04-20 08:48:07', NULL, '2023-04-20 08:48:07', NULL, 0, NULL, NULL),
(16, 2, '2', 'test beeway', '12', '13', '14', '3', '2', 'doel doel', '2023-04-20 08:48:18', NULL, '2023-04-20 08:48:18', NULL, 0, NULL, NULL),
(17, 3, '3', 'test beeway', '12', '13', '14', '3', '2', 'doel doel', '2023-04-20 08:48:44', NULL, '2023-04-20 08:48:44', NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `beewayobservatie`
--

CREATE TABLE `beewayobservatie` (
  `observatieid` int(11) NOT NULL,
  `beewayid` int(11) NOT NULL,
  `datales` varchar(2500) DEFAULT NULL,
  `leerdoel` varchar(2500) DEFAULT NULL,
  `evaluatie` varchar(2500) DEFAULT NULL,
  `werkdoel` varchar(2500) DEFAULT NULL,
  `actie` varchar(2500) DEFAULT NULL,
  `createdat` datetime NOT NULL DEFAULT current_timestamp(),
  `createdby` int(11) NOT NULL,
  `updatedat` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedby` int(11) NOT NULL,
  `archive` tinyint(4) NOT NULL DEFAULT 0,
  `deletedat` datetime DEFAULT NULL,
  `deletedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `beewayplanning`
--

CREATE TABLE `beewayplanning` (
  `planningid` int(11) NOT NULL,
  `beewayid` varchar(11) NOT NULL,
  `planning` varchar(155) DEFAULT NULL,
  `planningwat` varchar(2500) DEFAULT NULL,
  `planningwie` varchar(2500) DEFAULT NULL,
  `planningdeadline` datetime DEFAULT NULL,
  `planninggedaan` varchar(4) DEFAULT NULL,
  `createdat` datetime NOT NULL DEFAULT current_timestamp(),
  `createdby` int(11) DEFAULT NULL,
  `updatedat` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedby` int(11) DEFAULT NULL,
  `archive` tinyint(4) NOT NULL DEFAULT 0,
  `deletedat` datetime DEFAULT NULL,
  `deletedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `groepen`
--

CREATE TABLE `groepen` (
  `groepenid` int(11) NOT NULL,
  `groepen` varchar(3) NOT NULL,
  `createdat` datetime NOT NULL DEFAULT current_timestamp(),
  `createdby` int(11) NOT NULL,
  `updatedat` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedby` int(11) NOT NULL,
  `archive` tinyint(4) NOT NULL DEFAULT 0,
  `deletedat` datetime DEFAULT NULL,
  `deletedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `groepen`
--

INSERT INTO `groepen` (`groepenid`, `groepen`, `createdat`, `createdby`, `updatedat`, `updatedby`, `archive`, `deletedat`, `deletedby`) VALUES
(1, '6', '2023-04-20 09:47:56', 1, '2023-04-20 09:47:56', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hoofdthema`
--

CREATE TABLE `hoofdthema` (
  `themaid` int(11) NOT NULL,
  `naamthema` varchar(55) NOT NULL,
  `periode` int(2) NOT NULL,
  `schooljaar` varchar(10) NOT NULL,
  `createdat` datetime NOT NULL DEFAULT current_timestamp(),
  `createdby` int(11) NOT NULL,
  `updatedat` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedby` int(11) NOT NULL,
  `archive` tinyint(4) NOT NULL DEFAULT 0,
  `deletedat` datetime DEFAULT NULL,
  `deletedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `koppelinggroepen`
--

CREATE TABLE `koppelinggroepen` (
  `userid` int(11) NOT NULL,
  `groepenid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `koppelinggroepen`
--

INSERT INTO `koppelinggroepen` (`userid`, `groepenid`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `schoolen`
--

CREATE TABLE `schoolen` (
  `schoolid` int(11) NOT NULL,
  `naamschool` varchar(155) NOT NULL,
  `createdat` datetime NOT NULL DEFAULT current_timestamp(),
  `createdby` int(11) NOT NULL,
  `updatedat` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedby` int(11) NOT NULL,
  `archive` tinyint(4) NOT NULL DEFAULT 0,
  `deletedat` datetime DEFAULT NULL,
  `deletedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `schoolen`
--

INSERT INTO `schoolen` (`schoolid`, `naamschool`, `createdat`, `createdby`, `updatedat`, `updatedby`, `archive`, `deletedat`, `deletedby`) VALUES
(1, 'ict@paul', '2023-04-20 09:48:32', 1, '2023-04-20 09:48:32', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `session`
--

CREATE TABLE `session` (
  `sessionid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `stmp` int(11) NOT NULL,
  `token` varchar(155) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `session`
--

INSERT INTO `session` (`sessionid`, `userid`, `stmp`, `token`) VALUES
(1, 1, 1234, 'qwerty');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `schoolid` int(11) NOT NULL,
  `voornaam` varchar(55) NOT NULL,
  `achternaam` varchar(55) NOT NULL,
  `email` varchar(255) NOT NULL,
  `wachtwoord` varchar(100) NOT NULL,
  `rol` tinyint(4) NOT NULL,
  `createdat` datetime NOT NULL DEFAULT current_timestamp(),
  `createdby` int(11) NOT NULL,
  `updatedat` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedby` int(11) NOT NULL,
  `archive` tinyint(4) NOT NULL DEFAULT 0,
  `deletedat` datetime DEFAULT NULL,
  `deletedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`userid`, `schoolid`, `voornaam`, `achternaam`, `email`, `wachtwoord`, `rol`, `createdat`, `createdby`, `updatedat`, `updatedby`, `archive`, `deletedat`, `deletedby`) VALUES
(1, 1, 'test', 'test', 'test', 'test', 1, '2023-04-20 09:34:01', 1, '2023-04-20 09:34:01', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `vakgebied`
--

CREATE TABLE `vakgebied` (
  `vakid` int(11) NOT NULL,
  `naamvakgebied` varchar(55) NOT NULL,
  `createdat` datetime NOT NULL DEFAULT current_timestamp(),
  `createdby` int(11) NOT NULL,
  `updatedat` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedby` int(11) NOT NULL,
  `archive` tinyint(4) NOT NULL DEFAULT 0,
  `deletedat` datetime DEFAULT NULL,
  `deletedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `beeway`
--
ALTER TABLE `beeway`
  ADD PRIMARY KEY (`beewayid`);

--
-- Indexen voor tabel `beewayobservatie`
--
ALTER TABLE `beewayobservatie`
  ADD PRIMARY KEY (`observatieid`);

--
-- Indexen voor tabel `beewayplanning`
--
ALTER TABLE `beewayplanning`
  ADD PRIMARY KEY (`planningid`);

--
-- Indexen voor tabel `groepen`
--
ALTER TABLE `groepen`
  ADD PRIMARY KEY (`groepenid`);

--
-- Indexen voor tabel `hoofdthema`
--
ALTER TABLE `hoofdthema`
  ADD PRIMARY KEY (`themaid`);

--
-- Indexen voor tabel `schoolen`
--
ALTER TABLE `schoolen`
  ADD PRIMARY KEY (`schoolid`);

--
-- Indexen voor tabel `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`sessionid`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- Indexen voor tabel `vakgebied`
--
ALTER TABLE `vakgebied`
  ADD PRIMARY KEY (`vakid`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `beeway`
--
ALTER TABLE `beeway`
  MODIFY `beewayid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT voor een tabel `beewayobservatie`
--
ALTER TABLE `beewayobservatie`
  MODIFY `observatieid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `beewayplanning`
--
ALTER TABLE `beewayplanning`
  MODIFY `planningid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `hoofdthema`
--
ALTER TABLE `hoofdthema`
  MODIFY `themaid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `session`
--
ALTER TABLE `session`
  MODIFY `sessionid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `vakgebied`
--
ALTER TABLE `vakgebied`
  MODIFY `vakid` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
