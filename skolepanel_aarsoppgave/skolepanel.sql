-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2024 at 11:47 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skolepanel`
--

CREATE DATABASE skolepanel;
USE skolepanel;

-- --------------------------------------------------------

--
-- Table structure for table `annotations`
--

CREATE TABLE `annotations` (
  `annotation_id` int(50) NOT NULL,
  `student_id` int(50) NOT NULL,
  `subject_type` varchar(50) NOT NULL,
  `annotation_text` varchar(200) NOT NULL,
  `annotation_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `annotations`
--

INSERT INTO `annotations` (`annotation_id`, `student_id`, `subject_type`, `annotation_text`, `annotation_date`) VALUES
(218, 1, 'Norsk', 'Kom forsinket', '2023-11-30');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(50) NOT NULL,
  `class_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `class_name`) VALUES
(1, '10A'),
(2, '10B'),
(3, '10C'),
(4, '10D'),
(5, '10E'),
(6, '9A'),
(7, '9B'),
(8, '9C'),
(9, '9D');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `feedback` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `feedback`) VALUES
(1, '0'),
(5, 'fffefef'),
(6, 'test345');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `class` varchar(50) NOT NULL,
  `absence` varchar(50) NOT NULL,
  `comment` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `first_name`, `last_name`, `class`, `absence`, `comment`) VALUES
(28, 'Nikolas', 'Bjørklund', '2D', 'Ingen', ''),
(56, 'Andreas', 'Bakken', '10C', 'Udokumentert', 'Ut eleifend et ex eu commodo. Cras scelerisque porttitor nibh maximus rutrum. Vestibulum rhoncus nunc porttitor pretium vestibulum. In consequat sem vitae ante molestie scelerisque.'),
(57, 'Maria', 'Berntsen', '10B', 'Til stede', ''),
(58, 'Ingeborg', 'Bakken', '10B', 'Dokumentert', 'Quisque tortor velit, placerat non sapien in, gravida consequat nisl. Curabitur vel porttitor velit. Integer ut varius lacus. '),
(59, 'Frida', 'Hovden', '10A', 'Til stede', ''),
(60, 'Oliver', 'Bakken', '10C', 'Til stede', ''),
(61, 'Andreas', 'Johnsen', '10B', 'Til stede', ''),
(62, 'Petter', 'Eriksen', '10B', 'Til stede', ''),
(63, 'Frida', 'Berge', '9C', 'Ingen', ''),
(64, 'Oscar', 'Svendsen', '10C', 'Til stede', ''),
(65, 'Johannes', 'Moe', '10D', 'Ingen', ''),
(66, 'Olav', 'Bøe', '10A', 'Ingen', ''),
(67, 'Nora', 'Hovde', '10B', 'Til stede', ''),
(68, 'Silje', 'Birkeland', '9C', 'Til stede', ''),
(69, 'Alexander', 'Brekke', '9B', 'Til stede', ''),
(70, 'Pernille', 'Sørensen', '9D', 'Til stede', ''),
(71, 'Kristine', 'Borge', '10B', 'Til stede', ''),
(72, 'Ole', 'Berge', '9A', 'Ingen', ''),
(73, 'Hanna', 'Helle', '10E', 'Til stede', ''),
(74, 'William', 'Haugen', '9A', 'Til stede', ''),
(75, 'Kristine', 'Hovde', '10D', 'Til stede', ''),
(76, 'Ole', 'Eriksen', '9B', 'Til stede', ''),
(77, 'Andreas', 'Hermansen', '9B', 'Til stede', ''),
(78, 'Sara', 'Johannessen', '10D', 'Dokumentert', 'In nibh sapien, congue id aliquam at, egestas in augue. Sed sit amet nulla felis. Cras semper turpis tempor mauris finibus, ac imperdiet elit condimentum.'),
(79, 'Emma', 'Hovden', '9B', 'Til stede', ''),
(80, 'Hilde', 'Knutsen', '9C', 'Til stede', ''),
(81, 'Håkon', 'Sætre', '9B', 'Dokumentert', 'Aliquam augue tellus, sodales luctus elementum convallis, sagittis malesuada dui.'),
(82, 'Sara', 'Svendsen', '10E', 'Til stede', ''),
(83, 'Ole', 'Berge', '10A', 'Til stede', ''),
(84, 'Alexander', 'Nilsen', '10B', 'Til stede', ''),
(85, 'Sander', 'Haugen', '10A', 'Til stede', ''),
(86, 'Magnus', 'Berge', '10E', 'Til stede', ''),
(87, 'Thea', 'Halvorsen', '9B', 'Dokumentert', 'Quisque tortor velit, placerat non sapien in, gravida consequat nisl. Curabitur vel porttitor velit. Integer ut varius lacus. '),
(88, 'Amalie', 'Helle', '9C', 'Til stede', ''),
(89, 'Terje', 'Kristiansen', '9D', 'Til stede', ''),
(90, 'Mia', 'Solberg', '9D', 'Dokumentert', 'In nibh sapien, congue id aliquam at, egestas in augue. Sed sit amet nulla felis. Cras semper turpis tempor mauris finibus, ac imperdiet elit condimentum.'),
(91, 'Magnus', 'Berge', '10B', 'Til stede', ''),
(92, 'Maria', 'Gundersen', '9A', 'Til stede', ''),
(93, 'Nora', 'Lund', '10B', 'Dokumentert', 'Praesent eros purus, cursus id arcu ultrices, sollicitudin vestibulum ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse quis nisi nec enim vehicula ornare.'),
(94, 'Bjørn', 'Halvorsen', '10E', 'Udokumentert', 'Ut eleifend et ex eu commodo. Cras scelerisque porttitor nibh maximus rutrum. Vestibulum rhoncus nunc porttitor pretium vestibulum. In consequat sem vitae ante molestie scelerisque.'),
(95, 'Eirik', 'Hovland', '9D', 'Til stede', ''),
(96, 'Pernille', 'Iversen', '9D', 'Til stede', ''),
(97, 'Thomas', 'Pettersen', '10D', 'Til stede', ''),
(98, 'Ingrid', 'Berg', '10C', 'Til stede', ''),
(99, 'Lucas', 'Fredriksen', '10A', 'Til stede', ''),
(100, 'Matias', 'Hermansen', '10B', 'Til stede', ''),
(101, 'Hedda', 'Bjerke', '10B', 'Ingen', ''),
(102, 'Karen', 'Brekke', '9A', 'Til stede', ''),
(103, 'Aurora', 'Hagen', '10C', 'Dokumentert', 'Pellentesque lacus orci, sollicitudin quis nunc aliquam, feugiat lacinia leo. Nulla elementum augue eu urna consequat congue. Etiam laoreet erat ac odio molestie viverra.'),
(104, 'Andreas', 'Helle', '10B', 'Ingen', ''),
(105, 'Frida', 'Lunde', '9C', 'Til stede', ''),
(106, 'Lilly', 'Hovde', '10E', 'Til stede', ''),
(107, 'Ingrid', 'Borge', '9D', 'Til stede', ''),
(108, 'Lise', 'Solheim', '9A', 'Ingen', ''),
(109, 'Hilde', 'Borge', '9D', 'Udokumentert', 'In nibh sapien, congue id aliquam at, egestas in augue. Sed sit amet nulla felis. Cras semper turpis tempor mauris finibus, ac imperdiet elit condimentum.'),
(110, 'Tiril', 'Nilsen', '10C', 'Til stede', ''),
(111, 'Elise', 'Sætre', '10D', 'Til stede', ''),
(112, 'Mathilde', 'Brekke', '10C', 'Ingen', ''),
(113, 'Håkon', 'Birkeland', '10C', 'Til stede', ''),
(114, 'Olav', 'Sæther', '10C', 'Dokumentert', 'Ut eleifend et ex eu commodo. Cras scelerisque porttitor nibh maximus rutrum. Vestibulum rhoncus nunc porttitor pretium vestibulum. In consequat sem vitae ante molestie scelerisque.'),
(115, 'William', 'Bjerke', '10E', 'Ingen', ''),
(116, 'Karen', 'Hovland', '9A', 'Til stede', ''),
(117, 'Thomas', 'Sæther', '9A', 'Til stede', ''),
(118, 'Lea', 'Hermansen', '9C', 'Udokumentert', 'Quisque tortor velit, placerat non sapien in, gravida consequat nisl. Curabitur vel porttitor velit. Integer ut varius lacus. '),
(119, 'Alma', 'Hovland', '10C', 'Til stede', ''),
(120, 'Fredrik', 'Hansen', '9C', 'Til stede', ''),
(121, 'Emil', 'Bøe', '9A', 'Dokumentert', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ipsum est, fermentum ut fermentum vitae, semper vitae justo. Maecenas vulputate tellus in mauris volutpat, in dictum odio vestibulum. Cras'),
(122, 'Daniel', 'Eriksen', '10D', 'Dokumentert', 'Praesent eros purus, cursus id arcu ultrices, sollicitudin vestibulum ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse quis nisi nec enim vehicula ornare.'),
(123, 'Victoria', 'Lunde', '10C', 'Til stede', ''),
(124, 'Aksel', 'Brekke', '9B', 'Ingen', ''),
(125, 'Thomas', 'Haugen', '10A', 'Til stede', ''),
(126, 'Tone', 'Berge', '10C', 'Til stede', ''),
(127, 'Arne', 'Birkeland', '10C', 'Til stede', ''),
(128, 'Kristian', 'Fredriksen', '9D', 'Til stede', ''),
(129, 'Nora', 'Sætre', '9D', 'Udokumentert', 'Nunc nec metus vitae lorem dictum rhoncus id nec ligula. Aliquam imperdiet aliquam eros, et maximus odio tristique in. In bibendum commodo eleifend.'),
(130, 'Matias', 'Bjerke', '9B', 'Til stede', ''),
(131, 'Jon', 'Bøe', '9B', 'Til stede', ''),
(132, 'Victoria', 'Dahl', '9D', 'Til stede', ''),
(133, 'Karen', 'Birkeland', '10A', 'Til stede', ''),
(134, 'Hilde', 'Helle', '10C', 'Udokumentert', 'In nibh sapien, congue id aliquam at, egestas in augue. Sed sit amet nulla felis. Cras semper turpis tempor mauris finibus, ac imperdiet elit condimentum.'),
(135, 'Martin', 'Berg', '9A', 'Til stede', ''),
(136, 'Mathilde', 'Berge', '9D', 'Til stede', ''),
(137, 'Lea', 'Borge', '10E', 'Til stede', ''),
(138, 'Eirik', 'Bøe', '9D', 'Til stede', ''),
(139, 'William', 'Borge', '9D', 'Til stede', ''),
(140, 'Oscar', 'Bakken', '10D', 'Til stede', ''),
(141, 'Terje', 'Pedersen', '10D', 'Dokumentert', 'Aliquam augue tellus, sodales luctus elementum convallis, sagittis malesuada dui.'),
(142, 'Herman', 'Sætre', '10B', 'Til stede', ''),
(143, 'Ida', 'Dahl', '9A', 'Udokumentert', 'Ut eleifend et ex eu commodo. Cras scelerisque porttitor nibh maximus rutrum. Vestibulum rhoncus nunc porttitor pretium vestibulum. In consequat sem vitae ante molestie scelerisque.'),
(144, 'Roger', 'Hermansen', '9B', 'Dokumentert', 'Nunc nec metus vitae lorem dictum rhoncus id nec ligula. Aliquam imperdiet aliquam eros, et maximus odio tristique in. In bibendum commodo eleifend.'),
(145, 'Øystein', 'Sætre', '9C', 'Til stede', ''),
(146, 'Eline', 'Lunde', '9B', 'Til stede', ''),
(147, 'Geir', 'Evensen', '10B', 'Ingen', ''),
(148, 'Sebastian', 'Lund', '10C', 'Til stede', ''),
(149, 'Bjørn', 'Helle', '10D', 'Til stede', ''),
(150, 'Lucas', 'Bakken', '10A', 'Til stede', ''),
(151, 'Erik', 'Moe', '10E', 'Til stede', ''),
(152, 'Sofie', 'Bjerke', '9C', 'Til stede', ''),
(153, 'Marie', 'Johnsen', '9B', 'Til stede', ''),
(154, 'Johannes', 'Borge', '10C', 'Udokumentert', 'Aliquam augue tellus, sodales luctus elementum convallis, sagittis malesuada dui.'),
(155, 'Liam', 'Brekke', '10A', 'Til stede', ''),
(156, 'Emma', 'Hermansen', '9A', 'Ingen', ''),
(157, 'Isabella', 'Hovden', '10A', 'Til stede', ''),
(158, 'Sebastian', 'Berge', '10E', 'Til stede', ''),
(159, 'Live', 'Strand', '9C', 'Til stede', ''),
(160, 'Marie', 'Aas', '10A', 'Til stede', ''),
(161, 'Aurora', 'Johnsen', '10C', 'Ingen', ''),
(162, 'Karen', 'Hovde', '10E', 'Dokumentert', 'Praesent eros purus, cursus id arcu ultrices, sollicitudin vestibulum ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse quis nisi nec enim vehicula ornare.'),
(163, 'Benjamin', 'Dahl', '10A', 'Til stede', ''),
(164, 'Emilie', 'Haugen', '9C', 'Til stede', ''),
(165, 'Leah', 'Hermansen', '10C', 'Til stede', ''),
(166, 'Ida', 'Bakken', '10C', 'Til stede', ''),
(167, 'Fredrik', 'Helle', '10E', 'Til stede', ''),
(168, 'Matias', 'Halvorsen', '10B', 'Til stede', ''),
(169, 'Victor', 'Evensen', '10E', 'Til stede', ''),
(170, 'Mia', 'Nielsen', '9B', 'Til stede', ''),
(171, 'Victor', 'Bøe', '10D', 'Til stede', ''),
(172, 'Marte', 'Jensen', '9D', 'Til stede', ''),
(173, 'Hanna', 'Borge', '9D', 'Til stede', ''),
(174, 'Selma', 'Bakken', '10B', 'Ingen', ''),
(175, 'Lucas', 'Hermansen', '9A', 'Dokumentert', 'In nibh sapien, congue id aliquam at, egestas in augue. Sed sit amet nulla felis. Cras semper turpis tempor mauris finibus, ac imperdiet elit condimentum.'),
(176, 'Emilie', 'Eriksen', '9C', 'Til stede', ''),
(177, 'Roger', 'Birkeland', '10B', 'Til stede', ''),
(178, 'Maja', 'Bjerke', '10C', 'Dokumentert', 'Praesent eros purus, cursus id arcu ultrices, sollicitudin vestibulum ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse quis nisi nec enim vehicula ornare.'),
(179, 'Magnus', 'Brekke', '10B', 'Dokumentert', 'In nibh sapien, congue id aliquam at, egestas in augue. Sed sit amet nulla felis. Cras semper turpis tempor mauris finibus, ac imperdiet elit condimentum.'),
(180, 'Matias', 'Dahl', '10D', 'Dokumentert', 'In nibh sapien, congue id aliquam at, egestas in augue. Sed sit amet nulla felis. Cras semper turpis tempor mauris finibus, ac imperdiet elit condimentum.'),
(181, 'Daniel', 'Aas', '10B', 'Til stede', ''),
(182, 'Emilie', 'Hovden', '9A', 'Ingen', ''),
(183, 'Alma', 'Hansen', '9B', 'Til stede', ''),
(184, 'Hedda', 'Knutsen', '9D', 'Til stede', ''),
(185, 'Jonas', 'Lund', '9B', 'Ingen', ''),
(186, 'Sara', 'Sætre', '10B', 'Til stede', ''),
(187, 'Herman', 'Moen', '10C', 'Til stede', ''),
(188, 'Linnea', 'Bøe', '10A', 'Til stede', ''),
(189, 'Selma', 'Jacobsen', '9A', 'Til stede', ''),
(190, 'Olav', 'Hovland', '9A', 'Til stede', ''),
(191, 'Thomas', 'Bakken', '9D', 'Til stede', ''),
(192, 'Lilly', 'Halvorsen', '10E', 'Dokumentert', 'Ut eleifend et ex eu commodo. Cras scelerisque porttitor nibh maximus rutrum. Vestibulum rhoncus nunc porttitor pretium vestibulum. In consequat sem vitae ante molestie scelerisque.'),
(193, 'Terje', 'Berge', '9B', 'Ingen', ''),
(194, 'Jonas', 'Moe', '9D', 'Dokumentert', 'Quisque tortor velit, placerat non sapien in, gravida consequat nisl. Curabitur vel porttitor velit. Integer ut varius lacus. '),
(195, 'Selma', 'Bjerke', '9A', 'Ingen', ''),
(196, 'Camilla', 'Hermansen', '10E', 'Udokumentert', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ipsum est, fermentum ut fermentum vitae, semper vitae justo. Maecenas vulputate tellus in mauris volutpat, in dictum odio vestibulum. Cras'),
(197, 'Marte', 'Bakken', '9D', 'Til stede', ''),
(198, 'Amelia', 'Hovland', '10B', 'Til stede', ''),
(199, 'Sebastian', 'Johansen', '10A', 'Til stede', ''),
(200, 'Hilde', 'Solheim', '10C', 'Til stede', ''),
(201, 'Nora', 'Bøe', '10B', 'Dokumentert', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ipsum est, fermentum ut fermentum vitae, semper vitae justo. Maecenas vulputate tellus in mauris volutpat, in dictum odio vestibulum. Cras'),
(202, 'Jon', 'Fredriksen', '9C', 'Udokumentert', 'Aliquam augue tellus, sodales luctus elementum convallis, sagittis malesuada dui.'),
(203, 'Ingeborg', 'Borge', '10A', 'Til stede', ''),
(204, 'Per', 'Moen', '10E', 'Ingen', ''),
(205, 'Johannes', 'Helle', '10D', 'Ingen', ''),
(206, 'Alexander', 'Berge', '10B', 'Udokumentert', 'In nibh sapien, congue id aliquam at, egestas in augue. Sed sit amet nulla felis. Cras semper turpis tempor mauris finibus, ac imperdiet elit condimentum.'),
(207, 'Tiril', 'Bakken', '9C', 'Til stede', ''),
(208, 'Thomas', 'Berge', '10C', 'Til stede', ''),
(209, 'Selma', 'Haugland', '10C', 'Udokumentert', 'Nunc nec metus vitae lorem dictum rhoncus id nec ligula. Aliquam imperdiet aliquam eros, et maximus odio tristique in. In bibendum commodo eleifend.'),
(210, 'Emilie', 'Hovde', '9A', 'Til stede', ''),
(211, 'Noah', 'Bøe', '10B', 'Til stede', ''),
(212, 'Elias', 'Pedersen', '9C', 'Dokumentert', 'Ut eleifend et ex eu commodo. Cras scelerisque porttitor nibh maximus rutrum. Vestibulum rhoncus nunc porttitor pretium vestibulum. In consequat sem vitae ante molestie scelerisque.'),
(213, 'Marcus', 'Hagen', '10A', 'Til stede', ''),
(214, 'Oliver', 'Hermansen', '9A', 'Udokumentert', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ipsum est, fermentum ut fermentum vitae, semper vitae justo. Maecenas vulputate tellus in mauris volutpat, in dictum odio vestibulum. Cras'),
(215, 'Bjørn', 'Hovde', '10D', 'Til stede', ''),
(216, 'Tone', 'Hovde', '10C', 'Til stede', ''),
(217, 'Amelia', 'Johnsen', '9A', 'Udokumentert', 'Pellentesque lacus orci, sollicitudin quis nunc aliquam, feugiat lacinia leo. Nulla elementum augue eu urna consequat congue. Etiam laoreet erat ac odio molestie viverra.'),
(218, 'Jonas', 'Hovden', '9C', 'Til stede', ''),
(219, 'Noah', 'Borge', '10A', 'Til stede', ''),
(220, 'Pernille', 'Berge', '10E', 'Til stede', ''),
(221, 'Roger', 'Berge', '10C', 'Til stede', ''),
(222, 'Oliver', 'Iversen', '10E', 'Til stede', ''),
(223, 'Matias', 'Bakken', '10D', 'Dokumentert', 'Quisque tortor velit, placerat non sapien in, gravida consequat nisl. Curabitur vel porttitor velit. Integer ut varius lacus. '),
(224, 'Frida', 'Hovden', '10A', 'Til stede', ''),
(225, 'Hedda', 'Berge', '10B', 'Udokumentert', 'Aliquam augue tellus, sodales luctus elementum convallis, sagittis malesuada dui.'),
(226, 'Knut', 'Hovden', '10E', 'Til stede', ''),
(227, 'Emilia', 'Bakken', '9B', 'Udokumentert', 'Ut eleifend et ex eu commodo. Cras scelerisque porttitor nibh maximus rutrum. Vestibulum rhoncus nunc porttitor pretium vestibulum. In consequat sem vitae ante molestie scelerisque.'),
(228, 'Mathilde', 'Bøe', '9B', 'Til stede', ''),
(229, 'Silje', 'Hagen', '10B', 'Til stede', ''),
(230, 'Hedda', 'Johansen', '10B', 'Til stede', ''),
(231, 'Ingeborg', 'Berge', '9A', 'Til stede', ''),
(232, 'Marie', 'Haugland', '10C', 'Ingen', ''),
(233, 'Filip', 'Hovde', '9D', 'Udokumentert', 'Aliquam augue tellus, sodales luctus elementum convallis, sagittis malesuada dui.'),
(234, 'Arne', 'Hagen', '10A', 'Til stede', ''),
(235, 'Emil', 'Bøe', '10C', 'Udokumentert', 'Ut eleifend et ex eu commodo. Cras scelerisque porttitor nibh maximus rutrum. Vestibulum rhoncus nunc porttitor pretium vestibulum. In consequat sem vitae ante molestie scelerisque.'),
(236, 'Øystein', 'Pedersen', '9A', 'Til stede', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `access` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `mail`, `password`, `access`) VALUES
(1, 'rektor', 'rrektorr@osloskolen.no', '2acfa5bc90c2a1077a408cee690d778e61dd8394d212c85e2c57474422f24d1d', '*'),
(2, '10alærer', '10alaerer@osloskolen.no', '8c70002d1aa500608d6495c0786859e9426a3d6226d9f5853c1e961fbfd9e69c', '1'),
(3, '10bclærer', '10bclaerer@osloskolen.no', 'c62e6cb6c06727636296dbb97ef73f149a3fe837557221726add6210479e9e84', '2-3'),
(4, '10dlærer', '10dlaerer@osloskolen.no', '74a9b50d3369e15627772491cf7eace35cc0c857769a7c9f651db653ac14a78c', '4'),
(14, 'Testbruker', 'test1@oslo.no', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', '3'),
(15, 'avdeling10', 'test2@oslo.no', '25aa739a4cca3f9eb6382e332b0f1768a4b0217d8dde48194bb818a5bca7c678', '1-2-3-4-5'),
(21, 'Adrian', 'test@adrian.mail', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', '6-7');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `annotations`
--
ALTER TABLE `annotations`
  ADD PRIMARY KEY (`annotation_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
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
-- AUTO_INCREMENT for table `annotations`
--
ALTER TABLE `annotations`
  MODIFY `annotation_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=238;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;