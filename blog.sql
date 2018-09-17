-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2018 at 10:52 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `ID` int(11) NOT NULL,
  `Fullname` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Phone` varchar(255) NOT NULL,
  `Message` text NOT NULL,
  `Country` varchar(255) NOT NULL,
  `Role` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`ID`, `Fullname`, `Email`, `Username`, `Phone`, `Message`, `Country`, `Role`, `Password`, `Created_at`) VALUES
(1, 'Muhammad Muhaddis', 'Muhaddisshah@gmail.com', 'MuhaddiMu', '03346016010', 'Muhaddis.Info', 'PK', 'Admin', '$2y$10$KmhRxwp7FDQzt5hHEG0Avey1bkJVgOU/z9TsuZyKVDxrx4Husfmdy', '2018-09-03 08:05:33'),
(2, 'Brad Hussey', 'brad@bradhussey.ca', 'BradHussey', '11152052055', 'bradhussey.ca', 'PK', 'Admin', '$2y$10$F17QCkpeIFVkg8NvcfJVjOp.7WstdINu6TvlnTBENHcH9REsoDbn2', '2018-09-03 08:05:33');

-- --------------------------------------------------------

--
-- Table structure for table `blog_post`
--

CREATE TABLE `blog_post` (
  `Post_ID` int(11) NOT NULL,
  `Post_Tag` varchar(256) NOT NULL,
  `Post_Title` text NOT NULL,
  `Post_Feature_Image` varchar(256) NOT NULL,
  `Post_Content` text NOT NULL,
  `Posted_By` int(11) NOT NULL,
  `Post_Date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_post`
--

INSERT INTO `blog_post` (`Post_ID`, `Post_Tag`, `Post_Title`, `Post_Feature_Image`, `Post_Content`, `Posted_By`, `Post_Date`) VALUES
(1, '5', 'We Design Stunning Websites!!!', 'http://127.0.0.1/My-Blog/Admin/plugins/images/BlogImages/5b9e17aebed925b9e17aebed92.jpg', '<p>Web designers don&rsquo;t just thrive on creativity and out-of-the-box ideas. They need a strong set of tools that can help them bring a vision to life. If you are looking for one tool that does it all, look no further than bootstrap. This open-source, front-end framework helps you in creating websites and applications that will blow your mind away. You can bring your vision to life with awe-inspiring&nbsp;<a href=\"https://wrappixel.com/templates/category/bootstrap-admin-templates/\">bootstrap admin templates</a>available on Wrap Pixel.</p>\r\n\r\n<p>Instead of working from scratch, select from a wide variety of free bootstrap themes available on Wrap Pixel. The creative, beautifully designed and highly responsive themes available on this platform will be a dream come true for any developer. Name a genre, a color scheme or any design basic- you will have it all covered in these themes. The selection of free themes is so wide and varied that creating several wonderful websites will be as easy as 1-2-3.</p>\r\n\r\n<p><img alt=\"bootstrap-admin-templates-ingographic\" src=\"https://wrappixel.com/wp-content/uploads/2018/08/wrappixel-bootstrap-admin-templates.jpg\" style=\"height:3439px; width:780px\" />&nbsp;</p>\r\n\r\n<p>If you are looking for extra customizations and advanced functionalities, switch to the premium&nbsp;<a href=\"https://wrappixel.com/templates/category/angular-templates/\"><strong>angular admin templates</strong></a>. Complete with&nbsp;<a href=\"https://wrappixel.com/templates/category/ui-kit/\">UI kits</a>, these extensive themes will provide extra features, more customization options and help you in creating a website your clients will be impressed with.</p>\r\n\r\n<p>Don&rsquo;t wait anymore and visit&nbsp;<a href=\"https://wrappixel.com/\">WrapPixel</a>&nbsp;for finding your next breathtaking website design. Find a design that truly reflects your vision, make some quick customizations, and add content, links and applications and you are ready to go. Web designing has never been this simple but then, you didn&rsquo;t know about the powerful and user-friendly Wrap Pixel platform too.</p>\r\n\r\n<p>Join the community and impress your clients with designs they can&rsquo;t get their eyes off!</p>\r\n', 1, '2018-09-16 08:46:24');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `Comment_ID` int(11) NOT NULL,
  `CommentPost_ID` int(11) NOT NULL,
  `Comment_Author` varchar(255) NOT NULL,
  `Comment` text NOT NULL,
  `Comment_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`Comment_ID`, `CommentPost_ID`, `Comment_Author`, `Comment`, `Comment_Date`) VALUES
(1, 1, 'Jany Adnrews', 'Wow! I&#039;d love to download it, Thanks for sharing!', '2018-09-16 08:50:54');

-- --------------------------------------------------------

--
-- Table structure for table `homepage`
--

CREATE TABLE `homepage` (
  `Homepage_Image` varchar(100) NOT NULL,
  `Homepage_Name` varchar(255) NOT NULL,
  `Homepage_Message` text NOT NULL,
  `Homepage_Description` text NOT NULL,
  `Homepage_Footer_Text` varchar(255) NOT NULL,
  `Homepage_Footer_Link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `homepage`
--

INSERT INTO `homepage` (`Homepage_Image`, `Homepage_Name`, `Homepage_Message`, `Homepage_Description`, `Homepage_Footer_Text`, `Homepage_Footer_Link`) VALUES
('http://127.0.0.1/My-Blog/Admin/plugins/images/UserAvatar.jpg', 'Muhammad Muhaddis', 'Just me, myself and I, exploring the universe of uknownment. I have a heart of love and a interest of lorem ipsum and mauris neque quam blog. I want to share my world with yours. ~Muhaddis', 'Welcome to the blog of CYBER SECURITY', 'Muhaddis', 'https://www.muhaddis.info/');

-- --------------------------------------------------------

--
-- Table structure for table `post_visits`
--

CREATE TABLE `post_visits` (
  `Post_ID` int(11) NOT NULL,
  `Post_Visits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_visits`
--

INSERT INTO `post_visits` (`Post_ID`, `Post_Visits`) VALUES
(1, 19);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `Tag_ID` int(11) NOT NULL,
  `Tag` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`Tag_ID`, `Tag`) VALUES
(1, 'Tag 1'),
(2, 'Tag 2'),
(3, 'Tag 3'),
(4, 'Tag 4'),
(5, 'Web Design'),
(6, 'Web Development'),
(7, 'App Security'),
(8, 'Code Audit'),
(9, 'Responsive Design'),
(10, 'Information Security'),
(11, 'Application Development'),
(12, 'Hosting Services');

-- --------------------------------------------------------

--
-- Table structure for table `total_visits`
--

CREATE TABLE `total_visits` (
  `Total_Visits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `total_visits`
--

INSERT INTO `total_visits` (`Total_Visits`) VALUES
(440);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `blog_post`
--
ALTER TABLE `blog_post`
  ADD PRIMARY KEY (`Post_ID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`Comment_ID`);

--
-- Indexes for table `post_visits`
--
ALTER TABLE `post_visits`
  ADD PRIMARY KEY (`Post_ID`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`Tag_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blog_post`
--
ALTER TABLE `blog_post`
  MODIFY `Post_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `Comment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `Tag_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
