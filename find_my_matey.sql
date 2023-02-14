-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2022 at 06:34 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `find_my_matey`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `username` varchar(50) NOT NULL,
  `time` datetime(4) NOT NULL DEFAULT current_timestamp(4)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `post_id`, `text`, `username`, `time`) VALUES
(3, 5, 'I like cherry pie wit\' a big scoop o\' ice cream.', 'MadEye', '2022-11-25 08:04:41.0000'),
(4, 11, 'Only if ye\'re willin\' t\' go on adventures wit\' me \'n me pet parrot Polly!', 'ElvaNoSmileSalvator', '2022-11-29 06:17:26.0000');

-- --------------------------------------------------------

--
-- Table structure for table `friend`
--

CREATE TABLE `friend` (
  `username` varchar(50) NOT NULL,
  `friend` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `friend`
--

INSERT INTO `friend` (`username`, `friend`) VALUES
('CaptainVeraBrave', 'MadEye'),
('Captain_Test', 'ElvaNoSmileSalvator'),
('Captain_Test', 'MadEye'),
('ElvaNoSmileSalvator', 'Captain_Test'),
('ElvaNoSmileSalvator', 'MadEye'),
('MadEye', 'Captain_Test');

-- --------------------------------------------------------

--
-- Table structure for table `like`
--

CREATE TABLE `like` (
  `post_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `like`
--

INSERT INTO `like` (`post_id`, `username`) VALUES
(1, 'Captain_Test'),
(1, 'ElvaNoSmileSalvator'),
(1, 'MadEye'),
(5, 'Captain_Test'),
(5, 'MadEye'),
(10, 'Captain_Test'),
(10, 'ElvaNoSmileSalvator'),
(11, 'CaptainVeraBrave'),
(11, 'MadEye'),
(12, 'CaptainVeraBrave');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `text` text NOT NULL,
  `time` datetime(4) NOT NULL DEFAULT current_timestamp(4)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `username`, `text`, `time`) VALUES
(1, 'Captain_Test', 'Ahoy, world!', '2022-11-18 10:14:13.0000'),
(5, 'Captain_Test', 'I love chocolate cake. Wha\' be yer fav\'rit dessert?', '2022-11-20 01:09:33.0000'),
(10, 'ElvaNoSmileSalvator', 'Ahoy, I be Elva \"No Smile\" Salvator. I love the smell o\' the salty sea \'n the gentle rock o\' the ocean.', '2022-11-29 01:19:54.0000'),
(11, 'MadEye', 'I be lookin\' fer some scallywags t\' sail the high seas wit\'. Any takers?', '2022-11-29 06:15:15.0000'),
(12, 'CaptainVeraBrave', 'Jus\' a lonely poppet lookin\' fer some booty \'n no-commitment pillagin\'.', '2022-11-29 06:32:39.0000');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(50) NOT NULL,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(128) NOT NULL,
  `avatar` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `first_name`, `last_name`, `email`, `password`, `avatar`) VALUES
('CaptainVeraBrave', 'Vera', 'Brave', 'cptnbrave24@sailors.net', '$2y$10$5.HWhP99qkKrOkBlEtTS7eU4y8AfxezOU2NPc/c2el9Ig243V2G3y', 'assets/icon4.jpg'),
('Captain_Test', 'Captain', 'Test', 'ridetheseas@email.com', '$2y$10$SXlGiAewklLba1W3nvn49.Q9dTTDeNxmNX.1J9JPjMDc/xHCgfvp.', 'assets/icon3.jpg'),
('ElvaNoSmileSalvator', 'Elva', 'Salvator', 'thegoldentreasure89@pirate.com', '$2y$10$RW5qV5kNeXGmiOH.cZBR3uSs2whm1KOQcUFnw4Ca5xFkbnxz1A1ha', 'assets/icon1.jpg'),
('MadEye', 'Fraser', 'Thorpe', 'seagullsOnHorizon@gmail.com', '$2y$10$HAqK8gYI6NmUaa0YjWpM5OvChYrHnMDqAf.PspFM8YmO2Y8gtqV2i', 'assets/icon2.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `friend`
--
ALTER TABLE `friend`
  ADD PRIMARY KEY (`username`,`friend`),
  ADD KEY `friend` (`friend`);

--
-- Indexes for table `like`
--
ALTER TABLE `like`
  ADD PRIMARY KEY (`post_id`,`username`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`username`) REFERENCES `user` (`username`);

--
-- Constraints for table `friend`
--
ALTER TABLE `friend`
  ADD CONSTRAINT `friend_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`),
  ADD CONSTRAINT `friend_ibfk_2` FOREIGN KEY (`friend`) REFERENCES `user` (`username`);

--
-- Constraints for table `like`
--
ALTER TABLE `like`
  ADD CONSTRAINT `like_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`),
  ADD CONSTRAINT `like_ibfk_2` FOREIGN KEY (`username`) REFERENCES `user` (`username`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
