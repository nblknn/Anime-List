-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Апр 27 2025 г., 14:03
-- Версия сервера: 8.4.4
-- Версия PHP: 8.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `anime_list`
--

-- --------------------------------------------------------

--
-- Структура таблицы `anime`
--

CREATE TABLE `anime` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `russianName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `episodes` int NOT NULL,
  `year` int NOT NULL,
  `description` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `anime`
--

INSERT INTO `anime` (`id`, `name`, `russianName`, `episodes`, `year`, `description`) VALUES
(1, 'Mob Psycho 100', 'Моб Психо 100', 12, 2016, 'Бросив первый поверхностный взгляд, мы узрим банальнейший сюжет, коих перевидали сотни: школа, кружки по интересам, ученики, пытающиеся выстроить свою личность и отношения в коллективе, разумеется, первая любовь, комплексы и тому подобные подростковые проблемы.\r\nОднако эта история не будет ординарной. Эта история будет экстраординарной. И таковой ее сделает выдающийся главный герой. Шигэо Кагэяма вроде бы обычный японский школьник — стеснительный, старающийся не привлекать внимания, не блещущий умом, красотой или чувством юмора. И самое большое его желание — привлечь внимание любимой девушки. Но! У этого восьмиклассника есть экстрасенсорные способности. С детства он взглядом гнет ложки и передвигает предметы. И пусть общественность пока этого не оценила, зато выгоду в этом очень скоро нашел его «ментальный наставник», эксплуатирующий способности Кагэямы себе на поживу.\r\nКак будет искать свой путь в этом привычно жестоком мире юный экстрасенс — нам и предстоит увидеть.'),
(2, 'Shingeki no Kyojin', 'Атака титанов', 23, 2013, 'С давних времён человечество ведёт свою борьбу с титанами. Титаны — это огромные существа, ростом с многоэтажный дом, которые не обладают большим интеллектом, но сила их просто ужасна. Они едят людей и получают от этого удовольствие. После продолжительной борьбы остатки человечества создали стену, окружившую мир людей, через которую не пройдут даже титаны.\r\nС тех пор прошло сто лет. Человечество мирно живёт под защитой стены. Но в один день мальчик Эрен и его сводная сестра Микаса становятся свидетелями страшного события: участок стены был разрушен супертитаном, появившимся прямо из воздуха. Титаны атакуют город, и двое детей в ужасе видят, как один из монстров заживо съедает их мать.\r\nБрат и сестра выживают, и Эрен клянётся, что убьёт всех титанов и отомстит за всё человечество!'),
(3, 'Boku no Hero Academia', 'Моя геройская академия', 13, 2016, 'Четырнадцатилетний Идзуку Мидория рано осознал, что люди не рождаются равными. А пришло это понимание, когда его начали дразнить одноклассники, одарённые особой силой. Несмотря на то, что большинство людей в этом мире рождаются с необычными способностями, Идзуку оказался среди тех немногих, кто напрочь их лишён.\r\n        Однако это не стало помехой для мальчика в стремлении стать таким же легендарным героем, как Всемогущий. Для осуществления мечты Идзуку не без помощи своего кумира поступает в самую престижную академию героев — Юэй.\r\nНо это, очевидно, лишь начало его удивительных приключений.');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `isVerified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `firstName`, `lastName`, `email`, `password`, `salt`, `token`, `isVerified`) VALUES
(1, 'Ksenia', 'Gorodko', 'xgorodko@gmail.com', '12345678', '0', '0', 1),
(2, 'Мега', 'Анимешник', 'iloveanime@anime.anime', 'anime', 'anime', 'anime', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `useranime`
--

CREATE TABLE `useranime` (
  `userID` int NOT NULL,
  `animeID` int NOT NULL,
  `isWatched` tinyint(1) NOT NULL,
  `rating` int DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `useranime`
--

INSERT INTO `useranime` (`userID`, `animeID`, `isWatched`, `rating`, `comment`) VALUES
(1, 1, 1, 10, 'topcheg'),
(1, 2, 0, NULL, NULL),
(2, 3, 0, NULL, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `anime`
--
ALTER TABLE `anime`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `useranime`
--
ALTER TABLE `useranime`
  ADD KEY `animeID` (`animeID`),
  ADD KEY `userID` (`userID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `anime`
--
ALTER TABLE `anime`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `useranime`
--
ALTER TABLE `useranime`
  ADD CONSTRAINT `useranime_ibfk_1` FOREIGN KEY (`animeID`) REFERENCES `anime` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `useranime_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
