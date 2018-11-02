-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 02, 2018 at 05:11 PM
-- Server version: 5.7.23-0ubuntu0.16.04.1
-- PHP Version: 7.0.32-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `social_network`
--
CREATE DATABASE IF NOT EXISTS `social_network` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `social_network`;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `post_body` text NOT NULL,
  `posted_by` varchar(60) NOT NULL,
  `posted_to` varchar(60) NOT NULL,
  `created_on` datetime NOT NULL,
  `removed` varchar(3) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `post_body`, `posted_by`, `posted_to`, `created_on`, `removed`, `post_id`) VALUES
(2, 'comment it', 'desmond_miles', 'mac_arthur', '2018-09-17 16:26:53', 'no', 7),
(3, 'hi', 'altair_ibn', 'desmond_miles', '2018-09-18 10:50:53', 'no', 18),
(4, 'hi', 'altair_ibn', 'desmond_miles', '2018-09-18 10:51:09', 'no', 18),
(5, 'sweety', 'altair_ibn', 'desmond_miles', '2018-09-18 11:14:11', 'no', 15),
(6, 'vinorex', 'altair_ibn', 'desmond_miles', '2018-09-18 11:16:00', 'no', 18),
(7, 'this is my first comment', 'mac_arthur', 'altair_ibn', '2018-09-18 16:41:20', 'no', 20),
(8, 'this is my second comment', 'mac_arthur', 'altair_ibn', '2018-09-18 16:41:31', 'no', 20),
(9, 'Sweetie', 'desmond_miles', 'mac_arthur', '2018-09-19 10:27:07', 'no', 21),
(10, 'poda', 'altair_ibn', 'mac_arthur', '2018-10-11 10:46:29', 'no', 23),
(11, 'sollu da mac !', 'altair_ibn', 'mac_arthur', '2018-10-11 11:02:39', 'no', 24),
(12, 'hi mac', 'altair_ibn', 'mac_arthur', '2018-10-11 11:04:56', 'no', 22),
(13, 'hi', 'mac_arthur', 'mac_arthur', '2018-10-31 12:23:21', 'no', 24),
(14, 'ji', 'mac_arthur', 'mac_arthur', '2018-10-31 12:23:39', 'no', 25);

-- --------------------------------------------------------

--
-- Table structure for table `friend_request`
--

DROP TABLE IF EXISTS `friend_request`;
CREATE TABLE `friend_request` (
  `id` int(11) NOT NULL,
  `user_from` varchar(50) NOT NULL,
  `user_to` varchar(50) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `username`, `post_id`) VALUES
(2, 'mac_arthur', 20),
(3, 'mac_arthur', 19),
(4, 'altair_ibn', 18),
(5, 'altair_ibn', 17),
(6, 'altair_ibn', 16),
(7, 'altair_ibn', 15),
(8, 'desmond_miles', 21),
(10, 'desmond_miles', 7),
(11, 'mac_arthur', 18),
(14, 'mac_arthur', 14),
(15, 'mac_arthur', 13),
(16, 'desmond_miles', 20),
(17, 'desmond_miles', 19),
(18, 'desmond_miles', 6),
(19, 'altair_ibn', 23),
(20, 'altair_ibn', 22),
(21, 'altair_ibn', 24),
(22, 'mac_arthur', 17),
(23, 'altair_ibn', 26),
(24, 'altair_ibn', 21),
(25, 'altair_ibn', 7),
(26, 'altair_ibn', 6),
(27, 'altair_ibn', 5),
(28, 'altair_ibn', 28),
(29, 'altair_ibn', 27),
(30, 'altair_ibn', 25);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `user_to` varchar(50) NOT NULL,
  `user_from` varchar(50) NOT NULL,
  `body` text NOT NULL,
  `date` datetime NOT NULL,
  `opened` varchar(3) NOT NULL,
  `viewed` varchar(3) NOT NULL,
  `deleted` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='messaging system';

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `post` text NOT NULL,
  `created_by` varchar(60) NOT NULL,
  `posted_to` text NOT NULL,
  `created_on` datetime NOT NULL,
  `user_closed` varchar(3) NOT NULL,
  `deleted` varchar(3) NOT NULL,
  `likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `post`, `created_by`, `posted_to`, `created_on`, `user_closed`, `deleted`, `likes`) VALUES
(5, 'Hi ! This is my first post', 'mac_arthur', 'none', '2018-09-12 10:20:36', 'no', 'no', 1),
(6, 'This is my second post', 'mac_arthur', 'none', '2018-09-12 10:21:15', 'no', 'no', 2),
(7, 'This is my second post', 'mac_arthur', 'none', '2018-09-12 10:21:36', 'no', 'no', 2),
(8, 'This is miles posting for social networks', 'desmond_miles', 'none', '2018-09-12 10:25:55', 'no', 'no', 0),
(10, 'Hi Lovly', 'desmond_miles', 'none', '2018-09-12 11:25:48', 'no', 'no', 0),
(11, 'Yup yup ', 'desmond_miles', 'none', '2018-09-12 11:28:51', 'no', 'no', 0),
(12, 'happy override', 'desmond_miles', 'none', '2018-09-12 11:30:24', 'no', 'no', 0),
(13, 'HI', 'desmond_miles', 'none', '2018-09-12 12:03:31', 'no', 'no', 1),
(14, 'post\r\n', 'desmond_miles', 'none', '2018-09-12 12:46:16', 'no', 'no', 1),
(15, 'post', 'desmond_miles', 'none', '2018-09-12 12:46:22', 'no', 'no', 1),
(16, 'demo demo ', 'desmond_miles', 'none', '2018-09-12 12:46:27', 'no', 'no', 1),
(17, 'demodsadlkadskl ', 'desmond_miles', 'none', '2018-09-12 12:46:34', 'no', 'no', 2),
(18, 'dssdmskdkde ', 'desmond_miles', 'none', '2018-09-12 12:46:43', 'no', 'no', 2),
(19, 'Hi I\'m Altair this is my first post', 'altair_ibn', 'none', '2018-09-14 15:30:02', 'no', 'no', 2),
(20, 'How are you all', 'altair_ibn', 'none', '2018-09-14 15:30:13', 'no', 'no', 2),
(21, 'Howdie partner', 'mac_arthur', 'none', '2018-09-19 10:25:04', 'no', 'no', 2),
(22, 'Hi Altair', 'mac_arthur', 'altair_ibn', '2018-10-11 10:41:25', 'no', 'no', 1),
(23, 'hi', 'mac_arthur', 'none', '2018-10-11 10:41:50', 'no', 'no', 1),
(24, 'mongoose', 'mac_arthur', 'altair_ibn', '2018-10-11 10:53:24', 'no', 'no', 1),
(25, 'Hi Altair How are you', 'mac_arthur', 'altair_ibn', '2018-10-15 13:02:21', 'no', 'no', 1),
(26, 'Hi Dear', 'altair_ibn', 'mac_arthur', '2018-10-15 13:02:54', 'no', 'no', 1),
(27, 'Mac', 'altair_ibn', 'none', '2018-10-15 13:03:11', 'no', 'yes', 1),
(28, 'demo', 'altair_ibn', 'none', '2018-10-31 15:40:17', 'no', 'yes', 1),
(29, 'hi', 'altair_ibn', 'mac_arthur', '2018-10-31 15:41:37', 'no', 'yes', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `signup_date` date NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `num_posts` int(11) NOT NULL,
  `num_likes` int(11) NOT NULL,
  `user_closed` varchar(3) NOT NULL,
  `friend_array` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `signup_date`, `profile_pic`, `num_posts`, `num_likes`, `user_closed`, `friend_array`) VALUES
(3, 'Mac', 'Arthur', 'mac_arthur', 'mac@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2018-09-05', 'assets/images/profile_pics/defaults/head_emerald.png', 8, 11, 'no', ',desmond_miles,altair_ibn,'),
(5, 'Desmond', 'Miles', 'desmond_miles', 'miles@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2018-09-12', 'assets/images/profile_pics/defaults/head_pomegranate.png', 10, 8, 'no', ',altair_ibn,mac_arthur,'),
(6, 'Altair', 'Ibn', 'altair_ibn', 'ibn@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2018-09-14', 'assets/images/profile_pics/defaults/head_sun_flower.png', 6, 7, 'no', ',desmond_miles,mac_arthur,');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friend_request`
--
ALTER TABLE `friend_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `friend_request`
--
ALTER TABLE `friend_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;
