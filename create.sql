CREATE DATABASE mvc
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_unicode_ci;

use mvc;

--
-- Table structure for table `img`
--

CREATE TABLE `img` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL DEFAULT '',
  `approved` tinyint(4) NOT NULL,
  `added` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `filename` (`filename`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `img_user`
--

CREATE TABLE `img_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `img` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `added` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `img_user_primary`
--

CREATE TABLE `img_user_primary` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `img` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `added` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `img_user` (`img`,`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthday` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sex` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `signup` int(11) DEFAULT NULL,
  `last` int(11) DEFAULT NULL,
  `added` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  `admin` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

