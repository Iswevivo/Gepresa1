DROP DATABASE IF EXISTS gepresa;
CREATE DATABASE IF NOT EXISTS gepresa;
USE gepresa;

CREATE TABLE Users(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL DEFAULT '$2y$10$KnveUf603r45ryHSPudwQuTTYIP5NhaK8x.VBuIy62rAZQFbeXMBe',
    role VARCHAR(25) NOT NULL,
    statut BOOLEAN DEFAULT FALSE
);

CREATE TABLE Sections(
    id INT NOT NULL PRIMARY KEY,
    designation VARCHAR(255) NOT NULL,
    sigle VARCHAR(10) NOT NULL UNIQUE,
    FOREIGN KEY(id) REFERENCES Users(id) ON DELETE CASCADE
);

CREATE TABLE Departements(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(255) NOT NULL,
    sigle VARCHAR(10) NOT NULL UNIQUE,
    section_ID INT NOT NULL,
    FOREIGN KEY(section_ID) REFERENCES Sections(id)
);

CREATE TABLE Promotions(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    designation VARCHAR(10) NOT NULL,
    departement_ID INT NOT NULL,
    FOREIGN KEY(departement_ID) REFERENCES Departements(id)
);

CREATE TABLE Jury(
    id INT NOT NULL PRIMARY KEY,
    promotion_ID INT NOT NULL UNIQUE,
    president VARCHAR(50) NOT NULL,
    sec1 VARCHAR(50) NOT NULL,
    sec2 VARCHAR(50) NOT NULL,
    membre VARCHAR(50) NOT NULL,
    FOREIGN KEY(promotion_ID) REFERENCES Promotions(id),
    FOREIGN KEY(id) REFERENCES Users(id) ON DELETE CASCADE
);

CREATE TABLE Etudiants(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    matricule VARCHAR(10) NOT NULL UNIQUE,
    nom VARCHAR(25) NOT NULL,
    postnom VARCHAR(25) NOT NULL,
    prenom VARCHAR(25) NOT NULL,
    sexe CHAR(1) NOT NULL,
    photo VARCHAR(255) NOT NULL,
    cardUID VARCHAR(20) NOT NULL,
    promotion_ID INT NOT NULL,
    FOREIGN KEY(promotion_ID) REFERENCES Promotions(id)
);

CREATE TABLE typeEvaluation(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    designation VARCHAR(25) NOT NULL
);

CREATE TABLE Evaluations(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    session VARCHAR(20) NOT NULL,
    intitule_cours VARCHAR(100) NOT NULL,
    date_evaluation DATE NOT NULL,
    vacation VARCHAR(2) NOT NULL DEFAULT 'AM',
    type_ID INT NOT NULL,
    promotion_ID INT NOT NULL,
    FOREIGN KEY(type_ID) REFERENCES typeEvaluation(id),
    FOREIGN KEY(promotion_ID) REFERENCES Promotions(id)
);

CREATE TABLE Passer(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    date_presence DATE NOT NULL,
    time_in TIME NOT NULL,
    time_out TIME NOT NULL,
    etudiant_ID INT NOT NULL,
    evaluation_ID INT NOT NULL,
    FOREIGN KEY(etudiant_ID) REFERENCES Etudiants(id),
    FOREIGN KEY(evaluation_ID) REFERENCES Evaluations(id)
);

CREATE TABLE Salles(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nomSalle VARCHAR(25) NOT NULL,
    capacite INT NOT NULL
);

CREATE TABLE EtreAffecte(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    dateAffectation DATE NOT NULL,
    student_ID INT NOT NULL,
    salle_ID INT NOT NULL,
    FOREIGN KEY(student_ID) REFERENCES Etudiants(id),
    FOREIGN KEY(salle_ID) REFERENCES Salles(id)
);

CREATE TABLE Surveillants(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nomComplet VARCHAR(50) NOT NULL,
    sexe CHAR(1) NOT NULL,
    grade VARCHAR(50) NOT NULL,
    ID_carte VARCHAR(20) NOT NULL,
    estChefDeSalle BOOLEAN DEFAULT FALSE
);

CREATE TABLE Surveiller(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    dateSurveillance DATE NOT NULL,
    vacation CHAR(2) NOT NULL,
    timeIn TIME NOT NULL,
    timeOut TIME NOT NULL,
    salleID INT NOT NULL,
    surveillantID INT NOT NULL,
    FOREIGN KEY(salleID) REFERENCES Salles(id),
    FOREIGN KEY(surveillantID) REFERENCES Surveillants(id)
);

INSERT INTO Users VALUES(NULL, 'Iswe', '$2y$10$pvHk489z56B5PGx2HEPMUOYd074CM8iQ3QU149lbX7x45PXujSA5.', 'SUPER ADMIN', 1);