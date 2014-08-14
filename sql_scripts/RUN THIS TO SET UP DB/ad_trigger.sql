delimiter $$

DROP TABLE IF EXISTS `ad`;
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
  CONSTRAINT `fk_Ad_User1` FOREIGN KEY (`buyer_id`) REFERENCES `useraccount` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Ad_User2` FOREIGN KEY (`seller_id`) REFERENCES `useraccount` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Ad_Book1` FOREIGN KEY (`Book_id`) REFERENCES `book` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1$$

CREATE
DEFINER=`root`@`localhost`
TRIGGER `animolibrosimple`.`ad_AINS`
AFTER INSERT ON `animolibrosimple`.`ad`
FOR EACH ROW
-- Edit trigger body code below this line. Do not edit lines above this one

BEGIN
	INSERT INTO `log_actions` (`user_id`, `action_type_id`) VALUES (NEW.seller_id, 3);
	INSERT INTO `log_actions_ad` (`log_id`, `ad_id`) VALUES (LAST_INSERT_ID(), NEW.id);
END
$$

