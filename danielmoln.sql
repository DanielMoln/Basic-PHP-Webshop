-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: mysql.caesar.elte.hu
-- Generation Time: Dec 30, 2024 at 02:27 PM
-- Server version: 5.5.60-0+deb7u1
-- PHP Version: 5.6.40-0+deb8u12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `danielmoln`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `userID`, `productID`, `quantity`) VALUES
(19, 2, 131, 1),
(20, 3, 128, 1),
(21, 3, 129, 1),
(22, 3, 131, 1),
(23, 2, 132, 15),
(24, 2, 128, 1),
(25, 2, 128, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `preview` varchar(2000) NOT NULL,
  `name` varchar(500) NOT NULL,
  `category` enum('animal','architecture','characters','') NOT NULL,
  `price` int(11) NOT NULL,
  `license` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `preview`, `name`, `category`, `price`, `license`) VALUES
(128, 'https://assets.superhivemarket.com/store/product/222763/image/large-28a58f4c775a5ece568adf1273be5226.jpg', 'Utcai kellékek', 'architecture', 50, 'Creative Commons'),
(129, 'https://media.sketchfab.com/models/cb228dcc137042cc9a3dc588758cc6e9/fallbacks/6181a19167ec4e4d81f103b70ab4ff76/9530a5b76fc946edaf6bb135f94ccb9e.jpeg', 'Steve', 'characters', 32, 'Creative Commons'),
(131, 'https://assets.superhivemarket.com/store/product/223941/image/medium-458bcbdb9450bf36fa45c56cbd3931de.png', 'Rottweiler', 'animal', 50, 'Creative common'),
(132, 'https://assets.superhivemarket.com/store/product/163410/image/medium-dffb4b179e68a3cbc98b45f4ecd1b062.jpg', 'Mamut', 'animal', 300, 'Creative Common'),
(133, 'https://assets.superhivemarket.com/store/product/163410/image/medium-dffb4b179e68a3cbc98b45f4ecd1b062.jpg', 'Mamut', 'animal', 300, 'Creative Common');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL,
  `password` varchar(1000) CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0',
  `money` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `isAdmin`, `money`) VALUES
(2, 'PWO08K', '$2y$10$fW8HO4IMEUz1onSuXfHx0.HpiJOsbDjXwhaf/IKiBk6OHOf/qd3lS', 1, 0),
(3, 'Sanyi', '$2y$10$zrZ1KB0kUCNMJM3SkapEYekLxBSDunvgzyw5aTKkqEj2Pj3plWpyG', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
