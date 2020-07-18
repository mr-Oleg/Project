-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 18 2020 г., 19:54
-- Версия сервера: 8.0.19
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `status`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cam_address`
--

CREATE TABLE `cam_address` (
  `addr_id` int NOT NULL,
  `addr_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `cam_address`
--

INSERT INTO `cam_address` (`addr_id`, `addr_link`) VALUES
(1, '123.234.123');

-- --------------------------------------------------------

--
-- Структура таблицы `recognize`
--

CREATE TABLE `recognize` (
  `rec_id` int NOT NULL,
  `rec_anger` tinyint(1) NOT NULL DEFAULT '1',
  `rec_sadness` tinyint(1) NOT NULL DEFAULT '1',
  `rec_happiness` tinyint(1) NOT NULL DEFAULT '1',
  `rec_existance` tinyint(1) NOT NULL DEFAULT '1',
  `rec_stroke` tinyint(1) NOT NULL DEFAULT '1',
  `rec_tire` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `recognize`
--

INSERT INTO `recognize` (`rec_id`, `rec_anger`, `rec_sadness`, `rec_happiness`, `rec_existance`, `rec_stroke`, `rec_tire`) VALUES
(1, 1, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `sensitivity`
--

CREATE TABLE `sensitivity` (
  `cam_id` int NOT NULL,
  `sense_exist` float NOT NULL DEFAULT '0.5',
  `sense_anger` float NOT NULL DEFAULT '0.5',
  `sense_tire` float NOT NULL DEFAULT '0.5',
  `sense_stroke` float NOT NULL DEFAULT '0.5',
  `sense_sad` float NOT NULL DEFAULT '0.5',
  `sense_happy` float NOT NULL DEFAULT '0.5'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sensitivity`
--

INSERT INTO `sensitivity` (`cam_id`, `sense_exist`, `sense_anger`, `sense_tire`, `sense_stroke`, `sense_sad`, `sense_happy`) VALUES
(1, 0.84, 0.05, 0.5, 0.5, 0.5, 0.26);

-- --------------------------------------------------------

--
-- Структура таблицы `subscribers`
--

CREATE TABLE `subscribers` (
  `sub_id` int NOT NULL,
  `cam_id` int NOT NULL,
  `sub_mode` text NOT NULL,
  `sub_adr` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `subscribers`
--

INSERT INTO `subscribers` (`sub_id`, `cam_id`, `sub_mode`, `sub_adr`) VALUES
(1, 1, 'happy', '1'),
(13, 1, 'anger', 'http://status.apv/php/requests.php?test');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cam_address`
--
ALTER TABLE `cam_address`
  ADD PRIMARY KEY (`addr_id`);

--
-- Индексы таблицы `recognize`
--
ALTER TABLE `recognize`
  ADD PRIMARY KEY (`rec_id`);

--
-- Индексы таблицы `sensitivity`
--
ALTER TABLE `sensitivity`
  ADD PRIMARY KEY (`cam_id`);

--
-- Индексы таблицы `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`sub_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `sub_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
