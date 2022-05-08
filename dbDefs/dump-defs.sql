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
  `deckId` varchar(31) NOT NULL,
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
  `password` varchar(60) DEFAULT NULL,
  `deck1ID` varchar(31) DEFAULT NULL,
  `deck2ID` varchar(31) DEFAULT NULL,
  `deck3ID` varchar(31) DEFAULT NULL,
  `wins` int unsigned DEFAULT '0',
  `ranking` int DEFAULT '0',
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `USERS`
--

LOCK TABLES `USERS` WRITE;
/*!40000 ALTER TABLE `USERS` DISABLE KEYS */;
INSERT INTO `USERS` VALUES (1,'testUser','testPassword',NULL,NULL,NULL,5,2),(2,'Brett','BrettPassword123',NULL,NULL,NULL,3,1),(3,'Brett2','BrettPass',NULL,NULL,NULL,0,0),(4,'Brett3','$2y$10$aLzF4p9lkj8XzAMj2nWYYOEvN09zo6i0GYxsw1qrN1RCtWbI04qa6',NULL,NULL,NULL,0,0),(5,'Brett4','$2y$10$iAjSRe7k7F8Ne1yxKvlIhu1PhmmN8wCxCpF7DLpHYUYHZyFIWH7MK',NULL,NULL,NULL,0,0),(6,'Brett5','$2y$10$ruplNAlqBv2SUXyBVCCi7OILSewGxyvrNva62mxPFxapjwWVbhXye',NULL,NULL,NULL,0,0);
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

-- Dump completed on 2022-05-06 17:55:07
