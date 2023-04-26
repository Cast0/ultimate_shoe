-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2023 at 04:23 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ultimate_shoe`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `c_id` int(11) NOT NULL,
  `categoryName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`c_id`, `categoryName`) VALUES
(1, 'Nike'),
(2, 'New Balance'),
(3, 'Asics'),
(6, 'Adidas'),
(7, 'Under Armour'),
(10, 'Vans'),
(11, 'Converse');

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `f_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `info_accts`
--

CREATE TABLE `info_accts` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `house` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `zip` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `info_accts`
--

INSERT INTO `info_accts` (`id`, `firstname`, `lastname`, `birthday`, `username`, `phone`, `password`, `role`, `house`, `city`, `province`, `zip`) VALUES
(12, 'Admin', 'Admin', '2001-08-13', 'admin', '09123456789', '$2y$10$HkVmVdmQHxyQE0ARqbPej.pmBGopjlUjj/ZQpFYLH6mFWwPn2tJ0G', 1, NULL, NULL, NULL, NULL),
(20, 'Crizelle', 'Bernardo', '2003-05-26', 'cheng', '09672637123', '$2y$10$ZgswubE.mVYCs77g4ApkDuBZUKNFdYEp/KkRc26HCWm.MeqnnPVoS', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `p_id` int(11) NOT NULL,
  `image` varchar(400) DEFAULT NULL,
  `productName` varchar(255) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `category` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`p_id`, `image`, `productName`, `price`, `category`) VALUES
(50, 'IMG-643db09dc7b5e7.36269645.png', 'NIKE Air Force 1', 6000, 1),
(53, 'IMG-643db8b4a34048.06774213.png', 'Nike Air Max 270', 7800, 1),
(55, 'IMG-644920695d2be0.14162186.jpg', 'Air Jordan 1 Low', 6195, 1),
(56, 'IMG-644920d4ebd861.09011377.jpg', 'Nike Dunk Low Retro Premium', 4339, 1),
(57, 'IMG-644920ff049f33.74459479.jpg', 'Nike Air Pegasus SE', 4400, 1),
(58, 'IMG-6449215e5f8096.24494027.jpg', 'Nike Dunk Low Retro Premium', 5000, 1),
(59, 'IMG-6449217586e215.35371853.jpg', 'Nike Air Pegasus 83 SE', 4600, 1),
(60, 'IMG-644922b7a95442.99993099.png', 'Adidas NMD R1 PRIMEBLUE', 8000, 6),
(61, 'IMG-644922fbc4c019.98699943.png', 'Adidas Superstar Shoes', 5300, 6),
(62, 'IMG-64492319620d38.20215687.png', 'Adidas Forum Low Shoes', 5000, 6),
(63, 'IMG-6449232cc9f111.43726410.png', 'Adidas Duramo 10 Shoes', 3500, 6),
(64, 'IMG-6449234064f1c4.35012223.png', 'Adidas Daily 3.0 Shoes', 3300, 6),
(65, 'IMG-6449236ae94455.83042826.png', 'Adidas EQ21 Run Shoes', 4500, 6),
(66, 'IMG-6449238ca1b669.43659152.png', 'Adidas Ultra 4DFWD Shoes', 14000, 6),
(67, 'IMG-644923b2140de7.68652859.png', 'Adidas Campus 00S Shoes', 5000, 6),
(68, 'IMG-6449250ec81419.92970358.png', 'Vans Authentic Black', 3336, 10),
(69, 'IMG-644925365799c5.93846356.png', 'Vans SK8 HI Shoe', 4448, 10),
(70, 'IMG-6449255ccffef2.78119277.png', 'Vans Canvas Old Skool Shoe', 3892, 10),
(71, 'IMG-644925801165c0.46122529.png', 'Vans Checkerboard Slip On Shoe', 3616, 10),
(72, 'IMG-6449259dcbef99.06446410.png', 'Vans Slip On Shoe', 3338, 10),
(73, 'IMG-644925b6ed8d95.72955469.png', 'New Balance 580', 7785, 2),
(74, 'IMG-644925e8cfdf15.76657611.png', 'New Balance MADE in USA 990v5 Core', 9735, 2),
(75, 'IMG-644926040d3ce2.16893425.png', 'New Balance 550', 6127, 2),
(76, 'IMG-6449262729c889.08557107.png', 'New Balance 574 Core', 4731, 2),
(77, 'IMG-6449265bd6a228.03850669.png', 'New Balance 9060', 8351, 2),
(78, 'IMG-644928684f5f83.36289116.png', 'Converse Ready To Ride', 3923, 11),
(79, 'IMG-6449287ff1f8e7.94795281.png', 'Converse Vintage Pro', 3923, 11),
(80, 'IMG-644928ebc400d7.21273471.png', 'Converse Chuck Taylor', 3923, 11),
(81, 'IMG-644929001cb6c0.24980600.png', 'Converse Chuck Taylor', 3923, 11),
(82, 'IMG-6449291cdce6d0.10971966.jpg', 'Converse Chuck Taylor All Star Classic', 3923, 11),
(83, 'IMG-644929cd284a80.81964607.png', 'NETBURNER BALLISTIC FF MT 2', 7890, 3),
(84, 'IMG-644929e71375d6.69931854.png', 'NOOSA TRI 13', 7990, 3),
(85, 'IMG-64492a0d782e90.64022887.png', 'ASICS GEL 1130', 6890, 3),
(86, 'IMG-64492a2c09be97.24339803.png', 'SKY ELITE FF 2 TOKYO', 7890, 3),
(87, 'IMG-64492a457d8f75.29391667.png', 'GEL NETBURNER ACADEMY 9 ', 7590, 2),
(88, 'IMG-64492a8029a266.23027890.png', 'Curry Flow 10 \"Unicorn & Butterfly\" Basketball Shoes (Unisex)', 9195, 7),
(89, 'IMG-64492aa2dc23f5.41418157.png', 'Curry 2 Low FloTro Basketball Shoes (Unisex)', 9195, 7),
(90, 'IMG-64492ac9852f92.41698464.png', 'Project Rock 5 Training Shoes (Men)', 8995, 7),
(91, 'IMG-64492af36b5ea1.50011352.png', 'UA Charged Assert 9 Iridescent Running Shoes (Women', 2995, 7),
(92, 'IMG-64492b36c2d614.21247289.png', 'UA HOVR Phantom 3 Running Shoes (Men)', 8995, 7);

-- --------------------------------------------------------

--
-- Table structure for table `user_orders`
--

CREATE TABLE `user_orders` (
  `id` int(11) NOT NULL,
  `order_number` int(11) NOT NULL,
  `product_id` int(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`f_id`);

--
-- Indexes for table `info_accts`
--
ALTER TABLE `info_accts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `products_ibfk` (`category`);

--
-- Indexes for table `user_orders`
--
ALTER TABLE `user_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_orders_ibfk` (`user_id`),
  ADD KEY `orders_ibfk` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `info_accts`
--
ALTER TABLE `info_accts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `user_orders`
--
ALTER TABLE `user_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk` FOREIGN KEY (`category`) REFERENCES `categories` (`c_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_orders`
--
ALTER TABLE `user_orders`
  ADD CONSTRAINT `orders_ibfk` FOREIGN KEY (`product_id`) REFERENCES `products` (`p_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_orders_ibfk` FOREIGN KEY (`user_id`) REFERENCES `info_accts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
