-- MySQL dump 10.13  Distrib 8.0.28, for Linux (x86_64)
--
-- Host: localhost    Database: webdb
-- ------------------------------------------------------
-- Server version	8.0.28-0ubuntu0.20.04.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `DECKS`
--

DROP TABLE IF EXISTS `DECKS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `DECKS` (
  `deckId` int unsigned NOT NULL AUTO_INCREMENT,
  `card1` json DEFAULT NULL,
  `card2` json DEFAULT NULL,
  `card3` json DEFAULT NULL,
  `card4` json DEFAULT NULL,
  `card5` json DEFAULT NULL,
  `card6` json DEFAULT NULL,
  `card7` json DEFAULT NULL,
  `card8` json DEFAULT NULL,
  `card9` json DEFAULT NULL,
  `card10` json DEFAULT NULL,
  PRIMARY KEY (`deckId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DECKS`
--

LOCK TABLES `DECKS` WRITE;
/*!40000 ALTER TABLE `DECKS` DISABLE KEYS */;
/*!40000 ALTER TABLE `DECKS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `USERS`
--

DROP TABLE IF EXISTS `USERS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `USERS` (
  `userid` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `deck1ID` int unsigned DEFAULT NULL,
  `deck2ID` int unsigned DEFAULT NULL,
  `deck3ID` int unsigned DEFAULT NULL,
  `wins` int unsigned DEFAULT '0',
  `ranking` int DEFAULT '0',
  PRIMARY KEY (`userid`),
  KEY `deck1ID` (`deck1ID`),
  KEY `deck2ID` (`deck2ID`),
  KEY `deck3ID` (`deck3ID`),
  CONSTRAINT `USERS_ibfk_1` FOREIGN KEY (`deck1ID`) REFERENCES `DECKS` (`deckId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `USERS_ibfk_2` FOREIGN KEY (`deck2ID`) REFERENCES `DECKS` (`deckId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `USERS_ibfk_3` FOREIGN KEY (`deck3ID`) REFERENCES `DECKS` (`deckId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `USERS`
--

LOCK TABLES `USERS` WRITE;
/*!40000 ALTER TABLE `USERS` DISABLE KEYS */;
INSERT INTO `USERS` VALUES (1,'testUser','testPassword',NULL,NULL,NULL,0,0),(2,'Brett','BrettPassword123',NULL,NULL,NULL,0,0),(3,'Brett2','BrettPass',NULL,NULL,NULL,0,0);
/*!40000 ALTER TABLE `USERS` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-03-21 11:15:54
