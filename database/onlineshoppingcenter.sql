CREATE DATABASE  IF NOT EXISTS `onlineshoppingcenter` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `onlineshoppingcenter`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: onlineshoppingcenter
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.11-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `administrator`
--

DROP TABLE IF EXISTS `administrator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administrator` (
  `administratorid` varchar(10) NOT NULL,
  `Firstname` varchar(45) DEFAULT NULL,
  `Lastname` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`administratorid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrator`
--

LOCK TABLES `administrator` WRITE;
/*!40000 ALTER TABLE `administrator` DISABLE KEYS */;
/*!40000 ALTER TABLE `administrator` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `customerid` varchar(10) NOT NULL,
  `Firstname` varchar(45) DEFAULT NULL,
  `Lastname` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `phonenumber` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `administrator_administratorid` varchar(10) NOT NULL,
  PRIMARY KEY (`customerid`,`administrator_administratorid`),
  KEY `fk_customer_administrator1_idx` (`administrator_administratorid`),
  CONSTRAINT `fk_customer_administrator1` FOREIGN KEY (`administrator_administratorid`) REFERENCES `administrator` (`administratorid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `productsid` varchar(10) NOT NULL,
  `administrator_administratorid` varchar(10) NOT NULL,
  `Name` varchar(45) DEFAULT NULL,
  `quality` varchar(45) DEFAULT NULL,
  `price` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`productsid`,`administrator_administratorid`),
  KEY `fk_products_administrator1_idx` (`administrator_administratorid`),
  CONSTRAINT `fk_products_administrator1` FOREIGN KEY (`administrator_administratorid`) REFERENCES `administrator` (`administratorid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchased products`
--

DROP TABLE IF EXISTS `purchased products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchased products` (
  `purchasedid` varchar(10) NOT NULL,
  `shoppingkart_custid` varchar(10) NOT NULL,
  `shoppingkart_prodid` varchar(10) NOT NULL,
  `customer_customerid` varchar(10) NOT NULL,
  `customer_administrator_administratorid` varchar(10) NOT NULL,
  `productname` varchar(45) DEFAULT NULL,
  `productquality` varchar(45) DEFAULT NULL,
  `price` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`purchasedid`,`shoppingkart_custid`,`shoppingkart_prodid`),
  KEY `fk_purchased products_shoppingkart1_idx` (`shoppingkart_custid`,`shoppingkart_prodid`),
  KEY `fk_purchased products_customer1_idx` (`customer_customerid`,`customer_administrator_administratorid`),
  CONSTRAINT `fk_purchased products_customer1` FOREIGN KEY (`customer_customerid`, `customer_administrator_administratorid`) REFERENCES `customer` (`customerid`, `administrator_administratorid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_purchased products_shoppingkart1` FOREIGN KEY (`shoppingkart_custid`, `shoppingkart_prodid`) REFERENCES `shoppingkart` (`custid`, `prodid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchased products`
--

LOCK TABLES `purchased products` WRITE;
/*!40000 ALTER TABLE `purchased products` DISABLE KEYS */;
/*!40000 ALTER TABLE `purchased products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shoppingkart`
--

DROP TABLE IF EXISTS `shoppingkart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shoppingkart` (
  `custid` varchar(10) NOT NULL,
  `prodid` varchar(10) NOT NULL,
  `overallprice` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`custid`,`prodid`),
  KEY `fk_customer_has_products_products1_idx` (`prodid`),
  KEY `fk_customer_has_products_customer_idx` (`custid`),
  CONSTRAINT `fk_customer_has_products_customer` FOREIGN KEY (`custid`) REFERENCES `customer` (`customerid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_customer_has_products_products1` FOREIGN KEY (`prodid`) REFERENCES `products` (`productsid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoppingkart`
--

LOCK TABLES `shoppingkart` WRITE;
/*!40000 ALTER TABLE `shoppingkart` DISABLE KEYS */;
/*!40000 ALTER TABLE `shoppingkart` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-03-27 20:34:12
