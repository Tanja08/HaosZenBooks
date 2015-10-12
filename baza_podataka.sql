/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50527
Source Host           : localhost:3306
Source Database       : prodavnica_knjiga

Target Server Type    : MYSQL
Target Server Version : 50527
File Encoding         : 65001

Date: 2014-06-14 14:48:49
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for autor
-- ----------------------------
DROP TABLE IF EXISTS `autor`;
CREATE TABLE `autor` (
  `ID` int(6) NOT NULL AUTO_INCREMENT,
  `ImePrezime` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of autor
-- ----------------------------
INSERT INTO `autor` VALUES ('1', 'Miloš Latinović');
INSERT INTO `autor` VALUES ('2', 'Roberto Kostantini');
INSERT INTO `autor` VALUES ('3', 'Peter Heg');
INSERT INTO `autor` VALUES ('4', 'Miloš Tomaš');

-- ----------------------------
-- Table structure for autor_knjiga
-- ----------------------------
DROP TABLE IF EXISTS `autor_knjiga`;
CREATE TABLE `autor_knjiga` (
  `Autor_ID` int(6) NOT NULL,
  `Knjiga_ID` int(8) NOT NULL,
  PRIMARY KEY (`Autor_ID`,`Knjiga_ID`),
  KEY `Autor_Knjiga_Knjiga_ID_Knjiga_ID` (`Knjiga_ID`),
  CONSTRAINT `Autor_Knjiga_Autor_ID_Autor_ID` FOREIGN KEY (`Autor_ID`) REFERENCES `autor` (`ID`) ON UPDATE CASCADE,
  CONSTRAINT `Autor_Knjiga_Knjiga_ID_Knjiga_ID` FOREIGN KEY (`Knjiga_ID`) REFERENCES `knjiga` (`ID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of autor_knjiga
-- ----------------------------
INSERT INTO `autor_knjiga` VALUES ('1', '1');
INSERT INTO `autor_knjiga` VALUES ('2', '2');
INSERT INTO `autor_knjiga` VALUES ('3', '3');
INSERT INTO `autor_knjiga` VALUES ('4', '4');

-- ----------------------------
-- Table structure for kategorija
-- ----------------------------
DROP TABLE IF EXISTS `kategorija`;
CREATE TABLE `kategorija` (
  `ID` int(6) NOT NULL AUTO_INCREMENT,
  `Naziv` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of kategorija
-- ----------------------------
INSERT INTO `kategorija` VALUES ('1', 'Umetnost');
INSERT INTO `kategorija` VALUES ('2', 'Stripovi');
INSERT INTO `kategorija` VALUES ('3', 'Sport');
INSERT INTO `kategorija` VALUES ('4', 'Sociologija');
INSERT INTO `kategorija` VALUES ('5', 'Rečnici');
INSERT INTO `kategorija` VALUES ('6', 'Religija');
INSERT INTO `kategorija` VALUES ('7', 'Putovanja');
INSERT INTO `kategorija` VALUES ('8', 'Psihologija');
INSERT INTO `kategorija` VALUES ('9', 'Priroda');
INSERT INTO `kategorija` VALUES ('10', 'Pravo');
INSERT INTO `kategorija` VALUES ('11', 'Nauka');
INSERT INTO `kategorija` VALUES ('12', 'Kulinarstvo');
INSERT INTO `kategorija` VALUES ('13', 'Knjige za decu');
INSERT INTO `kategorija` VALUES ('14', 'Knjige o zdravljnu');
INSERT INTO `kategorija` VALUES ('15', 'Knjige o računarima');
INSERT INTO `kategorija` VALUES ('16', 'Istorija');
INSERT INTO `kategorija` VALUES ('17', 'Humor i zabava');
INSERT INTO `kategorija` VALUES ('18', 'Finansije');
INSERT INTO `kategorija` VALUES ('19', 'Filozofija');
INSERT INTO `kategorija` VALUES ('20', 'Ekonomija');
INSERT INTO `kategorija` VALUES ('21', 'Društvena teorija');
INSERT INTO `kategorija` VALUES ('22', 'Beletristika');
INSERT INTO `kategorija` VALUES ('23', 'Popularna fizika');
INSERT INTO `kategorija` VALUES ('24', 'Strana izdanja');
INSERT INTO `kategorija` VALUES ('25', 'Domaća izdanja');
INSERT INTO `kategorija` VALUES ('26', 'Jezik - Srpski');
INSERT INTO `kategorija` VALUES ('27', 'Jezik - Engleski');
INSERT INTO `kategorija` VALUES ('28', 'Jezik - Srpsko-Hrvatski');
INSERT INTO `kategorija` VALUES ('29', 'Jezik - Bugarski');
INSERT INTO `kategorija` VALUES ('30', 'Jezik - Rumunski');
INSERT INTO `kategorija` VALUES ('31', 'Jezik - Kineski');

-- ----------------------------
-- Table structure for kategorija_knjiga
-- ----------------------------
DROP TABLE IF EXISTS `kategorija_knjiga`;
CREATE TABLE `kategorija_knjiga` (
  `Kategorija_ID` int(6) NOT NULL,
  `Knjiga_ID` int(8) NOT NULL,
  PRIMARY KEY (`Kategorija_ID`,`Knjiga_ID`),
  KEY `Kategorija_Knjiga_Knjiga_ID_Knjiga_ID` (`Knjiga_ID`),
  CONSTRAINT `Kategorija_Knjiga_Kategorija_ID_Kategorija_ID` FOREIGN KEY (`Kategorija_ID`) REFERENCES `kategorija` (`ID`) ON UPDATE CASCADE,
  CONSTRAINT `Kategorija_Knjiga_Knjiga_ID_Knjiga_ID` FOREIGN KEY (`Knjiga_ID`) REFERENCES `knjiga` (`ID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of kategorija_knjiga
-- ----------------------------
INSERT INTO `kategorija_knjiga` VALUES ('22', '1');
INSERT INTO `kategorija_knjiga` VALUES ('25', '1');
INSERT INTO `kategorija_knjiga` VALUES ('26', '1');
INSERT INTO `kategorija_knjiga` VALUES ('22', '2');
INSERT INTO `kategorija_knjiga` VALUES ('24', '2');
INSERT INTO `kategorija_knjiga` VALUES ('27', '2');
INSERT INTO `kategorija_knjiga` VALUES ('22', '3');
INSERT INTO `kategorija_knjiga` VALUES ('24', '3');
INSERT INTO `kategorija_knjiga` VALUES ('27', '3');
INSERT INTO `kategorija_knjiga` VALUES ('22', '4');
INSERT INTO `kategorija_knjiga` VALUES ('25', '4');
INSERT INTO `kategorija_knjiga` VALUES ('26', '4');

-- ----------------------------
-- Table structure for knjiga
-- ----------------------------
DROP TABLE IF EXISTS `knjiga`;
CREATE TABLE `knjiga` (
  `ID` int(8) NOT NULL AUTO_INCREMENT,
  `OriginalniNaslov` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `PrevodNaslova` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `BrojStrana` int(4) unsigned DEFAULT NULL,
  `ISBN` int(13) unsigned zerofill NOT NULL,
  `Godina` int(4) unsigned NOT NULL,
  `Cena` decimal(10,2) unsigned DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of knjiga
-- ----------------------------
INSERT INTO `knjiga` VALUES ('1', 'Sto dana kiše', null, '221', '0004294967295', '2013', '760.00');
INSERT INTO `knjiga` VALUES ('2', 'Tu sei il male', 'Ključ za Elizu', '407', '0004294967295', '2014', '600.00');
INSERT INTO `knjiga` VALUES ('3', 'The Elephant Keepers\' Children', 'Deca čuvara slonova', '512', '0001590516355', '2013', '451.00');
INSERT INTO `knjiga` VALUES ('4', 'Endemske vrste', null, null, '0004294967295', '2013', '570.00');

-- ----------------------------
-- Table structure for komentar
-- ----------------------------
DROP TABLE IF EXISTS `komentar`;
CREATE TABLE `komentar` (
  `ID` int(12) NOT NULL AUTO_INCREMENT,
  `Korisnik_ID` int(6) NOT NULL,
  `Knjiga_ID` int(8) NOT NULL,
  `DatumVreme` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Tekst` text COLLATE utf8_unicode_ci NOT NULL,
  `Odobren` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `Komentar_Odobren` (`Odobren`),
  KEY `Komentar_DatumVreme` (`DatumVreme`),
  KEY `Komentar_Korisnik_ID_Korisnik_ID` (`Korisnik_ID`),
  KEY `Komentar_Knjiga_ID_Knjiga_ID` (`Knjiga_ID`),
  CONSTRAINT `Komentar_Knjiga_ID_Knjiga_ID` FOREIGN KEY (`Knjiga_ID`) REFERENCES `knjiga` (`ID`) ON UPDATE CASCADE,
  CONSTRAINT `Komentar_Korisnik_ID_Korisnik_ID` FOREIGN KEY (`Korisnik_ID`) REFERENCES `korisnik` (`ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of komentar
-- ----------------------------
INSERT INTO `komentar` VALUES ('1', '1', '3', '2014-01-26 14:19:19', 'Deca čuvara slonova u kojem se ponovo kroz avanturističko-detektivki zaplet prati porodična drama i pokreću teme o globalnim političkim i religijskim mahinacijama zbog kojih društo i porodica zapadaju u krizu.', '1');
INSERT INTO `komentar` VALUES ('2', '2', '3', '2014-01-26 14:33:22', 'Jedna jako zanimljiva knjiga. Preporucujem svima da je procitaju. A Haos &amp; Zen Books portalu hvala sto nas snabdeva ovako dobrim knjigama!', '1');
INSERT INTO `komentar` VALUES ('3', '1', '2', '2014-01-26 15:32:30', 'Zanimljiva knjiga.', '1');
INSERT INTO `komentar` VALUES ('5', '1', '2', '2014-06-14 14:44:15', 'Moj prvi koemntar koji odobravam ili brisem iz admin panela!', '1');

-- ----------------------------
-- Table structure for korisnik
-- ----------------------------
DROP TABLE IF EXISTS `korisnik`;
CREATE TABLE `korisnik` (
  `ID` int(6) NOT NULL AUTO_INCREMENT,
  `KorisnickoIme` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `Lozinka` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `ZabranaPrijave` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `AdminPrivilegije` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of korisnik
-- ----------------------------
INSERT INTO `korisnik` VALUES ('1', 'Tanja', 'tanja', '0', '1');
INSERT INTO `korisnik` VALUES ('2', 'Milos', 'milos', '0', '0');
INSERT INTO `korisnik` VALUES ('3', 'test', '123456', '0', '0');

-- ----------------------------
-- Table structure for porudzbine
-- ----------------------------
DROP TABLE IF EXISTS `porudzbine`;
CREATE TABLE `porudzbine` (
  `ID` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `Korisnik_ID` int(8) NOT NULL,
  `DatumVreme` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Porudzbina` text COLLATE utf8_unicode_ci NOT NULL,
  `Suma` decimal(10,2) unsigned NOT NULL,
  `Ime_i_prezime` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Adresa` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Grad` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `Telefon` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Realizovana` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `fk_1` (`Korisnik_ID`),
  CONSTRAINT `fk_1` FOREIGN KEY (`Korisnik_ID`) REFERENCES `korisnik` (`ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of porudzbine
-- ----------------------------
INSERT INTO `porudzbine` VALUES ('1', '3', '2014-06-02 19:27:00', '[{\"Knjiga\":{\"Knjiga\":{\"ID\":\"1\",\"OriginalniNaslov\":\"Sto dana kiu0161e\",\"PrevodNaslova\":null,\"BrojStrana\":\"221\",\"ISBN\":\"0004294967295\",\"Godina\":\"2013\",\"Cena\":\"760.00\",\"Autor_ID\":\"1\",\"AutorImePrezime\":\"Milou0161 Latinoviu0107\",\"kategorije\":\"22,25,26\"},\"Komentari\":[]},\"Broj\":1,\"Ukupno\":760},{\"Knjiga\":{\"Knjiga\":{\"ID\":\"4\",\"OriginalniNaslov\":\"Endemske vrste\",\"PrevodNaslova\":null,\"BrojStrana\":null,\"ISBN\":\"0004294967295\",\"Godina\":\"2013\",\"Cena\":\"570.00\",\"Autor_ID\":\"4\",\"AutorImePrezime\":\"Milou0161 Tomau0161\",\"kategorije\":\"22,25,26\"},\"Komentari\":[]},\"Broj\":1,\"Ukupno\":570}]', '1330.00', 'Tanja B', 'Nepoznata ulica 13\r\n11000 Novi Beograd', 'Beograd', '+3816655500011', '0');
INSERT INTO `porudzbine` VALUES ('2', '3', '2014-06-02 19:35:41', '[{\"Knjiga\":{\"Knjiga\":{\"ID\":\"1\",\"OriginalniNaslov\":\"Sto dana kiu0161e\",\"PrevodNaslova\":null,\"BrojStrana\":\"221\",\"ISBN\":\"0004294967295\",\"Godina\":\"2013\",\"Cena\":\"760.00\",\"Autor_ID\":\"1\",\"AutorImePrezime\":\"Milou0161 Latinoviu0107\",\"kategorije\":\"22,25,26\"},\"Komentari\":[]},\"Broj\":1,\"Ukupno\":760},{\"Knjiga\":{\"Knjiga\":{\"ID\":\"4\",\"OriginalniNaslov\":\"Endemske vrste\",\"PrevodNaslova\":null,\"BrojStrana\":null,\"ISBN\":\"0004294967295\",\"Godina\":\"2013\",\"Cena\":\"570.00\",\"Autor_ID\":\"4\",\"AutorImePrezime\":\"Milou0161 Tomau0161\",\"kategorije\":\"22,25,26\"},\"Komentari\":[]},\"Broj\":1,\"Ukupno\":570}]', '1330.00', 'Tanja Brajenovic', 'Neka nepoznata adresa 33', 'Beograd', '+3816655500011', '0');
INSERT INTO `porudzbine` VALUES ('3', '1', '2014-06-02 20:04:52', '[{\"Knjiga\":{\"Knjiga\":{\"ID\":\"2\",\"OriginalniNaslov\":\"Tu sei il male\",\"PrevodNaslova\":\"Klju\\u010d za Elizu\",\"BrojStrana\":\"407\",\"ISBN\":\"0004294967295\",\"Godina\":\"2014\",\"Cena\":\"600.00\",\"Autor_ID\":\"2\",\"AutorImePrezime\":\"Roberto Kostantini\",\"kategorije\":\"22,24\"},\"Komentari\":[{\"ID\":\"3\",\"Korisnik_ID\":\"1\",\"Knjiga_ID\":\"2\",\"DatumVreme\":\"2014-01-26 15:32:30\",\"Tekst\":\"Zanimljiva knjiga.\",\"Odobren\":\"1\",\"KorisnikKorisnickoIme\":\"Tanja\"}]},\"Broj\":1,\"Ukupno\":600},{\"Knjiga\":{\"Knjiga\":{\"ID\":\"3\",\"OriginalniNaslov\":\"The Elephant Keepers\' Children\",\"PrevodNaslova\":\"Deca \\u010duvara slonova\",\"BrojStrana\":\"512\",\"ISBN\":\"0001590516355\",\"Godina\":\"2013\",\"Cena\":\"450.00\",\"Autor_ID\":\"3\",\"AutorImePrezime\":\"Peter Heg\",\"kategorije\":\"22,27,24\"},\"Komentari\":[{\"ID\":\"2\",\"Korisnik_ID\":\"2\",\"Knjiga_ID\":\"3\",\"DatumVreme\":\"2014-01-26 14:33:22\",\"Tekst\":\"Jedna jako zanimljiva knjiga. Preporucujem svima da je procitaju. A Haos &amp; Zen Books portalu hvala sto nas snabdeva ovako dobrim knjigama!\",\"Odobren\":\"1\",\"KorisnikKorisnickoIme\":\"Milos\"},{\"ID\":\"1\",\"Korisnik_ID\":\"1\",\"Knjiga_ID\":\"3\",\"DatumVreme\":\"2014-01-26 14:19:19\",\"Tekst\":\"Deca \\u010duvara slonova u kojem se ponovo kroz avanturisti\\u010dko-detektivki zaplet prati porodi\\u010dna drama i pokre\\u0107u teme o globalnim politi\\u010dkim i religijskim mahinacijama zbog kojih dru\\u0161to i porodica zapadaju u krizu.\",\"Odobren\":\"1\",\"KorisnikKorisnickoIme\":\"Tanja\"}]},\"Broj\":1,\"Ukupno\":450}]', '1050.00', 'Tanja Brajenovic', 'fddf', 'df', 'df', '1');
