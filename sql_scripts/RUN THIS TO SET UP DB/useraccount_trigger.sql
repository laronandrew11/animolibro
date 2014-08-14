USE `animolibrosimple`;

delimiter $$

DROP TABLE IF EXISTS `useraccount`;
CREATE TABLE `useraccount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `passwordhash` longtext NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1$$

CREATE
DEFINER=`root`@`localhost`
TRIGGER `animolibrosimple`.`useraccount_AINS`
AFTER INSERT ON `animolibrosimple`.`useraccount`
FOR EACH ROW
-- Edit trigger body code below this line. Do not edit lines above this one
BEGIN
	INSERT INTO `log_actions` (`user_id`, `action_type_id`) VALUES (NEW.id, 1);
END
$$

CREATE
DEFINER=`root`@`localhost`
TRIGGER `animolibrosimple`.`useraccount_AUPD`
AFTER UPDATE ON `animolibrosimple`.`useraccount`
FOR EACH ROW
-- Edit trigger body code below this line. Do not edit lines above this one
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
END
$$

