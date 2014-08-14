CREATE DATABASE  IF NOT EXISTS `animolibrosimple`;
USE `animolibrosimple`;

--
-- Table structure for table `log_actions`
--

DROP TABLE IF EXISTS `log_actions`;
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

--
-- Table structure for table `log_action_type`
--

DROP TABLE IF EXISTS `log_action_type`;
CREATE TABLE `log_action_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `action_UNIQUE` (`action`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log_action_type`
--

LOCK TABLES `log_action_type` WRITE;
INSERT INTO `log_action_type` VALUES (4,'added a new course'),(6,'added a new subject'),(16,'changed contact number'),(21,'changed course'),(15,'changed email address'),(17,'changed password'),(19,'changed profile picture'),(24,'changed the author'),(26,'changed the category'),(27,'changed the cover picture'),(22,'changed the isbn'),(25,'changed the publisher'),(23,'changed the title'),(20,'changed username'),(1,'created an account'),(3,'created an ad'),(2,'posted a new book'),(9,'removed a book'),(11,'removed a course'),(13,'removed a subject'),(8,'removed an account'),(10,'removed an ad'),(12,'removed an image'),(14,'removed the request to buy'),(7,'requested to buy '),(5,'uploaded a new image'),(18,'validated the account');
UNLOCK TABLES;

-- Dump completed on 2014-08-14  8:13:42

delimiter $$

DROP TABLE IF EXISTS `log_actions_ad`;
CREATE TABLE `log_actions_ad` (
  `log_id` int(11) NOT NULL,
  `ad_id` int(11) NOT NULL,
  PRIMARY KEY (`log_id`),
  KEY `log_ad.ad_idx` (`ad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1$$;

delimiter $$

DROP TABLE IF EXISTS `log_actions_book`;
CREATE TABLE `log_actions_book` (
  `log_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  PRIMARY KEY (`log_id`),
  KEY `log_book.book_idx` (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1$$;




