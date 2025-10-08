-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2025 at 03:36 PM
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
-- Database: `faculty_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone_number` int(11) NOT NULL,
  `id_number` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`first_name`, `last_name`, `password`, `gender`, `email`, `phone_number`, `id_number`, `created_at`) VALUES
('long', 'rams', '$2y$10$gy7', 'Male', 'long@gmail.com', 0, 'c23-0001', '2025-10-04 14:44:05'),
('q', 'w', '$2y$10$6FF', 'Male', 'qw@gmail.com', 0, 'c23-0002', '2025-10-04 15:57:22'),
('Joshua', 'Atis', '$2y$10$rS2L3fFrwxGzMcy3f5mgEe69VTbXaYHtT1ad.zXnzA0eKM1uNxEMW', 'Male', 'joshuaAtis@gmail.com', 952648975, 'C23-0033', '2025-10-05 11:46:39'),
('Calvin Joshua', 'asdasd', '$2y$10$mv8', 'Male', 'calvinkiunisala07@gmail.com', 0, 'c23-3434', '2025-10-04 08:57:29'),
('janna', 'ocliaman', '$2y$10$oL1', 'Male', 'calvinkiunisala@gmail.com', 0, 'c23-3435', '2025-10-04 09:05:48'),
('joshua', 'kiunisala', '$2y$10$LPj', 'Male', 'suzette@gmail.com', 0, 'c23-3436', '2025-10-04 08:58:24'),
('jerccho', 'asdasd', '$2y$10$pJb', 'Male', 'calvinkiunisala3@gmail', 0, 'c23-3437', '2025-10-04 11:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_subject`
--

CREATE TABLE `faculty_subject` (
  `id` int(11) NOT NULL,
  `faculty_id` varchar(10) NOT NULL,
  `subject_id` varchar(10) NOT NULL,
  `semester` varchar(100) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_subject`
--

INSERT INTO `faculty_subject` (`id`, `faculty_id`, `subject_id`, `semester`, `status`) VALUES
(30, 'C23-0033', 'IT101', 'First Semester', 1),
(31, 'C23-0033', 'IT303', 'first semester', 1),
(33, 'C23-0033', 'IT305', 'First Semester', 0);

-- --------------------------------------------------------

--
-- Table structure for table `grading`
--

CREATE TABLE `grading` (
  `id` int(11) NOT NULL,
  `subject_id` varchar(10) NOT NULL,
  `student_id` varchar(10) NOT NULL,
  `prelim` varchar(10) DEFAULT NULL,
  `midterm` varchar(10) DEFAULT NULL,
  `finals` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grading`
--

INSERT INTO `grading` (`id`, `subject_id`, `student_id`, `prelim`, `midterm`, `finals`) VALUES
(15, 'IT101', 'C23-0139', '90', '92', '—'),
(16, 'IT303', 'C23-0139', '94', '—', '—');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` varchar(10) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `year_level` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `first_name`, `last_name`, `year_level`) VALUES
('C23-0139', 'Elizabeth', 'Rebonza', '3rd Year'),
('C23-0149', 'Cris Martin ', 'Tirariray', '1st Year');

-- --------------------------------------------------------

--
-- Table structure for table `student_subject`
--

CREATE TABLE `student_subject` (
  `id` int(11) NOT NULL,
  `student_id` varchar(10) NOT NULL,
  `subject_id` varchar(10) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_subject`
--

INSERT INTO `student_subject` (`id`, `student_id`, `subject_id`, `status`) VALUES
(7, 'C23-0139', 'IT303', 0),
(8, 'C23-0139', 'IT101', 1),
(9, 'C23-0149', 'IT303', 1);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `code` varchar(10) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Units` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`code`, `Description`, `Units`) VALUES
('IT101', 'Computer Programming', 3),
('IT303', 'Networking', 3),
('IT305', 'Data Warehousing', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `role`, `username`, `password`) VALUES
('C23-0033', 'Joshua Atis', 'faculty', 'jAtis', 'j123'),
('C23-0126', 'George Aim Acodili', 'student', 'geo', '123'),
('C23-0131', 'Elizabeth Rebonza', 'student', '', ''),
('C23-0139', 'Cris Martin Tirariray', 'student', '', ''),
('C23-0149', 'Hannah Jansien Caday', 'faculty', 'hannah', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id_number`);

--
-- Indexes for table `faculty_subject`
--
ALTER TABLE `faculty_subject`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `faculty_subject_ibfk_1` (`faculty_id`);

--
-- Indexes for table `grading`
--
ALTER TABLE `grading`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `student_subject`
--
ALTER TABLE `student_subject`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `student_subject_ibfk_1` (`student_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `faculty_subject`
--
ALTER TABLE `faculty_subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `grading`
--
ALTER TABLE `grading`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `student_subject`
--
ALTER TABLE `student_subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `faculty_subject`
--
ALTER TABLE `faculty_subject`
  ADD CONSTRAINT `faculty_subject_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`id_number`),
  ADD CONSTRAINT `faculty_subject_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`code`);

--
-- Constraints for table `student_subject`
--
ALTER TABLE `student_subject`
  ADD CONSTRAINT `student_subject_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `student_subject_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
