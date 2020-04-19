-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 18, 2020 at 10:36 AM
-- Server version: 8.0.18
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ebay_ece`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `AddMoney`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `AddMoney` (IN `Ajout` DECIMAL(10,2), IN `NumeroVoulu` VARCHAR(255))  MODIFIES SQL DATA
    COMMENT 'Permet d''ajouter de l''argent sur une carte'
UPDATE carte
SET carte.Solde = carte.Solde + Ajout
where carte.NumeroCarte = NumeroVoulu$$

DROP PROCEDURE IF EXISTS `RemoveMoney`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `RemoveMoney` (IN `Retrait` DECIMAL(10,2), IN `NumeroVoulu` VARCHAR(255))  MODIFIES SQL DATA
UPDATE carte
Set carte.Solde = carte.Solde - retrait
WHERE carte.NumeroCarte = NumeroVoulu$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `acheteur`
--

DROP TABLE IF EXISTS `acheteur`;
CREATE TABLE IF NOT EXISTS `acheteur` (
  `IDAcheteur` int(10) NOT NULL AUTO_INCREMENT,
  `Prenom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `AdresseMail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `AdresseLigne1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `AdresseLigne2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Ville` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `CodePostal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Pays` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Telephone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `MotDePasse` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `NumeroCarte` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`IDAcheteur`),
  KEY `NumeroCarte` (`NumeroCarte`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `acheteur`
--

INSERT INTO `acheteur` (`IDAcheteur`, `Prenom`, `Nom`, `AdresseMail`, `AdresseLigne1`, `AdresseLigne2`, `Ville`, `CodePostal`, `Pays`, `Telephone`, `MotDePasse`, `NumeroCarte`) VALUES
(4, 'John', 'Doe', 'truc@gmail.com', 'Adresse1', NULL, 'Paris', '75015', 'France', '+33611111111', 'Password', '2'),
(5, 'Jean', 'Meni', 'jean.meni@gmail.com', '20 rue des Pommiers', NULL, 'Paris', '75000', 'France', '0612345678', 'azerty', '2'),
(6, 'Didier', 'Séreaux', 'didier.sereaux@gmail.com', '62 rue des arts', NULL, 'Paris', '75007', 'France', '0665896478', 'motdepasse', '1'),
(7, 'Benjamin', 'Barni', 'benjamin.barni@gmail.com', '56 rue de l\'Armistice', NULL, 'Lyon', '69000', 'France', '0666493514', '123456', '2');

-- --------------------------------------------------------

--
-- Table structure for table `carte`
--

DROP TABLE IF EXISTS `carte`;
CREATE TABLE IF NOT EXISTS `carte` (
  `NumeroCarte` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `TypeCarte` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `NomTitulaire` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `MoisExpiration` int(2) UNSIGNED ZEROFILL NOT NULL,
  `AnneeExpiration` int(2) UNSIGNED ZEROFILL NOT NULL,
  `CodeSecurite` int(4) NOT NULL,
  `Solde` decimal(10,2) NOT NULL,
  PRIMARY KEY (`NumeroCarte`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carte`
--

INSERT INTO `carte` (`NumeroCarte`, `TypeCarte`, `NomTitulaire`, `MoisExpiration`, `AnneeExpiration`, `CodeSecurite`, `Solde`) VALUES
('1', 'Visa', 'Duparc Aurele', 05, 22, 111, '1000000.00'),
('2', 'Mastercard', 'Jolly Simon', 10, 20, 222, '10000000.00'),
('3', 'American Express', 'Louche Sylvain', 06, 21, 333, '5000000.00');

-- --------------------------------------------------------

--
-- Table structure for table `enchere`
--

DROP TABLE IF EXISTS `enchere`;
CREATE TABLE IF NOT EXISTS `enchere` (
  `IDEnchere` int(10) NOT NULL AUTO_INCREMENT,
  `DateFin` datetime NOT NULL,
  `NumeroProduit` int(10) NOT NULL,
  PRIMARY KEY (`IDEnchere`),
  KEY `NumeroProduit` (`NumeroProduit`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enchere`
--

INSERT INTO `enchere` (`IDEnchere`, `DateFin`, `NumeroProduit`) VALUES
(1, '2020-04-21 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `negociation`
--

DROP TABLE IF EXISTS `negociation`;
CREATE TABLE IF NOT EXISTS `negociation` (
  `NumeroNegociation` int(10) NOT NULL AUTO_INCREMENT,
  `IDAcheteur` int(10) NOT NULL,
  `PseudoVendeur` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `NumeroProduit` int(10) NOT NULL,
  `Prop1` decimal(10,2) UNSIGNED DEFAULT NULL,
  `Prop2` decimal(10,2) UNSIGNED DEFAULT NULL,
  `Prop3` decimal(10,2) UNSIGNED DEFAULT NULL,
  `Prop4` decimal(10,2) UNSIGNED DEFAULT NULL,
  `Prop5` decimal(10,2) UNSIGNED DEFAULT NULL,
  `Prop6` decimal(10,2) UNSIGNED DEFAULT NULL,
  `Prop7` decimal(10,2) UNSIGNED DEFAULT NULL,
  `Prop8` decimal(10,2) UNSIGNED DEFAULT NULL,
  `Prop9` decimal(10,2) UNSIGNED DEFAULT NULL,
  `Prop10` decimal(10,2) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`NumeroNegociation`),
  KEY `IDAcheteur` (`IDAcheteur`),
  KEY `PseudoVendeur` (`PseudoVendeur`),
  KEY `NumeroProduit` (`NumeroProduit`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `negociation`
--

INSERT INTO `negociation` (`NumeroNegociation`, `IDAcheteur`, `PseudoVendeur`, `NumeroProduit`, `Prop1`, `Prop2`, `Prop3`, `Prop4`, `Prop5`, `Prop6`, `Prop7`, `Prop8`, `Prop9`, `Prop10`) VALUES
(1, 7, 'Simon', 2, '10000.00', '40000.00', '15000.00', '37500.00', '25000.00', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `offre`
--

DROP TABLE IF EXISTS `offre`;
CREATE TABLE IF NOT EXISTS `offre` (
  `IDEnchere` int(10) NOT NULL,
  `IDAcheteur` int(10) NOT NULL,
  `Valeur` decimal(10,2) UNSIGNED NOT NULL,
  `DateOffre` datetime NOT NULL,
  PRIMARY KEY (`IDEnchere`,`IDAcheteur`),
  KEY `IDEnchere` (`IDEnchere`,`IDAcheteur`),
  KEY `IDAcheteur` (`IDAcheteur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offre`
--

INSERT INTO `offre` (`IDEnchere`, `IDAcheteur`, `Valeur`, `DateOffre`) VALUES
(1, 4, '2000000.00', '2020-04-17 11:00:00'),
(1, 7, '1000000.00', '2020-04-17 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `NumeroProduit` int(10) NOT NULL,
  `IDClient` int(10) NOT NULL,
  PRIMARY KEY (`NumeroProduit`,`IDClient`),
  KEY `NumeroProduit` (`NumeroProduit`,`IDClient`),
  KEY `IDClient` (`IDClient`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `panier`
--

INSERT INTO `panier` (`NumeroProduit`, `IDClient`) VALUES
(1, 4),
(7, 4),
(3, 5),
(5, 6),
(4, 7),
(6, 7);

-- --------------------------------------------------------

--
-- Table structure for table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `Numero` int(10) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Photo1` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Photo2` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Photo3` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Photo4` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Photo5` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `MethodeVente` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `PrixDirect` decimal(10,2) UNSIGNED NOT NULL,
  `DescriptionCourte` text COLLATE utf8mb4_general_ci NOT NULL,
  `DescriptionLongue1` text COLLATE utf8mb4_general_ci NOT NULL,
  `Categorie` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `PseudoVendeur` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`Numero`),
  KEY `PseudoVendeur` (`PseudoVendeur`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produit`
--

INSERT INTO `produit` (`Numero`, `Nom`, `Photo1`, `Photo2`, `Photo3`, `Photo4`, `Photo5`, `MethodeVente`, `PrixDirect`, `DescriptionCourte`, `DescriptionLongue1`, `Categorie`, `PseudoVendeur`) VALUES
(1, 'Bugatti La voiture noire 2019', 'Images/Images-produits/Bugatti_La_Voiture_Noire_2019.png', 'Images/Images-produits/bugatti-la-voiture-noire-photo2.jpg', 'Images/Images-produits/Bugatti-La-Voiture-Noire-2019-photo3', 'Images/Images-produits/bugatti-la-voiture-noire-photo4.jpg', 'Images/Images-produits/bugatti-la-voiture-noire-photo5.jpg', 'Encheres', '11000000.00', 'Supercar GT du constructeur Bugatti. Modele unique.', 'La Voiture Noire est une supercar GT de luxe du constructeur automobile francais Bugatti. Voiture neuve parmi les plus cheres et rapides du monde, vendue 11 millions d\'euros hors taxes, elle est presentee au salon international de l\'automobile de Geneve 2019 et est un modele unique base sur la Chiron.', 'VIP', 'Aurele'),
(2, 'Buste de Victor Hugo', 'Images/Images-produits/Buste_de_Victor_Hugo.png', NULL, NULL, NULL, NULL, 'Negoce', '50000.00', 'Buste de Victor Hugo, par un artiste inconnu.', 'Victor Hugo est un poete, dramaturge, ecrivain, romancier et dessinateur romantique francais, ne le 7 ventose an X (26 fevrier 1802) a Besancon et mort le 22 mai 1885 a Paris. Il est considere comme l\'un des plus importants ecrivains de langue francaise. Il est aussi une personnalite politique et un intellectuel engage qui a eu un role ideologique majeur et occupe une place marquante dans l\'histoire des lettres francaises au XIXe siecle, dans des genres et des domaines d\’une remarquable variete.', 'Musee', 'Simon'),
(3, 'Costume original de Darth Vader', 'Images/Images-produits/costume_original_Darth_Vador.png', NULL, NULL, NULL, NULL, 'Encheres', '500000.00', 'Costume original de Darth Vader de la saga Star Wars.', 'Il s\'agit du costume initial utilise au cours du tournage des films de la trilogie originale.', 'VIP', 'Sylvain'),
(4, 'Fauteuil Louis XVI rouge', 'Images/Images-produits/fauteuil-Louis-XVI-rouge-rococo', NULL, NULL, NULL, NULL, 'Negoce', '120000.00', 'Fauteuil style Louis XVI de couleur rouge.', 'Fauteuil style Louis XVI de couleur rouge. Tres bon etat.', 'Ferraille', 'Vendeur 1'),
(5, 'Nuit de Neige a Kambara - Hiroshige', 'Images/Images-produits/Hiroshige_nuit_de_neige_a_Kambara.png', NULL, NULL, NULL, NULL, 'Encheres', '500000.00', 'Tableau : \'Nuit de neige a Kambara\' par le dessinateur Hiroge. (1833)', 'Tableau : \'Nuit de neige a Kambara\' par le dessinateur Hiroge. (1833)', 'Musee', 'Aurele'),
(6, 'Horloge', 'Images/Images-produits/horloge.png', NULL, NULL, NULL, NULL, 'Negoce', '10000.00', 'Petite horloge ornee de dorures.', 'Petite horloge ornee de dorures.', 'Ferraille', 'Simon'),
(7, 'Statuette de Bouddha en jade', 'Images/Images-produits/statuette-jade-bouddha.png', NULL, NULL, NULL, NULL, 'Negoce', '5000.00', 'Sculpture de Bouddha - jade. Artiste inconnu.', 'Sculpture de Bouddha -jade. Artiste inconnu.', 'Ferraille', 'Sylvain'),
(8, 'Le Rigi bleu - William Turner', 'Images/Images-produits/william-turner-le_rigi-bleu', NULL, NULL, NULL, NULL, 'Encheres', '5400000.00', '\'Le Rigi Bleu\', peinture par William Turner.', '\'Le Rigi Bleu\', peinture par William Turner.', 'Musee', 'Vendeur 1');

-- --------------------------------------------------------

--
-- Table structure for table `vendeur`
--

DROP TABLE IF EXISTS `vendeur`;
CREATE TABLE IF NOT EXISTS `vendeur` (
  `Pseudo` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `AdresseMail` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Nom` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Photo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ImageFond` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Description` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Pseudo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendeur`
--

INSERT INTO `vendeur` (`Pseudo`, `AdresseMail`, `Nom`, `Photo`, `ImageFond`, `Description`, `Admin`) VALUES
('Aurele', 'aurele.duparc@edu.ece.fr', 'Duparc', 'Images/photo-aurele', 'Images/fond-aurele', 'Admin numero 1', 1),
('Simon', 'simon.jolly@edu.ece.fr', 'Jolly', 'Images/photo-simon', 'Images/photo-sylvain', 'Admin numero 2', 1),
('Sylvain', 'sylvain.louche@edu.ece.fr', 'Louche', 'Images/photo-sylvain', 'Images/fond-sylvain', 'Admin numero 3', 1),
('Vendeur 1', 'vendeur1@edu.ece.fr', 'Durand', 'Images/photo-vendeur1.jpg', 'Images/fond-profil1.jpg', 'Premier vendeur non-admin ajouté à notre base de données', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `acheteur`
--
ALTER TABLE `acheteur`
  ADD CONSTRAINT `acheteur_ibfk_1` FOREIGN KEY (`NumeroCarte`) REFERENCES `carte` (`NumeroCarte`) ON DELETE SET NULL ON UPDATE RESTRICT;

--
-- Constraints for table `enchere`
--
ALTER TABLE `enchere`
  ADD CONSTRAINT `enchere_ibfk_1` FOREIGN KEY (`NumeroProduit`) REFERENCES `produit` (`Numero`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `negociation`
--
ALTER TABLE `negociation`
  ADD CONSTRAINT `negociation_ibfk_1` FOREIGN KEY (`PseudoVendeur`) REFERENCES `vendeur` (`Pseudo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `negociation_ibfk_2` FOREIGN KEY (`NumeroProduit`) REFERENCES `produit` (`Numero`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `negociation_ibfk_3` FOREIGN KEY (`IDAcheteur`) REFERENCES `acheteur` (`IDAcheteur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `offre`
--
ALTER TABLE `offre`
  ADD CONSTRAINT `offre_ibfk_1` FOREIGN KEY (`IDAcheteur`) REFERENCES `acheteur` (`IDAcheteur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `offre_ibfk_2` FOREIGN KEY (`IDEnchere`) REFERENCES `enchere` (`IDEnchere`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `panier_ibfk_1` FOREIGN KEY (`IDClient`) REFERENCES `acheteur` (`IDAcheteur`),
  ADD CONSTRAINT `panier_ibfk_2` FOREIGN KEY (`NumeroProduit`) REFERENCES `produit` (`Numero`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`PseudoVendeur`) REFERENCES `vendeur` (`Pseudo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
