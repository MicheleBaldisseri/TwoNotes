SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS Utenti;
DROP TABLE IF EXISTS Post;
DROP TABLE IF EXISTS NomeTag;
DROP TABLE IF EXISTS Tag;
DROP TABLE IF EXISTS Commenti;

CREATE TABLE Utenti (
       username VARCHAR(20) PRIMARY KEY,
       password CHAR(40) NOT NULL,
       nome VARCHAR(20) NOT NULL,
       cognome VARCHAR(20) NOT NULL,
       dataNascita DATE NOT NULL,
       email VARCHAR(30) NOT NULL,
       sesso ENUM('M','F') NOT NULL,
       provenienza VARCHAR(40),
       isAdmin BIT NOT NULL
) ENGINE=InnoDB;

CREATE TABLE Post (
       postID INTEGER PRIMARY KEY,
       titolo VARCHAR(30) NOT NULL,
       dataOra DATETIME NOT NULL,
       immagine LONGBLOB,
       altImmagine TEXT,
       contenuto TEXT,
       utente VARCHAR(20) NOT NULL,
       FOREIGN KEY (utente) REFERENCES Utenti(username) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE NomeTag (
       tipo INTEGER PRIMARY KEY,
       nome VARCHAR(20) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE Tag (
       postID INTEGER NOT NULL,
       tipo INTEGER NOT NULL,
       PRIMARY KEY (postID,tipo),
       FOREIGN KEY (postID) REFERENCES Post(postID) ON DELETE CASCADE ON UPDATE CASCADE,
       FOREIGN KEY (tipo) REFERENCES NomeTag(tipo) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE Commenti (
       commentoID INTEGER PRIMARY KEY,
       post INTEGER NOT NULL,
       utente VARCHAR(20) NOT NULL,
       uataOra DATETIME NOT NULL,
       contenuto TEXT NOT NULL,
       FOREIGN KEY (post) REFERENCES Post(postID) ON DELETE NO ACTION ON UPDATE NO ACTION,
       FOREIGN KEY (utente) REFERENCES Utenti(username) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO Utenti VALUES
('Lele97', 'michele2notes', 'Michele', 'Baldisseri', '1997-05-12', 'michele.baldi@gmail.com', 'M', 'San Pietro in Gu',0),
('Active', 'matthew2notes', 'Matthew', 'Balzan', '1999-06-11', 'matt.balzan@gmail.com', 'M', 'Crocetta del Montello',1);

INSERT INTO Post VALUES
('1', 'Nuova canzone Timmy Trumpet', '2020-12-01 22:08:56', 'NULL', 'NULL', 'Si chiama "Paul is dead". La sto ascoltando in loop su Spotify. Che bomba! Che ne pensate?', 'Lele97'),
('2', 'In cerca di consigli!', '2020-12-01 14:10:56', 'NULL', 'NULL','Ultimamente ascolto molto MOTi, consigli di canzoni simili a quelle sue?', 'Lele97'),
('3', 'Che ne pensate di Coez?', '2020-11-25 16:50:00', 'NULL', 'NULL','Ho iniziato ad apprezzare Coez, fino al mese scorso non lo consideravo... cosa pensate delle sue canzoni?', 'Active'),
('4', 'Sviluppatori pessimi', '2020-11-12 11:15:40', 'NULL', 'NULL','Avviso tutti che su Spotify e Youtube è disponibili il mio nuovo singolo! Passate parola!', 'Active');

INSERT INTO NomeTag VALUES
('1', 'New Artist'),
('2', 'Techno'),
('3', 'Rock'),
('4', 'New Song'),
('5', 'Trap'),
('6', 'Rap');

INSERT INTO Tag VALUES
('1', '4'),
('2', '2'),
('3', '6'),
('4', '1');

INSERT INTO Commenti VALUES
('1', '1', 'Lele97', '2020-12-01 22:10:11', 'Fantastica!'),
('2', '2', 'Active', '2020-12-01 14:15:37', 'Prova VIZE!'),
('3', '2', 'Lele97', '2020-12-01 14:40:11', 'Va bene lo ascolto subito, grazie!'),
('4', '3', 'Lele97', '2020-11-25 16:50:00', 'A me non piace per niente');

SET FOREIGN_KEY_CHECKS=1;


DROP TRIGGER IF EXISTS trig;

DELIMITER $$
CREATE TRIGGER trig AFTER INSERT ON Post FOR EACH ROW
BEGIN
IF new.Contenuto IS NULL AND new.Immagine IS NULL THEN
       SIGNAL SQLSTATE '45000'
       SET MESSAGE_TEXT = 'Errore: Impossibile inserire un post vuoto';
END IF;
END;
$$
DELIMITER ;


