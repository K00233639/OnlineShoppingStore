-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema onlineshoppingcenterv2
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `onlineshoppingcenterv2` ;

-- -----------------------------------------------------
-- Schema onlineshoppingcenterv2
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `onlineshoppingcenterv2` DEFAULT CHARACTER SET utf8 ;
USE `onlineshoppingcenterv2` ;

-- -----------------------------------------------------
-- Table `onlineshoppingcenterv2`.`User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `onlineshoppingcenterv2`.`User` (
  `Id` INT NULL AUTO_INCREMENT,
  `Address` VARCHAR(45) NOT NULL,
  `Email` VARCHAR(45) NOT NULL,
  `Firstname` VARCHAR(45) NULL DEFAULT NULL,
  `Lastname` VARCHAR(45) NULL DEFAULT NULL,
  `TelephoneNumber` VARCHAR(45) NULL DEFAULT NULL,
  `Password` VARCHAR(255) NOT NULL,
  `Username` VARCHAR(45) NOT NULL,
  `IsAdmin` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`),
  INDEX `fk_customer_administrator1_idx` (`Address` ASC),
  UNIQUE INDEX `Email_UNIQUE` (`Email` ASC),
  UNIQUE INDEX `Username_UNIQUE` (`Username` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `onlineshoppingcenterv2`.`Product`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `onlineshoppingcenterv2`.`Product` (
  `Id` INT NULL AUTO_INCREMENT,
  `Name` VARCHAR(45) NOT NULL,
  `Description` VARCHAR(45) NULL DEFAULT NULL,
  `Price` FLOAT NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`),
  UNIQUE INDEX `Name_UNIQUE` (`Name` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `onlineshoppingcenterv2`.`OrderStatus`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `onlineshoppingcenterv2`.`OrderStatus` (
  `Id` INT NULL AUTO_INCREMENT,
  `Label` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE INDEX `Label_UNIQUE` (`Label` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `onlineshoppingcenterv2`.`Order`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `onlineshoppingcenterv2`.`Order` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Customer` INT NOT NULL,
  `TimeOfPurchase` DATETIME NOT NULL DEFAULT now(),
  `TotalCost` FLOAT NOT NULL DEFAULT 0.0,
  `OrderStatus_Id` INT NOT NULL,
  INDEX `fk_customer_has_products_products1_idx` (`Id` ASC),
  INDEX `fk_ShoppingCart_User1_idx` (`Customer` ASC),
  PRIMARY KEY (`Id`),
  INDEX `fk_Order_OrderStatus1_idx` (`OrderStatus_Id` ASC),
  CONSTRAINT `fk_ShoppingCart_User10`
    FOREIGN KEY (`Customer`)
    REFERENCES `onlineshoppingcenterv2`.`User` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Order_OrderStatus1`
    FOREIGN KEY (`OrderStatus_Id`)
    REFERENCES `onlineshoppingcenterv2`.`OrderStatus` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `onlineshoppingcenterv2`.`OrderItem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `onlineshoppingcenterv2`.`OrderItem` (
  `Order` INT NOT NULL,
  `Product` INT NOT NULL,
  `Quanity` INT NOT NULL DEFAULT 1,
  `TimeOfPurchase` DATETIME NOT NULL DEFAULT now(),
  PRIMARY KEY (`Order`, `Product`),
  INDEX `fk_ShoppingCartItem_ShoppingCart1_idx` (`Order` ASC),
  INDEX `fk_ShoppingCartItem_Product1_idx` (`Product` ASC),
  CONSTRAINT `fk_ShoppingCartItem_ShoppingCart1`
    FOREIGN KEY (`Order`)
    REFERENCES `onlineshoppingcenterv2`.`Order` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ShoppingCartItem_Product1`
    FOREIGN KEY (`Product`)
    REFERENCES `onlineshoppingcenterv2`.`Product` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `onlineshoppingcenterv2`.`User`
-- -----------------------------------------------------
START TRANSACTION;
USE `onlineshoppingcenterv2`;
INSERT INTO `onlineshoppingcenterv2`.`User` (`Id`, `Address`, `Email`, `Firstname`, `Lastname`, `TelephoneNumber`, `Password`, `Username`, `IsAdmin`) VALUES (1, 'blah', 'admin@lit.ie', 'Zaki', 'Al Akkari', '123456789', '5200b92b38effe6dc43fe6bf3e549e3704a4656f', 'Admin', 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `onlineshoppingcenterv2`.`Product`
-- -----------------------------------------------------
START TRANSACTION;
USE `onlineshoppingcenterv2`;
INSERT INTO `onlineshoppingcenterv2`.`Product` (`Id`, `Name`, `Description`, `Price`) VALUES (1, 'Computer', 'Dell', 100);
INSERT INTO `onlineshoppingcenterv2`.`Product` (`Id`, `Name`, `Description`, `Price`) VALUES (2, 'Phone', 'Apple', 20);
INSERT INTO `onlineshoppingcenterv2`.`Product` (`Id`, `Name`, `Description`, `Price`) VALUES (3, 'Biscuits', 'Towergate', 1.99);

COMMIT;


-- -----------------------------------------------------
-- Data for table `onlineshoppingcenterv2`.`OrderStatus`
-- -----------------------------------------------------
START TRANSACTION;
USE `onlineshoppingcenterv2`;
INSERT INTO `onlineshoppingcenterv2`.`OrderStatus` (`Id`, `Label`) VALUES (1, 'In Progress');
INSERT INTO `onlineshoppingcenterv2`.`OrderStatus` (`Id`, `Label`) VALUES (2, 'Complete');

COMMIT;

