-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2025 at 02:17 PM
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
(28, '$2y$10$y2HTqm3GQxZRFl.V0Rt1dOIIpeaOHh62qrdA0w.eeqQLA8JrEJLDK', 'fred', 'trop', 'freddricktropico@gmail.com', NULL, NULL, '2025-05-07 10:18:04');

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
-- Table structure for table `book_likes_dislikes`
--

CREATE TABLE `book_likes_dislikes` (
  `id` int(11) NOT NULL,
  `acc_no` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `action` enum('like','dislike') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `book_renewal_history`
--

CREATE TABLE `book_renewal_history` (
  `bookrenewal_id` int(11) NOT NULL,
  `acc_no` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `renewal_date` date NOT NULL,
  `new_due_date` date NOT NULL,
  `status` enum('Renewed','Expired') NOT NULL,
  `book_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `borrowed_books`
--

CREATE TABLE `borrowed_books` (
  `borrow_id` int(255) NOT NULL,
  `student_no` int(255) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` text NOT NULL,
  `contact` varchar(255) NOT NULL,
  `book_id` int(255) NOT NULL,
  `ISBN` int(255) NOT NULL,
  `book_title` varchar(255) NOT NULL,
  `preferred_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowed_books`
--

INSERT INTO `borrowed_books` (`borrow_id`, `student_no`, `first_name`, `last_name`, `email`, `contact`, `book_id`, `ISBN`, `book_title`, `preferred_date`, `due_date`, `status`) VALUES
(49, 202210330, 'FREDDRICK', 'TROPICO', 'ic.freddrick.tropico@cvsu.edu.ph', '09515254884', 563, 2701, 'Moby Dick; Or, The Whale', '2025-05-12', '2025-05-15', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `borrowing_history`
--

CREATE TABLE `borrowing_history` (
  `borrowing_id` int(11) NOT NULL,
  `acc_no` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `borrow_date` date NOT NULL,
  `due_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('Borrowed','Returned','Pending') NOT NULL,
  `book_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `collection_books`
--

CREATE TABLE `collection_books` (
  `collection_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `book_title` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` text DEFAULT NULL,
  `acc_no` varchar(50) NOT NULL
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

--
-- Dumping data for table `librarian_acc`
--

INSERT INTO `librarian_acc` (`librarian_no`, `password`, `first_name`, `last_name`, `email`, `otp`, `otp_expiry`, `last_logged_in`) VALUES
(19, '$2y$10$DnWlnoBPmfjIJxrSK.5vAuxrFV2CALqP0V2uKKOrRsZ/dVFgcQ04C', '', '', 'freddricktropico14@gmail.com', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rejected_requests`
--

CREATE TABLE `rejected_requests` (
  `borrow_id` int(255) NOT NULL,
  `book_id` int(255) NOT NULL,
  `updated_by` text NOT NULL,
  `student_no` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `book_title` varchar(255) NOT NULL,
  `contact` bigint(255) NOT NULL,
  `preferred_date` date NOT NULL,
  `status` varchar(255) NOT NULL,
  `reason` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rejected_requests`
--

INSERT INTO `rejected_requests` (`borrow_id`, `book_id`, `updated_by`, `student_no`, `email`, `book_title`, `contact`, `preferred_date`, `status`, `reason`) VALUES
(50, 566, '19', 202210330, 'ic.freddrick.tropico@cvsu.edu.ph', 'Romeo and Juliet', 9515254884, '2025-05-19', 'Declined', 'tarantado ka pala eh'),
(51, 580, '19', 202210330, 'ic.freddrick.tropico@cvsu.edu.ph', 'The Strange Case of Dr. Jekyll and Mr. Hyde', 9515254884, '2025-05-20', 'Declined', 'bobo ka siguro');

-- --------------------------------------------------------

--
-- Table structure for table `reservation_history`
--

CREATE TABLE `reservation_history` (
  `reservation_id` int(11) NOT NULL,
  `acc_no` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `reservation_date` date DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `status` enum('Reserved','Cancelled','Expired','Borrowed') NOT NULL,
  `book_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reserved_books`
--

CREATE TABLE `reserved_books` (
  `reserved_id` int(11) NOT NULL,
  `book_title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `reserved_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `acc_no` varchar(50) NOT NULL,
  `book_id` int(11) NOT NULL,
  `student_no` varchar(50) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `ISBN` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reserved_books`
--

INSERT INTO `reserved_books` (`reserved_id`, `book_title`, `author`, `reserved_date`, `acc_no`, `book_id`, `student_no`, `first_name`, `last_name`, `ISBN`, `email`) VALUES
(277, 'Frankenstein; Or, The Modern Prometheus', 'Shelley, Mary Wollstonecraft', '2025-05-06 16:00:00', '67', 562, '202210330', 'FREDDRICK', 'TROPICO', '84', 'ic.freddrick.tropico@cvsu.edu.ph');

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
  `last_logged_in` datetime DEFAULT NULL,
  `verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stud_acc`
--

INSERT INTO `stud_acc` (`acc_no`, `student_no`, `password`, `first_name`, `last_name`, `email`, `contact`, `otp`, `otp_expiry`, `last_logged_in`, `verified`) VALUES
(67, 202210330, '$2y$10$kmDa0R8Yj912FJbi97zj9uAv62CRhdqGYKVm7P26PbmW47.oRF95S', 'FREDDRICK', 'TROPICO', 'ic.freddrick.tropico@cvsu.edu.ph', '09515254884', '', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_archived_books`
--

CREATE TABLE `tbl_archived_books` (
  `book_id` int(255) NOT NULL,
  `book_cover` varchar(255) NOT NULL,
  `book_title` varchar(255) NOT NULL,
  `book_author` varchar(255) NOT NULL,
  `book_description` text NOT NULL,
  `publisher` varchar(255) NOT NULL,
  `publication_date` date NOT NULL,
  `ISBN` int(255) NOT NULL,
  `book_genre` text NOT NULL,
  `book_stocks` int(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_books`
--

CREATE TABLE `tbl_books` (
  `book_id` int(255) NOT NULL,
  `book_cover` varchar(255) DEFAULT NULL,
  `book_title` varchar(255) DEFAULT NULL,
  `book_author` varchar(255) DEFAULT NULL,
  `book_description` text DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `publication_date` date DEFAULT NULL,
  `ISBN` int(255) DEFAULT NULL,
  `book_genre` text DEFAULT NULL,
  `book_stocks` int(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_books`
--

INSERT INTO `tbl_books` (`book_id`, `book_cover`, `book_title`, `book_author`, `book_description`, `publisher`, `publication_date`, `ISBN`, `book_genre`, `book_stocks`, `status`) VALUES
(562, 'https://www.gutenberg.org/cache/epub/84/pg84.cover.medium.jpg', 'Frankenstein; Or, The Modern Prometheus', 'Shelley, Mary Wollstonecraft', 'EN', 'Project Gutenberg', '2025-05-06', 84, 'Frankenstein\'s, Frankenstein,, Gothic, Horror, Monsters, Science, Scientists', 0, 'Available'),
(563, 'https://www.gutenberg.org/cache/epub/2701/pg2701.cover.medium.jpg', 'Moby Dick; Or, The Whale', 'Melville, Herman', 'EN', 'Project Gutenberg', '2025-05-06', 2701, 'Adventure, Ahab,, Mentally, Psychological, Sea, Ship, Whales, Whaling, Whaling', 21, 'Available'),
(564, 'https://www.gutenberg.org/cache/epub/1342/pg1342.cover.medium.jpg', 'Pride and Prejudice', 'Austen, Jane', 'EN', 'Project Gutenberg', '2025-05-06', 1342, 'Courtship, Domestic, England, Love, Sisters, Social, Young', 30, 'Available'),
(565, 'https://www.gutenberg.org/cache/epub/11/pg11.cover.medium.jpg', 'Alice\'s Adventures in Wonderland', 'Carroll, Lewis', 'EN', 'Project Gutenberg', '2025-05-06', 11, 'Alice, Children\'s, Fantasy, Imaginary', 0, 'Available'),
(566, 'https://www.gutenberg.org/cache/epub/1513/pg1513.cover.medium.jpg', 'Romeo and Juliet', 'Shakespeare, William', 'EN', 'Project Gutenberg', '2025-05-06', 1513, 'Conflict, Juliet, Romeo, Tragedies, Vendetta, Verona, Youth', 25, 'Available'),
(567, 'https://www.gutenberg.org/cache/epub/26184/pg26184.cover.medium.jpg', 'Simple Sabotage Field Manual', 'United States. Office of Strategic Services', 'EN', 'Project Gutenberg', '2025-05-06', 26184, 'Sabotage', 29, 'Available'),
(568, 'https://www.gutenberg.org/cache/epub/64317/pg64317.cover.medium.jpg', 'The Great Gatsby', 'Fitzgerald, F. Scott (Francis Scott)', 'EN', 'Project Gutenberg', '2025-05-06', 64317, 'First, Long, Married, Psychological, Rich', 29, 'Available'),
(569, 'https://www.gutenberg.org/cache/epub/2542/pg2542.cover.medium.jpg', 'A Doll\'s House : a play', 'Ibsen, Henrik', 'EN', 'Project Gutenberg', '2025-05-06', 2542, 'Man, Marriage, Norwegian, Wives', 29, 'Available'),
(570, 'https://www.gutenberg.org/cache/epub/844/pg844.cover.medium.jpg', 'The Importance of Being Earnest: A Trivial Comedy for Serious People', 'Wilde, Oscar', 'EN', 'Project Gutenberg', '2025-05-06', 844, 'Comedy, England, Foundlings, Identity', 29, 'Available'),
(571, 'https://www.gutenberg.org/cache/epub/100/pg100.cover.medium.jpg', 'The Complete Works of William Shakespeare', 'Shakespeare, William', 'EN', 'Project Gutenberg', '2025-05-06', 100, 'English', 28, 'Available'),
(572, 'https://www.gutenberg.org/cache/epub/145/pg145.cover.medium.jpg', 'Middlemarch', 'Eliot, George', 'EN', 'Project Gutenberg', '2025-05-06', 145, 'Bildungsromans, City, Didactic, Domestic, England, Love, Married, Young', 30, 'Available'),
(573, 'https://www.gutenberg.org/cache/epub/2641/pg2641.cover.medium.jpg', 'A Room with a View', 'Forster, E. M. (Edward Morgan)', 'EN', 'Project Gutenberg', '2025-05-06', 2641, 'British, England, Florence, Humorous, Young', 29, 'Available'),
(574, 'https://www.gutenberg.org/cache/epub/37106/pg37106.cover.medium.jpg', 'Little Women; Or, Meg, Jo, Beth, and Amy', 'Alcott, Louisa May', 'EN', 'Project Gutenberg', '2025-05-06', 37106, 'Autobiographical, Bildungsromans, Domestic, Family, March, Mothers, New, Sisters, Young', 30, 'Available'),
(575, 'https://www.gutenberg.org/cache/epub/174/pg174.cover.medium.jpg', 'The Picture of Dorian Gray', 'Wilde, Oscar', 'EN', 'Project Gutenberg', '2025-05-06', 174, 'Appearance, Conduct, Didactic, Great, London, Paranormal, Portraits, Supernatural', 29, 'Available'),
(576, 'https://www.gutenberg.org/cache/epub/16389/pg16389.cover.medium.jpg', 'The Enchanted April', 'Von Arnim, Elizabeth', 'EN', 'Project Gutenberg', '2025-05-06', 16389, 'British, Domestic, Female, Italy, Love', 30, 'Available'),
(577, 'https://www.gutenberg.org/cache/epub/67979/pg67979.cover.medium.jpg', 'The Blue Castle: a novel', 'Montgomery, L. M. (Lucy Maud)', 'EN', 'Project Gutenberg', '2025-05-06', 67979, 'Canada, Choice, Love, Romance, Self, Single, Young', 0, 'Available'),
(578, 'https://www.gutenberg.org/cache/epub/345/pg345.cover.medium.jpg', 'Dracula', 'Stoker, Bram', 'EN', 'Project Gutenberg', '2025-05-06', 345, 'Dracula,, Epistolary, Gothic, Horror, Transylvania, Vampires, Whitby', 30, 'Available'),
(579, 'https://www.gutenberg.org/cache/epub/2554/pg2554.cover.medium.jpg', 'Crime and Punishment', 'Dostoyevsky, Fyodor', 'EN', 'Project Gutenberg', '2025-05-06', 2554, 'Crime, Detective, Murder, Psychological, Saint', 29, 'Available'),
(580, 'https://www.gutenberg.org/cache/epub/43/pg43.cover.medium.jpg', 'The Strange Case of Dr. Jekyll and Mr. Hyde', 'Stevenson, Robert Louis', 'EN', 'Project Gutenberg', '2025-05-06', 43, 'Horror, London, Multiple, Physicians, Psychological, Science, Self', 28, 'Available'),
(581, 'https://www.gutenberg.org/cache/epub/394/pg394.cover.medium.jpg', 'Cranford', 'Gaskell, Elizabeth Cleghorn', 'EN', 'Project Gutenberg', '2025-05-06', 394, 'England, Female, Older, Pastoral, Sisters, Villages', 28, 'Available'),
(582, 'https://www.gutenberg.org/cache/epub/2160/pg2160.cover.medium.jpg', 'The Expedition of Humphry Clinker', 'Smollett, T. (Tobias)', 'EN', 'Project Gutenberg', '2025-05-06', 2160, 'Epistolary, Great, Travelers', 30, 'Available'),
(583, 'https://www.gutenberg.org/cache/epub/6761/pg6761.cover.medium.jpg', 'The Adventures of Ferdinand Count Fathom — Complete', 'Smollett, T. (Tobias)', 'EN', 'Project Gutenberg', '2025-05-06', 6761, 'Adventure, Gothic', 30, 'Available'),
(584, 'https://www.gutenberg.org/cache/epub/6593/pg6593.cover.medium.jpg', 'History of Tom Jones, a Foundling', 'Fielding, Henry', 'EN', 'Project Gutenberg', '2025-05-06', 6593, 'Bildungsromans, England, Foundlings, Humorous, Identity, Young', 30, 'Available'),
(585, 'https://www.gutenberg.org/cache/epub/5200/pg5200.cover.medium.jpg', 'Metamorphosis', 'Kafka, Franz', 'EN', 'Project Gutenberg', '2025-05-06', 5200, 'Metamorphosis, Psychological', 30, 'Available'),
(586, 'https://www.gutenberg.org/cache/epub/1259/pg1259.cover.medium.jpg', 'Twenty years after', 'Dumas, Alexandre', 'EN', 'Project Gutenberg', '2025-05-06', 1259, 'France', 30, 'Available'),
(587, 'https://www.gutenberg.org/cache/epub/98/pg98.cover.medium.jpg', 'A Tale of Two Cities', 'Dickens, Charles', 'EN', 'Project Gutenberg', '2025-05-06', 98, 'British, Executions, France, French, Historical, London, Lookalikes, Paris, War', 30, 'Available'),
(588, 'https://www.gutenberg.org/cache/epub/4085/pg4085.cover.medium.jpg', 'The Adventures of Roderick Random', 'Smollett, T. (Tobias)', 'EN', 'Project Gutenberg', '2025-05-06', 4085, 'England, Impressment, Picaresque, Rogues, Sailors, Scots, Sea, Warships', 30, 'Available'),
(589, 'https://www.gutenberg.org/cache/epub/5197/pg5197.cover.medium.jpg', 'My Life — Volume 1', 'Wagner, Richard', 'EN', 'Project Gutenberg', '2025-05-06', 5197, 'Composers, Wagner,', 30, 'Available'),
(590, 'https://www.gutenberg.org/cache/epub/1080/pg1080.cover.medium.jpg', 'A Modest Proposal: For preventing the children of poor people in Ireland, from being a burden on their parents or country, and for making them beneficial to the publick', 'Swift, Jonathan', 'EN', 'Project Gutenberg', '2025-05-06', 1080, 'Ireland, Political, Religious', 30, 'Available'),
(591, 'https://www.gutenberg.org/cache/epub/25344/pg25344.cover.medium.jpg', 'The Scarlet Letter', 'Hawthorne, Nathaniel', 'EN', 'Project Gutenberg', '2025-05-06', 25344, 'Adultery, Boston, Clergy, Historical, Illegitimate, Married, Psychological, Puritans, Revenge, Triangles, Women', 30, 'Available'),
(592, 'https://www.gutenberg.org/cache/epub/1260/pg1260.cover.medium.jpg', 'Jane Eyre: An Autobiography', 'Brontë, Charlotte', 'EN', 'Project Gutenberg', '2025-05-06', 1260, 'Bildungsromans, Charity, Country, England, Fathers, Governesses, Love, Married, Mentally, Orphans, Young', 30, 'Available'),
(593, 'https://www.gutenberg.org/cache/epub/1998/pg1998.cover.medium.jpg', 'Thus Spake Zarathustra: A Book for All and None', 'Nietzsche, Friedrich Wilhelm', 'EN', 'Project Gutenberg', '2025-05-06', 1998, 'Philosophy,, Superman', 30, 'Available');

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
-- Indexes for table `book_likes_dislikes`
--
ALTER TABLE `book_likes_dislikes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_vote` (`acc_no`,`book_id`);

--
-- Indexes for table `book_renewal_history`
--
ALTER TABLE `book_renewal_history`
  ADD PRIMARY KEY (`bookrenewal_id`),
  ADD KEY `acc_no` (`acc_no`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  ADD PRIMARY KEY (`borrow_id`),
  ADD KEY `borrowed_books` (`book_id`);

--
-- Indexes for table `borrowing_history`
--
ALTER TABLE `borrowing_history`
  ADD PRIMARY KEY (`borrowing_id`),
  ADD KEY `acc_no` (`acc_no`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `collection_books`
--
ALTER TABLE `collection_books`
  ADD PRIMARY KEY (`collection_id`),
  ADD KEY `collection_books` (`book_id`);

--
-- Indexes for table `librarian_acc`
--
ALTER TABLE `librarian_acc`
  ADD PRIMARY KEY (`librarian_no`);

--
-- Indexes for table `rejected_requests`
--
ALTER TABLE `rejected_requests`
  ADD KEY `rejected_requests` (`book_id`);

--
-- Indexes for table `reservation_history`
--
ALTER TABLE `reservation_history`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `acc_no` (`acc_no`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `reserved_books`
--
ALTER TABLE `reserved_books`
  ADD PRIMARY KEY (`reserved_id`),
  ADD KEY `reserved_books` (`book_id`);

--
-- Indexes for table `stud_acc`
--
ALTER TABLE `stud_acc`
  ADD PRIMARY KEY (`acc_no`);

--
-- Indexes for table `tbl_archived_books`
--
ALTER TABLE `tbl_archived_books`
  ADD KEY `tbl_archived_books` (`book_id`);

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
  MODIFY `admin_no` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `archived_acc`
--
ALTER TABLE `archived_acc`
  MODIFY `archived_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `book_likes_dislikes`
--
ALTER TABLE `book_likes_dislikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `book_renewal_history`
--
ALTER TABLE `book_renewal_history`
  MODIFY `bookrenewal_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  MODIFY `borrow_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `borrowing_history`
--
ALTER TABLE `borrowing_history`
  MODIFY `borrowing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `collection_books`
--
ALTER TABLE `collection_books`
  MODIFY `collection_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=364;

--
-- AUTO_INCREMENT for table `librarian_acc`
--
ALTER TABLE `librarian_acc`
  MODIFY `librarian_no` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `reservation_history`
--
ALTER TABLE `reservation_history`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT for table `reserved_books`
--
ALTER TABLE `reserved_books`
  MODIFY `reserved_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=278;

--
-- AUTO_INCREMENT for table `stud_acc`
--
ALTER TABLE `stud_acc`
  MODIFY `acc_no` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `tbl_books`
--
ALTER TABLE `tbl_books`
  MODIFY `book_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=594;

--
-- AUTO_INCREMENT for table `tbl_students`
--
ALTER TABLE `tbl_students`
  MODIFY `student_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  ADD CONSTRAINT `borrowed_books` FOREIGN KEY (`book_id`) REFERENCES `tbl_books` (`book_id`) ON DELETE CASCADE;

--
-- Constraints for table `collection_books`
--
ALTER TABLE `collection_books`
  ADD CONSTRAINT `collection_books` FOREIGN KEY (`book_id`) REFERENCES `tbl_books` (`book_id`) ON DELETE CASCADE;

--
-- Constraints for table `rejected_requests`
--
ALTER TABLE `rejected_requests`
  ADD CONSTRAINT `rejected_requests` FOREIGN KEY (`book_id`) REFERENCES `tbl_books` (`book_id`) ON DELETE CASCADE;

--
-- Constraints for table `reserved_books`
--
ALTER TABLE `reserved_books`
  ADD CONSTRAINT `reserved_books` FOREIGN KEY (`book_id`) REFERENCES `tbl_books` (`book_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_archived_books`
--
ALTER TABLE `tbl_archived_books`
  ADD CONSTRAINT `tbl_archived_books` FOREIGN KEY (`book_id`) REFERENCES `tbl_books` (`book_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
