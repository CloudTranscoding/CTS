-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2021-08-03 16:55:40
-- 服务器版本： 8.0.24
-- PHP 版本： 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `sql_zhua_eu`
--

-- --------------------------------------------------------

--
-- 表的结构 `cts_abuse`
--

CREATE TABLE `cts_abuse` (
  `abuse_id` int NOT NULL,
  `abuse_videoid` int NOT NULL,
  `abuse_username` varchar(20) NOT NULL,
  `abuse_dateadded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- 表的结构 `cts_categories`
--

CREATE TABLE `cts_categories` (
  `category_id` int NOT NULL,
  `category_name` text NOT NULL,
  `category_desc` text NOT NULL,
  `category_dateadded` mediumtext NOT NULL,
  `category_thumb` mediumtext NOT NULL,
  `isdefault` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- 转存表中的数据 `cts_categories`
--

INSERT INTO `cts_categories` (`category_id`, `category_name`, `category_desc`, `category_dateadded`, `category_thumb`, `isdefault`) VALUES
(1, '默认', '', '', '', 'yes'),
(2, '音乐', '', '', '', 'no'),
(3, '电影', '', '', '', 'no');

-- --------------------------------------------------------

--
-- 表的结构 `cts_config`
--

CREATE TABLE `cts_config` (
  `configid` int NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `value` mediumtext NOT NULL,
  `status` int NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- 转存表中的数据 `cts_config`
--

INSERT INTO `cts_config` (`configid`, `name`, `value`, `status`) VALUES
(1, 'dir_output', 'Ymd', 0),
(2, 'cov_vbit', '700', 0),
(3, 'cov_abit', '128', 0),
(4, 'cov_size', '720:-1', 0),
(5, 'cov_skiptime', '00:00:00', 0),
(6, 'cov_watermark', 'off', 0),
(7, 'cov_position', 'TL', 0),
(8, 'cov_watermarkpic', 'watermark.png', 0),
(9, 'cov_hlsaes', 'off', 0),
(10, 'cov_hlststime', '10', 0),
(11, 'cov_hlsfake', 'ts', 0),
(12, 'cov_hls', 'on', 0),
(13, 'sys_domain', 'http://127.0.0.1', 0),
(14, 'sys_name', 'CTS', 0),
(15, 'sys_license', '123456', 0);

-- --------------------------------------------------------

--
-- 表的结构 `cts_queue`
--

CREATE TABLE `cts_queue` (
  `queue_id` int NOT NULL,
  `queue_pid` varchar(255) NOT NULL,
  `queue_status` int NOT NULL DEFAULT '9',
  `queue_dateadded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- 表的结构 `cts_video`
--

CREATE TABLE `cts_video` (
  `video_id` bigint NOT NULL,
  `video_relid` mediumtext NOT NULL,
  `video_key` varchar(255) NOT NULL,
  `video_hash` varchar(255) NOT NULL,
  `video_categoryid` varchar(20) NOT NULL DEFAULT '1',
  `video_serverid` varchar(20) NOT NULL DEFAULT '1',
  `video_title` mediumtext NOT NULL,
  `video_description` mediumtext,
  `video_tags` mediumtext,
  `video_filename` mediumtext NOT NULL,
  `video_output` varchar(255) NOT NULL,
  `video_duration` varchar(255) NOT NULL DEFAULT '0',
  `video_filesize` varchar(255) DEFAULT NULL,
  `video_dateadded` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `video_createddate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `video_status` int NOT NULL DEFAULT '9',
  `video_active` char(3) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- 转存表中的数据 `cts_video`
--

INSERT INTO `cts_video` (`video_id`, `video_relid`, `video_key`, `video_hash`, `video_categoryid`, `video_serverid`, `video_title`, `video_description`, `video_tags`, `video_filename`, `video_output`, `video_duration`, `video_filesize`, `video_dateadded`, `video_createddate`, `video_status`, `video_active`) VALUES
(1, 'EESqHjFlYw', '6108f096d7153', 'd397da689de1b6d8d004798fb4debb91', '3', '1', '测试', '1627970211670', '测试', '/www/wwwroot/cts.zhua.eu/upload/original/6108f096d7153.mp4', '20210803/EESqHjFlYw', '15.000000', '2949159', '0000-00-00 00:00:00', '2021-08-03 00:00:00', 2, '0'),
(2, '5XqHCJAKqa', '6108f0fc7fd5d', 'cb3b8447ac8da9bcbdc9134dc945f70a', '0', '1', '韩国交通事故', '9c4e73343ef805f5f2b46c91dc711380', 'korean traffic accident', '/www/wwwroot/cts.zhua.eu/upload/original/6108f0fc7fd5d.mp4', '20210803/5XqHCJAKqa', '29.300000', '6732992', '0000-00-00 00:00:00', '2021-08-03 00:00:00', 2, '0');

-- --------------------------------------------------------

--
-- 表的结构 `encoding`
--

CREATE TABLE `encoding` (
  `id` bigint NOT NULL,
  `label` varchar(99) NOT NULL DEFAULT '',
  `width` int NOT NULL DEFAULT '0',
  `height` int NOT NULL DEFAULT '0',
  `crf` tinyint NOT NULL DEFAULT '18',
  `preset` enum('ultrafast','superfast','veryfast','faster','fast','medium','slow','slower','veryslow','placebo') NOT NULL DEFAULT 'fast',
  `faststart` enum('1','0') NOT NULL DEFAULT '1',
  `ios` enum('-profile:v baseline -level 3.0','-profile:v baseline -level 3.1','-profile:v main -level 3.1','-profile:v main -level 4.0','-profile:v high -level 4.0','-profile:v high -level 4.1','-profile:v high -level 4.2') DEFAULT NULL,
  `format` varchar(99) DEFAULT 'mp4',
  `copyonly` enum('1','0') NOT NULL DEFAULT '1',
  `status` enum('1','0') NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- 转存表中的数据 `encoding`
--

INSERT INTO `encoding` (`id`, `label`, `width`, `height`, `crf`, `preset`, `faststart`, `ios`, `format`, `copyonly`, `status`) VALUES
(1, '240p', 320, 240, 23, 'medium', '1', '', 'mp4', '1', '1'),
(2, '360p', 480, 360, 23, 'medium', '1', '', 'mp4', '1', '1'),
(3, '480p', 640, 480, 23, 'medium', '1', '', 'mp4', '1', '1'),
(4, '720p', 1280, 720, 23, 'medium', '1', '', 'mp4', '1', '1'),
(5, '1080p', 1920, 1080, 20, 'fast', '1', '', 'mp4', '1', '1');

-- --------------------------------------------------------

--
-- 表的结构 `video_formats`
--

CREATE TABLE `video_formats` (
  `format_id` smallint UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `ext` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `resolution` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `postfix` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `nice_priority` tinyint NOT NULL DEFAULT '0',
  `resize` tinyint(1) NOT NULL DEFAULT '0',
  `width` smallint NOT NULL DEFAULT '0',
  `height` smallint NOT NULL DEFAULT '0',
  `min_width` smallint NOT NULL DEFAULT '0',
  `min_height` smallint NOT NULL DEFAULT '0',
  `min_bitrate` smallint NOT NULL DEFAULT '0',
  `max_width` smallint NOT NULL DEFAULT '0',
  `max_height` smallint NOT NULL DEFAULT '0',
  `max_bitrate` smallint NOT NULL DEFAULT '0',
  `conversion` tinyint(1) NOT NULL DEFAULT '0',
  `trailer` tinyint(1) NOT NULL DEFAULT '0',
  `copied` tinyint(1) NOT NULL DEFAULT '0',
  `video_codec` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `video_preset` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `video_profile` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `video_level` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `video_max_rate` smallint NOT NULL DEFAULT '0',
  `video_bufsize` smallint NOT NULL DEFAULT '0',
  `video_bitrate` smallint NOT NULL DEFAULT '0',
  `video_crf` tinyint NOT NULL DEFAULT '0',
  `video_options` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `audio_codec` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `audio_bitrate` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `audio_samplerate` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `audio_options` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `hls` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `watermark` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `watermark_pos` tinyint(1) NOT NULL DEFAULT '0',
  `total_files` int UNSIGNED NOT NULL DEFAULT '0',
  `add_time` int UNSIGNED NOT NULL DEFAULT '0',
  `add_user_id` mediumint UNSIGNED NOT NULL DEFAULT '0',
  `edit_time` int UNSIGNED NOT NULL DEFAULT '0',
  `edit_user_id` mediumint UNSIGNED NOT NULL DEFAULT '0',
  `mobile` tinyint(1) NOT NULL DEFAULT '0',
  `position` int NOT NULL DEFAULT '0',
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `duration` smallint NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `video_formats`
--

INSERT INTO `video_formats` (`format_id`, `name`, `ext`, `resolution`, `postfix`, `nice_priority`, `resize`, `width`, `height`, `min_width`, `min_height`, `min_bitrate`, `max_width`, `max_height`, `max_bitrate`, `conversion`, `trailer`, `copied`, `video_codec`, `video_preset`, `video_profile`, `video_level`, `video_max_rate`, `video_bufsize`, `video_bitrate`, `video_crf`, `video_options`, `audio_codec`, `audio_bitrate`, `audio_samplerate`, `audio_options`, `hls`, `watermark`, `watermark_pos`, `total_files`, `add_time`, `add_user_id`, `edit_time`, `edit_user_id`, `mobile`, `position`, `required`, `status`, `duration`) VALUES
(1, 'MP4 240p', 'mp4', '240p', '_240p', 8, 1, 426, 240, 0, 1, 0, 0, 0, 0, 1, 0, 0, 'libx264', 'medium', 'baseline', '3.0', 600, 1200, 0, 20, '-threads 0 -r 25', 'aac', '128', '44100', '', 1, '0', 3, 0, 1473620209, 1, 1521618254, 1, 1, 1, 1, 1, 60),
(2, 'MP4 360p', 'mp4', '360p', '_360p', 8, 1, 640, 360, 0, 360, 0, 0, 0, 0, 1, 0, 0, 'libx264', 'medium', 'main', '3.1', 1000, 2000, 0, 20, '-threads 0 -r 25', 'aac', '128', '44100', '', 1, '0', 0, 0, 1473628018, 1, 1521618262, 1, 0, 2, 0, 1, 60),
(3, 'MP4 480p', 'mp4', '480p', '_480p', 8, 1, 854, 480, 0, 479, 0, 0, 0, 0, 1, 0, 0, 'libx264', 'medium', 'main', '3.1', 1500, 3000, 0, 20, '-threads 0 -r 25', 'aac', '128', '44100', '', 1, '0', 0, 0, 1473628045, 1, 1521618268, 1, 0, 3, 0, 1, 60),
(4, 'MP4 720p', 'mp4', '720p', '_720p', 8, 1, 1280, 720, 0, 720, 0, 0, 0, 0, 1, 0, 0, 'libx264', 'medium', 'main', '4.0', 2000, 4000, 0, 20, '-threads 0 -r 25', 'aac', '128', '44100', '', 1, '0', 0, 0, 1473628100, 1, 1521618274, 1, 0, 4, 0, 1, 60),
(5, 'MP4 1080p', 'mp4', '1080p', '_1080p', 8, 1, 1920, 1080, 0, 1080, 0, 0, 0, 0, 1, 0, 0, 'libx264', 'medium', 'high', '4.2', 4000, 6000, 0, 20, '-threads 0 -r 25', 'aac', '128', '44100', '', 1, '0', 0, 0, 1473628138, 1, 1521618282, 1, 0, 5, 0, 1, 60);

--
-- 转储表的索引
--

--
-- 表的索引 `cts_abuse`
--
ALTER TABLE `cts_abuse`
  ADD PRIMARY KEY (`abuse_id`);

--
-- 表的索引 `cts_categories`
--
ALTER TABLE `cts_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- 表的索引 `cts_config`
--
ALTER TABLE `cts_config`
  ADD PRIMARY KEY (`configid`);

--
-- 表的索引 `cts_queue`
--
ALTER TABLE `cts_queue`
  ADD UNIQUE KEY `queue_id` (`queue_id`);

--
-- 表的索引 `cts_video`
--
ALTER TABLE `cts_video`
  ADD PRIMARY KEY (`video_id`),
  ADD UNIQUE KEY `video_hash` (`video_hash`);

--
-- 表的索引 `video_formats`
--
ALTER TABLE `video_formats`
  ADD PRIMARY KEY (`format_id`),
  ADD KEY `sp` (`status`,`position`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `cts_abuse`
--
ALTER TABLE `cts_abuse`
  MODIFY `abuse_id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `cts_categories`
--
ALTER TABLE `cts_categories`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `cts_config`
--
ALTER TABLE `cts_config`
  MODIFY `configid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- 使用表AUTO_INCREMENT `cts_video`
--
ALTER TABLE `cts_video`
  MODIFY `video_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `video_formats`
--
ALTER TABLE `video_formats`
  MODIFY `format_id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
