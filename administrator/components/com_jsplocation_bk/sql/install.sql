DROP TABLE IF EXISTS `#__jsplocation_area`;
CREATE TABLE IF NOT EXISTS `#__jsplocation_area` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `country_id` int(10) NOT NULL,
  `state_id` int(10) NOT NULL,
  `city_id` int(10) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `published` tinyint(4) NOT NULL DEFAULT '0',
  `last_updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  AUTO_INCREMENT=9 ;

INSERT INTO `#__jsplocation_area` (`id`, `country_id`, `state_id`, `city_id`, `title`, `description`, `published`, `last_updated`) VALUES
(1, 1, 15, 1, 'Andheri', NULL, 1, '0000-00-00 00:00:00'),
(2, 1, 15, 1, 'Goregaon', NULL, 1, '0000-00-00 00:00:00'),
(3, 2, 29, 2, 'Southside Baptist Church', NULL, 1, '0000-00-00 00:00:00'),
(4, 3, 86, 3, 'Spring Garden Road', NULL, 1, '0000-00-00 00:00:00'),
(5, 1, 26, 5, 'Gomti Nagar', NULL, 1, '0000-00-00 00:00:00'),
(6, 1, 26, 6, 'DLF Cyber City', NULL, 1, '0000-00-00 00:00:00'),
(7, 1, 12, 7, 'Kondapur Village', NULL, 1, '0000-00-00 00:00:00'),
(8, 8, 191, 29, 'San Borja', NULL, 1, '0000-00-00 00:00:00'),
(9, 2, 194, 33, 'Powderhall', NULL, 1, '0000-00-00 00:00:00'),
(10, 2, 76, 34, '18th st NW', NULL, 1, '0000-00-00 00:00:00'),
(11, 4, 196, 35, 'old broad street', NULL, 1, '0000-00-00 00:00:00'),
(12, 10, 197, 36, '2nd Zabeel road', NULL, 1, '0000-00-00 00:00:00'),
(13, 5, 183, 32, 'Brunton Ave', NULL, 1, '0000-00-00 00:00:00'),
(14, 14, 201, 40, 'Petuelring', NULL, 1, '0000-00-00 00:00:00'),
(15, 11, 198, 37, 'Volokolamskoype sh', NULL, 1, '0000-00-00 00:00:00'),
(16, 13, 200, 39, 'Queens rd', NULL, 1, '0000-00-00 00:00:00'),
(17, 2, 33, 41, '1600 Amphitheatre Pkwy', NULL, 1, '0000-00-00 00:00:00'),
(18, 1, 15, 1, 'Dalal Street', NULL, 1, '0000-00-00 00:00:00');


DROP TABLE IF EXISTS `#__jsplocation_branch`;
CREATE TABLE IF NOT EXISTS `#__jsplocation_branch` (
`id` int(10) NOT NULL AUTO_INCREMENT,
  `branch_name` varchar(256) NOT NULL,
  `address1` varchar(256) NOT NULL,
  `latitude` varchar(256) NOT NULL,
  `longitude` varchar(256) NOT NULL,
  `lat_long_override` int(2) NOT NULL DEFAULT '0',
  `lat_ovr` varchar(256) NOT NULL,
  `long_ovr` varchar(256) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `landmark` varchar(256) NOT NULL,
  `area_id` int(5) NOT NULL,
  `city_id` int(5) NOT NULL,
  `state_id` int(5) NOT NULL,
  `country_id` int(5) NOT NULL,
  `category_id` varchar(256) NOT NULL,
  `contact_person` varchar(256) NOT NULL,
  `gender` int(1) NOT NULL,
  `email` varchar(256) NOT NULL,
  `website` varchar(256) NOT NULL,
  `contact_number` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `facebook` varchar(256) NOT NULL,
  `twitter` varchar(256) NOT NULL,
  `published` int(1) NOT NULL,
  `pointerImage` varchar(256) NOT NULL,
  `imagename` varchar(256) NOT NULL,
  `image_display` int(1) NOT NULL DEFAULT '0',
  `store_videos` int(11) NOT NULL DEFAULT '0',
  `youtube_url` varchar(255) NOT NULL,
  `vimeo_url` varchar(255) NOT NULL,
  `dailymotion_url` varchar(255) NOT NULL,
  `flickr_url` varchar(255) NOT NULL,
  `slideshare_url` varchar(255) NOT NULL,
  `speakerdeck_url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  AUTO_INCREMENT=1 ;



DROP TABLE IF EXISTS `#__jsplocation_customfields`;
CREATE TABLE IF NOT EXISTS `#__jsplocation_customfields` (
  `id` int(10) NOT NULL auto_increment,
  `branch_id` int(5) NOT NULL,
  `feild_id` int(11) NOT NULL,
  `value` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__jsplocation_city`;
CREATE TABLE IF NOT EXISTS `#__jsplocation_city` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `country_id` int(10) NOT NULL,
  `state_id` int(10) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `published` tinyint(4) NOT NULL DEFAULT '0',
  `last_updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  AUTO_INCREMENT=31 ;

INSERT INTO `#__jsplocation_city` (`id`, `country_id`, `state_id`, `title`, `description`, `published`, `last_updated`) VALUES
(1, 1, 15, 'Mumbai', NULL, 1, '0000-00-00 00:00:00'),
(2, 2, 29, 'Alabaster', NULL, 1, '0000-00-00 00:00:00'),
(3, 3, 86, 'Halifax', NULL, 1, '0000-00-00 00:00:00'),
(4, 2, 67, 'Pittsburgh', NULL, 1, '0000-00-00 00:00:00'),
(5, 1, 26, 'Lucknow', NULL, 1, '0000-00-00 00:00:00'),
(6, 1, 8, 'Gurgaon', NULL, 1, '0000-00-00 00:00:00'),
(7, 1, 12, 'Bangalore', NULL, 1, '0000-00-00 00:00:00'),
(8, 5, 183, 'Fitzroy', NULL, 1, '0000-00-00 00:00:00'),
(9, 5, 184, 'Balcatta', NULL, 1, '0000-00-00 00:00:00'),
(10, 5, 185, 'Dubbo', NULL, 1, '0000-00-00 00:00:00'),
(11, 5, 186, 'Barmera', NULL, 1, '0000-00-00 00:00:00'),
(12, 5, 183, 'Lilydale', NULL, 1, '0000-00-00 00:00:00'),
(13, 5, 185, 'Coffs Harbour', NULL, 1, '0000-00-00 00:00:00'),
(14, 5, 185, 'Forbes', NULL, 1, '0000-00-00 00:00:00'),
(15, 5, 185, 'Parkes', NULL, 1, '0000-00-00 00:00:00'),
(16, 5, 186, 'Mt Gambier', NULL, 1, '0000-00-00 00:00:00'),
(17, 5, 185, 'Griffith', NULL, 1, '0000-00-00 00:00:00'),
(18, 5, 187, 'Moranbah', NULL, 1, '0000-00-00 00:00:00'),
(19, 5, 185, 'Singleton', NULL, 1, '0000-00-00 00:00:00'),
(20, 5, 184, 'Bunbury', NULL, 1, '0000-00-00 00:00:00'),
(21, 5, 185, 'Taree', NULL, 1, '0000-00-00 00:00:00'),
(22, 5, 183, 'Northcote', NULL, 1, '0000-00-00 00:00:00'),
(23, 5, 185, 'Moruya', NULL, 1, '0000-00-00 00:00:00'),
(24, 5, 185, 'Kempsey', NULL, 1, '0000-00-00 00:00:00'),
(25, 5, 187, 'Rocklea', NULL, 1, '0000-00-00 00:00:00'),
(26, 6, 189, 'Cluj-Napoca', NULL, 1, '0000-00-00 00:00:00'),
(27, 7, 190, 'Lichtensteig', NULL, 1, '0000-00-00 00:00:00'),
(28, 7, 190, 'Hornussen', NULL, 1, '0000-00-00 00:00:00'),
(29, 8, 191, 'Lima', NULL, 1, '0000-00-00 00:00:00'),
(30, 4, 121, 'Rugby', NULL, 1, '0000-00-00 00:00:00'),
(31, 4, 192, 'Edinburgh', NULL, 1, '0000-00-00 00:00:00'),
(32, 5, 183, 'Melbourne', NULL, 1, '0000-00-00 00:00:00'),
(33, 2, 194, 'Lower Manhattan', NULL, 1, '0000-00-00 00:00:00'),
(34, 2, 76, 'Northwest', NULL, 1, '0000-00-00 00:00:00'),
(35, 4, 196, 'City of London', NULL, 1, '0000-00-00 00:00:00'),
(36, 10, 197, 'Dubai', NULL, 1, '0000-00-00 00:00:00'),
(37, 11, 198, 'Moscow', NULL, 1, '0000-00-00 00:00:00'),
(38, 12, 199, 'Shinjuku', NULL, 1, '0000-00-00 00:00:00'),
(39, 13, 200, 'Braamfontein', NULL, 1, '0000-00-00 00:00:00'),
(40, 14, 201, 'Munich', NULL, 1, '0000-00-00 00:00:00'),
(41, 2, 33, 'Mountain View', NULL, 1, '0000-00-00 00:00:00');

DROP TABLE IF EXISTS `#__jsplocation_configuration`;
CREATE TABLE IF NOT EXISTS `#__jsplocation_configuration` (
 `id` int(2) NOT NULL AUTO_INCREMENT,
 `maptitle` varchar(256) NOT NULL,
 `map_type` enum('0','1') NOT NULL DEFAULT '0',
 `BingMap_key` varchar(200) NOT NULL,
 `jquery` enum('Auto','Yes','No') NOT NULL DEFAULT 'Auto',
 `height` varchar(256) NOT NULL,
 `zoomlevel` varchar(256) NOT NULL,
 `lat_ovr_conf` varchar(256) NOT NULL,
 `long_ovr_conf` varchar(256) NOT NULL,
 `branch_id` int(5) NOT NULL,
 `branch_url` enum('Yes','No') NOT NULL DEFAULT 'Yes',
 `search` enum('Yes','No') NOT NULL DEFAULT 'Yes',
 `directions` enum('Yes','No') NOT NULL DEFAULT 'Yes',
 `branchlist` enum('Yes','No') NOT NULL DEFAULT 'Yes',
 `country` enum('Yes','No') NOT NULL DEFAULT 'Yes',
 `state` enum('Yes','No') NOT NULL DEFAULT 'Yes',
 `city` enum('Yes','No') NOT NULL DEFAULT 'Yes',
 `area` enum('Yes','No') NOT NULL DEFAULT 'Yes',
 `displaytitle` enum('Yes','No') NOT NULL DEFAULT 'Yes',
 `zip_search` enum('Yes','No') NOT NULL DEFAULT 'Yes',
 `category_search` enum('Yes','No') NOT NULL DEFAULT 'Yes',
 `country_search` enum('Yes','No') NOT NULL DEFAULT 'Yes',
 `state_search` enum('Yes','No') NOT NULL DEFAULT 'Yes',
 `city_search` enum('Yes','No') NOT NULL DEFAULT 'Yes',
 `area_search` enum('Yes','No') NOT NULL DEFAULT 'Yes',
 `google_autocomplete_address` enum('Yes','No') NOT NULL DEFAULT 'Yes',
 `radius_range` enum('Yes','No') NOT NULL DEFAULT 'Yes',
 `template` varchar(256) NOT NULL,
 `min_zip` int(6) NOT NULL DEFAULT '4',
 `max_zip` int(6) NOT NULL DEFAULT '6',
 `locateme` enum('Yes','No') NOT NULL DEFAULT 'Yes',
 `locateme_radius` int(11) NOT NULL DEFAULT '30',
 `branch_img_id` int(11) NOT NULL,
 `image_display` enum('Yes','No') NOT NULL DEFAULT 'No',
 `imagename` varchar(256) NOT NULL,
 `direction_range` enum('Yes','No') NOT NULL DEFAULT 'Yes',
 `show_pointer_type` enum('Yes','No') NOT NULL DEFAULT 'Yes',
 `page_limit` int(11) NOT NULL DEFAULT '3',
 `pointertype` enum('Yes','No') NOT NULL DEFAULT 'Yes',
 `fillcolor` varchar(6) NOT NULL DEFAULT '1496E7',
 `fontsize` int(2) NOT NULL DEFAULT '9',
 `file_type` int(10) NOT NULL,
 `file_path` varchar(255) NOT NULL,
 `location_status` int(10) NOT NULL,
 `location_file_type` int(10) NOT NULL,
 `location_file_path` varchar(255) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;



INSERT INTO `#__jsplocation_configuration` (`id`, `maptitle`, `map_type`, `BingMap_key`, `jquery`, `height`, `zoomlevel`, `lat_ovr_conf`, `long_ovr_conf`, `branch_id`, `branch_url`, `search`, `directions`, `branchlist`, `country`, `state`, `city`, `area`, `displaytitle`, `zip_search`, `category_search`, `country_search`, `state_search`, `city_search`, `area_search`, `google_autocomplete_address`, `radius_range`, `template`, `min_zip`, `max_zip`, `locateme`, `locateme_radius`, `branch_img_id`, `image_display`, `imagename`, `direction_range`, `show_pointer_type`, `page_limit`, `pointertype`, `fillcolor`, `fontsize`, `file_type`, `file_path`, `location_status`, `location_file_type`, `location_file_path`) VALUES
(1, 'JSP Location Component', '0', 'AlC42aoPjmY3XcyuEQFJBn6LAr0vluIelYd68caV5NQ2vBVTrCTHRD_QLmYxXa2U', 'Auto', '550', '8', '33.2442813', '33.24428130000001', 0, 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'No', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'classic', 4, 8, 'Yes', 50, 0, 'No', 'default.jpg', 'Yes', 'Yes', 4, 'Yes', 'A4E856', 10, 1, 'D:\\wamp\\www\\jspexcel.xls', 1, 1, 'D:\\wamp\\www\\branchlocation.xls');


DROP TABLE IF EXISTS `#__jsplocation_country`;
CREATE TABLE IF NOT EXISTS `#__jsplocation_country` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `published` tinyint(4) NOT NULL DEFAULT '0',
  `last_updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  AUTO_INCREMENT=9 ;

INSERT INTO `#__jsplocation_country` (`id`, `title`, `description`, `published`, `last_updated`) VALUES
(1, 'India', 'India', 1, '2011-09-20 15:18:18'),
(2, 'United States', 'USA', 1, '2011-09-20 15:18:18'),
(3, 'Canada', 'Canada', 1, '2011-09-20 15:18:18'),
(4, 'United Kingdom', 'United Kingdom', 1, '2011-09-20 15:18:18'),
(5, 'Australia', 'Australia', 1, '0000-00-00 00:00:00'),
(6, 'Romania', 'Romania', 1, '0000-00-00 00:00:00'),
(7, 'Switzerland', 'Switzerland', 1, '0000-00-00 00:00:00'),
(8, 'Peru', 'Peru', 1, '0000-00-00 00:00:00'),
(9, 'France', NULL, 1, '0000-00-00 00:00:00'),
(10, 'United Arab Emirates', NULL, 1, '0000-00-00 00:00:00'),
(11, 'Russia', NULL, 1, '0000-00-00 00:00:00'),
(12, 'Japan', NULL, 1, '0000-00-00 00:00:00'),
(13, 'South Africa', NULL, 1, '0000-00-00 00:00:00'),
(14, 'Germany', NULL, 1, '0000-00-00 00:00:00');

DROP TABLE IF EXISTS `#__jsplocation_category`;
CREATE TABLE IF NOT EXISTS `#__jsplocation_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `published` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  AUTO_INCREMENT=3 ;

INSERT INTO `#__jsplocation_category` (`id`, `title`, `description`, `published`) VALUES
(1, 'Store', NULL, 1),
(2, 'Outlet', NULL, 1);

DROP TABLE IF EXISTS `#__jsplocation_fields`;
CREATE TABLE IF NOT EXISTS `#__jsplocation_fields` (
  `id` int(5) NOT NULL auto_increment,
  `field_name` varchar(256) NOT NULL,
  `field_type` varchar(256) NOT NULL,
  `published` int(1) NOT NULL,
  `map_display` int(1) NOT NULL,
  `sidebar_display` int(1) NOT NULL,
  `predefined` int(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  AUTO_INCREMENT=8 ;

INSERT INTO `#__jsplocation_fields` (`id`, `field_name`, `field_type`, `published`, `map_display`, `sidebar_display`, `predefined`) VALUES
(1, 'Location Name', 'Text Field', 1, 1, 1, 1),
(2, 'Contact Person', 'Text Field', 1, 1, 1, 1),
(3, 'Contact Number', 'Text Field', 1, 1, 1, 1),
(4, 'Gender', 'Radio Button', 1, 1, 1, 1),
(5, 'E-mail Id', 'Text Field', 1, 1, 1, 1),
(6, 'Website', 'Text Field', 1, 1, 1, 1),
(7, 'Description', 'Text Area', 1, 1, 1, 1);

DROP TABLE IF EXISTS `#__jsplocation_state`;
CREATE TABLE IF NOT EXISTS `#__jsplocation_state` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `country_id` int(10) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(100) NOT NULL,
  `published` tinyint(4) NOT NULL DEFAULT '0',
  `last_updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  AUTO_INCREMENT=192 ;

INSERT INTO `#__jsplocation_state` (`id`, `country_id`, `title`, `description`, `published`, `last_updated`) VALUES
(1, 1, 'Andhra Pradesh', 'Andhra Pradesh', 0, '2009-01-26 15:30:00'),
(2, 1, 'Arunachal Pradesh', 'Arunachal Pradesh', 0, '2009-01-26 15:30:00'),
(3, 1, 'Assam', 'Assam', 0, '2009-01-26 15:30:00'),
(4, 1, 'Bihar', 'Bihar', 0, '2009-01-26 15:30:00'),
(5, 1, 'Chhattisgarh', 'Chhattisgarh', 0, '2009-01-26 15:30:00'),
(6, 1, 'Goa', 'Goa', 0, '2009-01-26 15:30:00'),
(7, 1, 'Gujarat', 'Gujarat', 0, '2009-01-26 15:30:00'),
(8, 1, 'Haryana', 'Haryana', 1, '2009-01-26 15:30:00'),
(9, 1, 'Himachal Pradesh', 'Himachal Pradesh', 0, '2009-01-26 15:30:00'),
(10, 1, 'Jammu and Kashmir', 'Jammu and Kashmir', 0, '2009-01-26 15:30:00'),
(11, 1, 'Jharkhand', 'Jharkhand', 0, '2009-01-26 15:30:00'),
(12, 1, 'Karnataka', 'Karnataka', 1, '2009-01-26 15:30:00'),
(13, 1, 'Kerala', 'Kerala', 0, '2009-01-26 15:30:00'),
(14, 1, 'Madhya Pradesh', 'Madhya Pradesh', 0, '2009-01-26 15:30:00'),
(15, 1, 'Maharashtra', 'Maharashtra', 1, '2009-01-26 15:30:00'),
(16, 1, 'Manipur', 'Manipur', 0, '2009-01-26 15:30:00'),
(17, 1, 'Meghalaya', 'Meghalaya', 0, '2009-01-26 15:30:00'),
(18, 1, 'Mizoram', 'Mizoram', 0, '2009-01-26 15:30:00'),
(19, 1, 'Nagaland', 'Nagaland', 0, '2009-01-26 15:30:00'),
(20, 1, 'Orissa', 'Orissa', 0, '2009-01-26 15:30:00'),
(21, 1, 'Punjab', 'Punjab', 0, '2009-01-26 15:30:00'),
(22, 1, 'Rajasthan', 'Rajasthan', 0, '2009-01-26 15:30:00'),
(23, 1, 'Sikkim', 'Sikkim', 0, '2009-01-26 15:30:00'),
(24, 1, 'Tamil Nadu', 'Tamil Nadu', 0, '2009-01-26 15:30:00'),
(25, 1, 'Tripura', 'Tripura', 0, '2009-01-26 15:30:00'),
(26, 1, 'Uttar Pradesh', 'Uttar Pradesh', 1, '2009-01-26 15:30:00'),
(27, 1, 'Uttaranchal', 'Uttaranchal', 0, '2009-01-26 15:30:00'),
(28, 1, 'West Bengal', 'West Bengal', 0, '2009-01-26 15:30:00'),
(29, 2, 'Alabama', 'ALA', 1, '2011-09-20 15:30:00'),
(30, 2, 'Alaska', 'ALK', 0, '2011-09-20 15:30:00'),
(31, 2, 'Arizona', 'ARZ', 0, '2011-09-20 15:30:00'),
(32, 2, 'Arkansas', 'ARK', 0, '2011-09-20 15:30:00'),
(33, 2, 'California', 'CAL', 1, '2011-09-20 15:30:00'),
(34, 2, 'Colorado', 'COL', 0, '2011-09-20 15:30:00'),
(35, 2, 'Connecticut', 'CCT', 0, '2011-09-20 15:30:00'),
(36, 2, 'Delaware', 'DEL', 0, '2011-09-20 15:30:00'),
(37, 2, 'District Of Columbia', 'DOC', 0, '2011-09-20 15:30:00'),
(38, 2, 'Florida', 'FLO', 0, '2011-09-20 15:30:00'),
(39, 2, 'Georgia', 'GEA', 0, '2011-09-20 15:30:00'),
(40, 2, 'Hawaii', 'HWI', 0, '2011-09-20 15:30:00'),
(41, 2, 'Idaho', 'IDA', 0, '2011-09-20 15:30:00'),
(42, 2, 'Illinois', 'ILL', 0, '2011-09-20 15:30:00'),
(43, 2, 'Indiana', 'IND', 0, '2011-09-20 15:30:00'),
(44, 2, 'Iowa', 'IOA', 0, '2011-09-20 15:30:00'),
(45, 2, 'Kansas', 'KAS', 0, '2011-09-20 15:30:00'),
(46, 2, 'Kentucky', 'KTY', 0, '2011-09-20 15:30:00'),
(47, 2, 'Louisiana', 'LOA', 0, '2011-09-20 15:30:00'),
(48, 2, 'Maine', 'MAI', 0, '2011-09-20 15:30:00'),
(49, 2, 'Maryland', 'MLD', 0, '2011-09-20 15:30:00'),
(50, 2, 'Massachusetts', 'MSA', 0, '2011-09-20 15:30:00'),
(51, 2, 'Michigan', 'MIC', 0, '2011-09-20 15:30:00'),
(52, 2, 'Minnesota', 'MIN', 0, '2011-09-20 15:30:00'),
(53, 2, 'Mississippi', 'MIS', 0, '2011-09-20 15:30:00'),
(54, 2, 'Missouri', 'MIO', 0, '2011-09-20 15:30:00'),
(55, 2, 'Montana', 'MOT', 0, '2011-09-20 15:30:00'),
(56, 2, 'Nebraska', 'NEB', 0, '2011-09-20 15:30:00'),
(57, 2, 'Nevada', 'NEV', 0, '2011-09-20 15:30:00'),
(58, 2, 'New Hampshire', 'NEH', 0, '2011-09-20 15:30:00'),
(59, 2, 'New Jersey', 'NEJ', 0, '2011-09-20 15:30:00'),
(60, 2, 'New Mexico', 'NEM', 0, '2011-09-20 15:30:00'),
(61, 2, 'New York', 'NEY', 0, '2011-09-20 15:30:00'),
(62, 2, 'North Carolina', 'NOC', 0, '2011-09-20 15:30:00'),
(63, 2, 'North Dakota', 'NOD', 0, '2011-09-20 15:30:00'),
(64, 2, 'Ohio', 'OHI', 0, '2011-09-20 15:30:00'),
(65, 2, 'Oklahoma', 'OKL', 0, '2011-09-20 15:30:00'),
(66, 2, 'Oregon', 'ORN', 0, '2011-09-20 15:30:00'),
(67, 2, 'Pennsylvania', 'PEA', 1, '2011-09-20 15:30:00'),
(68, 2, 'Rhode Island', 'RHI', 0, '2011-09-20 15:30:00'),
(69, 2, 'South Carolina', 'SOC', 0, '2011-09-20 15:30:00'),
(70, 2, 'South Dakota', 'SOD', 0, '2011-09-20 15:30:00'),
(71, 2, 'Tennessee', 'TEN', 0, '2011-09-20 15:30:00'),
(72, 2, 'Texas', 'TXS', 0, '2011-09-20 15:30:00'),
(73, 2, 'Utah', 'UTA', 0, '2011-09-20 15:30:00'),
(74, 2, 'Vermont', 'VMT', 0, '2011-09-20 15:30:00'),
(75, 2, 'Virginia', 'VIA', 0, '2011-09-20 15:30:00'),
(76, 2, 'Washington', 'WAS', 1, '2011-09-20 15:30:00'),
(77, 2, 'West Virginia', 'WEV', 0, '2011-09-20 15:30:00'),
(78, 2, 'Wisconsin', 'WIS', 0, '2011-09-20 15:30:00'),
(79, 2, 'Wyoming', 'WYO', 0, '2011-09-20 15:30:00'),
(80, 3, 'Alberta', 'ALB', 0, '2011-09-20 15:30:00'),
(81, 3, 'British Columbia', 'BRC', 0, '2011-09-20 15:30:00'),
(82, 3, 'Manitoba', 'MAB', 0, '2011-09-20 15:30:00'),
(83, 3, 'New Brunswick', 'NEB', 0, '2011-09-20 15:30:00'),
(84, 3, 'Newfoundland and Labrador', 'NFL', 0, '2011-09-20 15:30:00'),
(85, 3, 'Northwest Territories', 'NWT', 0, '2011-09-20 15:30:00'),
(86, 3, 'Nova Scotia', 'NOS', 1, '2011-09-20 15:30:00'),
(87, 3, 'Nunavut', 'NUT', 0, '2011-09-20 15:30:00'),
(88, 3, 'Ontario', 'ONT', 0, '2011-09-20 15:30:00'),
(89, 3, 'Prince Edward Island', 'PEI', 0, '2011-09-20 15:30:00'),
(90, 3, 'Quebec', 'QEC', 0, '2011-09-20 15:30:00'),
(91, 3, 'Saskatchewan', 'SAK', 0, '2011-09-20 15:30:00'),
(92, 3, 'Yukon', 'YUT', 0, '2011-09-20 15:30:00'),
(93, 4, 'Greater London', '', 0, '2011-09-20 15:30:00'),
(94, 4, 'West Midlands', '', 0, '2011-09-20 15:30:00'),
(95, 4, 'Greater Manchester', '', 0, '2011-09-20 15:30:00'),
(96, 4, 'West Yorkshire', '', 0, '2011-09-20 15:30:00'),
(97, 4, 'Kent', '', 0, '2011-09-20 15:30:00'),
(98, 4, 'Essex', '', 0, '2011-09-20 15:30:00'),
(99, 4, 'Merseyside', '', 0, '2011-09-20 15:30:00'),
(100, 4, 'South Yorkshire', '', 0, '2011-09-20 15:30:00'),
(101, 4, 'Hampshire', '', 0, '2011-09-20 15:30:00'),
(102, 4, 'Lancashire', '', 0, '2011-09-20 15:30:00'),
(103, 4, 'Surrey', '', 0, '2011-09-20 15:30:00'),
(104, 4, 'Tyne and Wear', '', 0, '2011-09-20 15:40:00'),
(105, 4, 'Hertfordshire', '', 0, '2011-09-20 15:40:00'),
(106, 4, 'Norfolk', '', 0, '2011-09-20 15:40:00'),
(107, 4, 'Staffordshire', '', 0, '2011-09-20 15:40:00'),
(108, 4, 'West Sussex', '', 0, '2011-09-20 15:40:00'),
(109, 4, 'Nottinghamshire', '', 0, '2011-09-20 15:40:00'),
(110, 4, 'Derbyshire', '', 0, '2011-09-20 15:40:00'),
(111, 4, 'Devon', '', 0, '2011-09-20 15:40:00'),
(112, 4, 'Suffolk', '', 0, '2011-09-20 15:40:00'),
(113, 4, 'Lincolnshire', '', 0, '2011-09-20 15:40:00'),
(114, 4, 'Northamptonshire', '', 0, '2011-09-20 15:40:00'),
(115, 4, 'Leicestershire', '', 0, '2011-09-20 15:40:00'),
(116, 4, 'Oxfordshire', '', 0, '2011-09-20 15:40:00'),
(117, 4, 'Cambridgeshire', '', 0, '2011-09-20 15:40:00'),
(118, 4, 'North Yorkshire', '', 0, '2011-09-20 15:40:00'),
(119, 4, 'Gloucestershire', '', 0, '2011-09-20 15:40:00'),
(120, 4, 'Worcestershire', '', 0, '2011-09-20 15:40:00'),
(121, 4, 'Warwickshire', '', 0, '2011-09-20 15:40:00'),
(122, 4, 'Cornwall', '', 0, '2011-09-20 15:40:00'),
(123, 4, 'Somerset', '', 0, '2011-09-20 15:40:00'),
(124, 4, 'East Sussex', '', 0, '2011-09-20 15:40:00'),
(125, 4, 'County Durham', '', 0, '2011-09-20 15:40:00'),
(126, 4, 'Buckinghamshire', '', 0, '2011-09-20 15:40:00'),
(127, 4, 'Cumbria', '', 0, '2011-09-20 15:40:00'),
(128, 4, 'Wiltshire', '', 0, '2011-09-20 15:40:00'),
(129, 4, 'Bristol', '', 0, '2011-09-20 15:40:00'),
(130, 4, 'Dorset', '', 0, '2011-09-20 15:30:00'),
(131, 4, 'Cheshire East', '', 0, '2011-09-20 15:30:00'),
(132, 4, 'East Riding of Yorkshire', '', 0, '2011-09-20 15:30:00'),
(133, 4, 'Cheshire West and Chester', '', 0, '2011-09-20 15:30:00'),
(134, 4, 'Northumberland', '', 0, '2011-09-20 15:30:00'),
(135, 4, 'Nottingham', '', 0, '2011-09-20 15:30:00'),
(136, 4, 'Leicester', '', 0, '2011-09-20 15:30:00'),
(137, 4, 'Shropshire', '', 0, '2011-09-20 15:30:00'),
(138, 4, 'South Gloucestershire', '', 0, '2011-09-20 15:30:00'),
(139, 4, 'Hull', '', 0, '2011-09-20 15:30:00'),
(140, 4, 'Brighton & Hove', '', 0, '2011-09-20 15:30:00'),
(141, 4, 'Plymouth', '', 0, '2011-09-20 15:30:00'),
(142, 4, 'Medway', '', 0, '2011-09-20 15:30:00'),
(143, 4, 'Central Bedfordshire', '', 0, '2011-09-20 15:30:00'),
(144, 4, 'Derby', '', 0, '2011-09-20 15:30:00'),
(145, 4, 'Milton Keynes', '', 0, '2011-09-20 15:30:00'),
(146, 4, 'Stoke-on-Trent', '', 0, '2011-09-20 15:30:00'),
(147, 4, 'Southampton', '', 0, '2011-09-20 15:30:00'),
(148, 4, 'North Somerset', '', 0, '2011-09-20 15:30:00'),
(149, 4, 'Portsmouth', '', 0, '2011-09-20 15:30:00'),
(150, 4, 'York', '', 0, '2011-09-20 15:30:00'),
(151, 4, 'Swindon', '', 0, '2011-09-20 15:30:00'),
(152, 4, 'Warrington', '', 0, '2011-09-20 15:30:00'),
(153, 4, 'Luton', '', 0, '2011-09-20 15:30:00'),
(154, 4, 'Stockton-on-Tees', '', 0, '2011-09-20 15:30:00'),
(155, 4, 'Bath and North East Somerset', '', 0, '2011-09-20 15:30:00'),
(156, 4, 'Herefordshire', '', 0, '2011-09-20 15:30:00'),
(157, 4, 'Peterborough', '', 0, '2011-09-20 15:30:00'),
(158, 4, 'Bournemouth', '', 0, '2011-09-20 15:30:00'),
(159, 4, 'Southend-on-Sea', '', 0, '2011-09-20 15:30:00'),
(160, 4, 'Wokingham', '', 0, '2011-09-20 15:30:00'),
(161, 4, 'Telford and Wrekin', '', 0, '2011-09-20 15:30:00'),
(162, 4, 'North Lincolnshire', '', 0, '2011-09-20 15:30:00'),
(163, 4, 'unitary', '', 0, '2011-09-20 15:30:00'),
(164, 4, 'Thurrock', '', 0, '2011-09-20 15:30:00'),
(165, 4, 'North East Lincolnshire', '', 0, '2011-09-20 15:30:00'),
(166, 4, 'Reading', '', 0, '2011-09-20 15:30:00'),
(167, 4, 'West Berkshire', '', 0, '2011-09-20 15:30:00'),
(168, 4, 'Windsor and Maidenhead', '', 0, '2011-09-20 15:30:00'),
(169, 4, 'Middlesbrough', '', 0, '2011-09-20 15:30:00'),
(170, 4, 'Poole', '', 0, '2011-09-20 15:30:00'),
(171, 4, 'Isle of Wight', '', 0, '2011-09-20 15:30:00'),
(172, 4, 'Blackpool', '', 0, '2011-09-20 15:30:00'),
(173, 4, 'Blackburn with Darwen', '', 0, '2011-09-20 15:30:00'),
(174, 4, 'Redcar and Cleveland', '', 0, '2011-09-20 15:30:00'),
(175, 4, 'Torbay', '', 0, '2011-09-20 15:30:00'),
(176, 4, 'Slough', '', 0, '2011-09-20 15:30:00'),
(177, 4, 'Halton', '', 0, '2011-09-20 15:30:00'),
(178, 4, 'Bracknell Forest', '', 0, '2011-09-20 15:30:00'),
(179, 4, 'Darlington', '', 0, '2011-09-20 15:30:00'),
(180, 4, 'Hartlepool', '', 0, '2011-09-20 15:30:00'),
(181, 4, 'Rutland', '', 0, '2011-09-20 15:30:00'),
(182, 4, 'Isles of Scilly', '', 0, '2011-09-20 15:30:00'),
(183, 5, 'Victoria', '', 1, '0000-00-00 00:00:00'),
(184, 5, 'Western Australia', '', 1, '0000-00-00 00:00:00'),
(185, 5, 'New South Wales', '', 1, '0000-00-00 00:00:00'),
(186, 5, 'South Australia', '', 1, '0000-00-00 00:00:00'),
(187, 5, 'Queensland', '', 1, '0000-00-00 00:00:00'),
(189, 6, 'Cluj County', '', 1, '0000-00-00 00:00:00'),
(190, 7, 'Schweiz', '', 1, '0000-00-00 00:00:00'),
(191, 8, 'Lima', 'Lima', 1, '0000-00-00 00:00:00'),
(192, 4, 'Edinburgh', '', 1, '0000-00-00 00:00:00'),
(194, 2, 'New York', '', 1, '0000-00-00 00:00:00'),
(196, 4, 'London', '', 1, '0000-00-00 00:00:00'),
(197, 10, 'Dubai', '', 1, '0000-00-00 00:00:00'),
(198, 11, 'Moscow', '', 1, '0000-00-00 00:00:00'),
(199, 12, 'Tokyo', '', 1, '0000-00-00 00:00:00'),
(200, 13, 'Johannesburg', '', 1, '0000-00-00 00:00:00'),
(201, 14, 'Munich', '', 1, '0000-00-00 00:00:00');

DROP TABLE IF EXISTS `#__jsplocation_branchhits`;
CREATE TABLE IF NOT EXISTS `#__jsplocation_branchhits` (
 `id` INT NOT NULL AUTO_INCREMENT ,
`branch` VARCHAR( 255 ) ,
`hits` INT ,
`date` DATE ,
PRIMARY KEY ( `id` )
) ENGINE = MyISAM  AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `#__jsplocation_ziphits`;
CREATE TABLE IF NOT EXISTS `#__jsplocation_ziphits` (
 `id` INT NOT NULL AUTO_INCREMENT ,
`zip` VARCHAR( 255 ) ,
`hits` INT ,
`date` DATE ,
PRIMARY KEY ( `id` )
) ENGINE = MyISAM  AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `#__jsplocation_directory_path`;

CREATE TABLE IF NOT EXISTS `#__jsplocation_directory_path` (
  `id` int(11) NOT NULL,
  `directorypath` text NOT NULL,
  `branch` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = MyISAM  AUTO_INCREMENT=1;

--
-- Dumping data for table `opltb_jsplocation_directory_path`
--

INSERT INTO `#__jsplocation_directory_path` (`id`, `directorypath`, `branch`) VALUES
(0, 'images/jsplocationimages/jsplocationImages/', '1 Wall Street');

-- --------------------------------------------------------

--
-- Table structure for table `#__jsplocation_gplaces_temp`
--

CREATE TABLE IF NOT EXISTS `#__jsplocation_gplaces_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `address` varchar(256) NOT NULL,
  `latitude` varchar(256) NOT NULL,
  `longitude` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `#__jsplocation_gplaces_temp`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__jsplocation_gplaces_apikey`
--

CREATE TABLE IF NOT EXISTS `#__jsplocation_gplaces_apikey` (
  `id` int(11) NOT NULL,
  `name` varchar(265) NOT NULL,
  `apikey` varchar(265) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__jsplocation_gplaces_apikey`
--