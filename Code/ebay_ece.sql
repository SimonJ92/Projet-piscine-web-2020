-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 14, 2020 at 04:07 PM
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
  `NumeroCarte` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`IDAcheteur`),
  KEY `NumeroCarte` (`NumeroCarte`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `acheteur`
--

INSERT INTO `acheteur` (`IDAcheteur`, `Prenom`, `Nom`, `AdresseMail`, `AdresseLigne1`, `AdresseLigne2`, `Ville`, `CodePostal`, `Pays`, `Telephone`, `NumeroCarte`) VALUES
(4, 'John', 'Doe', 'truc@gmail.com', 'Adresse1', NULL, 'Paris', '75015', 'France', '+33611111111', '2');

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
('1', 'Visa', 'Duparc Aurele', 05, 22, 111, '1000.00'),
('2', 'Mastercard', 'Jolly Simon', 10, 20, 222, '1000.00'),
('3', 'American Express', 'Louche Sylvain', 06, 21, 333, '1000.00');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
('Sylvain', 'sylvain.louche@edu.ece.fr', 'Louche', 'Images/photo-sylvain', 'Images/fond-sylvain', 'Admin numero 3', 1);

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
