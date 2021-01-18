-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 18, 2021 at 06:37 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `commenti`
--

INSERT INTO `commenti` (`commentoID`, `post`, `utente`, `dataOra`, `contenuto`) VALUES
(18, 26, 'user2', '2021-01-06 16:45:35', 'Ciao! Ti consiglio un po di musica vecchio stile, come per esempio <span xml:lang=\"en\" lang=\"en\">Queen</span>, <span xml:lang=\"en\" lang=\"en\">Pink Floyd</span>... Insomma i classici che non passano mai di moda!'),
(19, 27, 'user2', '2021-01-07 15:53:48', 'Woo fantastica!'),
(20, 27, 'user', '2021-01-07 16:00:15', 'L\'ho ascoltata pure io, sinceramente non mi fa impazzire...'),
(21, 28, 'user2', '2021-01-07 16:05:16', 'Noo! Avevo già preso i biglietti... Che delusione'),
(22, 28, 'user3', '2021-01-07 16:07:34', 'Ma si sa il <abbr title=\"perchè\">pk</abbr>?'),
(23, 29, 'admin', '2021-01-11 22:01:38', '<span xml:lang=\"en\" lang=\"en\">No one?</span>'),
(25, 29, 'user2', '2021-01-11 22:04:42', 'Mi <abbr title=\"Dispiace\">dsp</abbr>, mai sentita.'),
(26, 29, 'user3', '2021-01-11 22:07:32', 'Sai dire di che genere è?'),
(27, 29, 'user4', '2021-01-11 22:09:55', 'Io lo so: è pop!'),
(28, 30, 'user2', '2021-01-11 22:14:34', 'Prova questa: <span xml:lang=\"en\" lang=\"en\">Someone to you</span>'),
(29, 30, 'user2', '2021-01-11 22:16:36', 'Ah dimenticavo questa, è bellissima: <span xml:lang=\"en\" lang=\"en\">Perfect</span>, è di <span xml:lang=\"en\" lang=\"en\">Ed sheeran</span>'),
(30, 31, 'user3', '2021-01-11 22:21:58', 'Eh dai, ce ne sono una marea, ti suggerisco <span xml:lang=\"en\" lang=\"en\">Smile</span> che è il più recente'),
(31, 31, 'user2', '2021-01-11 22:23:26', '<abbr title=\"Grazie\">Grz</abbr> mille, lo ascolto subito'),
(32, 32, 'user2', '2021-01-11 22:27:01', 'Mi dispiace, a me non piace tanto il <span xml:lang=\"en\" lang=\"en\">rock</span>, non posso aiutarti'),
(33, 32, 'user4', '2021-01-11 22:28:01', 'Che ne dici di partire dagli AC/DC?'),
(34, 33, 'user3', '2021-01-11 22:30:48', 'Assolutamente no! Per la musica classica meglio una chitarra classica'),
(35, 33, 'user2', '2021-01-11 22:31:37', 'Concordo'),
(36, 34, 'user3', '2021-01-11 22:36:50', 'Di italiani ci sono <abbr title=\"Giacomo Puccini\">Puccini</abbr>, <abbr title=\"Antonio Vivaldi\">Vivaldi</abbr>,<abbr title=\"Giuseppe Verdi\"> Verdi</abbr>...'),
(37, 34, 'user2', '2021-01-11 22:39:11', 'E di inglese c\'è <span xml:lang=\"en\" lang=\"en\">George Frideric Handel</span>'),
(38, 34, 'user4', '2021-01-11 22:39:51', 'Wow! Non pensavo ce ne fossero così tanti'),
(39, 36, 'user3', '2021-01-11 22:54:23', 'Sarebbe meglio capire bene cosa intendi per rilassarti, cioè la ascolti mentre corri, dormi, fai ginnastica, dipende...'),
(42, 36, 'user2', '2021-01-11 22:58:30', 'Secondo me basta che vai su <span xml:lang=\"en\" lang=\"en\">Spotify</span> e cerchi musica per rilassarsi'),
(43, 36, 'user2', '2021-01-11 23:05:10', 'Io per rilassarmi ascolto I Metallica, so che sono strano ma mi piacciono un sacco'),
(44, 26, 'user3', '2021-01-09 16:53:56', 'Mi è capitato di essere nella tua stessa situazione, ti consiglio di scorrere nella <span xml:lang=\"en\" lang=\"en\">home</span> di <span xml:lang=\"en\" lang=\"en\">YouTube</span>, si trovano sempre ottime nuove uscite!'),
(45, 40, 'user2', '2021-01-09 18:17:00', 'Ciao! Per iniziare almeno un giradischi :-)'),
(46, 40, 'user3', '2021-01-09 18:17:33', 'Certo certo, quello non manca!'),
(47, 40, 'user2', '2021-01-10 17:00:48', 'Dipende che genere ti piace ovviamente!'),
(48, 40, 'user2', '2021-01-10 17:01:32', 'Tutti i generi al giorno d’oggi hanno il formato vinile...'),
(49, 35, 'user3', '2021-01-13 13:01:41', 'Grande Ed, inimitabile!'),
(50, 35, 'user2', '2021-01-13 13:06:09', 'Ti consiglio Shawn Mendes, Bruno Mars e John Legend!'),
(51, 32, 'user3', '2021-01-13 13:09:45', 'Per dire... Io ascolto <span xml:lang=\"en\">GreenDay</span>, <span xml:lang=\"en\">Sum41</span>.\r\nSicuramente ora ascolterò di più gli <span xml:lang=\"en\">AC/DC</span>!!'),
(52, 31, 'user3', '2021-01-13 13:11:17', 'Ora mi è balzato in mente! di Katy Perry ascoltavo molto <span xml:lang=\"en\">Teenage Dream</span>, buttaci un occhio!'),
(53, 29, 'user3', '2021-01-13 13:20:46', 'Rimarrà un mistero...'),
(54, 30, 'user3', '2021-01-13 13:21:57', '<span xml:lang=\"en\">Disturbia</span> di Rihanna!'),
(55, 30, 'user3', '2021-01-13 13:27:30', 'Poi ti consiglio lo stesso un po\' di canzoni in voga ultimamente, come <span xml:lang=\"en\">Holiday</span>, oppure se ti piace la <span xml:lang=\"en\">trap</span> prova con Sfera Ebbasta che va molto ultimamente!'),
(56, 39, 'user3', '2021-01-13 13:28:14', 'Concordo!'),
(57, 36, 'user4', '2021-01-13 13:29:15', 'Per rilassarmi intendo starmene tranquillo sul divano, ma sicuramente non facendo attività fisica');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `postID` int(11) NOT NULL AUTO_INCREMENT,
  `titolo` text COLLATE utf8_bin NOT NULL,
  `dataOra` datetime NOT NULL,
  `immagine` text COLLATE utf8_bin,
  `altImmagine` text COLLATE utf8_bin,
  `contenuto` text COLLATE utf8_bin,
  `utente` varchar(20) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`postID`),
  KEY `utente` (`utente`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`postID`, `titolo`, `dataOra`, `immagine`, `altImmagine`, `contenuto`, `utente`) VALUES
(14, 'Sviluppatori pessimi', '2020-12-19 20:47:14', '1608407234Eepg1TsXoAAuTKf.jpg', 'Uomo che si fa domande leggendo un foglio', 'Avviso tutti che su <span xml:lang=\"en\" lang=\"en\">Spotify</span> e <span xml:lang=\"en\" lang=\"en\">Youtube</span> è disponibili il mio nuovo singolo! Passate parola!', 'user2'),
(15, 'Che ne pensate di Coez?', '2020-12-19 20:48:48', '', '', 'Ho iniziato ad apprezzare Coez, fino al mese scorso non lo consideravo... cosa pensate delle sue canzoni?', 'user'),
(16, 'In cerca di consigli!', '2020-12-19 20:49:13', '', '', 'Ultimamente ascolto molto MOTi, consigli di canzoni simili a quelle sue?', 'user'),
(17, 'Nuova canzone <span xml:lang=\"en\" lang=\"en\">Timmy Trumpet</span> ', '2020-12-19 20:50:32', '1608407432darlin_gabe-the-dog-fb.jpg', 'Cane felice che abbaia', 'Si chiama <span xml:lang=\"en\" lang=\"en\">\"Paul is dead\"</span>. La sto ascoltando in <span xml:lang=\"en\" lang=\"en\">loop</span> su <span xml:lang=\"en\" lang=\"en\">Spotify</span> . Che bomba! Che ne pensate?', 'user2'),
(26, 'Blocco musicale!', '2021-01-06 16:18:58', '', '', 'Aiuto, ho un blocco musicale e un infinito bisogno di nuova musica!', 'user'),
(27, 'Blinding Lights', '2021-01-07 15:53:22', '', '', 'Ragazzi ascoltate assolutamente questa canzone dei <span xml:lang=\"en\" lang=\"en\">The Weekend</span>! Bellissima!', 'user3'),
(28, 'Home NEWS', '2021-01-07 16:04:23', '1610031863download.png', 'Scritta bianca Home su sfondo rosso', 'Sono stati cancellati i concerti dell’Home Festival più attesi dell’edizione e i fan non ci vedono chiaro.\r\nVoi cosa ne pensate?', 'user'),
(29, 'Nuova musica:<span xml:lang=\"en\" lang=\"en\">My town</span>!', '2021-01-11 22:00:56', '', '', 'Ciao a tutti, ho ascoltato questa nuova musica, qualcuno sa di che gruppo o banda sia?', 'admin'),
(30, 'Nuove musiche inglesi?', '2021-01-11 22:13:08', '', '', 'Sento sempre le solite musiche come <span xml:lang=\"en\" lang=\"en\">Fireworks</span>, <span xml:lang=\"en\">Diamonds</span> ecc. Qualcuno che me ne suggerisce una?', 'user4'),
(31, 'Katty Perry', '2021-01-11 22:19:38', '1610399978220px-Katy_Perry_-_One_of_the_Boys.png', 'cover dell\'albrum con l\'artista sdraiata nel prato di un giardino', 'Ciao, qualcuno conosce altri album di questa artista?', 'user4'),
(32, '<span xml:lang=\"en\">Rock for me</span>', '2021-01-11 22:26:15', '', '', 'Salve, ammetto di non conoscere molto su queste cose ma ultimamente mi piace la musica <span xml:lang=\"en\" lang=\"en\">Rock</span> quindi chiedo a tutti se avete gruppi/canzoni o altro da dirmi su questo', 'user3'),
(33, 'Chitarre', '2021-01-11 22:30:06', '1610400606preview_2.jpg', 'Chitarra elettrica', 'So che di solito qui si parla di musica e basta ma secondo me c\'entra: Per la musica classica mi consigliate questo tipo di chitarra o altro?', 'user4'),
(34, 'Musica classica', '2021-01-11 22:34:24', '1610400864musica-classica-famosa-piano-e-violino.jpg', 'Violino adagiato sulle note di un pianoforte', 'Ecco qua, io di musica classica conosco solo Mozart e <span xml:lang=\"en\" lang=\"en\">Beethoven</span>, che altri compositori ci sono?', 'user4'),
(35, '<span xml:lang=\"en\" lang=\"en\">Ed Sheeran</span>', '2021-01-11 22:41:55', '1610401315ed.jpg', 'Uomo con capelli rossi e occhi azzurri, vestito con una giacca nera', 'Ho ascoltato questo artista, consigli su musica simile?', 'user4'),
(36, 'Rilassamento', '2021-01-11 22:53:00', '', '', 'Ciao, sono alla ricerca di musica per rilassarmi, idee?', 'user4'),
(38, 'Sempre meno!', '2021-01-09 17:07:01', '1610208421unnamed.gif', 'Immagine animata raffigurante un chitarrista metal', 'Non vedo l\'ora, manca sempre meno al concerto della mia <span xml:lang=\"en\" lang=\"en\">band</span>!!', 'user2'),
(39, '<span xml:lang=\"en\" lang=\"en\">BEST RAP ALBUM</span>', '2021-01-09 17:28:29', '161020970961xUhLOdFXL._AC_SL1069_.jpg', 'Cover raffigurante il volto dell\'artista coperto dall\'ombra di un bambino', 'Lo ripeto: <span xml:lang=\"en\" lang=\"en\">Marracash</span> piace perché è bravo, e Persona indiscutibilmente uno dei dischi rap di maggior spessore usciti negli ultimi dieci anni.', 'user2'),
(40, 'Acquisto di un vinile?', '2021-01-09 18:12:15', '', '', 'Sarei interessato ad immergermi nel mondo dei vinili, ma non so proprio da dove iniziare o da che album acquistare...\r\nVoi che suggerite?', 'user3'),
(41, 'Qualcuno sa dirmi cosa è <abbr title=\"Attacco Decadimento Sostegno Rilascio\">ADSR</abbr>?', '2021-01-11 22:37:28', '', '', 'Ho una lezione di musica domani e devo assolutamente saperlo.\r\nSto impazzendo, aiutatemi <span xml:lang=\"en\" lang=\"en\">please</span>!', 'user');

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
  `isAdmin` bit(1) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `utenti`
--

INSERT INTO `utenti` (`username`, `password`, `nome`, `cognome`, `dataNascita`, `email`, `sesso`, `isAdmin`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin', '1999-12-02', 'admin@gmail.com', 'F', b'1'),
('user', 'ee11cbb19052e40b07aac0ca060c23ee', 'Michele', 'Baldisseri', '1997-05-12', 'michele.baldi@gmail.com', 'M', b'0'),
('user2', '7e58d63b60197ceb55a1c487989a3720', 'Matthew', 'Balzan', '1999-06-11', 'matt.balzan@gmail.com', 'M', b'0'),
('user3', '92877af70a45fd6a2ed7fe81e1236b78', 'Giulio', 'Zanatta', '1998-01-02', 'giuliozanatta98@gmail.com', 'M', b'0'),
('user4', '3f02ebe3d7929b091e3d8ccfde2f3bc6', 'Stefano', 'Dal Poz', '1997-10-06', 'dalpoz01@gmail.com', 'M', b'0');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commenti`
--
ALTER TABLE `commenti`
  ADD CONSTRAINT `commenti_ibfk_1` FOREIGN KEY (`post`) REFERENCES `post` (`postID`) ON DELETE CASCADE ON UPDATE CASCADE,
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
