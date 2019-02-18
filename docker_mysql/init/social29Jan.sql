-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 29, 2019 at 11:56 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `social`
--

CREATE DATABASE IF NOT EXISTS social ;

USE social ;

-- --------------------------------------------------------

--
-- Table structure for table `avatars`
--

CREATE TABLE `avatars` (
  `id` bigint(20) NOT NULL,
  `asset` varchar(255) NOT NULL,
  `type` enum('USER','SYSTEM') NOT NULL DEFAULT 'SYSTEM',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ownerId` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `avatars`
--

INSERT INTO `avatars` (`id`, `asset`, `type`, `created`, `ownerId`) VALUES
(1, 'assets/images/avatars/avatar0001.png', 'SYSTEM', '2019-01-11 18:48:51', NULL),
(2, 'assets/images/avatars/avatar0002.png', 'SYSTEM', '2019-01-11 18:53:42', NULL),
(3, 'assets/images/avatars/avatar0003.png', 'SYSTEM', '2019-01-29 12:59:39', NULL),
(4, 'assets/images/avatars/avatar0004.png', 'SYSTEM', '2019-01-29 12:59:39', NULL),
(5, 'assets/images/avatars/avatar0005.png', 'SYSTEM', '2019-01-29 12:59:39', NULL),
(6, 'assets/images/avatars/avatar0006.png', 'SYSTEM', '2019-01-29 12:59:39', NULL),
(7, 'assets/images/avatars/avatar0007.png', 'SYSTEM', '2019-01-29 12:59:39', NULL),
(8, 'assets/images/avatars/avatar0008.png', 'SYSTEM', '2019-01-29 12:59:39', NULL),
(9, 'assets/images/avatars/avatar0009.png', 'SYSTEM', '2019-01-29 12:59:39', NULL),
(10, 'assets/images/avatars/avatar0010.png', 'SYSTEM', '2019-01-29 12:59:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `id` bigint(20) NOT NULL,
  `userId` bigint(20) NOT NULL,
  `friendId` bigint(20) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`id`, `userId`, `friendId`, `created`) VALUES
(1, 102, 103, '2019-01-29 10:48:47'),
(2, 103, 102, '2019-01-29 10:48:47'),
(3, 102, 104, '2019-01-29 10:48:47'),
(4, 104, 102, '2019-01-29 10:48:47'),
(5, 102, 105, '2019-01-29 10:48:47'),
(6, 105, 102, '2019-01-29 10:48:47'),
(7, 102, 106, '2019-01-29 10:48:47'),
(8, 106, 102, '2019-01-29 10:48:47'),
(9, 102, 107, '2019-01-29 10:48:47'),
(10, 107, 102, '2019-01-29 10:48:47'),
(11, 110, 115, '2019-01-29 10:48:47'),
(12, 115, 110, '2019-01-29 10:48:47'),
(13, 110, 105, '2019-01-29 10:48:47'),
(14, 105, 110, '2019-01-29 10:48:47'),
(15, 110, 108, '2019-01-29 10:50:25'),
(16, 108, 110, '2019-01-29 10:50:25'),
(17, 110, 106, '2019-01-29 10:51:39'),
(18, 106, 110, '2019-01-29 10:51:39'),
(19, 104, 112, '2019-01-29 11:27:44'),
(20, 112, 104, '2019-01-29 11:27:44'),
(21, 104, 119, '2019-01-29 11:32:02'),
(22, 119, 104, '2019-01-29 11:32:02');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` bigint(20) NOT NULL,
  `post_id` bigint(20) NOT NULL,
  `liked_by` bigint(20) NOT NULL,
  `like_type` enum('LIKE','LAUGH','CRY') DEFAULT 'LIKE',
  `created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `post_id`, `liked_by`, `like_type`, `created`) VALUES
(283, 81, 104, 'LIKE', '2019-01-25 13:34:19'),
(284, 219, 104, 'LIKE', '2019-01-25 17:28:00'),
(293, 29, 102, 'LIKE', '2019-01-25 23:34:09');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) NOT NULL,
  `body` text NOT NULL,
  `posted_by` bigint(20) NOT NULL,
  `posted_to` bigint(20) DEFAULT NULL,
  `post_root` bigint(20) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hidden` tinyint(1) NOT NULL DEFAULT '0',
  `privacy` enum('owner','friends','public') NOT NULL DEFAULT 'public',
  `type` enum('post','chat') NOT NULL DEFAULT 'post'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `body`, `posted_by`, `posted_to`, `post_root`, `created`, `hidden`, `privacy`, `type`) VALUES
(15, 'aaaa', 102, NULL, NULL, '2019-01-18 07:29:43', 0, 'public', 'post'),
(16, 'aaaa', 102, NULL, NULL, '2019-01-18 07:30:29', 0, 'public', 'post'),
(17, 'aaaa', 102, NULL, NULL, '2019-01-18 07:30:32', 0, 'public', 'post'),
(18, 'aaaa', 102, NULL, NULL, '2019-01-18 07:32:16', 0, 'public', 'post'),
(19, 'aaaa', 102, NULL, NULL, '2019-01-18 07:32:27', 0, 'public', 'post'),
(20, 'hello', 102, NULL, NULL, '2019-01-18 07:47:13', 0, 'public', 'post'),
(21, 'hello', 102, NULL, NULL, '2019-01-18 07:50:15', 0, 'public', 'post'),
(22, 'hello', 102, NULL, NULL, '2019-01-18 07:52:08', 0, 'public', 'post'),
(23, 'What do you think?\r\n', 102, NULL, NULL, '2019-01-18 07:52:20', 0, 'public', 'post'),
(24, 'What do you think?\r\n', 102, NULL, NULL, '2019-01-18 07:53:31', 0, 'public', 'post'),
(25, 'What do you think?\r\n', 102, NULL, NULL, '2019-01-18 07:59:14', 0, 'public', 'post'),
(26, 'xxx', 102, NULL, NULL, '2019-01-18 07:59:18', 0, 'public', 'post'),
(27, 'aaaa', 102, NULL, NULL, '2019-01-18 07:59:22', 0, 'public', 'post'),
(28, 'hello test 3', 102, NULL, NULL, '2019-01-18 08:01:40', 0, 'public', 'post'),
(29, 'Hello test4', 102, NULL, NULL, '2019-01-18 08:02:04', 0, 'public', 'post'),
(30, 'aaa', 102, NULL, NULL, '2019-01-18 08:30:03', 0, 'public', 'post'),
(31, 'aaa', 102, NULL, NULL, '2019-01-18 08:40:30', 0, 'public', 'post'),
(32, 'aaa', 102, NULL, NULL, '2019-01-18 08:43:45', 0, 'public', 'post'),
(33, '', 102, NULL, NULL, '2019-01-18 11:26:27', 0, 'public', 'post'),
(34, '', 102, NULL, NULL, '2019-01-18 11:34:17', 0, 'public', 'post'),
(35, 'I\'m going to help you', 102, NULL, NULL, '2019-01-18 11:34:32', 0, 'public', 'post'),
(36, 'I\'m not going to say', 102, NULL, NULL, '2019-01-18 11:34:39', 0, 'public', 'post'),
(37, ' I am not going to say', 102, NULL, NULL, '2019-01-18 11:34:51', 0, 'public', 'post'),
(38, 'aaa', 102, NULL, NULL, '2019-01-18 11:35:44', 0, 'public', 'post'),
(39, 'aaa', 102, NULL, NULL, '2019-01-18 11:48:06', 0, 'public', 'post'),
(40, 'x', 102, NULL, NULL, '2019-01-18 11:58:41', 0, 'public', 'post'),
(41, 'x', 102, NULL, NULL, '2019-01-18 11:58:58', 0, 'public', 'post'),
(42, 'x', 102, NULL, NULL, '2019-01-18 11:59:54', 0, 'public', 'post'),
(43, 'HELLO WORLD', 102, NULL, NULL, '2019-01-18 12:01:25', 0, 'public', 'post'),
(44, 'I\'m at my end\'s tether!', 102, NULL, NULL, '2019-01-18 12:02:03', 0, 'public', 'post'),
(45, 'I\'m at my end\'s tether!', 102, NULL, NULL, '2019-01-18 12:03:54', 0, 'public', 'post'),
(46, '103 - my post', 103, NULL, NULL, '2019-01-18 13:32:01', 0, 'public', 'post'),
(47, 'Nhoj\'s post', 103, NULL, NULL, '2019-01-18 13:59:04', 0, 'public', 'post'),
(48, 'Nhoj\'s post', 103, NULL, NULL, '2019-01-18 13:59:26', 0, 'public', 'post'),
(49, 'Nhoj\'s post', 103, NULL, NULL, '2019-01-18 13:59:37', 0, 'public', 'post'),
(50, 'Nhoj\'s post', 103, NULL, NULL, '2019-01-18 14:02:08', 0, 'public', 'post'),
(51, 'xxx', 103, NULL, NULL, '2019-01-18 14:02:17', 0, 'public', 'post'),
(52, 'xxx', 103, NULL, NULL, '2019-01-18 14:04:01', 0, 'public', 'post'),
(53, 'xxxx', 103, NULL, NULL, '2019-01-18 14:04:05', 0, 'public', 'post'),
(54, 'qqqq', 103, NULL, NULL, '2019-01-18 14:04:10', 0, 'public', 'post'),
(55, 'xxx', 103, NULL, NULL, '2019-01-18 14:27:53', 0, 'public', 'post'),
(56, 'xxx', 103, NULL, NULL, '2019-01-18 14:28:41', 0, 'public', 'post'),
(57, 'xxx', 103, NULL, NULL, '2019-01-18 14:29:00', 0, 'public', 'post'),
(58, 'xxx', 103, NULL, NULL, '2019-01-18 14:29:12', 0, 'public', 'post'),
(59, 'xxx', 103, NULL, NULL, '2019-01-18 14:29:18', 0, 'public', 'post'),
(60, 'xxx', 103, NULL, NULL, '2019-01-18 14:30:03', 0, 'public', 'post'),
(61, 'xxx', 103, NULL, NULL, '2019-01-18 14:30:18', 0, 'public', 'post'),
(74, 'hmmm - you\'re a gumby', 102, NULL, NULL, '2019-01-18 19:28:15', 0, 'public', 'post'),
(75, 'This is something new to say', 102, NULL, NULL, '2019-01-18 19:30:09', 0, 'public', 'post'),
(76, 'This is something new to say', 102, NULL, NULL, '2019-01-18 19:34:16', 0, 'public', 'post'),
(77, 'This is something new to say', 102, NULL, NULL, '2019-01-18 19:42:31', 0, 'public', 'post'),
(78, 'xxx\r\n', 102, NULL, NULL, '2019-01-18 20:06:38', 0, 'public', 'post'),
(79, 'xxx\r\n', 102, NULL, NULL, '2019-01-18 20:07:11', 0, 'public', 'post'),
(80, '1\r\n', 102, NULL, NULL, '2019-01-18 20:30:34', 0, 'public', 'post'),
(81, '2', 102, NULL, NULL, '2019-01-18 20:30:36', 0, 'public', 'post'),
(82, '3', 102, NULL, NULL, '2019-01-18 20:30:37', 0, 'public', 'post'),
(83, '3', 102, NULL, NULL, '2019-01-18 20:30:41', 0, 'public', 'post'),
(84, '4', 102, NULL, NULL, '2019-01-18 20:30:43', 0, 'public', 'post'),
(85, '5', 102, NULL, NULL, '2019-01-18 20:30:45', 0, 'public', 'post'),
(86, '6', 102, NULL, NULL, '2019-01-18 20:30:48', 0, 'public', 'post'),
(87, '7', 102, NULL, NULL, '2019-01-18 20:30:52', 0, 'public', 'post'),
(120, '7', 102, NULL, NULL, '2019-01-18 20:32:04', 0, 'public', 'post'),
(218, 'Two is a good number!', 104, NULL, 81, '2019-01-25 13:34:30', 0, 'public', 'post'),
(219, 'Something needs to be said!', 104, NULL, NULL, '2019-01-25 15:05:06', 1, 'public', 'post'),
(220, 'Something else', 104, NULL, 219, '2019-01-25 17:28:29', 0, 'public', 'post'),
(221, 'Say something nice!', 104, NULL, NULL, '2019-01-25 17:28:50', 1, 'public', 'post'),
(222, '7 what? Are you on drugs?', 104, NULL, 87, '2019-01-25 18:43:08', 0, 'public', 'post'),
(223, 'What\'s going on?\r\n', 104, NULL, NULL, '2019-01-25 23:07:27', 1, 'public', 'post'),
(224, 'Hello', 104, NULL, NULL, '2019-01-25 23:11:38', 1, 'public', 'post'),
(225, 'I want to be honest!\r\n', 102, NULL, NULL, '2019-01-25 23:25:00', 0, 'public', 'post'),
(226, 'Hi Paul - I hope you are OK', 102, NULL, 224, '2019-01-25 23:36:42', 0, 'public', 'post'),
(227, 'Team effort is needed!', 103, NULL, NULL, '2019-01-26 00:07:00', 0, 'public', 'post'),
(228, 'He should be - He is paid well enough!', 103, NULL, 224, '2019-01-26 00:09:52', 0, 'public', 'post'),
(229, 'Come on Alan - you Have to be joking. Surely?', 104, NULL, NULL, '2019-01-26 00:11:24', 1, 'public', 'post'),
(230, 'I\'m not joking. Deadly serious, mate.', 103, NULL, NULL, '2019-01-26 00:13:30', 0, 'public', 'post'),
(231, 'xx', 104, 105, NULL, '2019-01-28 15:53:12', 1, 'public', 'post'),
(232, 'Please work me old mate', 104, 105, NULL, '2019-01-28 15:54:10', 1, 'public', 'post'),
(233, 'I am working', 104, 105, NULL, '2019-01-28 15:55:04', 1, 'public', 'post'),
(240, 'ddd', 104, 104, NULL, '2019-01-28 21:26:30', 1, 'public', 'post'),
(241, 'Man', 104, 104, NULL, '2019-01-28 22:36:42', 1, 'public', 'post'),
(242, 'xxx', 104, NULL, NULL, '2019-01-28 22:53:58', 1, 'public', 'post'),
(243, 'xxx', 104, NULL, NULL, '2019-01-28 22:54:35', 1, 'public', 'post'),
(244, 's;lslss', 104, 104, NULL, '2019-01-29 09:50:49', 1, 'public', 'post');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` bigint(20) NOT NULL,
  `requestorId` bigint(20) NOT NULL,
  `requesteeId` bigint(20) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `requestorId`, `requesteeId`, `created`) VALUES
(18, 102, 103, '2019-01-26 11:19:57'),
(32, 102, 104, '2019-01-27 15:21:50'),
(33, 103, 104, '2019-01-27 15:33:44'),
(34, 105, 104, '2019-01-27 16:32:18'),
(35, 106, 104, '2019-01-27 19:28:22'),
(36, 107, 104, '2019-01-27 19:29:37'),
(37, 108, 104, '2019-01-27 19:37:18'),
(38, 109, 104, '2019-01-27 19:39:55'),
(39, 110, 104, '2019-01-27 19:41:06'),
(40, 111, 104, '2019-01-27 19:41:57'),
(42, 113, 104, '2019-01-27 19:46:02'),
(43, 114, 104, '2019-01-27 19:46:41'),
(44, 115, 104, '2019-01-27 19:51:16'),
(45, 116, 104, '2019-01-27 19:53:47'),
(46, 117, 104, '2019-01-27 19:58:58'),
(47, 118, 104, '2019-01-27 20:03:47'),
(49, 120, 104, '2019-01-27 20:46:20'),
(50, 121, 104, '2019-01-27 20:48:07'),
(51, 122, 104, '2019-01-27 20:50:06'),
(52, 123, 104, '2019-01-27 20:52:11'),
(53, 124, 104, '2019-01-27 20:54:23'),
(54, 125, 104, '2019-01-27 21:00:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `firstname` varchar(128) NOT NULL,
  `surname` varchar(128) NOT NULL,
  `email` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `regdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `resetkey` varchar(255) DEFAULT NULL,
  `resettime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `avatarId` bigint(20) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `surname`, `email`, `password`, `regdate`, `active`, `resetkey`, `resettime`, `avatarId`) VALUES
(102, 'John', 'Wils', 'johnnyw66@gmail.com', 'c170524ac382682893d8e3511969900ca831a28a264ff8e04623c23c', '2019-01-18 06:59:12', 1, NULL, '0000-00-00 00:00:00', 3),
(103, 'Alan', 'Hansford', 'johnnyw66+1@gmail.com', 'b5592bb2558c938f5375f6c40cd051944449ee0610840d58fe7a1108', '2019-01-18 13:29:59', 1, NULL, '0000-00-00 00:00:00', 4),
(104, 'Paul', 'Wilson', 'johnw66@gmail.com', 'b1a4c4f695e50a63642d21a2c5d51f0f7ab15c73449046f41e977187', '2019-01-18 14:31:39', 1, NULL, '0000-00-00 00:00:00', 5),
(105, 'Ben', 'Benjamin', 'ben@gmail.com', '77deeb853b2be26858268dd5495330bdc764c3b881a5e640eee49b77', '2019-01-27 16:32:06', 1, NULL, '0000-00-00 00:00:00', 6),
(106, 'Charles', 'Winters', 'charles@gmail.com', 'c3994f63665608d64fbbb7d8ba740dbfc621c9498c9a7f63549ef8b2', '2019-01-27 16:33:00', 1, NULL, '0000-00-00 00:00:00', 7),
(107, 'Denzil', 'Washington', 'den@gmail.com', '004b97cdd3e8bceb215a06343d1d5d578fa6ee1167ae81a9d8e8e8e9', '2019-01-27 19:29:17', 1, NULL, '0000-00-00 00:00:00', 8),
(108, 'Eddie', 'Eccles', 'eddie@gmail.com', '1df20d35be5046ed98ceba76448245bd2f97c069bd59fe28db5df9cb', '2019-01-27 19:36:38', 1, NULL, '0000-00-00 00:00:00', 9),
(109, 'Frank', 'Freeman', 'frank@gmail.com', '0eef9532d9b9940c140dca1a5029012dc16d8f2633b45e77a4f8a89f', '2019-01-27 19:39:32', 1, NULL, '0000-00-00 00:00:00', 10),
(110, 'Gorden', 'Grinter', 'gordon@gmail.com', 'b2ea065d9c9c8ac9c61b7d61a62460a8b54a1a22315bd6aed9670fa3', '2019-01-27 19:40:40', 1, NULL, '0000-00-00 00:00:00', 1),
(111, 'Harry', 'Hughes', 'harry@gmail.com', '5673c56c7bc3e5a37b10facb8dd3e219c10219e58238f00078632897', '2019-01-27 19:41:36', 1, NULL, '0000-00-00 00:00:00', 2),
(112, 'Ian', 'Indigo', 'ian@gmail.com', 'e3be169b3edb9e9f99c48de6489eb426634c0363c1b59767820d19b6', '2019-01-27 19:42:24', 1, NULL, '0000-00-00 00:00:00', 3),
(113, 'Josh', 'Jones', 'josh@gmail.com', '37dbe03533bfde32de5e8e0fc1214ca2ef2a862be7c95b7e73b4add2', '2019-01-27 19:45:42', 1, NULL, '0000-00-00 00:00:00', 4),
(114, 'Kevin', 'Kilroy', 'kevin@gmail.com', '4810a9e72ef0eefd683ebb0179092ab87f6d5b8d639cd621529c0fd7', '2019-01-27 19:46:28', 1, NULL, '0000-00-00 00:00:00', 5),
(115, 'Leroy', 'Lolly', 'leroy@gmail.com', '99b9335e2376524ac5b94e788a832372d13d2e7d5e938430c3a9d88d', '2019-01-27 19:50:58', 1, NULL, '0000-00-00 00:00:00', 6),
(116, 'Mick', 'Mild', 'mick@gmail.com', '04045a6f15451901bd5b8ff0ed9c72ee1fd651e05658a370e0169389', '2019-01-27 19:53:33', 1, NULL, '0000-00-00 00:00:00', 7),
(117, 'Ned', 'Nicol', 'ned@gmail.com', '4099b7ac0c49566f9f959064019f4a8017ed0fa8f31a024f1996308a', '2019-01-27 19:58:45', 1, NULL, '0000-00-00 00:00:00', 8),
(118, 'Oscar', 'Old', 'oscar@gmail.com', '9bf31d0a9c1dccabb5cd5b894fd955e8ed25d4ab8aca508cdd9cad22', '2019-01-27 20:00:55', 1, NULL, '0000-00-00 00:00:00', 9),
(119, 'Peter', 'Purves', 'peter@gmail.com', 'dfa95482833b745d6ef88ba389afe56afff6c301b857a2799118082a', '2019-01-27 20:04:27', 1, NULL, '0000-00-00 00:00:00', 10),
(120, 'Quentin', 'Queenie', 'quentin@gmail.com', '37991f093a668f6a960657c40ebbc74acb4d9fe3696f77e832ac2ec9', '2019-01-27 20:46:06', 1, NULL, '0000-00-00 00:00:00', 1),
(121, 'Robin', 'Reed', 'robin@gmail.com', '56750da97668ff4fef7ed4731eebe4f9fd45de4b6880d0c2500f0c0b', '2019-01-27 20:47:51', 1, NULL, '0000-00-00 00:00:00', 2),
(122, 'Ted', 'Tings', 'ted@gmail.com', 'b34380a2179b5d1884452249580cbedc30340d1181bc2fe1dac1edcc', '2019-01-27 20:49:46', 1, NULL, '0000-00-00 00:00:00', 3),
(123, 'Ursula', 'Urdy', 'ursula@gmail.com', 'f6abf5122611e3ae9b932048d42a8120dc4d9c3163954fc3104b88f2', '2019-01-27 20:51:54', 1, NULL, '0000-00-00 00:00:00', 4),
(124, 'Victor', 'Viva', 'victor@gmail.com', '14001a5e646a1049a207607d89cfefecb61510348209879a82272872', '2019-01-27 20:53:05', 1, NULL, '0000-00-00 00:00:00', 5),
(125, 'William', 'Williams', 'william@gmail.com', '9b18c52d01cb1da3615f7779c26eaf7bb554d8e33b35d3b2aa1c05c9', '2019-01-27 20:59:00', 1, NULL, '0000-00-00 00:00:00', 6),
(126, 'Test', 'Testy', 'test@gmail.com', '6c4654689e1782f2a2154051738ee52bb98511cdd82c5a899bc35233', '2019-01-29 12:03:35', 1, NULL, '0000-00-00 00:00:00', 7),
(127, 'Quest', 'Questy', 'quest@gmail.com', '99869b93311d5ba0ad5d56128cfaf93a7d869247060dd34495a632d8', '2019-01-29 12:50:25', 1, NULL, '0000-00-00 00:00:00', 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `avatars`
--
ALTER TABLE `avatars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userId` (`userId`,`friendId`),
  ADD KEY `friendId` (`friendId`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `post_id` (`post_id`,`liked_by`,`like_type`),
  ADD KEY `liked_by` (`liked_by`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posted_by` (`posted_by`),
  ADD KEY `posted_to` (`posted_to`),
  ADD KEY `post_root` (`post_root`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `requestorId` (`requestorId`,`requesteeId`),
  ADD KEY `requesteeId` (`requesteeId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`) USING BTREE,
  ADD KEY `avatarId` (`avatarId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `avatars`
--
ALTER TABLE `avatars`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=297;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=245;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friendIdConst` FOREIGN KEY (`friendId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `userIdConst` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`liked_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`posted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`posted_to`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `posts_ibfk_3` FOREIGN KEY (`post_root`) REFERENCES `posts` (`id`);

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`requesteeId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`requestorId`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`avatarId`) REFERENCES `avatars` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
