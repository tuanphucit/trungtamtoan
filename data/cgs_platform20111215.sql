-- phpMyAdmin SQL Dump
-- version 2.7.0-pl2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Dec 15, 2011 at 08:49 AM
-- Server version: 5.1.41
-- PHP Version: 5.3.1
-- 
-- Database: `cgs_platform`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `layout`
-- 

CREATE TABLE `layout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `layout_name` varchar(255) DEFAULT NULL COMMENT 'Tên layout',
  `brief` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- 
-- Dumping data for table `layout`
-- 

INSERT INTO `layout` VALUES (1, 'master_admin.htm', NULL);
INSERT INTO `layout` VALUES (2, 'master_home.htm', NULL);
INSERT INTO `layout` VALUES (3, 'master_system.htm', NULL);
INSERT INTO `layout` VALUES (4, 'master_default_frontend.htm', NULL);
INSERT INTO `layout` VALUES (5, 'master_codegen.htm', NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `module`
-- 

CREATE TABLE `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `brief` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

-- 
-- Dumping data for table `module`
-- 

INSERT INTO `module` VALUES (1, 'system/MainAdv.php', 'system/MainAdv.php', NULL);
INSERT INTO `module` VALUES (35, 'system/SystemLogin.php', 'system/SystemLogin.php', NULL);
INSERT INTO `module` VALUES (30, 'system/SystemHeader.php', 'system/SystemHeader.php', NULL);
INSERT INTO `module` VALUES (5, 'system/MainLogin.php', 'system/MainLogin.php', NULL);
INSERT INTO `module` VALUES (6, 'system/SysMain.php', 'system/SysMain.php', NULL);
INSERT INTO `module` VALUES (29, 'system/SystemFooter.php', 'system/SystemFooter.php', NULL);
INSERT INTO `module` VALUES (28, 'system/SystemLayouts.php', 'system/SystemLayouts.php', NULL);
INSERT INTO `module` VALUES (10, 'system/SystemSetting.php', 'system/SystemSetting.php', NULL);
INSERT INTO `module` VALUES (11, 'system/SystemHint.php', 'system/SystemHint.php', NULL);
INSERT INTO `module` VALUES (41, 'system/SystemGenModel.php', 'system/SystemGenModel.php', NULL);
INSERT INTO `module` VALUES (13, 'system/SystemSide.php', 'system/SystemSide.php', NULL);
INSERT INTO `module` VALUES (14, 'system/SystemDebug.php', 'system/SystemDebug.php', NULL);
INSERT INTO `module` VALUES (15, 'system/SystemCache.php', 'system/SystemCache.php', NULL);
INSERT INTO `module` VALUES (16, 'system/SystemPortal.php', 'system/SystemPortal.php', NULL);
INSERT INTO `module` VALUES (17, 'system/SystemPortalAdd.php', 'system/SystemPortalAdd.php', NULL);
INSERT INTO `module` VALUES (18, 'system/SystemPortalEdit.php', 'system/SystemPortalEdit.php', NULL);
INSERT INTO `module` VALUES (19, 'system/SystemPageAdd.php', 'system/SystemPageAdd.php', NULL);
INSERT INTO `module` VALUES (20, 'system/SystemPage.php', 'system/SystemPage.php', NULL);
INSERT INTO `module` VALUES (21, 'system/SystemPageEdit.php', 'system/SystemPageEdit.php', NULL);
INSERT INTO `module` VALUES (22, 'system/SystemModule.php', 'system/SystemModule.php', NULL);
INSERT INTO `module` VALUES (23, 'test/Test.php', 'test/Test.php', NULL);
INSERT INTO `module` VALUES (24, 'default/frontend/DefaultHeader.php', 'default/frontend/DefaultHeader.php', NULL);
INSERT INTO `module` VALUES (25, 'default/frontend/DefaultNavigation.php', 'default/frontend/DefaultNavigation.php', NULL);
INSERT INTO `module` VALUES (26, 'default/frontend/DefaultSide.php', 'default/frontend/DefaultSide.php', NULL);
INSERT INTO `module` VALUES (27, 'default/frontend/DefaultFooter.php', 'default/frontend/DefaultFooter.php', NULL);
INSERT INTO `module` VALUES (31, 'system/SystemPathway.php', 'system/SystemPathway.php', NULL);
INSERT INTO `module` VALUES (32, 'system/SystemNavigation.php', 'system/SystemNavigation.php', NULL);
INSERT INTO `module` VALUES (33, 'system/SystemLog.php', 'system/SystemLog.php', NULL);
INSERT INTO `module` VALUES (34, 'codegen/CodegenHeader.php', 'codegen/CodegenHeader.php', NULL);
INSERT INTO `module` VALUES (36, 'system/SystemPermission.php', 'system/SystemPermission.php', NULL);
INSERT INTO `module` VALUES (37, 'system/SystemLogout.php', 'system/SystemLogout.php', NULL);
INSERT INTO `module` VALUES (38, 'mybooking/MybookingFooter.php', 'mybooking/MybookingFooter.php', NULL);
INSERT INTO `module` VALUES (39, 'mybooking/MybookingHeader.php', 'mybooking/MybookingHeader.php', NULL);
INSERT INTO `module` VALUES (40, 'mybooking/backend/ImportHotel.php', 'mybooking/backend/ImportHotel.php', NULL);
INSERT INTO `module` VALUES (42, 'system/SystemGenUi.php', 'system/SystemGenUi.php', NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `page`
-- 

CREATE TABLE `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(255) NOT NULL,
  `brief` varchar(255) DEFAULT NULL,
  `layout` varchar(255) DEFAULT NULL,
  `modules` text,
  `portal_id` int(11) NOT NULL,
  `master_id` int(11) DEFAULT NULL,
  `publish_flg` enum('0','1') NOT NULL DEFAULT '1',
  `time_inserted` int(11) DEFAULT '0',
  `time_updated` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- 
-- Dumping data for table `page`
-- 

INSERT INTO `page` VALUES (1, 'master_admin', 'Trang chá»§ cá»§a pháº§n Quáº£n trá»‹ ná»™i dung', 'master_admin.htm', '{"header":["system\\/MainHeader.php"],"footer":["system\\/MainFooter.php"],"navigation":["system\\/SysNavigation.php"]}', 1, 0, '1', 1303111785, 1315242484, '', 'KhÃ´ng cÃ³ gÃ¬', 'cgs,system');
INSERT INTO `page` VALUES (2, 'master_main', 'Trang chá»§ chá»©c nÄƒng', 'master_default_frontend.htm', '{"header":["default\\/frontend\\/DefaultHeader.php"],"side":["default\\/frontend\\/DefaultSide.php"],"navigation":["default\\/frontend\\/DefaultNavigation.php"],"footer":["default\\/frontend\\/DefaultFooter.php"]}', 2, 0, '1', 1303112051, 1307525191, 'CÃ´ng ty CGS.,JSC', 'CÃ´ng ty láº­p trÃ¬nh website', 'cgs,software');
INSERT INTO `page` VALUES (3, 'news', 'Trang tin tá»©c', 'master_default_frontend.htm', '{"center":[],"side":["system\\/SysSide.php"]}', 2, 2, '1', 1306752925, 1307853741, 'Tin tá»©c', '', '');
INSERT INTO `page` VALUES (4, 'about', 'About-US', 'master_default_frontend.htm', '{"header":[]}', 2, 2, '1', 1306753030, 0, NULL, NULL, NULL);
INSERT INTO `page` VALUES (5, 'contact', 'Contact-US', 'master_default_frontend.htm', NULL, 2, 2, '1', 1306753076, 0, NULL, NULL, NULL);
INSERT INTO `page` VALUES (6, 'category', 'Category', 'master_default_frontend.htm', NULL, 2, 2, '1', 1306753157, 0, NULL, NULL, NULL);
INSERT INTO `page` VALUES (7, 'master_hotel', 'abc', 'master_admin.htm', '{"header":["system\\/MainHeader.php"],"side":["system\\/SystemSide.php"],"center":["system\\/SystemDebug.php","system\\/SystemPortalAdd.php"],"footer":["system\\/MainFooter.php"]}', 8, 0, '1', 1314437128, 1314437151, '', '', '');
INSERT INTO `page` VALUES (8, 'fdgd', 'fdgd', 'master_admin.htm', NULL, 1, 4, '1', 1315058362, 1315159777, '', 'fdg', 'dgd');
INSERT INTO `page` VALUES (11, 'test', 'Test thu thoi', 'master_admin.htm', '{"side":["default\\/frontend\\/DefaultAdv.php","system\\/SysMain.php","system\\/SysPortal.php"]}', 2, 1, '1', 1315155170, 1315852092, 'Test thoi', 'Khong co gi ca', 'Gi day');
INSERT INTO `page` VALUES (13, 'index', 'Trang chá»§', 'master_codegen.htm', '{"header":["codegen\\/CodegenHeader.php"]}', 9, 0, '1', 1316922550, 0, '', '', '');
INSERT INTO `page` VALUES (14, '_master_home', 'Trang Master', 'master_codegen.htm', NULL, 11, 0, '1', 1317359266, 0, '', '', '');
INSERT INTO `page` VALUES (15, 'index', '', 'master_admin.htm', NULL, 12, 16, '1', 1317957654, 1317958000, 'Trang chu he thong', '', '');
INSERT INTO `page` VALUES (16, '__master_system', 'Master Dung cho He thong', 'master_admin.htm', '{"header":["system\\/SystemPermission.php","system\\/SystemHeader.php"],"navigation":["system\\/SystemNavigation.php"],"pathway":["system\\/SystemPathway.php"],"side":["system\\/SystemSide.php"],"footer":["system\\/SystemFooter.php"]}', 12, 0, '1', 1317957742, 0, 'Master', '', '');
INSERT INTO `page` VALUES (17, 'index', 'Trang chu', 'master_admin.htm', NULL, 11, 14, '1', 1318303810, 0, 'MyBooking::Äáº·t phÃ²ng khÃ¡ch sáº¡n', 'Äáº·t phÃ²ng khÃ¡ch sáº¡n ONLINE', 'mybooking,dat phong,Ä‘áº·t phÃ²ng,khÃ¡ch sáº¡n,khach san,hotel');
INSERT INTO `page` VALUES (18, 'codegen', 'generate coding', 'master_admin.htm', NULL, 12, 16, '1', 1318782454, 0, 'Generate Coding', '', '');
INSERT INTO `page` VALUES (19, 'gen_model', 'Generate MODEL from database', 'master_admin.htm', '{"center":["system\\/SystemGenModel.php"]}', 12, 16, '1', 1318785464, 0, '', '', '');
INSERT INTO `page` VALUES (20, 'gen_ui', 'Generate UI from XML', 'master_admin.htm', NULL, 12, 16, '1', 1318785488, 0, '', '', '');

-- --------------------------------------------------------

-- 
-- Table structure for table `portal`
-- 

CREATE TABLE `portal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `portal_name` varchar(255) NOT NULL,
  `brief` varchar(255) DEFAULT NULL,
  `publish_flg` enum('0','1') NOT NULL DEFAULT '1',
  `time_inserted` int(11) DEFAULT '0',
  `time_updated` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- 
-- Dumping data for table `portal`
-- 

INSERT INTO `portal` VALUES (1, 'admin', 'Quáº£n trá»‹ ná»™i dung trang chá»§', '1', 1303111527, 1314038643);
INSERT INTO `portal` VALUES (2, 'main', 'Trang chá»§ máº·c Ä‘á»‹nh', '1', 1303111562, 0);
INSERT INTO `portal` VALUES (9, 'codegen', '', '1', 1316922376, 1317357527);
INSERT INTO `portal` VALUES (11, 'mybooking', 'Há»‡ thá»‘ng quáº£n trá»‹ Äáº·t phÃ²ng khÃ¡ch sáº¡n', '1', 1317359165, 0);
INSERT INTO `portal` VALUES (12, 'system', 'He thong', '1', 1317957624, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `setting`
-- 

CREATE TABLE `setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `brief` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

-- 
-- Dumping data for table `setting`
-- 

INSERT INTO `setting` VALUES (1, 'HINT_LAYOUT_ENABLE', '0', NULL);
INSERT INTO `setting` VALUES (2, 'HINT_LAYOUT_COLOR', '', NULL);
INSERT INTO `setting` VALUES (3, 'HINT_LAYOUT_STYLE', '', NULL);
INSERT INTO `setting` VALUES (4, 'HINT_BLOCK_ENABLE', '0', NULL);
INSERT INTO `setting` VALUES (5, 'HINT_BLOCK_COLOR', '', NULL);
INSERT INTO `setting` VALUES (6, 'HINT_BLOCK_STYLE', '', NULL);
INSERT INTO `setting` VALUES (7, 'HINT_SYSTEM_MODULE_ENABLE', '0', NULL);
INSERT INTO `setting` VALUES (8, 'DEBUG_ENABLE', '1', NULL);
INSERT INTO `setting` VALUES (9, 'DEBUG_GENERAL_INFORMATION', '0', NULL);
INSERT INTO `setting` VALUES (10, 'DEBUG_LAYOUT_POSITION_FLUGIN', '1', NULL);
INSERT INTO `setting` VALUES (11, 'DEBUG_SQL_QUERY', '1', NULL);
INSERT INTO `setting` VALUES (12, 'DEBUG_INCLUDES_FILE', '1', NULL);
INSERT INTO `setting` VALUES (13, 'DEBUG_VAR', '1', NULL);
INSERT INTO `setting` VALUES (14, 'DEBUG_LANG', '1', NULL);
INSERT INTO `setting` VALUES (15, 'HINT_LAYOUT_WIDTH', '', NULL);
INSERT INTO `setting` VALUES (16, 'HINT_BLOCK_WIDTH', '', NULL);
INSERT INTO `setting` VALUES (17, 'DEBUG_ERROR', '1', NULL);
INSERT INTO `setting` VALUES (18, 'CACHE_ENABLE', '1', NULL);
INSERT INTO `setting` VALUES (19, 'CACHE_SQL', '1', NULL);
INSERT INTO `setting` VALUES (20, 'CACHE_SQL_TIME', '0', NULL);
INSERT INTO `setting` VALUES (21, 'CACHE_URI', '0', NULL);
INSERT INTO `setting` VALUES (22, 'CACHE_URI_TIME', '0', NULL);
INSERT INTO `setting` VALUES (23, 'CACHE_MODULE', '0', NULL);
INSERT INTO `setting` VALUES (24, 'CACHE_MODULE_TIME', '0', NULL);
INSERT INTO `setting` VALUES (25, 'REWRITE_URL', '0', NULL);
INSERT INTO `setting` VALUES (26, 'DEBUG_REQUEST', '0', NULL);
INSERT INTO `setting` VALUES (27, 'CACHE_JS', '0', NULL);
INSERT INTO `setting` VALUES (28, 'CACHE_JS_TIME', '0', NULL);
INSERT INTO `setting` VALUES (29, 'CACHE_CSS', '0', NULL);
INSERT INTO `setting` VALUES (30, 'CACHE_CSS_TIME', '0', NULL);
INSERT INTO `setting` VALUES (31, 'LOG_ENABLE', '1', NULL);
INSERT INTO `setting` VALUES (32, 'LOG_ERROR', '1', NULL);
INSERT INTO `setting` VALUES (33, 'LOG_SQL', '0', NULL);
INSERT INTO `setting` VALUES (34, 'LOG_SQL_VIEW', '0', NULL);
INSERT INTO `setting` VALUES (35, 'LOG_SQL_ADD', '1', NULL);
INSERT INTO `setting` VALUES (36, 'LOG_SQL_EDIT', '1', NULL);
INSERT INTO `setting` VALUES (37, 'LOG_SQL_DELETE', '1', NULL);
INSERT INTO `setting` VALUES (38, 'LOG_SQL_OTHER', '1', NULL);
INSERT INTO `setting` VALUES (39, 'LOG_SQL_SLOW', '1', NULL);
INSERT INTO `setting` VALUES (40, 'LOG_SQL_SLOW_TIME', '0.5', NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `user`
-- 

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL DEFAULT '',
  `password_salt` varchar(10) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT '0000-00-00',
  `gender` tinyint(1) DEFAULT '0',
  `address` text,
  `telephone` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `homepage` varchar(255) DEFAULT NULL,
  `active_flg` tinyint(1) DEFAULT '1',
  `insert_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `display_flg` tinyint(1) NOT NULL DEFAULT '1',
  `delete_flg` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `user`
-- 

INSERT INTO `user` VALUES (1, 'admin', 'ea9e4c04b4bbbefcd19c2dbecbe41f90', 'abcd', 'admin@cgs.vn', NULL, NULL, NULL, '0000-00-00', 0, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0);
