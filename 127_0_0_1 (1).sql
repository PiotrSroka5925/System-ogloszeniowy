-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2025 at 09:30 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `system_ogloszeniowy`
--
CREATE DATABASE IF NOT EXISTS `system_ogloszeniowy` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `system_ogloszeniowy`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `aplikowania`
--

CREATE TABLE `aplikowania` (
  `aplikowanie_id` int(10) UNSIGNED NOT NULL,
  `uzytkownik_id` int(10) UNSIGNED NOT NULL,
  `ogloszenie_id` int(10) UNSIGNED NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `aplikowania`
--

INSERT INTO `aplikowania` (`aplikowanie_id`, `uzytkownik_id`, `ogloszenie_id`, `status`) VALUES
(11, 1, 58, 'nie zatwierdzone'),
(30, 1, 55, 'nie zatwierdzone'),
(32, 1, 59, 'zatwierdzono');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `firmy`
--

CREATE TABLE `firmy` (
  `firma_id` int(10) UNSIGNED NOT NULL,
  `nazwa_firmy` varchar(90) NOT NULL,
  `informacje` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `firmy`
--

INSERT INTO `firmy` (`firma_id`, `nazwa_firmy`, `informacje`) VALUES
(1, 'Millenium', 'Super firma Milennium'),
(2, 'Martes', 'Super firma Martes'),
(3, 'Stokrotka', 'Super firma StokrotkaSuper firma StokrotkaSuper firma StokrotkaSuper firma StokrotkaSuper firma StokrotkaSuper firma StokrotkaSuper firma StokrotkaSuper firma StokrotkaSuper firma StokrotkaSuper firma Stokrotka'),
(8, 'Gigga Firma', 'aaaaaaaaaaaaaaab');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorie`
--

CREATE TABLE `kategorie` (
  `kategoria_id` int(11) UNSIGNED NOT NULL,
  `nazwa_kategorii` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `kategorie`
--

INSERT INTO `kategorie` (`kategoria_id`, `nazwa_kategorii`) VALUES
(4, 'ekonomia'),
(5, 'produkcja'),
(7, 'bankowość'),
(33, 'hotelarstwo'),
(86, 'energetyka');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ogloszenia`
--

CREATE TABLE `ogloszenia` (
  `ogloszenie_id` int(10) UNSIGNED NOT NULL,
  `nazwa_ogloszenia` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `lokalizacja` text NOT NULL,
  `firma_id` int(10) UNSIGNED NOT NULL,
  `stanowisko_id` int(10) UNSIGNED NOT NULL,
  `umowa_id` int(10) UNSIGNED NOT NULL,
  `etat_id` int(10) UNSIGNED NOT NULL,
  `rodzaj_pracy_id` int(10) UNSIGNED NOT NULL,
  `najmn_wynagrodzenie` decimal(11,2) UNSIGNED NOT NULL,
  `najw_wynagrodzenie` decimal(11,2) UNSIGNED NOT NULL,
  `dni_pracy` text NOT NULL,
  `godziny_pracy` text NOT NULL,
  `data_waznosci` date NOT NULL,
  `data_utworzenia` date NOT NULL,
  `zdjecie` text NOT NULL,
  `poziom_stanowiska` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `ogloszenia`
--

INSERT INTO `ogloszenia` (`ogloszenie_id`, `nazwa_ogloszenia`, `lokalizacja`, `firma_id`, `stanowisko_id`, `umowa_id`, `etat_id`, `rodzaj_pracy_id`, `najmn_wynagrodzenie`, `najw_wynagrodzenie`, `dni_pracy`, `godziny_pracy`, `data_waznosci`, `data_utworzenia`, `zdjecie`, `poziom_stanowiska`) VALUES
(51, 'sdadadadas', 'addasdadas', 2, 5, 3, 2, 6, 6000.90, 8000.90, 'dadsadsadsad', '8', '2024-05-22', '2024-05-01', '../Images/Companies/seaofclouds.jpg', 'saadad'),
(52, 'Edytowałem lol ełe łesdsddasdasdsadasEdytowałem lo', 'Bytom', 3, 4, 4, 2, 6, 7000.00, 10000.00, 'daad ads addda adsdaaaaaaaaaaaaaaaa', '9', '2024-05-14', '2024-05-01', '../Images/Companies/dungeon.jpg', 'aada'),
(55, 'sdadadadas', 'addasdadas', 3, 4, 2, 3, 5, 8000.00, 9000.00, 'sdsadasdsdasdasdsadsa', '24', '2024-05-30', '2024-05-07', '../Images/Companies/dungeon.jpg', 'ddd'),
(58, 'asdadas', 'sadadsada', 1, 4, 1, 3, 4, 7000.00, 8000.00, 'gggdggggdg', '9', '0000-00-00', '2024-05-09', '../Images/Companies/artorias.jpg', 'aaaa'),
(59, 'jakies', 'bydgoszcz', 8, 3, 3, 2, 5, 6000.00, 9000.00, 'adadasdsadad', '7', '2024-06-07', '2024-05-13', '../Images/Companies/tape.jpg', 'nwm lol'),
(67, 'dddddddd', 'ddddd', 2, 4, 1, 3, 5, 8000.00, 9000.00, 'aaaaaa', '6', '2024-06-06', '2024-05-18', '../Images/Companies/mangaspace.png', 'dddd'),
(68, 'testowy noc', 'Kraków', 1, 11, 5, 3, 6, 6500.99, 12000.00, 'od poniedziałku do piątku', '8', '2024-06-09', '2024-05-19', '../Images/Companies/mangaspace.png', 'juniorek');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ogloszenie_benefity`
--

CREATE TABLE `ogloszenie_benefity` (
  `benefit_id` int(10) UNSIGNED NOT NULL,
  `benefitText` text NOT NULL,
  `ogloszenie_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `ogloszenie_benefity`
--

INSERT INTO `ogloszenie_benefity` (`benefit_id`, `benefitText`, `ogloszenie_id`) VALUES
(5, 'aaaa', 51),
(15, 'aaaaaa', 55),
(16, 'asdasdda', 55),
(20, 'beneficior1', 58),
(21, 'beneficior1', 58),
(84, 'adadadada', 52),
(85, 'edytowany benfit', 52),
(91, 'ccccc', 67),
(93, 'adadsada', 59),
(94, 'aaa beneffgfdgfdgdfgdfg', 68),
(95, 'fggdgfdgfdgfd', 68),
(96, 'dfgfgfdgfdgdfgf', 68),
(97, 'ssfdssssdfgdgfd', 68),
(98, 'sffsdfdsfsdfsdfdg', 68),
(99, 'dfgdgfgfd', 68);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ogloszenie_etaty`
--

CREATE TABLE `ogloszenie_etaty` (
  `etat_id` int(10) UNSIGNED NOT NULL,
  `wymiar_etatu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `ogloszenie_etaty`
--

INSERT INTO `ogloszenie_etaty` (`etat_id`, `wymiar_etatu`) VALUES
(1, 'część etatu'),
(2, 'cały etat'),
(3, 'dodatkowa/tymczasowa');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ogloszenie_kategorie`
--

CREATE TABLE `ogloszenie_kategorie` (
  `ogloszenie_kategoria_id` int(10) UNSIGNED NOT NULL,
  `ogloszenie_id` int(10) UNSIGNED NOT NULL,
  `kategoria_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `ogloszenie_kategorie`
--

INSERT INTO `ogloszenie_kategorie` (`ogloszenie_kategoria_id`, `ogloszenie_id`, `kategoria_id`) VALUES
(6, 51, 5),
(20, 55, 5),
(26, 58, 4),
(27, 58, 7),
(60, 52, 4),
(61, 52, 5),
(71, 67, 4),
(72, 67, 7),
(74, 59, 33),
(75, 59, 86),
(76, 68, 86);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ogloszenie_obowiazki`
--

CREATE TABLE `ogloszenie_obowiazki` (
  `obowiazek_id` int(11) UNSIGNED NOT NULL,
  `obowiazekText` text NOT NULL,
  `ogloszenie_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `ogloszenie_obowiazki`
--

INSERT INTO `ogloszenie_obowiazki` (`obowiazek_id`, `obowiazekText`, `ogloszenie_id`) VALUES
(6, 'saddadasd', 51),
(19, 'asdadasda', 55),
(20, 'adasdsa', 55),
(24, 'aad', 58),
(25, 'aad', 58),
(106, 'adsdada', 52),
(107, 'edytowany oowiazek', 52),
(108, 'aas', 52),
(114, 'saaaa', 67),
(116, 'adadda', 59),
(117, 'aaaa obo', 68),
(118, 'assasadaaa', 68),
(119, 'ddddddddd', 68),
(120, 'kyhhfhhfhfhfhfgchgf', 68),
(121, 'dsadad', 68),
(122, 'vvvvvvv', 68);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ogloszenie_rodzaje_pracy`
--

CREATE TABLE `ogloszenie_rodzaje_pracy` (
  `rodzaj_pracy_id` int(10) UNSIGNED NOT NULL,
  `rodzaj_pracy` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `ogloszenie_rodzaje_pracy`
--

INSERT INTO `ogloszenie_rodzaje_pracy` (`rodzaj_pracy_id`, `rodzaj_pracy`) VALUES
(4, 'stacjonarna\r\n'),
(5, 'hybrydowa'),
(6, 'zdalna');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ogloszenie_stanowiska`
--

CREATE TABLE `ogloszenie_stanowiska` (
  `stanowisko_id` int(10) UNSIGNED NOT NULL,
  `nazwa_stanowiska` varchar(90) NOT NULL,
  `poziom_stanowiska` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `ogloszenie_stanowiska`
--

INSERT INTO `ogloszenie_stanowiska` (`stanowisko_id`, `nazwa_stanowiska`, `poziom_stanowiska`) VALUES
(2, 'praktykant/stażysta', ''),
(3, ' asystent', ''),
(4, 'młodszy specjalista', '(junior)'),
(5, 'specjalista', '(mid)'),
(6, 'starszy specjalista', '(senior)'),
(7, 'ekspert', ''),
(8, 'kierownik/koordynator', ''),
(9, 'menedżer', ''),
(10, 'dyrektor', ''),
(11, 'prezes', '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ogloszenie_umowy`
--

CREATE TABLE `ogloszenie_umowy` (
  `umowa_id` int(10) UNSIGNED NOT NULL,
  `rodzaj_umowy` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `ogloszenie_umowy`
--

INSERT INTO `ogloszenie_umowy` (`umowa_id`, `rodzaj_umowy`) VALUES
(1, 'umowa o pracę'),
(2, 'umowa o dzieło'),
(3, 'zlecenie'),
(4, 'umowa B2B'),
(5, 'zastępstwo'),
(6, 'staż/praktyka');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ogloszenie_wymagania`
--

CREATE TABLE `ogloszenie_wymagania` (
  `wymaganie_id` int(10) UNSIGNED NOT NULL,
  `wymaganieText` text NOT NULL,
  `ogloszenie_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `ogloszenie_wymagania`
--

INSERT INTO `ogloszenie_wymagania` (`wymaganie_id`, `wymaganieText`, `ogloszenie_id`) VALUES
(5, 'asdsasdsaddsa', 51),
(6, 'asdsadad', 51),
(18, 'sadasdada', 55),
(22, 'asdsasdsaddsa', 58),
(23, 'asdsasdsaddsa', 58),
(100, 'sdsadaddad', 52),
(101, 'edytowane wymaganie', 52),
(107, 'ddddd', 67),
(109, 'aaaa', 59),
(110, 'aaaa wymg', 68),
(111, 'ggfggdgdg', 68),
(112, 'fdgfgfdgdgfdg', 68),
(113, 'zfgdggfdgfdg', 68),
(114, 'fgdgfdfgdgdfg', 68),
(115, 'dfggfgfdgfd', 68);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `profile`
--

CREATE TABLE `profile` (
  `profil_id` int(10) UNSIGNED NOT NULL,
  `imie` varchar(30) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `data_urodzenia` date NOT NULL,
  `telefon` varchar(50) NOT NULL,
  `zdjecie_profilowe` text NOT NULL,
  `podsumowanie_zawodowe` text NOT NULL,
  `stanowisko_pracy_id` int(10) UNSIGNED NOT NULL,
  `uzytkownik_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`profil_id`, `imie`, `nazwisko`, `data_urodzenia`, `telefon`, `zdjecie_profilowe`, `podsumowanie_zawodowe`, `stanowisko_pracy_id`, `uzytkownik_id`) VALUES
(1, 'Piotr', 'Sroka', '2005-08-09', '111 222 333', '../Images/Profile/mineTheWorld.png', 'cośtam cośtam , nie ma to znaczenia,fjnfsnfisfuisfuiosdfusdbfuosdbfuysdbfuysdbfuysdbfudbfudhfuszdbfudgbfuiszdgbfudybfuysdgfuy9szdghfuyszdfbuydhfusdbfuszdbfudosbfuosdbfosdbof', 1, 1),
(2, 'Adam', 'Oleksy', '2006-10-01', '777 883 232', '../Images/Profile/czarna-dziura.jpg', 'jakies doswiadczenie', 1, 2),
(3, '', '', '0000-00-00', '', '', '', 0, 4);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `profil_aktywnosci`
--

CREATE TABLE `profil_aktywnosci` (
  `aktywnosc_id` int(10) UNSIGNED NOT NULL,
  `organizacja` text NOT NULL,
  `czas_trwania_od` date NOT NULL,
  `czas_trwania_do` date NOT NULL,
  `miejsce` text NOT NULL,
  `czynnosci` text NOT NULL,
  `profil_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `profil_aktywnosci`
--

INSERT INTO `profil_aktywnosci` (`aktywnosc_id`, `organizacja`, `czas_trwania_od`, `czas_trwania_do`, `miejsce`, `czynnosci`, `profil_id`) VALUES
(1, 'Jakas podejrzana organizacja nwm', '2024-05-16', '2024-05-25', 'Białystok', 'podejrzne czynności bardzo', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `profil_dodatkowe_szkolenia`
--

CREATE TABLE `profil_dodatkowe_szkolenia` (
  `szkolenie_id` int(11) UNSIGNED NOT NULL,
  `nazwa_szkolenia` varchar(70) NOT NULL,
  `organizator` varchar(60) NOT NULL,
  `data_szkolenia_od` date NOT NULL,
  `data_szkolenia_do` date NOT NULL,
  `profil_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `profil_dodatkowe_szkolenia`
--

INSERT INTO `profil_dodatkowe_szkolenia` (`szkolenie_id`, `nazwa_szkolenia`, `organizator`, `data_szkolenia_od`, `data_szkolenia_do`, `profil_id`) VALUES
(1, 'Szkolenie C++', 'Maciej Bąk', '2018-05-01', '2018-05-31', 1),
(2, 'Szkolenie C#', 'Artur Pieczarek', '2019-05-08', '2024-05-22', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `profil_doswiadczenie_zawodowe`
--

CREATE TABLE `profil_doswiadczenie_zawodowe` (
  `doswiadczenie_zawodowe_id` int(10) UNSIGNED NOT NULL,
  `stanowisko` varchar(70) NOT NULL,
  `nazwa_firmy` varchar(50) NOT NULL,
  `lokalizacja` varchar(70) NOT NULL,
  `okres_zatrudnienia_od` date NOT NULL,
  `okres_zatrudnienia_do` date DEFAULT NULL,
  `obowiazki` text NOT NULL,
  `profil_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `profil_doswiadczenie_zawodowe`
--

INSERT INTO `profil_doswiadczenie_zawodowe` (`doswiadczenie_zawodowe_id`, `stanowisko`, `nazwa_firmy`, `lokalizacja`, `okres_zatrudnienia_od`, `okres_zatrudnienia_do`, `obowiazki`, `profil_id`) VALUES
(1, 'Kasjer', 'Top-Market', 'Gdów', '2020-05-12', '2024-05-01', 'obsługa klienta', 1),
(2, 'zbieracz malin', 'Januszex', 'Holandia', '2020-05-06', '2020-05-31', 'zbieranie truskawek', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `profil_hobby`
--

CREATE TABLE `profil_hobby` (
  `hobby_id` int(10) UNSIGNED NOT NULL,
  `hobbyText` text NOT NULL,
  `profil_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `profil_hobby`
--

INSERT INTO `profil_hobby` (`hobby_id`, `hobbyText`, `profil_id`) VALUES
(1, 'gra w życie', 1),
(2, 'spanie', 1),
(3, 'granie', 1),
(8, 'nic nie robienie', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `profil_linki`
--

CREATE TABLE `profil_linki` (
  `link_id` int(10) UNSIGNED NOT NULL,
  `tytul_linku` text NOT NULL,
  `link` text NOT NULL,
  `profil_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `profil_linki`
--

INSERT INTO `profil_linki` (`link_id`, `tytul_linku`, `link`, `profil_id`) VALUES
(1, 'GitHub', 'https://github.com/PiotrSroka2005', 1),
(2, 'StackOverflow', 'https://stackoverflow.com/', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `profil_miejsce_zamieszkania`
--

CREATE TABLE `profil_miejsce_zamieszkania` (
  `miejsce_zamieszkania_id` int(10) UNSIGNED NOT NULL,
  `miasto` varchar(80) NOT NULL,
  `profil_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `profil_miejsce_zamieszkania`
--

INSERT INTO `profil_miejsce_zamieszkania` (`miejsce_zamieszkania_id`, `miasto`, `profil_id`) VALUES
(1, 'Słopnice', 1),
(2, 'Krakow', 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `profil_stanowisko_pracy`
--

CREATE TABLE `profil_stanowisko_pracy` (
  `stanowisko_pracy_id` int(10) UNSIGNED NOT NULL,
  `nazwa_stanowiska` varchar(80) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `opis_stanowiska` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `profil_stanowisko_pracy`
--

INSERT INTO `profil_stanowisko_pracy` (`stanowisko_pracy_id`, `nazwa_stanowiska`, `opis_stanowiska`) VALUES
(1, 'Programista', 'Web developer');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `profil_wyksztalcenie`
--

CREATE TABLE `profil_wyksztalcenie` (
  `wykszatlcenie_id` int(10) UNSIGNED NOT NULL,
  `placowka` varchar(70) NOT NULL,
  `miejscowosc` varchar(70) NOT NULL,
  `poziom_wyksztalcenia` enum('podstawowe','zawodowe','srednie','licencjat') CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `kierunek` varchar(50) NOT NULL,
  `okres_wyksztalcenia_od` date NOT NULL,
  `okres_wyksztalcenia_do` date NOT NULL,
  `profil_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `profil_wyksztalcenie`
--

INSERT INTO `profil_wyksztalcenie` (`wykszatlcenie_id`, `placowka`, `miejscowosc`, `poziom_wyksztalcenia`, `kierunek`, `okres_wyksztalcenia_od`, `okres_wyksztalcenia_do`, `profil_id`) VALUES
(1, 'Szkoła podstawowa Nr2 w Słopnicach dolnych', 'Słopnice', 'podstawowe', 'ogólny', '2011-09-01', '2020-06-21', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `profil_znajomosc_jezykow`
--

CREATE TABLE `profil_znajomosc_jezykow` (
  `jezyk_id` int(10) UNSIGNED NOT NULL,
  `jezyk` varchar(50) NOT NULL,
  `poziom_jezyka` enum('ojczysty','podstawowy','srednio-zaawansowany','zaawansowany','') NOT NULL,
  `profil_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `profil_znajomosc_jezykow`
--

INSERT INTO `profil_znajomosc_jezykow` (`jezyk_id`, `jezyk`, `poziom_jezyka`, `profil_id`) VALUES
(1, 'Angielski', 'srednio-zaawansowany', 1),
(3, 'Polski', 'ojczysty', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ulubione`
--

CREATE TABLE `ulubione` (
  `ulubione_id` int(10) UNSIGNED NOT NULL,
  `uzytkownik_id` int(10) UNSIGNED NOT NULL,
  `ogloszenie_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `ulubione`
--

INSERT INTO `ulubione` (`ulubione_id`, `uzytkownik_id`, `ogloszenie_id`) VALUES
(54, 1, 51);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `umiejetnosci`
--

CREATE TABLE `umiejetnosci` (
  `umiejetnosc_id` int(10) UNSIGNED NOT NULL,
  `profil_id` int(10) UNSIGNED NOT NULL,
  `umiejetnoscText` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `umiejetnosci`
--

INSERT INTO `umiejetnosci` (`umiejetnosc_id`, `profil_id`, `umiejetnoscText`) VALUES
(1, 1, 'kmdmfdkfdfkdmfpkdfpdmnfdnfpidnfdfnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn'),
(2, 1, 'dddkamdsadmksdsadmksadmksadksadksadksadasdsadadsasdsadsadasdddadsad');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `uzytkownik_id` int(10) UNSIGNED NOT NULL,
  `nick` varchar(25) NOT NULL,
  `haslo` varchar(260) NOT NULL,
  `email` varchar(200) NOT NULL,
  `administrator` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`uzytkownik_id`, `nick`, `haslo`, `email`, `administrator`) VALUES
(1, 'Delviner', '$2y$10$amnlz9kkXM301QlN7RkHBuRERY5SgFziYhSxp8vSEa.0BIHJfs/Hi', 'reniffer23467@wp.pl', 1),
(2, 'Gigan', '$2y$10$mxV9V16m5JKA3e4weeWdIO5e1rxiHW43ZmZG488rDr6G9h6qjUDly', 'gigan@wp.pl', 0),
(4, 'Testowy', '$2y$10$FCYo6xxQqkB6sAWOl7Phh.Run/niSNOctQxVbZFtfuYLsGHVyZuiW', 'testowy@emaial.pl', 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `aplikowania`
--
ALTER TABLE `aplikowania`
  ADD PRIMARY KEY (`aplikowanie_id`),
  ADD KEY `uzytkownik_id` (`uzytkownik_id`),
  ADD KEY `ogloszenie_id` (`ogloszenie_id`);

--
-- Indeksy dla tabeli `firmy`
--
ALTER TABLE `firmy`
  ADD PRIMARY KEY (`firma_id`);

--
-- Indeksy dla tabeli `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`kategoria_id`);

--
-- Indeksy dla tabeli `ogloszenia`
--
ALTER TABLE `ogloszenia`
  ADD PRIMARY KEY (`ogloszenie_id`),
  ADD KEY `stanowisko_id` (`stanowisko_id`),
  ADD KEY `firma_id` (`firma_id`),
  ADD KEY `rodzaj_pracy_id` (`rodzaj_pracy_id`),
  ADD KEY `umowa_id` (`umowa_id`),
  ADD KEY `etat_id` (`etat_id`);

--
-- Indeksy dla tabeli `ogloszenie_benefity`
--
ALTER TABLE `ogloszenie_benefity`
  ADD PRIMARY KEY (`benefit_id`),
  ADD KEY `ogloszenie_id` (`ogloszenie_id`);

--
-- Indeksy dla tabeli `ogloszenie_etaty`
--
ALTER TABLE `ogloszenie_etaty`
  ADD PRIMARY KEY (`etat_id`);

--
-- Indeksy dla tabeli `ogloszenie_kategorie`
--
ALTER TABLE `ogloszenie_kategorie`
  ADD PRIMARY KEY (`ogloszenie_kategoria_id`),
  ADD KEY `ogloszenie_id` (`ogloszenie_id`),
  ADD KEY `kategoria_id` (`kategoria_id`);

--
-- Indeksy dla tabeli `ogloszenie_obowiazki`
--
ALTER TABLE `ogloszenie_obowiazki`
  ADD PRIMARY KEY (`obowiazek_id`),
  ADD KEY `ogloszenie_id` (`ogloszenie_id`);

--
-- Indeksy dla tabeli `ogloszenie_rodzaje_pracy`
--
ALTER TABLE `ogloszenie_rodzaje_pracy`
  ADD PRIMARY KEY (`rodzaj_pracy_id`);

--
-- Indeksy dla tabeli `ogloszenie_stanowiska`
--
ALTER TABLE `ogloszenie_stanowiska`
  ADD PRIMARY KEY (`stanowisko_id`);

--
-- Indeksy dla tabeli `ogloszenie_umowy`
--
ALTER TABLE `ogloszenie_umowy`
  ADD PRIMARY KEY (`umowa_id`);

--
-- Indeksy dla tabeli `ogloszenie_wymagania`
--
ALTER TABLE `ogloszenie_wymagania`
  ADD PRIMARY KEY (`wymaganie_id`),
  ADD KEY `ogloszenie_id` (`ogloszenie_id`);

--
-- Indeksy dla tabeli `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`profil_id`),
  ADD KEY `stanowisko_pracy_id` (`stanowisko_pracy_id`),
  ADD KEY `uzytkownik_id` (`uzytkownik_id`);

--
-- Indeksy dla tabeli `profil_aktywnosci`
--
ALTER TABLE `profil_aktywnosci`
  ADD PRIMARY KEY (`aktywnosc_id`),
  ADD KEY `profil_id` (`profil_id`);

--
-- Indeksy dla tabeli `profil_dodatkowe_szkolenia`
--
ALTER TABLE `profil_dodatkowe_szkolenia`
  ADD PRIMARY KEY (`szkolenie_id`),
  ADD KEY `uzytkownik_id` (`profil_id`);

--
-- Indeksy dla tabeli `profil_doswiadczenie_zawodowe`
--
ALTER TABLE `profil_doswiadczenie_zawodowe`
  ADD PRIMARY KEY (`doswiadczenie_zawodowe_id`),
  ADD KEY `uzytkownik_id` (`profil_id`);

--
-- Indeksy dla tabeli `profil_hobby`
--
ALTER TABLE `profil_hobby`
  ADD PRIMARY KEY (`hobby_id`),
  ADD KEY `profil_id` (`profil_id`);

--
-- Indeksy dla tabeli `profil_linki`
--
ALTER TABLE `profil_linki`
  ADD PRIMARY KEY (`link_id`),
  ADD KEY `uzytkownik_id` (`profil_id`);

--
-- Indeksy dla tabeli `profil_miejsce_zamieszkania`
--
ALTER TABLE `profil_miejsce_zamieszkania`
  ADD PRIMARY KEY (`miejsce_zamieszkania_id`),
  ADD KEY `uzytkownik_id` (`profil_id`);

--
-- Indeksy dla tabeli `profil_stanowisko_pracy`
--
ALTER TABLE `profil_stanowisko_pracy`
  ADD PRIMARY KEY (`stanowisko_pracy_id`);

--
-- Indeksy dla tabeli `profil_wyksztalcenie`
--
ALTER TABLE `profil_wyksztalcenie`
  ADD PRIMARY KEY (`wykszatlcenie_id`),
  ADD KEY `uzytkownik_id` (`profil_id`);

--
-- Indeksy dla tabeli `profil_znajomosc_jezykow`
--
ALTER TABLE `profil_znajomosc_jezykow`
  ADD PRIMARY KEY (`jezyk_id`),
  ADD KEY `uzytkownik_id` (`profil_id`);

--
-- Indeksy dla tabeli `ulubione`
--
ALTER TABLE `ulubione`
  ADD PRIMARY KEY (`ulubione_id`),
  ADD KEY `uzytkownik_id` (`uzytkownik_id`),
  ADD KEY `ogloszenie_id` (`ogloszenie_id`);

--
-- Indeksy dla tabeli `umiejetnosci`
--
ALTER TABLE `umiejetnosci`
  ADD PRIMARY KEY (`umiejetnosc_id`),
  ADD KEY `uzytkownik_id` (`profil_id`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`uzytkownik_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aplikowania`
--
ALTER TABLE `aplikowania`
  MODIFY `aplikowanie_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `firmy`
--
ALTER TABLE `firmy`
  MODIFY `firma_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `kategoria_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `ogloszenia`
--
ALTER TABLE `ogloszenia`
  MODIFY `ogloszenie_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `ogloszenie_benefity`
--
ALTER TABLE `ogloszenie_benefity`
  MODIFY `benefit_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `ogloszenie_etaty`
--
ALTER TABLE `ogloszenie_etaty`
  MODIFY `etat_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ogloszenie_kategorie`
--
ALTER TABLE `ogloszenie_kategorie`
  MODIFY `ogloszenie_kategoria_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `ogloszenie_obowiazki`
--
ALTER TABLE `ogloszenie_obowiazki`
  MODIFY `obowiazek_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `ogloszenie_rodzaje_pracy`
--
ALTER TABLE `ogloszenie_rodzaje_pracy`
  MODIFY `rodzaj_pracy_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ogloszenie_stanowiska`
--
ALTER TABLE `ogloszenie_stanowiska`
  MODIFY `stanowisko_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ogloszenie_umowy`
--
ALTER TABLE `ogloszenie_umowy`
  MODIFY `umowa_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ogloszenie_wymagania`
--
ALTER TABLE `ogloszenie_wymagania`
  MODIFY `wymaganie_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `profil_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `profil_aktywnosci`
--
ALTER TABLE `profil_aktywnosci`
  MODIFY `aktywnosc_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `profil_dodatkowe_szkolenia`
--
ALTER TABLE `profil_dodatkowe_szkolenia`
  MODIFY `szkolenie_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `profil_doswiadczenie_zawodowe`
--
ALTER TABLE `profil_doswiadczenie_zawodowe`
  MODIFY `doswiadczenie_zawodowe_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `profil_hobby`
--
ALTER TABLE `profil_hobby`
  MODIFY `hobby_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `profil_linki`
--
ALTER TABLE `profil_linki`
  MODIFY `link_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `profil_miejsce_zamieszkania`
--
ALTER TABLE `profil_miejsce_zamieszkania`
  MODIFY `miejsce_zamieszkania_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `profil_stanowisko_pracy`
--
ALTER TABLE `profil_stanowisko_pracy`
  MODIFY `stanowisko_pracy_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `profil_wyksztalcenie`
--
ALTER TABLE `profil_wyksztalcenie`
  MODIFY `wykszatlcenie_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `profil_znajomosc_jezykow`
--
ALTER TABLE `profil_znajomosc_jezykow`
  MODIFY `jezyk_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ulubione`
--
ALTER TABLE `ulubione`
  MODIFY `ulubione_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `umiejetnosci`
--
ALTER TABLE `umiejetnosci`
  MODIFY `umiejetnosc_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `uzytkownik_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aplikowania`
--
ALTER TABLE `aplikowania`
  ADD CONSTRAINT `aplikowania_ibfk_1` FOREIGN KEY (`ogloszenie_id`) REFERENCES `ogloszenia` (`ogloszenie_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `aplikowania_ibfk_2` FOREIGN KEY (`uzytkownik_id`) REFERENCES `uzytkownicy` (`uzytkownik_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ogloszenia`
--
ALTER TABLE `ogloszenia`
  ADD CONSTRAINT `ogloszenia_ibfk_1` FOREIGN KEY (`firma_id`) REFERENCES `firmy` (`firma_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ogloszenia_ibfk_3` FOREIGN KEY (`stanowisko_id`) REFERENCES `ogloszenie_stanowiska` (`stanowisko_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ogloszenia_ibfk_4` FOREIGN KEY (`etat_id`) REFERENCES `ogloszenie_etaty` (`etat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ogloszenia_ibfk_5` FOREIGN KEY (`rodzaj_pracy_id`) REFERENCES `ogloszenie_rodzaje_pracy` (`rodzaj_pracy_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ogloszenia_ibfk_6` FOREIGN KEY (`umowa_id`) REFERENCES `ogloszenie_umowy` (`umowa_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ogloszenie_benefity`
--
ALTER TABLE `ogloszenie_benefity`
  ADD CONSTRAINT `ogloszenie_benefity_ibfk_1` FOREIGN KEY (`ogloszenie_id`) REFERENCES `ogloszenia` (`ogloszenie_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ogloszenie_kategorie`
--
ALTER TABLE `ogloszenie_kategorie`
  ADD CONSTRAINT `ogloszenie_kategorie_ibfk_1` FOREIGN KEY (`kategoria_id`) REFERENCES `kategorie` (`kategoria_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ogloszenie_kategorie_ibfk_2` FOREIGN KEY (`ogloszenie_id`) REFERENCES `ogloszenia` (`ogloszenie_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ogloszenie_obowiazki`
--
ALTER TABLE `ogloszenie_obowiazki`
  ADD CONSTRAINT `ogloszenie_obowiazki_ibfk_1` FOREIGN KEY (`ogloszenie_id`) REFERENCES `ogloszenia` (`ogloszenie_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ogloszenie_wymagania`
--
ALTER TABLE `ogloszenie_wymagania`
  ADD CONSTRAINT `ogloszenie_wymagania_ibfk_1` FOREIGN KEY (`ogloszenie_id`) REFERENCES `ogloszenia` (`ogloszenie_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`uzytkownik_id`) REFERENCES `uzytkownicy` (`uzytkownik_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profil_aktywnosci`
--
ALTER TABLE `profil_aktywnosci`
  ADD CONSTRAINT `profil_aktywnosci_ibfk_1` FOREIGN KEY (`profil_id`) REFERENCES `profile` (`profil_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profil_dodatkowe_szkolenia`
--
ALTER TABLE `profil_dodatkowe_szkolenia`
  ADD CONSTRAINT `profil_dodatkowe_szkolenia_ibfk_1` FOREIGN KEY (`profil_id`) REFERENCES `profile` (`profil_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profil_doswiadczenie_zawodowe`
--
ALTER TABLE `profil_doswiadczenie_zawodowe`
  ADD CONSTRAINT `profil_doswiadczenie_zawodowe_ibfk_1` FOREIGN KEY (`profil_id`) REFERENCES `profile` (`profil_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profil_hobby`
--
ALTER TABLE `profil_hobby`
  ADD CONSTRAINT `profil_hobby_ibfk_1` FOREIGN KEY (`profil_id`) REFERENCES `profile` (`profil_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profil_linki`
--
ALTER TABLE `profil_linki`
  ADD CONSTRAINT `profil_linki_ibfk_1` FOREIGN KEY (`profil_id`) REFERENCES `profile` (`profil_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profil_miejsce_zamieszkania`
--
ALTER TABLE `profil_miejsce_zamieszkania`
  ADD CONSTRAINT `profil_miejsce_zamieszkania_ibfk_1` FOREIGN KEY (`profil_id`) REFERENCES `profile` (`profil_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profil_stanowisko_pracy`
--
ALTER TABLE `profil_stanowisko_pracy`
  ADD CONSTRAINT `profil_stanowisko_pracy_ibfk_1` FOREIGN KEY (`stanowisko_pracy_id`) REFERENCES `profile` (`stanowisko_pracy_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profil_wyksztalcenie`
--
ALTER TABLE `profil_wyksztalcenie`
  ADD CONSTRAINT `profil_wyksztalcenie_ibfk_1` FOREIGN KEY (`profil_id`) REFERENCES `profile` (`profil_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profil_znajomosc_jezykow`
--
ALTER TABLE `profil_znajomosc_jezykow`
  ADD CONSTRAINT `profil_znajomosc_jezykow_ibfk_1` FOREIGN KEY (`profil_id`) REFERENCES `profile` (`profil_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ulubione`
--
ALTER TABLE `ulubione`
  ADD CONSTRAINT `ulubione_ibfk_1` FOREIGN KEY (`ogloszenie_id`) REFERENCES `ogloszenia` (`ogloszenie_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ulubione_ibfk_2` FOREIGN KEY (`uzytkownik_id`) REFERENCES `uzytkownicy` (`uzytkownik_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `umiejetnosci`
--
ALTER TABLE `umiejetnosci`
  ADD CONSTRAINT `umiejetnosci_ibfk_1` FOREIGN KEY (`profil_id`) REFERENCES `profile` (`profil_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
