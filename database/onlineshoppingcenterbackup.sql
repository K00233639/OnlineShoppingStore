-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema onlineshoppingcenter
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema onlineshoppingcenter
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `onlineshoppingcenter` DEFAULT CHARACTER SET utf8 ;
USE `onlineshoppingcenter` ;

-- -----------------------------------------------------
-- Table `onlineshoppingcenter`.`administrator`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `onlineshoppingcenter`.`administrator` (
  `administratorid` VARCHAR(10) NOT NULL,
  `Firstname` VARCHAR(45) NULL DEFAULT NULL,
  `Lastname` VARCHAR(45) NULL DEFAULT NULL,
  `email` VARCHAR(45) NULL DEFAULT NULL,
  `password` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`administratorid`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `onlineshoppingcenter`.`customer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `onlineshoppingcenter`.`customer` (
  `customerid` VARCHAR(10) NOT NULL,
  `Firstname` VARCHAR(45) NULL DEFAULT NULL,
  `Lastname` VARCHAR(45) NULL DEFAULT NULL,
  `email` VARCHAR(45) NULL DEFAULT NULL,
  `phonenumber` VARCHAR(45) NULL DEFAULT NULL,
  `password` VARCHAR(45) NULL DEFAULT NULL,
  `Region` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`customerid`, `Region`),
  INDEX `fk_customer_administrator1_idx` (`Region` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `onlineshoppingcenter`.`products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `onlineshoppingcenter`.`products` (
  `productsid` VARCHAR(10) NOT NULL,
  `manufacturref` VARCHAR(10) NULL DEFAULT NULL,
  `Name` VARCHAR(45) NULL DEFAULT NULL,
  `quality` VARCHAR(45) NULL DEFAULT NULL,
  `price` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`productsid`),
  INDEX `fk_products_administrator1_idx` (`manufacturref` ASC),
  CONSTRAINT `fk_products_administrator1`
    FOREIGN KEY (`manufacturref`)
    REFERENCES `onlineshoppingcenter`.`administrator` (`administratorid`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `onlineshoppingcenter`.`shoppingkart`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `onlineshoppingcenter`.`shoppingkart` (
  `custid` VARCHAR(10) NULL DEFAULT NULL,
  `prodid` VARCHAR(10) NOT NULL,
  `pname` VARCHAR(45) NULL DEFAULT NULL,
  `pquality` VARCHAR(45) NULL DEFAULT NULL,
  `price` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`prodid`),
  INDEX `fk_customer_has_products_products1_idx` (`prodid` ASC),
  INDEX `fk_customer_has_products_customer_idx` (`custid` ASC),
  CONSTRAINT `fk_customer_has_products_customer`
    FOREIGN KEY (`custid`)
    REFERENCES `onlineshoppingcenter`.`customer` (`customerid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_customer_has_products_products1`
    FOREIGN KEY (`prodid`)
    REFERENCES `onlineshoppingcenter`.`products` (`productsid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `onlineshoppingcenter`.`purchasedproducts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `onlineshoppingcenter`.`purchasedproducts` (
  `purchasedid` VARCHAR(10) NULL DEFAULT NULL,
  `shoppingkart_custid` VARCHAR(10) NULL DEFAULT NULL,
  `shoppingkart_prodid` VARCHAR(10) NOT NULL,
  `customer_customerid` VARCHAR(10) NULL DEFAULT NULL,
  `customer_administrator_administratorid` VARCHAR(10) NULL DEFAULT NULL,
  `productname` VARCHAR(45) NULL DEFAULT NULL,
  `productquality` VARCHAR(45) NULL DEFAULT NULL,
  `price` VARCHAR(45) NULL DEFAULT NULL,
  `overallprice` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`shoppingkart_prodid`),
  INDEX `fk_purchased products_shoppingkart1_idx` (`shoppingkart_custid` ASC, `shoppingkart_prodid` ASC),
  INDEX `fk_purchased products_customer1_idx` (`customer_customerid` ASC, `customer_administrator_administratorid` ASC),
  CONSTRAINT `fk_purchased products_customer1`
    FOREIGN KEY (`customer_customerid` , `customer_administrator_administratorid`)
    REFERENCES `onlineshoppingcenter`.`customer` (`customerid` , `Region`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_purchased products_shoppingkart1`
    FOREIGN KEY (`shoppingkart_custid` , `shoppingkart_prodid`)
    REFERENCES `onlineshoppingcenter`.`shoppingkart` (`custid` , `prodid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
