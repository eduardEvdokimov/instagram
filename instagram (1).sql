-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 28 2019 г., 16:48
-- Версия сервера: 8.0.12
-- Версия PHP: 7.2.10

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
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `parent_id_user` int(11) NOT NULL,
  `parent_id_publication` int(11) NOT NULL,
  `coment` text NOT NULL,
  `likes` int(11) NOT NULL DEFAULT '0',
  `pub_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `gender_users`
--

CREATE TABLE `gender_users` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `gender` set('Мужской','Женский') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `hashtags`
--

CREATE TABLE `hashtags` (
  `id` int(11) NOT NULL,
  `parent_id_publication` int(11) NOT NULL,
  `hashtag` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `hashtags`
--

INSERT INTO `hashtags` (`id`, `parent_id_publication`, `hashtag`) VALUES
(24, 77, '#123,#321');

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
(26, 41, 'eduard.evdokimov@inbox.ru', 0),
(29, 44, 'evdokimov99@mail.ua', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `publications`
--

CREATE TABLE `publications` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  `title` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `pub_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `likes` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `publications`
--

INSERT INTO `publications` (`id`, `parent_id`, `img`, `title`, `pub_date`, `likes`) VALUES
(76, 41, '754d0c4e46e678b8f073f0cc9665ead8.jpeg', 'описание', '2019-02-27 13:31:58', 0),
(77, 41, '135e4783fd051c7e33686184dd51cb97.jpeg', 'описание', '2019-02-27 13:31:58', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `subscribers`
--

CREATE TABLE `subscribers` (
  `id_subscriber` int(11) NOT NULL,
  `sub_object` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(150) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `web_cyte` varchar(100) DEFAULT NULL,
  `about` text,
  `avatar` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `date_register` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `confirmed` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `name`, `password`, `web_cyte`, `about`, `avatar`, `date_register`, `confirmed`) VALUES
(41, '158311419', 'Эдуард Евдокимов', '$2y$10$MqPPb1j4fD.mQsRggfXNN.f3UFjhvolxLfQMuUWThl8hfvwUQrXiK', NULL, NULL, '5385bd4228a99b3647537793bf5f584b.jpg', '2019-02-24 16:04:34', '1'),
(44, '533215137', 'Леха Пидоркин', '$2y$10$MMB2YrTYp6nRbaHv1uwC3O4SiUrBMXt7XNYenNi/U1p8eA3XbxccG', NULL, NULL, 'no_image_user.png', '2019-02-24 17:06:47', '1');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id_user` (`parent_id_user`),
  ADD KEY `parent_id_photo` (`parent_id_publication`);

--
-- Индексы таблицы `gender_users`
--
ALTER TABLE `gender_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Индексы таблицы `hashtags`
--
ALTER TABLE `hashtags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id_publication` (`parent_id_publication`);

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
  ADD KEY `parent_id` (`parent_id`);

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
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `gender_users`
--
ALTER TABLE `gender_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `hashtags`
--
ALTER TABLE `hashtags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `mails`
--
ALTER TABLE `mails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT для таблицы `publications`
--
ALTER TABLE `publications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`parent_id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`parent_id_publication`) REFERENCES `publications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `gender_users`
--
ALTER TABLE `gender_users`
  ADD CONSTRAINT `gender_users_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `hashtags`
--
ALTER TABLE `hashtags`
  ADD CONSTRAINT `hashtags_ibfk_1` FOREIGN KEY (`parent_id_publication`) REFERENCES `publications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
