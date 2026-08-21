-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Aug 21, 2026 at 11:28 AM
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
-- Database: `ruchi_recipes`
--

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE `collections` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(160) NOT NULL,
  `description` text DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `collections`
--

INSERT INTO `collections` (`id`, `user_id`, `title`, `description`, `is_public`) VALUES
(1, 1, 'Hari Raya Favourites', 'Festive Malay dishes for open house.', 1),
(2, 1, '15-Minute Malaysian Dinners', 'Quick weeknight plates.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `collection_items`
--

CREATE TABLE `collection_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `collection_id` int(10) UNSIGNED NOT NULL,
  `recipe_id` int(10) UNSIGNED NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `collection_items`
--

INSERT INTO `collection_items` (`id`, `collection_id`, `recipe_id`, `added_at`) VALUES
(1, 1, 2, '2026-08-18 09:49:50'),
(2, 1, 1, '2026-08-18 09:49:50'),
(3, 2, 3, '2026-08-18 09:49:50');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `recipe_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `body` text NOT NULL,
  `is_author_reply` tinyint(1) NOT NULL DEFAULT 0,
  `is_flagged` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `recipe_id`, `user_id`, `parent_id`, `body`, `is_author_reply`, `is_flagged`, `created_at`) VALUES
(1, 1, 5, NULL, 'Buat pagi tadi — sambal pedas pas! Terima kasih resepi.', 0, 0, '2026-08-18 09:49:50'),
(2, 1, 2, NULL, 'Suka dengar! Kalau nak kurang pedas, kurangkan cili kering sikit.', 1, 0, '2026-08-18 09:49:50'),
(3, 3, 5, NULL, 'Wok hei tip worked. Next time I will use a hotter flame.', 0, 0, '2026-08-18 09:49:50'),
(4, 1, 8, NULL, 'I Cooked This', 0, 0, '2026-08-18 11:44:12'),
(5, 3, 8, NULL, 'thids i excellent', 0, 0, '2026-08-19 03:52:14');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `email` varchar(190) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'madesh', 'abuthahirmohammed6@gmail.com', 'madesh', '2026-08-19 11:19:23'),
(2, 'Mohammed Abuthahir', 'abuthahirmohammed6@gmail.com', 'aaaasa', '2026-08-19 11:21:38'),
(3, 'Mohammed Abuthahir', 'abuthahirmohammed6@gmail.com', 'asasasasasasasasasasas', '2026-08-19 11:22:12'),
(4, 'naveen', 'nithilan2004@gmail.com', 'dsssdsdsdsdsdsdsdsdsd', '2026-08-19 11:23:26'),
(5, 'naveen', 'nithilan2004@gmail.com', 'dsssdsdsdsdsdsdsdsdsd', '2026-08-19 11:23:28'),
(6, 'Mohammed Abuthahir', 'abuthahirmohammed6@gmail.com', 'today i visit you web its awesome bro', '2026-08-19 11:25:40'),
(7, 'Ruchi form check', 'check@ruchi.local', 'Contact form working test. Name, email, and query only.', '2026-08-19 11:30:06');

-- --------------------------------------------------------

--
-- Table structure for table `cooked_logs`
--

CREATE TABLE `cooked_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `recipe_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `photo_url` varchar(500) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `cooked_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cooked_logs`
--

INSERT INTO `cooked_logs` (`id`, `recipe_id`, `user_id`, `photo_url`, `note`, `cooked_at`) VALUES
(1, 1, 8, NULL, NULL, '2026-08-18 11:47:13'),
(2, 7, 8, NULL, NULL, '2026-08-18 11:48:18'),
(4, 3, 8, NULL, NULL, '2026-08-19 03:52:39'),
(5, 3, 9, NULL, NULL, '2026-08-19 03:54:53'),
(6, 1, 2, NULL, NULL, '2026-08-19 04:06:58'),
(7, 3, 1, NULL, NULL, '2026-08-19 04:47:10'),
(8, 7, 5, NULL, NULL, '2026-08-19 11:31:59');

-- --------------------------------------------------------

--
-- Table structure for table `cuisines`
--

CREATE TABLE `cuisines` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `hero_image_url` varchar(500) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cuisines`
--

INSERT INTO `cuisines` (`id`, `name`, `slug`, `hero_image_url`, `description`) VALUES
(1, 'Malay', 'malay', 'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?w=1200&h=700&fit=crop', 'From fragrant nasi lemak to slow-cooked rendang — the heart of Malaysian home cooking.'),
(2, 'Chinese Malaysian', 'chinese-malaysian', 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=1200&h=700&fit=crop', 'Wok hei, street noodles, and family banquet dishes from Malaysian Chinese kitchens.'),
(3, 'Indian Malaysian', 'indian-malaysian', 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?w=1200&h=700&fit=crop', 'Spiced gravies, roti, and banana-leaf favourites shaped by Malaysian Indian heritage.'),
(4, 'Nyonya', 'nyonya', 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=1200&h=700&fit=crop', 'Peranakan fusion — sweet, sour, spicy recipes from Melaka and Penang.'),
(5, 'Sabah & Sarawak', 'sabah-sarawak', 'https://images.unsplash.com/photo-1547592166-23ac45744acd?w=1200&h=700&fit=crop', 'Borneo flavours — bamboo rice, midin, and coastal specialties.'),
(6, 'Traditional Indian', 'traditional-indian', 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?w=1200&h=700&fit=crop', 'Old Tamil and South Indian home foods — millet porridges, chinna vengaya (small onion) classics, and temple-town favourites.');

-- --------------------------------------------------------

--
-- Table structure for table `diet_tags`
--

CREATE TABLE `diet_tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diet_tags`
--

INSERT INTO `diet_tags` (`id`, `name`) VALUES
(4, 'Dairy-Free'),
(2, 'Gluten-Free'),
(1, 'Halal'),
(3, 'High-Protein'),
(6, 'Millet Based'),
(5, 'Quick Under 30'),
(7, 'Traditional / Ancestral');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(10) UNSIGNED NOT NULL,
  `recipe_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `recipe_id`, `user_id`, `created_at`) VALUES
(1, 1, 8, '2026-08-18 11:35:07'),
(2, 7, 8, '2026-08-18 11:43:11'),
(4, 3, 8, '2026-08-19 03:49:48'),
(5, 3, 9, '2026-08-19 03:54:13'),
(6, 1, 2, '2026-08-19 04:06:48'),
(7, 7, 5, '2026-08-19 11:31:41'),
(8, 2, 2, '2026-08-19 11:48:36');

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `id` int(10) UNSIGNED NOT NULL,
  `follower_id` int(10) UNSIGNED NOT NULL,
  `following_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `id` int(10) UNSIGNED NOT NULL,
  `recipe_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unit` varchar(40) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_optional` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`id`, `recipe_id`, `name`, `quantity`, `unit`, `sort_order`, `is_optional`) VALUES
(1, 1, 'Jasmine rice', 400.00, 'g', 1, 0),
(2, 1, 'Coconut milk', 400.00, 'ml', 2, 0),
(3, 1, 'Pandan leaves', 3.00, 'pcs', 3, 0),
(4, 1, 'Dried chillies', 20.00, 'pcs', 4, 0),
(5, 1, 'Shallots', 6.00, 'pcs', 5, 0),
(6, 1, 'Garlic cloves', 4.00, 'pcs', 6, 0),
(7, 1, 'Belacan', 1.00, 'tsp', 7, 0),
(8, 1, 'Tamarind paste', 2.00, 'tbsp', 8, 0),
(9, 1, 'Ikan bilis', 100.00, 'g', 9, 0),
(10, 1, 'Roasted peanuts', 80.00, 'g', 10, 0),
(11, 1, 'Eggs', 4.00, 'pcs', 11, 0),
(12, 1, 'Cucumber', 1.00, 'pcs', 12, 0),
(13, 2, 'Beef chuck', 1000.00, 'g', 1, 0),
(14, 2, 'Thick coconut milk', 800.00, 'ml', 2, 0),
(15, 2, 'Kerisik (toasted coconut)', 80.00, 'g', 3, 0),
(16, 2, 'Lemongrass stalks', 3.00, 'pcs', 4, 0),
(17, 2, 'Kaffir lime leaves', 6.00, 'pcs', 5, 0),
(18, 2, 'Turmeric leaves', 2.00, 'pcs', 6, 0),
(19, 2, 'Shallots', 10.00, 'pcs', 7, 0),
(20, 2, 'Garlic cloves', 6.00, 'pcs', 8, 0),
(21, 2, 'Ginger', 40.00, 'g', 9, 0),
(22, 2, 'Galangal', 40.00, 'g', 10, 0),
(23, 2, 'Dried chillies', 15.00, 'pcs', 11, 0),
(24, 3, 'Flat rice noodles (kway teow)', 400.00, 'g', 1, 0),
(25, 3, 'Prawns', 150.00, 'g', 2, 0),
(26, 3, 'Chinese sausage (lap cheong)', 1.00, 'pcs', 3, 0),
(27, 3, 'Bean sprouts', 150.00, 'g', 4, 0),
(28, 3, 'Chives (ku chai)', 40.00, 'g', 5, 0),
(29, 3, 'Eggs', 2.00, 'pcs', 6, 0),
(30, 3, 'Dark soy sauce', 1.00, 'tbsp', 7, 0),
(31, 3, 'Light soy sauce', 1.50, 'tbsp', 8, 0),
(32, 3, 'Chilli paste', 1.00, 'tbsp', 9, 0),
(33, 3, 'Lard or oil', 3.00, 'tbsp', 10, 0),
(34, 4, 'All-purpose flour', 500.00, 'g', 1, 0),
(35, 4, 'Ghee or oil', 80.00, 'ml', 2, 0),
(36, 4, 'Salt', 1.00, 'tsp', 3, 0),
(37, 4, 'Sugar', 1.00, 'tsp', 4, 0),
(38, 4, 'Warm water', 280.00, 'ml', 5, 0),
(39, 4, 'Yellow lentils', 200.00, 'g', 6, 0),
(40, 4, 'Onion', 1.00, 'pcs', 7, 0),
(41, 4, 'Tomato', 1.00, 'pcs', 8, 0),
(42, 4, 'Curry powder', 2.00, 'tbsp', 9, 0),
(43, 4, 'Coconut milk', 150.00, 'ml', 10, 0),
(44, 5, 'Rice vermicelli or thick laksa noodles', 400.00, 'g', 1, 0),
(45, 5, 'Coconut milk', 600.00, 'ml', 2, 0),
(46, 5, 'Prawns', 300.00, 'g', 3, 0),
(47, 5, 'Tofu puffs', 8.00, 'pcs', 4, 0),
(48, 5, 'Bean sprouts', 120.00, 'g', 5, 0),
(49, 5, 'Laksa leaves', 20.00, 'g', 6, 0),
(50, 5, 'Dried chillies', 12.00, 'pcs', 7, 0),
(51, 5, 'Shallots', 8.00, 'pcs', 8, 0),
(52, 5, 'Lemongrass', 2.00, 'pcs', 9, 0),
(53, 5, 'Candlenuts', 4.00, 'pcs', 10, 0),
(54, 5, 'Fish stock or water', 800.00, 'ml', 11, 0),
(55, 6, 'Glutinous rice', 300.00, 'g', 1, 0),
(56, 6, 'Coconut milk', 500.00, 'ml', 2, 0),
(57, 6, 'Pandan juice', 120.00, 'ml', 3, 0),
(58, 6, 'Sugar', 120.00, 'g', 4, 0),
(59, 6, 'Eggs or egg replacer', 2.00, 'pcs', 5, 0),
(60, 6, 'Plain flour', 40.00, 'g', 6, 0),
(61, 6, 'Salt', 1.00, 'tsp', 7, 0),
(62, 7, 'Chinna vengaya (pearl onions), peeled', 200.00, 'g', 1, 0),
(63, 7, 'Toor dal (thuvaram paruppu)', 120.00, 'g', 2, 0),
(64, 7, 'Tamarind pulp', 2.00, 'tbsp', 3, 0),
(65, 7, 'Sambar powder', 2.00, 'tbsp', 4, 0),
(66, 7, 'Turmeric powder', 0.50, 'tsp', 5, 0),
(67, 7, 'Tomato', 1.00, 'pcs', 6, 0),
(68, 7, 'Mustard seeds', 1.00, 'tsp', 7, 0),
(69, 7, 'Curry leaves', 1.00, 'sprig', 8, 0),
(70, 7, 'Dried red chilli', 2.00, 'pcs', 9, 0),
(71, 7, 'Gingelly / sesame oil or ghee', 2.00, 'tbsp', 10, 0),
(72, 7, 'Salt', 1.00, 'tsp', 11, 0),
(73, 7, 'Asafoetida (hing)', 0.25, 'tsp', 12, 0),
(74, 8, 'Big onions, sliced', 3.00, 'pcs', 1, 0),
(75, 8, 'Dried red chillies', 4.00, 'pcs', 2, 0),
(76, 8, 'Urad dal', 1.00, 'tbsp', 3, 0),
(77, 8, 'Tamarind small ball', 1.00, 'pcs', 4, 0),
(78, 8, 'Oil', 2.00, 'tbsp', 5, 0),
(79, 8, 'Salt', 0.75, 'tsp', 6, 0),
(80, 8, 'Mustard seeds', 0.50, 'tsp', 7, 0),
(81, 8, 'Curry leaves', 1.00, 'sprig', 8, 0),
(82, 9, 'Ragi flour (finger millet)', 200.00, 'g', 1, 0),
(83, 9, 'Water', 700.00, 'ml', 2, 0),
(84, 9, 'Salt', 0.50, 'tsp', 3, 0),
(85, 9, 'Sesame oil (optional, to grease hands)', 1.00, 'tsp', 4, 0),
(86, 10, 'Kambu (pearl millet) flour or broken kambu', 180.00, 'g', 1, 0),
(87, 10, 'Water for cooking', 900.00, 'ml', 2, 0),
(88, 10, 'Thick buttermilk / curd watered', 400.00, 'ml', 3, 0),
(89, 10, 'Small onion, finely chopped', 1.00, 'pcs', 4, 0),
(90, 10, 'Green chilli, chopped', 1.00, 'pcs', 5, 0),
(91, 10, 'Salt', 1.00, 'tsp', 6, 0),
(92, 10, 'Curry leaves (optional)', 1.00, 'sprig', 7, 0),
(93, 11, 'Thinai (foxtail millet)', 160.00, 'g', 1, 0),
(94, 11, 'Moong dal', 40.00, 'g', 2, 0),
(95, 11, 'Jaggery', 140.00, 'g', 3, 0),
(96, 11, 'Ghee', 3.00, 'tbsp', 4, 0),
(97, 11, 'Cashew nuts', 15.00, 'g', 5, 0),
(98, 11, 'Raisins', 15.00, 'g', 6, 0),
(99, 11, 'Cardamom powder', 0.50, 'tsp', 7, 0),
(100, 11, 'Water', 650.00, 'ml', 8, 0),
(101, 12, 'Samai (little millet)', 180.00, 'g', 1, 0),
(102, 12, 'Onion, finely chopped', 1.00, 'pcs', 2, 0),
(103, 12, 'Carrot, diced', 1.00, 'pcs', 3, 0),
(104, 12, 'Green peas', 50.00, 'g', 4, 0),
(105, 12, 'Green chillies', 2.00, 'pcs', 5, 0),
(106, 12, 'Ginger, minced', 1.00, 'tsp', 6, 0),
(107, 12, 'Mustard seeds', 1.00, 'tsp', 7, 0),
(108, 12, 'Urad dal', 1.00, 'tsp', 8, 0),
(109, 12, 'Curry leaves', 1.00, 'sprig', 9, 0),
(110, 12, 'Oil', 2.00, 'tbsp', 10, 0),
(111, 12, 'Water', 450.00, 'ml', 11, 0),
(112, 12, 'Salt', 1.00, 'tsp', 12, 0),
(113, 12, 'Lemon juice', 1.00, 'tsp', 13, 0),
(114, 13, 'Idli rice', 300.00, 'g', 1, 0),
(115, 13, 'Urad dal', 100.00, 'g', 2, 0),
(116, 13, 'Thick poha / aval', 40.00, 'g', 3, 0),
(117, 13, 'Black pepper, crushed', 1.00, 'tsp', 4, 0),
(118, 13, 'Cumin seeds', 1.00, 'tsp', 5, 0),
(119, 13, 'Ginger, finely chopped', 1.00, 'tbsp', 6, 0),
(120, 13, 'Green chilli, chopped', 1.00, 'pcs', 7, 0),
(121, 13, 'Curry leaves, chopped', 2.00, 'tbsp', 8, 0),
(122, 13, 'Cashew nuts', 15.00, 'g', 9, 0),
(123, 13, 'Ghee or oil', 2.00, 'tbsp', 10, 0),
(124, 13, 'Salt', 1.25, 'tsp', 11, 0),
(132, 15, 'Mangai', 1.00, 'g', 1, 0),
(133, 16, 'Mangai', 1.00, 'g', 1, 0),
(141, 19, 'asas', 1.00, 'g', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `type` varchar(60) NOT NULL,
  `message` varchar(500) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `read_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nutrition_info`
--

CREATE TABLE `nutrition_info` (
  `id` int(10) UNSIGNED NOT NULL,
  `recipe_id` int(10) UNSIGNED NOT NULL,
  `calories` decimal(8,2) NOT NULL,
  `protein_g` decimal(8,2) NOT NULL,
  `carbs_g` decimal(8,2) NOT NULL,
  `fat_g` decimal(8,2) NOT NULL,
  `fiber_g` decimal(8,2) DEFAULT NULL,
  `sugar_g` decimal(8,2) DEFAULT NULL,
  `sodium_mg` decimal(8,2) DEFAULT NULL,
  `per_serving` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nutrition_info`
--

INSERT INTO `nutrition_info` (`id`, `recipe_id`, `calories`, `protein_g`, `carbs_g`, `fat_g`, `fiber_g`, `sugar_g`, `sodium_mg`, `per_serving`) VALUES
(1, 1, 620.00, 18.00, 72.00, 28.00, 4.00, 8.00, 780.00, 1),
(2, 2, 540.00, 36.00, 12.00, 38.00, 3.00, 5.00, 620.00, 1),
(3, 3, 710.00, 28.00, 78.00, 30.00, 4.00, 6.00, 1180.00, 1),
(4, 4, 480.00, 14.00, 62.00, 18.00, 7.00, 4.00, 520.00, 1),
(5, 5, 590.00, 24.00, 58.00, 30.00, 5.00, 7.00, 890.00, 1),
(6, 6, 280.00, 4.00, 42.00, 11.00, 1.00, 18.00, 140.00, 1),
(7, 7, 210.00, 9.50, 32.00, 5.50, 7.20, 6.00, 480.00, 1),
(8, 8, 95.00, 2.40, 10.00, 5.20, 2.10, 4.50, 290.00, 1),
(9, 9, 245.00, 6.80, 48.00, 2.20, 8.50, 0.80, 220.00, 1),
(10, 10, 195.00, 7.10, 34.00, 3.80, 6.40, 3.20, 360.00, 1),
(11, 11, 320.00, 7.50, 54.00, 9.00, 5.80, 22.00, 40.00, 1),
(12, 12, 265.00, 7.00, 44.00, 7.50, 6.00, 4.00, 410.00, 1),
(13, 13, 185.00, 6.20, 30.00, 4.50, 2.80, 1.20, 350.00, 1),
(15, 15, 12.00, 12.00, 12.00, 12.00, 12.00, 12.00, 12.01, 1),
(16, 16, 12.00, 12.00, 12.00, 12.00, 12.00, 12.00, 12.00, 1),
(18, 19, 12.00, 12.00, 12.00, 12.00, 12.00, 12.00, 12.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(10) UNSIGNED NOT NULL,
  `recipe_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `stars` tinyint(3) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `recipe_id`, `user_id`, `stars`, `created_at`) VALUES
(1, 1, 5, 5, '2026-08-18 09:49:50'),
(2, 1, 3, 5, '2026-08-18 09:49:50'),
(3, 2, 5, 5, '2026-08-18 09:49:50'),
(4, 3, 5, 4, '2026-08-18 09:49:50'),
(5, 4, 5, 5, '2026-08-18 09:49:50'),
(6, 5, 3, 5, '2026-08-18 09:49:50'),
(7, 6, 5, 4, '2026-08-18 09:49:50'),
(8, 1, 8, 5, '2026-08-18 11:35:02'),
(10, 7, 8, 5, '2026-08-18 11:48:18'),
(13, 3, 8, 5, '2026-08-19 03:49:41'),
(15, 8, 5, 5, '2026-08-19 10:44:44'),
(16, 8, 3, 4, '2026-08-19 10:44:44'),
(17, 9, 5, 5, '2026-08-19 10:44:44'),
(18, 9, 1, 5, '2026-08-19 10:44:44'),
(19, 10, 5, 5, '2026-08-19 10:44:44'),
(20, 11, 5, 5, '2026-08-19 10:44:44'),
(21, 11, 3, 4, '2026-08-19 10:44:44'),
(22, 12, 5, 5, '2026-08-19 10:44:44'),
(23, 13, 5, 5, '2026-08-19 10:44:44'),
(24, 13, 3, 5, '2026-08-19 10:44:44'),
(25, 3, 1, 5, '2026-08-19 10:48:06');

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `slug` varchar(220) NOT NULL,
  `description` text NOT NULL,
  `author_id` int(10) UNSIGNED NOT NULL,
  `cuisine_id` int(10) UNSIGNED NOT NULL,
  `food_type` enum('VEG','NON_VEG','VEGAN','EGGETARIAN') NOT NULL DEFAULT 'VEG',
  `meal_type` enum('BREAKFAST','LUNCH','DINNER','SNACK','DESSERT','BEVERAGE') NOT NULL DEFAULT 'DINNER',
  `difficulty` enum('EASY','MEDIUM','HARD') NOT NULL DEFAULT 'EASY',
  `prep_time_mins` int(10) UNSIGNED NOT NULL DEFAULT 15,
  `cook_time_mins` int(10) UNSIGNED NOT NULL DEFAULT 30,
  `servings` int(10) UNSIGNED NOT NULL DEFAULT 4,
  `hero_image_url` varchar(500) NOT NULL,
  `video_clip_url` varchar(500) DEFAULT NULL,
  `status` enum('DRAFT','SUBMITTED','PUBLISHED','REJECTED') NOT NULL DEFAULT 'DRAFT',
  `view_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `cooked_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `published_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `title`, `slug`, `description`, `author_id`, `cuisine_id`, `food_type`, `meal_type`, `difficulty`, `prep_time_mins`, `cook_time_mins`, `servings`, `hero_image_url`, `video_clip_url`, `status`, `view_count`, `cooked_count`, `created_at`, `published_at`) VALUES
(1, 'Nasi Lemak Classic', 'nasi-lemak-classic', 'Malaysia\'s beloved coconut rice with sambal, crispy ikan bilis, peanuts, egg, and cucumber. Perfect for breakfast or anytime.', 2, 1, 'NON_VEG', 'BREAKFAST', 'MEDIUM', 25, 40, 4, 'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?w=1200&h=800&fit=crop', 'https://videos.pexels.com/video-files/4259125/4259125-sd_640_360_25fps.mp4', 'PUBLISHED', 1302, 98, '2026-08-18 09:49:50', '2026-08-18 15:19:50'),
(2, 'Beef Rendang', 'beef-rendang', 'Slow-cooked beef in rich coconut and spice paste until dark, tender and intensely aromatic — a festive Malay classic.', 2, 1, 'NON_VEG', 'DINNER', 'HARD', 40, 180, 6, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSJwxD1EFWULakq3D-j70eyxVQ31XzupilY5hLqN74XYAJi1-PKdPVgibfX&s=10', NULL, 'PUBLISHED', 984, 54, '2026-08-18 09:49:50', '2026-08-18 15:19:50'),
(3, 'Penang Char Kway Teow', 'penang-char-kway-teow', 'Smoky flat rice noodles wok-tossed with prawns, lap cheong, bean sprouts and dark soy — street-food energy at home.', 3, 2, 'NON_VEG', 'DINNER', 'MEDIUM', 20, 15, 2, 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=1200&h=800&fit=crop', NULL, 'PUBLISHED', 1587, 115, '2026-08-18 09:49:50', '2026-08-18 15:19:50'),
(4, 'Roti Canai with Dhal', 'roti-canai-dhal', 'Flaky layered flatbread with creamy lentil curry — the Malaysian mamak breakfast you can make at home.', 4, 3, 'VEG', 'BREAKFAST', 'HARD', 90, 45, 4, 'https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=1200&h=800&fit=crop', 'https://videos.pexels.com/video-files/3329230/3329230-sd_640_360_24fps.mp4', 'PUBLISHED', 870, 41, '2026-08-18 09:49:50', '2026-08-18 15:19:50'),
(5, 'Nyonya Laksa Lemak', 'nyonya-laksa-lemak', 'Creamy coconut laksa with rice noodles, prawns, tofu puff and fragrant rempah — Penang-Melaka soul in a bowl.', 2, 4, 'NON_VEG', 'LUNCH', 'MEDIUM', 35, 40, 4, 'https://images.unsplash.com/photo-1555126634-323283e090fa?w=1200&h=800&fit=crop', NULL, 'PUBLISHED', 1121, 67, '2026-08-18 09:49:50', '2026-08-18 15:19:50'),
(6, 'Kuih Seri Muka', 'kuih-seri-muka', 'Two-layer Nyonya kuih — glutinous rice base topped with pandan coconut custard. Soft, fragrant and festive.', 2, 4, 'EGGETARIAN', 'DESSERT', 'MEDIUM', 30, 50, 8, 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=1200&h=800&fit=crop', NULL, 'PUBLISHED', 641, 38, '2026-08-18 09:49:50', '2026-08-18 15:19:50'),
(7, 'Chinna Vengaya Sambar (Small Onion)', 'chinna-vengaya-sambar', 'Classic Tamil sambar with chinna vengaya (pearl / small onions) — the old Kanchipuram-style onion gravy served with rice or idli.', 6, 6, 'VEG', 'LUNCH', 'MEDIUM', 20, 35, 4, 'https://images.unsplash.com/photo-1546833999-b9f581a1996d?w=1200&h=800&fit=crop', 'https://videos.pexels.com/video-files/4259125/4259125-sd_640_360_25fps.mp4', 'PUBLISHED', 429, 30, '2026-08-18 09:49:55', '2026-08-18 15:19:55'),
(8, 'Vengaya Thuvayal (Onion Chutney)', 'vengaya-thuvayal', 'Smoky roasted onion chutney from old Tamil kitchens — pairs with dosa, idli, and millet upma.', 6, 6, 'VEGAN', 'BREAKFAST', 'EASY', 10, 15, 4, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS0bXZBso5SxVi2XXTzBy1B_wh3O7p1Pg3v_529XQfshtwMypaLLA4APY4&s=10', 'https://videos.pexels.com/video-files/4259128/4259128-sd_640_360_30fps.mp4', 'PUBLISHED', 312, 19, '2026-08-18 09:49:55', '2026-08-18 15:19:55'),
(9, 'Ragi Kali (Finger Millet Ball)', 'ragi-kali', 'Ancestral ragi (kezhvaragu) kali — soft millet balls traditionally eaten with greens kuzhambu or buttermilk.', 6, 6, 'VEGAN', 'LUNCH', 'MEDIUM', 10, 25, 3, 'https://images.unsplash.com/photo-1516684669134-de6f7c473a2a?w=1200&h=800&fit=crop', 'https://videos.pexels.com/video-files/6894026/6894026-sd_640_360_25fps.mp4', 'PUBLISHED', 561, 41, '2026-08-18 09:49:55', '2026-08-18 15:19:55'),
(10, 'Kambu Koozh (Pearl Millet Porridge)', 'kambu-koozh', 'Cooling fermented pearl-millet koozh — a village summer staple, usually mixed with buttermilk and raw onion.', 6, 6, 'VEG', 'BREAKFAST', 'EASY', 15, 30, 4, 'https://images.unsplash.com/photo-1490474418585-ba9bad8fd0ea?w=1200&h=800&fit=crop', 'https://videos.pexels.com/video-files/3763322/3763322-sd_640_360_24fps.mp4', 'PUBLISHED', 391, 33, '2026-08-18 09:49:55', '2026-08-18 15:19:55'),
(11, 'Thinai Sakkarai Pongal (Foxtail Millet)', 'thinai-sakkarai-pongal', 'Festival-style sweet pongal made with thinai (foxtail millet) instead of rice — lighter, high-fibre ancestral sweet.', 4, 6, 'VEG', 'DESSERT', 'MEDIUM', 15, 35, 4, 'https://images.unsplash.com/photo-1631452180519-c014fe946bc7?w=1200&h=800&fit=crop', 'https://videos.pexels.com/video-files/3329230/3329230-sd_640_360_24fps.mp4', 'PUBLISHED', 277, 16, '2026-08-18 09:49:55', '2026-08-18 15:19:55'),
(12, 'Samai Vegetable Upma (Little Millet)', 'samai-vegetable-upma', 'Savoury little-millet upma with onions and mixed vegetables — everyday old-style breakfast that digests lighter than rava.', 4, 6, 'VEGAN', 'BREAKFAST', 'EASY', 15, 20, 3, 'https://i.pinimg.com/736x/80/bd/7b/80bd7bd9e00294c157b118445520e81f.jpg', 'https://videos.pexels.com/video-files/3329214/3329214-sd_640_360_24fps.mp4', 'PUBLISHED', 344, 24, '2026-08-18 09:49:55', '2026-08-18 15:19:55'),
(13, 'Kanchipuram Idli', 'kanchipuram-idli', 'Spiced temple-town idli from Kanchipuram — pepper, cumin, ginger and curry-leaf tempering in the batter for an old festival taste.', 6, 6, 'VEG', 'BREAKFAST', 'HARD', 480, 25, 6, 'https://images.unsplash.com/photo-1589301760014-d929f3979dbc?w=1200&h=800&fit=crop', 'https://videos.pexels.com/video-files/4259141/4259141-sd_640_360_30fps.mp4', 'PUBLISHED', 611, 37, '2026-08-18 09:49:55', '2026-08-18 15:19:55'),
(15, 'Mambalam oorgai', 'mambalam-oorgai-da3cfd', 'this is mambalam oorgai it will give you the better body and good for health', 8, 6, 'VEG', 'LUNCH', 'EASY', 15, 30, 4, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSGVZy_6ocKbw7lDfkuY2knLBaKsftoiXXfpgUQph_reg&s', 'https://www.youtube.com/watch?v=nQZOGshpNO8', 'REJECTED', 0, 0, '2026-08-18 11:55:37', NULL),
(16, 'manga', 'manga-8766b1', 'asasa', 8, 2, 'VEG', 'BREAKFAST', 'EASY', 15, 30, 4, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSGVZy_6ocKbw7lDfkuY2knLBaKsftoiXXfpgUQph_reg&s', NULL, 'REJECTED', 0, 0, '2026-08-18 11:58:28', NULL),
(19, 'adsasas', 'adsasas-8cda46', 'asasas', 2, 2, 'VEG', 'BREAKFAST', 'EASY', 15, 30, 4, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSGVZy_6ocKbw7lDfkuY2knLBaKsftoiXXfpgUQph_reg&s', NULL, 'REJECTED', 0, 0, '2026-08-19 04:23:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `recipe_diet_tags`
--

CREATE TABLE `recipe_diet_tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `recipe_id` int(10) UNSIGNED NOT NULL,
  `diet_tag_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe_diet_tags`
--

INSERT INTO `recipe_diet_tags` (`id`, `recipe_id`, `diet_tag_id`) VALUES
(1, 1, 1),
(2, 1, 3),
(3, 2, 1),
(4, 2, 2),
(5, 2, 3),
(6, 3, 5),
(7, 4, 1),
(8, 5, 1),
(9, 5, 4),
(10, 6, 1),
(11, 6, 4),
(12, 7, 1),
(15, 7, 4),
(13, 7, 6),
(14, 7, 7),
(16, 8, 1),
(17, 8, 4),
(18, 8, 5),
(19, 8, 7),
(20, 9, 1),
(21, 9, 2),
(22, 9, 4),
(23, 9, 6),
(24, 9, 7),
(25, 10, 1),
(26, 10, 6),
(27, 10, 7),
(28, 11, 1),
(29, 11, 6),
(30, 11, 7),
(31, 12, 1),
(32, 12, 4),
(33, 12, 5),
(34, 12, 6),
(35, 12, 7),
(36, 13, 1),
(37, 13, 7);

-- --------------------------------------------------------

--
-- Table structure for table `recipe_images`
--

CREATE TABLE `recipe_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `recipe_id` int(10) UNSIGNED NOT NULL,
  `url` varchar(500) NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recipe_steps`
--

CREATE TABLE `recipe_steps` (
  `id` int(10) UNSIGNED NOT NULL,
  `recipe_id` int(10) UNSIGNED NOT NULL,
  `step_number` int(10) UNSIGNED NOT NULL,
  `instruction` text NOT NULL,
  `image_url` varchar(500) DEFAULT NULL,
  `timer_seconds` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe_steps`
--

INSERT INTO `recipe_steps` (`id`, `recipe_id`, `step_number`, `instruction`, `image_url`, `timer_seconds`) VALUES
(1, 1, 1, 'Rinse rice until water runs clear. Cook with coconut milk, a pinch of salt, and knotted pandan leaves until fluffy.', NULL, 1500),
(2, 1, 2, 'Soak dried chillies, blend with shallots, garlic and belacan into a smooth paste.', NULL, NULL),
(3, 1, 3, 'Fry the chilli paste in oil until fragrant and oil separates. Add tamarind, sugar and salt to taste for sambal.', NULL, 600),
(4, 1, 4, 'Deep-fry ikan bilis until crispy. Soft-boil or fry the eggs. Slice cucumber.', NULL, 480),
(5, 1, 5, 'Plate coconut rice with sambal, ikan bilis, peanuts, egg and cucumber. Serve hot.', NULL, NULL),
(6, 2, 1, 'Blend shallots, garlic, ginger, galangal and soaked chillies into a rempah paste.', NULL, NULL),
(7, 2, 2, 'Fry rempah in oil until fragrant. Add beef pieces and coat well.', NULL, 480),
(8, 2, 3, 'Pour in coconut milk, bruised lemongrass, lime leaves and turmeric leaves. Simmer gently, stirring often.', NULL, 7200),
(9, 2, 4, 'When sauce thickens and darkens, stir in kerisik. Continue until oil separates and meat is tender.', NULL, 1800),
(10, 2, 5, 'Rest 15 minutes before serving with rice or ketupat.', NULL, 900),
(11, 3, 1, 'Loosen noodles under warm water. Prep prawns, slice sausage, wash sprouts and chives.', NULL, NULL),
(12, 3, 2, 'Heat wok until smoking. Fry prawns and sausage, push aside, scramble eggs.', NULL, 120),
(13, 3, 3, 'Add noodles, soy sauces and chilli paste. Toss hard for wok hei.', NULL, 180),
(14, 3, 4, 'Fold in bean sprouts and chives. Serve immediately on a hot plate.', NULL, 60),
(15, 4, 1, 'Knead flour, salt, sugar, oil and water into a soft dough. Rest coated in oil.', NULL, 3600),
(16, 4, 2, 'Divide dough, oil each ball, rest again. Meanwhile simmer lentils with spices for dhal.', NULL, 1800),
(17, 4, 3, 'Flip and stretch each dough ball thin, fold into layers, cook on a hot griddle with ghee until golden.', NULL, NULL),
(18, 4, 4, 'Finish dhal with coconut milk. Serve hot roti with the curry.', NULL, NULL),
(19, 5, 1, 'Blend rempah: chillies, shallots, lemongrass, candlenuts, turmeric and belacan.', NULL, NULL),
(20, 5, 2, 'Fry rempah until oil separates. Add stock and simmer.', NULL, 600),
(21, 5, 3, 'Stir in coconut milk, tofu puffs and prawns. Season with salt and a touch of sugar.', NULL, 480),
(22, 5, 4, 'Blanch noodles and sprouts. Assemble bowls, ladle soup, garnish with laksa leaves and chilli.', NULL, NULL),
(23, 6, 1, 'Soak glutinous rice 2 hours. Steam with salt and some coconut milk until half-cooked, then press into a tray.', NULL, 7200),
(24, 6, 2, 'Whisk pandan juice, remaining coconut milk, sugar, flour and eggs for the custard layer.', NULL, NULL),
(25, 6, 3, 'Pour custard over rice. Steam until set and a skewer comes out clean.', NULL, 2400),
(26, 6, 4, 'Cool completely before slicing into diamond pieces.', NULL, 1800),
(27, 7, 1, 'Wash toor dal. Pressure-cook with turmeric and enough water until soft and mashable.', NULL, 900),
(28, 7, 2, 'Soak tamarind in warm water, extract thick pulp. Peel chinna vengaya and keep whole.', NULL, 600),
(29, 7, 3, 'In a pot, heat oil. Temper mustard, dried chilli, curry leaves and hing. Add pearl onions and sauté until glossy.', NULL, 300),
(30, 7, 4, 'Add chopped tomato, sambar powder and a splash of water. Cook until onions soften and tomato melts.', NULL, 480),
(31, 7, 5, 'Pour tamarind pulp, salt and simmer until raw smell goes. Add mashed dal, adjust consistency, boil once more.', NULL, 600),
(32, 7, 6, 'Rest 5 minutes. Serve hot with steamed rice, idli or millet rice.', NULL, 300),
(33, 8, 1, 'Heat 1 tbsp oil. Roast urad dal and red chillies until golden. Set aside.', NULL, 180),
(34, 8, 2, 'In the same pan, roast sliced onions with a little oil until deeply browned at edges (this gives the old-style smoky taste).', NULL, 420),
(35, 8, 3, 'Cool slightly. Grind onions, roasted dal, chillies, tamarind and salt with minimal water to a coarse paste.', NULL, NULL),
(36, 8, 4, 'Temper mustard and curry leaves in oil, pour over thuvayal. Serve with hot idli or dosa.', NULL, 120),
(37, 9, 1, 'Mix 4 tbsp ragi flour with 150 ml water into a lump-free slurry. Keep remaining flour dry.', NULL, NULL),
(38, 9, 2, 'Boil the rest of the water with salt. Lower flame, pour slurry while stirring continuously.', NULL, 300),
(39, 9, 3, 'Add remaining ragi flour little by little, stirring firmly so no lumps form. Cook until the mass leaves the pan sides.', NULL, 600),
(40, 9, 4, 'Cover and steam on low heat for 5–7 minutes for soft texture.', NULL, 420),
(41, 9, 5, 'Grease hands with oil, shape warm kali into balls. Serve with keerai kuzhambu, sambar or buttermilk.', NULL, NULL),
(42, 10, 1, 'Mix kambu flour with a little water to a smooth paste. Boil remaining water.', NULL, NULL),
(43, 10, 2, 'Add paste to boiling water, stir continuously until thick porridge forms. Cook well.', NULL, 900),
(44, 10, 3, 'Cool completely. Traditionally leave covered overnight for light fermentation (old village method).', NULL, 28800),
(45, 10, 4, 'Next day (or once cool), loosen koozh with buttermilk, salt, chopped onion and green chilli. Serve cool.', NULL, NULL),
(46, 11, 1, 'Dry-roast thinai and moong dal lightly. Wash and pressure-cook with water until soft.', NULL, 900),
(47, 11, 2, 'Melt jaggery with a little water, strain to remove impurities.', NULL, 300),
(48, 11, 3, 'Combine cooked millet-dal mash with jaggery syrup. Cook on medium, stirring until glossy.', NULL, 480),
(49, 11, 4, 'Add cardamom. Fry cashews and raisins in ghee, pour over pongal. Serve warm.', NULL, 180),
(50, 12, 1, 'Wash samai, drain. Dry-roast 2 minutes for nutty aroma.', NULL, 120),
(51, 12, 2, 'Heat oil, temper mustard, urad dal, curry leaves, green chilli and ginger. Sauté onion until soft.', NULL, 300),
(52, 12, 3, 'Add carrot and peas, cook 2 minutes. Add water and salt; bring to a boil.', NULL, 240),
(53, 12, 4, 'Add samai, stir, cover and cook on low until water is absorbed and grains are soft.', NULL, 720),
(54, 12, 5, 'Fluff with a fork, squeeze lemon, rest 2 minutes and serve with coconut chutney or vengaya thuvayal.', NULL, 120),
(55, 13, 1, 'Soak rice, urad dal and poha separately 4–5 hours. Grind to a slightly coarse idli batter. Ferment overnight.', NULL, NULL),
(56, 13, 2, 'Heat ghee. Roast cashew, pepper, cumin, ginger, chilli and curry leaves. Cool slightly.', NULL, 300),
(57, 13, 3, 'Mix tempering and salt into fermented batter. Grease tall tumblers or idli moulds.', NULL, NULL),
(58, 13, 4, 'Pour batter and steam until a skewer comes out clean (about 12–15 minutes for tumbler style).', NULL, 900),
(59, 13, 5, 'Unmould, slice if steamed in tumblers. Serve with coconut chutney and chinna vengaya sambar.', NULL, NULL),
(66, 15, 1, 'you do da', NULL, NULL),
(67, 16, 1, 'aasasa', NULL, NULL),
(74, 19, 1, 'asasasas', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `role` enum('USER','AUTHOR','MODERATOR','ADMIN') NOT NULL DEFAULT 'USER',
  `name` varchar(120) NOT NULL,
  `email` varchar(190) NOT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `avatar_url` varchar(500) DEFAULT NULL,
  `cover_photo_url` varchar(500) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `is_verified_author` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `email`, `password_hash`, `avatar_url`, `cover_photo_url`, `bio`, `is_verified_author`, `created_at`) VALUES
(1, 'ADMIN', 'Admin Ruchi', 'admin@ruchi.my', '$2y$10$dmMesX.0iIcs4SmeeW5Oy.xT.BkJNqWYLwwbC95V3SJh345JL7WDa', 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=200&h=200&fit=crop', NULL, 'Platform admin for Ruchi Malaysia.', 1, '2026-08-18 09:49:50'),
(2, 'AUTHOR', 'Siti Aminah', 'siti@ruchi.my', '$2y$10$dmMesX.0iIcs4SmeeW5Oy.xT.BkJNqWYLwwbC95V3SJh345JL7WDa', 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=200&h=200&fit=crop', NULL, 'Home cook from Melaka. Specialises in Malay comfort food and festive dishes.', 1, '2026-08-18 09:49:50'),
(3, 'AUTHOR', 'Chen Wei Ming', 'chen@ruchi.my', '$2y$10$dmMesX.0iIcs4SmeeW5Oy.xT.BkJNqWYLwwbC95V3SJh345JL7WDa', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&h=200&fit=crop', NULL, 'Penang hawker-inspired recipes from a third-generation cook.', 1, '2026-08-18 09:49:50'),
(4, 'AUTHOR', 'Priya Nair', 'priya@ruchi.my', '$2y$10$dmMesX.0iIcs4SmeeW5Oy.xT.BkJNqWYLwwbC95V3SJh345JL7WDa', 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=200&h=200&fit=crop', NULL, 'Malaysian Indian kitchen — banana leaf classics made for home cooks.', 1, '2026-08-18 09:49:50'),
(5, 'USER', 'Aiman Razak', 'aiman@ruchi.my', '$2y$10$dmMesX.0iIcs4SmeeW5Oy.xT.BkJNqWYLwwbC95V3SJh345JL7WDa', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=200&h=200&fit=crop', NULL, 'Weekend cook from KL.', 0, '2026-08-18 09:49:50'),
(6, 'AUTHOR', 'Lakshmi Amma', 'lakshmi@ruchi.my', '$2y$10$dmMesX.0iIcs4SmeeW5Oy.xT.BkJNqWYLwwbC95V3SJh345JL7WDa', 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=200&h=200&fit=crop', NULL, 'Keeps ancestral Tamil millet and onion recipes from Kanchipuram & Thanjavur kitchens.', 0, '2026-08-18 09:49:55'),
(7, 'USER', 'Test User', 'testuser@gmail.com', '$2y$10$i1v1K93XbDKLCl3eDlhm6uAbKKp/YEEXkBrD3GvKoNMoPP3yc7Vfi', NULL, NULL, NULL, 0, '2026-08-18 11:29:12'),
(8, 'USER', 'Mohammed Abuthahir', 'abuthahirmohammed6@gmail.com', '$2y$10$1BGu3L/4Ic0l/1l7V3LFRu442aqXlPKMO2xmoG6vhIVmTjLLhmNbC', NULL, NULL, NULL, 0, '2026-08-18 11:32:59'),
(9, 'USER', 'Mahi', 'maho86479@gmail.com', '$2y$10$NEZzSNeUVEagkHtJu./9LO9kYpEHp7ZOHHzxBJZZ3bN0Hxr5tyiZO', NULL, NULL, NULL, 0, '2026-08-19 03:53:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_col_user` (`user_id`);

--
-- Indexes for table `collection_items`
--
ALTER TABLE `collection_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_col_item` (`collection_id`,`recipe_id`),
  ADD KEY `fk_ci_recipe` (`recipe_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cmt_recipe` (`recipe_id`),
  ADD KEY `fk_cmt_user` (`user_id`),
  ADD KEY `fk_cmt_parent` (`parent_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cooked_logs`
--
ALTER TABLE `cooked_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_cooked` (`recipe_id`,`user_id`),
  ADD KEY `fk_cooked_user` (`user_id`);

--
-- Indexes for table `cuisines`
--
ALTER TABLE `cuisines`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `diet_tags`
--
ALTER TABLE `diet_tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_fav` (`recipe_id`,`user_id`),
  ADD KEY `fk_fav_user` (`user_id`);

--
-- Indexes for table `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_follow` (`follower_id`,`following_id`),
  ADD KEY `fk_follow_following` (`following_id`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ing_recipe` (`recipe_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notif_user` (`user_id`);

--
-- Indexes for table `nutrition_info`
--
ALTER TABLE `nutrition_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `recipe_id` (`recipe_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_rating` (`recipe_id`,`user_id`),
  ADD KEY `fk_rate_user` (`user_id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_recipe_author` (`author_id`),
  ADD KEY `idx_recipes_status` (`status`),
  ADD KEY `idx_recipes_food_type` (`food_type`),
  ADD KEY `idx_recipes_cuisine` (`cuisine_id`);

--
-- Indexes for table `recipe_diet_tags`
--
ALTER TABLE `recipe_diet_tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_recipe_diet` (`recipe_id`,`diet_tag_id`),
  ADD KEY `fk_rdt_tag` (`diet_tag_id`);

--
-- Indexes for table `recipe_images`
--
ALTER TABLE `recipe_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_img_recipe` (`recipe_id`);

--
-- Indexes for table `recipe_steps`
--
ALTER TABLE `recipe_steps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_step_recipe` (`recipe_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `collection_items`
--
ALTER TABLE `collection_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cooked_logs`
--
ALTER TABLE `cooked_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cuisines`
--
ALTER TABLE `cuisines`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `diet_tags`
--
ALTER TABLE `diet_tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `follows`
--
ALTER TABLE `follows`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nutrition_info`
--
ALTER TABLE `nutrition_info`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `recipe_diet_tags`
--
ALTER TABLE `recipe_diet_tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `recipe_images`
--
ALTER TABLE `recipe_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recipe_steps`
--
ALTER TABLE `recipe_steps`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `collections`
--
ALTER TABLE `collections`
  ADD CONSTRAINT `fk_col_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `collection_items`
--
ALTER TABLE `collection_items`
  ADD CONSTRAINT `fk_ci_col` FOREIGN KEY (`collection_id`) REFERENCES `collections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ci_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_cmt_parent` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cmt_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cmt_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cooked_logs`
--
ALTER TABLE `cooked_logs`
  ADD CONSTRAINT `fk_cooked_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cooked_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `fk_fav_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_fav_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `fk_follow_follower` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_follow_following` FOREIGN KEY (`following_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD CONSTRAINT `fk_ing_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notif_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `nutrition_info`
--
ALTER TABLE `nutrition_info`
  ADD CONSTRAINT `fk_nut_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `fk_rate_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_rate_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `fk_recipe_author` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_recipe_cuisine` FOREIGN KEY (`cuisine_id`) REFERENCES `cuisines` (`id`);

--
-- Constraints for table `recipe_diet_tags`
--
ALTER TABLE `recipe_diet_tags`
  ADD CONSTRAINT `fk_rdt_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_rdt_tag` FOREIGN KEY (`diet_tag_id`) REFERENCES `diet_tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recipe_images`
--
ALTER TABLE `recipe_images`
  ADD CONSTRAINT `fk_img_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recipe_steps`
--
ALTER TABLE `recipe_steps`
  ADD CONSTRAINT `fk_step_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
