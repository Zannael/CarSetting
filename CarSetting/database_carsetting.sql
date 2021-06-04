-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 04, 2021 alle 09:23
-- Versione del server: 10.4.18-MariaDB
-- Versione PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `alimentazione`
--

CREATE TABLE `alimentazione` (
  `id` int(10) UNSIGNED NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `carburante` varchar(255) NOT NULL,
  `tipoibrido` varchar(255) DEFAULT NULL,
  `idcapacita` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `alimentazione`
--

INSERT INTO `alimentazione` (`id`, `tipo`, `carburante`, `tipoibrido`, `idcapacita`) VALUES
(1, 'meccanica', 'benzina', NULL, 1),
(2, 'meccanica', 'diesel', NULL, 1),
(3, 'meccanica', 'GPL', NULL, 1),
(4, 'hybrid', 'batteria/benzina', 'mild-hybrid', 2),
(5, 'meccanica', 'benzina', NULL, 3),
(6, 'meccanica', 'diesel', NULL, 3),
(7, 'meccanica', 'benzina', NULL, 4),
(8, 'meccanica', 'diesel', NULL, 5),
(9, 'meccanica', 'benzina', NULL, 4),
(10, 'meccanica', 'diesel', NULL, 5),
(11, 'hybrid', 'batteria', 'mild-hybrid', 5),
(12, 'hybrid', 'batteria', 'plug-in hybrid', 5),
(13, 'meccanica', 'benzina', NULL, 6),
(14, 'hybrid', 'batteria', 'mild-hybrid', 7),
(15, 'meccanica', 'benzina', NULL, 8),
(16, 'hybrid', 'batteria', 'full-hybrid', 9),
(17, 'meccanica', 'diesel', NULL, 9),
(18, 'elettrica', 'batteria', NULL, 11);

-- --------------------------------------------------------

--
-- Struttura della tabella `automobili`
--

CREATE TABLE `automobili` (
  `modello` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `peso` int(10) UNSIGNED NOT NULL,
  `velocita` int(10) UNSIGNED NOT NULL,
  `prezzolistino` int(10) UNSIGNED NOT NULL,
  `idvalutazione` int(10) UNSIGNED NOT NULL,
  `imageurl` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `automobili`
--

INSERT INTO `automobili` (`modello`, `brand`, `peso`, `velocita`, `prezzolistino`, `idvalutazione`, `imageurl`) VALUES
('Fiesta', 'Ford', 1055, 185, 17050, 1, 'images/nuovafiesta.png'),
('Giulia', 'Alfa Romeo', 2000, 235, 48500, 2, 'images/alfagiulia.png'),
('Kona', 'Hyundai', 1355, 180, 22000, 4, 'images/hyundaikona.png'),
('Lodgy', 'Dacia', 1188, 172, 14450, 7, 'images/dacialodgy.png'),
('NSX', 'Honda', 1763, 308, 99000, 6, 'images/hondansx.png'),
('Nuova ë-C4', 'Citroen', 1561, 150, 35400, 8, 'images/citroenc4.png'),
('Q3 Sportback', 'Audi', 1650, 210, 39400, 3, 'images/audiq3.png'),
('Z4', 'BMW', 1495, 241, 43800, 5, 'images/bmwz4.png');

--
-- Trigger `automobili`
--
DELIMITER $$
CREATE TRIGGER `max_auto` BEFORE INSERT ON `automobili` FOR EACH ROW BEGIN
    IF (SELECT COUNT(*) FROM automobili) THEN 
        SIGNAL SQLSTATE '02000' SET MESSAGE_TEXT = 'Limite auto raggiunto';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `avg_rating`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `avg_rating` (
`rating` int(10) unsigned
);

-- --------------------------------------------------------

--
-- Struttura della tabella `cambio`
--

CREATE TABLE `cambio` (
  `tipo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `cambio`
--

INSERT INTO `cambio` (`tipo`) VALUES
('Automatico'),
('Manuale');

-- --------------------------------------------------------

--
-- Struttura della tabella `capacita`
--

CREATE TABLE `capacita` (
  `id` int(10) UNSIGNED NOT NULL,
  `valore` int(10) UNSIGNED NOT NULL,
  `tipo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `capacita`
--

INSERT INTO `capacita` (`id`, `valore`, `tipo`) VALUES
(1, 45, 1),
(2, 48, 0),
(3, 58, 1),
(4, 55, 1),
(5, 48, 0),
(6, 50, 1),
(7, 48, 0),
(8, 45, 1),
(9, 50, 0),
(10, 45, 0),
(11, 48, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `carrozzeria`
--

CREATE TABLE `carrozzeria` (
  `id` int(10) UNSIGNED NOT NULL,
  `variante` varchar(255) NOT NULL,
  `colore` varchar(255) NOT NULL,
  `nomeauto` varchar(255) NOT NULL,
  `nomebrand` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `carrozzeria`
--

INSERT INTO `carrozzeria` (`id`, `variante`, `colore`, `nomeauto`, `nomebrand`) VALUES
(6, 'Berlina', 'Agate Black micalizzato', 'Fiesta', 'Ford'),
(7, 'Berlina', 'Rosso edizione', 'Giulia', 'Alfa Romeo'),
(8, 'Suv', 'Grigio Chronos Metallizzato', 'Q3 Sportback', 'Audi'),
(9, 'Suv', 'Dive in Jeju Pastello', 'Kona', 'Hyundai'),
(10, 'Cabrio', 'Alpin White Pastello', 'Z4', 'BMW'),
(11, 'Coupe', 'Nord Gray Metallic', 'NSX', 'Honda'),
(12, 'Monovolume', 'Blue Iron', 'Lodgy', 'Dacia'),
(13, 'Berlina', 'Grigio', 'Nuova ë-C4', 'Citroen');

--
-- Trigger `carrozzeria`
--
DELIMITER $$
CREATE TRIGGER `double_carr` BEFORE INSERT ON `carrozzeria` FOR EACH ROW BEGIN
    IF (new.variante not in ( 
        SELECT variante FROM carrozzeria 
        WHERE new.nomeauto = nomeauto and new.nomebrand = nomebrand)
       ) THEN 
        SIGNAL SQLSTATE '02000' SET MESSAGE_TEXT = 'Una macchina non può avere 2 carrozzerie';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `costruttori`
--

CREATE TABLE `costruttori` (
  `nome` varchar(255) NOT NULL,
  `nazionalita` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `costruttori`
--

INSERT INTO `costruttori` (`nome`, `nazionalita`) VALUES
('Alfa Romeo', 'Italia'),
('Audi', 'Germania'),
('BMW', 'Germania'),
('Citroen', 'Francia'),
('Dacia', 'Romania'),
('Ford', 'USA'),
('Honda', 'Giappone'),
('Hyundai', 'Corea del Sud');

-- --------------------------------------------------------

--
-- Struttura della tabella `dotazione`
--

CREATE TABLE `dotazione` (
  `codicemotore` varchar(255) NOT NULL,
  `consumomotore` int(10) UNSIGNED NOT NULL,
  `nomeauto` varchar(255) NOT NULL,
  `nomebrand` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `dotazione`
--

INSERT INTO `dotazione` (`codicemotore`, `consumomotore`, `nomeauto`, `nomebrand`) VALUES
('FoFi1', 5, 'Fiesta', 'Ford'),
('FoFi2', 6, 'Fiesta', 'Ford'),
('FoFi3', 5, 'Fiesta', 'Ford'),
('FoFi4', 4, 'Fiesta', 'Ford'),
('AlGi1', 10, 'Giulia', 'Alfa Romeo'),
('AlGi2', 11, 'Giulia', 'Alfa Romeo'),
('AlGi3', 11, 'Giulia', 'Alfa Romeo'),
('AlGi4', 15, 'Giulia', 'Alfa Romeo'),
('AuQ31', 9, 'Q3 Sportback', 'Audi'),
('AuQ32', 10, 'Q3 Sportback', 'Audi'),
('AuQ33', 9, 'Q3 Sportback', 'Audi'),
('AuQ34', 9, 'Q3 Sportback', 'Audi'),
('AuQ35', 2, 'Q3 Sportback', 'Audi'),
('HyKo1', 8, 'Kona', 'Hyundai'),
('HyKo2', 7, 'Kona', 'Hyundai'),
('BmZ41', 7, 'Z4', 'BMW'),
('BmZ42', 8, 'Z4', 'BMW'),
('HoNs1', 11, 'NSX', 'Honda'),
('DaLo1', 4, 'Lodgy', 'Dacia'),
('DaLo2', 5, 'Lodgy', 'Dacia'),
('CiC41', 0, 'Nuova ë-C4', 'Citroen');

-- --------------------------------------------------------

--
-- Struttura della tabella `meccanismo`
--

CREATE TABLE `meccanismo` (
  `codicemotore` varchar(255) NOT NULL,
  `consumomotore` int(10) UNSIGNED NOT NULL,
  `tipocambio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `meccanismo`
--

INSERT INTO `meccanismo` (`codicemotore`, `consumomotore`, `tipocambio`) VALUES
('AlGi1', 10, 'Automatico'),
('AlGi2', 11, 'Automatico'),
('AlGi3', 11, 'Automatico'),
('AlGi4', 15, 'Automatico'),
('AuQ31', 9, 'Manuale'),
('AuQ32', 10, 'Automatico'),
('AuQ33', 9, 'Manuale'),
('AuQ34', 9, 'Automatico'),
('AuQ35', 2, 'Automatico'),
('BmZ41', 7, 'Manuale'),
('BmZ42', 8, 'Automatico'),
('CiC41', 0, 'Automatico'),
('DaLo1', 4, 'Manuale'),
('DaLo2', 5, 'Manuale'),
('FoFi1', 5, 'Manuale'),
('FoFi2', 6, 'Manuale'),
('FoFi3', 5, 'Manuale'),
('HoNs1', 11, 'Automatico'),
('HyKo1', 8, 'Manuale'),
('HyKo2', 7, 'Automatico');

-- --------------------------------------------------------

--
-- Struttura della tabella `motori`
--

CREATE TABLE `motori` (
  `codice` varchar(255) NOT NULL,
  `consumo` int(10) UNSIGNED NOT NULL,
  `potenza` int(10) UNSIGNED NOT NULL,
  `cilindrata` int(10) UNSIGNED NOT NULL,
  `co2` int(10) UNSIGNED NOT NULL,
  `classe` varchar(255) NOT NULL,
  `idalimentazione` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `motori`
--

INSERT INTO `motori` (`codice`, `consumo`, `potenza`, `cilindrata`, `co2`, `classe`, `idalimentazione`) VALUES
('AlGi1', 10, 160, 2200, 127, 'euro6D', 6),
('AlGi2', 11, 200, 2000, 165, 'euro6D', 5),
('AlGi3', 11, 210, 2200, 144, 'euro6D', 6),
('AlGi4', 15, 510, 2900, 227, 'euro6D', 5),
('AuQ31', 9, 150, 1500, 149, 'euro6D', 9),
('AuQ32', 10, 190, 2000, 175, 'euro6D', 9),
('AuQ33', 9, 200, 2000, 174, 'euro6D', 10),
('AuQ34', 9, 150, 1500, 149, 'euro6D', 11),
('AuQ35', 2, 245, 3000, 43, 'euro6D', 12),
('BmZ41', 7, 145, 1200, 197, 'euro6D', 15),
('BmZ42', 8, 250, 1900, 340, 'euro6D', 15),
('CiC41', 0, 100, 0, 0, 'euro6D', 18),
('DaLo1', 4, 95, 1461, 115, 'euro6D', 17),
('DaLo2', 5, 100, 1551, 118, 'euro6D', 17),
('FoFi1', 5, 75, 1000, 128, 'euro6D', 2),
('FoFi2', 6, 90, 1000, 121, 'euro6D', 1),
('FoFi3', 5, 75, 1000, 115, 'euro6D', 3),
('FoFi4', 4, 125, 1000, 115, 'euro6D', 4),
('HoNs1', 11, 580, 3493, 242, 'euro6D', 16),
('HyKo1', 8, 120, 1000, 133, 'euro6D', 13),
('HyKo2', 7, 136, 1600, 146, 'euro6D', 14);

-- --------------------------------------------------------

--
-- Struttura della tabella `optional`
--

CREATE TABLE `optional` (
  `id` int(10) UNSIGNED NOT NULL,
  `coloresedili` varchar(255) NOT NULL,
  `pollici` int(10) UNSIGNED NOT NULL,
  `ariacond` tinyint(1) NOT NULL,
  `sensoreparc` tinyint(1) NOT NULL,
  `display` tinyint(1) NOT NULL,
  `prezzo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `optional`
--

INSERT INTO `optional` (`id`, `coloresedili`, `pollici`, `ariacond`, `sensoreparc`, `display`, `prezzo`) VALUES
(1, 'nero', 15, 1, 0, 0, 17050),
(2, 'nero', 15, 1, 1, 0, 22150),
(3, 'nero', 16, 1, 1, 1, 23150),
(16, 'alcantara', 16, 1, 0, 0, 48500),
(17, 'alcantara', 17, 1, 1, 0, 59900),
(18, 'alcantara', 18, 1, 1, 0, 60900),
(19, 'alcantara', 20, 1, 1, 1, 92000),
(28, 'grigio', 17, 1, 0, 0, 39400),
(29, 'grigio', 17, 1, 1, 0, 51050),
(30, 'grigio', 18, 1, 1, 0, 55350),
(31, 'grigio', 20, 1, 1, 1, 57200),
(32, 'nero', 17, 1, 0, 0, 22000),
(33, 'nero', 17, 1, 1, 0, 24900),
(34, 'nero', 18, 1, 1, 0, 30400),
(35, 'nero', 19, 1, 1, 1, 31600),
(36, 'nero', 16, 1, 0, 0, 43800),
(37, 'nero', 16, 1, 1, 0, 53100),
(38, 'nero', 17, 1, 1, 0, 58500),
(39, 'nero', 18, 1, 1, 1, 66800),
(40, 'nero', 17, 1, 1, 1, 99000),
(41, 'nero', 16, 1, 0, 0, 14450),
(42, 'nero', 16, 1, 1, 0, 16150),
(43, 'grigio', 16, 1, 0, 0, 35400),
(44, 'grigio', 17, 1, 1, 0, 37900);

-- --------------------------------------------------------

--
-- Struttura della tabella `preventivi`
--

CREATE TABLE `preventivi` (
  `codice` int(10) UNSIGNED NOT NULL,
  `emailutente` varchar(255) NOT NULL,
  `nomeauto` varchar(255) NOT NULL,
  `nomebrand` varchar(255) NOT NULL,
  `totale` int(10) UNSIGNED NOT NULL,
  `datacreazione` date NOT NULL,
  `idoptional` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `preventivi`
--

INSERT INTO `preventivi` (`codice`, `emailutente`, `nomeauto`, `nomebrand`, `totale`, `datacreazione`, `idoptional`) VALUES
(41, 'cazzinculo', 'Giulia', 'Alfa Romeo', 60900, '2021-05-30', 18),
(48, 'politi.1857617@studenti.uniroma1.it', 'Fiesta', 'Ford', 17050, '2021-06-03', 1),
(49, 'politi.1857617@studenti.uniroma1.it', 'Q3 Sportback', 'Audi', 57200, '2021-06-03', 31);

-- --------------------------------------------------------

--
-- Struttura della tabella `trasmissione`
--

CREATE TABLE `trasmissione` (
  `codicemotore` varchar(255) NOT NULL,
  `consumomotore` int(10) UNSIGNED NOT NULL,
  `tipotrazione` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `trasmissione`
--

INSERT INTO `trasmissione` (`codicemotore`, `consumomotore`, `tipotrazione`) VALUES
('AlGi1', 10, 'Posteriore'),
('AlGi2', 11, 'Posteriore'),
('AlGi3', 11, 'Posteriore'),
('AlGi4', 15, '4x4'),
('AuQ31', 9, 'Anteriore'),
('AuQ32', 10, '4x4'),
('AuQ33', 9, 'Anteriore'),
('AuQ34', 9, 'Anteriore'),
('AuQ35', 2, 'Anteriore'),
('BmZ41', 7, 'Posteriore'),
('BmZ42', 8, 'Posteriore'),
('CiC41', 0, 'Anteriore'),
('DaLo1', 4, 'Anteriore'),
('DaLo2', 5, 'Anteriore'),
('FoFi1', 5, 'Anteriore'),
('FoFi2', 6, 'Anteriore'),
('FoFi3', 5, 'Anteriore'),
('HoNs1', 11, '4x4'),
('HyKo1', 8, 'Anteriore'),
('HyKo2', 7, 'Anteriore');

-- --------------------------------------------------------

--
-- Struttura della tabella `trazione`
--

CREATE TABLE `trazione` (
  `tipo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `trazione`
--

INSERT INTO `trazione` (`tipo`) VALUES
('4x4'),
('Anteriore'),
('Posteriore');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `email` varchar(255) NOT NULL,
  `passw` varchar(255) NOT NULL,
  `npreventivi` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`email`, `passw`, `npreventivi`) VALUES
('cazzinculo', '$2y$10$mneEGMiCxz1LNykujOQ1ee0vGOt9MY57TacwEB6QQDj10CbBbjsfK', 0),
('grvfvgdege', '$2y$10$6vYjlRUe3q3bZrh5zBHdtubiu1XNbYzv5Q..AG72DiCifAzHQn2xK', 0),
('mirko', '$2y$10$j6bxRISgVh..FjSHY3/wUelIopJt50QvDSISWD8Y2mM39rtacc2bu', 0),
('mirko1', '$2y$10$KP.5D0hL4sqIrYXHXQyqx.z8RkYF32LzxbBYzkqAJCfQw45WQTYqW', 0),
('politi.1857617@studenti.uniroma1.it', '$2y$10$os38e7mYj75gqnd20SgZbuS8CCR6sH6f.MAN/D3rm5wl3YbNrcPwC', 0),
('sal', '$2y$10$VJG4vEqITpSdAHUq1u.KC.cTOdAKCVK6snqNcJJ18pLSwRpWWZHpm', 0),
('zanna', '$2y$10$c0E8jtMf.3HGT5dQ1EgUlO7SirCNH1icnb9RG7yO/L0YlQaHivcqC', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `valutazioni`
--

CREATE TABLE `valutazioni` (
  `id` int(10) UNSIGNED NOT NULL,
  `rating` int(10) UNSIGNED NOT NULL CHECK (`rating` >= 0 and `rating` <= 5)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `valutazioni`
--

INSERT INTO `valutazioni` (`id`, `rating`) VALUES
(1, 4),
(2, 4),
(3, 4),
(4, 3),
(5, 5),
(6, 5),
(7, 2),
(8, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `versione`
--

CREATE TABLE `versione` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `idcarrozzeria` int(10) UNSIGNED NOT NULL,
  `idoptional` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `versione`
--

INSERT INTO `versione` (`id`, `nome`, `idcarrozzeria`, `idoptional`) VALUES
(9, 'Titanium', 6, 1),
(10, 'ST-Line', 6, 2),
(11, 'Vignale', 6, 3),
(12, 'Business', 7, 16),
(13, 'Veloce', 7, 17),
(14, 'Sprint', 7, 18),
(15, 'Quadrifoglio', 7, 19),
(16, '35 TFSI', 8, 28),
(17, '40 TFSI Quattro S Tronic', 8, 29),
(18, '35 TDI', 8, 30),
(19, '35 TFSI S Tronic Business Plus', 8, 31),
(20, '45 TFSI S Tronic Business Plus', 8, 31),
(21, 'GDI 120 X-Tech', 9, 34),
(22, 'GDI 120 N-Line', 9, 35),
(23, 'sDrive20i', 10, 36),
(24, 'sDrive30i', 10, 38),
(25, 'M40i', 10, 39),
(26, '3.5L V6 DOHC', 11, 40),
(27, '1.5 Blue DCI 95cv ESSENTIAL 7p', 12, 41),
(28, '1.5 Blue DCI 115cv STEP SL Dacia Plus 7p', 12, 42),
(29, '100 kW 136CV Electric Feel', 13, 43),
(30, '100 kW 136CV Electric Shine', 13, 44);

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `view_alim`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `view_alim` (
`tipo` varchar(255)
);

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `view_cambio`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `view_cambio` (
`tipocambio` varchar(255)
);

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `view_cap`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `view_cap` (
`valore` int(10) unsigned
,`tipo` tinyint(1)
);

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `view_completa_mot`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `view_completa_mot` (
`id` int(10) unsigned
,`tipo` varchar(255)
,`carburante` varchar(255)
,`tipoibrido` varchar(255)
,`idcapacita` int(10) unsigned
,`codice` varchar(255)
,`consumo` int(10) unsigned
,`potenza` int(10) unsigned
,`cilindrata` int(10) unsigned
,`co2` int(10) unsigned
,`classe` varchar(255)
,`idalimentazione` int(10) unsigned
);

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `view_for_preventivi`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `view_for_preventivi` (
`modello` varchar(255)
,`brand` varchar(255)
,`peso` int(10) unsigned
,`velocita` int(10) unsigned
,`prezzolistino` int(10) unsigned
,`idvalutazione` int(10) unsigned
,`imageurl` varchar(255)
);

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `view_peso_vel`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `view_peso_vel` (
`peso` int(10) unsigned
,`velocita` int(10) unsigned
);

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `view_pot_cil_con`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `view_pot_cil_con` (
`potenza` int(10) unsigned
,`cilindrata` int(10) unsigned
,`consumo` int(10) unsigned
,`classe` varchar(255)
);

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `view_trazione`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `view_trazione` (
`tipotrazione` varchar(255)
);

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `view_ver_opt_pr`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `view_ver_opt_pr` (
`nome` varchar(255)
,`ariacond` tinyint(1)
,`sensoreparc` tinyint(1)
,`display` tinyint(1)
,`prezzo` int(11)
,`idoptional` int(10) unsigned
);

-- --------------------------------------------------------

--
-- Struttura per vista `avg_rating`
--
DROP TABLE IF EXISTS `avg_rating`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `avg_rating`  AS SELECT `valutazioni`.`rating` AS `rating` FROM `valutazioni` WHERE `valutazioni`.`id` in (select `automobili`.`idvalutazione` from `automobili` where lcase(`automobili`.`modello`) like '%fiesta%' AND lcase(`automobili`.`brand`) like '%ford%') ;

-- --------------------------------------------------------

--
-- Struttura per vista `view_alim`
--
DROP TABLE IF EXISTS `view_alim`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_alim`  AS SELECT DISTINCT `alimentazione`.`tipo` AS `tipo` FROM `alimentazione` WHERE `alimentazione`.`id` in (select `motori`.`idalimentazione` from `motori` where (`motori`.`codice`,`motori`.`consumo`) in (select `dotazione`.`codicemotore`,`dotazione`.`consumomotore` from `dotazione` where lcase(`dotazione`.`nomeauto`) like 'Fiesta' AND lcase(`dotazione`.`nomebrand`) like 'Ford')) ;

-- --------------------------------------------------------

--
-- Struttura per vista `view_cambio`
--
DROP TABLE IF EXISTS `view_cambio`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_cambio`  AS SELECT DISTINCT `meccanismo`.`tipocambio` AS `tipocambio` FROM `meccanismo` WHERE (`meccanismo`.`codicemotore`,`meccanismo`.`consumomotore`) in (select `dotazione`.`codicemotore`,`dotazione`.`consumomotore` from `dotazione` where lcase(`dotazione`.`nomeauto`) like 'Fiesta' AND lcase(`dotazione`.`nomebrand`) like 'Ford') ;

-- --------------------------------------------------------

--
-- Struttura per vista `view_cap`
--
DROP TABLE IF EXISTS `view_cap`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_cap`  AS SELECT `capacita`.`valore` AS `valore`, `capacita`.`tipo` AS `tipo` FROM `capacita` WHERE `capacita`.`id` in (select `alimentazione`.`idcapacita` from `alimentazione` where `alimentazione`.`id` in (select `motori`.`idalimentazione` from `motori` where (`motori`.`codice`,`motori`.`consumo`) in (select `dotazione`.`codicemotore`,`dotazione`.`consumomotore` from `dotazione` where lcase(`dotazione`.`nomeauto`) like 'Fiesta' AND lcase(`dotazione`.`nomebrand`) like 'Ford'))) ;

-- --------------------------------------------------------

--
-- Struttura per vista `view_completa_mot`
--
DROP TABLE IF EXISTS `view_completa_mot`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_completa_mot`  AS SELECT `alimentazione`.`id` AS `id`, `alimentazione`.`tipo` AS `tipo`, `alimentazione`.`carburante` AS `carburante`, `alimentazione`.`tipoibrido` AS `tipoibrido`, `alimentazione`.`idcapacita` AS `idcapacita`, `motori`.`codice` AS `codice`, `motori`.`consumo` AS `consumo`, `motori`.`potenza` AS `potenza`, `motori`.`cilindrata` AS `cilindrata`, `motori`.`co2` AS `co2`, `motori`.`classe` AS `classe`, `motori`.`idalimentazione` AS `idalimentazione` FROM (`alimentazione` join `motori` on(`alimentazione`.`id` = `motori`.`idalimentazione`)) WHERE (`motori`.`codice`,`motori`.`consumo`) in (select `dotazione`.`codicemotore`,`dotazione`.`consumomotore` from `dotazione` where lcase(`dotazione`.`nomeauto`) like 'Fiesta' AND lcase(`dotazione`.`nomebrand`) like 'Ford') ;

-- --------------------------------------------------------

--
-- Struttura per vista `view_for_preventivi`
--
DROP TABLE IF EXISTS `view_for_preventivi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_for_preventivi`  AS SELECT `automobili`.`modello` AS `modello`, `automobili`.`brand` AS `brand`, `automobili`.`peso` AS `peso`, `automobili`.`velocita` AS `velocita`, `automobili`.`prezzolistino` AS `prezzolistino`, `automobili`.`idvalutazione` AS `idvalutazione`, `automobili`.`imageurl` AS `imageurl` FROM `automobili` WHERE `automobili`.`prezzolistino` >= 0 AND `automobili`.`prezzolistino` <= 100000 AND (`automobili`.`modello`,`automobili`.`brand`) in (select `carrozzeria`.`nomeauto`,`carrozzeria`.`nomebrand` from `carrozzeria` where lcase(`carrozzeria`.`variante`) like '%%') AND (`automobili`.`modello`,`automobili`.`brand`) in (select `dotazione`.`nomeauto`,`dotazione`.`nomebrand` from `dotazione` where `dotazione`.`codicemotore` in (select `motori`.`codice` from `motori` where `motori`.`idalimentazione` in (select `alimentazione`.`id` from `alimentazione` where lcase(`alimentazione`.`carburante`) like '%%'))) AND lcase(`automobili`.`brand`) like '%%' AND (`automobili`.`modello`,`automobili`.`brand`) in (select `dotazione`.`nomeauto`,`dotazione`.`nomebrand` from `dotazione` where `dotazione`.`codicemotore` in (select `motori`.`codice` from `motori` where (`motori`.`codice`,`motori`.`consumo`) in (select `meccanismo`.`codicemotore`,`meccanismo`.`consumomotore` from `meccanismo` where lcase(`meccanismo`.`tipocambio`) like '%%'))) AND (`automobili`.`modello`,`automobili`.`brand`) in (select `dotazione`.`nomeauto`,`dotazione`.`nomebrand` from `dotazione` where `dotazione`.`codicemotore` in (select `motori`.`codice` from `motori` where (`motori`.`codice`,`motori`.`consumo`) in (select `trasmissione`.`codicemotore`,`trasmissione`.`consumomotore` from `trasmissione` where lcase(`trasmissione`.`tipotrazione`) like '%%'))) AND (`automobili`.`modello`,`automobili`.`brand`) in (select `dotazione`.`nomeauto`,`dotazione`.`nomebrand` from `dotazione` where `dotazione`.`codicemotore` in (select `motori`.`codice` from `motori` where `motori`.`potenza` >= 0 AND `motori`.`potenza` <= 1000)) ;

-- --------------------------------------------------------

--
-- Struttura per vista `view_peso_vel`
--
DROP TABLE IF EXISTS `view_peso_vel`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_peso_vel`  AS SELECT `automobili`.`peso` AS `peso`, `automobili`.`velocita` AS `velocita` FROM `automobili` WHERE lcase(`automobili`.`modello`) like 'Nuova ë-C4' AND lcase(`automobili`.`brand`) like 'Citroen' ;

-- --------------------------------------------------------

--
-- Struttura per vista `view_pot_cil_con`
--
DROP TABLE IF EXISTS `view_pot_cil_con`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_pot_cil_con`  AS SELECT `motori`.`potenza` AS `potenza`, `motori`.`cilindrata` AS `cilindrata`, `motori`.`consumo` AS `consumo`, `motori`.`classe` AS `classe` FROM `motori` WHERE (`motori`.`codice`,`motori`.`consumo`) in (select `dotazione`.`codicemotore`,`dotazione`.`consumomotore` from `dotazione` where lcase(`dotazione`.`nomeauto`) like 'Nuova ë-C4' AND lcase(`dotazione`.`nomebrand`) like 'Citroen') ;

-- --------------------------------------------------------

--
-- Struttura per vista `view_trazione`
--
DROP TABLE IF EXISTS `view_trazione`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_trazione`  AS SELECT DISTINCT `trasmissione`.`tipotrazione` AS `tipotrazione` FROM `trasmissione` WHERE (`trasmissione`.`codicemotore`,`trasmissione`.`consumomotore`) in (select `dotazione`.`codicemotore`,`dotazione`.`consumomotore` from `dotazione` where lcase(`dotazione`.`nomeauto`) like 'Fiesta' AND lcase(`dotazione`.`nomebrand`) like 'Ford') ;

-- --------------------------------------------------------

--
-- Struttura per vista `view_ver_opt_pr`
--
DROP TABLE IF EXISTS `view_ver_opt_pr`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_ver_opt_pr`  AS SELECT `versione`.`nome` AS `nome`, `optional`.`ariacond` AS `ariacond`, `optional`.`sensoreparc` AS `sensoreparc`, `optional`.`display` AS `display`, `optional`.`prezzo` AS `prezzo`, `versione`.`idoptional` AS `idoptional` FROM (`versione` join `optional` on(`versione`.`idoptional` = `optional`.`id`)) WHERE `optional`.`id` in (select `versione`.`idoptional` from `versione` where `versione`.`idcarrozzeria` in (select `carrozzeria`.`id` from `carrozzeria` where lcase(`carrozzeria`.`nomeauto`) like 'Fiesta' AND lcase(`carrozzeria`.`nomebrand`) like 'Ford')) ;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `alimentazione`
--
ALTER TABLE `alimentazione`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idcapacita` (`idcapacita`);

--
-- Indici per le tabelle `automobili`
--
ALTER TABLE `automobili`
  ADD PRIMARY KEY (`modello`,`brand`),
  ADD KEY `brand` (`brand`),
  ADD KEY `idvalutazione` (`idvalutazione`);

--
-- Indici per le tabelle `cambio`
--
ALTER TABLE `cambio`
  ADD PRIMARY KEY (`tipo`);

--
-- Indici per le tabelle `capacita`
--
ALTER TABLE `capacita`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `carrozzeria`
--
ALTER TABLE `carrozzeria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nomeauto` (`nomeauto`,`nomebrand`);

--
-- Indici per le tabelle `costruttori`
--
ALTER TABLE `costruttori`
  ADD PRIMARY KEY (`nome`);

--
-- Indici per le tabelle `dotazione`
--
ALTER TABLE `dotazione`
  ADD KEY `codicemotore` (`codicemotore`,`consumomotore`),
  ADD KEY `nomeauto` (`nomeauto`,`nomebrand`);

--
-- Indici per le tabelle `meccanismo`
--
ALTER TABLE `meccanismo`
  ADD PRIMARY KEY (`codicemotore`,`consumomotore`,`tipocambio`),
  ADD KEY `tipocambio` (`tipocambio`);

--
-- Indici per le tabelle `motori`
--
ALTER TABLE `motori`
  ADD PRIMARY KEY (`codice`,`consumo`),
  ADD KEY `idalimentazione` (`idalimentazione`);

--
-- Indici per le tabelle `optional`
--
ALTER TABLE `optional`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `preventivi`
--
ALTER TABLE `preventivi`
  ADD PRIMARY KEY (`codice`),
  ADD KEY `emailutente` (`emailutente`),
  ADD KEY `nomeauto` (`nomeauto`,`nomebrand`),
  ADD KEY `idoptional` (`idoptional`);

--
-- Indici per le tabelle `trasmissione`
--
ALTER TABLE `trasmissione`
  ADD PRIMARY KEY (`codicemotore`,`consumomotore`,`tipotrazione`),
  ADD KEY `tipotrazione` (`tipotrazione`);

--
-- Indici per le tabelle `trazione`
--
ALTER TABLE `trazione`
  ADD PRIMARY KEY (`tipo`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`email`);

--
-- Indici per le tabelle `valutazioni`
--
ALTER TABLE `valutazioni`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `versione`
--
ALTER TABLE `versione`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idcarrozzeria` (`idcarrozzeria`),
  ADD KEY `idoptional` (`idoptional`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `alimentazione`
--
ALTER TABLE `alimentazione`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT per la tabella `capacita`
--
ALTER TABLE `capacita`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT per la tabella `carrozzeria`
--
ALTER TABLE `carrozzeria`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT per la tabella `optional`
--
ALTER TABLE `optional`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT per la tabella `preventivi`
--
ALTER TABLE `preventivi`
  MODIFY `codice` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT per la tabella `valutazioni`
--
ALTER TABLE `valutazioni`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `versione`
--
ALTER TABLE `versione`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `alimentazione`
--
ALTER TABLE `alimentazione`
  ADD CONSTRAINT `alimentazione_ibfk_1` FOREIGN KEY (`idcapacita`) REFERENCES `capacita` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `automobili`
--
ALTER TABLE `automobili`
  ADD CONSTRAINT `automobili_ibfk_1` FOREIGN KEY (`brand`) REFERENCES `costruttori` (`nome`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `automobili_ibfk_2` FOREIGN KEY (`idvalutazione`) REFERENCES `valutazioni` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `carrozzeria`
--
ALTER TABLE `carrozzeria`
  ADD CONSTRAINT `carrozzeria_ibfk_1` FOREIGN KEY (`nomeauto`,`nomebrand`) REFERENCES `automobili` (`modello`, `brand`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `dotazione`
--
ALTER TABLE `dotazione`
  ADD CONSTRAINT `dotazione_ibfk_1` FOREIGN KEY (`codicemotore`,`consumomotore`) REFERENCES `motori` (`codice`, `consumo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dotazione_ibfk_2` FOREIGN KEY (`nomeauto`,`nomebrand`) REFERENCES `automobili` (`modello`, `brand`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `meccanismo`
--
ALTER TABLE `meccanismo`
  ADD CONSTRAINT `meccanismo_ibfk_1` FOREIGN KEY (`tipocambio`) REFERENCES `cambio` (`tipo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `meccanismo_ibfk_2` FOREIGN KEY (`codicemotore`,`consumomotore`) REFERENCES `motori` (`codice`, `consumo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `motori`
--
ALTER TABLE `motori`
  ADD CONSTRAINT `motori_ibfk_1` FOREIGN KEY (`idalimentazione`) REFERENCES `alimentazione` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `preventivi`
--
ALTER TABLE `preventivi`
  ADD CONSTRAINT `preventivi_ibfk_1` FOREIGN KEY (`emailutente`) REFERENCES `utenti` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `preventivi_ibfk_2` FOREIGN KEY (`nomeauto`,`nomebrand`) REFERENCES `automobili` (`modello`, `brand`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `preventivi_ibfk_3` FOREIGN KEY (`idoptional`) REFERENCES `optional` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `trasmissione`
--
ALTER TABLE `trasmissione`
  ADD CONSTRAINT `trasmissione_ibfk_1` FOREIGN KEY (`tipotrazione`) REFERENCES `trazione` (`tipo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `trasmissione_ibfk_2` FOREIGN KEY (`codicemotore`,`consumomotore`) REFERENCES `motori` (`codice`, `consumo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `versione`
--
ALTER TABLE `versione`
  ADD CONSTRAINT `versione_ibfk_1` FOREIGN KEY (`idcarrozzeria`) REFERENCES `carrozzeria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `versione_ibfk_2` FOREIGN KEY (`idoptional`) REFERENCES `optional` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
