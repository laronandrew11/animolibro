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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

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
INSERT INTO `log_action_type` VALUES (1,'created an account'),(2,'posted a new book'),(3,'created an advertisement'),(4,'added a new course'),(5,'uploaded a new image'),(6,'added a new subject'),(7,'requested to buy '),(8,'removed an account'),(9,'removed a book'),(10,'removed an advertisement'),(11,'removed a course'),(12,'removed an image'),(13,'removed a subject'),(14,'removed the request to buy'),(15,'changed email address'),(16,'changed contact number'),(17,'changed password'),(18,'validated the account'),(19,'changed profile picture'),(20,'changed username'),(21,'changed course'),(22,'changed the isbn'),(23,'changed the title'),(24,'changed the author'),(25,'changed the publisher'),(26,'changed the category'),(27,'changed the cover picture');
UNLOCK TABLES;

-- Dump completed on 2014-08-14  8:13:42

delimiter $$

DROP TABLE IF EXISTS `log_actions_ad`;
CREATE TABLE `log_actions_ad` (
  `log_id` int(11) NOT NULL,
  `ad_id` int(11) NOT NULL,
  PRIMARY KEY (`log_id`),
  KEY `log_ad.ad_idx` (`ad_id`),
  CONSTRAINT `log_ad.log` FOREIGN KEY (`log_id`) REFERENCES `log_actions` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `log_ad.ad` FOREIGN KEY (`ad_id`) REFERENCES `ad` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1$$

delimiter $$

DROP TABLE IF EXISTS `log_actions_book`;
CREATE TABLE `log_actions_book` (
  `log_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  PRIMARY KEY (`log_id`),
  KEY `log_book.book_idx` (`book_id`),
  CONSTRAINT `log_book.log` FOREIGN KEY (`log_id`) REFERENCES `log_actions` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `log_book.book` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1$$

delimiter $$

DROP TABLE IF EXISTS `log_actions_image`;
CREATE TABLE `log_actions_image` (
  `log_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  PRIMARY KEY (`log_id`),
  KEY `log_image.image_idx` (`image_id`),
  CONSTRAINT `log_image.log` FOREIGN KEY (`log_id`) REFERENCES `log_actions` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `log_image.image` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1$$

