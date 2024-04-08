-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2024 at 03:07 PM
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
-- Database: `web_adidas_shoes`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(3, 'Dép'),
(1, 'Giày nam'),
(2, 'Giày nữ');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `customer_name` varchar(50) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(320) NOT NULL,
  `city` varchar(50) NOT NULL,
  `district` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_date`, `customer_name`, `phone_number`, `email`, `city`, `district`, `address`, `note`, `status`) VALUES
(1, '2024-04-05 09:31:40', 'Nguyễn Văn A', '0123456789', 'nguyenvana@example.com', 'Hà Nội', 'Ba Đình', 'Số 10, Phố ABC', 'Giao hàng trước 5h chiều', 'Chưa xác nhận'),
(2, '2024-04-05 09:31:40', 'Trần Thị B', '0987654321', 'tranthib@example.com', 'Hồ Chí Minh', 'Quận 1', 'Số 20, Đường XYZ', 'Giao hàng sau 7 ngày', 'Hoàn thành'),
(7, '2024-04-08 03:48:06', 'abc', '1234', 'abc@gmail.com', 'CT', 'Ninh Kiềua', '123', '123', 'Chờ xử lý'),
(8, '2024-04-08 12:58:25', 'fdsa', 'dfsa', '4@gmail.com', '4321', '2341', 'fdsafdsa', '4321', 'Chờ xử lý'),
(9, '2024-04-08 13:05:02', '5423', '5432', '4@gmail.com', 'rewq', 'tre', 'trq', 'rewq', 'Chờ xử lý');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `size_value` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_detail_id`, `order_id`, `product_id`, `size_value`, `quantity`, `unit_price`) VALUES
(1, 1, 1, 40, 2, 3000000),
(2, 1, 3, 40, 1, 300000),
(3, 2, 2, 37, 1, 2900000),
(4, 2, 5, 38, 3, 1100000),
(12, 7, 2, 38, 1, 4900000),
(13, 8, 4, 40, 1, 1800000),
(14, 9, 4, 40, 1, 1800000);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` bigint(20) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `description`, `price`, `image_url`, `category_id`) VALUES
(1, 'Giày thể thao Adidas Ultraboost', 'Giày thể thao Adidas Ultraboost 21 Nam', 5200000, 'uploads/d3aa83d299bc87275476e23b00d98013_Giày thể thao Adidas Ultraboost 21 Nam.jpg', 1),
(2, 'Giày thể thao Adidas Ultraboost', 'Giày chạy nữ cao cấp của Adidas, thiết kế nhẹ nhàng và thoải mái', 4900000, 'uploads/6004d4cc9aae281802fefcaff099479d_Giày thể thao Adidas Ultraboost 21 Nữ.jpg', 2),
(3, 'Dép Adidas Adilette', 'Dép Adidas kiểu dáng đơn giản, phù hợp cho mọi dịp', 590000, 'uploads/2b6d46c52b11dd5c8f6de910cbf217f3_Dép Adidas Adilette.jpg', 3),
(4, 'Giày thể thao Adidas Runfalcon', 'Giày thể thao nam với thiết kế đơn giản và tiện dụng', 1800000, 'uploads/1a1e19a191ffa575ec7a258df832ab49_Giày thể thao Adidas Runfalcon 2.0 Nam.jpg', 1),
(5, 'Giày thể thao Adidas Runfalcon', 'Giày thể thao nữ với thiết kế thoải mái và phong cách', 1100000, 'uploads/50fdf8e34cde005f2f7feba4b9132023_Giày thể thao Adidas Runfalcon 2.0 nữ.jpg', 2),
(13, 'Giày Samba OG', 'Giày Samba OG', 2700000, 'uploads/aafc675c79b92d4c79429e6c06dc6b79.jpg', 1),
(14, 'Giày SupersStar', 'Giày SupersStar', 2700000, 'uploads/4c7e51f6a7f9810e4f28c976b49f5c1e.jpg', 1),
(15, 'Dép Adilette Shower', 'Dép Adilette Shower', 680000, 'uploads/882e88744a5033bfb3270ff6aed1b7d6.webp', 3),
(16, 'Dép Adidas Adilette Ayoon Sides', 'Dép Adidas Adilette Ayoon Sides', 680000, 'uploads/cabab8416a71f4cd2b09f5ec51e1120f.webp', 3),
(17, 'Giày Adidas Nữ V46', 'Giày Adidas Nữ V46', 3100000, 'uploads/3ef8019ae50641f985373e481d2d9131.jpg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `product_size`
--

CREATE TABLE `product_size` (
  `product_size_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `size_value` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_size`
--

INSERT INTO `product_size` (`product_size_id`, `product_id`, `size_value`) VALUES
(1, 1, 39),
(2, 1, 40),
(3, 1, 41),
(4, 2, 36),
(5, 2, 37),
(6, 2, 38),
(7, 3, 38),
(8, 3, 39),
(9, 3, 40),
(10, 4, 40),
(11, 4, 41),
(12, 4, 42),
(13, 5, 36),
(14, 5, 37),
(15, 5, 38),
(16, 4, 42),
(17, 13, 42),
(18, 14, 42),
(19, 5, 42),
(21, 3, 42),
(22, 15, 42),
(23, 16, 42),
(24, 1, 42),
(25, 2, 42),
(31, 17, 32),
(36, 17, 40);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_size`
--
ALTER TABLE `product_size`
  ADD PRIMARY KEY (`product_size_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `product_size`
--
ALTER TABLE `product_size`
  MODIFY `product_size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE;

--
-- Constraints for table `product_size`
--
ALTER TABLE `product_size`
  ADD CONSTRAINT `product_size_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
