-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 10 2021 г., 00:38
-- Версия сервера: 5.7.31
-- Версия PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `odyag_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `first_category`
--

DROP TABLE IF EXISTS `first_category`;
CREATE TABLE IF NOT EXISTS `first_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  `views` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `first_category`
--

INSERT INTO `first_category` (`id`, `name`, `status`, `views`) VALUES
(1, 'Новинки', 1, 0),
(2, 'Жінкам', 1, 0),
(3, 'Чоловікам', 1, 0),
(4, 'Популярне', 1, 0),
(5, 'Конструктор', 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `info`
--

DROP TABLE IF EXISTS `info`;
CREATE TABLE IF NOT EXISTS `info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` int(2) NOT NULL DEFAULT '1',
  `status` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `tagindex` (`tag`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `info`
--

INSERT INTO `info` (`id`, `tag`, `name`, `category`, `status`) VALUES
(1, 'covid', 'Зміни, пов\'язані з епідемією коронавірусу (COVID-19)', 1, 1),
(2, 'howbuy', 'Як оформити замовлення', 1, 1),
(3, 'question', 'Запитання відповіді', 1, 1),
(4, 'delivery', 'Термін і вартість доставки', 1, 1),
(5, 'pay', 'Оплата', 1, 1),
(6, 'return', 'Повернення', 1, 1),
(7, 'claims', 'Претензії', 1, 1),
(8, 'tablesize', 'Таблиця розмірності', 1, 1),
(9, 'constructor', 'Конструктор', 1, 1),
(10, 'termsofuse', 'Умови використання інтернет магазину', 2, 1),
(11, 'privacypolicy', 'Політика конфідеційності', 2, 1),
(12, 'price', 'Ціни в магазинах', 2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `recipient` varchar(255) NOT NULL,
  `sum` int(11) NOT NULL DEFAULT '0',
  `status_order` int(2) NOT NULL DEFAULT '1',
  `products` text NOT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `order`
--

INSERT INTO `order` (`id`, `id_user`, `date`, `recipient`, `sum`, `status_order`, `products`, `status`) VALUES
(1, 1, '2021-06-01 12:00:32', 'Соколов Валерій', 1200, 3, '3.XL.152.1-2.36.200.2-4.XL.158.1', 1),
(2, 2, '2021-06-01 12:00:32', 'Олексій Гос', 4525, 2, '1.40.543.1-3.36.200.1-4.40.200.1', 1),
(3, 1, '2021-06-01 18:30:23', 'Соколова Тетьяна', 3523, 5, '3.XL.152.1-2.36.200.2-4.XL.158.1\r\n', 1),
(4, 1, '2021-06-01 18:30:23', 'Соколов Валерій', 222, 4, '7.36.33.3-3.38.111.1-4.40.123.1-3.XL.152.1-2.36.200.2-4.XL.158.1\r\n', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `price` int(11) NOT NULL DEFAULT '0',
  `discount` int(11) NOT NULL DEFAULT '0',
  `description` text,
  `material` varchar(255) DEFAULT NULL,
  `size` varchar(255) NOT NULL DEFAULT '1.s-',
  `length` varchar(255) NOT NULL,
  `constructor_status` int(11) NOT NULL DEFAULT '0',
  `id_third_cat` int(2) NOT NULL DEFAULT '0',
  `status` int(2) NOT NULL DEFAULT '0',
  `views` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `tag`, `name`, `company`, `price`, `discount`, `description`, `material`, `size`, `length`, `constructor_status`, `id_third_cat`, `status`, `views`) VALUES
(1, 1, 'Джинси з завищеною талією', 'Cropp', 659, 20, '- висока посадка\r\n- застібка-блискавка та ґудзик', '98% БАВОВНА, 2% ЕЛАСТАН', '0.32-0.34-1.36-3.38-0.40-0.42-0.XL-132.XXL', '80.32-85.34-90.36-95.38-100.40-105.42-110.XL-115.XXL', 1, 3, 1, 180),
(2, 1, 'Джинси high waist', 'Cropp', 659, 20, '- висока посадка\r\n- застібка-блискавка та ґудзик', '98% БАВОВНА, 2% ЕЛАСТАН', '12.32-0.34-0.36-0.38-0.40-0.42-', '80.32-85.34-90.36-95.38-100.40-105.42-110.XL-115.XXL', 1, 3, 1, 9),
(3, 1, 'Джинси з завищеною талією', 'Cropp', 659, 0, 'висока посадка\r\nзастібка-блискавка та ґудзик', '98% БАВОВНА, 2% ЕЛАСТАН', '15.32-12.34-10.36-0.38-7.40-1.42-', '80.32-85.34-90.36-95.38-100.40-105.42-110.XL-115.XXL', 1, 3, 1, 26),
(4, 1, 'Джинси з завищеною талією', 'Cropp', 659, 20, '- висока посадка\r\n- застібка-блискавка та ґудзик', '98% БАВОВНА, 2% ЕЛАСТАН', '7.32-10.34-0.36-0.38-0.40-0.42-', '80.32-85.34-90.36-95.38-100.40-105.42-110.XL-115.XXL', 1, 3, 1, 16),
(5, 2, 'Джинси skinny', 'Cropp', 600, 15, '-висока посадка\r\n-застібка-блискавка та ґудзик', '74% БАВОВНА, 24% ПОЛІЕСТЕР, 2% ЕЛАСТАН', '5.32-0.34-0.36-19.38-0.40-0.42-', '80.32-85.34-90.36-95.38-100.40-105.42-110.XL-115.XXL', 1, 3, 1, 15),
(6, 2, 'Джинси skinny', 'Cropp', 499, 0, '-висока посадка\r\n-застібка-блискавка та ґудзик', '74% БАВОВНА, 24% ПОЛІЕСТЕР, 2% ЕЛАСТАН', '5.32-0.34-15.36-0.38-11.40-0.42-', '80.32-85.34-90.36-95.38-100.40-105.42-110.XL-115.XXL', 1, 3, 1, 21),
(7, 2, 'LADIES` JEANS TROUSERS', 'Cropp', 600, 15, '-висока посадка\r\n-застібка-блискавка та ґудзик', '74% БАВОВНА, 24% ПОЛІЕСТЕР, 2% ЕЛАСТАН', '18.32-10.34-0.36-0.38-0.40-0.42-', '80.32-85.34-90.36-95.38-100.40-105.42-110.XL-115.XXL', 1, 3, 1, 7),
(8, 2, 'Джинси skinny', 'Cropp', 599, 15, '-висока посадка\r\n-застібка-блискавка та ґудзик', '74% БАВОВНА, 24% ПОЛІЕСТЕР, 2% ЕЛАСТАН', '0.32-0.34-0.36-0.38-0.40-0.42-', '80.32-85.34-90.36-95.38-100.40-105.42-110.XL-115.XXL', 1, 3, 1, 45),
(9, 2, 'Джинси skinny', 'Cropp', 599, 15, '-висока посадка\r\n-застібка-блискавка та ґудзик', '74% БАВОВНА, 24% ПОЛІЕСТЕР, 2% ЕЛАСТАН', '0.32-0.34-0.36-0.38-0.40-15.42-', '80.32-85.34-90.36-95.38-100.40-105.42-110.XL-115.XXL', 1, 3, 1, 27);

-- --------------------------------------------------------

--
-- Структура таблицы `second_category`
--

DROP TABLE IF EXISTS `second_category`;
CREATE TABLE IF NOT EXISTS `second_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  `views` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `second_category`
--

INSERT INTO `second_category` (`id`, `name`, `status`, `views`) VALUES
(1, 'Одяг', 1, 0),
(2, 'Взуття', 1, 0),
(3, 'Аксесуари', 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `third_category`
--

DROP TABLE IF EXISTS `third_category`;
CREATE TABLE IF NOT EXISTS `third_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `id_first_cat` int(11) NOT NULL DEFAULT '0',
  `id_second_cat` int(11) NOT NULL DEFAULT '0',
  `status` int(2) NOT NULL DEFAULT '0',
  `views` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `third_category`
--

INSERT INTO `third_category` (`id`, `name`, `id_first_cat`, `id_second_cat`, `status`, `views`) VALUES
(1, 'Футболки', 2, 1, 1, 0),
(2, 'Сукні', 2, 1, 1, 0),
(3, 'Джинси', 2, 1, 1, 0),
(4, 'Шорти', 2, 1, 1, 0),
(5, 'Комбінезон', 2, 1, 1, 0),
(6, 'Світшот', 2, 1, 1, 0),
(7, 'Сорочки', 2, 1, 1, 0),
(8, 'Блузки', 2, 1, 1, 0),
(9, 'Спідниці', 2, 1, 1, 0),
(10, 'Куртки', 2, 1, 1, 0),
(11, 'Пальто', 2, 1, 1, 0),
(12, 'Светри', 2, 1, 1, 0),
(13, 'Штани', 2, 1, 1, 0),
(14, 'Сандалі', 2, 2, 1, 0),
(15, 'Шльопанці', 2, 2, 1, 0),
(16, 'Кеди', 2, 2, 1, 0),
(17, 'Кросівки', 2, 2, 1, 0),
(18, 'Еспадрільї', 2, 2, 1, 0),
(19, 'Черевики', 2, 2, 1, 0),
(20, 'Сумки', 2, 3, 1, 0),
(21, 'Рюкзаки', 2, 3, 1, 0),
(22, 'Купальники', 2, 3, 1, 0),
(23, 'Шкарпетки', 2, 3, 1, 0),
(24, 'Шапки', 2, 3, 1, 0),
(25, 'Сонцезахисні окуляри', 2, 3, 1, 0),
(26, 'Пояси', 2, 3, 1, 0),
(27, 'Гаманці', 2, 3, 1, 0),
(28, 'Біжутерія', 2, 3, 1, 0),
(29, 'Футболки', 3, 1, 1, 0),
(30, 'Шорти', 3, 1, 1, 0),
(31, 'Сорочки', 3, 1, 1, 0),
(32, 'Світшоти', 3, 1, 1, 0),
(33, 'Джинси', 3, 1, 1, 0),
(34, 'Штани', 3, 1, 1, 0),
(35, 'Куртки', 3, 1, 1, 0),
(36, 'Жилети', 3, 1, 1, 0),
(37, 'Кеди', 3, 2, 1, 0),
(38, 'Кросівки', 3, 2, 1, 0),
(39, 'Черевики', 3, 2, 1, 0),
(40, 'Туфлі', 3, 2, 1, 0),
(41, 'Чоботи', 3, 2, 1, 0),
(42, 'Сандалі', 3, 2, 1, 0),
(43, 'Білизна', 3, 3, 1, 0),
(44, 'Шкарпетки', 3, 3, 1, 0),
(45, 'Сонцезахисні окуляри', 3, 3, 1, 0),
(46, 'Шапки', 3, 3, 1, 0),
(47, 'Сумки', 3, 3, 1, 0),
(48, 'Пояси', 3, 3, 1, 0),
(49, 'Гаманці', 3, 3, 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `login`, `email`, `password`) VALUES
(1, 'Kriker39', 'valera_sokolov99@mail.ru', '$2y$10$Dewe1HS3GXKhAlt24LbPu.PNRB.jVxlDA4gdcx50YyH6.HgP7KK4m'),
(2, '10061136', 'valera_sokolov99@mail.rur', '$2y$10$1x294SKFlgO/ksmtaQ6LLe8Sd/MuLyqwOqukXgswDI.Rj19W0hVXi');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
