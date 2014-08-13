CREATE DATABASE AnimoLibroSimple;
USE AnimoLibroSimple;


-- -----------------------------------------------------
-- Table AnimoLibro.Course
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS AnimoLibroSimple.Course (
  id INT NOT NULL AUTO_INCREMENT ,
  name VARCHAR(45) NOT NULL ,
  code VARCHAR(45) NOT NULL ,
  PRIMARY KEY (id) ,
  UNIQUE INDEX name_UNIQUE (name ASC) ,
  UNIQUE INDEX code_UNIQUE (code ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table AnimoLibro.User
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS AnimoLibroSimple.UserAccount (
  id INT NOT NULL AUTO_INCREMENT ,
  username VARCHAR(45) NOT NULL ,
  passwordhash LONGTEXT NOT NULL ,
  email VARCHAR(45) NOT NULL ,
  contactnumber BIGINT NULL ,
  stars BIGINT NOT NULL ,
  Course_id INT NULL ,
  Com_code VARCHAR( 255 ) default NULL,
  PRIMARY KEY (id) ,
  UNIQUE INDEX username_UNIQUE (username ASC) ,
  UNIQUE INDEX email_UNIQUE (email ASC) ,
  INDEX fk_User_Course1_idx (Course_id ASC) ,
  CONSTRAINT fk_User_Course1
    FOREIGN KEY (Course_id )
    REFERENCES AnimoLibroSimple.Course (id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



-- -----------------------------------------------------
-- Table AnimoLibro.Book
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS AnimoLibroSimple.Book (
  id INT NOT NULL AUTO_INCREMENT ,
  title VARCHAR(45) NOT NULL ,
  authors VARCHAR(45) NOT NULL ,
  publisher VARCHAR(45) NULL ,
  isbn VARCHAR(45) NULL ,
  category VARCHAR(45) NOT NULL ,
  subjects VARCHAR(45) NOT NULL,
  PRIMARY KEY (id) ,
  UNIQUE INDEX isbn_UNIQUE (isbn ASC) )

ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table AnimoLibro.Ad
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS AnimoLibroSimple.Ad (
  id INT NOT NULL AUTO_INCREMENT ,
  cost FLOAT NOT NULL ,
  meetup VARCHAR(45) NOT NULL ,
  copy_condition VARCHAR(45) NOT NULL ,
  negotiable TINYINT(1) NOT NULL ,
  status INT NOT NULL ,
  description VARCHAR(300) NULL ,
  buyer_id INT NULL ,
  seller_id INT NOT NULL ,
  Book_id INT NOT NULL ,
  PRIMARY KEY (id) ,
  INDEX fk_Ad_User1_idx (buyer_id ASC) ,
  INDEX fk_Ad_User2_idx (seller_id ASC) ,
  INDEX fk_Ad_Book1_idx (Book_id ASC) ,
  CONSTRAINT fk_Ad_User1
    FOREIGN KEY (buyer_id )
    REFERENCES AnimoLibroSimple.UserAccount (id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_Ad_User2
    FOREIGN KEY (seller_id )
    REFERENCES AnimoLibroSimple.UserAccount (id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_Ad_Book1
    FOREIGN KEY (Book_id )
    REFERENCES AnimoLibroSimple.Book (id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table AnimoLibro.User_wants_Book
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS AnimoLibroSimple.User_wants_Book (
  User_id INT NOT NULL ,
  Book_id INT NOT NULL ,
  PRIMARY KEY (User_id, Book_id) ,
  INDEX fk_User_has_Book_Book1_idx (Book_id ASC) ,
  INDEX fk_User_has_Book_User1_idx (User_id ASC) ,
  CONSTRAINT fk_User_has_Book_User1
    FOREIGN KEY (User_id )
    REFERENCES AnimoLibroSimple.UserAccount (id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_User_has_Book_Book1
    FOREIGN KEY (Book_id )
    REFERENCES AnimoLibroSimple.Book (id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
-- begin "image_alter.sql"
CREATE  TABLE IF NOT EXISTS AnimoLibroSimple.Image (
  id INT NOT NULL AUTO_INCREMENT ,
  type INT NOT NULL,
  href VARCHAR(45) NOT NULL ,
  PRIMARY KEY (id) )
ENGINE = InnoDB;

ALTER TABLE UserAccount
 ADD profile_pic_id INT NULL;
 
 ALTER TABLE Book
 ADD cover_pic_id INT NULL;
 -- allow multiple subjects per book; no need to alter Book table except for this:

ALTER TABLE Book
 drop subjects ;

CREATE  TABLE IF NOT EXISTS AnimoLibroSimple.Subject (
  id INT NOT NULL AUTO_INCREMENT ,
  code VARCHAR(8) NOT NULL ,
  PRIMARY KEY (id) ,
  UNIQUE INDEX code_UNIQUE (code ASC) )
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table AnimoLibro.Subject_uses_Book
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS AnimoLibroSimple.Subject_uses_Book (
  Book_id INT NOT NULL ,
  Subject_id INT NOT NULL ,
  PRIMARY KEY (Book_id, Subject_id) )

ENGINE = InnoDB;
