-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2018 年 03 月 17 日 11:38
-- 服务器版本: 5.6.13
-- PHP 版本: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `simplephp`
--
CREATE DATABASE IF NOT EXISTS `simplephp` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `simplephp`;

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usrid` varchar(15) NOT NULL COMMENT '用户ID，登录名',
  `usrname` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '用户姓名',
  `pw` varchar(32) NOT NULL COMMENT 'MD5之后的密码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `detail`
--

CREATE TABLE IF NOT EXISTS `detail` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `sid` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '学号',
  `reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '原因',
  `schange` int(11) NOT NULL COMMENT '分数变动',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- 表的结构 `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `ID` int(11) NOT NULL COMMENT '唯一学生标识码',
  `sid` varchar(11) COLLATE utf8_unicode_ci NOT NULL COMMENT '学号',
  `name` char(4) COLLATE utf8_unicode_ci NOT NULL COMMENT '姓名',
  `score` int(11) NOT NULL COMMENT '分数',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  UNIQUE KEY `SID` (`sid`),
  KEY `ID_2` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='全级基本表';

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
