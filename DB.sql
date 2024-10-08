-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2022 at 11:53 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dxnln`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `user_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `is_right` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `answer`, `is_right`) VALUES
(35, 29, 'true', 2),
(36, 29, 'false', 1),
(37, 29, 'true', 2);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lecture_id` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `up_comment` int(11) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `is_enable` tinyint(1) NOT NULL DEFAULT 1,
  `date` datetime DEFAULT current_timestamp(),
  `parent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `is_enable`, `date`, `parent`) VALUES
(6, 'firest', 'one', 2, '2022-01-08 18:45:35', NULL),
(9, 'second', 'testing course', 2, '2022-01-27 20:03:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `exam_percent` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `title`, `description`, `exam_percent`, `date`) VALUES
(10, 'exam', 'fireast exam', 20, '2022-01-08');

-- --------------------------------------------------------

--
-- Table structure for table `exams_answers`
--

CREATE TABLE `exams_answers` (
  `id` int(11) NOT NULL,
  `exam_take` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `right` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `exam_take`
--

CREATE TABLE `exam_take` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `path_id` int(11) DEFAULT NULL,
  `icon` int(11) NOT NULL DEFAULT 1,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `teacher_id`, `path_id`, `icon`, `name`, `description`) VALUES
(1, 2, 1, 1, 'First Group', 'هذة المجموعة خاصة لطلاب المبيعات ولا تشمل التسويق عامة'),
(11, 2, 1, 1, 'bbb', 'this is a testing group'),
(12, 2, 2, 1, 'ccc', 'this is a testing group');

-- --------------------------------------------------------

--
-- Table structure for table `icons`
--

CREATE TABLE `icons` (
  `id` int(11) NOT NULL,
  `icon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `icons`
--

INSERT INTO `icons` (`id`, `icon`) VALUES
(1, '1.png'),
(2, '10.png'),
(3, '11.png'),
(4, '12.png'),
(5, '13.png'),
(6, '14.png'),
(7, '15.png'),
(8, '16.png'),
(9, '17.png'),
(10, '18.png'),
(11, '19.png'),
(12, '2.png'),
(13, '20.png'),
(14, '21.png'),
(15, '22.png'),
(16, '23.png'),
(17, '24.png'),
(18, '25.png'),
(19, '26.png'),
(20, '27.png'),
(21, '28.png'),
(22, '29.png'),
(23, '3.png'),
(24, '30.png'),
(25, '31.png'),
(26, '32.png'),
(27, '33.png'),
(28, '34.png'),
(29, '35.png'),
(30, '36.png'),
(31, '37.png'),
(32, '38.png'),
(33, '39.png'),
(34, '4.png'),
(35, '40.png'),
(36, '41.png'),
(37, '42.png'),
(38, '43.png'),
(39, '44.png'),
(40, '45.png'),
(41, '46.png'),
(42, '47.png'),
(43, '48.png'),
(44, '49.png'),
(45, '5.png'),
(46, '50.png'),
(47, '51.png'),
(48, '52.png'),
(49, '53.png'),
(50, '54.png'),
(51, '55.png'),
(52, '56.png'),
(53, '57.png'),
(54, '58.png'),
(55, '6.png'),
(56, '7.png'),
(57, '8.png'),
(58, '9.png');

-- --------------------------------------------------------

--
-- Table structure for table `items_order`
--

CREATE TABLE `items_order` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_type` tinyint(4) NOT NULL,
  `order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items_order`
--

INSERT INTO `items_order` (`id`, `course_id`, `item_id`, `item_type`, `order`) VALUES
(36, 6, 31, 1, 1),
(37, 6, 10, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `lectures`
--

CREATE TABLE `lectures` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lectures`
--

INSERT INTO `lectures` (`id`, `title`, `description`, `video`, `thumbnail`, `date`) VALUES
(31, 'lecture', 'firest lecture', 'InT9PtzlREV.mp4', 'B4dTsSBPbSx.jpg', '2022-01-08');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `meta` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `components` tinyint(4) NOT NULL DEFAULT 1,
  `arguments` tinyint(4) NOT NULL DEFAULT 0,
  `file` varchar(255) NOT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `mini_description` text DEFAULT NULL,
  `featured_img` varchar(255) DEFAULT NULL,
  `language` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `title`, `meta`, `type`, `components`, `arguments`, `file`, `thumb`, `description`, `mini_description`, `featured_img`, `language`) VALUES
(1, 'course-add', 'Create Course', NULL, 'manage', 1, 0, 'course-create.php', NULL, NULL, NULL, NULL, 'ar'),
(2, 'error', 'Error', NULL, 'main', 1, 0, 'error.php', NULL, NULL, NULL, NULL, 'ar'),
(3, 'user-create', 'Create User', NULL, 'manage', 1, 0, 'user-create.php', NULL, NULL, NULL, NULL, 'ar'),
(4, 'home', 'Home', NULL, 'main', 1, 0, 'home.php', NULL, NULL, NULL, NULL, 'ar'),
(5, 'login', 'Login', NULL, 'main', 2, 0, 'login.php', NULL, NULL, NULL, NULL, 'ar'),
(6, 'login-teacher', 'Teacher Login', NULL, 'main', 2, 0, 'login-teacher.php', NULL, NULL, NULL, NULL, 'ar'),
(7, 'login-admin', 'Admin Login', NULL, 'main', 2, 0, 'login-admin.php', NULL, NULL, NULL, NULL, 'ar'),
(8, 'logout', 'Logout', NULL, 'only-file', 1, 0, 'logout.php', NULL, NULL, NULL, NULL, 'ar'),
(9, 'exam-manage', 'Manage Exam', NULL, 'manage', 1, 2, 'exam-manage.php', NULL, NULL, NULL, NULL, 'ar'),
(10, 'exam-add', 'Add Exam', NULL, 'manage', 1, 0, 'exam-create.php', NULL, NULL, NULL, NULL, 'ar'),
(11, 'lecture-add', 'Add Lecture', NULL, 'manage', 1, 1, 'lecture-create.php', NULL, NULL, NULL, NULL, 'ar'),
(12, 'lecture-manage', 'Manage LActure', NULL, 'manage', 1, 1, 'lecture-manage.php', NULL, NULL, NULL, NULL, 'ar'),
(13, 'dashboard-admin', 'Admin Dashboard', NULL, 'admin', 1, 0, 'dashboard-admin.php', NULL, NULL, NULL, NULL, 'ar'),
(14, 'dashboard-student', 'Student Dashboard', NULL, 'student', 1, 0, 'dashboard-student.php', NULL, NULL, NULL, NULL, 'ar'),
(15, 'dashboard-teacher', 'Teacher Dashboard', NULL, 'teacher', 1, 0, 'dashboard-teacher.php', NULL, NULL, NULL, NULL, 'ar'),
(16, 'item-delete', 'Delete Item', NULL, 'manage', 1, 2, 'item-delete.php', NULL, NULL, NULL, NULL, 'ar'),
(19, 'view', 'View Item', NULL, 'login', 1, 2, 'view.php', NULL, NULL, NULL, NULL, 'ar'),
(21, 'lecture-done', 'finish lecture', NULL, 'only-file', 3, 0, 'lecture-done.php', NULL, NULL, NULL, NULL, 'ar'),
(22, 'exam-result', 'show exam result', NULL, 'login', 1, 0, 'exam-result.php', NULL, NULL, NULL, NULL, 'ar'),
(23, 'course', 'show course', NULL, 'login', 1, 1, 'course-show.php', NULL, NULL, NULL, NULL, 'ar'),
(24, 'manage-course', 'Manage Courses', NULL, 'manage', 1, 0, 'manage-course.php', NULL, NULL, NULL, NULL, 'ar'),
(25, 'manage-groups', '', NULL, 'manage', 1, 0, 'groups-manage.php', NULL, NULL, NULL, NULL, 'ar'),
(26, 'exam-proces', 'calculation', NULL, NULL, 3, 0, 'exam-proces.php', NULL, NULL, NULL, NULL, 'ar'),
(27, 'course-delete', 'course-delete', NULL, NULL, 1, 1, 'course-delete.php', NULL, NULL, NULL, NULL, 'ar'),
(29, 'exam-done', '', NULL, NULL, 3, 0, 'exam-done.php', NULL, NULL, NULL, NULL, 'ar'),
(30, 'group-add-prc', '', NULL, 'manage', 1, 0, 'group-add-prc.php', NULL, NULL, NULL, NULL, 'ar'),
(31, 'add-group', '', NULL, 'manage', 1, 0, 'group-add-view.php', NULL, NULL, NULL, NULL, 'ar'),
(33, 'group-delete', '', NULL, NULL, 2, 1, 'group-delete.php', NULL, NULL, NULL, NULL, 'ar'),
(34, 'group-members', 'members of group', NULL, NULL, 1, 0, 'group-members.php', NULL, NULL, NULL, NULL, 'ar'),
(35, 'delete-group', '', NULL, NULL, 1, 0, 'group-delete.php', NULL, NULL, NULL, NULL, 'ar'),
(36, 'manage-group', 'manage group', NULL, NULL, 1, 1, 'group-manage.php', NULL, NULL, NULL, NULL, 'ar'),
(37, 'group-edit-prc', '', NULL, 'manage', 2, 1, 'group-edit-prc.php', NULL, NULL, NULL, NULL, 'ar');

-- --------------------------------------------------------

--
-- Table structure for table `paths`
--

CREATE TABLE `paths` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `last_modification` date NOT NULL DEFAULT current_timestamp(),
  `is_main` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `paths`
--

INSERT INTO `paths` (`id`, `teacher_id`, `name`, `last_modification`, `is_main`) VALUES
(1, 2, 'Main Path', '2021-11-02', 1),
(2, 2, 'Second Path', '2021-11-02', 0);

-- --------------------------------------------------------

--
-- Table structure for table `paths_courses`
--

CREATE TABLE `paths_courses` (
  `id` int(11) NOT NULL,
  `path_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `paths_courses`
--

INSERT INTO `paths_courses` (`id`, `path_id`, `course_id`, `order`) VALUES
(7, 1, 6, 1),
(8, 1, 9, 2);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `value` varchar(8) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `value`, `name`, `note`) VALUES
(1, '11111', 'owner', 'course maker'),
(2, '01111', 'full-editor', 'can create, update, delete'),
(3, '00110', 'editor', 'can update, delete'),
(4, '00010', 'remover', 'can just remove'),
(5, '00100', 'updater', 'can just update'),
(6, '01000', 'maker', 'can just create'),
(7, '01100', 'maker-assistant', 'can create, update'),
(9, '00001', 'priority changer', 'can just add to his own priority list');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `important` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `multible_option` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `exam_id`, `question`, `important`, `order`, `multible_option`) VALUES
(29, 10, 'firest question', 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`) VALUES
(1, 2),
(2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `students_groups`
--

CREATE TABLE `students_groups` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `students_groups`
--

INSERT INTO `students_groups` (`id`, `student_id`, `group_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `student_pass`
--

CREATE TABLE `student_pass` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `item_order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student_pass`
--

INSERT INTO `student_pass` (`id`, `student_id`, `item_order_id`) VALUES
(25, 1, 36),
(26, 1, 37);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `user_id`) VALUES
(2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `teachers_courses`
--

CREATE TABLE `teachers_courses` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `permission_giver` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teachers_courses`
--

INSERT INTO `teachers_courses` (`id`, `course_id`, `teacher_id`, `permission_id`, `permission_giver`) VALUES
(11, 6, 2, 1, 2),
(14, 9, 2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `dxnid` varchar(255) NOT NULL,
  `dxn_upline` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `job` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `gander` tinyint(1) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `registerdate` date NOT NULL DEFAULT current_timestamp(),
  `thumbimage` varchar(255) DEFAULT 'default_user.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `dxnid`, `dxn_upline`, `password`, `email`, `mobile`, `country`, `birthdate`, `job`, `address`, `gander`, `image`, `registerdate`, `thumbimage`) VALUES
(1, 'admin', 'admin admin', '111', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'admin@info.com', '12345678910', 'istanbul', '2000-10-09', 'designer', 'i told you \" istanbul\"', 1, NULL, '2021-04-13', 'default_user.jpg'),
(2, 'student', 'student', '333', '222', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'student@test.test', '123456789', NULL, '2021-05-10', NULL, NULL, 1, NULL, '2021-05-10', 'default_user.jpg'),
(3, 'teacher', 'teacher teacher', '222', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'teacher@test.test', '123456789', NULL, NULL, NULL, NULL, 1, NULL, '2021-05-10', 'default_user.jpg'),
(4, 'student 2', 'student 2  student 2 ', '444', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'student2@gmail.com', '09876658123', 'istanbul', NULL, 'student', 'moon, 13 streat, third way at the right', 1, NULL, '2021-07-07', 'default_user.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question` (`question_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lecture_comment` (`lecture_id`),
  ADD KEY `user_comment` (`user_id`),
  ADD KEY `comment_comment` (`up_comment`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exams_answers`
--
ALTER TABLE `exams_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_take_id` (`exam_take`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `exam_take`
--
ALTER TABLE `exam_take`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student` (`student_id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher` (`teacher_id`),
  ADD KEY `path_id` (`path_id`),
  ADD KEY `icon` (`icon`);

--
-- Indexes for table `icons`
--
ALTER TABLE `icons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `icon` (`icon`);

--
-- Indexes for table `items_order`
--
ALTER TABLE `items_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `items_order_courses` (`course_id`);

--
-- Indexes for table `lectures`
--
ALTER TABLE `lectures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paths`
--
ALTER TABLE `paths`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teachers_paths` (`teacher_id`);

--
-- Indexes for table `paths_courses`
--
ALTER TABLE `paths_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paths` (`path_id`),
  ADD KEY `course_studentpaths` (`course_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam` (`exam_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `students_groups`
--
ALTER TABLE `students_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groups_students` (`student_id`),
  ADD KEY `groups_groups` (`group_id`);

--
-- Indexes for table `student_pass`
--
ALTER TABLE `student_pass`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `item_order` (`item_order_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `teachers_courses`
--
ALTER TABLE `teachers_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teachers` (`teacher_id`),
  ADD KEY `courses` (`course_id`),
  ADD KEY `permmision` (`permission_id`),
  ADD KEY `permission_giver` (`permission_giver`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dxnid` (`dxnid`),
  ADD KEY `teacher_up_line` (`dxn_upline`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `exams_answers`
--
ALTER TABLE `exams_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `exam_take`
--
ALTER TABLE `exam_take`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `icons`
--
ALTER TABLE `icons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `items_order`
--
ALTER TABLE `items_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `lectures`
--
ALTER TABLE `lectures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `paths`
--
ALTER TABLE `paths`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `paths_courses`
--
ALTER TABLE `paths_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students_groups`
--
ALTER TABLE `students_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student_pass`
--
ALTER TABLE `student_pass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `teachers_courses`
--
ALTER TABLE `teachers_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admin_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `question` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_comment` FOREIGN KEY (`up_comment`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lecture_comment` FOREIGN KEY (`lecture_id`) REFERENCES `lectures` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_comment` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exams_answers`
--
ALTER TABLE `exams_answers`
  ADD CONSTRAINT `exam_take_id` FOREIGN KEY (`exam_take`) REFERENCES `exam_take` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `question_id` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exam_take`
--
ALTER TABLE `exam_take`
  ADD CONSTRAINT `exam_id` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `icon` FOREIGN KEY (`icon`) REFERENCES `icons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `path_id` FOREIGN KEY (`path_id`) REFERENCES `paths` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teacher` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items_order`
--
ALTER TABLE `items_order`
  ADD CONSTRAINT `items_order_courses` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `paths`
--
ALTER TABLE `paths`
  ADD CONSTRAINT `teachers_paths` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `paths_courses`
--
ALTER TABLE `paths_courses`
  ADD CONSTRAINT `course_studentpaths` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `paths` FOREIGN KEY (`path_id`) REFERENCES `paths` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `exam` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students_groups`
--
ALTER TABLE `students_groups`
  ADD CONSTRAINT `groups_groups` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `groups_students` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_pass`
--
ALTER TABLE `student_pass`
  ADD CONSTRAINT `item_order` FOREIGN KEY (`item_order_id`) REFERENCES `items_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_id` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teacher_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teachers_courses`
--
ALTER TABLE `teachers_courses`
  ADD CONSTRAINT `courses` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_giver` FOREIGN KEY (`permission_giver`) REFERENCES `teachers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teachers` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `teacher_up_line` FOREIGN KEY (`dxn_upline`) REFERENCES `users` (`dxnid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
