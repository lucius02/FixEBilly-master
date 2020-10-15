-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 01, 2018 at 08:07 AM
-- Server version: 5.6.37
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog_samples`
--

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE `links` (
  `id` int(8) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `votes` tinyint(2) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `links`
--

INSERT INTO `links` (`id`, `title`, `description`, `votes`) VALUES
(1, 'Favorite Star Rating with jQuery', 'This tutorial is for doing favorite star rating using jQuery. It displays list of HTML stars by using li tags. These stars are highlighted by using CSS and jQuery based on the favorite rating selected by the user.', 1),
(2, 'PHP RSS Feed Read and List', 'PHP\'s simplexml_load_file() function is used for reading data from xml file. Using this function, we can parse RSS feed to get item object array.', 0),
(3, 'jQuery AJAX Autocomplete - Country Example', 'Autocomplete feature is used to provide auto suggestion for users while entering input. It suggests country names for the users based on the keyword they entered into the input field by using jQuery AJAX.', 0),
(4, 'PHP CRUD with Search and Pagination', 'We have search options for searching the Name and Code columns by the given keywords posted via the search form. The search keyword is used to find match with the values of corresponding columns by using MySQL LIKE clause.', 0),
(5, 'DropDown with Search using jQuery', 'Search is an useful feature for a HTML dropdown list. Especially it will increase user convenience to select items from the dropdown having long list. In this tutorial, we are going to list country dropdown with a search option.', 0),
(6, 'PHP MySQL Date Range Search with jQuery DatePicker', 'how to search database records date between two given ranges. It will return the filtered results from database based on these dates input.', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `links`
--
ALTER TABLE `links`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
