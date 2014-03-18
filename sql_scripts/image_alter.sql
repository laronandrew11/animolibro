-- -----------------------------------------------------
-- Table AnimoLibro.Image
-- -----------------------------------------------------
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