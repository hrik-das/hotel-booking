-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2025 at 08:07 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel-booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_cred`
--

CREATE TABLE `admin_cred` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_cred`
--

INSERT INTO `admin_cred` (`id`, `username`, `password`) VALUES
(1, 'godlike', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--

CREATE TABLE `booking_details` (
  `sr_no` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `room_name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `total_payment` int(11) NOT NULL,
  `room_no` varchar(100) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_details`
--

INSERT INTO `booking_details` (`sr_no`, `booking_id`, `room_name`, `price`, `total_payment`, `room_no`, `username`, `phone`, `email`, `address`) VALUES
(1, 1, 'Luxury Room', 1299, 1299, NULL, 'Nanda Gopal Das', '1234567890', 'emptynull01@gmail.com', 'India'),
(2, 2, 'Deluxe Room', 899, 17081, 'A2', 'Nanda Gopal Das', '1234567890', 'emptynull01@gmail.com', 'India'),
(3, 3, 'Simple Room', 499, 3992, NULL, 'Nanda Gopal Das', '1234567890', 'emptynull01@gmail.com', 'India'),
(4, 4, 'Simple Room', 499, 8982, NULL, 'Nanda Gopal Das', '1234567890', 'emptynull01@gmail.com', 'India'),
(5, 5, 'Luxury Room', 1299, 23382, 'A9', 'Nanda Gopal Das', '1234567890', 'emptynull01@gmail.com', 'India'),
(6, 6, 'Simple Room', 499, 499, NULL, 'Nanda Gopal Das', '1234567890', 'emptynull01@gmail.com', 'India'),
(7, 7, 'Super Deluxe Room', 1899, 32283, 'N70', 'Nanda Gopal Das', '1234567890', 'emptynull01@gmail.com', 'India'),
(8, 8, 'Simple Room', 499, 8483, 'A1', 'Nanda Gopal Das', '1234567890', 'emptynull01@gmail.com', 'India'),
(9, 9, 'Deluxe Room', 899, 15283, NULL, 'Nanda Gopal Das', '1234567890', 'emptynull01@gmail.com', 'India'),
(10, 10, 'Super Luxury Room', 2599, 44183, 'D30', 'Nanda Gopal Das', '1234567890', 'emptynull01@gmail.com', 'India');

-- --------------------------------------------------------

--
-- Table structure for table `booking_order`
--

CREATE TABLE `booking_order` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `arrival` tinyint(4) NOT NULL DEFAULT 0,
  `refund` tinyint(4) DEFAULT NULL,
  `booking_status` varchar(255) NOT NULL DEFAULT 'pending',
  `order_id` varchar(255) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `transaction_amount` int(11) NOT NULL,
  `transaction_status` varchar(255) NOT NULL DEFAULT 'pending',
  `transaction_response` varchar(255) DEFAULT NULL,
  `rate_review` tinyint(4) DEFAULT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_order`
--

INSERT INTO `booking_order` (`booking_id`, `user_id`, `room_id`, `check_in`, `check_out`, `arrival`, `refund`, `booking_status`, `order_id`, `transaction_id`, `transaction_amount`, `transaction_status`, `transaction_response`, `rate_review`, `date_time`) VALUES
(1, 17, 3, '2025-05-12', '2025-05-13', 0, NULL, 'pending', 'ORD_1764842315', NULL, 0, 'pending', NULL, NULL, '2025-05-12 00:00:00'),
(2, 17, 2, '2025-05-12', '2025-05-31', 1, NULL, 'booked', 'ORD_1726314047', '20220720111212800110168128204225279', 17081, 'TXN_SUCCESS', 'Txn Success', 1, '2025-05-12 00:00:00'),
(3, 17, 1, '2025-05-12', '2025-05-20', 0, NULL, 'failed', 'ORD_1732123862', '20220720111212800110168372503893816', 3992, 'TXN_FAILURE', 'Your payment has been declined by your bank. Please try again later', NULL, '2025-05-12 00:00:00'),
(4, 17, 1, '2025-05-13', '2025-05-31', 0, 0, 'cancelled', 'ORD_1723143220', '20220720111212800110168147852369014', 8982, 'TXN_SUCCESS', 'Txn Success', NULL, '2025-05-13 00:00:00'),
(5, 17, 3, '2025-05-13', '2025-05-31', 1, NULL, 'booked', 'ORD_1764352504', '20220720111212800110168852147963025', 23382, 'TXN_SUCCESS', 'Txn Success', 1, '2025-05-13 00:00:00'),
(6, 17, 1, '2025-05-13', '2025-05-14', 0, 1, 'cancelled', 'ORD_1719641472', '20220720111212800110168456789123028', 499, 'TXN_SUCCESS', 'Txn Success', NULL, '2025-05-13 00:00:00'),
(7, 17, 4, '2025-05-14', '2025-05-31', 1, NULL, 'booked', 'ORD_1780474472', '20220720111212800110168789582635412', 32283, 'TXN_SUCCESS', 'Txn Success', 0, '2025-05-14 16:52:06'),
(8, 17, 1, '2025-05-14', '2025-05-31', 1, NULL, 'booked', 'ORD_1738321088', '20220720111212800110168852365574120', 8483, 'TXN_SUCCESS', 'Txn Success', 1, '2025-05-14 16:55:08'),
(9, 17, 2, '2025-05-14', '2025-05-31', 0, NULL, 'booked', 'ORD_1745574271', '20220720111212800110168774125896355', 15283, 'TXN_SUCCESS', 'Txn Success', NULL, '2025-05-14 16:56:57'),
(10, 17, 5, '2025-05-14', '2025-05-31', 1, NULL, 'booked', 'ORD_1765061276', '20220720111212800110168790805077441', 44183, 'TXN_SUCCESS', 'Txn Success', 1, '2025-05-14 16:59:15');

-- --------------------------------------------------------

--
-- Table structure for table `carousel`
--

CREATE TABLE `carousel` (
  `sr_no` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carousel`
--

INSERT INTO `carousel` (`sr_no`, `image`) VALUES
(1, 'IMAGE_799785.png'),
(2, 'IMAGE_372156.png'),
(3, 'IMAGE_486204.png'),
(4, 'IMAGE_996037.png'),
(5, 'IMAGE_934408.png'),
(6, 'IMAGE_923504.png'),
(7, 'IMAGE_344871.jpg'),
(8, 'IMAGE_535638.jpg'),
(9, 'IMAGE_301739.jpg'),
(10, 'IMAGE_349445.jpg'),
(11, 'IMAGE_394713.jpg'),
(12, 'IMAGE_760218.jpg'),
(13, 'IMAGE_313272.jpg'),
(14, 'IMAGE_712038.jpg'),
(15, 'IMAGE_510270.jpg'),
(16, 'IMAGE_978240.jpg'),
(17, 'IMAGE_482768.jpg'),
(18, 'IMAGE_408046.jpg'),
(19, 'IMAGE_428580.jpg'),
(20, 'IMAGE_485996.jpg'),
(21, 'IMAGE_335887.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `contact_details`
--

CREATE TABLE `contact_details` (
  `sr_no` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `gmap` varchar(255) NOT NULL,
  `phone_one` bigint(20) NOT NULL,
  `phone_two` bigint(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `instagram` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `iframe` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_details`
--

INSERT INTO `contact_details` (`sr_no`, `address`, `gmap`, `phone_one`, `phone_two`, `email`, `facebook`, `instagram`, `twitter`, `iframe`) VALUES
(1, 'XYZ, Assam, India', 'https://maps.app.goo.gl/C291p9opm3xkUpBC7', 911234567890, 911234567890, 'support.restaurantgodlike@gmail.com', 'https://www.facebook.com', 'https://www.instagram.com', 'https://www.x.com', 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d30499770.719593283!2d82.752529!3d21.068007!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30635ff06b92b791:0xd78c4fa1854213a6!2sIndia!5e0!3m2!1sen!2sin!4v1746110115788!5m2!1sen!2sin');

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` int(11) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `icon`, `name`, `description`) VALUES
(5, 'SVG_217031.svg', 'Air Conditioner', 'lorem ipsum dolor sit amet'),
(6, 'SVG_438951.svg', 'Gyser', 'lorem ipsum dolor sit amet'),
(8, 'SVG_824266.svg', 'Unlimited Wifi', 'lorem ipsum dolor sit amet'),
(9, 'SVG_620390.svg', 'Massage Parlour', 'lorem ipsum dolor sit amet'),
(10, 'SVG_833947.svg', 'Smart Television', 'lorem ipsum dolor sit amet'),
(11, 'SVG_652768.svg', 'Room Heater', 'lorem ipsum dolor sit amet');

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`id`, `name`) VALUES
(1, 'Balcony'),
(3, 'Kitchen'),
(5, 'Sofa and Cusions'),
(6, 'Bathroom'),
(7, 'Bedroom'),
(9, 'Living Room');

-- --------------------------------------------------------

--
-- Table structure for table `rating_review`
--

CREATE TABLE `rating_review` (
  `sr_no` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` varchar(255) NOT NULL,
  `seen` tinyint(4) NOT NULL DEFAULT 0,
  `date_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating_review`
--

INSERT INTO `rating_review` (`sr_no`, `booking_id`, `room_id`, `user_id`, `rating`, `review`, `seen`, `date_time`) VALUES
(3, 10, 5, 17, 5, 'lorem ipsum dolor sit amet', 1, '2025-05-14 17:09:55'),
(4, 8, 1, 17, 3, 'lorem ipsum dolor sit amet', 0, '2025-05-14 17:10:03'),
(5, 5, 3, 17, 1, 'lorem ipsum dolor sit amet', 1, '2025-05-14 17:10:10'),
(6, 2, 2, 17, 4, 'lorem ipsum dolor sit amet', 0, '2025-05-14 17:10:18');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `area` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `adult` int(11) NOT NULL,
  `children` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `removed` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `area`, `price`, `quantity`, `adult`, `children`, `description`, `status`, `removed`) VALUES
(1, 'Simple Room', 48, 499, 30, 3, 2, 'It is a simple room with decent features and facilities to make our customers comfortable.', 1, 0),
(2, 'Deluxe Room', 59, 899, 20, 2, 1, 'It is a deluxe room for the customers who love to spend their time in work with the deluxe comfortness.', 1, 0),
(3, 'Luxury Room', 68, 1299, 10, 2, 1, 'This is our top-most luxury room in our hotel for the VIP customers and it comes with all the luxury features and facilities to make them joy in our luxury comfortness.', 1, 0),
(4, 'Super Deluxe Room', 88, 1899, 5, 1, 1, 'It is a super deluxe room for the customers who love to spend their time in work with the deluxe comfortness.', 1, 0),
(5, 'Super Luxury Room', 95, 2599, 3, 1, 1, 'It is a super luxury room for the customers who love to spend their time in work with the deluxe comfortness.', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `room_facilities`
--

CREATE TABLE `room_facilities` (
  `sr_no` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `facilities_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_facilities`
--

INSERT INTO `room_facilities` (`sr_no`, `room_id`, `facilities_id`) VALUES
(23, 3, 5),
(24, 3, 6),
(25, 3, 8),
(26, 3, 9),
(27, 3, 10),
(28, 3, 11),
(33, 1, 5),
(34, 1, 6),
(35, 1, 8),
(40, 2, 5),
(41, 2, 6),
(42, 2, 8),
(43, 2, 10),
(44, 4, 5),
(45, 4, 6),
(46, 4, 8),
(47, 4, 9),
(48, 4, 10),
(49, 4, 11),
(50, 5, 5),
(51, 5, 6),
(52, 5, 8),
(53, 5, 9),
(54, 5, 10),
(55, 5, 11);

-- --------------------------------------------------------

--
-- Table structure for table `room_features`
--

CREATE TABLE `room_features` (
  `sr_no` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `features_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_features`
--

INSERT INTO `room_features` (`sr_no`, `room_id`, `features_id`) VALUES
(23, 3, 1),
(24, 3, 3),
(25, 3, 5),
(26, 3, 6),
(27, 3, 7),
(28, 3, 9),
(33, 1, 3),
(34, 1, 6),
(35, 1, 7),
(40, 2, 1),
(41, 2, 3),
(42, 2, 6),
(43, 2, 7),
(44, 4, 1),
(45, 4, 3),
(46, 4, 5),
(47, 4, 6),
(48, 4, 7),
(49, 4, 9),
(50, 5, 1),
(51, 5, 3),
(52, 5, 5),
(53, 5, 6),
(54, 5, 7),
(55, 5, 9);

-- --------------------------------------------------------

--
-- Table structure for table `room_image`
--

CREATE TABLE `room_image` (
  `sr_no` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `thumbnail` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_image`
--

INSERT INTO `room_image` (`sr_no`, `room_id`, `image`, `thumbnail`) VALUES
(7, 1, 'IMAGE_531685.png', 1),
(8, 1, 'IMAGE_118961.jpg', 0),
(9, 1, 'IMAGE_957535.jpg', 0),
(10, 2, 'IMAGE_442029.png', 0),
(11, 2, 'IMAGE_799421.jpg', 0),
(12, 2, 'IMAGE_435835.jpg', 0),
(13, 2, 'IMAGE_545274.jpg', 1),
(14, 3, 'IMAGE_455982.png', 0),
(15, 3, 'IMAGE_675388.png', 0),
(16, 3, 'IMAGE_324482.jpg', 0),
(17, 3, 'IMAGE_306482.jpg', 0),
(18, 3, 'IMAGE_764617.jpg', 1),
(19, 4, 'IMAGE_525738.png', 1),
(20, 4, 'IMAGE_523315.jpg', 0),
(21, 4, 'IMAGE_484364.jpg', 0),
(22, 4, 'IMAGE_509066.jpg', 0),
(23, 5, 'IMAGE_285201.jpg', 1),
(24, 5, 'IMAGE_647938.jpg', 0),
(25, 5, 'IMAGE_663609.jpg', 0),
(26, 5, 'IMAGE_999898.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `sr_no` int(11) NOT NULL,
  `site_title` varchar(255) NOT NULL,
  `site_about` varchar(255) NOT NULL,
  `shutdown` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`sr_no`, `site_title`, `site_about`, `shutdown`) VALUES
(1, 'Godlike Restaurant', 'Welcome to Godlike Restaurant, where delicious flavors and warm hospitality come together to create an unforgettable dining experience. Our menu features a variety of freshly prepared dishes made with high-quality ingredients, perfect for any occasion.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `team_details`
--

CREATE TABLE `team_details` (
  `sr_no` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_details`
--

INSERT INTO `team_details` (`sr_no`, `name`, `image`) VALUES
(1, 'Debbie Carter', 'IMAGE_427143.jpg'),
(2, 'Alex Jones', 'IMAGE_589759.jpg'),
(3, 'Henry Hargrove', 'IMAGE_806286.jpg'),
(5, 'Giya McKinnor', 'IMAGE_122719.jpg'),
(6, 'Steve Benson', 'IMAGE_128796.jpg'),
(7, 'Nancy Wheeler', 'IMAGE_358758.jpg'),
(8, 'Mariam Jessie', 'IMAGE_130506.jpg'),
(9, 'Benjamin Mateo', 'IMAGE_303952.jpg'),
(10, 'Isabelle Harper', 'IMAGE_455302.jpg'),
(11, 'Mary Jane', 'IMAGE_590689.jpg'),
(12, 'Amelia Gracey', 'IMAGE_391335.jpg'),
(13, 'Natalia Eve', 'IMAGE_829248.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user_cred`
--

CREATE TABLE `user_cred` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `profile` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `pincode` int(11) NOT NULL,
  `dob` date NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_verified` tinyint(4) NOT NULL DEFAULT 0,
  `token` varchar(255) DEFAULT NULL,
  `token_expire` date DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `date_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_cred`
--

INSERT INTO `user_cred` (`id`, `username`, `email`, `phone`, `profile`, `address`, `pincode`, `dob`, `password`, `is_verified`, `token`, `token_expire`, `status`, `date_time`) VALUES
(17, 'Nanda Gopal Das', 'emptynull01@gmail.com', '1234567890', 'IMAGE_613266.jpeg', 'India', 788710, '2003-10-11', '$2y$10$WIHZGbgbk4Bp7JpF/fIVkODTtZi.5CLOYiZzJQBZJX0zrqpDRfGCi', 1, NULL, NULL, 1, '2025-05-10 22:54:20');

-- --------------------------------------------------------

--
-- Table structure for table `user_queries`
--

CREATE TABLE `user_queries` (
  `sr_no` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp(),
  `seen` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_queries`
--

INSERT INTO `user_queries` (`sr_no`, `name`, `email`, `subject`, `message`, `date_time`, `seen`) VALUES
(7, 'Nanda Gopal Das', 'emptynull01@gmail.com', 'I&#039;m testing this website functionality', 'I&#039;m just testing if this functionality is working correctly or not.', '2025-05-13 00:00:00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_cred`
--
ALTER TABLE `admin_cred`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `booking_order`
--
ALTER TABLE `booking_order`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `contact_details`
--
ALTER TABLE `contact_details`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating_review`
--
ALTER TABLE `rating_review`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_facilities`
--
ALTER TABLE `room_facilities`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `facilities_id` (`facilities_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `room_features`
--
ALTER TABLE `room_features`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `features_id` (`features_id`),
  ADD KEY `room id` (`room_id`);

--
-- Indexes for table `room_image`
--
ALTER TABLE `room_image`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `team_details`
--
ALTER TABLE `team_details`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `user_cred`
--
ALTER TABLE `user_cred`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_queries`
--
ALTER TABLE `user_queries`
  ADD PRIMARY KEY (`sr_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_cred`
--
ALTER TABLE `admin_cred`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `booking_order`
--
ALTER TABLE `booking_order`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `carousel`
--
ALTER TABLE `carousel`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `contact_details`
--
ALTER TABLE `contact_details`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `rating_review`
--
ALTER TABLE `rating_review`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `room_facilities`
--
ALTER TABLE `room_facilities`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `room_features`
--
ALTER TABLE `room_features`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `room_image`
--
ALTER TABLE `room_image`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `team_details`
--
ALTER TABLE `team_details`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_cred`
--
ALTER TABLE `user_cred`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user_queries`
--
ALTER TABLE `user_queries`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD CONSTRAINT `booking_details_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking_order` (`booking_id`);

--
-- Constraints for table `booking_order`
--
ALTER TABLE `booking_order`
  ADD CONSTRAINT `booking_order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_cred` (`id`),
  ADD CONSTRAINT `booking_order_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Constraints for table `rating_review`
--
ALTER TABLE `rating_review`
  ADD CONSTRAINT `rating_review_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking_order` (`booking_id`),
  ADD CONSTRAINT `rating_review_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `rating_review_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user_cred` (`id`);

--
-- Constraints for table `room_facilities`
--
ALTER TABLE `room_facilities`
  ADD CONSTRAINT `facilities_id` FOREIGN KEY (`facilities_id`) REFERENCES `facilities` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `room_id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `room_features`
--
ALTER TABLE `room_features`
  ADD CONSTRAINT `features_id` FOREIGN KEY (`features_id`) REFERENCES `features` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `room id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `room_image`
--
ALTER TABLE `room_image`
  ADD CONSTRAINT `room_image_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
