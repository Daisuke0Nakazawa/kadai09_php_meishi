-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2023-01-26 15:46:00
-- サーバのバージョン： 10.4.27-MariaDB
-- PHP のバージョン: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `gs_db`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `ga_image_table`
--

CREATE TABLE `ga_image_table` (
  `id` int(12) NOT NULL,
  `title` varchar(64) NOT NULL,
  `content` varchar(256) NOT NULL,
  `img` varchar(256) NOT NULL,
  `date` datetime NOT NULL,
  `update_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `ga_image_table`
--

INSERT INTO `ga_image_table` (`id`, `title`, `content`, `img`, `date`, `update_time`) VALUES
(0, 'nakazawa', '名刺', '20230125155541_nakazawameisi.JPG', '2023-01-25 23:55:41', '0000-00-00 00:00:00'),
(0, 'あああ', 'ｓｓｓ', '20230125160001_nakazawameisi.JPG', '2023-01-26 00:00:01', '0000-00-00 00:00:00'),
(0, 'ffff', 'gdsgeg', '20230125160100_happy-birthday.png', '2023-01-26 00:01:00', '0000-00-00 00:00:00'),
(0, 'aaaaaa', 'aaaaaaaaaaaa', '20230125161259_happy-birthday.png', '2023-01-26 00:12:59', '0000-00-00 00:00:00'),
(0, 'aaaaaa', 'aaaaaaaaaaaa', '', '2023-01-26 00:16:31', '0000-00-00 00:00:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
