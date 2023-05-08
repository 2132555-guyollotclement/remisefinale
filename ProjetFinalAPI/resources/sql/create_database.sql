-- Créer la base de données (si elle n'existe pas déjà)
CREATE DATABASE IF NOT EXISTS gestionnaire_de_taches
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

-- Utiliser la base de données créée
USE gestionnaire_de_taches;

-- Supprimer la table 'taches' si elle existe déjà
DROP TABLE IF EXISTS taches;

-- Créer la table 'taches' avec la colonne 'description' supplémentaire
CREATE TABLE taches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    description TEXT,
    termine BOOLEAN DEFAULT 0 NOT NULL 
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    api_key VARCHAR(255) DEFAULT NULL
);

-- Insérer des données dans la table 'users'
INSERT INTO users (username, password, api_key)
VALUES
    ('user1', '$2y$10$gFQ53syS/G7V9Xk25gT7GOuNnT4GR1lLsVEGxDyV6eQjg0Sv7o9DS', 'abc123'),
    ('user2', '$2y$10$vW.fK.W/zDkbP6fRXvgy2eXWZB1dtsoAZGNg5.YfzQ2EEXkHmzGmC', 'def456');

-- Insérer des données dans la table 'taches'
INSERT INTO taches (titre, description, termine) 
VALUES 
('Faire les courses', 'Acheter du lait, du pain et des oeufs', false),
('Répondre aux e-mails', 'Répondre aux e-mails professionnels et personnels', false),
('Nettoyer la cuisine', 'Laver la vaisselle et nettoyer les comptoirs', false),
('Faire du sport', 'Aller courir pendant 30 minutes', false),
('Prendre rendez-vous chez le dentiste', 'Prendre rendez-vous pour un nettoyage annuel', false);
