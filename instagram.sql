-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 10 2019 г., 12:54
-- Версия сервера: 5.6.38-log
-- Версия PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `instagram`
--

-- --------------------------------------------------------

--
-- Структура таблицы `action_users`
--

CREATE TABLE `action_users` (
  `id` int(11) NOT NULL,
  `action_user` int(11) NOT NULL,
  `action` set('subscribe_user','like_publication','like_comment','add_comment') NOT NULL,
  `object` int(11) NOT NULL,
  `more` int(11) DEFAULT NULL COMMENT 'id объекта с которым произошло действие. Если подписались будет null.',
  `checked` tinyint(1) NOT NULL DEFAULT '0',
  `action_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `action_users`
--

INSERT INTO `action_users` (`id`, `action_user`, `action`, `object`, `more`, `checked`, `action_date`) VALUES
(2, 63, 'subscribe_user', 66, NULL, 0, '2019-04-10 11:28:02'),
(3, 63, 'subscribe_user', 68, NULL, 0, '2019-04-10 11:28:05'),
(4, 63, 'subscribe_user', 71, NULL, 0, '2019-04-10 11:28:09'),
(5, 63, 'subscribe_user', 72, NULL, 1, '2019-04-10 11:28:10'),
(6, 63, 'subscribe_user', 73, NULL, 1, '2019-04-10 11:28:11'),
(7, 63, 'subscribe_user', 53, NULL, 0, '2019-04-10 11:28:16'),
(8, 71, 'subscribe_user', 53, NULL, 0, '2019-04-10 11:28:35'),
(9, 71, 'subscribe_user', 72, NULL, 1, '2019-04-10 11:28:37'),
(10, 71, 'subscribe_user', 68, NULL, 0, '2019-04-10 11:28:39'),
(11, 71, 'subscribe_user', 67, NULL, 0, '2019-04-10 11:28:42'),
(12, 71, 'subscribe_user', 70, NULL, 0, '2019-04-10 11:28:47'),
(13, 69, 'subscribe_user', 68, NULL, 0, '2019-04-10 11:29:07'),
(14, 69, 'subscribe_user', 72, NULL, 1, '2019-04-10 11:29:09'),
(15, 69, 'subscribe_user', 67, NULL, 0, '2019-04-10 11:29:10'),
(16, 69, 'subscribe_user', 71, NULL, 0, '2019-04-10 11:29:14'),
(17, 70, 'subscribe_user', 68, NULL, 0, '2019-04-10 11:29:30'),
(18, 70, 'subscribe_user', 72, NULL, 1, '2019-04-10 11:29:32'),
(19, 70, 'subscribe_user', 67, NULL, 0, '2019-04-10 11:29:34'),
(20, 70, 'subscribe_user', 71, NULL, 0, '2019-04-10 11:29:35'),
(21, 70, 'subscribe_user', 69, NULL, 0, '2019-04-10 11:29:38'),
(22, 67, 'subscribe_user', 68, NULL, 0, '2019-04-10 11:29:55'),
(23, 67, 'subscribe_user', 72, NULL, 1, '2019-04-10 11:29:56'),
(24, 67, 'subscribe_user', 69, NULL, 0, '2019-04-10 11:29:57'),
(25, 67, 'subscribe_user', 71, NULL, 0, '2019-04-10 11:30:01'),
(26, 73, 'subscribe_user', 68, NULL, 0, '2019-04-10 11:30:17'),
(27, 73, 'subscribe_user', 72, NULL, 1, '2019-04-10 11:30:17'),
(28, 73, 'subscribe_user', 53, NULL, 0, '2019-04-10 11:30:19'),
(29, 73, 'subscribe_user', 64, NULL, 0, '2019-04-10 11:30:21'),
(30, 73, 'subscribe_user', 65, NULL, 0, '2019-04-10 11:30:22'),
(31, 73, 'subscribe_user', 70, NULL, 0, '2019-04-10 11:30:24'),
(32, 73, 'subscribe_user', 63, NULL, 1, '2019-04-10 11:30:26'),
(33, 73, 'subscribe_user', 44, NULL, 0, '2019-04-10 11:30:27'),
(34, 68, 'subscribe_user', 72, NULL, 0, '2019-04-10 11:35:10'),
(35, 68, 'subscribe_user', 71, NULL, 0, '2019-04-10 11:35:11'),
(36, 68, 'subscribe_user', 67, NULL, 0, '2019-04-10 11:35:12'),
(37, 68, 'subscribe_user', 69, NULL, 0, '2019-04-10 11:35:14'),
(38, 68, 'subscribe_user', 63, NULL, 1, '2019-04-10 11:35:18'),
(39, 74, 'subscribe_user', 72, NULL, 0, '2019-04-10 11:41:40'),
(40, 74, 'subscribe_user', 71, NULL, 0, '2019-04-10 11:41:42'),
(41, 74, 'subscribe_user', 67, NULL, 0, '2019-04-10 11:41:42'),
(42, 74, 'subscribe_user', 68, NULL, 0, '2019-04-10 11:41:44'),
(43, 74, 'subscribe_user', 69, NULL, 0, '2019-04-10 11:41:45'),
(44, 74, 'subscribe_user', 73, NULL, 0, '2019-04-10 11:41:48'),
(45, 72, 'subscribe_user', 68, NULL, 0, '2019-04-10 11:43:42'),
(46, 72, 'subscribe_user', 69, NULL, 0, '2019-04-10 11:43:43'),
(47, 72, 'subscribe_user', 67, NULL, 0, '2019-04-10 11:43:45'),
(48, 72, 'subscribe_user', 70, NULL, 0, '2019-04-10 11:43:46'),
(49, 72, 'subscribe_user', 63, NULL, 1, '2019-04-10 11:43:49'),
(50, 63, 'subscribe_user', 69, NULL, 0, '2019-04-10 12:01:11'),
(51, 63, 'add_comment', 68, 150, 0, '2019-04-10 12:22:52'),
(52, 63, 'add_comment', 68, 151, 0, '2019-04-10 12:23:05'),
(53, 63, 'add_comment', 68, 152, 0, '2019-04-10 12:23:19'),
(54, 63, 'add_comment', 68, 153, 0, '2019-04-10 12:23:31'),
(55, 63, 'add_comment', 69, 154, 0, '2019-04-10 12:23:40'),
(56, 63, 'add_comment', 71, 155, 0, '2019-04-10 12:23:51'),
(57, 63, 'add_comment', 71, 156, 0, '2019-04-10 12:24:02'),
(58, 63, 'add_comment', 73, 157, 0, '2019-04-10 12:24:24'),
(59, 63, 'add_comment', 72, 158, 0, '2019-04-10 12:24:47'),
(60, 68, 'add_comment', 67, 159, 0, '2019-04-10 12:29:53'),
(61, 68, 'add_comment', 67, 160, 0, '2019-04-10 12:30:00'),
(62, 68, 'add_comment', 67, 161, 0, '2019-04-10 12:30:06'),
(63, 68, 'add_comment', 69, 162, 0, '2019-04-10 12:30:20'),
(64, 68, 'like_comment', 63, 152, 1, '2019-04-10 12:30:47'),
(65, 68, 'like_comment', 63, 151, 1, '2019-04-10 12:30:49'),
(66, 67, 'add_comment', 68, 163, 0, '2019-04-10 12:31:13'),
(67, 67, 'add_comment', 68, 164, 0, '2019-04-10 12:31:28'),
(68, 67, 'like_comment', 63, 151, 1, '2019-04-10 12:31:30'),
(69, 67, 'add_comment', 68, 165, 0, '2019-04-10 12:31:38'),
(70, 67, 'like_comment', 63, 152, 1, '2019-04-10 12:31:39'),
(71, 67, 'add_comment', 68, 166, 0, '2019-04-10 12:31:57'),
(72, 67, 'add_comment', 69, 167, 0, '2019-04-10 12:32:18'),
(73, 67, 'add_comment', 69, 168, 0, '2019-04-10 12:32:40'),
(74, 67, 'add_comment', 71, 169, 0, '2019-04-10 12:32:55'),
(75, 69, 'like_comment', 67, 163, 0, '2019-04-10 12:33:12'),
(76, 69, 'add_comment', 68, 170, 0, '2019-04-10 12:33:24'),
(77, 69, 'like_comment', 67, 164, 0, '2019-04-10 12:33:32'),
(78, 69, 'add_comment', 68, 171, 0, '2019-04-10 12:33:51'),
(79, 69, 'add_comment', 68, 172, 0, '2019-04-10 12:34:22'),
(80, 69, 'like_comment', 67, 166, 0, '2019-04-10 12:34:26'),
(81, 69, 'add_comment', 67, 173, 0, '2019-04-10 12:34:50'),
(82, 69, 'like_comment', 68, 159, 0, '2019-04-10 12:34:54'),
(83, 69, 'add_comment', 67, 174, 0, '2019-04-10 12:35:17'),
(84, 69, 'like_comment', 67, 169, 0, '2019-04-10 12:35:24'),
(85, 69, 'add_comment', 72, 175, 0, '2019-04-10 12:35:40'),
(86, 69, 'like_comment', 63, 158, 1, '2019-04-10 12:35:43'),
(87, 70, 'like_comment', 69, 170, 0, '2019-04-10 12:36:07'),
(88, 70, 'like_comment', 67, 163, 0, '2019-04-10 12:36:08'),
(89, 70, 'add_comment', 68, 176, 0, '2019-04-10 12:36:18'),
(90, 70, 'add_comment', 68, 177, 0, '2019-04-10 12:36:43'),
(91, 70, 'like_comment', 63, 151, 1, '2019-04-10 12:36:45'),
(92, 70, 'add_comment', 68, 178, 0, '2019-04-10 12:36:58'),
(93, 70, 'like_comment', 68, 160, 0, '2019-04-10 12:37:10'),
(94, 70, 'like_comment', 68, 162, 0, '2019-04-10 12:37:14'),
(95, 70, 'like_comment', 69, 175, 0, '2019-04-10 12:37:28'),
(96, 71, 'add_comment', 68, 179, 0, '2019-04-10 12:38:04'),
(97, 71, 'like_comment', 70, 176, 0, '2019-04-10 12:38:06'),
(98, 71, 'add_comment', 68, 180, 0, '2019-04-10 12:38:17'),
(99, 71, 'like_comment', 67, 166, 0, '2019-04-10 12:38:28'),
(100, 71, 'like_comment', 63, 153, 1, '2019-04-10 12:38:29'),
(101, 71, 'like_comment', 69, 173, 0, '2019-04-10 12:38:33'),
(102, 71, 'add_comment', 67, 181, 0, '2019-04-10 12:38:46'),
(103, 71, 'like_comment', 68, 161, 0, '2019-04-10 12:38:53'),
(104, 72, 'add_comment', 63, 182, 1, '2019-04-10 12:39:33'),
(105, 72, 'add_comment', 68, 183, 0, '2019-04-10 12:39:51'),
(106, 72, 'like_comment', 71, 179, 0, '2019-04-10 12:39:56'),
(107, 72, 'like_comment', 69, 170, 0, '2019-04-10 12:39:58'),
(108, 72, 'like_comment', 67, 163, 0, '2019-04-10 12:40:00'),
(109, 72, 'like_comment', 70, 177, 0, '2019-04-10 12:40:05'),
(110, 72, 'add_comment', 68, 184, 0, '2019-04-10 12:40:08'),
(111, 73, 'add_comment', 63, 185, 1, '2019-04-10 12:41:09'),
(112, 73, 'add_comment', 63, 186, 1, '2019-04-10 12:41:17'),
(113, 73, 'add_comment', 72, 187, 0, '2019-04-10 12:41:42'),
(114, 74, 'like_comment', 71, 179, 0, '2019-04-10 12:42:09'),
(115, 74, 'like_comment', 72, 183, 0, '2019-04-10 12:42:09'),
(116, 74, 'like_comment', 63, 154, 1, '2019-04-10 12:42:19'),
(117, 74, 'like_comment', 67, 167, 0, '2019-04-10 12:42:20'),
(118, 74, 'add_comment', 69, 188, 0, '2019-04-10 12:42:24'),
(119, 74, 'subscribe_user', 63, NULL, 1, '2019-04-10 12:42:39'),
(121, 63, 'like_comment', 73, 185, 0, '2019-04-10 12:52:50');

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `parent_id_user` int(11) NOT NULL,
  `parent_id_publication` int(11) NOT NULL,
  `comment` text NOT NULL,
  `likes` int(11) NOT NULL DEFAULT '0',
  `pub_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `parent_id_user`, `parent_id_publication`, `comment`, `likes`, `pub_date`) VALUES
(150, 63, 325, 'прикольная киса, бро)', 0, '2019-04-10 09:22:52'),
(151, 63, 324, 'пиздатая дача', 3, '2019-04-10 09:23:05'),
(152, 63, 323, 'листочки заплакали?', 2, '2019-04-10 09:23:19'),
(153, 63, 321, 'чтоб я так жил', 1, '2019-04-10 09:23:31'),
(154, 63, 315, 'буль буль', 1, '2019-04-10 09:23:40'),
(155, 63, 310, 'круто', 0, '2019-04-10 09:23:51'),
(156, 63, 309, 'люблю космос', 0, '2019-04-10 09:24:02'),
(157, 63, 305, 'как всегда пиздат', 1, '2019-04-10 09:24:24'),
(158, 63, 300, 'night bro', 1, '2019-04-10 09:24:47'),
(159, 68, 319, 'good', 1, '2019-04-10 09:29:53'),
(160, 68, 318, 'nice cat', 1, '2019-04-10 09:30:00'),
(161, 68, 317, 'wow', 1, '2019-04-10 09:30:06'),
(162, 68, 315, 'nice fish', 1, '2019-04-10 09:30:20'),
(163, 67, 325, 'круто', 3, '2019-04-10 09:31:13'),
(164, 67, 324, 'полностью согласен', 1, '2019-04-10 09:31:28'),
(165, 67, 323, 'походу', 0, '2019-04-10 09:31:38'),
(166, 67, 321, 'я так и живу, лол', 3, '2019-04-10 09:31:57'),
(167, 67, 315, 'дайвер епта', 1, '2019-04-10 09:32:18'),
(168, 67, 313, 'красиво', 0, '2019-04-10 09:32:40'),
(169, 67, 309, 'очень красиво', 1, '2019-04-10 09:32:55'),
(170, 69, 325, 'очень мило', 2, '2019-04-10 09:33:24'),
(171, 69, 324, 'мальчики, я к вам!!!', 0, '2019-04-10 09:33:51'),
(172, 69, 321, 'раян, кому я к тебе. жди', 0, '2019-04-10 09:34:22'),
(173, 69, 320, 'крутой коктейль. угостишь?)', 1, '2019-04-10 09:34:50'),
(174, 69, 316, 'у гослинга скопипастил чтоли?', 0, '2019-04-10 09:35:17'),
(175, 69, 300, 'sex', 1, '2019-04-10 09:35:40'),
(176, 70, 325, 'ваще зверь', 1, '2019-04-10 09:36:18'),
(177, 70, 324, 'ого, так много зеленого', 1, '2019-04-10 09:36:43'),
(178, 70, 323, 'люблю зеленый цвет', 0, '2019-04-10 09:36:58'),
(179, 71, 325, 'крутая фотка', 2, '2019-04-10 09:38:04'),
(180, 71, 324, 'очень красиво', 0, '2019-04-10 09:38:17'),
(181, 71, 320, 'я угощу, приезжай киса', 0, '2019-04-10 09:38:46'),
(182, 72, 336, 'bad boy', 0, '2019-04-10 09:39:33'),
(183, 72, 325, 'nice boy', 1, '2019-04-10 09:39:51'),
(184, 72, 324, 'wow', 0, '2019-04-10 09:40:08'),
(185, 73, 337, 'man', 1, '2019-04-10 09:41:09'),
(186, 73, 336, 'nice', 0, '2019-04-10 09:41:17'),
(187, 73, 300, 'мой пездюк. как ты бро?', 0, '2019-04-10 09:41:42'),
(188, 74, 315, 'круто', 0, '2019-04-10 09:42:24');

-- --------------------------------------------------------

--
-- Структура таблицы `hashtags`
--

CREATE TABLE `hashtags` (
  `id` int(11) NOT NULL,
  `parent_id_publication` int(11) NOT NULL,
  `hashtag` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `hashtags`
--

INSERT INTO `hashtags` (`id`, `parent_id_publication`, `hashtag`) VALUES
(11, 297, '#fruit,#summer,#juce'),
(12, 298, '#цветы,#отдых,#лето'),
(13, 300, '#sexy_niger'),
(14, 301, '#вот_так_вот'),
(15, 302, '#отдых,#summer'),
(16, 303, '#вот_так_вот'),
(17, 305, '#вот_так_вот');

-- --------------------------------------------------------

--
-- Структура таблицы `likes_comments`
--

CREATE TABLE `likes_comments` (
  `id_user` int(11) NOT NULL,
  `id_comment` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `likes_comments`
--

INSERT INTO `likes_comments` (`id_user`, `id_comment`) VALUES
(67, 151),
(68, 151),
(70, 151),
(67, 152),
(68, 152),
(71, 153),
(74, 154),
(63, 157),
(69, 158),
(69, 159),
(70, 160),
(71, 161),
(70, 162),
(69, 163),
(70, 163),
(72, 163),
(69, 164),
(67, 166),
(69, 166),
(71, 166),
(74, 167),
(69, 169),
(70, 170),
(72, 170),
(71, 173),
(70, 175),
(71, 176),
(72, 177),
(72, 179),
(74, 179),
(74, 183),
(63, 185);

-- --------------------------------------------------------

--
-- Структура таблицы `likes_publications`
--

CREATE TABLE `likes_publications` (
  `user_id` int(11) NOT NULL,
  `publication_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `likes_publications`
--

INSERT INTO `likes_publications` (`user_id`, `publication_id`) VALUES
(69, 297),
(73, 297),
(69, 298),
(70, 298),
(73, 298),
(69, 299),
(69, 300),
(70, 300),
(71, 300),
(73, 300),
(63, 301),
(63, 303),
(68, 307),
(69, 307),
(68, 308),
(70, 308),
(68, 309),
(69, 309),
(67, 310),
(74, 310),
(68, 311),
(70, 311),
(67, 312),
(68, 312),
(69, 312),
(63, 313),
(67, 313),
(68, 313),
(63, 314),
(68, 314),
(70, 314),
(68, 315),
(70, 315),
(74, 315),
(68, 316),
(69, 316),
(74, 316),
(68, 317),
(71, 317),
(74, 317),
(70, 318),
(68, 319),
(69, 319),
(71, 319),
(69, 320),
(70, 320),
(71, 320),
(63, 321),
(67, 321),
(69, 321),
(70, 321),
(71, 321),
(71, 322),
(63, 323),
(67, 323),
(70, 323),
(71, 323),
(72, 323),
(67, 324),
(70, 324),
(71, 324),
(72, 324),
(74, 324),
(63, 325),
(67, 325),
(69, 325),
(70, 325),
(71, 325),
(72, 325),
(74, 325),
(72, 334),
(72, 336),
(68, 337),
(72, 337),
(73, 337),
(68, 338),
(72, 338),
(73, 338);

-- --------------------------------------------------------

--
-- Структура таблицы `mails`
--

CREATE TABLE `mails` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `mail` varchar(200) NOT NULL,
  `check_news` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mails`
--

INSERT INTO `mails` (`id`, `parent_id`, `mail`, `check_news`) VALUES
(29, 44, 'evdokimov99@mail.ua', 0),
(38, 53, 'vlad.kunchenko@gmail.com', 0),
(48, 63, 'eduard.evdokimov@inbox.ru', 0),
(49, 64, 'mike@mail.com', 0),
(50, 65, 'angela@mail.com', 0),
(51, 66, 'bob@mail.com', 0),
(52, 67, 'jackson@mail.com', 0),
(53, 68, 'gosling@mail.com', 0),
(54, 69, 'Emma@mail.com', 0),
(55, 70, 'Jake_Gyllenhaal@mail.com', 0),
(56, 71, 'russell_crowe@mail.com', 0),
(57, 72, 'scarlett_johansson@mail.com', 0),
(58, 73, 'alexander_nevski@mail.com', 0),
(59, 74, 'JamesMcAvoy@mail.com', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `publications`
--

CREATE TABLE `publications` (
  `id` int(11) NOT NULL,
  `public_id` varchar(12) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  `title` text,
  `pub_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `likes` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `publications`
--

INSERT INTO `publications` (`id`, `public_id`, `parent_id`, `img`, `title`, `pub_date`, `likes`) VALUES
(297, '5bb1ac9bd7f8', 72, 'dedf02d678c4f1484a176a1bef90970a.jpeg', 'fruit)))', '2019-04-10 08:44:35', 2),
(298, 'b336e75a8f0d', 72, 'c0b8e076b81508d2bc617391c48235fe.jpeg', 'perfect цветы', '2019-04-10 08:45:51', 3),
(299, 'de44e8a650d3', 72, 'e7ae78f3cd3ff8556cf143cc5fd091ff.jpeg', NULL, '2019-04-10 08:46:12', 1),
(300, '64111e09ff7d', 72, '8d59e53cf7f319edd1b05371ccc438fb.jpeg', NULL, '2019-04-10 08:46:48', 4),
(301, 'faabd87cd74c', 73, 'b6b9fa0bc2fc28d53728f86a47bbbc0d.jpeg', 'мой пездюк', '2019-04-10 08:49:43', 1),
(302, '7c5221ea8b0b', 73, '8831f0367c162091b9a7587059f2050b.jpeg', 'чил с киской', '2019-04-10 08:50:21', 0),
(303, '3e805efab849', 73, '10c8607f0d30f97ce1915769bf99a2f2.jpeg', 'мой пездюк 2. Возвращение легенды', '2019-04-10 08:51:03', 1),
(304, '4f50d7da0c6f', 73, 'b7e713cb7be4feed22b7cd20cff46436.jpeg', 'night best body', '2019-04-10 08:51:47', 0),
(305, '431f05f2d603', 73, '902d20bdddbea0bd28d4f4cd90d0f43b.jpeg', NULL, '2019-04-10 08:52:10', 0),
(306, '075c0ed828dd', 73, 'd1cc00d844e87aba74d6569800f6f561.jpeg', NULL, '2019-04-10 08:52:30', 0),
(307, '8d449534f165', 71, 'd3c013214606ed41f9a7b59dae9f1cee.jpeg', NULL, '2019-04-10 08:53:46', 2),
(308, '3cbd63c01692', 71, '2d90ea386646808e7295c20991f919da.jpeg', NULL, '2019-04-10 08:53:55', 2),
(309, 'dd5c6bf5fc3a', 71, '9420193395220477db3e786bdae2bcf9.jpeg', NULL, '2019-04-10 08:54:01', 2),
(310, 'b68bf92c3104', 71, 'f55e8b82eb7f9a18236590ab3e9a7e4d.jpeg', NULL, '2019-04-10 08:54:10', 2),
(311, '733e751d4bb9', 71, '45827201c289cc9f19aa6065745d9012.jpeg', NULL, '2019-04-10 08:57:07', 2),
(312, '586aca7ee5f7', 71, '132678f957b2da4788d30875349304be.jpeg', NULL, '2019-04-10 08:57:19', 3),
(313, 'f2f2319063ab', 69, 'aff600f6502d651a90d1c5b6d49eb5db.jpeg', NULL, '2019-04-10 08:57:52', 3),
(314, '2a24a139e431', 69, '091a8f82c9f047b02c6be28a4e54328d.jpeg', NULL, '2019-04-10 08:58:01', 3),
(315, '88a66e8aa786', 69, '0f4a529a0e22fc6b6478fb59279f4064.jpeg', 'ocean', '2019-04-10 08:58:19', 3),
(316, 'acfa2bce94f0', 67, '91f47c95b1c093c9be1e65e0251fc121.jpeg', NULL, '2019-04-10 08:59:17', 3),
(317, 'd7bdf52aea33', 67, '5e3558ba7c4660295cdfa20ac5784bb4.jpeg', NULL, '2019-04-10 08:59:24', 3),
(318, '58b22ab2f58c', 67, '7e4156b91791e60e820059214faf2ec0.jpeg', NULL, '2019-04-10 08:59:31', 1),
(319, 'c895d372ecf1', 67, '6b7fbf7242e80b808b751f9d9469e82a.jpeg', NULL, '2019-04-10 08:59:38', 3),
(320, 'd7f87af75c6b', 67, '804a77bdf04705a4a5c3d7cd39da6450.jpeg', NULL, '2019-04-10 08:59:46', 3),
(321, '069ac0973033', 68, '6cac93f3d7374e3c893b80c30b89a7f9.jpeg', NULL, '2019-04-10 09:00:13', 5),
(322, '387729a24fe5', 68, '88a8cfdfc66c2236b1a3c2a39b2d11c8.jpeg', NULL, '2019-04-10 09:00:21', 1),
(323, '3e20a8eac96b', 68, 'bd0ff22107e679c2477009c4c8675702.jpeg', NULL, '2019-04-10 09:00:26', 5),
(324, '9a88d10a33d1', 68, '4245fe94184143a1cfb91127e136d837.jpeg', NULL, '2019-04-10 09:00:32', 5),
(325, '121f7406e765', 68, '2bfaa57b056c8b786ddb2ed81c920397.jpeg', NULL, '2019-04-10 09:00:38', 7),
(326, '8262c135fa15', 63, 'b5befb4c7dbceac7851a751bf9250e0e.jpeg', NULL, '2019-04-10 09:25:47', 0),
(327, '6212ecdfe58e', 63, '61c638776011ea616a7129c0f33cc587.jpeg', NULL, '2019-04-10 09:27:24', 0),
(328, '0ccd973655c3', 63, 'c599f6e90de39fe307e0ce32d0c18fed.jpeg', NULL, '2019-04-10 09:27:27', 0),
(329, 'db9ab05d4e9f', 63, '7d69fa9023d2f6fdaaea688480700b78.jpeg', NULL, '2019-04-10 09:27:30', 0),
(330, 'd9ee6daba995', 63, '96c6f20232801e94e59a10821c372a92.jpeg', NULL, '2019-04-10 09:27:33', 0),
(331, 'ca2cfa24d1ab', 63, 'b4a54c60ffb040393a96a8a91e732c26.jpeg', NULL, '2019-04-10 09:27:39', 0),
(332, 'e85f628f9a28', 63, '5075ca6240a12c240d02b3c77e477666.jpeg', NULL, '2019-04-10 09:27:46', 0),
(333, '9017839a7c5a', 63, '2f22275a222aaf1e655efd09346eb031.jpeg', NULL, '2019-04-10 09:27:54', 0),
(334, '0564ab9996ca', 63, 'efea87f8b9f8049caff00dcf1c4b3d79.jpeg', NULL, '2019-04-10 09:28:01', 1),
(335, '14c3aa3d0a4c', 63, 'adc4b3996fb74890563b91a3c5e5c06a.jpeg', NULL, '2019-04-10 09:28:11', 0),
(336, '0ceaabd5d888', 63, '7e95b8f3da92b389f7f4c0165dc6d6f2.jpeg', NULL, '2019-04-10 09:28:29', 1),
(337, '22122b7e87e5', 63, '6db70345551395c341a50b0617c0b566.jpeg', NULL, '2019-04-10 09:28:33', 3),
(338, 'b4120ee702eb', 63, '7e42ea31321ff136dcccdb33314e9fa8.jpeg', NULL, '2019-04-10 09:28:37', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `subscribers`
--

CREATE TABLE `subscribers` (
  `id_subscriber` int(11) NOT NULL,
  `sub_object` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `subscribers`
--

INSERT INTO `subscribers` (`id_subscriber`, `sub_object`) VALUES
(63, 66),
(63, 68),
(63, 71),
(63, 72),
(63, 73),
(63, 53),
(71, 53),
(71, 72),
(71, 68),
(71, 67),
(71, 70),
(69, 68),
(69, 72),
(69, 67),
(69, 71),
(70, 68),
(70, 72),
(70, 67),
(70, 71),
(70, 69),
(67, 68),
(67, 72),
(67, 69),
(67, 71),
(73, 68),
(73, 72),
(73, 53),
(73, 64),
(73, 65),
(73, 70),
(73, 63),
(73, 44),
(68, 72),
(68, 71),
(68, 67),
(68, 69),
(68, 63),
(74, 72),
(74, 71),
(74, 67),
(74, 68),
(74, 69),
(74, 73),
(72, 68),
(72, 69),
(72, 67),
(72, 70),
(72, 63),
(63, 69),
(74, 63);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(150) NOT NULL,
  `count_publications` int(11) NOT NULL DEFAULT '0',
  `count_subscribers` int(11) NOT NULL DEFAULT '0',
  `count_subscriptions` int(11) NOT NULL DEFAULT '0',
  `name` varchar(150) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `web_cyte` varchar(100) DEFAULT NULL,
  `about` text,
  `avatar` varchar(200) DEFAULT NULL,
  `date_register` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `confirmed` text NOT NULL,
  `code_restore_pass` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `count_publications`, `count_subscribers`, `count_subscriptions`, `name`, `password`, `web_cyte`, `about`, `avatar`, `date_register`, `confirmed`, `code_restore_pass`) VALUES
(44, '533215137', 0, 1, 0, 'Леха Пидоркин', '$2y$10$MMB2YrTYp6nRbaHv1uwC3O4SiUrBMXt7XNYenNi/U1p8eA3XbxccG', NULL, NULL, 'no_image_user.png', '2019-02-24 17:06:47', '1', NULL),
(53, '135105988', 0, 3, 0, 'Влад Кунченко', '$2y$10$z7CJIEA5dBibkI737zHwTOUETLjVpPqT0SAyImf5bGknnZt8it8Rq', NULL, NULL, '417957bab44cf61c353a77053910c95b.jpg', '2019-03-27 09:24:30', '1', NULL),
(63, 'podpishick123', 13, 4, 7, 'Эдуард Евдокимов', '$2y$10$jPEMO0X3of6Ie/zb8A6lWuHbGuNA.IQQyINBmpl06GPOm9yMgwOie', 'www.google.com', 'программер с детства', 'no_image_user.png', '2019-04-10 08:01:47', '1', NULL),
(64, 'mike_speed', 0, 1, 0, 'mike_LA', '$2y$10$e9.4fuz8NiwskWalsUYsrOxa/57TYb2HZBAkUooBDWnpXB6UzUlpK', NULL, NULL, 'no_image_user.png', '2019-04-10 08:02:52', '1', NULL),
(65, 'good_angela', 0, 1, 0, NULL, '$2y$10$dwZIACIwEupd5mGuTKceYeZ2SuZPKc72dquqPp7dmtGPg7aPtGQN2', NULL, NULL, 'no_image_user.png', '2019-04-10 08:08:57', '1', NULL),
(66, 'bob', 0, 1, 0, NULL, '$2y$10$9mluN39Ly565JPW3SjgWcufjHUNrDMoQgdfcSv2a2CnpPVJDed6W2', NULL, NULL, 'no_image_user.png', '2019-04-10 08:10:08', '1', NULL),
(67, 'samuel_l_jackson', 5, 6, 4, 'черный сем', '$2y$10$Af49rNjCCwF7vML9Kq0M4ud3pJ4uroG3dLVMfErlRmbQe5Ymh8rga', '', '', '336c2326c6bf73d1f6a0f68ba3258d05.jpeg', '2019-04-10 08:12:07', '1', NULL),
(68, 'Ryan_Gosling', 5, 8, 5, '', '$2y$10$A4Tm4N9VB/m.dVmIdt2T/O6wewzLS7HtmCfgij/sUkjijtOHMcOr.', '', '', '248281438e5b9364e1e782bfc4440f28.jpeg', '2019-04-10 08:16:00', '1', NULL),
(69, 'Emma_Stone', 3, 6, 4, '', '$2y$10$YEsGCkWfbZRA/NBsvLQtb.6Wmchr4g4LWK3fPlpMskelgedCadOMC', '', '', '9089df430e2f02e6b443e6226f0c569c.jpeg', '2019-04-10 08:17:23', '1', NULL),
(70, 'Jake_Gyllenhaal', 0, 3, 5, 'Тот, что снимался в &quot;Левша&quot;', '$2y$10$0auJKifvypxMrTwAik8hl.21C9rzd3zxh5vkbkVRhZ8XRYhPZyQzu', '', '', 'e53ba04885b074370f3d4827b81d2160.jpeg', '2019-04-10 08:19:14', '1', NULL),
(71, 'Russell_Crowe', 6, 6, 5, 'Поехавший математик', '$2y$10$pjC7rPvMU5glNcHbW35th.updJoj9E/gQnayIf7s4NCL.8HcSCBpO', '', '', '5111b34886ee6a047ec356143535169a.jpeg', '2019-04-10 08:21:43', '1', NULL),
(72, 'scarlett_johansson', 4, 8, 5, 'люблю ее ехансон)))', '$2y$10$cW9UJCLKQ3QTdSBSi5qbG.XYcf32wa2xPH8kUXUm5W.c14JpR6jtC', '', '', '67ad99ebdb57337f9cc0fee7b8734d90.jpeg', '2019-04-10 08:23:27', '1', NULL),
(73, 'alexander_nevski', 6, 2, 8, 'best body builder in the world', '$2y$10$xVtv3H.QT9NTURonYmF3cuAOr8dAKEy8pA9P9k7Dyx69YyQAIyrg6', '', '', '332b6b4feb64be512ad5a04f1b612d77.jpeg', '2019-04-10 08:26:46', '1', NULL),
(74, 'JamesMcAvoy', 0, 0, 7, '', '$2y$10$rz4qwafzgnDp8h6b1eM5Xu1PESO4kc.SCCX8eoapNxHssZxl9szTS', '', '', 'd0a2373ba36cb2fee52789b7b3d8854f.jpeg', '2019-04-10 08:41:07', '1', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `action_users`
--
ALTER TABLE `action_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `action_user` (`object`),
  ADD KEY `action_object` (`action_user`) USING BTREE;

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id_user` (`parent_id_user`),
  ADD KEY `parent_id_photo` (`parent_id_publication`);

--
-- Индексы таблицы `hashtags`
--
ALTER TABLE `hashtags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id_publication` (`parent_id_publication`);

--
-- Индексы таблицы `likes_comments`
--
ALTER TABLE `likes_comments`
  ADD PRIMARY KEY (`id_user`,`id_comment`),
  ADD KEY `id_comment` (`id_comment`);

--
-- Индексы таблицы `likes_publications`
--
ALTER TABLE `likes_publications`
  ADD PRIMARY KEY (`user_id`,`publication_id`),
  ADD KEY `publication_id` (`publication_id`);

--
-- Индексы таблицы `mails`
--
ALTER TABLE `mails`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail` (`mail`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Индексы таблицы `publications`
--
ALTER TABLE `publications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `public_id` (`public_id`),
  ADD KEY `parent_id` (`parent_id`) USING BTREE;

--
-- Индексы таблицы `subscribers`
--
ALTER TABLE `subscribers`
  ADD KEY `sub_object` (`sub_object`),
  ADD KEY `subscribers_ibfk_1` (`id_subscriber`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `action_users`
--
ALTER TABLE `action_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT для таблицы `hashtags`
--
ALTER TABLE `hashtags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `mails`
--
ALTER TABLE `mails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT для таблицы `publications`
--
ALTER TABLE `publications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=339;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `action_users`
--
ALTER TABLE `action_users`
  ADD CONSTRAINT `action_users_ibfk_1` FOREIGN KEY (`action_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `action_users_ibfk_2` FOREIGN KEY (`object`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`parent_id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`parent_id_publication`) REFERENCES `publications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `hashtags`
--
ALTER TABLE `hashtags`
  ADD CONSTRAINT `hashtags_ibfk_1` FOREIGN KEY (`parent_id_publication`) REFERENCES `publications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `likes_comments`
--
ALTER TABLE `likes_comments`
  ADD CONSTRAINT `likes_comments_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_comments_ibfk_2` FOREIGN KEY (`id_comment`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `likes_publications`
--
ALTER TABLE `likes_publications`
  ADD CONSTRAINT `likes_publications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_publications_ibfk_2` FOREIGN KEY (`publication_id`) REFERENCES `publications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `mails`
--
ALTER TABLE `mails`
  ADD CONSTRAINT `mails_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `publications`
--
ALTER TABLE `publications`
  ADD CONSTRAINT `publications_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `subscribers`
--
ALTER TABLE `subscribers`
  ADD CONSTRAINT `subscribers_ibfk_1` FOREIGN KEY (`id_subscriber`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subscribers_ibfk_2` FOREIGN KEY (`sub_object`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
