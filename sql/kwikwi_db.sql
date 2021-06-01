-- MySQL Script generated by MySQL Workbench
-- Mon May 24 18:04:46 2021
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering
-- SET
--   @OLD_UNIQUE_CHECKS = @ @UNIQUE_CHECKS,
--   UNIQUE_CHECKS = 0;
-- SET
--   @OLD_FOREIGN_KEY_CHECKS = @ @FOREIGN_KEY_CHECKS,
--   FOREIGN_KEY_CHECKS = 0;
-- SET
--   @OLD_SQL_MODE = @ @SQL_MODE,
--   SQL_MODE = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema kwikwi_db
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `kwikwi_db`;

-- -----------------------------------------------------
-- Schema kwikwi_db
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `kwikwi_db`;

USE `kwikwi_db`;

-- -----------------------------------------------------
-- Table `kwikwi_db`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kwikwi_db`.`user` (
  `id_user` INT NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(45) NOT NULL,
  `lastname` VARCHAR(45) NOT NULL,
  `birthdate` DATE NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `role` ENUM('user', 'administrator') NULL DEFAULT 'user',
  `gender` ENUM('male', 'femal', 'other') NOT NULL DEFAULT 'male',
  `subscription` INT NOT NULL DEFAULT 0,
  `subscriber` INT NOT NULL DEFAULT 0,
  `picture_profile` VARCHAR(255) NOT NULL DEFAULT './images/default/picture.png',
  `ban` TINYINT NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `kwikwi_db`.`conversation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kwikwi_db`.`conversation` (
  `idconversation` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL DEFAULT 'Nouveau Groupe',
  `picture` LONGTEXT NOT NULL,
  PRIMARY KEY (`idconversation`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `kwikwi_db`.`messages`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kwikwi_db`.`messages` (
  `id_messages` INT NOT NULL AUTO_INCREMENT,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `title` VARCHAR(255) NULL DEFAULT NULL,
  `text` LONGTEXT NOT NULL,
  `reaction` TINYINT NULL DEFAULT 0,
  `conversation_idconversation` INT NOT NULL,
  PRIMARY KEY (`id_messages`),
  INDEX `fk_messages_conversation1_idx` (`conversation_idconversation` ASC),
  CONSTRAINT `fk_messages_conversation1` FOREIGN KEY (`conversation_idconversation`) REFERENCES `kwikwi_db`.`conversation` (`idconversation`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `kwikwi_db`.`user_has_messages`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kwikwi_db`.`user_has_messages` (
  `user_id_user` INT NOT NULL,
  `Messages_id_messages` INT NOT NULL,
  PRIMARY KEY (`user_id_user`, `Messages_id_messages`),
  INDEX `fk_user_has_Messages_Messages1_idx` (`Messages_id_messages` ASC),
  INDEX `fk_user_has_Messages_user_idx` (`user_id_user` ASC),
  CONSTRAINT `fk_user_has_Messages_user` FOREIGN KEY (`user_id_user`) REFERENCES `kwikwi_db`.`user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_Messages_Messages1` FOREIGN KEY (`Messages_id_messages`) REFERENCES `kwikwi_db`.`messages` (`id_messages`) ON DELETE NO ACTION ON UPDATE NO ACTION
);

-- -----------------------------------------------------
-- Table `kwikwi_db`.`publication`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kwikwi_db`.`publication` (
  `idpublication` INT NOT NULL AUTO_INCREMENT,
  `content` VARCHAR(255) NOT NULL,
  `like` INT NOT NULL DEFAULT 0,
  `date_publi` VARCHAR(255) NOT NULL,
  `user_id_user` INT NOT NULL,
  `reports` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`idpublication`),
  UNIQUE INDEX `idpublication_UNIQUE` (`idpublication` ASC),
  INDEX `fk_publication_user1_idx` (`user_id_user` ASC),
  CONSTRAINT `fk_publication_user1` FOREIGN KEY (`user_id_user`) REFERENCES `kwikwi_db`.`user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `kwikwi_db`.`comment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kwikwi_db`.`comment` (
  `idcomment` INT NOT NULL AUTO_INCREMENT,
  `content` VARCHAR(255) NOT NULL,
  `like` INT NOT NULL DEFAULT 0,
  `date_comm` VARCHAR(255) NOT NULL,
  `publication_idpublication` INT NOT NULL,
  `user_id_user` INT NOT NULL,
  `reports` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`idcomment`),
  UNIQUE INDEX `idcomment_UNIQUE` (`idcomment` ASC),
  INDEX `fk_comment_publication1_idx` (`publication_idpublication` ASC),
  INDEX `fk_comment_user1_idx` (`user_id_user` ASC),
  CONSTRAINT `fk_comment_publication1` FOREIGN KEY (`publication_idpublication`) REFERENCES `kwikwi_db`.`publication` (`idpublication`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_comment_user1` FOREIGN KEY (`user_id_user`) REFERENCES `kwikwi_db`.`user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `kwikwi_db`.`subscription`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kwikwi_db`.`subscription` (
  `id_user` INT(11) NOT NULL,
  `id_target` INT(11) NOT NULL,
  INDEX `id_user` (`id_user` ASC),
  INDEX `id_target` (`id_target` ASC),
  CONSTRAINT `id_user` FOREIGN KEY (`id_user`) REFERENCES `kwikwi_db`.`user` (`id_user`),
  CONSTRAINT `id_target` FOREIGN KEY (`id_target`) REFERENCES `kwikwi_db`.`user` (`id_user`)
);

-- -----------------------------------------------------
-- Table `kwikwi_db`.`like`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kwikwi_db`.`like` (
  `user_id_user` INT NOT NULL,
  `publication_idpublication` INT NOT NULL,
  PRIMARY KEY (`user_id_user`, `publication_idpublication`),
  INDEX `fk_user_has_publication_publication1_idx` (`publication_idpublication` ASC),
  INDEX `fk_user_has_publication_user1_idx` (`user_id_user` ASC),
  CONSTRAINT `fk_user_has_publication_user1` FOREIGN KEY (`user_id_user`) REFERENCES `kwikwi_db`.`user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_publication_publication1` FOREIGN KEY (`publication_idpublication`) REFERENCES `kwikwi_db`.`publication` (`idpublication`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `kwikwi_db`.`like_comment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kwikwi_db`.`like_comment` (
  `user_id_user` INT NOT NULL,
  `comment_idcomment` INT NOT NULL,
  PRIMARY KEY (`user_id_user`, `comment_idcomment`),
  INDEX `fk_user_has_comment_comment1_idx` (`comment_idcomment` ASC),
  INDEX `fk_user_has_comment_user1_idx` (`user_id_user` ASC),
  CONSTRAINT `fk_user_has_comment_user1` FOREIGN KEY (`user_id_user`) REFERENCES `kwikwi_db`.`user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_comment_comment1` FOREIGN KEY (`comment_idcomment`) REFERENCES `kwikwi_db`.`comment` (`idcomment`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `kwikwi_db`.`reports`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kwikwi_db`.`reports` (
  `publication_idpublication` INT NOT NULL,
  `user_id_user` INT NOT NULL,
  PRIMARY KEY (`publication_idpublication`, `user_id_user`),
  INDEX `fk_publication_has_user_user1_idx` (`user_id_user` ASC),
  INDEX `fk_publication_has_user_publication1_idx` (`publication_idpublication` ASC),
  CONSTRAINT `fk_publication_has_user_publication1` FOREIGN KEY (`publication_idpublication`) REFERENCES `kwikwi_db`.`publication` (`idpublication`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_publication_has_user_user1` FOREIGN KEY (`user_id_user`) REFERENCES `kwikwi_db`.`user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `kwikwi_db`.`reports_comm`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kwikwi_db`.`reports_comm` (
  `comment_idcomment` INT NOT NULL,
  `user_id_user` INT NOT NULL,
  PRIMARY KEY (`comment_idcomment`, `user_id_user`),
  INDEX `fk_comment_has_user_user1_idx` (`user_id_user` ASC),
  INDEX `fk_comment_has_user_comment1_idx` (`comment_idcomment` ASC),
  CONSTRAINT `fk_comment_has_user_comment1` FOREIGN KEY (`comment_idcomment`) REFERENCES `kwikwi_db`.`comment` (`idcomment`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_comment_has_user_user1` FOREIGN KEY (`user_id_user`) REFERENCES `kwikwi_db`.`user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- SET
--   SQL_MODE = @OLD_SQL_MODE;
-- SET
--   FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS;
-- SET
--   UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS;