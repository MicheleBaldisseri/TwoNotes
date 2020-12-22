-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 22, 2020 at 05:44 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

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
-- Table structure for table `commenti`
--

DROP TABLE IF EXISTS `commenti`;
CREATE TABLE IF NOT EXISTS `commenti` (
  `commentoID` int(11) NOT NULL AUTO_INCREMENT,
  `post` int(11) NOT NULL,
  `utente` varchar(20) COLLATE utf8_bin NOT NULL,
  `dataOra` datetime NOT NULL,
  `contenuto` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`commentoID`),
  KEY `post` (`post`),
  KEY `utente` (`utente`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `commenti`
--

INSERT INTO `commenti` (`commentoID`, `post`, `utente`, `dataOra`, `contenuto`) VALUES
(12, 17, 'admin', '2020-12-19 20:58:37', 'test è'),
(13, 17, 'admin', '2020-12-19 20:58:43', 'test ù'),
(14, 24, 'admin', '2020-12-19 23:29:31', 'test <abbr title=\"test\"> test </abbr>'),
(16, 24, 'admin', '2020-12-21 23:39:35', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `postID` int(11) NOT NULL AUTO_INCREMENT,
  `titolo` varchar(30) COLLATE utf8_bin NOT NULL,
  `dataOra` datetime NOT NULL,
  `immagine` text COLLATE utf8_bin,
  `altImmagine` text COLLATE utf8_bin,
  `contenuto` text COLLATE utf8_bin,
  `utente` varchar(20) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`postID`),
  KEY `utente` (`utente`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`postID`, `titolo`, `dataOra`, `immagine`, `altImmagine`, `contenuto`, `utente`) VALUES
(14, 'Sviluppatori pessimi', '2020-12-19 20:47:14', '1608407234Eepg1TsXoAAuTKf.jpg', 'Uomo che si fa domande leggendo un foglio', 'Avviso tutti che su Spotify e Youtube è disponibili il mio nuovo singolo! Passate parola!', 'user2'),
(15, 'Che ne pensate di Coez?', '2020-12-19 20:48:48', '1608407328fatRat.jpg', 'Ratto gigante', 'Ho iniziato ad apprezzare Coez, fino al mese scorso non lo consideravo... cosa pensate delle sue canzoni?', 'user'),
(16, 'In cerca di consigli!', '2020-12-19 20:49:13', '', '', 'Ultimamente ascolto molto MOTi, consigli di canzoni simili a quelle sue?', 'user'),
(17, 'Nuova canzone Timmy Trumpet ', '2020-12-19 20:50:32', '1608407432darlin_gabe-the-dog-fb.jpg', 'Cane felice', 'Si chiama \"Paul is dead\". La sto ascoltando in loop su Spotify. Che bomba! Che ne pensate?', 'user2'),
(18, 'afè', '2020-12-19 20:56:29', '', '', 'asdfè', 'admin'),
(19, 'test', '2020-12-19 20:56:45', '', '', 'test', 'admin'),
(20, 'test 2', '2020-12-19 20:56:59', '', '', 'test 2', 'admin'),
(22, 'test tags', '2020-12-19 22:53:39', '', '', '<span xml:lang=\"en\"> hello there </span>\r\n<abbr title=\"Fabbrica Italiana Automobili Torino\"> FIAT </abbr>', 'admin'),
(23, 'asdf', '2020-12-19 23:10:40', '', '', 'asdffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff asdfasdfsa', 'admin'),
(24, 'afsdf', '2020-12-19 23:11:31', '', '', 'fasdfasdfasdfkalshfkjahslfkdhfalskdhflaksjdfhlkashdflkashdflkahdfjkjhalskdfhalskdfhalksdfhlaksjfhlaskdfha12312321asflksh fksahflkajshdlfkasdhfkasldfkjah', 'admin');

--
-- Triggers `post`
--
DROP TRIGGER IF EXISTS `trig`;
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
-- Table structure for table `utenti`
--

DROP TABLE IF EXISTS `utenti`;
CREATE TABLE IF NOT EXISTS `utenti` (
  `username` varchar(20) COLLATE utf8_bin NOT NULL,
  `password` char(40) COLLATE utf8_bin NOT NULL,
  `nome` varchar(20) COLLATE utf8_bin NOT NULL,
  `cognome` varchar(20) COLLATE utf8_bin NOT NULL,
  `dataNascita` date NOT NULL,
  `email` varchar(30) COLLATE utf8_bin NOT NULL,
  `sesso` enum('M','F','A') COLLATE utf8_bin NOT NULL,
  `provenienza` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `isAdmin` bit(1) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `utenti`
--

INSERT INTO `utenti` (`username`, `password`, `nome`, `cognome`, `dataNascita`, `email`, `sesso`, `provenienza`, `isAdmin`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin', '1999-12-02', 'admin@gmail.com', 'A', 'Cornuda', b'1'),
('user', 'ee11cbb19052e40b07aac0ca060c23ee', 'Michele', 'Baldisseri', '1997-05-12', 'michele.baldi@gmail.com', 'M', 'San Pietro in Gu', b'0'),
('user2', '7e58d63b60197ceb55a1c487989a3720', 'Matthew', 'Balzan', '1999-06-11', 'matt.balzan@gmail.com', 'M', 'Crocetta del Montello', b'0');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commenti`
--
ALTER TABLE `commenti`
  ADD CONSTRAINT `commenti_ibfk_1` FOREIGN KEY (`post`) REFERENCES `post` (`postID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `commenti_ibfk_2` FOREIGN KEY (`utente`) REFERENCES `utenti` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`utente`) REFERENCES `utenti` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
