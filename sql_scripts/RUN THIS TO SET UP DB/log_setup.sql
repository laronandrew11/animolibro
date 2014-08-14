CREATE DATABASE  IF NOT EXISTS `animolibrosimple` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `animolibrosimple`;
-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: animolibrosimple
-- ------------------------------------------------------
-- Server version	5.5.29

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `log_actions`
--

DROP TABLE IF EXISTS `log_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `action_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `log.user_idx` (`user_id`),
  KEY `log.action_type_idx` (`action_type_id`),
  CONSTRAINT `log.action_type` FOREIGN KEY (`action_type_id`) REFERENCES `log_action_type` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `log.user` FOREIGN KEY (`user_id`) REFERENCES `useraccount` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_actions`
--

LOCK TABLES `log_actions` WRITE;
/*!40000 ALTER TABLE `log_actions` DISABLE KEYS */;
INSERT INTO `log_actions` VALUES (1,'2014-08-13 12:52:31',9,1),(2,'2014-08-13 23:47:19',9,20),(3,'2014-08-14 00:11:21',9,18),(4,'2014-08-14 00:11:52',9,17);
/*!40000 ALTER TABLE `log_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_action_type`
--

DROP TABLE IF EXISTS `log_action_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_action_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `action_UNIQUE` (`action`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_action_type`
--

LOCK TABLES `log_action_type` WRITE;
/*!40000 ALTER TABLE `log_action_type` DISABLE KEYS */;
INSERT INTO `log_action_type` VALUES (4,'added a new course'),(6,'added a new subject'),(16,'changed contact number'),(21,'changed course'),(15,'changed email address'),(17,'changed password'),(19,'changed profile picture'),(24,'changed the author'),(26,'changed the category'),(27,'changed the cover picture'),(22,'changed the isbn'),(25,'changed the publisher'),(23,'changed the title'),(20,'changed username'),(1,'created an account'),(3,'created an ad'),(2,'posted a new book'),(9,'removed a book'),(11,'removed a course'),(13,'removed a subject'),(8,'removed an account'),(10,'removed an ad'),(12,'removed an image'),(14,'removed the request to buy'),(7,'requested to buy '),(5,'uploaded a new image'),(18,'validated the account');
/*!40000 ALTER TABLE `log_action_type` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-08-14  8:13:42
