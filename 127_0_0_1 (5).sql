-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2025 at 07:29 AM
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
-- Database: `db_library_management_system`
--
CREATE DATABASE IF NOT EXISTS `db_library_management_system` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_library_management_system`;

-- --------------------------------------------------------

--
-- Table structure for table `admin_acc`
--

CREATE TABLE `admin_acc` (
  `admin_no` int(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` int(255) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL,
  `last_logged_in` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_acc`
--

INSERT INTO `admin_acc` (`admin_no`, `password`, `first_name`, `last_name`, `email`, `otp`, `otp_expiry`, `last_logged_in`) VALUES
(24, '$2y$10$dr/xPTuo0SKxNn0sqSjEBur.uzORuYHbFpUqjpspN2KlZJIIEmR.O', 'Nino', 'Barzaga', 'freddricktropico14@gmail.com', NULL, NULL, '2025-03-20 13:00:25'),
(26, '', 'freddrick', 'tropico', 'ic.freddrick.tropico@cvsu.edu.ph', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `archived_acc`
--

CREATE TABLE `archived_acc` (
  `archived_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `archived_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `librarian_acc`
--

CREATE TABLE `librarian_acc` (
  `librarian_no` int(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` int(255) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL,
  `last_logged_in` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stud_acc`
--

CREATE TABLE `stud_acc` (
  `acc_no` int(255) NOT NULL,
  `student_no` int(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `otp` varchar(6) NOT NULL,
  `otp_expiry` datetime DEFAULT NULL,
  `last_logged_in` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stud_acc`
--

INSERT INTO `stud_acc` (`acc_no`, `student_no`, `password`, `first_name`, `last_name`, `email`, `contact`, `otp`, `otp_expiry`, `last_logged_in`) VALUES
(32, 202210330, '$2y$10$G/9GplXQZOr0xAiofJIVuu/Iqtn2eChf56Ct91acxSnoDGBiPxFFu', 'FREDDRICK', 'TROPICO', 'ic.freddrick.tropico@cvsu.edu.ph', '09515254884', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_books`
--

CREATE TABLE `tbl_books` (
  `book_id` int(255) NOT NULL,
  `book_cover` varchar(255) DEFAULT NULL,
  `book_title` varchar(255) NOT NULL,
  `book_author` varchar(255) NOT NULL,
  `book_description` text NOT NULL,
  `publisher_id` int(11) DEFAULT NULL,
  `publication_date` date NOT NULL,
  `ISBN` int(255) NOT NULL,
  `book_genre_id` int(11) DEFAULT NULL,
  `book_stocks` int(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_students`
--

CREATE TABLE `tbl_students` (
  `student_id` int(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `student_number` int(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_students`
--

INSERT INTO `tbl_students` (`student_id`, `last_name`, `first_name`, `student_number`, `email`) VALUES
(1, 'ASPERILLA', 'JAMES CARLO', 202211106, 'ic.jamescarlo.asperilla@cvsu.edu.ph'),
(2, 'BAUTISTA', 'HAZEL ANNE', 202210344, 'ic.hazelanne.bautista@cvsu.edu.ph'),
(3, 'BITANCOR', 'XEVIER  CLYDE', 202210347, 'ic.xevierclyde.bitancor@cvsu.edu.ph'),
(4, 'BUCLARES', 'RHANEL SEIGHMONE', 202221074, 'ic.rhanelseighmone.buclares@cvsu.edu.ph'),
(5, 'CALAIS', 'GIULIANI', 202210572, 'ic.giuliani.calais@cvsu.edu.ph'),
(6, 'CAMPAÑA', 'LOEL', 202210275, 'ic.loel.campana@cvsu.edu.ph'),
(7, 'CASTAÑEDA', 'DANIELA ROMANA', 202210352, 'ic.danielaromana.castaneda@cvsu.edu.ph'),
(8, 'CINCO', 'DANIELA FAITH', 202210356, 'ic.danielafaith.cinco@cvsu.edu.ph'),
(9, 'DE CASTRO', 'KRISCHELLE', 202210363, 'ic.krischelle.de castro@cvsu.edu.ph'),
(10, 'ENRIQUE', 'LORD RAVEN FLEA IRIS', 202210810, 'ic.lordravenfleairis.enrique@cvsu.edu.ph'),
(11, 'FABIAN', 'MEG ANGELINE', 202210202, 'ic.megangeline.fabian@cvsu.edu.ph'),
(12, 'FIDELIS', 'ALEN', 202210203, 'ic.alen.fidelis@cvsu.edu.ph'),
(13, 'GALO', 'SHANLEY', 202210206, 'ic.shanley.galo@cvsu.edu.ph'),
(14, 'GASCON', 'JAMAIELYN MAY', 202210289, 'ic.jamaielynmay.gascon@cvsu.edu.ph'),
(15, 'GERVACIO', 'DANIELA', 202210291, 'ic.daniela.gervacio@cvsu.edu.ph'),
(16, 'GUMATAS', 'ANGELA KATE', 202210208, 'ic.angelakate.gumatas@cvsu.edu.ph'),
(17, 'JAVIER', 'JAN HARVEY', 202210215, 'ic.janharvey.javier@cvsu.edu.ph'),
(18, 'KOA', 'KRISTINE', 202210299, 'ic.kristine.koa@cvsu.edu.ph'),
(19, 'LABANIEGO', 'EVAN KERR', 202210723, 'ic.evankerr.labaniego@cvsu.edu.ph'),
(20, 'LAGSAC', 'ANGELO MHYR', 202211201, 'ic.angelomhyr.lagsac@cvsu.edu.ph'),
(21, 'LOFAMIA', 'DHANIEL', 202211203, 'ic.dhaniel.lofamia@cvsu.edu.ph'),
(22, 'MACASPAC', 'JOHN PATRICK', 202210219, 'ic.johnpatrick.macaspac@cvsu.edu.ph'),
(23, 'MORALES', 'CHARICE', 202210224, 'ic.charice.morales@cvsu.edu.ph'),
(24, 'NAGTALON', 'PRINCE HARVEY', 202310536, 'ic.princeharvey.nagtalon@cvsu.edu.ph'),
(25, 'NICOL', 'CARLOS JR', 202210227, 'ic.carlosjr.nicol@cvsu.edu.ph'),
(26, 'OMEGA', 'REYMART', 202211207, 'ic.reymart.omega@cvsu.edu.ph'),
(27, 'ORELLANO', 'JOHNRIEL', 202110696, 'ic.johnriel.orellano@cvsu.edu.ph'),
(28, 'PALIMA', 'GINNA', 202210236, 'ic.ginna.palima@cvsu.edu.ph'),
(29, 'PANGILIN', 'JASMINE', 202210315, 'ic.jasmine.pangilin@cvsu.edu.ph'),
(30, 'PAR', 'JOHN PATRICK', 202210239, 'ic.johnpatrick.par@cvsu.edu.ph'),
(31, 'RAMA', 'ANDREI ANGELO', 202211211, 'ic.andreiangelo.rama@cvsu.edu.ph'),
(32, 'SANGIL', 'JOEY', 202210323, 'ic.joey.sangil@cvsu.edu.ph'),
(33, 'SANTOS', 'RODNEY', 202210324, 'ic.rodney.santos@cvsu.edu.ph'),
(34, 'SERRANO', 'KATE', 202210250, 'ic.kate.serrano@cvsu.edu.ph'),
(35, 'TOLEDO', 'MARC ANDREI', 202210255, 'ic.marcandrei.toledo@cvsu.edu.ph'),
(36, 'TROPICO', 'FREDDRICK', 202210330, 'ic.freddrick.tropico@cvsu.edu.ph'),
(37, 'VALENTINO', 'MARTIN LOUIS', 202210334, 'ic.martinlouis.valentino@cvsu.edu.ph'),
(38, 'VELASCO', 'HAZEL MAE', 202210260, 'ic.hazelmae.velasco@cvsu.edu.ph'),
(39, 'ZULUETA', 'RAVEN NICO', 202210263, 'ic.ravennico.zulueta@cvsu.edu.ph');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_acc`
--
ALTER TABLE `admin_acc`
  ADD PRIMARY KEY (`admin_no`);

--
-- Indexes for table `archived_acc`
--
ALTER TABLE `archived_acc`
  ADD PRIMARY KEY (`archived_id`);

--
-- Indexes for table `librarian_acc`
--
ALTER TABLE `librarian_acc`
  ADD PRIMARY KEY (`librarian_no`);

--
-- Indexes for table `stud_acc`
--
ALTER TABLE `stud_acc`
  ADD PRIMARY KEY (`acc_no`);

--
-- Indexes for table `tbl_books`
--
ALTER TABLE `tbl_books`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `tbl_students`
--
ALTER TABLE `tbl_students`
  ADD PRIMARY KEY (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_acc`
--
ALTER TABLE `admin_acc`
  MODIFY `admin_no` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `archived_acc`
--
ALTER TABLE `archived_acc`
  MODIFY `archived_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `librarian_acc`
--
ALTER TABLE `librarian_acc`
  MODIFY `librarian_no` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `stud_acc`
--
ALTER TABLE `stud_acc`
  MODIFY `acc_no` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tbl_books`
--
ALTER TABLE `tbl_books`
  MODIFY `book_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `tbl_students`
--
ALTER TABLE `tbl_students`
  MODIFY `student_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
