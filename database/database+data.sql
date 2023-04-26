-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 26 apr 2023 om 10:51
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
  `status` varchar(1) NOT NULL DEFAULT '0',
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

INSERT INTO `beeway` (`beewayid`, `schoolid`, `groepenid`, `beewaynaam`, `begoed`, `bevoldoende`, `beonvoldoende`, `hoofdthemaid`, `vakgebiedid`, `concreetdoel`, `status`, `createdat`, `createdby`, `updatedat`, `updatedby`, `archive`, `deletedat`, `deletedby`) VALUES
(15, 1, '1', 'test beeway', '12', '13', '14', '3', '2', 'doel doel', '0', '2023-04-20 08:48:07', NULL, '2023-04-20 08:48:07', NULL, 0, NULL, NULL),
(16, 2, '2', 'test beeway', '12', '13', '14', '3', '2', 'doel doel', '0', '2023-04-20 08:48:18', NULL, '2023-04-20 08:48:18', NULL, 0, NULL, NULL),
(17, 3, '3', 'test beeway', '12', '13', '14', '3', '2', 'doel doel', '0', '2023-04-20 08:48:44', NULL, '2023-04-20 08:48:44', NULL, 0, NULL, NULL);

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
-- Tabelstructuur voor tabel `scholen`
--

CREATE TABLE `scholen` (
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
-- Gegevens worden geëxporteerd voor tabel `scholen`
--

INSERT INTO `scholen` (`schoolid`, `naamschool`, `createdat`, `createdby`, `updatedat`, `updatedby`, `archive`, `deletedat`, `deletedby`) VALUES
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
(3, 1, 1682411386, 'hGEnZO3R1cffGakKUeyOBA5zt87m62nAs67U1exUpAQojwum39'),
(5, 2, 1682411612, 'UdIpU8UNkCEMJaAasXRnTaeLHhxDZlUiR0zDqkFkKqnSquFm94'),
(6, 1, 1682411818, '9E9YkyGLFbZcboMtGiEfxqqOx0Mm8Mm38rsd3RnbsAif0odzai'),
(7, 1, 1682413137, '96xpxJ5LoN780HD4x5ARCfCDLRFmppIcT4LCZorV9CswhP6wX0'),
(8, 1, 1682413204, 'vfkMPVCRHcb8E3jwmhkb47X2yiknpbdrfGbye8yturfPZ1KxM6'),
(9, 1, 1682413500, 'I1IJRMmiqOB7Fg4gQbS4QqDqLC4LP4NTYLnAi1khd28APcwC2x'),
(10, 1, 1682413560, 'Yn8ZpYp2lQjxfVAg82NLyk6omnOembcO9JGyIedtsWR1vOYnRR'),
(11, 1, 1682414549, 'jMH8e8Ya2ZwttsIMVyVTFCqoCyp3rjvdb5M764itI4ZW5S6nGE'),
(12, 1, 1682415637, 'ATBK2KB9PE47GGLTxA4BVJzyMYPo3Bbvm0WsBob0WL1sJ0wxtd'),
(13, 1, 1682416044, 'aiCJY2YgQJ0mzQRLZdia09zhMYYz5kQQvRIt5YDQZc35iSO6xM'),
(14, 1, 1682416533, 'eBH8itjho1PqcKT2FZI4XCfaAIkmAuWdTy1ysMftlpLGr27ZS0'),
(15, 1, 1682416535, 'OKPOYvYABHu5qw2mMBKt1YuRDLUUzXJMKkFVXcaUjMhBVmWWWz'),
(16, 1, 1682416576, 'lfjKrl0oak9sVPyJ3KeO6Xu7jFafqkjBm3LmHurp4UaFEu0O0T'),
(17, 1, 1682416626, 'U5I6yNBhkCw9sMmPNi3ZJyD9Xe9vv1al22InCxtcieMhidojZe'),
(18, 1, 1682416641, 'LilMIeHzIVeCdBDazFqbbCkwo9Y0Y54DKlPk7FnDuuCb2MJrJt'),
(19, 1, 1682416682, '8Z5jVODxy7ljXKEdIQNoDlRerxT6LjhJTjKVGtE0DkwyNwl6Lc'),
(20, 1, 1682419867, 'jefKUpyDzhUdgO8BHJccsAVR4mvAsHEhdDFMFGiqENHC0x3DlH'),
(21, 2, 1682419906, 'JJQ9LhFKhmv9Q5crZ9ffy3AcPfnDZBXZr3tUc0UNU6PRDdBPK3'),
(22, 2, 1682419908, 'CzMDsBUkSVBCuBP25gXihAB3wKhKJEAQq0ZclmK6jOsAYJc2TS'),
(23, 2, 1682419915, 'ZYfk4I9LYmpueicMFVSvX6hDl3n539Kc2XDzYy2Bjv6LpAEbJP'),
(24, 2, 1682420077, '7O48sczNMIW6wWVazyL04cQZ8CKjmsBJ1eXs85fTfLn5Ic4n7V'),
(25, 2, 1682420077, 'j6X78PHrKg2gjsQ9uJaTo7IOVWjm2lWShKm3xKEdXrbRFxx4PD'),
(26, 2, 1682420077, '6uLlDvsrUPEzxm8Xi5mctedO4pyGp063BD2JhBcTBFFYEP3TQU'),
(27, 2, 1682420078, 'fzMBnv0o087OeIxRLD2Tg6Zl1IdDSx8Vcl0JCXe94IZ4R6t9VT'),
(28, 2, 1682420078, 'xRV1tFTU8kfByoQ7qmhvXNLF0S0gREOQqvxfBK4deuebBSFLDA'),
(29, 2, 1682420078, 'iyq2efuWzKqWYPK0Mtv6aQgi5yoge8ARa35qanvJbMySLlvlKh'),
(30, 2, 1682420078, 'yWYeORAqWD8jZdWaWsCDaERSJY14Sct5SvUT57ZbwwHn8V0x2Y'),
(31, 2, 1682420078, 'hwAYCUprremR6RThR1pfSL5Fpm6iIcxq6co3PwhvROsn3j1s75'),
(32, 2, 1682420240, 'Jhuf0vUcz0Vw92wDzsZT9xCjDw2puJaJKJvlftawpbWWQebY6c'),
(33, 3, 1682420294, 'N59EpWtT0DgBbA6pkhtiHYUOb4hn2BH5jvDwWJ1talCsYtShym'),
(34, 1, 1682378212, 'yzDrVGznLPZJXQaL0TPUbhBOHHyeBYvprleNl4H9ggaubyVdKY'),
(35, 2, 1682378479, 'bLXox6GjwpMEYDbyrkWDzJoXK68JJRuxYbWvuckSzL3cSlotb9'),
(36, 1, 1682379370, 'JCYNJJEDLVnElZzqryCwRjPGiRnv5nJEw2UbACyVM6AesJQeph'),
(37, 1, 1682497913, 'mc6pG8g0Kk9cbyo9QqiBU9Ext5WhrJotIDXAeqKGHscWMhDYCVlsK0Ff1V4v1aDnbHn3F3PftaJqCynAf8SmZvRKTygn'),
(38, 1, 1682497934, 'FgSsvJ3yHerkVlxmGWs8D3viIM29Q3HhqFiyewGqQjMJCIkvfalPVveP'),
(39, 1, 1682497976, 'pZazClFGXvYnj3hpAN7WMOJ8Fpz6mA1AzkajEtYF5eYIYX1OlQA4eSKNQOVds0KKsjFPNxdX8BwnFhufGgos5ugHd'),
(40, 1, 1682498227, 'lhnaTcfrSOwLWQDooRUxe2Kfxc8fRgByEMrQi9rkjaKL87ccySSAM'),
(41, 1, 1682498954, '9CcNTCkqI9kBZ6Z3P2em52Cm4ZzXtt0zH6I56kUzW1pjweEERSWTwc5Bvx8EtesSKcly9AAm8yaX85mVVdu3GtS');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `schoolid` int(11) DEFAULT NULL,
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
(1, NULL, 'test', 'test', 'test@test.nl', '098f6bcd4621d373cade4e832627b4f6', 2, '2023-04-20 09:34:01', 1, '2023-04-20 09:34:01', 1, 0, NULL, NULL),
(2, 1, 'test', 'test', 'een@test.nl', '098f6bcd4621d373cade4e832627b4f6', 1, '2023-04-20 09:34:01', 1, '2023-04-20 09:34:01', 1, 0, NULL, NULL),
(3, 1, 'test', 'test', 'twee@test.nl', '098f6bcd4621d373cade4e832627b4f6', 0, '2023-04-20 09:34:01', 1, '2023-04-20 09:34:01', 1, 0, NULL, NULL);

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
-- Indexen voor tabel `scholen`
--
ALTER TABLE `scholen`
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
  MODIFY `sessionid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `vakgebied`
--
ALTER TABLE `vakgebied`
  MODIFY `vakid` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
