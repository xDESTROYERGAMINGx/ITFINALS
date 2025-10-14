-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2025 at 08:54 AM
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
-- Database: `grading_system`
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
  `faculty_id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `id_number` varchar(20) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone_number` varchar(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`faculty_id`, `first_name`, `last_name`, `id_number`, `password`, `gender`, `email`, `phone_number`, `created_at`) VALUES
(2, 'Elizabeth', 'Rebonza', 'CF-102532', '$2y$10$tq9Cd2ltNJ4gcHelUvwCvOR9n0yKk9wNHvWbqKxrTOzzh6HOTj2TS', 'Female', 'elizabethrebonza@gmail.com', '0966356587', '2025-10-12 02:29:59'),
(3, 'Joshua', 'Atis', 'CF-102420', '$2y$10$F8MBTptkXhU98otOM9EspumsOB.El2C9tlDsBn6Hou.caW1sNwYyu', 'Male', 'joshuaAtis@gmail.com', '0952648976', '2025-10-12 03:43:27'),
(5, 'Calvin Joshua', 'Kiunisala', 'CF-102418', '$2y$10$BU1RVucUHBjaCtIi2IZiB.dC3ZtxFi8LHEiqjkRyx.OGCeCqDT5Ye', 'Male', 'calvin@gmail.com', '0963548975', '2025-10-12 04:28:00');

-- --------------------------------------------------------

--
-- Table structure for table `grading`
--

CREATE TABLE `grading` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `prelim` varchar(10) DEFAULT NULL,
  `midterm` varchar(10) DEFAULT NULL,
  `finals` varchar(10) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grading`
--

INSERT INTO `grading` (`id`, `subject_id`, `student_id`, `prelim`, `midterm`, `finals`, `status`) VALUES
(25, 4, 2, '90', '90', '91', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reject_archive`
--

CREATE TABLE `reject_archive` (
  `id` int(11) NOT NULL,
  `id_number` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `origin` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reject_archive`
--

INSERT INTO `reject_archive` (`id`, `id_number`, `subject_id`, `origin`, `created_at`) VALUES
(1, 2, 3, 'student', '2025-10-14 05:24:49');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `id_number` varchar(20) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `year_level` varchar(20) NOT NULL,
  `mobile_number` varchar(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `id_number`, `first_name`, `last_name`, `gender`, `year_level`, `mobile_number`, `email`, `password`) VALUES
(1, 'C23-0139', 'Elizabeth', 'Rebonza', 'Female', '3rd Year', '09635689745', 'elizabeth@gmail.com', '123'),
(2, 'C23-0149', 'Cris Martin ', 'Tirariray', 'Male', '1st Year', '09897856328', 'martin@gmail.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `student_subject`
--

CREATE TABLE `student_subject` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_subject`
--

INSERT INTO `student_subject` (`id`, `student_id`, `subject_id`, `status`, `created_at`) VALUES
(16, 2, 4, 'approved', '2025-10-14 04:46:24');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(11) NOT NULL,
  `subject_code` varchar(20) NOT NULL,
  `subject_name` varchar(255) NOT NULL,
  `year_level` varchar(100) NOT NULL,
  `semester` varchar(100) NOT NULL,
  `credit_units` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `subject_code`, `subject_name`, `year_level`, `semester`, `credit_units`) VALUES
(1, 'IT101', 'Computer Programming 1', '1st Year', '1st Semester', 3),
(2, 'IT303', 'Networking 2', '3rd Year', '1st Semester', 3),
(3, 'IT201', 'Networking 1', '1st Year', '1st Semester', 3),
(4, 'IT305', 'Data Warehousing', '3rd Year', '1st Semester', 2);

-- --------------------------------------------------------

--
-- Table structure for table `subject_allocations`
--

CREATE TABLE `subject_allocations` (
  `id` int(11) NOT NULL,
  `subject_id` varchar(20) NOT NULL,
  `faculty_id` varchar(20) NOT NULL,
  `status` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject_allocations`
--

INSERT INTO `subject_allocations` (`id`, `subject_id`, `faculty_id`, `status`, `created_at`) VALUES
(4, '3', '3', 'Approved', '2025-10-12 04:10:36'),
(5, '1', '3', 'Approved', '2025-10-12 04:30:27'),
(6, '4', '3', 'Approved', '2025-10-13 18:31:01');

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
  ADD PRIMARY KEY (`faculty_id`);

--
-- Indexes for table `grading`
--
ALTER TABLE `grading`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `reject_archive`
--
ALTER TABLE `reject_archive`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `subject_allocations`
--
ALTER TABLE `subject_allocations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id` (`faculty_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `grading`
--
ALTER TABLE `grading`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `reject_archive`
--
ALTER TABLE `reject_archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student_subject`
--
ALTER TABLE `student_subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `subject_allocations`
--
ALTER TABLE `subject_allocations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grading`
--
ALTER TABLE `grading`
  ADD CONSTRAINT `grading_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `grading_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`);

--
-- Constraints for table `student_subject`
--
ALTER TABLE `student_subject`
  ADD CONSTRAINT `student_subject_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `student_subject_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
