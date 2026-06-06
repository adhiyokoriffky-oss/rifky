-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2026 at 01:31 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_barang`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `kd_kat` varchar(6) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `kd_kat`, `category_name`) VALUES
(4, 'K001', 'Fashion & Aksesoris'),
(5, 'K002', 'Elektronik & Gadget'),
(6, 'K003', 'Kesehatan & Kecantikan'),
(7, 'K004', 'Kebutuhan rumah tangga'),
(8, 'K005', 'Otomotif');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_code` varchar(50) DEFAULT NULL,
  `product_name` varchar(150) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `min_stock` int(11) DEFAULT 5,
  `price` int(11) DEFAULT NULL,
  `gambar` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `product_code`, `product_name`, `stock`, `min_stock`, `price`, `gambar`, `created_at`, `updated_at`) VALUES
(3, 4, 'P001', 'Baju 3 Second', 10, 50, 200000, 'de9a1c012d850672824dfcbead2efa24.jpg', '2026-06-01 04:06:46', NULL),
(4, 4, 'P002', 'Celana SympleCo', 100, 50, 300000, 'c5fc0dc1703fe72ecfdb539cc96f2cc3.jpg', '2026-06-01 04:07:45', NULL),
(5, 4, 'P003', 'Tas Eiger', 20, 50, 450000, '5e290ec6525376b3e517fa42886f34c9.jpg', '2026-06-01 04:09:00', NULL),
(6, 4, 'P004', 'Baju Erigo', 170, 50, 350000, 'f89287ee3c5acdbb89110d5f98740f5f.jpg', '2026-06-01 04:11:17', NULL),
(7, 5, 'P005', 'HP Iphone 17 ProMax', 38, 20, 36000000, '6c33487f01847a7339df40b9154e8ca9.jpg', '2026-06-01 04:18:00', NULL),
(8, 5, 'P006', 'TV SAMSUNG UHD SMART TV 43 INCH', 5, 20, 5199000, '4e0ff17ba73d1eb2d0e9ab3011411ca8.jpg', '2026-06-01 04:21:43', NULL),
(9, 5, 'P007', 'Laptop LENOVO IDEAPAD SLIM 3 14', 30, 5, 7000000, '3b3194c1e1f703a5c1f6f4a0f0bbdb08.jpg', '2026-06-01 04:29:36', NULL),
(10, 5, 'P008', 'PlayStasion 5', 10, 5, 10000000, 'c1b3aa290563529935ad1b7e9221afd0.jpg', '2026-06-01 04:31:40', NULL),
(11, 6, 'P009', 'Serum Wardah Lightening Serum Ampoule', 50, 20, 71500, 'c51a80a2798319af11501b74e2d13ba4.jpg', '2026-06-01 04:35:16', NULL),
(12, 6, 'P010', 'Sunscreen SKINTIFIC 5X Ceramide Serum Sunscreen SPF50', 50, 50, 139000, 'c85035a2cd947958ce778ebabb93532c.jpg', '2026-06-01 04:42:08', NULL),
(13, 6, 'P011', 'Serum Somethinc 5% Niacinamide + Moisture Sabi Beet Serum', 100, 20, 116000, '946e4d8166a4e612cb29576dad05f908.png', '2026-06-01 04:45:29', NULL),
(14, 6, 'P012', 'Cetaphil Gentle Skin Cleanser', 50, 20, 199000, '56f810a66dd1d739b4edec22e520c9b1.png', '2026-06-01 13:08:35', NULL),
(15, 7, 'P013', 'Sapu Ijuk', 100, 50, 30000, '5c912a4f8234643e1ed49ea44c9638d2.png', '2026-06-01 13:10:31', NULL),
(16, 7, 'P014', 'Pel lantai', 20, 50, 35000, '1ecf7544f8485d33681c79406c24ef7b.jpg', '2026-06-01 13:12:07', NULL),
(17, 7, 'P015', 'Kemoceng ', 80, 30, 12000, 'e9411c8225f21625c5df486d4744f20b.jpg', '2026-06-01 13:14:47', NULL),
(18, 7, 'P016', 'Kain lap fiber', 50, 40, 10000, '068640de2d52b49a1fac6539b203dcca.jpg', '2026-06-01 13:16:04', NULL),
(19, 8, 'P017', 'Sepeda motor Honda Beat Matic', 5, 8, 14000000, 'ecb35fcec484615c2f6911a267bfadfe.jpg', '2026-06-01 13:18:47', NULL),
(20, 8, 'P018', 'Ban Michelin Pilot Street', 100, 50, 4300000, 'd004e7a87b6861d613b15f85a6901bab.jpg', '2026-06-02 06:46:21', NULL),
(21, 8, 'P019', 'OLI SHELL HELIX HX5 15W40 1L', 20, 50, 91000, '2b7adb4db17ef5ff8f5353edaefe0ba9.jpg', '2026-06-02 06:48:27', NULL),
(22, 8, 'P020', 'Yamaha FreeGo 125', 20, 5, 23000000, '8227166815c1adabd9e7ea252e71b077.jpg', '2026-06-02 06:50:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock_logs`
--

CREATE TABLE `stock_logs` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `change_type` enum('ADD','EDIT','REDUCE') DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `stock_before` int(11) DEFAULT NULL,
  `stock_after` int(11) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock_logs`
--

INSERT INTO `stock_logs` (`id`, `product_id`, `change_type`, `qty`, `stock_before`, `stock_after`, `note`, `created_at`, `created_by`) VALUES
(2, 3, 'ADD', 10, 50, 60, 'Tambahan ', '2026-06-02 06:57:10', 5),
(3, 7, 'REDUCE', 2, 40, 38, 'Terjual', '2026-06-02 06:57:33', 5),
(4, 6, 'ADD', 50, 120, 170, 'barang masuk', '2026-06-04 00:51:04', 5),
(5, 3, 'REDUCE', 50, 60, 10, '', '2026-06-04 00:56:41', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','staff') DEFAULT 'staff',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `is_active`, `created_at`) VALUES
(5, 'rifky', 'rifky@gmail.com', '$2y$10$.1RKcBLsB93SqSM.6E0YUO/4cxVDhE4OOkaIi0.JbE7MuoRD4gjXm', 'admin', 1, '2026-05-21 03:53:14'),
(6, 'krisna', 'krisna@gmail.com', '$2y$10$rTVH/UpHOkfjODlT96c2mOjEe54Ly/LVw/KQdkd4hhg4ZI8Fi0YD2', 'staff', 0, '2026-06-04 01:15:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kd_kat` (`kd_kat`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_logs`
--
ALTER TABLE `stock_logs`
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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `stock_logs`
--
ALTER TABLE `stock_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
