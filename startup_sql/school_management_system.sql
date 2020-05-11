--
-- Database: `school_management_system`
--

CREATE DATABASE school_management_system;
USE school_management_system;

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `allow_password_change` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `class` tinyint(4) NOT NULL,
  `class_section` varchar(2) DEFAULT NULL,
  `class_teacher_id` int(11) DEFAULT NULL UNIQUE,
  CONSTRAINT `cl_cl_lab` UNIQUE (`class`,`class_section`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `grade` tinyint(4) NOT NULL,
  `grade_label` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `session_grades`
--

CREATE TABLE `session_grades` (
  `student_egn` varchar(10) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `for_class` tinyint(2) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `class_teacher_id` int(11) NOT NULL,
  CONSTRAINT `egn_subj_class` UNIQUE (`student_egn`,`subject_id`,`for_class`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `egn` varchar(10) NOT NULL UNIQUE,
  `first_name` varchar(50) NOT NULL,
  `second_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `class_no` tinyint(4) NOT NULL,
  `class_id` int(11) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `username` varchar(50) NOT NULL UNIQUE,
  `password` varchar(50) NOT NULL,
  `role_id` int(11) NOT NULL,
  CONSTRAINT `cl_no_cl_id` UNIQUE (`class_no`,`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL UNIQUE,
  `password` varchar(50) NOT NULL,
  `role_id` int(11) NOT NULL,
  CONSTRAINT `teach_fn_ln` UNIQUE (`first_name`,`last_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teachers_subjects`
--

CREATE TABLE `teachers_subjects` (
  `teacher_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  CONSTRAINT `teach_subj` UNIQUE (`teacher_id`,`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class_teachers`
--

CREATE TABLE `class_teachers` (
  `class_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  CONSTRAINT `teach_subj` UNIQUE (`class_id`,`teacher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `id` int(11) NOT NULL,
  `term` tinyint(4) NOT NULL,
  `term_label` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `current_grades`
--

CREATE TABLE `current_grades` (
  `student_egn` varchar(10) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `for_class` tinyint(2) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `term_grades`
--

CREATE TABLE `term_grades` (
  `student_egn` varchar(10) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `for_class` tinyint(2) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  CONSTRAINT `gr_subj_term` UNIQUE (`student_egn`,`subject_id`,`term_id`, `for_class`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `school_session`
--

CREATE TABLE `school_session` (
  `term_id` int(11) NOT NULL,
  `now` tinyint(1) NOT NULL CHECK (`term_now` IN (0, 1))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE `school` (
  `id` int(11) NOT NULL,
  `name` varchar(100),
  `description` varchar(500)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role` (`role_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);
  
--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `session_grades`
--
ALTER TABLE `session_grades`
  ADD KEY `student_egn` (`student_egn`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `grade_id` (`grade_id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `class_teacher_id` (`class_teacher_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`egn`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `teachers_subjects`
--
ALTER TABLE `teachers_subjects`
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `subject_id` (`subject_id`);
  
--
-- Indexes for table `class_teachers`
--
ALTER TABLE `class_teachers`
  ADD KEY `class_id` (`class_id`),
  ADD KEY `teacher_id` (`teacher_id`);
  
--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`);
  
--
-- Indexes for table `current_grades`
--
ALTER TABLE `current_grades`
  ADD KEY `student_egn` (`student_egn`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `grade_id` (`grade_id`),
  ADD KEY `term_id` (`term_id`),
  ADD KEY `teacher_id` (`teacher_id`);
  
--
-- Indexes for table `term_grades`
--
ALTER TABLE `term_grades`
  ADD KEY `student_egn` (`student_egn`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `term_id` (`term_id`),
  ADD KEY `grade_id` (`grade_id`),
  ADD KEY `teacher_id` (`teacher_id`);
  
--
-- Indexes for table `school_session`
--
ALTER TABLE `school_session`
  ADD KEY `term_id` (`term_id`);

--
-- Indexes for table `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`id`);  

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
  
--
-- AUTO_INCREMENT for table `school`
--
ALTER TABLE `school`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
  
--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrator`
--
ALTER TABLE `administrator`
  ADD CONSTRAINT `administrator_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`class_teacher_id`) REFERENCES `teachers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `session_grades`
--
ALTER TABLE `session_grades`
  ADD CONSTRAINT `session_grades_ibfk_1` FOREIGN KEY (`student_egn`) REFERENCES `students` (`egn`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `session_grades_ibfk_4` FOREIGN KEY (`grade_id`) REFERENCES `grades` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `session_grades_ibfk_5` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `session_grades_ibfk_6` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `session_grades_ibfk_7` FOREIGN KEY (`class_teacher_id`) REFERENCES `classes` (`class_teacher_id`) ON UPDATE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `teachers_subjects`
--
ALTER TABLE `teachers_subjects`
  ADD CONSTRAINT `teachers_subjects_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teachers_subjects_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
--
-- Constraints for table `class_teachers`
--
ALTER TABLE `class_teachers`
  ADD CONSTRAINT `class_teachers_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `class_teachers_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;  

--
-- Constraints for table `current_grades`
--
ALTER TABLE `current_grades`
  ADD CONSTRAINT `current_grades_ibfk_1` FOREIGN KEY (`student_egn`) REFERENCES students (`egn`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `current_grades_ibfk_4` FOREIGN KEY (`grade_id`) REFERENCES grades (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `current_grades_ibfk_5` FOREIGN KEY (`term_id`) REFERENCES terms (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `current_grades_ibfk_6` FOREIGN KEY (`subject_id`) REFERENCES subjects (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `current_grades_ibfk_7` FOREIGN KEY (`teacher_id`) REFERENCES teachers (`id`) ON UPDATE CASCADE;
  
--
-- Constraints for table `term_grades`
--
ALTER TABLE `term_grades`
  ADD CONSTRAINT `term_grades_ibfk_1` FOREIGN KEY (`student_egn`) REFERENCES students (`egn`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `term_grades_ibfk_5` FOREIGN KEY (`grade_id`) REFERENCES grades (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `term_grades_ibfk_6` FOREIGN KEY (`subject_id`) REFERENCES subjects (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `term_grades_ibfk_7` FOREIGN KEY (`term_id`) REFERENCES terms (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `term_grades_ibfk_8` FOREIGN KEY (`teacher_id`) REFERENCES teachers (`id`) ON UPDATE CASCADE;
  
--
-- Constraints for table `school_session`
--

ALTER TABLE `school_session`
  ADD CONSTRAINT `school_session_ibfk_1` FOREIGN KEY (`term_id`) REFERENCES terms (`id`) ON UPDATE CASCADE;
  

