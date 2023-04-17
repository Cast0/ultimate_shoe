-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2023 at 11:04 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kads`
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
(1, 'Sushi Rolls'),
(2, 'Bento Box'),
(3, 'Temaki Wraps'),
(6, 'Platters'),
(7, 'Cakes');

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
(18, 'Alvy', 'Depositar', '2001-08-13', 'aldepositar2020@plm.edu.ph', '09123456789', '$2y$10$1hvaK7LXmrV2KmhKxpKh/OTGve6h07d4HrZpEbL45l0kXP5B8nUz.', 2, '1215 Mithi St., Tondo', 'Caloocan', 'Metro Manila', 1012),
(19, 'Cheska Louisse', 'Francisco', '2002-12-12', 'clafrancisco2020@plm.edu.ph', '09123456789', '$2y$10$2YrgJi3eoLrpCAcpdW7zGe2cIWTjfE2KuJaC5KrLf/V9fddQOa5Gu', 2, '123 MOA St', 'Caloocan', 'Metro Manila', 1013);

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
(8, 'IMG-63b85f55e30814.16050105.png', 'Salmon Roll', 190, 1),
(10, 'IMG-63b85f6e7ab867.21949032.png', 'Kani Roll', 150, 1),
(11, 'IMG-63b85f8b343056.80089378.png', 'BNY Roll', 230, 1),
(12, 'IMG-63b85f9a1adb86.83227212.png', 'Bonito Roll', 185, 1),
(13, 'IMG-63b85fa186c036.43296471.png', 'California Roll', 230, 1),
(14, 'IMG-63b85fab878042.97388770.png', 'Crazy Kani Roll', 220, 1),
(15, 'IMG-63b85fb9c79542.80524625.png', 'Golden Roll', 190, 1),
(16, 'IMG-63b85fcfa01602.65640887.png', 'Lava Roll', 250, 1),
(17, 'IMG-63b85ff49e4382.66362994.png', 'OG Roll', 390, 1),
(18, 'IMG-63b8600be5b008.84541368.png', 'Spicy Tuna Roll', 250, 1),
(19, 'IMG-63b8601b1c1796.23705063.png', 'Spicy Kani Roll', 290, 1),
(20, 'IMG-63b86038176741.49207115.png', 'Sunshine Roll', 350, 1),
(21, 'IMG-63b8604949bc39.68325891.png', 'Super Cali Roll', 390, 1),
(22, 'IMG-63b86055e9a126.42208117.png', 'Tamago Roll', 150, 1),
(23, 'IMG-63b8606e965108.13347397.png', 'Tuna Roll', 190, 1),
(24, 'IMG-63b8607c5c2513.91181968.png', 'Wakame Roll', 230, 1),
(25, 'IMG-63b86086057a56.72885709.png', 'Caramba Roll', 250, 1),
(26, 'IMG-63b860eeb1ba75.23920111.png', 'Caramba Temaki', 250, 3),
(27, 'IMG-63b862c9892099.05667644.png', 'California Temaki', 190, 3),
(28, 'IMG-63b862e8688139.14303407.png', 'Chicken Winner Roll', 230, 1),
(29, 'IMG-63b8632f2f5761.70903125.png', 'Cloud 9 Roll', 250, 1),
(30, 'IMG-63b8636234f0f7.29795206.png', 'Fireball Roll', 290, 1),
(31, 'IMG-63b863748644b0.01812730.png', 'Godzilla Roll', 330, 1),
(32, 'IMG-63b8639dca4ef0.90948589.png', 'Firecracker Roll', 220, 1),
(33, 'IMG-63b863c989a2d7.51811383.png', 'Crazy Kani Temaki', 190, 3),
(34, 'IMG-63b863e5b4bd91.86541466.png', 'Firecracker Temaki', 200, 3),
(35, 'IMG-63b8640a01de35.26894582.png', 'Okonomiya Temaki', 200, 3),
(36, 'IMG-63b864356c3d08.39590278.png', 'Sushi Dreams Temaki', 230, 3),
(37, 'IMG-63b86462bf1dd8.52349637.png', 'Aburi Mix Bento', 500, 2),
(38, 'IMG-63b8654d2ba1f1.72871302.png', 'Classic Mix Bento', 500, 2),
(39, 'IMG-63b8658b0bdf63.73682690.png', 'Salmon Overload Bento', 600, 2),
(40, 'IMG-63b865af5c54a1.15080877.png', 'Tuna Overload Bento', 600, 2),
(41, 'IMG-63b86600ab6c78.98186216.png', 'Basic Party Platter', 1500, 6),
(42, 'IMG-63b866423d5a85.60123403.png', 'Deluxe Party Platter', 1900, 6),
(43, 'IMG-63b86668b88257.72776792.png', 'Poke Party Platter', 2300, 6),
(44, 'IMG-63b8669176d383.37165719.png', 'Premium Party Platter', 2500, 6),
(45, 'IMG-63b866b2916cc6.42531744.png', 'Veggie Sushi Cake', 1300, 7),
(46, 'IMG-63b866edf05e79.94782112.png', 'Classic Sushi Cake', 1500, 7),
(47, 'IMG-63b8670fbf3a23.47768244.png', 'Rose Sushi Cake', 1500, 7),
(48, 'IMG-63b8672ad3c850.20096925.png', 'Spicy Sushi Cake', 1500, 7),
(49, 'IMG-63c3e0dd99cdc1.47704691.png', 'Cucumber Roll', 100, 1);

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
-- Dumping data for table `user_orders`
--

INSERT INTO `user_orders` (`id`, `order_number`, `product_id`, `quantity`, `date`, `status`, `user_id`) VALUES
(7, 2, 11, 1, '2023-01-16 03:44:49', 3, 18),
(8, 3, 11, 1, '2023-01-16 06:57:36', 3, 19),
(9, 3, 12, 6, '2023-01-16 06:57:36', 3, 19),
(10, 4, 11, 5, '2023-01-17 02:57:30', 3, 19),
(11, 4, 8, 1, '2023-01-17 02:57:30', 3, 19),
(12, 4, 12, 1, '2023-01-17 02:57:30', 3, 19),
(13, 4, 48, 1, '2023-01-17 02:57:30', 3, 19),
(14, 5, 48, 4, '2023-01-17 03:04:44', 3, 18),
(15, 6, 48, 1, '2023-01-17 03:05:35', 3, 18),
(16, 7, 8, 3, '2023-01-17 03:06:32', 3, 18),
(17, 8, 12, 4, '2023-01-17 03:10:08', 3, 18),
(18, 9, 17, 1, '2023-01-17 03:14:42', 3, 18),
(19, 9, 18, 1, '2023-01-17 03:14:42', 3, 18),
(20, 10, 16, 1, '2023-01-17 03:21:35', 3, 18),
(21, 10, 13, 1, '2023-01-17 03:21:35', 3, 18);

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
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `info_accts`
--
ALTER TABLE `info_accts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

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
