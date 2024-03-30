-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2024 at 11:07 AM
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
-- Database: `hotel-booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_cred`
--

CREATE TABLE `admin_cred` (
  `sr_no` int(11) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `admin_pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_cred`
--

INSERT INTO `admin_cred` (`sr_no`, `admin_name`, `admin_pass`) VALUES
(1, 'godlike', '12345');

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
(7, 'IMG_35073.png'),
(8, 'IMG_52964.png'),
(9, 'IMG_64144.png'),
(10, 'IMG_39549.png'),
(11, 'IMG_99023.png'),
(12, 'IMG_49943.png'),
(13, 'IMG_24688.jpg'),
(16, 'IMG_51665.jpg'),
(18, 'IMG_39957.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `contact_details`
--

CREATE TABLE `contact_details` (
  `sr_no` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `gmap` varchar(255) NOT NULL,
  `phone1` varchar(255) NOT NULL,
  `phone2` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fb` varchar(255) NOT NULL,
  `insta` varchar(255) NOT NULL,
  `tw` varchar(255) NOT NULL,
  `iframe` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_details`
--

INSERT INTO `contact_details` (`sr_no`, `address`, `gmap`, `phone1`, `phone2`, `email`, `fb`, `insta`, `tw`, `iframe`) VALUES
(1, 'XYZ, Hawrah, Kolkata', 'https://maps.app.goo.gl/o3wkTANpFaJsVdFJ9', '919988776655', '911122334455', 'hrikdas012@gmail.com', 'https://www.facebook.com', 'https://www.instagram.com', 'https://www.twitter.com', 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d30499770.719593283!2d82.752529!3d21.068007!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30635ff06b92b791:0xd78c4fa1854213a6!2sIndia!5e0!3m2!1sen!2sin!4v1711310426669!5m2!1sen!2sin');

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` int(11) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `icon`, `name`, `description`) VALUES
(13, 'IMG_37211.svg', 'Air Conditioner', 'Air Conditioner is available for our Customers in our Restaurant Rooms.'),
(14, 'IMG_75029.svg', 'Geyser', 'Geyser is available for our Customer Relaxation in our Restaurant.'),
(15, 'IMG_80488.svg', 'Room Heater', 'Room Heater is available for our Customers in our Restaurant.'),
(16, 'IMG_21993.svg', 'Unlimited Wifi', 'Unlimited Internet Connectivity available for our Customers in our Restaurant.'),
(17, 'IMG_83401.svg', 'Massage Parlour', 'Massage Parlor is available for our Customers Relaxation in our Restaurant.'),
(18, 'IMG_32503.svg', 'Smart Television', 'Smart Television is available for our Customers Entertainment in our Restaurant.');

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`id`, `name`) VALUES
(23, 'Bedroom'),
(24, 'Bathroom'),
(25, 'Balcony'),
(26, 'Kitchen'),
(27, 'Sofa'),
(28, 'Living Room');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `area` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `adult` int(11) NOT NULL,
  `children` int(11) NOT NULL,
  `description` varchar(500) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `removed` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `area`, `price`, `quantity`, `adult`, `children`, `description`, `status`, `removed`) VALUES
(6, 'Simple Room', 149, 399, 50, 3, 3, 'This is a Simple Room for Night Stays specially for Tourist. Very Comfortable Room with Single Bedroom and a Single Bathroom and a Kitchen. Geyser for and Room Heater is also Available for our Customers facilities.', 1, 0),
(7, 'Deluxe Room', 240, 899, 20, 2, 1, 'This is a Deluxe Room with Super Features and Facilities added for Customers Relaxation with a Double Bedroom and Single Bathroom and a Kitchen with 2 Sofas and a Living Room for Enjoy.', 1, 0),
(8, 'Super Deluxe Room', 500, 2499, 10, 1, 1, 'A Super Deluxe Room for our Extremely Deluxe Customers with 2 Double Bedrooms and 2 Bathrooms and 2 Kitchen for Comfort and a Living Room for Relaxation with Room Heater and Unlimited Internet Connectivity to Enjoy the Fullest.', 1, 0),
(9, 'Luxury Room', 587, 2899, 10, 1, 1, 'A Luxury Room for our VIP Customers and Celebrities for Night Stays and Enjoy with Internet Connectivity and Room Heater Bathroom Geyser and Living Room and Massage Parlour for Relaxation and 24x7 Room Service Available.', 1, 0);

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
(49, 6, 14),
(50, 6, 15),
(51, 7, 13),
(52, 7, 14),
(53, 7, 15),
(54, 7, 16),
(55, 7, 18),
(62, 9, 13),
(63, 9, 14),
(64, 9, 15),
(65, 9, 16),
(66, 9, 17),
(67, 9, 18),
(68, 8, 13),
(69, 8, 14),
(70, 8, 15),
(71, 8, 16),
(72, 8, 18);

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
(54, 6, 23),
(55, 6, 24),
(56, 6, 26),
(57, 7, 23),
(58, 7, 24),
(59, 7, 26),
(60, 7, 27),
(61, 7, 28),
(68, 9, 23),
(69, 9, 24),
(70, 9, 25),
(71, 9, 26),
(72, 9, 27),
(73, 9, 28),
(74, 8, 23),
(75, 8, 24),
(76, 8, 26),
(77, 8, 27),
(78, 8, 28);

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
(8, 6, 'IMG_70582.png', 1),
(9, 6, 'IMG_91207.png', 0),
(10, 6, 'IMG_14956.png', 0),
(11, 7, 'IMG_39621.png', 1),
(12, 7, 'IMG_64129.png', 0),
(13, 7, 'IMG_15589.png', 0),
(14, 7, 'IMG_39688.png', 0),
(15, 7, 'IMG_75459.png', 0),
(16, 6, 'IMG_38085.png', 0),
(17, 6, 'IMG_29293.png', 0),
(18, 8, 'IMG_43250.png', 1),
(20, 8, 'IMG_25996.png', 0),
(21, 8, 'IMG_73354.jpg', 0),
(22, 8, 'IMG_76899.jpg', 0),
(25, 8, 'IMG_88544.jpg', 0),
(26, 8, 'IMG_75569.png', 0),
(27, 8, 'IMG_48574.png', 0),
(28, 9, 'IMG_60917.png', 1),
(29, 9, 'IMG_55270.png', 0),
(30, 9, 'IMG_24524.png', 0),
(31, 9, 'IMG_39950.png', 0),
(32, 9, 'IMG_30247.jpg', 0),
(33, 9, 'IMG_53880.jpg', 0);

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
(1, 'Godlike Restaurant', 'The Hotel Admin Panel is a web-based management system designed to streamline hotel operations and enhance guest experiences. It offers a range of features, including room management, reservation tracking, guest check-in/check-out, billing and invoicing.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `team_details`
--

CREATE TABLE `team_details` (
  `sr_no` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_details`
--

INSERT INTO `team_details` (`sr_no`, `name`, `picture`) VALUES
(17, 'Jacob', 'IMG_71797.png'),
(19, 'Georgia', 'IMG_42747.jpg'),
(20, 'Jake', 'IMG_92850.jpg'),
(22, 'Miya', 'IMG_47109.jpg'),
(23, 'Mark', 'IMG_18423.png'),
(24, 'Jenelia', 'IMG_47641.jpg'),
(25, 'Edward', 'IMG_17171.jpg'),
(28, 'Lily', 'IMG_78984.jpg'),
(30, 'Amelia', 'IMG_56813.jpg'),
(33, 'Lucas', 'IMG_69903.jpg'),
(36, 'Charlie', 'IMG_28257.jpg'),
(45, 'Melissa', 'IMG_25634.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user_cred`
--

CREATE TABLE `user_cred` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `pincode` int(11) NOT NULL,
  `dob` date NOT NULL,
  `profile` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `isVerified` tinyint(4) NOT NULL DEFAULT 0,
  `token` varchar(255) DEFAULT NULL,
  `tokenExpire` date DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `dateTime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_cred`
--

INSERT INTO `user_cred` (`id`, `name`, `email`, `address`, `phone`, `pincode`, `dob`, `profile`, `pass`, `isVerified`, `token`, `tokenExpire`, `status`, `dateTime`) VALUES
(8, 'Hrik Das', 'emptynull01@gmail.com', 'India', '9387500659', 788710, '2003-11-10', 'IMG_88971.jpeg', '$2y$10$ciOmP/70q2GgrOu49N2oo.8E1dS6nAYxghBea7Mzg2ZC8sxV3WLIu', 1, '5006bb1d2bd0f2f8828c4eb1ec3b19a3', NULL, 1, '2024-03-30 16:06:19');

-- --------------------------------------------------------

--
-- Table structure for table `user_queries`
--

CREATE TABLE `user_queries` (
  `sr_no` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` tinyint(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` varchar(500) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `seen` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_queries`
--

INSERT INTO `user_queries` (`sr_no`, `name`, `email`, `subject`, `message`, `date`, `seen`) VALUES
(6, 'Melissa Humerra', 0, 'Complaint', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere voluptate, saepe quas sapiente fugiat ipsum totam! Voluptatem a hic quod.', '2024-03-27', 0),
(7, 'Jacob Dalni', 0, 'Complaint', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere voluptate, saepe quas sapiente fugiat ipsum totam! Voluptatem a hic quod.', '2024-03-27', 0),
(8, 'Erika Damini', 0, 'Complaint', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere voluptate, saepe quas sapiente fugiat ipsum totam! Voluptatem a hic quod.', '2024-03-27', 0),
(9, 'Jane Doe', 0, 'Complaint', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere voluptate, saepe quas sapiente fugiat ipsum totam! Voluptatem a hic quod.', '2024-03-27', 0),
(10, 'Jhon Doe', 0, 'Complaint', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere voluptate, saepe quas sapiente fugiat ipsum totam! Voluptatem a hic quod.', '2024-03-27', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_cred`
--
ALTER TABLE `admin_cred`
  ADD PRIMARY KEY (`sr_no`);

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
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_facilities`
--
ALTER TABLE `room_facilities`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `facilities id` (`facilities_id`),
  ADD KEY `room id` (`room_id`);

--
-- Indexes for table `room_features`
--
ALTER TABLE `room_features`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `features id` (`features_id`),
  ADD KEY `room_id` (`room_id`);

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
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `carousel`
--
ALTER TABLE `carousel`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `contact_details`
--
ALTER TABLE `contact_details`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `room_facilities`
--
ALTER TABLE `room_facilities`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `room_features`
--
ALTER TABLE `room_features`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `room_image`
--
ALTER TABLE `room_image`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `team_details`
--
ALTER TABLE `team_details`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `user_cred`
--
ALTER TABLE `user_cred`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_queries`
--
ALTER TABLE `user_queries`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `room_facilities`
--
ALTER TABLE `room_facilities`
  ADD CONSTRAINT `facilities id` FOREIGN KEY (`facilities_id`) REFERENCES `facilities` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `room id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `room_features`
--
ALTER TABLE `room_features`
  ADD CONSTRAINT `features id` FOREIGN KEY (`features_id`) REFERENCES `features` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `room_id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `room_image`
--
ALTER TABLE `room_image`
  ADD CONSTRAINT `room_image_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;