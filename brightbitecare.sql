-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2025 at 05:38 PM
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
-- Database: `brightbitecare`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `status` enum('pending','confirmed','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `user_id`, `service_id`, `appointment_date`, `appointment_time`, `status`, `created_at`) VALUES
(1, 3, 2, '2025-05-19', '00:00:00', 'pending', '2025-05-19 16:01:46'),
(2, 3, 4, '2025-05-20', '00:00:00', 'pending', '2025-05-20 15:20:53');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(1, 3, 4, 'nice', '2025-05-19 16:10:38'),
(2, 3, 4, 'DASDSAD', '2025-05-19 16:13:47'),
(3, 3, 2, 'galing!', '2025-05-20 15:21:21');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('unread','read') DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `subject`, `message`, `status`, `created_at`) VALUES
(1, 'test_data', 'jessicacute@gmail.com', 'Message from: 3234234', 'ampogi mo po kuya je', 'unread', '2025-05-19 15:09:52'),
(2, 'test', 'test@gmail.com', 'Message from: 334', 'dasd', 'unread', '2025-05-19 16:08:10'),
(3, 'jessica love sir jeff', 'jessica@gmail.com', 'Message from: 2323223', 'i love sir andro my baby', 'unread', '2025-05-20 15:16:20');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `status`, `created_at`) VALUES
(1, 3, 100.00, 'pending', '2025-05-19 15:53:11'),
(2, 3, 150.00, 'pending', '2025-05-19 15:53:21'),
(3, 3, 400.00, 'pending', '2025-05-19 15:53:23'),
(4, 3, 250.00, 'pending', '2025-05-19 15:57:22'),
(5, 1, 250.00, 'pending', '2025-05-19 16:26:35'),
(6, 3, 800.00, 'pending', '2025-05-20 15:20:43');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 1, 100.00),
(2, 2, 2, 1, 150.00),
(3, 3, 6, 1, 400.00),
(4, 4, 3, 1, 250.00),
(5, 5, 3, 1, 250.00),
(6, 6, 9, 1, 800.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(2083) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image_url`, `description`) VALUES
(1, 'Toothbrushes', 100.00, 'https://shop.colgate.com/_ipx/f_webp&s_1800x1800/cms/7db2e55c-971b-4c11-bc34-661be64dce47', 'Multi-level bristles for a thorough clean, gentle on gums. Recommended for daily use.'),
(2, 'Toothpaste', 150.00, 'https://shopmetro.ph/lapulapu-supermarket/wp-content/uploads/2023/04/SM9034647_2-14.jpg', 'High-frequency vibrations for superior plaque removal. Multiple cleaning modes and timer.'),
(3, 'Mouthwash', 250.00, 'https://images.ctfassets.net/ikipq83d3rdu/1au59VFJ4hsD4wbn3DY9nw/05d3ea14cf8fc60d219f33cc3a2624f0/Cool_Mint_-_1.5L.webp', 'All-in-one protection against cavities, gingivitis, plaque, and tartar. Fresh mint flavor.'),
(4, 'Floss and Interdental Cleaners', 250.00, 'https://www.colgateprofessional.com.au/content/dam/cp-sites/oral-care/professional2020/en_au/products/interdental/colgate-interdental-brush-and-pick.jpg', 'Clinically proven relief and daily protection for sensitive teeth. Gentle formula.'),
(5, 'Whitening Products', 1200.00, 'https://m.media-amazon.com/images/I/518d0Bhn4aL._SR290,290_.jpg', 'Removes surface stains and whitens teeth in just one week. Enamel-safe.'),
(6, 'Oral Rinses', 400.00, 'https://rustans-thebeautysource.com/en/wp-content/uploads/2017/09/Dentiste-Oral-Rinse.jpg', 'Kills 99.9% of germs that cause bad breath, plaque, and gingivitis. Cool mint.'),
(7, 'Mouthguards', 1500.00, 'https://m.media-amazon.com/images/I/712DoJUuEoL._AC_SL1500_.jpg', 'Strengthens enamel and helps prevent cavities. Alcohol-free formula.'),
(8, 'Denture Products', 500.00, 'https://i-cf65.ch-static.com/content/dam/cf-consumer-healthcare/denture-appliance-care/en_US/losalisation/product-images/super-green-poligrip.jpg?auto=format', 'Strong, shred-resistant floss that glides easily between teeth. Refreshing mint.'),
(9, 'Orthodontic Supplies', 800.00, 'https://www.skydentalsupply.com/picts/blog/tn1200x1200-best-orthodontics-supplies.webp', 'Convenient floss picks for on-the-go cleaning. Angled design for hard-to-reach areas.'),
(10, 'Whitening Products Advanced', 1200.00, 'https://m.media-amazon.com/images/I/71ZrnBtzRgL._AC_UF1000,1000_QL80_.jpg', 'Comprehensive care kit for sensitive teeth. Contains special whitening gel.');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `price`) VALUES
(1, 'Dental Checkups & Exams', 1000.00),
(2, 'Teeth Cleaning (Prophylaxis)', 1000.00),
(3, 'Fillings', 500.00),
(4, 'Tooth Extractions', 2000.00),
(5, 'Root Canal Therapy', 3000.00),
(6, 'Crowns and Bridges', 1500.00),
(7, 'Dentures', 20000.00),
(8, 'Teeth Whitening', 1500.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `full_name`, `phone`, `address`, `is_admin`, `created_at`) VALUES
(1, 'admin', 'admin123', 'admin@brightbitecare.com', 'Admin User', NULL, NULL, 1, '2025-05-19 15:05:17'),
(2, 'jessica', 'jessica', 'jessica@gmail.com', 'Jessica Argame', '455445', NULL, 0, '2025-05-19 15:18:47'),
(3, 'test1', 'test1', 'test1@gmail.com', 'test1', '34343', 'oputatan', 0, '2025-05-19 15:33:56'),
(4, 'denis', 'denis', 'denis@gmail.com', 'denis', '2323', 'fsdfsdf', 0, '2025-05-20 15:35:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
