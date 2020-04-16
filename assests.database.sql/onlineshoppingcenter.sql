-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2020 at 09:48 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlineshoppingcenter`
--
CREATE DATABASE IF NOT EXISTS `onlineshoppingcenter` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `onlineshoppingcenter`;

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `administratorid` varchar(10) NOT NULL,
  `Firstname` varchar(45) DEFAULT NULL,
  `Lastname` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`administratorid`, `Firstname`, `Lastname`, `email`, `password`) VALUES
('A01234', 'Zak', 'Tak', 'M@gmail.com', '5200b92b38effe6dc43fe6bf3e549e3704a4656f');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customerid` varchar(10) NOT NULL,
  `Firstname` varchar(45) DEFAULT NULL,
  `Lastname` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `phonenumber` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `Region` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerid`, `Firstname`, `Lastname`, `email`, `phonenumber`, `password`, `Region`) VALUES
('', '', 'sdfsd', 'sdf@dfsg', 'sdfg', '748ce6bf1869dc37e64f8aa9e8601f32b7d6a4cb', '1234'),
('A01234', 'qedq', 'eete3', 'wefw@gmail.com', '24213312133332', '894884a795e4d6753ae0d0e497d715487be9f02b', 'Europe'),
('A43232', 'wdwadew', 'wefwqefq', 'dsasa@gmail.com', '42145434543', '033621b7e6eb2ddf33f7a4ca9dad0094669bb2b5', 'America'),
('B02323', 'connor', 'james', 'ja@gmail.com', '5412387964', '0f82323837f19cffe4f66b996454a6e4c81e431b', 'USA'),
('B1285', 'Jane', 'Dorothy', 'a@gmail.com', '5223234556', 'Bd1234567', 'American'),
('C0987', 'Mandy', 'Dan', 'Do@gmail.com', '5867304921', '3e8b8f7519c272b2484a0c49134415f35cd054d7', 'Europe'),
('D3232', 'asaa', 'ewqw', 'qww@gmail.com', '134543635', 'a4c82710f2521ecb4db25edac5b0f1e7ac8843ec', 'USA'),
('X3434', 'Johny', 'Long', 'LJ@gmail.com', '9786453120', '5200b92b38effe6dc43fe6bf3e549e3704a4656f', 'USA');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productsid` varchar(10) NOT NULL,
  `manufacturref` varchar(10) DEFAULT NULL,
  `Name` varchar(45) DEFAULT NULL,
  `quality` varchar(45) DEFAULT NULL,
  `price` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productsid`, `manufacturref`, `Name`, `quality`, `price`) VALUES
('A112112', NULL, 'csceee23', '222222', '52'),
('A12322', NULL, 'dssdds', '121435', '1231313'),
('A2322', NULL, '23332r', '12233', '12'),
('A543', NULL, 'fridge', 'good', '22'),
('B1234', NULL, 'computer', 'good', '52'),
('B1236', 'Ba123', 'computer', 'bad', '99'),
('C2222', NULL, 'computer', '5', '24');

-- --------------------------------------------------------

--
-- Table structure for table `purchasedproducts`
--

CREATE TABLE `purchasedproducts` (
  `purchasedid` varchar(10) DEFAULT NULL,
  `shoppingkart_custid` varchar(10) DEFAULT NULL,
  `shoppingkart_prodid` varchar(10) NOT NULL,
  `customer_customerid` varchar(10) DEFAULT NULL,
  `customer_administrator_administratorid` varchar(10) DEFAULT NULL,
  `productname` varchar(45) DEFAULT NULL,
  `productquality` varchar(45) DEFAULT NULL,
  `price` varchar(45) DEFAULT NULL,
  `overallprice` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `purchasedproducts`
--

INSERT INTO `purchasedproducts` (`purchasedid`, `shoppingkart_custid`, `shoppingkart_prodid`, `customer_customerid`, `customer_administrator_administratorid`, `productname`, `productquality`, `price`, `overallprice`) VALUES
(NULL, NULL, '12232', NULL, NULL, '1q2qqw7658', 'bad', '12', NULL),
(NULL, NULL, 'A543', NULL, NULL, 'fridge', 'good', '22', NULL),
(NULL, NULL, 'C2222', NULL, NULL, 'computer', '5', '24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shoppingkart`
--

CREATE TABLE `shoppingkart` (
  `custid` varchar(10) DEFAULT NULL,
  `prodid` varchar(10) NOT NULL,
  `pname` varchar(45) DEFAULT NULL,
  `pquality` varchar(45) DEFAULT NULL,
  `price` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shoppingkart`
--

INSERT INTO `shoppingkart` (`custid`, `prodid`, `pname`, `pquality`, `price`) VALUES
(NULL, '12232', '1q2qqw7658', 'bad', '12'),
(NULL, '123456', '55555555', '55555', '55'),
(NULL, 'A12322', 'dssdds', '121435', '1231313'),
(NULL, 'A2322', '23332r', '12233', '12'),
(NULL, 'C2222', 'computer', '5', '24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`administratorid`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerid`,`Region`),
  ADD KEY `fk_customer_administrator1_idx` (`Region`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productsid`),
  ADD KEY `fk_products_administrator1_idx` (`manufacturref`);

--
-- Indexes for table `purchasedproducts`
--
ALTER TABLE `purchasedproducts`
  ADD PRIMARY KEY (`shoppingkart_prodid`),
  ADD KEY `fk_purchased products_shoppingkart1_idx` (`shoppingkart_custid`,`shoppingkart_prodid`),
  ADD KEY `fk_purchased products_customer1_idx` (`customer_customerid`,`customer_administrator_administratorid`);

--
-- Indexes for table `shoppingkart`
--
ALTER TABLE `shoppingkart`
  ADD PRIMARY KEY (`prodid`),
  ADD KEY `fk_customer_has_products_products1_idx` (`prodid`),
  ADD KEY `fk_customer_has_products_customer_idx` (`custid`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_administrator1` FOREIGN KEY (`manufacturref`) REFERENCES `administrator` (`administratorid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchasedproducts`
--
ALTER TABLE `purchasedproducts`
  ADD CONSTRAINT `fk_purchased products_customer1` FOREIGN KEY (`customer_customerid`,`customer_administrator_administratorid`) REFERENCES `customer` (`customerid`, `Region`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_purchased products_shoppingkart1` FOREIGN KEY (`shoppingkart_custid`,`shoppingkart_prodid`) REFERENCES `shoppingkart` (`custid`, `prodid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `shoppingkart`
--
ALTER TABLE `shoppingkart`
  ADD CONSTRAINT `fk_customer_has_products_customer` FOREIGN KEY (`custid`) REFERENCES `customer` (`customerid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
