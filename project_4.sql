-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2024 at 08:06 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_4`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ID` int(11) NOT NULL,
  `product_id` varchar(36) NOT NULL,
  `product_name` text NOT NULL,
  `product_img_path` varchar(255) NOT NULL,
  `categories` text NOT NULL,
  `stock_count` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `discount_percentage` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ID`, `product_id`, `product_name`, `product_img_path`, `categories`, `stock_count`, `price`, `discount_percentage`, `created_at`, `updated_at`) VALUES
(4, 'MPS-67148a96', 'testing', '67148a9626cf2_Screenshot 2024-10-12 065406.png', 'Apparel', 21, 155, 0, '2024-10-20 04:44:06', '2024-10-26 04:29:48'),
(5, 'MPS-671b0d6d', 'ARWEREW', '671b0d6d01010_462536573_548384071119094_8996577890262821736_n.jpg', 'T-shirt', 22, 2, 20, '2024-10-25 03:15:57', '2024-10-26 05:53:27'),
(6, 'MPS-671c83ed', 'dog', '671c83edc7087_Screenshot 2024-10-01 183217.png', 'Mugs &amp; Drinkware', 5, 25, 20, '2024-10-26 05:53:49', '2024-10-26 05:53:49');

-- --------------------------------------------------------

--
-- Table structure for table `registered_users`
--

CREATE TABLE `registered_users` (
  `ID` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_number` int(20) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verify_status` enum('unverified','verified') NOT NULL DEFAULT 'unverified',
  `verification_token` varchar(255) NOT NULL,
  `user_type` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registered_users`
--

INSERT INTO `registered_users` (`ID`, `user_id`, `full_name`, `email`, `contact_number`, `gender`, `address`, `password`, `verify_status`, `verification_token`, `user_type`, `created_at`, `updated_at`) VALUES
(27, 'user_671c6330dbfbf', 'kaizen', 'kaizenthebeast@gmail.com', 0, '', '', '$2y$10$rJdS1iZFEgDu5gIEBLVaN.3MukRgqFefNOiDs85JxjxQZ2EJPXgmy', 'verified', 'f8982e069bdb094f2ecf279403d163419e43a3d33e91a7ca3dea9426d6f287bf', 'user', '2024-10-26 03:34:08', '2024-10-26 03:34:32');

-- --------------------------------------------------------

--
-- Table structure for table `user_orders`
--

CREATE TABLE `user_orders` (
  `ID` int(11) NOT NULL,
  `order_ID` varchar(255) NOT NULL,
  `order_status` enum('Pending','Complete','Ready') NOT NULL DEFAULT 'Pending',
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `product_id` varchar(36) NOT NULL,
  `product_price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `vat` decimal(10,2) DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL,
  `downpayment` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_orders`
--

INSERT INTO `user_orders` (`ID`, `order_ID`, `order_status`, `user_id`, `full_name`, `email`, `contact_number`, `address`, `product_id`, `product_price`, `quantity`, `vat`, `total_amount`, `downpayment`, `order_date`) VALUES
(90, 'ORD-EC1DFC', '', 27, 'kaizen', 'kaizenthebeast@gmail.com', '09993302485', 'rawrawrware', 'MPS-67148a96', 155, 1, 31.00, 186.00, 25, '2024-10-25 21:55:41'),
(92, 'ORD-E80ADE', 'Ready', 27, 'kaizen', 'kaizenthebeast@gmail.com', '09993302485', 'rawrawrware', 'MPS-67148a96', 155, 1, 31.00, 186.00, 25, '2024-10-25 22:14:00'),
(93, 'ORD-0B3AAB', 'Ready', 27, 'kaizen', 'kaizenthebeast@gmail.com', '09993302485', 'rawrawrware', 'MPS-67148a96', 155, 2, 31.00, 372.00, 25, '2024-10-25 22:15:55'),
(94, 'ORD-0720E8', 'Ready', 27, 'kaizen', 'kaizenthebeast@gmail.com', '09993302485', 'rawrawrware', 'MPS-67148a96', 155, 2, 31.00, 372.00, 25, '2024-10-25 22:18:40'),
(95, 'ORD-E3A976', 'Ready', 27, 'kaizen', 'kaizenthebeast@gmail.com', '09993302485', 'rawrawrware', 'MPS-67148a96', 155, 2, 31.00, 372.00, 25, '2024-10-25 22:21:51'),
(96, 'ORD-75F0E9', 'Complete', 27, 'kaizen', 'kaizenthebeast@gmail.com', '09993302485', 'rawrawrware', 'MPS-67148a96', 155, 2, 31.00, 372.00, 25, '2024-10-25 22:26:39'),
(97, 'ORD-6F147D', 'Complete', 27, 'kaizen', 'kaizenthebeast@gmail.com', '09993302485', 'rawrawrware', 'MPS-67148a96', 155, 2, 31.00, 372.00, 25, '2024-10-25 22:28:45'),
(98, 'ORD-F3DF42', 'Ready', 27, 'kaizen', 'kaizenthebeast@gmail.com', '09993302485', 'rawrawrware', 'MPS-67148a96', 155, 1, 31.00, 186.00, 25, '2024-10-25 22:33:09'),
(99, 'ORD-F5D9E3', 'Pending', 27, 'kaizen', 'kaizenthebeast@gmail.com', '09993302485', 'rawrawrware', 'MPS-67148a96', 155, 1, 31.00, 186.00, 25, '2024-10-25 23:53:00');

-- --------------------------------------------------------

--
-- Table structure for table `vat_settings`
--

CREATE TABLE `vat_settings` (
  `ID` int(11) NOT NULL,
  `vat_percentage` decimal(5,2) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vat_settings`
--

INSERT INTO `vat_settings` (`ID`, `vat_percentage`, `updated_at`) VALUES
(1, 20.00, '2024-10-19 23:21:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `product_id` (`product_id`);

--
-- Indexes for table `registered_users`
--
ALTER TABLE `registered_users`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_orders`
--
ALTER TABLE `user_orders`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `vat_settings`
--
ALTER TABLE `vat_settings`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `registered_users`
--
ALTER TABLE `registered_users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `user_orders`
--
ALTER TABLE `user_orders`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `vat_settings`
--
ALTER TABLE `vat_settings`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_orders`
--
ALTER TABLE `user_orders`
  ADD CONSTRAINT `user_orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `registered_users` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
