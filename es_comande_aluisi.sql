-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 17, 2025 alle 19:01
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
-- Database: `es_comande_aluisi`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `camerieri`
--

CREATE TABLE `camerieri` (
  `ID_cameriere` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `pass_id` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `camerieri`
--

INSERT INTO `camerieri` (`ID_cameriere`, `nome`, `cognome`, `username`, `password`, `pass_id`) VALUES
(1, 'Jhonny', 'Gallo', 'Jhonny_Gallo', 'Cameriere1', '0e448656cb8c6e4f072f7dcfb5c105b346444305a11bb263d1fb8fb7c3ee0dfe'),
(2, 'Jonathan', 'Joestar', 'Jo_Jo', 'Cameriere2', '856e8683f495cdcaded2357ec90c34c57fc0a412e489a8b61eb8f0c9f2419fa5');

-- --------------------------------------------------------

--
-- Struttura della tabella `comande`
--

CREATE TABLE `comande` (
  `ID_comanda` int(11) NOT NULL,
  `data` date NOT NULL,
  `ora` time NOT NULL,
  `stato` tinyint(1) NOT NULL,
  `N_tavolo` int(11) NOT NULL,
  `N_coperti` int(11) NOT NULL,
  `ID_cameriere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `comande`
--

INSERT INTO `comande` (`ID_comanda`, `data`, `ora`, `stato`, `N_tavolo`, `N_coperti`, `ID_cameriere`) VALUES
(1, '2024-12-03', '18:15:30', 0, 4, 3, 1),
(2, '2024-12-04', '13:22:54', 0, 2, 4, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `dettagli_comande`
--

CREATE TABLE `dettagli_comande` (
  `ID_dettaglio` int(11) NOT NULL,
  `ID_menu` int(11) NOT NULL,
  `ID_comanda` int(11) NOT NULL,
  `N_uscita` int(11) NOT NULL,
  `quantità` int(11) NOT NULL,
  `nota` varchar(100) NOT NULL,
  `stato` tinyint(1) NOT NULL,
  `costo` float NOT NULL,
  `prezzo` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `dettagli_comande`
--

INSERT INTO `dettagli_comande` (`ID_dettaglio`, `ID_menu`, `ID_comanda`, `N_uscita`, `quantità`, `nota`, `stato`, `costo`, `prezzo`) VALUES
(1, 1, 1, 1, 1, '/', 1, 1, 5),
(2, 2, 2, 1, 1, '/', 1, 4, 12),
(20, 1, 1, 0, 0, '', 0, 1, 5);

-- --------------------------------------------------------

--
-- Struttura della tabella `menu`
--

CREATE TABLE `menu` (
  `ID_menu` int(11) NOT NULL,
  `prezzo` float NOT NULL,
  `costo` float NOT NULL,
  `attivo` tinyint(1) NOT NULL,
  `Descrizione_piatto` varchar(50) NOT NULL,
  `Descrizione_ingredienti` varchar(150) NOT NULL,
  `ID_tipologia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `menu`
--

INSERT INTO `menu` (`ID_menu`, `prezzo`, `costo`, `attivo`, `Descrizione_piatto`, `Descrizione_ingredienti`, `ID_tipologia`) VALUES
(1, 5, 1, 1, 'misto di affettati e formaggi', 'prosciutto cotto, salame, mortadella, latteria, montasio', 1),
(2, 12, 4, 1, 'spaghetti al nero di seppia', 'spaghetti conditi con nero di seppia', 2),
(3, 15, 5, 1, 'cotoletta con patate', 'pollo fritto con contorno di patatine fritte', 3),
(4, 12, 4, 1, 'bruschette', 'Pane tostato con sopra pomodorini, olio e origano', 1),
(5, 15, 5, 1, 'gnocchi al ragù', 'gnocchi di patate conditi con ragù di manzo', 2),
(6, 16, 4, 1, 'filetti con funghi', 'fettine di manzo ai ferri con contorno di funghi', 3),
(7, 9, 3, 1, 'caprese', 'mozzarella e pomodoro a fette con olio, origano e sale', 1),
(8, 18, 6, 1, 'farfalle al tartufo', 'farfalle condite con tartufo e crema di formaggio', 2),
(9, 15, 5, 1, 'grigliata mista', 'grigliata con pollo, civapcici e manzo contornata con polenta', 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `tipologie_piatti`
--

CREATE TABLE `tipologie_piatti` (
  `ID_tipologia` int(11) NOT NULL,
  `Descrizione_tipologia` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tipologie_piatti`
--

INSERT INTO `tipologie_piatti` (`ID_tipologia`, `Descrizione_tipologia`) VALUES
(1, 'Antipasti'),
(2, 'Primi'),
(3, 'Secondi');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `camerieri`
--
ALTER TABLE `camerieri`
  ADD PRIMARY KEY (`ID_cameriere`);

--
-- Indici per le tabelle `comande`
--
ALTER TABLE `comande`
  ADD PRIMARY KEY (`ID_comanda`),
  ADD KEY `ID_cameriere` (`ID_cameriere`);

--
-- Indici per le tabelle `dettagli_comande`
--
ALTER TABLE `dettagli_comande`
  ADD PRIMARY KEY (`ID_dettaglio`),
  ADD KEY `ID_menu` (`ID_menu`,`ID_comanda`);

--
-- Indici per le tabelle `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`ID_menu`),
  ADD KEY `ID_tipologia` (`ID_tipologia`);

--
-- Indici per le tabelle `tipologie_piatti`
--
ALTER TABLE `tipologie_piatti`
  ADD PRIMARY KEY (`ID_tipologia`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `camerieri`
--
ALTER TABLE `camerieri`
  MODIFY `ID_cameriere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `comande`
--
ALTER TABLE `comande`
  MODIFY `ID_comanda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `dettagli_comande`
--
ALTER TABLE `dettagli_comande`
  MODIFY `ID_dettaglio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT per la tabella `menu`
--
ALTER TABLE `menu`
  MODIFY `ID_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT per la tabella `tipologie_piatti`
--
ALTER TABLE `tipologie_piatti`
  MODIFY `ID_tipologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
