SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema sabor_latino
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `sabor_latino` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `sabor_latino` ;

-- -----------------------------------------------------
-- Table `sabor_latino`.`Performances`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sabor_latino`.`Performances` ;

CREATE TABLE IF NOT EXISTS `sabor_latino`.`Performances` (
  `idPerformances` INT(11) NOT NULL AUTO_INCREMENT,
  `performanceTitle` VARCHAR(100) NOT NULL,
  `performanceLocation` VARCHAR(100) NULL,
  `performanceDate` DATE NULL,
  PRIMARY KEY (`idPerformances`),
  UNIQUE INDEX `idPerformances_UNIQUE` (`idPerformances` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sabor_latino`.`Pictures`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sabor_latino`.`Pictures` ;

CREATE TABLE IF NOT EXISTS `sabor_latino`.`Pictures` (
  `idPictures` INT(11) NOT NULL AUTO_INCREMENT,
  `urlP` VARCHAR(500) NOT NULL,
  `captionP` VARCHAR(255) NULL,
  `PerformanceID` INT(11) NULL DEFAULT NULL COMMENT 'NULL when picture is not linked to a Performance',
  PRIMARY KEY (`idPictures`),
  UNIQUE INDEX `idPictures_UNIQUE` (`idPictures` ASC),
  INDEX `PictureOfPerformance_idx` (`PerformanceID` ASC),
  CONSTRAINT `PictureOfPerformance`
    FOREIGN KEY (`PerformanceID`)
    REFERENCES `sabor_latino`.`Performances` (`idPerformances`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sabor_latino`.`Members`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sabor_latino`.`Members` ;

CREATE TABLE IF NOT EXISTS `sabor_latino`.`Members` (
  `idMembers` INT(11) NOT NULL AUTO_INCREMENT,
  `firstName` VARCHAR(45) NOT NULL,
  `lastName` VARCHAR(45) NOT NULL,
  `year` YEAR NULL,
  `bio` VARCHAR(500) NULL,
  `pictureID` INT(11) NULL DEFAULT 0,
  PRIMARY KEY (`idMembers`),
  UNIQUE INDEX `idMembers_UNIQUE` (`idMembers` ASC),
  INDEX `profilePic_idx` (`pictureID` ASC),
  CONSTRAINT `profilePic`
    FOREIGN KEY (`pictureID`)
    REFERENCES `sabor_latino`.`Pictures` (`idPictures`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sabor_latino`.`Videos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sabor_latino`.`Videos` ;

CREATE TABLE IF NOT EXISTS `sabor_latino`.`Videos` (
  `idVideos` INT(11) NOT NULL AUTO_INCREMENT,
  `urlV` VARCHAR(500) NOT NULL,
  `captionV` VARCHAR(255) NULL,
  `performanceID` INT(11) NOT NULL,
  PRIMARY KEY (`idVideos`),
  UNIQUE INDEX `idVideos_UNIQUE` (`idVideos` ASC),
  INDEX `vid2performance_idx` (`performanceID` ASC),
  CONSTRAINT `vid2performance`
    FOREIGN KEY (`performanceID`)
    REFERENCES `sabor_latino`.`Performances` (`idPerformances`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sabor_latino`.`Positions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sabor_latino`.`Positions` ;

CREATE TABLE IF NOT EXISTS `sabor_latino`.`Positions` (
  `idPositions` INT(11) NOT NULL,
  `position` VARCHAR(45) NOT NULL DEFAULT 'mixed',
  PRIMARY KEY (`idPositions`),
  UNIQUE INDEX `idPositions_UNIQUE` (`idPositions` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sabor_latino`.`MembersHistory`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sabor_latino`.`MembersHistory` ;

CREATE TABLE IF NOT EXISTS `sabor_latino`.`MembersHistory` (
  `idHistory` INT(10) UNSIGNED NOT NULL,
  `memberID` INT(11) NOT NULL,
  `positionID` INT(11) NOT NULL DEFAULT 0,
  `startDate` DATE NULL,
  `endDate` DATE NULL,
  PRIMARY KEY (`idHistory`),
  UNIQUE INDEX `memberID_UNIQUE` (`memberID` ASC),
  INDEX `hist2Position_idx` (`positionID` ASC),
  CONSTRAINT `hist2members`
    FOREIGN KEY (`memberID`)
    REFERENCES `sabor_latino`.`Members` (`idMembers`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `hist2Position`
    FOREIGN KEY (`positionID`)
    REFERENCES `sabor_latino`.`Positions` (`idPositions`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sabor_latino`.`MemberContactInfo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sabor_latino`.`MemberContactInfo` ;

CREATE TABLE IF NOT EXISTS `sabor_latino`.`MemberContactInfo` (
  `memberID` INT(11) NOT NULL,
  `email` VARCHAR(45) NULL,
  `phone` VARCHAR(16) NULL,
  `country` VARCHAR(45) NULL DEFAULT 'USA',
  `state` VARCHAR(45) NULL DEFAULT 'NY',
  `city` VARCHAR(45) NULL DEFAULT 'Ithaca',
  PRIMARY KEY (`memberID`),
  UNIQUE INDEX `memberID_UNIQUE` (`memberID` ASC),
  CONSTRAINT `info2member`
    FOREIGN KEY (`memberID`)
    REFERENCES `sabor_latino`.`Members` (`idMembers`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sabor_latino`.`Genres`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sabor_latino`.`Genres` ;

CREATE TABLE IF NOT EXISTS `sabor_latino`.`Genres` (
  `idGenres` INT(11) NOT NULL AUTO_INCREMENT,
  `genreName` VARCHAR(45) NOT NULL DEFAULT 'mix',
  PRIMARY KEY (`idGenres`),
  UNIQUE INDEX `idGenres_UNIQUE` (`idGenres` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sabor_latino`.`MembersInVid`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sabor_latino`.`MembersInVid` ;

CREATE TABLE IF NOT EXISTS `sabor_latino`.`MembersInVid` (
  `memberID` INT(11) NOT NULL,
  `videoID` INT(11) NOT NULL,
  PRIMARY KEY (`memberID`, `videoID`),
  INDEX `videos_idx` (`videoID` ASC),
  CONSTRAINT `members`
    FOREIGN KEY (`memberID`)
    REFERENCES `sabor_latino`.`Members` (`idMembers`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `videos`
    FOREIGN KEY (`videoID`)
    REFERENCES `sabor_latino`.`Videos` (`idVideos`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sabor_latino`.`GenresInVid`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sabor_latino`.`GenresInVid` ;

CREATE TABLE IF NOT EXISTS `sabor_latino`.`GenresInVid` (
  `genreID` INT(11) NOT NULL,
  `videoID` INT(11) NOT NULL,
  PRIMARY KEY (`genreID`, `videoID`),
  CONSTRAINT `genres`
    FOREIGN KEY (`genreID`)
    REFERENCES `sabor_latino`.`Genres` (`idGenres`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `videos`
    FOREIGN KEY (`videoID`)
    REFERENCES `sabor_latino`.`Videos` (`idVideos`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sabor_latino`.`Admin`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sabor_latino`.`Admin` ;

CREATE TABLE IF NOT EXISTS `sabor_latino`.`Admin` (
  `username` VARCHAR(256) NOT NULL,
  `password` VARCHAR(256) NOT NULL,
  PRIMARY KEY (`username`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sabor_latino`.`ChoreographersOfVid`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sabor_latino`.`ChoreographersOfVid` ;

CREATE TABLE IF NOT EXISTS `sabor_latino`.`ChoreographersOfVid` (
  `MemberID` INT(11) NOT NULL,
  `VideoID` INT(11) NOT NULL,
  PRIMARY KEY (`MemberID`, `VideoID`),
  INDEX `danceChoreographed_idx` (`VideoID` ASC),
  CONSTRAINT `memberWhoChoreographed`
    FOREIGN KEY (`MemberID`)
    REFERENCES `sabor_latino`.`Members` (`idMembers`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `danceChoreographed`
    FOREIGN KEY (`VideoID`)
    REFERENCES `sabor_latino`.`Videos` (`idVideos`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
