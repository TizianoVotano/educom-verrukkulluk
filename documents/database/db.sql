-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2023 at 01:38 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `verrukkulluk`
--

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE `artikel` (
  `id` int(11) NOT NULL,
  `naam` varchar(50) NOT NULL,
  `omschrijving` varchar(300) NOT NULL,
  `prijs` float NOT NULL,
  `eenheid` int(10) NOT NULL COMMENT 'aantal verpakkingen',
  `verpakking` varchar(50) NOT NULL COMMENT 'bv grammen of liters',
  `calories` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`id`, `naam`, `omschrijving`, `prijs`, `eenheid`, `verpakking`, `calories`) VALUES
(1, 'Spagetti_Barilla_nr13', 'Een pak spaghetti van het merk Barilla', 2, 250, 'gram', 10),
(2, 'Knoflookbol', 'Netje met 5 bollen knoflook (50g/bol)', 2, 250, 'gram', 2),
(3, 'Olijfolie', 'Flesje Olijfolie', 4.53, 500, 'ml', 30),
(4, 'Rode Peper Pitjes', 'Gedroogde rode peper pitjes in een plastic verpakking', 6, 50, 'gram', 0),
(5, 'Bolognese Saus', 'Klaargemaakte bolognese saus', 3.25, 500, 'gram', 45),
(6, 'Zout', 'Zout in een container', 2, 100, 'gram', 0),
(7, 'Pesto', 'Pesto van basilicum', 3.85, 200, 'gram', 8),
(8, 'Parmezaanse Kaas', 'Geraspte parmezaanse kaas', 8.9, 200, 'gram', 35),
(9, 'Pijnboompitten', 'Pijnboompitten', 10, 150, 'gram', 15),
(10, 'Eieren', 'Een verpakking van 5 eieren', 2.5, 250, 'gram', 30),
(11, 'Ham', 'Gesneden Ham', 7.25, 150, 'gram', 65),
(12, 'Spek', 'Spekblokjes', 5, 200, 'gram', 74);

-- --------------------------------------------------------

--
-- Table structure for table `boodschappen`
--

CREATE TABLE `boodschappen` (
  `id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `artikel_id` int(20) NOT NULL,
  `aantal` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `boodschappen`
--

INSERT INTO `boodschappen` (`id`, `user_id`, `artikel_id`, `aantal`) VALUES
(1, 2, 1, 7000),
(2, 2, 2, 7),
(3, 2, 3, 7),
(4, 2, 4, 2),
(5, 2, 6, 327),
(6, 2, 5, 3000);

-- --------------------------------------------------------

--
-- Table structure for table `gerecht`
--

CREATE TABLE `gerecht` (
  `id` int(50) NOT NULL,
  `keuken_id` int(50) NOT NULL,
  `type_id` int(50) NOT NULL,
  `user_id` int(50) NOT NULL,
  `datum_toegevoegd` date NOT NULL,
  `titel` varchar(100) NOT NULL,
  `korte_omschrijving` text NOT NULL,
  `lange_omschrijving` text NOT NULL,
  `afbeelding` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gerecht`
--

INSERT INTO `gerecht` (`id`, `keuken_id`, `type_id`, `user_id`, `datum_toegevoegd`, `titel`, `korte_omschrijving`, `lange_omschrijving`, `afbeelding`) VALUES
(1, 3, 2, 2, '2023-06-01', 'Pasta Aglio Olio e Peperoncino', 'Een simpel en vlug gemaakte heerlijke maaltijd!', 'Pasta aglio e olio, wat \'knoflook en olie\' betekent, is een eenvoudig maar smaakvol Italiaans pastagerecht. Deze klassieke bereiding vereist slechts een handvol ingrediënten, maar de combinatie van knoflook, olijfolie en kruiden zorgt voor een heerlijk geurige en smaakvolle maaltijd.\r\n\r\nOm te beginnen, kook je de pasta al dente volgens de instructies op de verpakking. Terwijl de pasta kookt, verwarm je in een grote pan een ruime hoeveelheid olijfolie op middelhoog vuur. Voeg vervolgens dun gesneden knoflookteentjes toe en bak ze tot ze goudbruin zijn en een heerlijk aroma afgeven.\r\n\r\nZodra de knoflook goudbruin is, voeg je een snufje rode pepervlokken toe voor een vleugje pittigheid (optioneel, afhankelijk van je smaakvoorkeur). Voeg de gekookte pasta toe aan de pan met de knoflook-olie-mix en meng goed, zodat elke sliert bedekt is met de smaakvolle saus.\r\n\r\nBreng het gerecht op smaak met zout en peper en voeg een handvol gehakte peterselie toe voor een verfrissende smaak en wat kleur. Je kunt ook wat versgeraspte Parmezaanse kaas over de pasta strooien om de smaken nog verder te versterken.\r\n\r\nServeer de pasta aglio e olio direct en geniet van de eenvoudige maar verrukkelijke smaken. Dit gerecht is perfect als een snelle doordeweekse maaltijd of als een bijgerecht bij andere Italiaanse gerechten.\r\n\r\nMet zijn knapperige knoflooksmaak, de smaakvolle olijfolie en de subtiele kruiden, zal deze klassieke Italiaanse pasta zeker een favoriet worden op je eettafel. Buon appetito!', 'gerecht-pasta-aglio-olio-e-peperoncino'),
(2, 3, 4, 3, '2023-06-02', 'Pasta Bolognese', 'Pasta met bolognese saus', 'Makkelijk recept voor de lekkerste pasta bolognese met een smaakvolle saus op basis van ham!', 'gerecht-spaghetti-bolognese'),
(3, 3, 2, 2, '2023-06-03', 'Pasta al Pesto', 'Dit lekkere en makkelijke recept met pasta in een lekkere pestosaus moet je een keer geprobeerd hebben!', 'Wilt u een fris en geurig gerecht perfect voor uw menu? Dan is pasta al pesto een klassiek recept, degene die je zocht! Pesto, de hoeksteen van de Ligurische keuken, is een zeer veelzijdige saus en altijd erg populair aan tafel, die kan worden gebruikt om uitstekende voorgerechten te maken, zoals lasagne, en om pastagerechten te verfraaien met zijn rijke en onmiskenbare smaak. Pesto maakt alle goedheid en frisheid vrij die in de basilicumblaadjes zit, waardoor een romige specerij ontstaat die de goede smaken en kleuren van de mediterrane keuken versterkt!', 'gerecht-pasta-pesto'),
(4, 3, 5, 2, '2023-06-04', 'Pasta Carbonara', 'Klassiek recept voor romige Italiaanse spaghetti carbonara met spekjes, eieren en Parmezaanse kaas', 'Waar is spaghetti carbonara ontstaan? De Vicolo della Scrofa, voor wie Rome kent, is een van de meest karakteristieke straten vol symbolen. Het lijkt erop dat de eerste carbonara werd gemaakt in een zaakje in deze straat, vandaar de naam van de steeg, in 1944. Duik met ons mee in dit heerlijk gerecht!', 'gerecht-pasta-carbonara');

-- --------------------------------------------------------

--
-- Table structure for table `gerecht_info`
--

CREATE TABLE `gerecht_info` (
  `id` int(11) NOT NULL,
  `record_type` varchar(1) NOT NULL,
  `gerecht_id` int(50) NOT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT 'fk to gerechtinfo is optional',
  `datum` date DEFAULT NULL,
  `nummeriekveld` int(11) DEFAULT NULL,
  `tekstveld` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gerecht_info`
--

INSERT INTO `gerecht_info` (`id`, `record_type`, `gerecht_id`, `user_id`, `datum`, `nummeriekveld`, `tekstveld`) VALUES
(1, 'B', 1, NULL, NULL, 1, 'Doe het water in een grote pot. Voeg het zout toe in het water en zet deze op hoog vuur tot het kookt.'),
(2, 'B', 1, NULL, NULL, 2, 'Bereid de saus voor.'),
(3, 'B', 1, NULL, NULL, 3, 'Haal de pasta uit de verpakking en zet het in het kokend water voor het aantal minuten dat op de verpakking staat.'),
(4, 'B', 1, NULL, NULL, 4, 'Eens gaar giet je het water in een vergiet tot het er helemaal uit is. Dan zet je de pasta terug in de pot en voeg je de saus eraan toe en meng je het tot het goed verdeeld is. Smakelijk!'),
(5, 'O', 1, 2, '2023-06-20', NULL, 'Heerlijk! Maar dit eet je best niet als je ergens naartoe moet.'),
(6, 'W', 1, NULL, NULL, 4, NULL),
(10, 'F', 1, 2, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ingredient`
--

CREATE TABLE `ingredient` (
  `id` int(11) NOT NULL,
  `gerecht_id` int(11) NOT NULL,
  `artikel_id` int(11) NOT NULL,
  `aantal` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ingredient`
--

INSERT INTO `ingredient` (`id`, `gerecht_id`, `artikel_id`, `aantal`) VALUES
(1, 1, 1, 500),
(2, 1, 2, 50),
(3, 1, 3, 100),
(4, 1, 4, 15),
(5, 1, 6, 25),
(7, 2, 1, 500),
(8, 2, 5, 500),
(9, 2, 6, 25),
(10, 3, 1, 500),
(11, 3, 7, 200),
(12, 3, 6, 25),
(13, 3, 9, 50),
(14, 4, 1, 500),
(15, 4, 10, 100),
(16, 4, 12, 200),
(17, 4, 8, 50),
(18, 4, 6, 25),
(19, 4, 3, 25);

-- --------------------------------------------------------

--
-- Table structure for table `keuken_type`
--

CREATE TABLE `keuken_type` (
  `id` int(11) NOT NULL,
  `record_type[K,T]` varchar(1) NOT NULL,
  `omschrijving` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keuken_type`
--

INSERT INTO `keuken_type` (`id`, `record_type[K,T]`, `omschrijving`) VALUES
(1, 'K', 'Amerikaans'),
(2, 'T', 'Vegan'),
(3, 'K', 'Italiaans'),
(4, 'T', 'Vegetarisch'),
(5, 'T', 'Normaal');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL COMMENT 'password = password',
  `email` varchar(50) NOT NULL,
  `afbeelding` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_name`, `password`, `email`, `afbeelding`) VALUES
(1, 'admin', '5f4dcc3b5aa765d61d8327deb882cf99', 'admin@verrukkelluk.com', 'admin'),
(2, 'Veronica Camera', '5f4dcc3b5aa765d61d8327deb882cf99', 'vcamera@verrukkulluk.com', 'user1'),
(3, 'Dirk Stappen', '5f4dcc3b5aa765d61d8327deb882cf99', 'dstappen@verrukkulluk.com', 'user2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `boodschappen`
--
ALTER TABLE `boodschappen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_boodschappen_user_id` (`user_id`),
  ADD KEY `fk_boodschappen_artikel_id` (`artikel_id`);

--
-- Indexes for table `gerecht`
--
ALTER TABLE `gerecht`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_keuken_id` (`keuken_id`),
  ADD KEY `fk_type_id` (`type_id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `gerecht_info`
--
ALTER TABLE `gerecht_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_gerecht_info.gerecht_id` (`gerecht_id`);

--
-- Indexes for table `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_gerecht_id` (`gerecht_id`),
  ADD KEY `fk_artikel_id` (`artikel_id`);

--
-- Indexes for table `keuken_type`
--
ALTER TABLE `keuken_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `boodschappen`
--
ALTER TABLE `boodschappen`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `gerecht`
--
ALTER TABLE `gerecht`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `gerecht_info`
--
ALTER TABLE `gerecht_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `keuken_type`
--
ALTER TABLE `keuken_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `boodschappen`
--
ALTER TABLE `boodschappen`
  ADD CONSTRAINT `fk_boodschappen_artikel_id` FOREIGN KEY (`artikel_id`) REFERENCES `artikel` (`id`),
  ADD CONSTRAINT `fk_boodschappen_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `gerecht`
--
ALTER TABLE `gerecht`
  ADD CONSTRAINT `fk_keuken_id` FOREIGN KEY (`keuken_id`) REFERENCES `keuken_type` (`id`),
  ADD CONSTRAINT `fk_type_id` FOREIGN KEY (`type_id`) REFERENCES `keuken_type` (`id`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `gerecht_info`
--
ALTER TABLE `gerecht_info`
  ADD CONSTRAINT `fk_gerecht_info.gerecht_id` FOREIGN KEY (`gerecht_id`) REFERENCES `gerecht` (`id`);

--
-- Constraints for table `ingredient`
--
ALTER TABLE `ingredient`
  ADD CONSTRAINT `fk_artikel_id` FOREIGN KEY (`artikel_id`) REFERENCES `artikel` (`id`),
  ADD CONSTRAINT `fk_gerecht_id` FOREIGN KEY (`gerecht_id`) REFERENCES `gerecht` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
