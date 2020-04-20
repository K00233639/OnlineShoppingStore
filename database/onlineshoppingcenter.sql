-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2020 at 08:04 PM
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
('A01234', 'Zak', 'Tak', 'M@gmail.com', '5200b92b38effe6dc43fe6bf3e549e3704a4656f'),
('A02468', 'Zakery', 'Winston', 'Winston@gmail.com', '5200b92b38effe6dc43fe6bf3e549e3704a4656f');

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
('D3666', 'Tak', 'Taky', 'Lq@gmail.com', '84934759383', '5200b92b38effe6dc43fe6bf3e549e3704a4656f', 'USA');

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
('A2322', NULL, '23332r', 'bad', '40'),
('B1234', NULL, 'computer', 'good', '52'),
('B1236', 'Ba123', 'computer', 'bad', '99'),
('B6565', NULL, 'computera', 'good', '36'),
('C2222', NULL, 'computer', '5', '24'),
('T2113', NULL, 'Battery', 'good', '23'),
('X3333', NULL, 'Television', 'notgood', '54');

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
(NULL, '123456', '55555555', '55555', '55'),
(NULL, 'A12322', 'dssdds', '121435', '1231313'),
(NULL, 'A2322', '23332r', '12233', '12'),
(NULL, 'A543', 'fridge', 'good', '22'),
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
