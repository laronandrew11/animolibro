-- allow multiple subjects per book; no need to alter Book table except for this:

ALTER TABLE Book
 DELETE subjects ;

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



-- TBD: allow multiple pics for profile or cover

CREATE  TABLE IF NOT EXISTS AnimoLibroSimple.ProfilePics (
  User_id INT NOT NULL ,
  Pic_id INT NOT NULL ,
  PRIMARY KEY (User_id, Pic_id) )
  
CREATE  TABLE IF NOT EXISTS AnimoLibroSimple.CoverPics (
  Book_id INT NOT NULL ,
  Pic_id INT NOT NULL ,
  PRIMARY KEY (Book_id, Pic_id) )
  
ALTER TABLE UserAccount
 DELETE profile_pic_id;  
  
ALTER TABLE Book
 DELETE cover_pic_id;
 
 
  
  
