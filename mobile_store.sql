-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 03, 2017 at 12:06 PM
-- Server version: 5.7.19-0ubuntu0.16.04.1
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mobile_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id` int(2) UNSIGNED NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'gost',
  `obrisan` int(1) NOT NULL DEFAULT '0',
  `token` varchar(256) NOT NULL,
  `istek` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `first_name`, `last_name`, `email`, `password`, `status`, `obrisan`, `token`, `istek`) VALUES
(1, 'admin', 'admin', 'admin@mail.com', '$2y$10$svBMnHzK3L1tKN8LC.jNM.k1ls4LGvodN4N0pFyyAyY5ybOjn4ccu', 'admin', 0, '', NULL),
(2, 'guest', 'guest', 'guest@mail.com', '$2y$10$3yP0H4nB6NKhbG710hxVnOudjpS3hcJ42VdZImfqnHPuZvCfcm9yC', 'gost', 0, '', NULL),
(3, 'mile', 'mile', 'mile@mail.com', '$2y$10$CH45cWflanl1y5sQHyZrC.yWbBIsFA./F6PD5p2DGc6GrNgpDZ.qu', 'gost', 0, '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `korpa`
--

CREATE TABLE `korpa` (
  `id` int(3) UNSIGNED NOT NULL,
  `idkupca` int(3) NOT NULL,
  `idproizvoda` int(3) NOT NULL,
  `model` varchar(50) NOT NULL,
  `kolicina` int(2) NOT NULL,
  `kupljen` int(1) NOT NULL DEFAULT '0',
  `datumnaruzbine` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `datumkupovine` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `korpa`
--

INSERT INTO `korpa` (`id`, `idkupca`, `idproizvoda`, `model`, `kolicina`, `kupljen`, `datumnaruzbine`, `datumkupovine`) VALUES
(1, 2, 1, 'Samsung J3', 1, 0, '2017-09-02 10:45:40', NULL),
(2, 2, 2, 'Samsung J5', 1, 0, '2017-09-02 10:45:44', NULL),
(3, 2, 4, 'Huawei P9 LITE', 1, 0, '2017-09-02 11:06:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `proizvodjaci`
--

CREATE TABLE `proizvodjaci` (
  `id` int(2) UNSIGNED NOT NULL,
  `naziv` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `proizvodjaci`
--

INSERT INTO `proizvodjaci` (`id`, `naziv`) VALUES
(1, 'alcatel'),
(2, 'sony'),
(3, 'samsung'),
(4, 'iphone'),
(5, 'huawei'),
(6, 'htc');

-- --------------------------------------------------------

--
-- Table structure for table `telefoni`
--

CREATE TABLE `telefoni` (
  `id` int(3) UNSIGNED NOT NULL,
  `model` varchar(100) NOT NULL,
  `cena` varchar(100) NOT NULL,
  `slika` varchar(100) DEFAULT NULL,
  `id_proizvodjaca` int(3) NOT NULL,
  `obrisan` int(1) NOT NULL DEFAULT '0',
  `sistem` varchar(100) NOT NULL,
  `ekran` varchar(100) NOT NULL,
  `memorija` varchar(100) NOT NULL,
  `kamera` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `telefoni`
--

INSERT INTO `telefoni` (`id`, `model`, `cena`, `slika`, `id_proizvodjaca`, `obrisan`, `sistem`, `ekran`, `memorija`, `kamera`) VALUES
(1, 'Samsung J3', '250', 'samsung1.jpg', 3, 0, 'Android 5.1', '5', '34Mpix', '24GB RAM'),
(2, 'Samsung J5', '350', 'samsung2.jpg', 3, 0, 'Android 6.0', '5.2', '13Mpix', '2 GB RAM'),
(3, 'Huawei P8 LITE', '400', 'huawei.jpg', 5, 0, 'Android 5.0', '5"', '13Mpix', '2 GB RAM'),
(4, 'Huawei P9 LITE', '450', 'huawei1.jpg', 5, 0, 'Android 6.0', '5.2"', '13Mpix', '2 GB RAM'),
(5, 'Sony XPERIA E5', '450', 'sony.jpg', 2, 0, 'Android 6.0', '5"', '13Mpix', '1.5 GB RAM'),
(6, 'APPLE IPHONE 7 32GB ', '700', 'iphone.jpg', 4, 0, 'iOS 10', '4.7"', '-', '12 Mpix'),
(7, 'ALCATEL PIXI 4', '100', 'mobile.jpg', 1, 0, 'Android 6.0', '5"', '5 Mpix', '1 GB RAM'),
(8, 'HTC 10', '800', '1485978742.jpg', 6, 0, 'Android 6.0', '5.2', '4 GB RAM', '14 Mpix'),
(9, 'iphone 5', '500', '1503823833.jpg', 4, 0, 'ios', '5"', '12GB', '12mpx');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `korpa`
--
ALTER TABLE `korpa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proizvodjaci`
--
ALTER TABLE `proizvodjaci`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `telefoni`
--
ALTER TABLE `telefoni`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `korpa`
--
ALTER TABLE `korpa`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `proizvodjaci`
--
ALTER TABLE `proizvodjaci`
  MODIFY `id` int(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `telefoni`
--
ALTER TABLE `telefoni`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
