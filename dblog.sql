-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Mar 22, 2022 at 10:59 PM
-- Server version: 8.0.28
-- PHP Version: 8.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dblog`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int NOT NULL,
  `post_id` int NOT NULL,
  `message` varchar(50) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_anonymous` tinyint(1) NOT NULL DEFAULT '0',
  `is_approved` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `post_id`, `message`, `name`, `created_at`, `is_anonymous`, `is_approved`) VALUES
(1, 1, 'Nice one!', 'Adam', '2022-03-17 06:00:29', 0, 0),
(2, 1, 'Ikr', 'Bob', '2022-03-17 06:00:29', 0, 1),
(3, 1, 'Awesome!', 'Chris', '2022-03-17 06:00:29', 1, 1),
(4, 2, 'Ikr', 'Ellie', '2022-03-17 06:04:46', 0, 0),
(6, 2, 'Awesome!', 'Frank', '2022-03-17 06:04:46', 1, 0),
(8, 1, 'TEST', 'S', '2022-03-17 06:33:42', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int NOT NULL,
  `user_id` int NOT NULL DEFAULT '1',
  `title` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `body` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `user_id`, `title`, `body`, `created_at`, `edited_at`) VALUES
(1, 1, 'First Blog', 'The first blog posted by Deng.\r\nRequirements:\r\nThe Project should be written using PHP 7.4 or higher\r\nWe expect genuinely self-written code, with no existing framework or library, or should\r\nhave no reference with any online code repository.\r\nShould use Mysql as the database management system\r\nThe website needs to be hosted on Nginx (Need to provide the virtual host file)\r\nCode needs to be pushed to the GIT version controller (Github or Bitbucket)\r\nThe developer needs to consider the MVC pattern, bootstrapping, and error handling\r\nThe developer needs to provide a database dump with some sample data.', '2022-03-16 03:24:51', '2022-03-21 05:07:37'),
(2, 2, 'Adelaide named as one of the world’s top destinations for 2022', 'While some of us already know that Adelaide is one of the hottest spots in the world, our sunny state has been recognised on the big stage once again, taking out one of the top spots in the 2022 National Geographic Traveller hot list!\r\n\r\nAdelaide placed sixth in the competition and is one of only two Australian cities to feature on the star-studded list, alongside our Eastern neighbour Victoria.\r\n\r\nFresh off the heels of being declared the most liveable city in the nation, and the third most liveable in the world by The Economist, National Geographic has recognised Adelaide as the second-best sustainable destination city.\r\n\r\nsource: https://glamadelaide.com.au/adelaide-named-as-one-of-the-worlds-top-destinations-for-2022/', '2022-03-16 03:26:43', NULL),
(3, 3, 'PHP Introduction', 'PHP is a general-purpose scripting language geared towards web development. It was originally created by Danish-Canadian programmer Rasmus Lerdorf in 1994. The PHP reference implementation is now produced by The PHP Group. PHP originally stood for Personal Home Page, but it now stands for the recursive initialism PHP: Hypertext Preprocessor.\r\n\r\nsource: https://en.wikipedia.org/wiki/PHP', '2022-03-17 01:58:09', NULL),
(5, 3, 'Adelaide', 'Adelaide is South Australia’s cosmopolitan coastal capital. Its ring of parkland on the River Torrens is home to renowned museums such as the Art Gallery of South Australia, displaying expansive collections including noted Indigenous art, and the South Australian Museum, devoted to natural history. The city\'s Adelaide Festival is an annual international arts gathering with spin-offs including fringe and film events. ― Google', '2022-03-20 15:15:21', '2022-03-22 06:29:11'),
(7, 4, 'E-commerce Introduction', 'E-commerce (electronic commerce) is the activity of electronically buying or selling of products on online services or over the Internet. E-commerce draws on technologies such as mobile commerce, electronic funds transfer, supply chain management, Internet marketing, online transaction processing, electronic data interchange (EDI), inventory management systems, and automated data collection systems. E-commerce is in turn driven by the technological advances of the semiconductor industry, and is the largest sector of the electronics industry.\r\n\r\nE-commerce typically uses the web for at least a part of a transaction\'s life cycle although it may also use other technologies such as e-mail. Typical e-commerce transactions include the purchase of products (such as books from Amazon) or services (such as music downloads in the form of digital distribution such as iTunes Store).[1] There are three areas of e-commerce: online retailing, electronic markets, and online auctions. E-commerce is supported by electronic business.[2]\r\n\r\nE-commerce businesses may also employ some or all of the following:\r\n\r\nOnline shopping for retail sales direct to consumers via web sites and mobile apps, and conversational commerce via live chat, chatbots, and voice assistants;[3]\r\nProviding or participating in online marketplaces, which process third-party business-to-consumer (B2C) or consumer-to-consumer (C2C) sales;\r\nBusiness-to-business (B2B) buying and selling;[4]\r\nGathering and using demographic data through web contacts and social media;\r\nB2B electronic data interchange;\r\nMarketing to prospective and established customers by e-mail or fax (for example, with newsletters);\r\nEngaging in pretail for launching new products and services;\r\nOnline financial exchanges for currency exchanges or trading purposes.', '2022-03-21 02:05:07', '2022-03-22 06:23:51');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `created_at`, `edited_at`) VALUES
(1, 'Derrick', '$2y$10$FuIWvBP3nYduZ37iYfvnsu4/MG9uh.QR0bMr2D9NAxINW.W9bdOgi', '2022-03-15 00:01:49', '2022-03-22 06:14:26'),
(2, 'Xiaobin', '$2y$10$hvjAQdz8Zv1PloCMsm0ITu8uJcYMgSrjM4o3UJiPc9R4Rt5ISmw3G', '2022-03-15 00:01:49', '2022-03-22 06:14:45'),
(3, 'John', '$2y$10$3Wy1hMjSVLn7Fn/P525mb.MhrGL8FLrCSS1xXNeBY/mdoXSF8DIi2', '2022-03-15 00:26:28', NULL),
(4, 'Adam', '$2y$10$6qJSD/NG6wYMl.f5cZwhY.qn454YJp.9cp3esb1R4unBVuPjs7nfK', '2022-03-19 15:57:23', '2022-03-22 06:58:42'),
(5, 'Chad', '$2y$10$z4YHOTHLIQpCl7J1yb2Yx.mAXjl5jNQYO/SjcmljjTbDxfE.pUYKG', '2022-03-19 15:57:23', '2022-03-20 23:46:19'),
(6, 'Chris', '$2y$10$7WlXDgZhM1Sl/aGRdh0oIO3Pa8GAZGkRrXgHqqaE3sTJg2dC8adN.', '2022-03-19 16:17:54', '2022-03-22 05:37:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
