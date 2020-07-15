-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 14 2020 г., 16:56
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
  `addr_link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `recognize`
--

INSERT INTO `recognize` (`rec_id`, `rec_anger`, `rec_sadness`, `rec_happiness`, `rec_existance`, `rec_stroke`, `rec_tire`) VALUES
(1, 0, 0, 1, 1, 1, 0);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
