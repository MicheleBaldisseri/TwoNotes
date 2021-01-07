-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 07, 2021 alle 16:21
-- Versione del server: 10.4.17-MariaDB
-- Versione PHP: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `twonotes`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `commenti`
--

CREATE TABLE `commenti` (
  `commentoID` int(11) NOT NULL,
  `post` int(11) NOT NULL,
  `utente` varchar(20) COLLATE utf8_bin NOT NULL,
  `dataOra` datetime NOT NULL,
  `contenuto` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `commenti`
--

INSERT INTO `commenti` (`commentoID`, `post`, `utente`, `dataOra`, `contenuto`) VALUES
(17, 17, 'admin', '2020-12-22 21:16:11', 'test'),
(18, 26, 'user2', '2021-01-06 16:45:35', 'Ciao! Ti consiglio un po di musica vecchio stile, come per esempio <span xml:lang=\"en\">Queen</span>, <span xml:lang=\"en\">Pink Floyd</span>... Insomma i classici che non passano mai di moda!'),
(19, 27, 'user2', '2021-01-07 15:53:48', 'Woo fantastica!'),
(20, 27, 'user', '2021-01-07 16:00:15', 'L\'ho ascoltata pure io, sinceramente non mi fa impazzire...'),
(21, 28, 'user2', '2021-01-07 16:05:16', 'Noo! Avevo già preso i biglietti... Che delusione'),
(22, 28, 'user3', '2021-01-07 16:07:34', 'Ma si sa il <abbr title=\"perchè\">pk</abbr>?');

-- --------------------------------------------------------

--
-- Struttura della tabella `post`
--

CREATE TABLE `post` (
  `postID` int(11) NOT NULL,
  `titolo` text COLLATE utf8_bin NOT NULL,
  `dataOra` datetime NOT NULL,
  `immagine` text COLLATE utf8_bin DEFAULT NULL,
  `altImmagine` text COLLATE utf8_bin DEFAULT NULL,
  `contenuto` text COLLATE utf8_bin DEFAULT NULL,
  `utente` varchar(20) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `post`
--

INSERT INTO `post` (`postID`, `titolo`, `dataOra`, `immagine`, `altImmagine`, `contenuto`, `utente`) VALUES
(14, 'Sviluppatori pessimi', '2020-12-19 20:47:14', '1608407234Eepg1TsXoAAuTKf.jpg', 'Uomo che si fa domande leggendo un foglio', 'Avviso tutti che su Spotify e Youtube è disponibili il mio nuovo singolo! Passate parola!', 'user2'),
(15, 'Che ne pensate di Coez?', '2020-12-19 20:48:48', '1608407328fatRat.jpg', 'Ratto gigante', 'Ho iniziato ad apprezzare Coez, fino al mese scorso non lo consideravo... cosa pensate delle sue canzoni?', 'user'),
(16, 'In cerca di consigli!', '2020-12-19 20:49:13', '', '', 'Ultimamente ascolto molto MOTi, consigli di canzoni simili a quelle sue?', 'user'),
(17, 'Nuova canzone Timmy Trumpet ', '2020-12-19 20:50:32', '1608407432darlin_gabe-the-dog-fb.jpg', 'Cane felice', 'Si chiama \"Paul is dead\". La sto ascoltando in loop su Spotify. Che bomba! Che ne pensate?', 'user2'),
(26, 'Blocco musicale!', '2021-01-06 16:18:58', '', '', 'Aiuto, ho un blocco musicale e un infinito bisogno di nuova musica!', 'user'),
(27, 'Blinding Lights', '2021-01-07 15:53:22', '', '', 'Ragazzi ascoltate assolutamente questa canzone dei <span xml:lang=\"en\">The Weekend</span>! Bellissima!', 'user3'),
(28, 'Home NEWS', '2021-01-07 16:04:23', '1610031863download.png', 'Scritta bianca [en]Home[/en] su sfondo rosso', 'Sono stati cancellati i concerti dell’Home Festival più attesi dell’edizione e i fan non ci vedono chiaro.\r\nVoi cosa ne pensate?', 'user');

--
-- Trigger `post`
--
DELIMITER $$
CREATE TRIGGER `trig` AFTER INSERT ON `post` FOR EACH ROW BEGIN
IF new.Contenuto IS NULL AND new.Immagine IS NULL THEN
       SIGNAL SQLSTATE '45000'
       SET MESSAGE_TEXT = 'Errore: Impossibile inserire un post vuoto';
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `username` varchar(20) COLLATE utf8_bin NOT NULL,
  `password` char(40) COLLATE utf8_bin NOT NULL,
  `nome` varchar(20) COLLATE utf8_bin NOT NULL,
  `cognome` varchar(20) COLLATE utf8_bin NOT NULL,
  `dataNascita` date NOT NULL,
  `email` varchar(30) COLLATE utf8_bin NOT NULL,
  `sesso` enum('M','F','A') COLLATE utf8_bin NOT NULL,
  `provenienza` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `isAdmin` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`username`, `password`, `nome`, `cognome`, `dataNascita`, `email`, `sesso`, `provenienza`, `isAdmin`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin', '1999-12-02', 'admin@gmail.com', 'A', 'Cornuda', b'1'),
('user', 'ee11cbb19052e40b07aac0ca060c23ee', 'Michele', 'Baldisseri', '1997-05-12', 'michele.baldi@gmail.com', 'M', 'San Pietro in Gu', b'0'),
('user2', '7e58d63b60197ceb55a1c487989a3720', 'Matthew', 'Balzan', '1999-06-11', 'matt.balzan@gmail.com', 'M', 'Crocetta del Montello', b'0'),
('user3', '92877af70a45fd6a2ed7fe81e1236b78', 'Giulio', 'Zanatta', '1998-01-02', 'giuliozanatta98@gmail.com', 'M', 'Treviso', b'0');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `commenti`
--
ALTER TABLE `commenti`
  ADD PRIMARY KEY (`commentoID`),
  ADD KEY `post` (`post`),
  ADD KEY `utente` (`utente`);

--
-- Indici per le tabelle `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`postID`),
  ADD KEY `utente` (`utente`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `commenti`
--
ALTER TABLE `commenti`
  MODIFY `commentoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT per la tabella `post`
--
ALTER TABLE `post`
  MODIFY `postID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `commenti`
--
ALTER TABLE `commenti`
  ADD CONSTRAINT `commenti_ibfk_1` FOREIGN KEY (`post`) REFERENCES `post` (`postID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commenti_ibfk_2` FOREIGN KEY (`utente`) REFERENCES `utenti` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`utente`) REFERENCES `utenti` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
