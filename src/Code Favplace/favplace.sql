-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 28, 2011 at 10:51 PM
-- Server version: 5.0.91
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `favmovie_favp`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL default '0',
  `ip_address` varchar(16) NOT NULL default '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL default '0',
  `user_data` text NOT NULL,
  PRIMARY KEY  (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `coord_cities`
--

CREATE TABLE IF NOT EXISTS `coord_cities` (
  `id` int(11) NOT NULL auto_increment,
  `municipality_id` int(11) NOT NULL,
  `type` tinyint(4) default '0',
  `name` varchar(1000) NOT NULL,
  `status` tinyint(4) default '0',
  PRIMARY KEY  (`id`),
  KEY `municipality_id` (`municipality_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5307 ;

-- --------------------------------------------------------

--
-- Table structure for table `coord_countries`
--

CREATE TABLE IF NOT EXISTS `coord_countries` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(1000) NOT NULL,
  `status` tinyint(4) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `coord_districts`
--

CREATE TABLE IF NOT EXISTS `coord_districts` (
  `id` int(11) NOT NULL auto_increment,
  `country_id` int(11) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `status` tinyint(4) default '0',
  PRIMARY KEY  (`id`),
  KEY `country_id` (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

-- --------------------------------------------------------

--
-- Table structure for table `coord_municipalities`
--

CREATE TABLE IF NOT EXISTS `coord_municipalities` (
  `id` int(11) NOT NULL auto_increment,
  `district_id` int(11) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `status` tinyint(4) default '0',
  PRIMARY KEY  (`id`),
  KEY `district_id` (`district_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=269 ;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL auto_increment,
  `profile_id` int(11) default NULL,
  `place_id` int(11) default NULL,
  `name` varchar(1000) default NULL,
  `date_start` datetime default NULL,
  `date_end` datetime default NULL,
  `description` text,
  `visible` tinyint(4) default '1' COMMENT '1 - for all\n2 - for friends',
  `picture` varchar(40) default NULL,
  `date` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `place_id` (`place_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_pictures`
--

CREATE TABLE IF NOT EXISTS `event_pictures` (
  `id` int(11) NOT NULL auto_increment,
  `event_id` int(11) default NULL,
  `profile_id` int(11) default NULL,
  `date` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `event_id` (`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_visits`
--

CREATE TABLE IF NOT EXISTS `event_visits` (
  `id` int(11) NOT NULL auto_increment,
  `event_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `favorites_places_categories`
--

CREATE TABLE IF NOT EXISTS `favorites_places_categories` (
  `id` int(11) NOT NULL auto_increment,
  `profile_id` int(11) default NULL,
  `name` varchar(300) default NULL,
  `date` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `profile_id` (`profile_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `favorite_places`
--

CREATE TABLE IF NOT EXISTS `favorite_places` (
  `id` int(11) NOT NULL auto_increment,
  `profile_id` int(11) default NULL,
  `place_id` int(11) default NULL,
  `category_id` int(11) default '0',
  `date` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `profile_id` (`profile_id`),
  KEY `category_id` (`category_id`),
  KEY `place_id` (`place_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

CREATE TABLE IF NOT EXISTS `pictures` (
  `id` int(11) NOT NULL auto_increment,
  `ref_id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL default '0',
  `name` varchar(40) NOT NULL,
  `ext` varchar(10) default NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `ref_id_place` (`ref_id`),
  KEY `ref_id_event` (`ref_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE IF NOT EXISTS `places` (
  `id` int(11) NOT NULL auto_increment,
  `profile_id` int(11) default NULL,
  `owner_id` int(11) default NULL,
  `name` varchar(1000) default NULL,
  `address` varchar(1000) default NULL,
  `coord_x` varchar(45) default NULL,
  `coord_y` varchar(45) default NULL,
  `coord_country_id` int(11) default '0',
  `coord_district_id` int(11) default '0',
  `coord_municipality_id` int(11) default '0',
  `coord_city_id` int(11) default '0',
  `description` text,
  `work_time` varchar(500) default NULL,
  `date` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `profile_id` (`profile_id`),
  KEY `coord_country_id` (`coord_country_id`),
  KEY `coord_district_id` (`coord_district_id`),
  KEY `coord_municipality_id` (`coord_municipality_id`),
  KEY `coord_city_id` (`coord_city_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Table structure for table `places_categories`
--

CREATE TABLE IF NOT EXISTS `places_categories` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `places_categories_link`
--

CREATE TABLE IF NOT EXISTS `places_categories_link` (
  `id` int(11) NOT NULL auto_increment,
  `place_id` int(11) default NULL,
  `category_id` int(11) default NULL,
  `subcategory_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `place_id` (`place_id`),
  KEY `category_id` (`category_id`),
  KEY `subcategory_id` (`subcategory_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=66 ;

-- --------------------------------------------------------

--
-- Table structure for table `places_categories_link_h`
--

CREATE TABLE IF NOT EXISTS `places_categories_link_h` (
  `id` int(11) NOT NULL auto_increment,
  `place_id` int(11) default NULL,
  `category_id` int(11) default NULL,
  `subcategory_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `place_id` (`place_id`),
  KEY `category_id` (`category_id`),
  KEY `subcategory_id` (`subcategory_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

-- --------------------------------------------------------

--
-- Table structure for table `places_h`
--

CREATE TABLE IF NOT EXISTS `places_h` (
  `id` int(11) NOT NULL auto_increment,
  `place_id` int(11) default NULL,
  `profile_creator_id` int(11) default NULL,
  `profile_editor_id` int(11) default NULL,
  `owner_id` int(11) default NULL,
  `name` varchar(1000) default NULL,
  `address` varchar(1000) default NULL,
  `coord_x` varchar(45) default NULL,
  `coord_y` varchar(45) default NULL,
  `coord_country_id` int(11) default '0',
  `coord_district_id` int(11) default '0',
  `coord_municipality_id` int(11) default '0',
  `coord_city_id` int(11) default '0',
  `description` text,
  `work_time` varchar(500) default NULL,
  `date` datetime default NULL,
  `date_h` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `coord_country_id` (`coord_country_id`),
  KEY `coord_district_id` (`coord_district_id`),
  KEY `coord_municipality_id` (`coord_municipality_id`),
  KEY `coord_city_id` (`coord_city_id`),
  KEY `place_id` (`place_id`),
  KEY `profile_creator_id` (`profile_creator_id`),
  KEY `profile_editor_id` (`profile_editor_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `places_subcategories`
--

CREATE TABLE IF NOT EXISTS `places_subcategories` (
  `id` int(11) NOT NULL auto_increment,
  `category_id` int(11) default NULL,
  `name` varchar(200) default NULL,
  PRIMARY KEY  (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `places_tags`
--

CREATE TABLE IF NOT EXISTS `places_tags` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(300) NOT NULL,
  `status` tinyint(4) default '0' COMMENT '1 - visible for the search\n0 - visible only for the current place',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `places_tags_link`
--

CREATE TABLE IF NOT EXISTS `places_tags_link` (
  `id` int(11) NOT NULL auto_increment,
  `place_id` int(11) default NULL,
  `tag_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `tag_id` (`tag_id`),
  KEY `place_id` (`place_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=117 ;

-- --------------------------------------------------------

--
-- Table structure for table `places_tags_link_h`
--

CREATE TABLE IF NOT EXISTS `places_tags_link_h` (
  `id` int(11) NOT NULL auto_increment,
  `place_id` int(11) default NULL,
  `tag_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `place_id` (`place_id`),
  KEY `tag_id` (`tag_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=65 ;

-- --------------------------------------------------------

--
-- Table structure for table `place_customization`
--

CREATE TABLE IF NOT EXISTS `place_customization` (
  `id` int(11) NOT NULL auto_increment,
  `place_id` int(11) default NULL,
  `css` text,
  `date` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `place_menu_categories`
--

CREATE TABLE IF NOT EXISTS `place_menu_categories` (
  `id` int(11) NOT NULL auto_increment,
  `place_id` int(11) default NULL,
  `name` varchar(1000) default NULL,
  `status` tinyint(4) default '1',
  `date` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `place_id` (`place_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `place_menu_items`
--

CREATE TABLE IF NOT EXISTS `place_menu_items` (
  `id` int(11) NOT NULL auto_increment,
  `subcategory_id` int(11) default NULL,
  `name` varchar(1000) default NULL,
  `amount` varchar(30) default NULL,
  `price` varchar(30) default NULL,
  `description` text,
  `status` tinyint(4) default '1',
  `date` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `subcategory_id` (`subcategory_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `place_menu_subcategories`
--

CREATE TABLE IF NOT EXISTS `place_menu_subcategories` (
  `id` int(11) NOT NULL auto_increment,
  `category_id` int(11) default NULL,
  `name` varchar(1000) default NULL,
  `status` tinyint(4) default '1',
  `date` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `place_pictures`
--

CREATE TABLE IF NOT EXISTS `place_pictures` (
  `id` int(11) NOT NULL auto_increment,
  `place_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `place_id` (`place_id`),
  KEY `profile_id` (`profile_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `place_request`
--

CREATE TABLE IF NOT EXISTS `place_request` (
  `id` int(11) NOT NULL auto_increment,
  `place_id` int(11) default NULL,
  `content` text,
  `status` tinyint(4) default '0',
  `date` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `place_id` (`place_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `place_searches`
--

CREATE TABLE IF NOT EXISTS `place_searches` (
  `id` int(11) NOT NULL auto_increment,
  `key` varchar(32) default NULL,
  `params` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `key_UNIQUE` (`key`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(320) NOT NULL,
  `name` varchar(150) default NULL,
  `description` varchar(1000) default NULL,
  `sex_id` tinyint(4) default NULL,
  `country_id` int(11) default NULL,
  `city_id` int(11) default NULL,
  `birthdate` datetime default NULL,
  `avatar` varchar(40) default NULL,
  `facebook` varchar(200) default NULL,
  `twitter` varchar(30) default NULL,
  `edno23` varchar(30) default NULL,
  `personal_site` varchar(67) default NULL,
  `places_visited` int(11) default '0',
  `places_will_visit` int(11) default '0',
  `last_online` datetime default NULL,
  `registered` datetime default NULL,
  `status` tinyint(4) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `profiles_password_recovory`
--

CREATE TABLE IF NOT EXISTS `profiles_password_recovory` (
  `id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `key` varchar(32) default NULL,
  `date` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `profile_id_UNIQUE` (`profile_id`),
  KEY `profile_id` (`profile_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `profile_comments`
--

CREATE TABLE IF NOT EXISTS `profile_comments` (
  `id` int(11) NOT NULL auto_increment,
  `profile_id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL default '0',
  `comment` varchar(1000) default NULL,
  `type` tinyint(4) NOT NULL default '0' COMMENT '0 - just a comment\n1- visit | 2 - will visit',
  `date` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `profile_id` (`profile_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `profile_comment_params`
--

CREATE TABLE IF NOT EXISTS `profile_comment_params` (
  `id` int(11) NOT NULL auto_increment,
  `profile_comment_id` int(11) default NULL,
  `param_id` int(11) default NULL,
  `param_type` int(11) default NULL,
  `param_pos` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `profile_comment_id` (`profile_comment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `profile_followers`
--

CREATE TABLE IF NOT EXISTS `profile_followers` (
  `id` int(11) NOT NULL auto_increment,
  `follower_id` int(11) NOT NULL,
  `followed_id` int(11) NOT NULL,
  `date` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `follower_id` (`follower_id`),
  KEY `followed_id` (`followed_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `profile_walls`
--

CREATE TABLE IF NOT EXISTS `profile_walls` (
  `id` int(11) NOT NULL auto_increment,
  `ref_id` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `profile_wall_comments`
--

CREATE TABLE IF NOT EXISTS `profile_wall_comments` (
  `id` int(11) NOT NULL auto_increment,
  `profile_wall_id` int(11) default NULL,
  `profile_id` int(11) default NULL,
  `comment` text,
  `date` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `profile_wall_id` (`profile_wall_id`),
  KEY `profile_id` (`profile_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

DELIMITER $$
--
-- Functions
--

CREATE FUNCTION `distance`(lat1 VARCHAR(45),lon1 VARCHAR(45), lat2 VARCHAR(45),lon2 VARCHAR(45)) RETURNS double DETERMINISTIC BEGIN DECLARE R INT; DECLARE dLAT,dLon,a,c DOUBLE; SET R=6371; SET dlat=RADIANS(lat2-lat1); SET dLon=RADIANS(lon2-lon1); SET a=POW(SIN(dLat/2),2)+COS(RADIANS(lat1))*COS(RADIANS(lat2))*POW(SIN(dLon/2),2); SET c=2*ATAN2(SQRT(a),SQRT(1-a)); RETURN R*c; END$$

DELIMITER ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `favmovie_favp`
--

--
-- Dumping data for table `places_categories`
--

INSERT INTO `places_categories` (`id`, `name`) VALUES
(1, 'Заведения'),
(2, 'Нощен живот'),
(3, 'Забавления и други'),
(4, 'Забележителности и природа'),
(5, 'Хотели, механи, вили и други'),
(6, 'Ежедневни');

--
-- Dumping data for table `places_subcategories`
--

INSERT INTO `places_subcategories` (`id`, `category_id`, `name`) VALUES
(1, 1, 'Заведения_1'),
(2, 1, 'Заведения_2'),
(3, 2, 'Нощен живот');

--
-- Dumping data for table `places_tags`
--

INSERT INTO `places_tags` (`id`, `name`, `status`) VALUES
(1, 'Подходящо за групи', 1),
(2, 'Подходящо за деца', 1),
(3, 'Места за пушачи', 1),
(4, 'Външни места', 1),
(5, 'Музика на живо', 1),
(6, 'Wi-Fi', 1),
(7, 'Собствен паркинг', 1);
