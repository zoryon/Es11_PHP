-- DATABASE

-- Creazione del database "concerti"
CREATE DATABASE IF NOT EXISTS concerti;

-- Selezione del database "concerti"
USE concerti;

-- Creazione della tabella persona
CREATE TABLE persona (
  cf VARCHAR(16) PRIMARY KEY,
  nome VARCHAR(255) NOT NULL,
  cognome VARCHAR(255) NOT NULL
);

-- Creazione della tabella autore
CREATE TABLE autore (
  cf VARCHAR(16) PRIMARY KEY,
  FOREIGN KEY (cf) REFERENCES persona(cf)
);

-- Creazione della tabella direttore
CREATE TABLE direttore (
  cf VARCHAR(16) PRIMARY KEY,
  FOREIGN KEY (cf) REFERENCES persona(cf)
);

-- Creazione della tabella orchestrale
CREATE TABLE orchestrale (
  cf VARCHAR(16) PRIMARY KEY,
  FOREIGN KEY (cf) REFERENCES persona(cf)
);

-- Creazione della tabella sala
CREATE TABLE sala (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(255) NOT NULL
);

-- Creazione della tabella orchestra
CREATE TABLE orchestra (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(255) NOT NULL,
  idDirettore VARCHAR(16),
  FOREIGN KEY (idDirettore) REFERENCES direttore(cf)
);

-- Creazione della tabella concerti
CREATE TABLE concerti (
  id INT PRIMARY KEY AUTO_INCREMENT,
  salaID INT,
  descrizione TEXT,
  titolo VARCHAR(255) NOT NULL,
  data DATE NOT NULL,
  idOrchestra INT,
  FOREIGN KEY (salaID) REFERENCES sala(id),
  FOREIGN KEY (idOrchestra) REFERENCES orchestra(id)
);

-- Creazione della tabella pezzo
CREATE TABLE pezzo (
  id INT PRIMARY KEY AUTO_INCREMENT,
  titolo VARCHAR(255) NOT NULL,
  annoRilascio INT
);

-- Creazione della tabella orchestrali_orchestra (tabella di relazione molti-a-molti)
CREATE TABLE orchestrali_orchestra (
  idOrchestra INT,
  idOrchestrale VARCHAR(16),
  FOREIGN KEY (idOrchestra) REFERENCES orchestra(id),
  FOREIGN KEY (idOrchestrale) REFERENCES orchestrale(cf),
  PRIMARY KEY (idOrchestra, idOrchestrale)
);

-- Creazione della tabella concerto_pezzi (tabella di relazione molti-a-molti)
CREATE TABLE concerto_pezzi (
  idConcerto INT,
  idPezzo INT,
  FOREIGN KEY (idConcerto) REFERENCES concerti(id),
  FOREIGN KEY (idPezzo) REFERENCES pezzo(id),
  PRIMARY KEY (idConcerto, idPezzo)
);

-- Creazione della tabella strumenti
CREATE TABLE strumenti (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(255) NOT NULL,
  tipo VARCHAR(255)
);

-- Creazione della tabella orchestrale_strumenti (tabella di relazione molti-a-molti)
CREATE TABLE orchestrale_strumenti (
  cfOrchestrale VARCHAR(16),
  idStrumento INT,
  FOREIGN KEY (cfOrchestrale) REFERENCES orchestrale(cf),
  FOREIGN KEY (idStrumento) REFERENCES strumenti(id),
  PRIMARY KEY (cfOrchestrale, idStrumento)
);

-- Creazione della tabella autore_pezzo (tabella di relazione molti-a-molti)
CREATE TABLE autore_pezzo (
  cfAutore VARCHAR(16),
  idPezzo INT,
  FOREIGN KEY (cfAutore) REFERENCES autore(cf),
  FOREIGN KEY (idPezzo) REFERENCES pezzo(id),
  PRIMARY KEY (cfAutore, idPezzo)
);

-- Creazione della tabella utenti
CREATE TABLE utenti (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) UNIQUE,
    password VARCHAR(255)
);

-- Creazione della tabella admin (discende da utenti)
CREATE TABLE admin (
    id INT PRIMARY KEY,
    FOREIGN KEY(id) REFERENCES utenti(id)
);





-- INSERT
-- Selezione del database "concerti" (assicurati di essere nel database corretto)
USE concerti;

-- Inserimento di dati nella tabella persona
INSERT INTO persona (cf, nome, cognome) VALUES
('RSSMRO80A01H501X', 'Mario', 'Rossi'),
('SNDGNN75B02Z112Y', 'Giovanni', 'Sanna'),
('FNCVCN90T03A001K', 'Vincenzo', 'Falcone'),
('LZZLSE82M04L219Q', 'Luisa', 'Lazzari'),
('BRNGNN68D05G001F', 'Anna', 'Bruni');

-- Inserimento di dati nella tabella autore
INSERT INTO autore (cf) VALUES
('RSSMRO80A01H501X'),
('SNDGNN75B02Z112Y'),
('FNCVCN90T03A001K');

-- Inserimento di dati nella tabella direttore
INSERT INTO direttore (cf) VALUES
('LZZLSE82M04L219Q'),
('BRNGNN68D05G001F');

-- Inserimento di dati nella tabella orchestrale
INSERT INTO orchestrale (cf) VALUES
('RSSMRO80A01H501X'),
('SNDGNN75B02Z112Y'),
('FNCVCN90T03A001K'),
('LZZLSE82M04L219Q'),
('BRNGNN68D05G001F');

-- Inserimento di dati nella tabella sala
INSERT INTO sala (nome) VALUES
('Teatro alla Scala'),
('Auditorium Parco della Musica'),
('Musikverein'),
('Carnegie Hall'),
('Sydney Opera House');

-- Inserimento di dati nella tabella orchestra
INSERT INTO orchestra (nome, idDirettore) VALUES
('Orchestra Filarmonica della Scala', 'LZZLSE82M04L219Q'),
('Orchestra dell''Accademia Nazionale di Santa Cecilia', 'BRNGNN68D05G001F'),
('Wiener Philharmoniker', 'LZZLSE82M04L219Q'),
('New York Philharmonic', 'BRNGNN68D05G001F'),
('London Symphony Orchestra', 'LZZLSE82M04L219Q');

-- Inserimento di dati nella tabella concerti
INSERT INTO concerti (salaID, descrizione, titolo, data, idOrchestra) VALUES
(1, 'Concerto di apertura stagione', 'La Traviata', '2024-03-15', 1),
(2, 'Concerto sinfonico', 'Sinfonia n. 5 di Beethoven', '2024-04-20', 2),
(3, 'Concerto speciale di Natale', 'Il Messia di Händel', '2023-12-22', 3),
(4, 'Gala lirico', 'Arie famose', '2024-05-10', 4),
(5, 'Concerto per giovani', 'Pierino e il lupo', '2024-06-05', 5);

-- Inserimento di dati nella tabella pezzo
INSERT INTO pezzo (titolo, annoRilascio) VALUES
('La Traviata', 1853),
('Sinfonia n. 5', 1808),
('Il Messia', 1741),
('Aida', 1871),
('Carmina Burana', 1936);

-- Inserimento di dati nella tabella orchestrali_orchestra
INSERT INTO orchestrali_orchestra (idOrchestra, idOrchestrale) VALUES
(1, 'RSSMRO80A01H501X'),
(1, 'SNDGNN75B02Z112Y'),
(2, 'FNCVCN90T03A001K'),
(2, 'LZZLSE82M04L219Q'),
(3, 'BRNGNN68D05G001F');

-- Inserimento di dati nella tabella concerto_pezzi
INSERT INTO concerto_pezzi (idConcerto, idPezzo) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);

-- Inserimento di dati nella tabella strumenti
INSERT INTO strumenti (nome, tipo) VALUES
('Violino', 'Archi'),
('Flauto', 'Fiati'),
('Tromba', 'Ottoni'),
('Pianoforte', 'Tastiera'),
('Batteria', 'Percussioni');

-- Inserimento di dati nella tabella orchestrale_strumenti
INSERT INTO orchestrale_strumenti (cfOrchestrale, idStrumento) VALUES
('RSSMRO80A01H501X', 1),
('SNDGNN75B02Z112Y', 2),
('FNCVCN90T03A001K', 3),
('LZZLSE82M04L219Q', 4),
('BRNGNN68D05G001F', 5);

-- Inserimento di dati nella tabella autore_pezzo
INSERT INTO autore_pezzo (cfAutore, idPezzo) VALUES
('RSSMRO80A01H501X', 1),
('SNDGNN75B02Z112Y', 2),
('FNCVCN90T03A001K', 3);

--Inserimento di dati nella tabella utenti
INSERT INTO utenti(username, password) VALUES("gioele", "$2y$10$AuHPe0jkssGMaRJA6mCOYeC.6GxjsQqmRboUGHUr3WNeD.FmVaFai");

--Inserimento di dati nella tabella admin
INSERT INTO admin(id) VALUES(1);