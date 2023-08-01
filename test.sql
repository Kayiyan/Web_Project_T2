-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2023 at 09:50 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `challenges`
--

CREATE TABLE `challenges` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `hint` varchar(255) NOT NULL,
  `challenge_file` varchar(255) NOT NULL,
  `answer_or_message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `challenges`
--

INSERT INTO `challenges` (`id`, `title`, `hint`, `challenge_file`, `answer_or_message`) VALUES
(1, '', 'câu lệnh đầu', 'uploads_challenge/logic.txt', ''),
(2, 'challenge2', 'code mở đầu', 'uploads_challenge/hello.txt', 'hello world'),
(3, 'challenge3', 'câu lệnh điều kiện', 'uploads_challenge/chall3.txt', 'if else');

-- --------------------------------------------------------

--
-- Table structure for table `homeworks`
--

CREATE TABLE `homeworks` (
  `id` int(11) NOT NULL,
  `homework_file` varchar(255) NOT NULL,
  `student_answer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `homeworks`
--

INSERT INTO `homeworks` (`id`, `homework_file`, `student_answer`) VALUES
(1, 'uploads/homework1.txt', 'student_uploads_homeworks/answer3.txt'),
(2, 'uploads/homework1.txt', 'student_uploads_homeworks/answer2.txt'),
(3, 'uploads/homework2.txt', 'student_uploads_homeworks/answer3.txt'),
(4, 'uploads/homework2.txt', NULL),
(5, 'uploads/homework1.txt', NULL),
(6, 'uploads/homework2.txt', NULL),
(7, 'uploads/homework3.txt', NULL),
(8, 'uploads/homework3.txt', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `homework_submit`
--

CREATE TABLE `homework_submit` (
  `id` int(11) NOT NULL,
  `homework_id` int(11) NOT NULL,
  `student_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `homework_submit`
--

INSERT INTO `homework_submit` (`id`, `homework_id`, `student_name`) VALUES
(1, 1, 'Kim Giang'),
(2, 3, 'Đức Văn');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `type`, `username`, `password`) VALUES
(1, 'teacher', 'admin', 'admin'),
(2, 'student', 'kimgiang', 'kimgiang123'),
(3, 'student', 'ducvan', 'ducvan123'),
(4, 'student', 'tuananh', 'tuananh123'),
(6, 'student', 'Kayiyan', '213123123'),
(7, 'student', 'test', 'test'),
(8, 'student', 'test', 'test'),
(9, 'student', 'test', 'test'),
(10, 'student', 'test', 'test'),
(11, 'student', 'test', 'test'),
(12, 'student', 'test', 'test'),
(13, 'student', 'test', 'test'),
(14, 'student', 'test', 'test'),
(15, 'student', 'test', 'test'),
(16, 'student', 'test', 'test'),
(17, 'student', 'test', 'test'),
(18, 'student', 'test', 'test'),
(19, 'student', 'test', 'test'),
(20, 'student', 'test', 'test'),
(21, 'student', 'test', 'test'),
(22, 'student', 'test', 'test'),
(23, 'student', 'test', 'test'),
(24, 'student', 'test', 'test'),
(25, 'student', 'test', 'test'),
(26, 'student', 'test', 'test'),
(27, 'student', 'test', 'test'),
(28, 'student', 'test', 'test'),
(29, 'student', 'test', 'test'),
(30, 'student', 'test', 'test'),
(31, 'student', 'khanhhoang', 'khanh123'),
(32, 'student', 'Kanzizi', 'khanh123123');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `username`, `password`, `name`, `email`, `phone_number`, `teacher_id`) VALUES
(2, 'kimgiang', 'kimgiang123', 'Kim Giang', 'kimgiang@gmail.com', '09990892', 1),
(3, 'ducvan', 'ducvan123', 'Đức Văn', 'ducvan@mail.com', '09828111213', 1),
(4, 'tuananh', 'tuananh123', 'Tuấn Anh', 'tuananh@gmail.com', '098786671', 1),
(30, 'khanhhoang', 'khanh123', 'khánh', 'khanh@gmail.com', '0009987790', 1),
(31, 'Kanzizi', 'khanh123123', 'khánh hoàng', 'khanhhoang@gmail.com', '09888770012', 1);

-- --------------------------------------------------------

--
-- Table structure for table `student_submit`
--

CREATE TABLE `student_submit` (
  `id` int(11) NOT NULL,
  `student_name` varchar(255) DEFAULT NULL,
  `challenge_id` int(11) DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_submit`
--

INSERT INTO `student_submit` (`id`, `student_name`, `challenge_id`, `is_correct`) VALUES
(1, 'Kim Giang', 3, 1),
(2, 'Đức Văn', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gmail` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`id`, `username`, `password`, `gmail`) VALUES
(1, 'admin', 'admin', 'khanh@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `challenges`
--
ALTER TABLE `challenges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homeworks`
--
ALTER TABLE `homeworks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homework_submit`
--
ALTER TABLE `homework_submit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `homework_id` (`homework_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_teacher` (`teacher_id`);

--
-- Indexes for table `student_submit`
--
ALTER TABLE `student_submit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `challenge_id` (`challenge_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `challenges`
--
ALTER TABLE `challenges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `homeworks`
--
ALTER TABLE `homeworks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `homework_submit`
--
ALTER TABLE `homework_submit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `student_submit`
--
ALTER TABLE `student_submit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `homework_submit`
--
ALTER TABLE `homework_submit`
  ADD CONSTRAINT `homework_submit_ibfk_1` FOREIGN KEY (`homework_id`) REFERENCES `homeworks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `fk_student_role` FOREIGN KEY (`id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `fk_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`id`);

--
-- Constraints for table `student_submit`
--
ALTER TABLE `student_submit`
  ADD CONSTRAINT `student_submit_ibfk_1` FOREIGN KEY (`challenge_id`) REFERENCES `challenges` (`id`);

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `fk_teacher_role` FOREIGN KEY (`id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
