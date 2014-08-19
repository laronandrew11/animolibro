CREATE DATABASE IF NOT EXISTS `animolibrosimple`;
USE `animolibrosimple`;

DROP TABLE IF EXISTS `log_actions_ad`;
DROP TABLE IF EXISTS `log_actions_book`;
DROP TABLE IF EXISTS `log_actions_image`;
DROP TABLE IF EXISTS `log_actions`;
DROP TABLE IF EXISTS `ad`;
DROP TABLE IF EXISTS `subject_uses_book`;
DROP TABLE IF EXISTS `book`;
DROP TABLE IF EXISTS `useraccount`;
DROP TABLE IF EXISTS `image`;
DROP TABLE IF EXISTS `log_errors`;
DROP TABLE IF EXISTS `loginattempts`;
DROP TABLE IF EXISTS `course`;
DROP TABLE IF EXISTS `log_action_type`;
DROP TABLE IF EXISTS `subject`;

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(8) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_UNIQUE` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject`
--

LOCK TABLES `subject` WRITE;
INSERT INTO `subject` VALUES (1,'HCIFACE'),(2,'SECUDEV'),(3,'HUMAART'),(4,'WEBAPPS'),(5,'COMPRO1'),(6,'ACTBAS');
UNLOCK TABLES;

--
-- Table structure for table `log_action_type`
--

CREATE TABLE `log_action_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `action_UNIQUE` (`action`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log_action_type`
--

LOCK TABLES `log_action_type` WRITE;
INSERT INTO `log_action_type` VALUES (1,'created an account'),(2,'posted a new book'),(3,'created an advertisement'),(4,'added a new course'),(5,'uploaded a new image'),(6,'added a new subject'),(7,'requested to buy '),(8,'removed an account'),(9,'removed a book'),(10,'removed an advertisement'),(11,'removed a course'),(12,'removed an image'),(13,'removed a subject'),(14,'removed the request to buy'),(15,'changed email address'),(16,'changed contact number'),(17,'changed password'),(18,'validated the account'),(19,'changed profile picture'),(20,'changed username'),(21,'changed course'),(22,'changed the isbn'),(23,'changed the title'),(24,'changed the author'),(25,'changed the publisher'),(26,'changed the category'),(27,'changed the cover picture'),(28,'logged in');
UNLOCK TABLES;

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `code` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  UNIQUE KEY `code_UNIQUE` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

LOCK TABLES `course` WRITE;
INSERT INTO `course` VALUES (1,'Software Technology','CS-ST'),(2,'Computer Systems Engineering','CS-CSE'),(3,'Network Engineering','CS-NE'),(4,'Instructional Systems Technology','CS-IST');
UNLOCK TABLES;

--
-- Table structure for table `loginattempts`
--

CREATE TABLE `loginattempts` (
  `IP` varchar(20) NOT NULL,
  `Attempt` int(11) NOT NULL,
  `LastLogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`IP`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `log_errors`
--

CREATE TABLE `log_errors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `errno` int(11) NOT NULL,
  `errstr` longtext NOT NULL,
  `errfile` text NOT NULL,
  `errline` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `href` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `useraccount`
--

CREATE TABLE `useraccount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `passwordhash` longtext NOT NULL,
  `salt` longtext NOT NULL,
  `email` varchar(45) NOT NULL,
  `contactnumber` bigint(20) DEFAULT NULL,
  `stars` bigint(20) NOT NULL DEFAULT '0',
  `Course_id` int(11) DEFAULT NULL,
  `Com_code` varchar(255) DEFAULT NULL,
  `profile_pic_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `fk_User_Course1_idx` (`Course_id`),
  CONSTRAINT `fk_User_Course1` FOREIGN KEY (`Course_id`) REFERENCES `course` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DELIMITER ||

CREATE TRIGGER `animolibrosimple`.`useraccount_AINS`
AFTER INSERT ON `animolibrosimple`.`useraccount`
FOR EACH ROW
BEGIN
  INSERT INTO `log_actions` (`user_id`, `action_type_id`) VALUES (NEW.id, 1);
END ||

DELIMITER ||

CREATE TRIGGER `animolibrosimple`.`useraccount_AUPD`
AFTER UPDATE ON `animolibrosimple`.`useraccount`
FOR EACH ROW
BEGIN
  IF NOT OLD.email <=> NEW.email THEN
    INSERT INTO `log_actions` (`user_id`, `action_type_id`) VALUES (OLD.id, 15);
  END IF;
  IF NOT OLD.contactnumber <=> NEW.contactnumber THEN
    INSERT INTO `log_actions` (`user_id`, `action_type_id`) VALUES (OLD.id, 16);
  END IF;
  IF NOT OLD.passwordhash <=> NEW.passwordhash THEN
    INSERT INTO `log_actions` (`user_id`, `action_type_id`) VALUES (OLD.id, 17);
  END IF;
  IF NOT OLD.com_code <=> NEW.com_code AND NEW.com_code <=> null THEN
    INSERT INTO `log_actions` (`user_id`, `action_type_id`) VALUES (OLD.id, 18);
  END IF;
  IF NOT OLD.profile_pic_id <=> NEW.profile_pic_id THEN
    INSERT INTO `log_actions` (`user_id`, `action_type_id`) VALUES (OLD.id, 19);
  END IF;
  IF NOT OLD.username <=> NEW.username THEN
    INSERT INTO `log_actions` (`user_id`, `action_type_id`) VALUES (OLD.id, 20);
  END IF;
  IF NOT OLD.course_id <=> NEW.course_id THEN
    INSERT INTO `log_actions` (`user_id`, `action_type_id`) VALUES (OLD.id, 21);
  END IF;
END ||

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `authors` varchar(45) NOT NULL,
  `publisher` varchar(45) DEFAULT NULL,
  `isbn` varchar(45) DEFAULT NULL,
  `category` varchar(45) NOT NULL,
  `cover_pic_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `isbn_UNIQUE` (`isbn`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1; ||

--
-- Table structure for table `subject_uses_book`
--

CREATE TABLE `subject_uses_book` (
  `Book_id` int(11) NOT NULL,
  `Subject_id` int(11) NOT NULL,
  PRIMARY KEY (`Book_id`,`Subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1; ||

--
-- Table structure for table `ad`
--

CREATE TABLE `ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cost` float NOT NULL,
  `meetup` varchar(45) NOT NULL,
  `copy_condition` varchar(45) NOT NULL,
  `negotiable` tinyint(1) NOT NULL,
  `status` int(11) NOT NULL,
  `description` varchar(300) DEFAULT NULL,
  `buyer_id` int(11) DEFAULT NULL,
  `seller_id` int(11) NOT NULL,
  `Book_id` int(11) NOT NULL,
  `submitted_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Ad_User1_idx` (`buyer_id`),
  KEY `fk_Ad_User2_idx` (`seller_id`),
  KEY `fk_Ad_Book1_idx` (`Book_id`),
  CONSTRAINT `fk_Ad_Book1` FOREIGN KEY (`Book_id`) REFERENCES `book` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Ad_User1` FOREIGN KEY (`buyer_id`) REFERENCES `useraccount` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Ad_User2` FOREIGN KEY (`seller_id`) REFERENCES `useraccount` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1; ||

CREATE TRIGGER `ad_AINS` AFTER INSERT ON `ad`
FOR EACH ROW
BEGIN
  INSERT INTO `log_actions` (`user_id`, `action_type_id`) VALUES (NEW.seller_id, 3) ;
  INSERT INTO `log_actions_ad` (`log_id`, `ad_id`) VALUES (LAST_INSERT_ID(), NEW.id) ;
END ||

DELIMITER ||

CREATE TRIGGER `ad_AUPD` AFTER UPDATE ON `ad`
FOR EACH ROW
BEGIN
  IF NEW.status <=> 1 AND NOT OLD.buyer_id <=> NEW.buyer_id THEN
    INSERT INTO `log_actions` (`user_id`, `action_type_id`) VALUES (NEW.buyer_id, 7);
    INSERT INTO `log_actions_ad` (`log_id`, `ad_id`) VALUES (LAST_INSERT_ID(), OLD.id);
  END IF;
END ||

--
-- Table structure for table `log_actions`
--

CREATE TABLE `log_actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `action_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `log.user_idx` (`user_id`),
  KEY `log.action_type_idx` (`action_type_id`),
  CONSTRAINT `log.user` FOREIGN KEY (`user_id`) REFERENCES `useraccount` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `log.action_type` FOREIGN KEY (`action_type_id`) REFERENCES `log_action_type` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1; ||

--
-- Table structure for table `log_actions_image`
--

CREATE TABLE `log_actions_image` (
  `log_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  PRIMARY KEY (`log_id`),
  KEY `log_image.image_idx` (`image_id`),
  CONSTRAINT `log_image.log` FOREIGN KEY (`log_id`) REFERENCES `log_actions` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `log_image.image` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1; ||

--
-- Table structure for table `log_actions_book`
--

CREATE TABLE `log_actions_book` (
  `log_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  PRIMARY KEY (`log_id`),
  KEY `log_book.book_idx` (`book_id`),
  CONSTRAINT `log_book.log` FOREIGN KEY (`log_id`) REFERENCES `log_actions` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `log_book.book` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1; ||

--
-- Table structure for table `log_actions_ad`
--

CREATE TABLE `log_actions_ad` (
  `log_id` int(11) NOT NULL,
  `ad_id` int(11) NOT NULL,
  PRIMARY KEY (`log_id`),
  KEY `log_ad.ad_idx` (`ad_id`),
  CONSTRAINT `log_ad.log` FOREIGN KEY (`log_id`) REFERENCES `log_actions` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `log_ad.ad` FOREIGN KEY (`ad_id`) REFERENCES `ad` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dump completed on 2014-08-15 18:14:26
