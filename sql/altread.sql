-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 29, 2025 at 07:16 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;
--
-- Database: `altread`
--

CREATE DATABASE altread;
USE altread;
-- --------------------------------------------------------
--
-- Table structure for table `answer_keys`
--

CREATE TABLE `answer_keys` (
  `id` int NOT NULL,
  `original_name` varchar(255) DEFAULT NULL,
  `stored_name` varchar(255) DEFAULT NULL,
  `file_path` text,
  `file_size` int DEFAULT NULL,
  `uploaded_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
--
-- Dumping data for table `answer_keys`
--

INSERT INTO `answer_keys` (
    `id`,
    `original_name`,
    `stored_name`,
    `file_path`,
    `file_size`,
    `uploaded_at`,
    `is_active`
  )
VALUES (
    17,
    'Doc1.pdf',
    'css-guide-list.pdf',
    '/files/uploads/answer_keys/css-guide-list.pdf',
    322842,
    '2025-04-06 15:51:39',
    0
  ),
  (
    18,
    'rgb-hex-colors-guide.pdf',
    'rgb-hex-colors-guide_1_2_3.pdf',
    '/files/uploads/answer_keys/rgb-hex-colors-guide_1_2_3.pdf',
    203420,
    '2025-04-06 16:00:34',
    0
  );
-- --------------------------------------------------------
--
-- Table structure for table `audit_log`
--

CREATE TABLE `audit_log` (
  `log_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
-- --------------------------------------------------------
--
-- Table structure for table `choices`
--

CREATE TABLE `choices` (
  `choice_id` int NOT NULL,
  `question_id` int NOT NULL,
  `choice_text` text NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
--
-- Dumping data for table `choices`
--

INSERT INTO `choices` (
    `choice_id`,
    `question_id`,
    `choice_text`,
    `is_correct`,
    `is_active`,
    `created_at`
  )
VALUES (
    13,
    27,
    'is the most important point of a text',
    0,
    1,
    '2025-04-07 15:24:01'
  ),
  (
    14,
    27,
    '2. is the least important point of a text',
    1,
    1,
    '2025-04-07 15:24:02'
  ),
  (
    15,
    27,
    '3. may be found in the title of the text',
    0,
    1,
    '2025-04-07 15:24:02'
  ),
  (
    16,
    27,
    '4. may be found as part of an introduction to a text',
    1,
    1,
    '2025-04-07 15:24:02'
  );
-- --------------------------------------------------------
--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` int NOT NULL,
  `department_name` varchar(100) NOT NULL,
  `department_description` text
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (
    `department_id`,
    `department_name`,
    `department_description`
  )
VALUES (
    1,
    'Science',
    'Department focused on scientific disciplines such as Physics, Chemistry, and Biology.'
  ),
  (
    2,
    'Mathematics',
    'Department specializing in Mathematics and related fields.'
  ),
  (
    3,
    'English',
    'Department dedicated to English language and literature studies.'
  ),
  (
    4,
    'Social Studies',
    'Department covering History, Geography, and Social Sciences.'
  ),
  (
    5,
    'Computer Science',
    'Department focusing on computer programming, information technology, and digital systems.'
  ),
  (
    6,
    'Physical Education',
    'Department responsible for physical fitness, sports, and health education.'
  );
-- --------------------------------------------------------
--
-- Table structure for table `learners`
--

CREATE TABLE `learners` (
  `learner_id` int NOT NULL,
  `user_id` int NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `sex` enum('Male', 'Female') NOT NULL,
  `birthdate` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `religion` varchar(50) DEFAULT NULL,
  `marital_status` enum(
    'Single',
    'Married',
    'Widow/Widower',
    'Separated/Divorced'
  ) DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `educational_attainment` varchar(100) DEFAULT NULL,
  `personal_statement` text,
  `enrollment_status` enum(
    'pending',
    'enrolled',
    'rejected',
    'promoted',
    'drop'
  ) NOT NULL DEFAULT 'pending',
  `reason_for_rejection` text
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
--
-- Dumping data for table `learners`
--

INSERT INTO `learners` (
    `learner_id`,
    `user_id`,
    `first_name`,
    `middle_name`,
    `last_name`,
    `sex`,
    `birthdate`,
    `address`,
    `religion`,
    `marital_status`,
    `occupation`,
    `educational_attainment`,
    `personal_statement`,
    `enrollment_status`,
    `reason_for_rejection`
  )
VALUES (
    8,
    4,
    'Jennifer',
    'Ursa Joyce',
    'Holland',
    'Male',
    '1982-06-09',
    'Quos aute sit totam , Magna blanditiis quo, Voluptas ipsum dolo, Irure sunt voluptate',
    'Inventore a eaque mi',
    'Separated/Divorced',
    'Eos sed optio non ',
    NULL,
    'Modi quo obcaecati a',
    'enrolled',
    NULL
  ),
  (
    9,
    5,
    'Camilo',
    'Arceo',
    'Diamante Jr.',
    'Male',
    '1998-06-20',
    'Block 12 Lot 12, Paloc Sool, Dumangas, Iloilo',
    'Christianity',
    'Single',
    'Admin Staff',
    NULL,
    'jdjjdjdjdjhd',
    'enrolled',
    NULL
  );
-- --------------------------------------------------------
--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `lesson_id` int NOT NULL,
  `module_id` int NOT NULL,
  `lesson_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `lesson_description` text,
  `is_active` tinyint(1) DEFAULT '1'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (
    `lesson_id`,
    `module_id`,
    `lesson_name`,
    `lesson_description`,
    `is_active`
  )
VALUES (1, 1, 'Lesson 1', 'What’s the Big Idea?', 1),
  (2, 1, 'Lesson 2', 'This is Where I Stand', 1),
  (3, 1, 'Lesson 3', 'Just Follow Me', 1),
  (
    4,
    2,
    'Lesson 1',
    'What is the Subject, Please?',
    0
  ),
  (5, 2, 'Lesson 2', 'It’s Simply Active', 0),
  (6, 2, 'Lesson 3', 'You Are So Intense', 0),
  (7, 3, 'Lesson 1', 'I Am Ready, Are You?', 0);
-- --------------------------------------------------------
--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `materialID` int NOT NULL,
  `materialCategory` varchar(300) DEFAULT NULL,
  `materialTitle` varchar(300) DEFAULT NULL,
  `materialSubtitle` varchar(300) DEFAULT NULL,
  `materialGenre` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `materialFiles` varchar(300) DEFAULT NULL,
  `datePublished` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isArchived` tinyint(1) NOT NULL DEFAULT '0',
  `dateArchived` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (
    `materialID`,
    `materialCategory`,
    `materialTitle`,
    `materialSubtitle`,
    `materialGenre`,
    `materialFiles`,
    `datePublished`,
    `isArchived`,
    `dateArchived`
  )
VALUES (
    1,
    'Modules',
    'Module 1',
    'I GET IT (RECOGNIZING THE MAIN IDEA)',
    'Not Applicable',
    'ALS_LS1_ENGLISH_M01_(1).pdf',
    '2025-01-26 05:30:57',
    0,
    NULL
  ),
  (
    2,
    'Handbook',
    'HTML5',
    'Guide list',
    'Not Applicable',
    'rgb-hex-colors-guide.pdf',
    '2025-01-30 13:59:54',
    1,
    '2025-03-17 14:23:38'
  ),
  (
    3,
    'Modules',
    'Module 2',
    'IN OTHER WORDS (RESTATING INFORMATION)',
    'Not Applicable',
    'ALS_LS1_ENGLISH_M02_(2).pdf',
    '2025-01-30 14:04:04',
    1,
    '0000-00-00 00:00:00'
  ),
  (
    4,
    'fdafaf',
    'fdf',
    'fdf',
    'Not Applicable',
    'jquery-guide-list.pdf',
    '2025-01-30 14:05:23',
    1,
    '0000-00-00 00:00:00'
  ),
  (
    5,
    'Module',
    'Module 3',
    'I MYSELF BELIEVE (EXPRESSING OPINIONS)',
    'Not Applicable',
    'ALS_LS1_ENGLISH_M03.pdf',
    '2025-01-30 15:09:11',
    0,
    '0000-00-00 00:00:00'
  ),
  (
    6,
    'Module',
    'Module 1',
    'I get it recognize',
    'Not Applicable',
    '1738508316_xhtml-guide-list.pdf',
    '2025-02-02 03:17:46',
    1,
    '0000-00-00 00:00:00'
  ),
  (
    7,
    'Module',
    'Module 7',
    'I get it recognize',
    'Not Applicable',
    'html5-guide-list_(1).pdf',
    '2025-02-02 03:18:31',
    1,
    '0000-00-00 00:00:00'
  );
-- --------------------------------------------------------
--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `module_id` int NOT NULL,
  `module_name` varchar(100) NOT NULL,
  `module_description` text,
  `is_active` tinyint(1) DEFAULT '1'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (
    `module_id`,
    `module_name`,
    `module_description`,
    `is_active`
  )
VALUES (
    1,
    'Module 1',
    'I GET IT (RECOGNIZING THE MAIN IDEA)',
    1
  ),
  (
    2,
    'Module 2',
    'IN OTHER WORDS (RESTATING INFORMATION)',
    1
  ),
  (
    3,
    'Module 3',
    'I MYSELF BELIEVE (EXPRESSING OPINIONS)',
    1
  ),
  (
    4,
    'Module 4',
    'YOU ARE DOING WELL, AREN’T YOU? (TAG QUESTIONS)',
    1
  ),
  (
    5,
    'Module 5',
    'WHAT IS THE MEANING OF THIS? (DRAWING GENERALIZATIONS)',
    1
  ),
  (
    6,
    'Module 6',
    'GIVE ME A HINT (USING CONTEXT CLUES)',
    1
  ),
  (
    7,
    'Module 7',
    'JUST HANG IN THERE (IDIOMATIC EXPRESSIONS)',
    1
  ),
  (
    8,
    'Module 8',
    'WRITE IT (YOUR JOURNEY INTO THE TEXT)',
    1
  );
-- --------------------------------------------------------
--
-- Table structure for table `parts`
--

CREATE TABLE `parts` (
  `part_id` int NOT NULL,
  `part_name` varchar(100) NOT NULL,
  `part_description` text,
  `is_active` tinyint(1) DEFAULT '1'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
--
-- Dumping data for table `parts`
--

INSERT INTO `parts` (
    `part_id`,
    `part_name`,
    `part_description`,
    `is_active`
  )
VALUES (1, 'Setting the Path', NULL, 0),
  (2, 'Trying This Out', NULL, 1),
  (3, 'Understanding What You Did', NULL, 1),
  (4, 'Sharpening Your Skills', NULL, 1),
  (5, 'Treading the Road to Mastery', NULL, 1);
-- --------------------------------------------------------
--
-- Table structure for table `pretest`
--

CREATE TABLE `pretest` (
  `pretest_id` int NOT NULL,
  `pretest_type` enum('Reading', 'Writing') NOT NULL,
  `question` text NOT NULL,
  `context` varchar(3000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `first_sub_context` varchar(3000) DEFAULT NULL,
  `second_sub_context` varchar(3000) DEFAULT NULL,
  `third_sub_context` varchar(3000) DEFAULT NULL,
  `fourth_sub_context` varchar(3000) DEFAULT NULL,
  `choice_a` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `choice_b` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `choice_c` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `choice_d` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `correct_answer` char(1) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `archive_date_time` datetime DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
--
-- Dumping data for table `pretest`
--

INSERT INTO `pretest` (
    `pretest_id`,
    `pretest_type`,
    `question`,
    `context`,
    `first_sub_context`,
    `second_sub_context`,
    `third_sub_context`,
    `fourth_sub_context`,
    `choice_a`,
    `choice_b`,
    `choice_c`,
    `choice_d`,
    `correct_answer`,
    `image_url`,
    `is_active`,
    `archive_date_time`
  )
VALUES (
    1,
    'Reading',
    'Which of the following signs means \"NO SMOKING\"?',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    'no-blowing-of-horns.png',
    'one-way.png',
    'tweenty-speed.png',
    'no-smoking.png',
    'D',
    NULL,
    0,
    NULL
  ),
  (
    2,
    'Reading',
    'Identify the type of sentence according to use.',
    'I won the lottery!',
    '',
    '',
    '',
    '',
    'Imperative',
    'Exclamatory',
    'Declarative',
    'Interrogative',
    'B',
    NULL,
    0,
    NULL
  ),
  (
    4,
    'Reading',
    'What is the main idea of the paragraph?',
    'The Sun is very important. Without it, there would be only darkness and our planet would be very cold and be without liquid water. Our planet would also be without people, animals, and plants because these things need sunlight and water to live.\r\n(Excerpt from “The Sun and The Stars, by Sue Peterson)',
    '',
    '',
    '',
    '',
    'Things need sunlight to live.',
    'There would be darkness in our planet.',
    'It would be very cold on Earth.',
    'The importance of the Sun.',
    'A',
    NULL,
    1,
    NULL
  ),
  (
    5,
    'Reading',
    'Based on below directions for the use of fertilizer, what is the rate to be applied for Pop-Up Starter?',
    'General Use Directions\r\n',
    '',
    '',
    '',
    '',
    '1/2 gallon in a 3-10 gallon tank',
    '1/2 gallon per acre',
    '1/2 gallon per acre as needed',
    '1/2 gallon per jar',
    'A',
    NULL,
    1,
    NULL
  );
-- --------------------------------------------------------
--
-- Table structure for table `pretest_submitted_answers`
--

CREATE TABLE `pretest_submitted_answers` (
  `psaID` int NOT NULL,
  `learnerID` int NOT NULL,
  `pretestID` int NOT NULL,
  `pretestAnswer` varchar(350) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pretestScore` int DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
--
-- Dumping data for table `pretest_submitted_answers`
--

INSERT INTO `pretest_submitted_answers` (
    `psaID`,
    `learnerID`,
    `pretestID`,
    `pretestAnswer`,
    `pretestScore`
  )
VALUES (86, 1, 4, 'C', 0),
  (87, 1, 5, 'C', 0),
  (88, 1, 4, 'C', 0),
  (89, 1, 5, 'C', 0),
  (90, 9, 4, 'C', 0),
  (91, 9, 5, 'B', 0),
  (92, 9, 4, 'C', 0),
  (93, 9, 5, 'B', 0);
-- --------------------------------------------------------
--
-- Table structure for table `progress`
--

CREATE TABLE `progress` (
  `progress_id` int NOT NULL,
  `learner_id` int NOT NULL,
  `module_id` int DEFAULT NULL,
  `lesson_id` int DEFAULT NULL,
  `part_id` int DEFAULT NULL,
  `status` enum('Not Started', 'In Progress', 'Completed') DEFAULT 'Not Started'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
-- --------------------------------------------------------
--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int NOT NULL,
  `lesson_id` int NOT NULL,
  `part_id` int NOT NULL,
  `questions_direction` varchar(500) DEFAULT NULL,
  `question_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `content_title` varchar(255) DEFAULT NULL,
  `content_img` varchar(255) DEFAULT NULL,
  `sub_content_1` text,
  `sub_content_2` text,
  `sub_content_3` text,
  `sub_content_4` text,
  `question_type` enum(
    'multiple_choice',
    'true_false',
    'short_answer',
    'fill_in_the_blank'
  ) NOT NULL DEFAULT 'multiple_choice',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (
    `question_id`,
    `lesson_id`,
    `part_id`,
    `questions_direction`,
    `question_text`,
    `content_title`,
    `content_img`,
    `sub_content_1`,
    `sub_content_2`,
    `sub_content_3`,
    `sub_content_4`,
    `question_type`,
    `is_active`,
    `created_at`,
    `updated_at`
  )
VALUES (
    27,
    1,
    2,
    'Directions: Which of the statements below best describe the main idea and the\r\nsupporting details of a written or spoken text? Select the choices below the paragraph.',
    'The main idea of a paragraph',
    '',
    'default-img.jpg',
    NULL,
    NULL,
    NULL,
    NULL,
    'multiple_choice',
    1,
    '2025-04-07 23:24:01',
    '2025-04-07 23:24:01'
  );
-- --------------------------------------------------------
--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `quiz_id` int NOT NULL,
  `quiz_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quiz_question` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_content_1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sub_content_2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sub_content_3` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sub_content_4` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sub_content_5` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sub_content_6` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `choices_1` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `choices_2` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `choices_3` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `choices_4` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `choices_5` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `choices_6` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quiz_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (
    `quiz_id`,
    `quiz_title`,
    `quiz_question`,
    `sub_content_1`,
    `sub_content_2`,
    `sub_content_3`,
    `sub_content_4`,
    `sub_content_5`,
    `sub_content_6`,
    `choices_1`,
    `choices_2`,
    `choices_3`,
    `choices_4`,
    `choices_5`,
    `choices_6`,
    `quiz_type`,
    `is_active`,
    `created_at`,
    `updated_at`
  )
VALUES (
    40,
    'Perferendis dolores',
    'Qui id deserunt dolo',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    'short_answer',
    1,
    '2025-04-09 05:24:08',
    '2025-04-09 05:24:08'
  ),
  (
    41,
    'Dolorum et accusanti',
    'Ut cumque mollitia d',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    'short_answer',
    1,
    '2025-04-09 05:25:25',
    '2025-04-09 05:25:25'
  ),
  (
    42,
    'Quia et possimus ea',
    'Ut est non id eaque',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    'true_false',
    1,
    '2025-04-09 05:26:05',
    '2025-04-09 05:26:05'
  ),
  (
    43,
    'Ipsum odit amet et',
    'Iste excepteur accus',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    'true_false',
    1,
    '2025-04-09 05:28:08',
    '2025-04-09 05:28:08'
  ),
  (
    44,
    'Consequat Recusanda',
    'Magna consequatur p',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    'true_false',
    1,
    '2025-04-09 05:33:39',
    '2025-04-09 05:33:39'
  ),
  (
    45,
    'Sed est velit et re',
    'Accusamus quaerat qu',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    'multiple_choice',
    1,
    '2025-04-09 05:33:46',
    '2025-04-09 05:33:46'
  ),
  (
    46,
    'Voluptatem laboris c',
    'Et at nisi temporibu',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    'true_false',
    1,
    '2025-04-09 05:34:06',
    '2025-04-09 05:34:06'
  ),
  (
    47,
    'Nemo facilis est in',
    'Ratione similique od',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    'true_false',
    1,
    '2025-04-09 05:36:24',
    '2025-04-09 05:36:24'
  ),
  (
    48,
    'Rem est beatae persp',
    'Consequatur ea dele',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    'multiple_choice',
    1,
    '2025-04-09 05:36:31',
    '2025-04-09 05:36:31'
  ),
  (
    49,
    'Modi iure nulla exce',
    'Consectetur asperio',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    'multiple_choice',
    1,
    '2025-04-09 05:36:38',
    '2025-04-09 05:36:38'
  ),
  (
    50,
    'Rem ad nostrum cupid',
    'Sint voluptatem Re',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    'true_false',
    1,
    '2025-04-09 05:36:45',
    '2025-04-09 05:36:45'
  ),
  (
    51,
    'Minim in quis volupt',
    'Non elit est et dig',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    'short_answer',
    1,
    '2025-04-09 05:36:55',
    '2025-04-09 05:36:55'
  );
-- --------------------------------------------------------
--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `submission_id` int NOT NULL,
  `learner_id` int NOT NULL,
  `question_id` int NOT NULL,
  `choice_id` int DEFAULT NULL,
  `answers` varchar(600) NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT '1',
  `submitted_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `score` decimal(5, 2) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (
    `submission_id`,
    `learner_id`,
    `question_id`,
    `choice_id`,
    `answers`,
    `is_correct`,
    `submitted_at`,
    `score`
  )
VALUES (
    4,
    9,
    27,
    NULL,
    'ffff',
    1,
    '2025-04-29 14:29:18',
    1.00
  ),
  (
    5,
    9,
    27,
    NULL,
    'aaaaa',
    1,
    '2025-04-29 14:54:27',
    1.00
  );
-- --------------------------------------------------------
--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` int NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `address` varchar(500) NOT NULL,
  `date_of_birth` timestamp NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (
    `teacher_id`,
    `first_name`,
    `middle_name`,
    `last_name`,
    `email`,
    `contact_number`,
    `position`,
    `address`,
    `date_of_birth`,
    `is_active`,
    `created_at`
  )
VALUES (
    14,
    'Lamar',
    'Jake',
    'Ferguson',
    'jucilujero@mailinator.com',
    '979',
    'Itaque aliquam dolor',
    'Ut veritatis a nihil',
    '2005-03-14 16:00:00',
    0,
    '2025-04-06 17:21:39'
  ),
  (
    15,
    'Raymond',
    'Jamal',
    'Gordon',
    'bagijykejy@mailinator.com',
    '984',
    'Repellendus Exercit',
    'Voluptatem doloribus',
    '1976-02-11 16:00:00',
    0,
    '2025-04-06 17:23:09'
  ),
  (
    16,
    'Dylan',
    ' Spears',
    'Carver',
    'besa@mailinator.com',
    '305',
    'Adipisicing nihil de',
    'Dolorum consequatur ',
    '2008-08-08 16:00:00',
    0,
    '2025-04-06 17:23:58'
  ),
  (
    17,
    'Faith',
    'Jaime',
    'Carroll',
    'fimomaweho@mailinator.com',
    '617',
    'Voluptatum anim est',
    'Nanananananana',
    '1978-10-05 16:00:00',
    0,
    '2025-04-06 18:37:55'
  ),
  (
    18,
    'Chastity',
    'Xander ',
    'Parks',
    'muxaxiqery@mailinator.com',
    '648',
    'Quia sint quod et na',
    'Eum officiis velit ',
    '1979-06-12 16:00:00',
    0,
    '2025-04-06 18:39:26'
  ),
  (
    19,
    'Yeo',
    'Russell',
    'Lawrence',
    'hojumy@mailinator.com',
    '118',
    'Nihil aut et ad aliq',
    'Ipsa eius deserunt ',
    '1987-05-02 16:00:00',
    0,
    '2025-04-06 18:45:42'
  );
-- --------------------------------------------------------
--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `avatar` varchar(250) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('Admin', 'Teacher', 'Learner') NOT NULL,
  `date_created` date DEFAULT NULL,
  `is_status` enum(
    'active',
    'inactive',
    'suspended',
    'banned',
    'archived'
  ) DEFAULT 'active'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
--
-- Dumping data for table `users`
--

INSERT INTO `users` (
    `user_id`,
    `avatar`,
    `name`,
    `email`,
    `username`,
    `password`,
    `user_type`,
    `date_created`,
    `is_status`
  )
VALUES (
    1,
    'nilo_d_depamaylo.jpg',
    'Nilo D. Depamaylo',
    'nilo_depaymlo@mailinator.com',
    'Nilo',
    '$2y$10$CTswX4VQSaNXFdhHHgI1XumejmOoy7jI5BmkZm9cwylMy2PIY9XLC',
    'Admin',
    '2024-11-22',
    'active'
  ),
  (
    3,
    'Myriane_victoria_paulino.jpg',
    'Myriane Victoria R. Paulino',
    'myrianevictoriapaulino@gmail.com',
    'myriane_paulino',
    '$2y$10$CTswX4VQSaNXFdhHHgI1XumejmOoy7jI5BmkZm9cwylMy2PIY9XLC',
    'Teacher',
    '2025-04-06',
    'active'
  ),
  (
    4,
    'default-profile.png',
    'Hall Yates',
    'zubax@mailinator.com',
    'zixotun',
    '$2y$10$ficKK4BgFU0t/bQH/YhV8eg5BBIDaL6C6mLEFGm46HBFJh80vjiDi',
    'Learner',
    '2025-04-07',
    'active'
  ),
  (
    5,
    'default-profile.png',
    'Camilo A. Diamante Jr.',
    'camilodiamantejr@gmail.com',
    'Camilo',
    '$2y$10$kH8453N6Fby0dHyw3LtNCu4wWP14etPAIYp0gL6PEGp0sZt9fRbgm',
    'Learner',
    '2025-04-23',
    'active'
  );
--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer_keys`
--
ALTER TABLE `answer_keys`
ADD PRIMARY KEY (`id`);
--
-- Indexes for table `audit_log`
--
ALTER TABLE `audit_log`
ADD PRIMARY KEY (`log_id`),
  ADD KEY `audit_log_ibfk_1` (`user_id`);
--
-- Indexes for table `choices`
--
ALTER TABLE `choices`
ADD PRIMARY KEY (`choice_id`),
  ADD KEY `question_id` (`question_id`);
--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
ADD PRIMARY KEY (`department_id`);
--
-- Indexes for table `learners`
--
ALTER TABLE `learners`
ADD PRIMARY KEY (`learner_id`),
  ADD KEY `learners_ibfk_1` (`user_id`);
--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
ADD PRIMARY KEY (`lesson_id`),
  ADD KEY `lessons_ibfk_1` (`module_id`);
--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
ADD PRIMARY KEY (`materialID`);
--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
ADD PRIMARY KEY (`module_id`);
--
-- Indexes for table `parts`
--
ALTER TABLE `parts`
ADD PRIMARY KEY (`part_id`),
  ADD UNIQUE KEY `part_id` (`part_id`);
--
-- Indexes for table `pretest`
--
ALTER TABLE `pretest`
ADD PRIMARY KEY (`pretest_id`);
--
-- Indexes for table `pretest_submitted_answers`
--
ALTER TABLE `pretest_submitted_answers`
ADD PRIMARY KEY (`psaID`),
  ADD KEY `pretestID` (`pretestID`),
  ADD KEY `learnerID` (`learnerID`);
--
-- Indexes for table `progress`
--
ALTER TABLE `progress`
ADD PRIMARY KEY (`progress_id`);
--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
ADD PRIMARY KEY (`question_id`),
  ADD KEY `lesson_id` (`lesson_id`),
  ADD KEY `part_id` (`part_id`) USING BTREE;
--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
ADD PRIMARY KEY (`quiz_id`);
--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
ADD PRIMARY KEY (`submission_id`),
  ADD KEY `learner_id` (`learner_id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `choice_id` (`choice_id`);
--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
ADD PRIMARY KEY (`teacher_id`),
  ADD UNIQUE KEY `email` (`email`);
--
-- Indexes for table `users`
--
ALTER TABLE `users`
ADD PRIMARY KEY (`user_id`);
--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer_keys`
--
ALTER TABLE `answer_keys`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 19;
--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
MODIFY `log_id` int NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `choices`
--
ALTER TABLE `choices`
MODIFY `choice_id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 17;
--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
MODIFY `department_id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 7;
--
-- AUTO_INCREMENT for table `learners`
--
ALTER TABLE `learners`
MODIFY `learner_id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 10;
--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
MODIFY `lesson_id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 18;
--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
MODIFY `materialID` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 8;
--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
MODIFY `module_id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 9;
--
-- AUTO_INCREMENT for table `parts`
--
ALTER TABLE `parts`
MODIFY `part_id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 6;
--
-- AUTO_INCREMENT for table `pretest`
--
ALTER TABLE `pretest`
MODIFY `pretest_id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 6;
--
-- AUTO_INCREMENT for table `pretest_submitted_answers`
--
ALTER TABLE `pretest_submitted_answers`
MODIFY `psaID` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 94;
--
-- AUTO_INCREMENT for table `progress`
--
ALTER TABLE `progress`
MODIFY `progress_id` int NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
MODIFY `question_id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 28;
--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
MODIFY `quiz_id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 52;
--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
MODIFY `submission_id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 6;
--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
MODIFY `teacher_id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 20;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `user_id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_log`
--
ALTER TABLE `audit_log`
ADD CONSTRAINT `audit_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE
SET NULL;
--
-- Constraints for table `learners`
--
ALTER TABLE `learners`
ADD CONSTRAINT `learners_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
--
-- Constraints for table `submissions`
--
ALTER TABLE `submissions`
ADD CONSTRAINT `submissions_ibfk_1` FOREIGN KEY (`learner_id`) REFERENCES `learners` (`learner_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `submissions_ibfk_2` FOREIGN KEY (`choice_id`) REFERENCES `choices` (`choice_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `submissions_ibfk_3` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;