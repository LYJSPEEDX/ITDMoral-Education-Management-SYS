-- phpMyAdmin SQL Dump
-- version 4.8.0-rc1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2018-04-06 12:53:13
-- 服务器版本： 5.6.33
-- PHP Version: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `itdmoral`
--

-- --------------------------------------------------------

--
-- 表的结构 `detail`
--

CREATE TABLE `detail` (
  `ID` int(11) NOT NULL COMMENT '唯一事件号',
  `sid` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '学号',
  `reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '原因',
  `schange` int(11) NOT NULL COMMENT '分数变动'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `oper_record`
--

CREATE TABLE `oper_record` (
  `id` int(11) NOT NULL,
  `operator` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '操作者',
  `evenid` text COLLATE utf8_bin NOT NULL COMMENT '事件号 DEL表示删除',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '时间戳',
  `note` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `students`
--

CREATE TABLE `students` (
  `ID` int(11) NOT NULL COMMENT '唯一学生标识码',
  `sid` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '学号',
  `name` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '姓名',
  `score` int(11) NOT NULL COMMENT '分数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='全级基本表';

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `usrname` varchar(15) CHARACTER SET utf8 NOT NULL COMMENT '用户ID，登录名',
  `sid` varchar(4) CHARACTER SET utf8 NOT NULL COMMENT '学号',
  `pw` varchar(32) CHARACTER SET utf8 NOT NULL,
  `status` varchar(6) CHARACTER SET utf8 NOT NULL COMMENT '用户状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='用户表';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail`
--
ALTER TABLE `detail`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `oper_record`
--
ALTER TABLE `oper_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `detail`
--
ALTER TABLE `detail`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '唯一事件号';

--
-- 使用表AUTO_INCREMENT `oper_record`
--
ALTER TABLE `oper_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
