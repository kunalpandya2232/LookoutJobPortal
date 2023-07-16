-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2022 at 07:45 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testlookout_db_proj7911`
--

-- --------------------------------------------------------

--
-- Table structure for table `lo_tblapplier`
--

CREATE TABLE `lo_tblapplier` (
  `id` mediumint(10) UNSIGNED NOT NULL,
  `user_id` mediumint(10) UNSIGNED DEFAULT NULL,
  `apply` enum('1','0','2') NOT NULL DEFAULT '0' COMMENT '0=apply, 1=accept,2=deny',
  `job` mediumint(10) UNSIGNED DEFAULT NULL,
  `report` mediumint(10) UNSIGNED DEFAULT NULL,
  `is_delete` enum('Y','N','') NOT NULL DEFAULT 'N',
  `lastly_editedBy` enum('J','O','A') DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lo_tblapplier`
--

INSERT INTO `lo_tblapplier` (`id`, `user_id`, `apply`, `job`, `report`, `is_delete`, `lastly_editedBy`, `date_created`, `date_updated`) VALUES
(1, 7, '1', 3, NULL, 'N', NULL, '2022-04-03 07:06:43', '2022-04-03 07:07:49');

-- --------------------------------------------------------

--
-- Table structure for table `lo_tblcategory`
--

CREATE TABLE `lo_tblcategory` (
  `id` mediumint(10) UNSIGNED NOT NULL,
  `category_name` varchar(20) NOT NULL,
  `category_subname` varchar(20) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lo_tblcategory`
--

INSERT INTO `lo_tblcategory` (`id`, `category_name`, `category_subname`, `date_created`, `date_updated`) VALUES
(1, 'IT', 'ANDROID DEVELOPER', '2022-04-02 12:13:36', '2022-04-02 12:13:36'),
(2, 'IT', 'WEB DEVELOPER', '2022-04-02 12:13:36', '2022-04-02 12:13:36'),
(3, 'IT', 'PYTHON DEVELOPER', '2022-04-02 12:13:36', '2022-04-02 12:13:36'),
(4, 'IT', 'FRONTEND DEVELOPER', '2022-04-02 12:13:36', '2022-04-02 12:13:36'),
(5, 'EDUCATION', 'TEACHER', '2022-04-02 12:13:36', '2022-04-02 12:13:36'),
(6, 'EDUCATION', 'SCHOOL DRIVERS', '2022-04-02 12:13:36', '2022-04-02 12:13:36'),
(7, 'MARKETING', 'SALES PERSON', '2022-04-02 12:13:36', '2022-04-02 12:13:36'),
(8, 'MARKETING', 'ADERTISER', '2022-04-02 12:13:36', '2022-04-02 12:13:36'),
(9, 'MARKETING', 'INVENTORY', '2022-04-02 12:13:36', '2022-04-02 12:13:36'),
(10, 'OTHERS', 'PEIONS', '2022-04-02 12:13:36', '2022-04-02 12:13:36'),
(11, 'OTHERS', 'DRIVERS', '2022-04-02 12:13:36', '2022-04-02 12:13:36'),
(12, 'OTHERS', 'SECURITY', '2022-04-02 12:13:36', '2022-04-02 12:13:36'),
(13, 'OTHERS', 'SERVENTS', '2022-04-02 12:13:36', '2022-04-02 12:13:36'),
(14, 'BUSSINESS', 'REAL-ESTATE', '2022-04-02 12:13:36', '2022-04-02 12:13:36'),
(15, 'BUSSINESS', 'MANAGER', '2022-04-02 12:13:36', '2022-04-02 12:13:36');

-- --------------------------------------------------------

--
-- Table structure for table `lo_tblcomments`
--

CREATE TABLE `lo_tblcomments` (
  `id` mediumint(10) UNSIGNED NOT NULL,
  `user_id` mediumint(10) UNSIGNED NOT NULL,
  `job_id` mediumint(10) UNSIGNED NOT NULL,
  `comment_desc` varchar(255) NOT NULL,
  `comment_createdBy` enum('A','O','J') NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lo_tblcomments`
--

INSERT INTO `lo_tblcomments` (`id`, `user_id`, `job_id`, `comment_desc`, `comment_createdBy`, `date_created`, `date_updated`) VALUES
(1, 2, 3, 'Good', 'O', '2022-04-03 06:56:53', '2022-04-03 06:56:53'),
(2, 7, 3, 'Nice', 'J', '2022-04-03 07:06:14', '2022-04-03 07:06:14'),
(3, 2, 3, 'We accept', 'O', '2022-04-03 07:08:17', '2022-04-03 07:08:17'),
(4, 2, 3, 'I will comment', 'O', '2022-04-04 05:24:10', '2022-04-04 05:24:10');

-- --------------------------------------------------------

--
-- Table structure for table `lo_tbljobs`
--

CREATE TABLE `lo_tbljobs` (
  `id` mediumint(10) UNSIGNED NOT NULL,
  `user_id` mediumint(10) UNSIGNED NOT NULL,
  `job_title` varchar(200) NOT NULL,
  `job_desc` varchar(255) NOT NULL,
  `job_amt` int(10) NOT NULL,
  `job_hours` enum('1','2','0') NOT NULL DEFAULT '1',
  `job_miniexp` mediumint(3) UNSIGNED DEFAULT 0,
  `job_vacancy` mediumint(5) NOT NULL,
  `job_location` varchar(150) DEFAULT NULL,
  `job_responsibility` varchar(100) DEFAULT NULL,
  `job_skillRequire` varchar(100) DEFAULT NULL,
  `category_id` mediumint(10) UNSIGNED NOT NULL,
  `is_deleted` enum('Y','N') NOT NULL DEFAULT 'N',
  `is_reported` enum('Y','N') NOT NULL DEFAULT 'N',
  `job_createdBy` enum('A','O') DEFAULT NULL,
  `job_lastlyEdited` enum('A','O') DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lo_tbljobs`
--

INSERT INTO `lo_tbljobs` (`id`, `user_id`, `job_title`, `job_desc`, `job_amt`, `job_hours`, `job_miniexp`, `job_vacancy`, `job_location`, `job_responsibility`, `job_skillRequire`, `category_id`, `is_deleted`, `is_reported`, `job_createdBy`, `job_lastlyEdited`, `date_created`, `date_updated`) VALUES
(1, 2, 'Software devwloper', 'we need To sofrwa,faml', 50000, '1', 5, 150, '', '', '', 1, 'Y', 'N', 'O', 'O', '2022-04-02 12:15:09', '2022-04-03 06:36:24'),
(2, 2, 'testf  ddd', 'testtesff', 4444, '2', 4, 4, '', 'rrfsdf', 'fdsfds', 4, 'Y', 'N', 'O', 'O', '2022-04-02 13:14:47', '2022-04-04 05:43:17'),
(3, 2, 'Software devwloper - III', 'we need To sofrwa,faml', 5000, '2', 0, 1, 'indiaa', '', '', 5, 'Y', 'N', 'O', 'O', '2022-04-02 18:53:13', '2022-04-04 05:43:42'),
(4, 3, 'XXXXZZZZXXX', 'ffdsfdfds', 10000, '0', 4, 3, '', '', '', 6, 'N', 'N', 'O', 'O', '2022-04-03 17:29:37', '2022-04-03 17:29:37'),
(5, 3, 'okok', 'dsadas', 8000, '0', 8, 11, '', '', '', 2, 'N', 'N', 'O', 'A', '2022-04-03 17:30:01', '2022-04-03 21:53:59');

-- --------------------------------------------------------

--
-- Table structure for table `lo_tblotp`
--

CREATE TABLE `lo_tblotp` (
  `id` mediumint(10) UNSIGNED NOT NULL,
  `user_email` varchar(150) NOT NULL,
  `type` enum('REG','FPASS','CONTACT') NOT NULL,
  `verify_code` varchar(16) NOT NULL,
  `verify_status` enum('0','1') NOT NULL DEFAULT '0',
  `is_verify` enum('0','1') NOT NULL DEFAULT '0',
  `date_created` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lo_tblotp`
--

INSERT INTO `lo_tblotp` (`id`, `user_email`, `type`, `verify_code`, `verify_status`, `is_verify`, `date_created`) VALUES
(1, 'admin@admin.com', 'REG', 'gudiya48dfa', '1', '1', '2022-04-02 11:31:03'),
(2, 'mera131549911@gmail.com', 'REG', 'jaanus88dd', '1', '1', '2022-04-02 11:31:40'),
(3, 'lamnin1251159@gmail.com', 'REG', 'kunal142dd', '1', '0', '2022-04-02 11:32:30'),
(4, 'gudiya61565125@gmail.com', 'REG', 'yogesh52powbiq', '1', '1', '2022-04-02 11:32:30'),
(5, 'diines123691411@gmail.com', 'REG', 'tenjvi1314powbiq', '1', '1', '2022-04-02 11:32:30'),
(6, 'jaanus12841512@gmail.com', 'REG', 'shyam72qod', '1', '1', '2022-04-02 11:32:30'),
(7, 'harsh1017631@gmail.com', 'REG', 'urvi1410qpod', '1', '1', '2022-04-02 11:32:31'),
(8, 'urvi151151332@gmail.com', 'REG', 'lamnin132dfa', '1', '1', '2022-04-02 11:32:31'),
(9, 'wrjoterj673541@gmail.com', 'REG', 'qorano410qpq', '1', '1', '2022-04-02 11:32:31'),
(10, 'urvi6101414411@gmail.com', 'REG', 'urvi33aq', '1', '1', '2022-04-02 11:32:31'),
(11, 'fafad3310282@gmail.com', 'REG', 'rajs113qod', '1', '1', '2022-04-02 11:32:31'),
(12, 'ishat215941312@gmail.com', 'REG', 'harsh86qpq', '1', '1', '2022-04-02 11:32:31'),
(13, 'elsisha4155615@gmail.com', 'REG', 'xagqu113own', '1', '1', '2022-04-02 11:32:31'),
(14, 'chandu2115476@gmail.com', 'REG', 'owl12doif', '1', '1', '2022-04-02 11:32:31'),
(15, 'paassr733183@gmail.com', 'REG', 'wrjoterj38qpod', '1', '1', '2022-04-02 11:32:31'),
(16, 'paassr124751213@gmail.com', 'REG', 'lamnin1414iwud', '1', '1', '2022-04-02 11:32:31'),
(17, 'fafad1762715@gmail.com', 'REG', 'rajs815qpod', '1', '1', '2022-04-02 11:32:32'),
(18, 'zorion239121010@gmail.com', 'REG', 'gudiya91own', '1', '0', '2022-04-02 11:32:32'),
(19, 'zorion102211010@gmail.com', 'REG', 'diines611qpq', '1', '1', '2022-04-02 11:32:32'),
(20, 'rajs143610911@gmail.com', 'REG', 'shyam74qod', '1', '1', '2022-04-02 11:32:32'),
(21, 'elsisha997644@gmail.com', 'REG', 'wrjoterj1312powb', '1', '1', '2022-04-02 11:32:32'),
(22, 'ishat71545131@gmail.com', 'REG', 'ishat1010dd', '1', '0', '2022-04-02 11:36:44'),
(23, 'bhavik810141414@gmail.com', 'REG', 'elsisha159iwud', '1', '1', '2022-04-02 11:37:00'),
(24, 'vyom2151111715@gmail.com', 'REG', 'gudiya52iwud', '1', '1', '2022-04-02 11:37:00'),
(25, 'tenjvi93613102@gmail.com', 'REG', 'harsh410zpm', '1', '1', '2022-04-02 11:37:01'),
(26, 'jaanus76121214@gmail.com', 'REG', 'fafad89qpq', '1', '1', '2022-04-02 11:37:01'),
(27, 'jaanus105713811@gmail.com', 'REG', 'paassr714zpm', '1', '1', '2022-04-02 11:37:01'),
(28, 'tenjvi8911295@gmail.com', 'REG', 'yogesh113iwud', '1', '1', '2022-04-02 11:37:01'),
(29, 'owl111261139@gmail.com', 'REG', 'elsisha914qpq', '1', '1', '2022-04-02 11:37:01'),
(30, 'paassr72314311@gmail.com', 'REG', 'lamnin72iwud', '1', '1', '2022-04-02 11:37:01'),
(31, 'vyom519686@gmail.com', 'REG', 'paassr35powbiq', '1', '1', '2022-04-02 11:37:01'),
(32, 'owl211151510@gmail.com', 'REG', 'chandu148iwud', '1', '1', '2022-04-02 11:37:02'),
(33, 'kunal14210121010@gmail.com', 'REG', 'aakanksha57qpod', '1', '1', '2022-04-02 11:37:02'),
(34, 'zorion122121233@gmail.com', 'REG', 'nainan137own', '1', '1', '2022-04-02 11:37:02'),
(35, 'elsisha9515561@gmail.com', 'REG', 'vyom1310dfa', '1', '1', '2022-04-02 11:37:02'),
(36, 'aakanksha1171452@gmail.com', 'REG', 'ishat131qpod', '1', '1', '2022-04-02 11:37:02'),
(37, 'harsh28815312@gmail.com', 'REG', 'jaanus312qod', '1', '1', '2022-04-02 11:37:02'),
(38, 'tenjvi879716@gmail.com', 'REG', 'chandu53powbiq', '1', '1', '2022-04-02 11:37:03'),
(39, 'diines31462713@gmail.com', 'REG', 'bhavik910iwud', '1', '1', '2022-04-02 11:37:03'),
(40, 'vyom98111314@gmail.com', 'REG', 'ishat31doif', '1', '1', '2022-04-02 11:37:03'),
(41, 'bhavik9481253@gmail.com', 'REG', 'elsisha82qpod', '1', '1', '2022-04-02 11:37:03'),
(42, 'diines14625155@gmail.com', 'REG', 'harsh811zpm', '1', '1', '2022-04-02 11:37:58'),
(43, 'fafad24142128@gmail.com', 'REG', 'paassr61iwud', '1', '1', '2022-04-02 11:38:03'),
(44, 'wrjoterj21117413@gmail.com', 'REG', 'rajs614qpod', '1', '1', '2022-04-02 11:38:03'),
(45, 'diines84311129@gmail.com', 'REG', 'rajs84qod', '1', '1', '2022-04-02 11:38:03'),
(46, 'shyam410131213@gmail.com', 'REG', 'elsisha1514iwud', '1', '1', '2022-04-02 11:38:03'),
(47, 'yogesh45151439@gmail.com', 'REG', 'rajs117dd', '1', '1', '2022-04-02 11:38:03'),
(48, 'xagqu131324138@gmail.com', 'REG', 'ishat77dfa', '1', '1', '2022-04-02 11:38:03'),
(49, 'vyom1571214310@gmail.com', 'REG', 'gudiya315powbiq', '1', '1', '2022-04-02 11:38:04'),
(50, 'shyam10123318@gmail.com', 'REG', 'elsisha91qod', '1', '1', '2022-04-02 11:38:04'),
(51, 'fafad91131613@gmail.com', 'REG', 'elsisha711aq', '1', '1', '2022-04-02 11:38:04'),
(52, 'lamnin141565115@gmail.com', 'REG', 'bhavik215qpod', '1', '1', '2022-04-02 11:38:04'),
(53, 'tenjvi741147@gmail.com', 'REG', 'bhavik1011zpm', '1', '1', '2022-04-02 11:38:04'),
(54, 'chandu384741@gmail.com', 'REG', 'shyam11own', '1', '1', '2022-04-02 11:38:04'),
(55, 'elsisha62511116@gmail.com', 'REG', 'paassr114doif', '1', '1', '2022-04-02 11:38:04'),
(56, 'xagqu141413118@gmail.com', 'REG', 'paassr116iwud', '1', '1', '2022-04-02 11:38:04'),
(57, 'zorion1431241010@gmail.com', 'REG', 'tenjvi51iwud', '1', '1', '2022-04-02 11:38:05'),
(58, 'fafad121128514@gmail.com', 'REG', 'aakanksha17qpod', '1', '1', '2022-04-02 11:38:05'),
(59, 'aakanksha41075107@gmail.com', 'REG', 'kunal72own', '1', '1', '2022-04-02 11:38:05'),
(60, 'chandu9571315@gmail.com', 'REG', 'jaanus83own', '1', '1', '2022-04-02 11:38:05'),
(61, 'aakanksha671014411@gmail.com', 'REG', 'mera102dfa', '1', '1', '2022-04-02 11:38:05'),
(62, 'shyamadesara7911@gmail.comddd', 'REG', 'admin1', '1', '1', '2022-04-03 13:57:46'),
(63, 'qqqqq@qq.bb', 'REG', 'admin1', '1', '1', '2022-04-03 13:58:34'),
(64, 'qqqqq@qqs.bb', 'REG', 'admin1', '1', '1', '2022-04-03 14:01:51'),
(65, 'qwwq@qq.qqq', 'REG', 'admin1', '1', '1', '2022-04-03 14:12:16'),
(66, 'Aaa@11.nm', 'REG', 'admin1', '1', '1', '2022-04-03 17:12:05');

-- --------------------------------------------------------

--
-- Table structure for table `lo_tblprofileuser`
--

CREATE TABLE `lo_tblprofileuser` (
  `id` mediumint(10) UNSIGNED NOT NULL,
  `user_id` mediumint(10) UNSIGNED NOT NULL,
  `profile_userName` varchar(20) NOT NULL,
  `jobS_resume` varchar(255) DEFAULT NULL,
  `jobS_occupation` varchar(50) DEFAULT NULL,
  `jobS_exp` mediumint(20) DEFAULT NULL,
  `category_id` mediumint(10) UNSIGNED DEFAULT NULL,
  `org_name` varchar(20) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lo_tblprofileuser`
--

INSERT INTO `lo_tblprofileuser` (`id`, `user_id`, `profile_userName`, `jobS_resume`, `jobS_occupation`, `jobS_exp`, `category_id`, `org_name`, `date_created`, `date_updated`) VALUES
(1, 2, 'rajs1231115414qpq', NULL, 'CEO', NULL, NULL, 'Google', '2022-04-02 11:31:04', '2022-04-02 12:12:17'),
(3, 3, 'mera2961549iwud', NULL, '', NULL, NULL, NULL, '2022-04-02 11:32:30', '2022-04-03 17:00:54'),
(4, 4, 'qorano13433214qpod', NULL, '', NULL, NULL, NULL, '2022-04-02 11:32:30', '2022-04-03 17:00:16'),
(5, 1, 'xagqu14212564doif', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:32:30', '2022-04-03 21:46:03'),
(6, 6, 'urvi2212356dd', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:32:31', '2022-04-02 11:32:31'),
(7, 7, 'qorano611410710dfa', NULL, 'WebDeveloper', NULL, NULL, NULL, '2022-04-02 11:32:31', '2022-04-04 02:32:50'),
(8, 8, 'xagqu148121296qod', NULL, '', NULL, NULL, NULL, '2022-04-02 11:32:31', '2022-04-03 17:06:37'),
(9, 9, 'vyom101313778qod', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:32:31', '2022-04-02 11:32:31'),
(10, 10, 'fafad14215364qod', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:32:31', '2022-04-02 11:32:31'),
(11, 11, 'nainan9871054qod', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:32:31', '2022-04-02 11:32:31'),
(12, 12, 'fafad3121510415doif', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:32:31', '2022-04-02 11:32:31'),
(13, 13, 'owl11151471014iwud', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:32:31', '2022-04-02 11:32:31'),
(14, 14, 'aakanksha105141097po', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:32:31', '2022-04-02 11:32:31'),
(15, 15, 'owl61314636own', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:32:31', '2022-04-02 11:32:31'),
(16, 16, 'aakanksha5171913dd', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:32:32', '2022-04-02 11:32:32'),
(17, 17, 'kunal1714925qpod', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:32:32', '2022-04-02 11:32:32'),
(18, 18, 'harsh131372158qpq', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:32:32', '2022-04-02 11:32:32'),
(19, 19, 'jaanus62311211qpq', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:32:32', '2022-04-02 11:32:32'),
(20, 20, 'qorano101513141413ow', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:32:32', '2022-04-02 11:32:32'),
(21, 21, 'rajs1337722iwud', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:32:32', '2022-04-02 11:32:32'),
(23, 22, 'rajs21161434dfa', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:37:00', '2022-04-02 11:37:00'),
(24, 23, 'elsisha8713887dfa', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:37:01', '2022-04-02 11:37:01'),
(25, 24, 'vyom1127101114own', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:37:01', '2022-04-02 11:37:01'),
(26, 25, 'jaanus101515141512aq', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:37:01', '2022-04-02 11:37:01'),
(27, 26, 'wrjoterj10418134dd', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:37:01', '2022-04-02 11:37:01'),
(28, 27, 'jaanus81022118aq', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:37:01', '2022-04-02 11:37:01'),
(29, 28, 'qorano117111248powbi', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:37:01', '2022-04-02 11:37:01'),
(30, 29, 'tenjvi12799128dfa', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:37:01', '2022-04-02 11:37:01'),
(31, 30, 'jaanus9325411dd', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:37:01', '2022-04-02 11:37:01'),
(32, 31, 'kunal812610911own', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:37:02', '2022-04-02 11:37:02'),
(33, 32, 'yogesh57510413zpm', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:37:02', '2022-04-02 11:37:02'),
(34, 33, 'gudiya213111478powbi', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:37:02', '2022-04-02 11:37:02'),
(35, 34, 'ishat107148156qpq', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:37:02', '2022-04-02 11:37:02'),
(36, 35, 'jaanus8158111214qpod', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:37:02', '2022-04-02 11:37:02'),
(37, 36, 'chandu2104141112own', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:37:03', '2022-04-02 11:37:03'),
(38, 37, 'tenjvi741371213qpod', NULL, '', NULL, NULL, NULL, '2022-04-02 11:37:03', '2022-04-03 17:09:46'),
(39, 38, 'xagqu777131515powbiq', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:37:03', '2022-04-02 11:37:03'),
(40, 39, 'nainan121110691qpq', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:37:03', '2022-04-02 11:37:03'),
(41, 40, 'paassr96104103zpm', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:37:03', '2022-04-02 11:37:03'),
(43, 41, 'gudiya1261131015qpq', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:38:03', '2022-04-02 11:38:03'),
(44, 42, 'mera7263110qpod', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:38:03', '2022-04-02 11:38:03'),
(45, 43, 'zorion331315611qod', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:38:03', '2022-04-02 11:38:03'),
(46, 44, 'yogesh713212123qpq', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:38:03', '2022-04-02 11:38:03'),
(47, 45, 'shyam9341523qpq', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:38:03', '2022-04-02 11:38:03'),
(48, 46, 'chandu10974107iwud', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:38:04', '2022-04-02 11:38:04'),
(49, 47, 'aakanksha72148149qpq', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:38:04', '2022-04-02 11:38:04'),
(50, 48, 'wrjoterj1071411116dd', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:38:04', '2022-04-02 11:38:04'),
(51, 49, 'zorion56148614iwud', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:38:04', '2022-04-02 11:38:04'),
(52, 50, 'urvi5137212doif', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:38:04', '2022-04-02 11:38:04'),
(53, 51, 'mera121121145qpod', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:38:04', '2022-04-02 11:38:04'),
(54, 52, 'owl10187513powbiq', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:38:04', '2022-04-02 11:38:04'),
(55, 53, 'qorano2361154dd', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:38:04', '2022-04-02 11:38:04'),
(56, 54, 'qorano1236136aq', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:38:05', '2022-04-02 11:38:05'),
(57, 55, 'jaanus12271527dfa', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:38:05', '2022-04-02 11:38:05'),
(58, 56, 'nainan6126641dfa', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:38:05', '2022-04-02 11:38:05'),
(59, 57, 'harsh10255105zpm', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:38:05', '2022-04-02 11:38:05'),
(60, 58, 'lamnin149211211dd', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:38:05', '2022-04-02 11:38:05'),
(61, 59, 'wrjoterj531310152qod', NULL, NULL, NULL, NULL, NULL, '2022-04-02 11:38:05', '2022-04-02 11:38:05'),
(62, 62, 'CXiCqYyrsX', 'NULL', 'dfds', 0, NULL, 'ffa', '2022-04-03 13:57:45', '2022-04-03 13:57:45'),
(63, 63, 'yosjVNmUGF', 'NULL', 'fa', 4, NULL, '', '2022-04-03 13:58:33', '2022-04-03 13:58:33'),
(64, 64, 'czrPSrGyLB', 'NULL', 'fa', 4, NULL, '', '2022-04-03 14:01:51', '2022-04-03 14:01:51'),
(65, 65, 'RgzPqDzfSL', 'NULL', '555', 5, NULL, '', '2022-04-03 14:12:16', '2022-04-03 14:12:16'),
(66, 66, 'VmdNBxgPVF', 'NULL', 'web', 2, NULL, '', '2022-04-03 17:12:04', '2022-04-03 17:12:04');

-- --------------------------------------------------------

--
-- Table structure for table `lo_tblreports`
--

CREATE TABLE `lo_tblreports` (
  `id` mediumint(10) UNSIGNED NOT NULL,
  `user_id` mediumint(10) UNSIGNED NOT NULL,
  `job_id` mediumint(10) UNSIGNED NOT NULL,
  `report_title` varchar(50) DEFAULT NULL,
  `report_desc` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lo_tblreports`
--

INSERT INTO `lo_tblreports` (`id`, `user_id`, `job_id`, `report_title`, `report_desc`, `date_created`, `date_updated`) VALUES
(1, 7, 5, 'Spam', 'dsada', '2022-04-03 18:04:46', '2022-04-03 18:04:46'),
(2, 7, 4, 'Sexual Content', 'faffas', '2022-04-03 18:21:03', '2022-04-03 18:21:03');

-- --------------------------------------------------------

--
-- Table structure for table `lo_tblusers`
--

CREATE TABLE `lo_tblusers` (
  `id` mediumint(10) UNSIGNED NOT NULL,
  `user_fname` varchar(20) NOT NULL,
  `user_lname` varchar(20) NOT NULL,
  `user_email` varchar(150) NOT NULL,
  `user_contactNumber` bigint(10) UNSIGNED NOT NULL,
  `user_dob` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_country` varchar(20) DEFAULT NULL,
  `user_state` varchar(30) DEFAULT NULL,
  `user_city` varchar(20) DEFAULT NULL,
  `user_address` varchar(100) DEFAULT NULL,
  `user_photo` varchar(200) DEFAULT NULL,
  `user_password` varchar(32) DEFAULT NULL,
  `user_gender` enum('M','F','N') DEFAULT NULL,
  `user_type` enum('A','O','J') NOT NULL DEFAULT 'J',
  `is_live` enum('Y','N') NOT NULL DEFAULT 'N',
  `is_deleted` enum('Y','N') NOT NULL DEFAULT 'N',
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lo_tblusers`
--

INSERT INTO `lo_tblusers` (`id`, `user_fname`, `user_lname`, `user_email`, `user_contactNumber`, `user_dob`, `user_country`, `user_state`, `user_city`, `user_address`, `user_photo`, `user_password`, `user_gender`, `user_type`, `is_live`, `is_deleted`, `date_created`, `date_updated`) VALUES
(1, 'shyam', 'adesara', 'admin@admin.com', 8247115829, '2022-04-04 05:29:55', NULL, NULL, NULL, NULL, 'default.png', '25f9e794323b453885f5181f1b624d0b', NULL, 'A', 'Y', 'N', '2022-04-02 11:31:03', '2022-04-04 05:29:55'),
(2, 'Sundar', 'Pichai', 'mera131549911@gmail.com', 9876543210, '2022-04-04 05:29:44', 'Equatorial Guinea', 'Centro Sur Province', NULL, 'Heerere', 'default.png', '25f9e794323b453885f5181f1b624d0b', 'M', 'O', 'N', 'N', '2022-04-02 11:31:41', '2022-04-04 05:29:44'),
(3, 'neww', 'qpod10269711', 'lamnin1251159@gmail.com', 2808509842, '2022-04-04 03:16:45', 'Belarus', 'Brest Region', NULL, NULL, 'default.png', '25f9e794323b453885f5181f1b624d0b', 'F', 'O', 'Y', 'Y', '2022-04-02 11:32:30', '2022-04-04 03:16:45'),
(4, 'aq13879106', 'qpq1729610', 'gudiya61565125@gmail.com', 5373097476, '2022-04-03 17:00:16', 'Angola', 'Cunene', NULL, NULL, 'default.png', '25f9e794323b453885f5181f1b624d0b', 'F', 'O', 'Y', 'N', '2022-04-02 11:32:30', '2022-04-03 17:00:16'),
(5, 'own275151110', 'qpod131189105', 'diines123691411@gmail.com', 5672987347, '2022-04-02 11:40:47', NULL, NULL, NULL, NULL, 'default.png', '25f9e794323b453885f5181f1b624d0b', NULL, 'O', 'Y', 'N', '2022-04-02 11:32:30', '2022-04-02 11:40:47'),
(6, 'dfa71559214', 'zpm15718911', 'jaanus12841512@gmail.com', 1246472363, '2022-04-02 11:40:47', NULL, NULL, NULL, NULL, 'default.png', '25f9e794323b453885f5181f1b624d0b', NULL, 'O', 'Y', 'N', '2022-04-02 11:32:30', '2022-04-02 11:40:47'),
(7, 'Harshgg', 'Aaa', 'harsh1017631@gmail.com', 8888555000, '2022-04-04 02:33:13', 'Barbados', 'Christ Church', NULL, NULL, 'default.png', '25f9e794323b453885f5181f1b624d0b', 'F', 'J', 'N', 'N', '2022-04-02 11:32:31', '2022-04-04 02:33:13'),
(8, 'HHfd', 'doif137146814', 'urvi151151332@gmail.com', 3919704397, '2022-04-03 17:10:27', 'Anguilla', 'fa', NULL, NULL, 'default.png', '25f9e794323b453885f5181f1b624d0b', 'F', 'J', 'Y', 'N', '2022-04-02 11:32:31', '2022-04-03 17:10:27'),
(9, 'zpm63911814', 'powbiq8881214', 'wrjoterj673541@gmail.com', 6027741079, '2022-04-02 11:40:47', NULL, NULL, NULL, NULL, 'default.png', '25f9e794323b453885f5181f1b624d0b', NULL, 'J', 'Y', 'N', '2022-04-02 11:32:31', '2022-04-02 11:40:47'),
(10, 'powbiq1442101510', 'iwud10613583', 'urvi6101414411@gmail.com', 9804630883, '2022-04-02 11:40:47', NULL, NULL, NULL, NULL, 'default.png', '25f9e794323b453885f5181f1b624d0b', NULL, 'J', 'N', 'N', '2022-04-02 11:32:31', '2022-04-02 11:40:47'),
(11, 'dd241310510', 'powbiq6765610', 'fafad3310282@gmail.com', 9207410226, '2022-04-02 11:40:47', NULL, NULL, NULL, NULL, 'default.png', '25f9e794323b453885f5181f1b624d0b', NULL, 'O', 'Y', 'N', '2022-04-02 11:32:31', '2022-04-02 11:40:47'),
(12, 'doif1241481010', 'qpq8396614', 'ishat215941312@gmail.com', 7780347705, '2022-04-02 11:40:47', NULL, NULL, NULL, NULL, 'default.png', '25f9e794323b453885f5181f1b624d0b', NULL, 'O', 'Y', 'N', '2022-04-02 11:32:31', '2022-04-02 11:40:47'),
(13, 'qpod2101181511', 'dfa771512148', 'elsisha4155615@gmail.com', 8769891453, '2022-04-02 11:40:47', NULL, NULL, NULL, NULL, 'default.png', '25f9e794323b453885f5181f1b624d0b', NULL, 'J', 'N', 'N', '2022-04-02 11:32:31', '2022-04-02 11:40:47'),
(14, 'powbiq12277212', 'aq51564811', 'chandu2115476@gmail.com', 7890854736, '2022-04-02 11:40:47', NULL, NULL, NULL, NULL, 'default.png', '25f9e794323b453885f5181f1b624d0b', NULL, 'O', 'Y', 'N', '2022-04-02 11:32:31', '2022-04-02 11:40:47'),
(15, 'dfa101714410', 'qpod688388', 'paassr733183@gmail.com', 5348483307, '2022-04-02 11:40:47', NULL, NULL, NULL, NULL, 'default.png', '25f9e794323b453885f5181f1b624d0b', NULL, 'O', 'Y', 'N', '2022-04-02 11:32:31', '2022-04-02 11:40:47'),
(16, 'zpm525659', 'aq681011154', 'paassr124751213@gmail.com', 6615884770, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', '13d45337ac0b77a409ced70c5aa84ad9', NULL, 'J', 'Y', 'N', '2022-04-02 11:32:31', '2022-04-02 11:32:31'),
(17, 'own414112615', 'powbiq10123826', 'fafad1762715@gmail.com', 8763065923, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', 'a5d1c57fd43c94e4e9775de58d93ed0a', NULL, 'J', 'Y', 'N', '2022-04-02 11:32:32', '2022-04-02 11:32:32'),
(18, 'doif1413101067', 'doif7251533', 'zorion239121010@gmail.com', 6230507768, '2022-04-04 03:21:30', NULL, NULL, NULL, NULL, 'default.png', '8716d1f66ffead97989e1aa36e0dff12', NULL, 'J', 'N', 'Y', '2022-04-02 11:32:32', '2022-04-04 03:21:30'),
(19, 'qpq10761213', 'own14126473', 'zorion102211010@gmail.com', 9333518281, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', '3631d298aa9e645e223a30e9e63072cf', NULL, 'O', 'N', 'N', '2022-04-02 11:32:32', '2022-04-02 11:32:32'),
(20, 'doif914612102', 'doif14142762', 'rajs143610911@gmail.com', 6032235131, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', '30663ac99f29248df23540c8397093b8', NULL, 'O', 'N', 'N', '2022-04-02 11:32:32', '2022-04-02 11:32:32'),
(21, 'doif3215651', 'qpod11486106', 'elsisha997644@gmail.com', 381893193, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', '9cf3001935c6faba2e95191417fd5ea5', NULL, 'O', 'N', 'N', '2022-04-02 11:32:32', '2022-04-02 11:32:32'),
(22, 'qod133413117', 'dfa91038141', 'ishat71545131@gmail.com', 3821361274, '2022-04-04 04:52:40', NULL, NULL, NULL, NULL, 'default.png', '5ced09edeb4aea82623602b20722fd7a', NULL, 'J', 'Y', 'Y', '2022-04-02 11:36:44', '2022-04-04 04:52:40'),
(23, 'qpq613914144', 'dfa1231022', 'bhavik810141414@gmail.com', 4560007886, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', '2004d2da0800d04c8ef531aac8a6ac4d', NULL, 'O', 'N', 'N', '2022-04-02 11:37:00', '2022-04-02 11:37:00'),
(24, 'qpq7373313', 'dd147811610', 'vyom2151111715@gmail.com', 7393891634, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', 'a0a6f8872abde30b4a83d38dbd01770c', NULL, 'O', 'N', 'N', '2022-04-02 11:37:01', '2022-04-02 11:37:01'),
(25, 'powbiq242141413', 'qpod10157111012', 'tenjvi93613102@gmail.com', 7501227551, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', '21527b7ac1fb41c2f6a4972327f65594', NULL, 'O', 'N', 'N', '2022-04-02 11:37:01', '2022-04-02 11:37:01'),
(26, 'aq5126951', 'dd61415914', 'jaanus76121214@gmail.com', 2617304282, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', 'e6e69ffc0fcb4bbc78b22d0d92005869', NULL, 'O', 'N', 'N', '2022-04-02 11:37:01', '2022-04-02 11:37:01'),
(27, 'powbiq9159429', 'powbiq8791574', 'jaanus105713811@gmail.com', 1529644966, '2022-04-03 14:36:20', NULL, NULL, NULL, NULL, 'client-3.jpg', '078c6fbbd670931c858115d94b33e5fb', NULL, 'O', 'Y', 'N', '2022-04-02 11:37:01', '2022-04-03 14:36:20'),
(28, 'powbiq13415138', 'doif12182119', 'tenjvi8911295@gmail.com', 6958445749, '2022-04-03 14:36:14', NULL, NULL, NULL, NULL, 'client-5.jpg', '35bda59e1a399717f75eb06200bcbfea', NULL, 'O', 'N', 'N', '2022-04-02 11:37:01', '2022-04-03 14:36:14'),
(29, 'qpq5310111215', 'aq125151013', 'owl111261139@gmail.com', 6522861932, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', '6f7f02b18b473652372ee94eb0c26d97', NULL, 'O', 'N', 'N', '2022-04-02 11:37:01', '2022-04-02 11:37:01'),
(30, 'qpq8389131', 'qod13242913', 'paassr72314311@gmail.com', 2903360857, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', '84c03183761d57e2e225177f81d50f1a', NULL, 'O', 'N', 'N', '2022-04-02 11:37:01', '2022-04-02 11:37:01'),
(31, 'powbiq152715113', 'dfa1381513215', 'vyom519686@gmail.com', 7052361720, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', 'f74069a0d92034ae2f74ea95759c7f6b', NULL, 'J', 'Y', 'N', '2022-04-02 11:37:01', '2022-04-02 11:37:01'),
(32, 'qpq813315', 'qpod118551', 'owl211151510@gmail.com', 3794741455, '2022-04-03 14:36:09', NULL, NULL, NULL, NULL, 'client-3.jpg', 'a8c7afb75ffd3d069c13572d51b50690', NULL, 'J', 'N', 'N', '2022-04-02 11:37:02', '2022-04-03 14:36:09'),
(33, 'own97111147', 'doif911311215', 'kunal14210121010@gmail.com', 7431369636, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', '91a9e6f174e50bc91fb88c7d913b9045', NULL, 'J', 'Y', 'N', '2022-04-02 11:37:02', '2022-04-02 11:37:02'),
(34, 'aq9283512', 'dfa91326117', 'zorion122121233@gmail.com', 356939047, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', '25126c26c4097a9a758b2d9c10abfa48', NULL, 'O', 'N', 'N', '2022-04-02 11:37:02', '2022-04-02 11:37:02'),
(35, 'powbiq14132385', 'iwud151065137', 'elsisha9515561@gmail.com', 6622687396, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', '580ed4555e9095ed71e30b9f4cbda8d3', NULL, 'O', 'N', 'N', '2022-04-02 11:37:02', '2022-04-02 11:37:02'),
(36, 'powbiq1213112126', 'iwud513134153', 'aakanksha1171452@gmail.com', 5717713315, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', '030cb984904eac98e14c887afd7e46bc', NULL, 'J', 'Y', 'N', '2022-04-02 11:37:02', '2022-04-02 11:37:02'),
(37, 'aaaa', 'iwud33136711', 'harsh28815312@gmail.com', 2985974138, '2022-04-03 17:09:46', NULL, NULL, NULL, NULL, 'client-4.jpg', 'cde4487bc4a00adaea790fb63d7a3729', 'F', 'J', 'Y', 'N', '2022-04-02 11:37:03', '2022-04-03 17:09:46'),
(38, 'zpm51511146', 'dfa14101314413', 'tenjvi879716@gmail.com', 2439425848, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', 'd1861674da8f1ccc675aa8d11692810f', NULL, 'J', 'N', 'N', '2022-04-02 11:37:03', '2022-04-02 11:37:03'),
(39, 'iwud141110226', 'aq14368515', 'diines31462713@gmail.com', 3264936147, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', '9356bd9ec4d451bcb5f699049ac5e4df', NULL, 'O', 'Y', 'N', '2022-04-02 11:37:03', '2022-04-02 11:37:03'),
(40, 'zpm213413119', 'zpm1212611157', 'vyom98111314@gmail.com', 1079715023, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', 'b028cd5aa2ad2bfe4676e60f38eec913', NULL, 'J', 'Y', 'N', '2022-04-02 11:37:03', '2022-04-02 11:37:03'),
(41, 'powbiq298141', 'qpod8116913', 'bhavik9481253@gmail.com', 3687499606, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', 'bf0b34e861fe16699f1505969b077f3c', NULL, 'J', 'N', 'N', '2022-04-02 11:37:03', '2022-04-02 11:37:03'),
(42, 'powbiq473101514', 'zpm991511913', 'diines14625155@gmail.com', 9139937487, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', '32df2673e0a4d5f5f373ef92a726c9e8', NULL, 'O', 'N', 'N', '2022-04-02 11:37:58', '2022-04-02 11:37:58'),
(43, 'own115146811', 'own15751227', 'fafad24142128@gmail.com', 8432702590, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', '20d97c1c8dfdcc40a9f990b96383eaf0', NULL, 'J', 'N', 'N', '2022-04-02 11:38:03', '2022-04-02 11:38:03'),
(44, 'powbiq1449725', 'doif46231110', 'wrjoterj21117413@gmail.com', 273042134, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', '9788cd9083e08ab9d9a511a69a0a25fd', NULL, 'J', 'Y', 'N', '2022-04-02 11:38:03', '2022-04-02 11:38:03'),
(45, 'qpod6136484', 'dd88111335', 'diines84311129@gmail.com', 9275581180, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', 'c50f24a0dc8e0ef8ad1c4f14ea77c10c', NULL, 'J', 'N', 'N', '2022-04-02 11:38:03', '2022-04-02 11:38:03'),
(46, 'aq832549', 'powbiq7935137', 'shyam410131213@gmail.com', 682280122, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', '5df687d3b391454b13c4fbecf68cec16', NULL, 'J', 'Y', 'N', '2022-04-02 11:38:03', '2022-04-02 11:38:03'),
(47, 'powbiq315711512', 'dd1177232', 'yogesh45151439@gmail.com', 7900860938, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', '61f4a0d1e682938a580a0191b949f834', NULL, 'J', 'N', 'N', '2022-04-02 11:38:03', '2022-04-02 11:38:03'),
(48, 'doif159134159', 'zpm921081315', 'xagqu131324138@gmail.com', 1265554699, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', 'eabcf4801dbd7a7d828c17e3c8ba4644', NULL, 'O', 'N', 'N', '2022-04-02 11:38:04', '2022-04-02 11:38:04'),
(49, 'qpq31274414', 'doif121014155', 'vyom1571214310@gmail.com', 6839368902, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', '798639ecc56f0335f69c71783d850401', NULL, 'O', 'Y', 'N', '2022-04-02 11:38:04', '2022-04-02 11:38:04'),
(50, 'dd112136812', 'iwud51461185', 'shyam10123318@gmail.com', 8509816115, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', '8f2e05facb1adc80ea06ed58d1602fef', NULL, 'J', 'N', 'N', '2022-04-02 11:38:04', '2022-04-02 11:38:04'),
(51, 'zpm3457112', 'qod5963154', 'fafad91131613@gmail.com', 70602333, '2022-04-03 14:35:15', NULL, NULL, NULL, NULL, 'client-1.jpg', '277e36a9da8861d50c95c59e70813ac2', NULL, 'J', 'Y', 'N', '2022-04-02 11:38:04', '2022-04-03 14:35:15'),
(52, 'qod1551311312', 'dd8134157', 'lamnin141565115@gmail.com', 7147254225, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', '9e1c22a2d5478a0c5930c4bb7f94b535', NULL, 'O', 'Y', 'N', '2022-04-02 11:38:04', '2022-04-02 11:38:04'),
(53, 'aq14142651', 'dfa1139214', 'tenjvi741147@gmail.com', 7079343204, '2022-04-03 14:35:31', NULL, NULL, NULL, NULL, 'client-2.jpg', 'f52912e92c18b7b3b15df2c8e85890f9', NULL, 'J', 'N', 'N', '2022-04-02 11:38:04', '2022-04-03 14:35:31'),
(54, 'qpod14366812', 'aq3571437', 'chandu384741@gmail.com', 5638583834, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', 'a14de7b67b828fd98d5af83a440b8aa4', NULL, 'O', 'N', 'N', '2022-04-02 11:38:04', '2022-04-02 11:38:04'),
(55, 'doif62124710', 'dfa921141212', 'elsisha62511116@gmail.com', 8341982781, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', '054642e20c02a3d5d16fa6bf529e06ea', NULL, 'O', 'Y', 'N', '2022-04-02 11:38:04', '2022-04-02 11:38:04'),
(56, 'own515914152', 'own31544154', 'xagqu141413118@gmail.com', 5308745113, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', 'c210ff6ae759d46df7a323f1d681acd2', NULL, 'J', 'Y', 'N', '2022-04-02 11:38:05', '2022-04-02 11:38:05'),
(57, 'dfa5910131', 'aq811912814', 'zorion1431241010@gmail.com', 4404112293, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', 'eac2e4bb2c36a84a0fd8bf041efe0020', NULL, 'J', 'Y', 'N', '2022-04-02 11:38:05', '2022-04-02 11:38:05'),
(58, 'iwud16136312', 'iwud718121214', 'fafad121128514@gmail.com', 2065512473, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', 'a42f9eaf8e21492b510c3e0ae25baf14', NULL, 'J', 'N', 'N', '2022-04-02 11:38:05', '2022-04-02 11:38:05'),
(59, 'qpq113311215', 'qod152761214', 'aakanksha41075107@gmail.com', 4195613710, '2022-04-03 14:35:44', NULL, NULL, NULL, NULL, 'client-3.jpg', '594e393ea7924c9d12cac5441d59408f', NULL, 'J', 'N', 'N', '2022-04-02 11:38:05', '2022-04-03 14:35:44'),
(60, 'qpq9512391', 'dfa382528', 'chandu9571315@gmail.com', 8427318251, '2022-04-03 14:35:37', NULL, NULL, NULL, NULL, 'client-1.jpg', '650058b6a4dc6563cc2038fbc6e9113a', NULL, 'J', 'Y', 'N', '2022-04-02 11:38:05', '2022-04-03 14:35:37'),
(61, 'zpm4327913', 'qpq1115251514', 'aakanksha671014411@gmail.com', 3715590273, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 'default.png', '8bbac0e32f08857523848df013bcc782', NULL, 'J', 'Y', 'N', '2022-04-02 11:38:05', '2022-04-02 11:38:05'),
(62, 'Shyam', 'fsdfsdfsd', 'shyamadesara7911@gmail.comddd', 1222333444, '2010-03-10 08:00:00', 'India', 'Gujarat', NULL, 'Hathikhanamainroad,opp:st.no:-3,&quot;butbhavanikrupa&quot;', NULL, '25f9e794323b453885f5181f1b624d0b', 'M', 'O', '', 'N', '2022-04-03 13:57:45', '2022-04-03 13:57:45'),
(63, 'Shyamddd', 'fafa', 'qqqqq@qq.bb', 9016077892, '2001-11-22 08:00:00', 'India', 'Gujarat', NULL, 'Hathikhanamainroad,opp:st.no:-3,&quot;butbhavanikrupa&quot;', NULL, '25f9e794323b453885f5181f1b624d0b', 'F', 'O', '', 'N', '2022-04-03 13:58:33', '2022-04-03 13:58:33'),
(64, 'Shyamddd', 'fafa', 'qqqqq@qqs.bb', 9016077892, '2022-04-03 14:35:48', 'India', 'Gujarat', NULL, 'Hathikhanamainroad,opp:st.no:-3,&quot;butbhavanikrupa&quot;', 'client-1.jpg', '25f9e794323b453885f5181f1b624d0b', 'F', 'O', '', 'N', '2022-04-03 14:01:51', '2022-04-03 14:35:48'),
(65, 'sss', 'dfa', 'qwwq@qq.qqq', 9999994444, '2010-03-10 08:00:00', 'Germany', 'Hamburg', NULL, 'fafaf', 'default.png', '3354045a397621cd92406f1f98cde292', 'M', 'J', '', 'N', '2022-04-03 14:12:16', '2022-04-03 14:12:16'),
(66, 'Aaa', 'dsa', 'Aaa@11.nm', 8890098214, '2022-04-03 17:21:02', 'Greece', 'BoeotiaRegionalUnit', NULL, 'dfsdfd', 'default.png', '25f9e794323b453885f5181f1b624d0b', 'N', 'J', '', 'N', '2022-04-03 17:12:04', '2022-04-03 17:21:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lo_tblapplier`
--
ALTER TABLE `lo_tblapplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lo_tblcategory`
--
ALTER TABLE `lo_tblcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lo_tblcomments`
--
ALTER TABLE `lo_tblcomments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_comment_id` (`user_id`),
  ADD KEY `fk_id_comment_jobid` (`job_id`);

--
-- Indexes for table `lo_tbljobs`
--
ALTER TABLE `lo_tbljobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_job_id` (`user_id`),
  ADD KEY `fk_id_job_catid` (`category_id`);

--
-- Indexes for table `lo_tblotp`
--
ALTER TABLE `lo_tblotp`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indexes for table `lo_tblprofileuser`
--
ALTER TABLE `lo_tblprofileuser`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `fk_id_catId` (`category_id`);

--
-- Indexes for table `lo_tblreports`
--
ALTER TABLE `lo_tblreports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_report_id` (`user_id`),
  ADD KEY `fk_id_reports_id` (`job_id`);

--
-- Indexes for table `lo_tblusers`
--
ALTER TABLE `lo_tblusers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lo_tblapplier`
--
ALTER TABLE `lo_tblapplier`
  MODIFY `id` mediumint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lo_tblcategory`
--
ALTER TABLE `lo_tblcategory`
  MODIFY `id` mediumint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `lo_tblcomments`
--
ALTER TABLE `lo_tblcomments`
  MODIFY `id` mediumint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lo_tbljobs`
--
ALTER TABLE `lo_tbljobs`
  MODIFY `id` mediumint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lo_tblotp`
--
ALTER TABLE `lo_tblotp`
  MODIFY `id` mediumint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `lo_tblprofileuser`
--
ALTER TABLE `lo_tblprofileuser`
  MODIFY `id` mediumint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `lo_tblreports`
--
ALTER TABLE `lo_tblreports`
  MODIFY `id` mediumint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lo_tblusers`
--
ALTER TABLE `lo_tblusers`
  MODIFY `id` mediumint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lo_tblapplier`
--
ALTER TABLE `lo_tblapplier`
  ADD CONSTRAINT `fk_apply_id_jobs_id` FOREIGN KEY (`job`) REFERENCES `lo_tbljobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_apply_id_report_id` FOREIGN KEY (`report`) REFERENCES `lo_tblreports` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_apply_id_user_id` FOREIGN KEY (`user_id`) REFERENCES `lo_tblusers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lo_tblcomments`
--
ALTER TABLE `lo_tblcomments`
  ADD CONSTRAINT `fk_id_comment_id` FOREIGN KEY (`user_id`) REFERENCES `lo_tblusers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_comment_jobid` FOREIGN KEY (`job_id`) REFERENCES `lo_tbljobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lo_tbljobs`
--
ALTER TABLE `lo_tbljobs`
  ADD CONSTRAINT `fk_id_job_catid` FOREIGN KEY (`category_id`) REFERENCES `lo_tblcategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_job_id` FOREIGN KEY (`user_id`) REFERENCES `lo_tblusers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lo_tblprofileuser`
--
ALTER TABLE `lo_tblprofileuser`
  ADD CONSTRAINT `fk_id_catId` FOREIGN KEY (`category_id`) REFERENCES `lo_tblcategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_profileUser` FOREIGN KEY (`user_id`) REFERENCES `lo_tblusers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lo_tblreports`
--
ALTER TABLE `lo_tblreports`
  ADD CONSTRAINT `fk_id_report_id` FOREIGN KEY (`user_id`) REFERENCES `lo_tblusers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_reports_id` FOREIGN KEY (`job_id`) REFERENCES `lo_tbljobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
