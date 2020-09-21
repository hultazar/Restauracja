-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 06 Sty 2019, 03:01
-- Wersja serwera: 10.1.34-MariaDB
-- Wersja PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `stoliktu`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `administratorzy`
--

CREATE TABLE `administratorzy` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `haslo` char(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `administratorzy`
--

INSERT INTO `administratorzy` (`id`, `login`, `haslo`) VALUES
(1, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `glosy`
--

CREATE TABLE `glosy` (
  `id_glosu` int(5) NOT NULL,
  `id_klienta` int(11) NOT NULL,
  `ocena` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `glosy`
--

INSERT INTO `glosy` (`id_glosu`, `id_klienta`, `ocena`) VALUES
(1, 3, 5),
(2, 2, 5),
(3, 1, 4),
(5, 5, 5);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klienci`
--

CREATE TABLE `klienci` (
  `id_klienta` int(11) NOT NULL,
  `login` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `haslo` char(64) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `data_urodzenia` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `klienci`
--

INSERT INTO `klienci` (`id_klienta`, `login`, `haslo`, `email`, `data_urodzenia`) VALUES
(1, 'test', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 'test@test.com', '2017-06-07'),
(2, 'alamakota', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'aaa@example.com', '2017-06-16'),
(3, 'andrzej', '56a17f2ad6a1aad9a8707a8c712772d1ceb4e491012148d2a0de0f8b764a7130', 'andrzej@o2.pl', '1992-02-13'),
(5, 'murzyn', '09461579db83744bdde1a311c235a7ee12e3d7ad8c4062415a9b00ac898ec56d', 'murzynek@gmail.com', '2018-12-11'),
(6, 'wiesiek', '26f55d2e7d13256b5375a0253e71be00672c361c770e203bfb06d9008ae6c4e9', 'wiesiek@o2.pl', '1999-01-27'),
(7, 'olbrzym', 'c2dd7c0d8d7a1c8b677b2adce9518f88aea31f117bf6dbe6e8d56fe519630357', 'olbrzym@o2.pl', '1992-01-01'),
(8, 'juzer', '8f9fb2d31a20a07c9f047361afc76e1e41e8408d879a9915afa3d3fc549e87ce', 'juzer@o2.pl', '1992-11-11');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rezerwacje`
--

CREATE TABLE `rezerwacje` (
  `id_rezerwacji` int(11) NOT NULL,
  `data_rezerwacji` date NOT NULL,
  `id_klienta` int(11) NOT NULL,
  `id_stolika` int(11) NOT NULL,
  `czy_potwierdzona` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `rezerwacje`
--

INSERT INTO `rezerwacje` (`id_rezerwacji`, `data_rezerwacji`, `id_klienta`, `id_stolika`, `czy_potwierdzona`) VALUES
(42, '2019-01-06', 3, 2, 1),
(43, '2018-12-17', 3, 4, 1),
(44, '2018-12-20', 3, 1, 0),
(45, '2019-01-06', 5, 5, 0),
(47, '2019-01-07', 3, 5, 1),
(48, '2019-01-07', 5, 3, 1),
(98, '2019-01-16', 3, 3, 1),
(104, '2019-01-17', 5, 4, 0),
(105, '2019-01-15', 5, 2, 0),
(106, '2019-01-09', 6, 1, 1),
(107, '2019-01-06', 6, 1, 0),
(108, '2019-01-06', 7, 4, 0),
(109, '2019-01-06', 8, 3, 0),
(110, '2019-01-07', 3, 1, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `stoliki`
--

CREATE TABLE `stoliki` (
  `id_stolika` int(11) NOT NULL,
  `tytul` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `stoliki`
--

INSERT INTO `stoliki` (`id_stolika`, `tytul`) VALUES
(1, 'Sami Swoi (4 osoby)'),
(2, 'Malinowy Gaj (6 osób)'),
(3, 'Pierwszy Raz (2 osoby)'),
(4, 'Przyjęcie (8 osób)'),
(5, 'Kamikaze (3 osoby)');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `administratorzy`
--
ALTER TABLE `administratorzy`
  ADD PRIMARY KEY (`id`,`login`);

--
-- Indeksy dla tabeli `glosy`
--
ALTER TABLE `glosy`
  ADD PRIMARY KEY (`id_glosu`),
  ADD KEY `id_klienta` (`id_klienta`);

--
-- Indeksy dla tabeli `klienci`
--
ALTER TABLE `klienci`
  ADD PRIMARY KEY (`id_klienta`);

--
-- Indeksy dla tabeli `rezerwacje`
--
ALTER TABLE `rezerwacje`
  ADD PRIMARY KEY (`id_rezerwacji`),
  ADD KEY `id_klienta` (`id_klienta`),
  ADD KEY `id_stolika` (`id_stolika`);

--
-- Indeksy dla tabeli `stoliki`
--
ALTER TABLE `stoliki`
  ADD PRIMARY KEY (`id_stolika`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `administratorzy`
--
ALTER TABLE `administratorzy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `glosy`
--
ALTER TABLE `glosy`
  MODIFY `id_glosu` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `klienci`
--
ALTER TABLE `klienci`
  MODIFY `id_klienta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `rezerwacje`
--
ALTER TABLE `rezerwacje`
  MODIFY `id_rezerwacji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT dla tabeli `stoliki`
--
ALTER TABLE `stoliki`
  MODIFY `id_stolika` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `glosy`
--
ALTER TABLE `glosy`
  ADD CONSTRAINT `glosy_ibfk_1` FOREIGN KEY (`id_klienta`) REFERENCES `klienci` (`id_klienta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `rezerwacje`
--
ALTER TABLE `rezerwacje`
  ADD CONSTRAINT `rezerwacje_klienci_FK` FOREIGN KEY (`id_klienta`) REFERENCES `klienci` (`id_klienta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rezerwacje_stoliki_FK` FOREIGN KEY (`id_stolika`) REFERENCES `stoliki` (`id_stolika`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
