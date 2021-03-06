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
  passwordhash VARCHAR(45) NOT NULL ,
  email VARCHAR(45) NOT NULL ,
  contactnumber INT NULL ,
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

