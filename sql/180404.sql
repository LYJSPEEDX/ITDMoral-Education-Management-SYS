-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2018 年 04 月 04 日 14:23
-- 服务器版本: 5.6.13
-- PHP 版本: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `itdmoral`
--
CREATE DATABASE IF NOT EXISTS `itdmoral` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `itdmoral`;

-- --------------------------------------------------------

--
-- 表的结构 `oper_record`
--

CREATE TABLE IF NOT EXISTS `oper_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `operator` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '操作者',
  `evenid` int(4) NOT NULL COMMENT '事件号',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '时间戳',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usrname` varchar(15) CHARACTER SET utf8 NOT NULL COMMENT '用户ID，登录名',
  `sid` varchar(4) CHARACTER SET utf8 NOT NULL COMMENT '学号',
  `pw` varchar(32) CHARACTER SET utf8 NOT NULL,
  `status` varchar(6) CHARACTER SET utf8 NOT NULL COMMENT '用户状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='用户表' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
