CREATE DATABASE AnimoLibro;
USE AnimoLibro;


-- -----------------------------------------------------
-- Table AnimoLibro.Course
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS AnimoLibro.Course (
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
CREATE  TABLE IF NOT EXISTS AnimoLibro.UserAccount (
  id INT NOT NULL AUTO_INCREMENT ,
  username VARCHAR(45) NOT NULL ,
  passwordhash VARCHAR(45) NOT NULL ,
  email VARCHAR(45) NOT NULL ,
  contactnumber INT NULL ,
  stars BIGINT NOT NULL ,
  Course_id INT NULL ,
  PRIMARY KEY (id) ,
  UNIQUE INDEX username_UNIQUE (username ASC) ,
  UNIQUE INDEX email_UNIQUE (email ASC) ,
  INDEX fk_User_Course1_idx (Course_id ASC) ,
  CONSTRAINT fk_User_Course1
    FOREIGN KEY (Course_id )
    REFERENCES AnimoLibro.Course (id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table AnimoLibro.Category
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS AnimoLibro.Category (
  id INT NOT NULL AUTO_INCREMENT ,
  name VARCHAR(45) NOT NULL ,
  PRIMARY KEY (id) ,
  UNIQUE INDEX name_UNIQUE (name ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table AnimoLibro.Book
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS AnimoLibro.Book (
  id INT NOT NULL AUTO_INCREMENT ,
  title VARCHAR(45) NOT NULL ,
  authors VARCHAR(45) NOT NULL ,
  publisher VARCHAR(45) NULL ,
  isbn VARCHAR(45) NULL ,
  Category_id INT NOT NULL ,
  PRIMARY KEY (id) ,
  UNIQUE INDEX isbn_UNIQUE (isbn ASC) ,
  INDEX fk_Book_Category_idx (Category_id ASC) ,
  CONSTRAINT fk_Book_Category
    FOREIGN KEY (Category_id )
    REFERENCES AnimoLibro.Category (id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table AnimoLibro.Ad
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS AnimoLibro.Ad (
  id INT NOT NULL AUTO_INCREMENT ,
  cost FLOAT NOT NULL ,
  meetup VARCHAR(45) NOT NULL ,
  condition VARCHAR(45) NOT NULL ,
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
    REFERENCES AnimoLibro.UserAccount (id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_Ad_User2
    FOREIGN KEY (seller_id )
    REFERENCES AnimoLibro.UserAccount (id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_Ad_Book1
    FOREIGN KEY (Book_id )
    REFERENCES AnimoLibro.Book (id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table AnimoLibro.Subject
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS AnimoLibro.Subject (
  id INT NOT NULL AUTO_INCREMENT ,
  code VARCHAR(45) NOT NULL ,
  PRIMARY KEY (id) ,
  UNIQUE INDEX code_UNIQUE (code ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table AnimoLibro.Subject_uses_Book
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS AnimoLibro.Subject_uses_Book (
  Book_id INT NOT NULL ,
  Subject_id INT NOT NULL ,
  PRIMARY KEY (Book_id, Subject_id) ,
  INDEX fk_Book_has_Subject_Subject1_idx (Subject_id ASC) ,
  INDEX fk_Book_has_Subject_Book1_idx (Book_id ASC) ,
  CONSTRAINT fk_Book_has_Subject_Book1
    FOREIGN KEY (Book_id )
    REFERENCES AnimoLibro.Book (id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_Book_has_Subject_Subject1
    FOREIGN KEY (Subject_id )
    REFERENCES AnimoLibro.Subject (id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table AnimoLibro.User_wants_Book
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS AnimoLibro.User_wants_Book (
  User_id INT NOT NULL ,
  Book_id INT NOT NULL ,
  PRIMARY KEY (User_id, Book_id) ,
  INDEX fk_User_has_Book_Book1_idx (Book_id ASC) ,
  INDEX fk_User_has_Book_User1_idx (User_id ASC) ,
  CONSTRAINT fk_User_has_Book_User1
    FOREIGN KEY (User_id )
    REFERENCES AnimoLibro.UserAccount (id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_User_has_Book_Book1
    FOREIGN KEY (Book_id )
    REFERENCES AnimoLibro.Book (id )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

