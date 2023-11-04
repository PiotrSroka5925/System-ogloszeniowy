-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Lis 05, 2023 at 12:00 AM
-- Wersja serwera: 10.4.28-MariaDB
-- Wersja PHP: 8.2.4

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

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `aplikacja`
--

CREATE TABLE `aplikacja` (
  `aplikacja_id` int(11) UNSIGNED NOT NULL,
  `cv` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `frima`
--

CREATE TABLE `frima` (
  `firma_id` int(10) UNSIGNED NOT NULL,
  `nazwa_firmy` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategoria`
--

CREATE TABLE `kategoria` (
  `kategoria_id` int(11) UNSIGNED NOT NULL,
  `nazwa_kategorii` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ogloszenie`
--

CREATE TABLE `ogloszenie` (
  `ogloszenie_id` int(10) UNSIGNED NOT NULL,
  `nazwa_ogloszenia` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `lokalizacja` text NOT NULL,
  `firma_id` int(10) UNSIGNED NOT NULL,
  `stanowisko_id` int(10) UNSIGNED NOT NULL,
  `rodzaj_umowy` varchar(40) NOT NULL,
  `wymiar_zatrudnienia` varchar(200) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `rodzaj_pracy` enum('zdalna','stacjonarna','hybrydowa','') NOT NULL,
  `wynagrodzenie` text CHARACTER SET utf16 COLLATE utf16_polish_ci NOT NULL,
  `dni_pracy` text NOT NULL,
  `godziny_pracy` text NOT NULL,
  `data_waznosci` date NOT NULL,
  `obowiazki` text NOT NULL,
  `wymagania` text NOT NULL,
  `benefity` text NOT NULL,
  `informacje` text NOT NULL,
  `kategoria_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ogloszenie_stanowisko`
--

CREATE TABLE `ogloszenie_stanowisko` (
  `stanowisko_id` int(10) UNSIGNED NOT NULL,
  `nazwa_stanowiska` varchar(90) NOT NULL,
  `poziom_stanowiska` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownik`
--

CREATE TABLE `uzytkownik` (
  `uzytkownik_id` int(10) UNSIGNED NOT NULL,
  `imie` varchar(30) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `haslo` varchar(260) NOT NULL,
  `data_urodzenia` date NOT NULL,
  `email` varchar(200) NOT NULL,
  `telefon` varchar(50) NOT NULL,
  `zdjecie_profilowe` varchar(1000) NOT NULL,
  `umiejetnosci` text NOT NULL,
  `podsumowanie_zawodowe` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `stanowisko_pracy_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownik_dodatkowe_szkolenia`
--

CREATE TABLE `uzytkownik_dodatkowe_szkolenia` (
  `szkolenie_id` int(11) UNSIGNED NOT NULL,
  `nazwa_szkolenia` varchar(70) NOT NULL,
  `organizator` int(60) NOT NULL,
  `data_szkolenia_od` date NOT NULL,
  `data_szkolenia_do` int(11) NOT NULL,
  `uzytkownik_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownik_doswiadczenie_zawodowe`
--

CREATE TABLE `uzytkownik_doswiadczenie_zawodowe` (
  `doswiadczenie_zawodowe_id` int(10) UNSIGNED NOT NULL,
  `stanowisko` varchar(70) NOT NULL,
  `nazwa_firmy` varchar(50) NOT NULL,
  `lokalizacja` varchar(70) NOT NULL,
  `okres_zatrudnienia_od` date NOT NULL,
  `okres_zatrudnienia_do` date DEFAULT NULL,
  `obowiazki` text NOT NULL,
  `uzytkownik_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownik_linki`
--

CREATE TABLE `uzytkownik_linki` (
  `link_id` int(10) UNSIGNED NOT NULL,
  `link` text NOT NULL,
  `uzytkownik_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownik_miejsce_zamieszkania`
--

CREATE TABLE `uzytkownik_miejsce_zamieszkania` (
  `miejsce_zamieszkania_id` int(10) UNSIGNED NOT NULL,
  `miasto` varchar(80) NOT NULL,
  `ulica` text CHARACTER SET utf32 COLLATE utf32_polish_ci NOT NULL,
  `kod_pocztowy` text NOT NULL,
  `numer_domu` smallint(6) NOT NULL,
  `uzytkownik_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownik_stanowisko_pracy`
--

CREATE TABLE `uzytkownik_stanowisko_pracy` (
  `stanowisko_pracy_id` int(10) UNSIGNED NOT NULL,
  `nazwa_stanowiska` varchar(80) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `opis_stanowiska` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownik_wykszatlcenie`
--

CREATE TABLE `uzytkownik_wykszatlcenie` (
  `wykszatlcenie_id` int(10) UNSIGNED NOT NULL,
  `placowka` varchar(70) NOT NULL,
  `miejscowosc` varchar(70) NOT NULL,
  `poziom_wyksztalcenia` enum('podstawowe','zawodowe','srednie','licencjat') CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `kierunek` varchar(50) NOT NULL,
  `okres_wyksztalcenia_od` date NOT NULL,
  `okres_wyksztalcenia_do` date NOT NULL,
  `uzytkownik_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownik_znajomosc_jezykow`
--

CREATE TABLE `uzytkownik_znajomosc_jezykow` (
  `jezyk_id` int(10) UNSIGNED NOT NULL,
  `jezyk` varchar(50) NOT NULL,
  `poziom_jezyka` enum('podstawowy','srednio-zaawansowany','zaawansowany','') NOT NULL,
  `uzytkownik_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `aplikacja`
--
ALTER TABLE `aplikacja`
  ADD PRIMARY KEY (`aplikacja_id`);

--
-- Indeksy dla tabeli `frima`
--
ALTER TABLE `frima`
  ADD PRIMARY KEY (`firma_id`);

--
-- Indeksy dla tabeli `kategoria`
--
ALTER TABLE `kategoria`
  ADD PRIMARY KEY (`kategoria_id`);

--
-- Indeksy dla tabeli `ogloszenie`
--
ALTER TABLE `ogloszenie`
  ADD PRIMARY KEY (`ogloszenie_id`),
  ADD KEY `stanowisko_id` (`stanowisko_id`),
  ADD KEY `kategoria_id` (`kategoria_id`),
  ADD KEY `firma_id` (`firma_id`);

--
-- Indeksy dla tabeli `ogloszenie_stanowisko`
--
ALTER TABLE `ogloszenie_stanowisko`
  ADD PRIMARY KEY (`stanowisko_id`);

--
-- Indeksy dla tabeli `uzytkownik`
--
ALTER TABLE `uzytkownik`
  ADD PRIMARY KEY (`uzytkownik_id`),
  ADD KEY `uzytkownik_stanowisko_pracy_id` (`stanowisko_pracy_id`);

--
-- Indeksy dla tabeli `uzytkownik_dodatkowe_szkolenia`
--
ALTER TABLE `uzytkownik_dodatkowe_szkolenia`
  ADD PRIMARY KEY (`szkolenie_id`),
  ADD KEY `uzytkownik_id` (`uzytkownik_id`);

--
-- Indeksy dla tabeli `uzytkownik_doswiadczenie_zawodowe`
--
ALTER TABLE `uzytkownik_doswiadczenie_zawodowe`
  ADD PRIMARY KEY (`doswiadczenie_zawodowe_id`),
  ADD KEY `uzytkownik_id` (`uzytkownik_id`);

--
-- Indeksy dla tabeli `uzytkownik_linki`
--
ALTER TABLE `uzytkownik_linki`
  ADD PRIMARY KEY (`link_id`),
  ADD KEY `uzytkownik_id` (`uzytkownik_id`);

--
-- Indeksy dla tabeli `uzytkownik_miejsce_zamieszkania`
--
ALTER TABLE `uzytkownik_miejsce_zamieszkania`
  ADD PRIMARY KEY (`miejsce_zamieszkania_id`),
  ADD KEY `uzytkownik_id` (`uzytkownik_id`);

--
-- Indeksy dla tabeli `uzytkownik_stanowisko_pracy`
--
ALTER TABLE `uzytkownik_stanowisko_pracy`
  ADD PRIMARY KEY (`stanowisko_pracy_id`);

--
-- Indeksy dla tabeli `uzytkownik_wykszatlcenie`
--
ALTER TABLE `uzytkownik_wykszatlcenie`
  ADD PRIMARY KEY (`wykszatlcenie_id`),
  ADD KEY `uzytkownik_id` (`uzytkownik_id`);

--
-- Indeksy dla tabeli `uzytkownik_znajomosc_jezykow`
--
ALTER TABLE `uzytkownik_znajomosc_jezykow`
  ADD PRIMARY KEY (`jezyk_id`),
  ADD KEY `uzytkownik_id` (`uzytkownik_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aplikacja`
--
ALTER TABLE `aplikacja`
  MODIFY `aplikacja_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frima`
--
ALTER TABLE `frima`
  MODIFY `firma_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategoria`
--
ALTER TABLE `kategoria`
  MODIFY `kategoria_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ogloszenie`
--
ALTER TABLE `ogloszenie`
  MODIFY `ogloszenie_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ogloszenie_stanowisko`
--
ALTER TABLE `ogloszenie_stanowisko`
  MODIFY `stanowisko_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uzytkownik`
--
ALTER TABLE `uzytkownik`
  MODIFY `uzytkownik_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uzytkownik_dodatkowe_szkolenia`
--
ALTER TABLE `uzytkownik_dodatkowe_szkolenia`
  MODIFY `szkolenie_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uzytkownik_doswiadczenie_zawodowe`
--
ALTER TABLE `uzytkownik_doswiadczenie_zawodowe`
  MODIFY `doswiadczenie_zawodowe_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uzytkownik_linki`
--
ALTER TABLE `uzytkownik_linki`
  MODIFY `link_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uzytkownik_miejsce_zamieszkania`
--
ALTER TABLE `uzytkownik_miejsce_zamieszkania`
  MODIFY `miejsce_zamieszkania_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uzytkownik_stanowisko_pracy`
--
ALTER TABLE `uzytkownik_stanowisko_pracy`
  MODIFY `stanowisko_pracy_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uzytkownik_wykszatlcenie`
--
ALTER TABLE `uzytkownik_wykszatlcenie`
  MODIFY `wykszatlcenie_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uzytkownik_znajomosc_jezykow`
--
ALTER TABLE `uzytkownik_znajomosc_jezykow`
  MODIFY `jezyk_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ogloszenie`
--
ALTER TABLE `ogloszenie`
  ADD CONSTRAINT `ogloszenie_ibfk_1` FOREIGN KEY (`firma_id`) REFERENCES `frima` (`firma_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ogloszenie_ibfk_2` FOREIGN KEY (`kategoria_id`) REFERENCES `kategoria` (`kategoria_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ogloszenie_stanowisko`
--
ALTER TABLE `ogloszenie_stanowisko`
  ADD CONSTRAINT `ogloszenie_stanowisko_ibfk_1` FOREIGN KEY (`stanowisko_id`) REFERENCES `ogloszenie` (`stanowisko_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `uzytkownik`
--
ALTER TABLE `uzytkownik`
  ADD CONSTRAINT `uzytkownik_ibfk_1` FOREIGN KEY (`uzytkownik_id`) REFERENCES `uzytkownik_linki` (`uzytkownik_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `uzytkownik_dodatkowe_szkolenia`
--
ALTER TABLE `uzytkownik_dodatkowe_szkolenia`
  ADD CONSTRAINT `uzytkownik_dodatkowe_szkolenia_ibfk_1` FOREIGN KEY (`uzytkownik_id`) REFERENCES `uzytkownik` (`uzytkownik_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `uzytkownik_doswiadczenie_zawodowe`
--
ALTER TABLE `uzytkownik_doswiadczenie_zawodowe`
  ADD CONSTRAINT `uzytkownik_doswiadczenie_zawodowe_ibfk_1` FOREIGN KEY (`uzytkownik_id`) REFERENCES `uzytkownik` (`uzytkownik_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `uzytkownik_miejsce_zamieszkania`
--
ALTER TABLE `uzytkownik_miejsce_zamieszkania`
  ADD CONSTRAINT `uzytkownik_miejsce_zamieszkania_ibfk_1` FOREIGN KEY (`uzytkownik_id`) REFERENCES `uzytkownik` (`uzytkownik_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `uzytkownik_stanowisko_pracy`
--
ALTER TABLE `uzytkownik_stanowisko_pracy`
  ADD CONSTRAINT `uzytkownik_stanowisko_pracy_ibfk_1` FOREIGN KEY (`stanowisko_pracy_id`) REFERENCES `uzytkownik` (`stanowisko_pracy_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `uzytkownik_wykszatlcenie`
--
ALTER TABLE `uzytkownik_wykszatlcenie`
  ADD CONSTRAINT `uzytkownik_wykszatlcenie_ibfk_1` FOREIGN KEY (`uzytkownik_id`) REFERENCES `uzytkownik` (`uzytkownik_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `uzytkownik_znajomosc_jezykow`
--
ALTER TABLE `uzytkownik_znajomosc_jezykow`
  ADD CONSTRAINT `uzytkownik_znajomosc_jezykow_ibfk_1` FOREIGN KEY (`uzytkownik_id`) REFERENCES `uzytkownik` (`uzytkownik_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
