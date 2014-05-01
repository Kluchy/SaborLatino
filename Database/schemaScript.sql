SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema info230_SP14_skemab
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `info230_SP14_skemab` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `info230_SP14_skemab` ;

-- -----------------------------------------------------
-- Table `info230_SP14_skemab`.`Performances`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `info230_SP14_skemab`.`Performances` (
  `idPerformances` INT NOT NULL AUTO_INCREMENT,
  `performanceTitle` VARCHAR(100) NOT NULL,
  `performanceLocation` VARCHAR(100) NULL,
  `performanceDate` DATE NULL,
  PRIMARY KEY (`idPerformances`),
  UNIQUE INDEX `idPerformances_UNIQUE` (`idPerformances` ASC))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `info230_SP14_skemab`.`Pictures`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `info230_SP14_skemab`.`Pictures` (
  `idPictures` INT NOT NULL AUTO_INCREMENT,
  `urlP` VARCHAR(500) NOT NULL,
  `captionP` VARCHAR(255) NULL,
  `PerformanceID` INT NULL DEFAULT NULL COMMENT 'NULL when picture is not linked to a Performance',
  PRIMARY KEY (`idPictures`),
  UNIQUE INDEX `idPictures_UNIQUE` (`idPictures` ASC),
  INDEX `PictureOfPerformance_idx` (`PerformanceID` ASC),
  CONSTRAINT `PictureOfPerformance`
    FOREIGN KEY (`PerformanceID`)
    REFERENCES `info230_SP14_skemab`.`Performances` (`idPerformances`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `info230_SP14_skemab`.`Members`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `info230_SP14_skemab`.`Members` (
  `idMembers` INT NOT NULL AUTO_INCREMENT,
  `firstName` VARCHAR(45) NOT NULL,
  `lastName` VARCHAR(45) NOT NULL,
  `year` YEAR NULL,
  `bio` VARCHAR(500) NULL,
  `pictureID` INT NULL DEFAULT 0,
  PRIMARY KEY (`idMembers`),
  UNIQUE INDEX `idMembers_UNIQUE` (`idMembers` ASC),
  INDEX `profilePic_idx` (`pictureID` ASC),
  CONSTRAINT `profilePic`
    FOREIGN KEY (`pictureID`)
    REFERENCES `info230_SP14_skemab`.`Pictures` (`idPictures`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `info230_SP14_skemab`.`Videos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `info230_SP14_skemab`.`Videos` (
  `idVideos` INT NOT NULL AUTO_INCREMENT,
  `urlV` VARCHAR(500) NOT NULL,
  `captionV` VARCHAR(255) NULL,
  `performanceID` INT NOT NULL,
  PRIMARY KEY (`idVideos`),
  UNIQUE INDEX `idVideos_UNIQUE` (`idVideos` ASC),
  INDEX `vid2performance_idx` (`performanceID` ASC),
  CONSTRAINT `vid2performance`
    FOREIGN KEY (`performanceID`)
    REFERENCES `info230_SP14_skemab`.`Performances` (`idPerformances`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `info230_SP14_skemab`.`Positions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `info230_SP14_skemab`.`Positions` (
  `idPositions` INT NOT NULL AUTO_INCREMENT,
  `position` VARCHAR(45) NOT NULL DEFAULT 'mixed',
  PRIMARY KEY (`idPositions`),
  UNIQUE INDEX `idPositions_UNIQUE` (`idPositions` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `info230_SP14_skemab`.`MembersHistory`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `info230_SP14_skemab`.`MembersHistory` (
  `idHistory` INT UNSIGNED NOT NULL,
  `memberID` INT NOT NULL,
  `positionID` INT NOT NULL DEFAULT 0,
  `startDate` DATE NULL,
  `endDate` DATE NULL,
  PRIMARY KEY (`idHistory`),
  UNIQUE INDEX `memberID_UNIQUE` (`memberID` ASC),
  INDEX `hist2Position_idx` (`positionID` ASC),
  CONSTRAINT `hist2members`
    FOREIGN KEY (`memberID`)
    REFERENCES `info230_SP14_skemab`.`Members` (`idMembers`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `hist2Position`
    FOREIGN KEY (`positionID`)
    REFERENCES `info230_SP14_skemab`.`Positions` (`idPositions`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `info230_SP14_skemab`.`MemberContactInfo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `info230_SP14_skemab`.`MemberContactInfo` (
  `memberID` INT NOT NULL,
  `email` VARCHAR(45) NULL,
  `phone` INT NULL,
  `country` VARCHAR(45) NULL DEFAULT 'USA',
  `state` VARCHAR(45) NULL DEFAULT 'NY',
  `city` VARCHAR(45) NULL DEFAULT 'Ithaca',
  PRIMARY KEY (`memberID`),
  UNIQUE INDEX `memberID_UNIQUE` (`memberID` ASC),
  CONSTRAINT `info2member`
    FOREIGN KEY (`memberID`)
    REFERENCES `info230_SP14_skemab`.`Members` (`idMembers`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `info230_SP14_skemab`.`Genres`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `info230_SP14_skemab`.`Genres` (
  `idGenres` INT NOT NULL AUTO_INCREMENT,
  `genreName` VARCHAR(45) NOT NULL DEFAULT 'mix',
  PRIMARY KEY (`idGenres`),
  UNIQUE INDEX `idGenres_UNIQUE` (`idGenres` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `info230_SP14_skemab`.`MembersInVid`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `info230_SP14_skemab`.`MembersInVid` (
  `memberID` INT NOT NULL,
  `videoID` INT NOT NULL,
  PRIMARY KEY (`memberID`, `videoID`),
  INDEX `videos_idx` (`videoID` ASC),
  CONSTRAINT `members`
    FOREIGN KEY (`memberID`)
    REFERENCES `info230_SP14_skemab`.`Members` (`idMembers`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `videos`
    FOREIGN KEY (`videoID`)
    REFERENCES `info230_SP14_skemab`.`Videos` (`idVideos`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `info230_SP14_skemab`.`GenresInVid`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `info230_SP14_skemab`.`GenresInVid` (
  `genreID` INT NOT NULL,
  `videoID` INT NOT NULL,
  PRIMARY KEY (`genreID`, `videoID`),
  CONSTRAINT `validGenres`
    FOREIGN KEY (`genreID`)
    REFERENCES `info230_SP14_skemab`.`Genres` (`idGenres`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `existingVideos`
    FOREIGN KEY (`videoID`)
    REFERENCES `info230_SP14_skemab`.`Videos` (`idVideos`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `info230_SP14_skemab`.`Admin`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `info230_SP14_skemab`.`Admin` (
  `username` VARCHAR(45) NOT NULL DEFAULT 'admin',
  `password` VARCHAR(255) NOT NULL DEFAULT 'admin',
  PRIMARY KEY (`username`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `info230_SP14_skemab`.`ChoreographersOfVid`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `info230_SP14_skemab`.`ChoreographersOfVid` (
  `MemberID` INT NOT NULL,
  `VideoID` INT NOT NULL,
  PRIMARY KEY (`MemberID`, `VideoID`),
  INDEX `danceChoreographed_idx` (`VideoID` ASC),
  CONSTRAINT `memberWhoChoreographed`
    FOREIGN KEY (`MemberID`)
    REFERENCES `info230_SP14_skemab`.`Members` (`idMembers`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `danceChoreographed`
    FOREIGN KEY (`VideoID`)
    REFERENCES `info230_SP14_skemab`.`Videos` (`idVideos`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
