-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.37 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for skelbimu_tinklapis
CREATE DATABASE IF NOT EXISTS `skelbimu_tinklapis` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `skelbimu_tinklapis`;

-- Dumping structure for table skelbimu_tinklapis.kategorijos
CREATE TABLE IF NOT EXISTS `kategorijos` (
  `ID` int unsigned NOT NULL AUTO_INCREMENT,
  `Pavadinimas` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Icon` char(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table skelbimu_tinklapis.kategorijos: ~14 rows (approximately)
INSERT INTO `kategorijos` (`ID`, `Pavadinimas`, `Icon`) VALUES
	(1, 'Aušintuvai', 'Ausintuvas.png'),
	(2, 'Garso plokštės', 'garso_plokste.png'),
	(3, 'Kietieji diskai', 'hdd.png'),
	(4, 'Korpusai', 'korpusas.png'),
	(5, 'Kortelių, diskelių skaitytuvai', 'skaitytuvas.png'),
	(6, 'Maitinimo blokai', 'maitinimas.png'),
	(7, 'Motininės plokštės', 'motinine.png'),
	(8, 'Operatyvioji atmintis(RAM)', 'ram.png'),
	(9, 'Procesoriai(CPU)', 'cpu.png'),
	(10, 'SCSI ir USB kontroleriai', 'kontroleriai.png'),
	(11, 'Tinklo plokštės', 'tinko_plokste.png'),
	(12, 'Vaizdo plokštės', 'gpu.png'),
	(16, 'Stacionarūs kompiuteriai', 'computer.png'),
	(17, 'Nešiojami kompiuteriai', 'laptop.png');

-- Dumping structure for table skelbimu_tinklapis.skelbimai
CREATE TABLE IF NOT EXISTS `skelbimai` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `VartotojoID` int unsigned NOT NULL,
  `Pavadinimas` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `Kategorija` int unsigned NOT NULL,
  `Aprasymas` text COLLATE utf8mb4_general_ci NOT NULL,
  `Tel_Nr` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `El_pastas` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Miestas` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Kaina` int unsigned NOT NULL DEFAULT '0',
  `Nuotraukos` text COLLATE utf8mb4_general_ci,
  `Ikelimo_data` datetime NOT NULL,
  `Paspaudimai` int NOT NULL DEFAULT (0),
  UNIQUE KEY `ID` (`ID`),
  KEY `FK_skelbimai_vartotojai` (`VartotojoID`),
  KEY `FK_skelbimai_kategorijos` (`Kategorija`),
  CONSTRAINT `FK_skelbimai_kategorijos` FOREIGN KEY (`Kategorija`) REFERENCES `kategorijos` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_skelbimai_vartotojai` FOREIGN KEY (`VartotojoID`) REFERENCES `vartotojai` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=206 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table skelbimu_tinklapis.skelbimai: ~23 rows (approximately)
INSERT INTO `skelbimai` (`ID`, `VartotojoID`, `Pavadinimas`, `Kategorija`, `Aprasymas`, `Tel_Nr`, `El_pastas`, `Miestas`, `Kaina`, `Nuotraukos`, `Ikelimo_data`, `Paspaudimai`) VALUES
	(183, 5, 'Parduodamas kompiuterio aušintuvas – Puikios būklės!', 1, 'a:1:{i:0;s:325:"Parduodamas aukštos kokybės kompiuterio aušintuvas, užtikrinantis puikų aušinimą ir tylų veikimą. Tinka įvairiems kompiuterio modeliams ir yra ideali pasirinkimo galimybė tiems, kurie nori sumažinti kompiuterio temperatūrą ir užtikrinti ilgesnį jo tarnavimo laiką. Lengvas montavimas ir aukštas efektyvumas.";}', '+37064579157', 'Jonas@gmail.com', 'Elektrėnai', 30, '67915c74aea83-370215b2d82611ef88590eefd6361f3f_1920x1080_1x-0.jpg||67915c74aec16-35cf7e0ad82611efb8bdbe017ca184e5_1920x1080_1x-0.jpg||67915c74aede0-3459c080d82611efaab40eefd6361f3f_1920x1080_1x-0.jpg', '2025-01-22 22:00:36', 15),
	(184, 5, 'CoolMax Pro 120', 1, 'a:1:{i:0;s:360:"Parduodamas CoolMax Pro 120 kompiuterio aušintuvas. Puikiai tinka tiek žaidimų, tiek darbui su kompiuteriais, užtikrinantis efektyvų aušinimą ir tylų veikimą. Naudotas, tačiau puikios būklės, neseniai valytas ir paruoštas naudojimui. Idealiai tinka tiek procesoriams, tiek grafikos plokštėms. Parduodamas su visais priedais ir originaliu paketu.";}', '+370 600 12345', 'Jonas@gmail.com', 'Skuodas', 35, '679160fe887a8-73319f1ed7bb11ef9c0f323c63edb003_1920x1080_1x-0.jpg||679160fe88987-702deee4d7bb11ef875116436b900922_1920x1080_1x-0.jpg', '2025-01-22 22:19:58', 2),
	(185, 5, 'Parduodama garso plokštė – SoundMax Ultra 7.1', 2, 'a:9:{i:0;s:354:"Parduodama SoundMax Ultra 7.1 garso plokštė, puikiai tinkanti tiek žaidėjams, tiek profesionalams, ieškantiems aukštos kokybės garso. Ši plokštė palaiko 7.1 kanalų garsą, užtikrina aiškų ir galingą garsą bei turi pažangias garso apdorojimo funkcijas. Naudota, tačiau puikios būklės, be jokių defektų. Parduodama su visais priedais.";i:1;s:0:"";i:2;s:15:"Specifikacijos:";i:3;s:0:"";i:4;s:30:"Palaikomas garsas: 7.1 kanalų";i:5;s:29:"Suderinamumas: Windows, Linux";i:6;s:36:"Išvestys: 3,5mm Jack, optinė, HDMI";i:7;s:29:"Prijungimo tipas: PCI Express";i:8;s:83:"Kitos savybės: Aukštos kokybės garso apdorojimas, žemos latencijos technologija";}', '+370 600 67890', 'Jonas@gmail.com', 'Jonava', 50, '679162ebc8cca-85116950d90311efb373322cc4d37263_1920x1080_1x-0.jpg', '2025-01-22 22:28:11', 1),
	(186, 5, 'Parduodamas kietasis diskas – UltraDrive 1TB', 3, 'a:9:{i:0;s:314:"Parduodamas UltraDrive 1TB kietasis diskas. Tai patikimas ir talpus HDD diskas, skirtas kompiuteriams, kurie reikalauja didelės saugojimo talpos. Diskas yra naudotas, tačiau veikia puikiai, be jokių klaidų ar problemų. Idealiai tinka tiek asmeniniams, tiek darbo kompiuteriams. Parduodamas su visais priedais.";i:1;s:0:"";i:2;s:15:"Specifikacijos:";i:3;s:0:"";i:4;s:10:"Talpa: 1TB";i:5;s:28:"Tipas: HDD (kietasis diskas)";i:6;s:17:"Greitis: 7200 RPM";i:7;s:17:"Jungtis: SATA III";i:8;s:64:"Kitos savybės: Tylus veikimas, patikima saugykla, didelė talpa";}', '+370 600 11223', 'Jonas@gmail.com', 'Trakai', 40, '6791634f51da1-a969ac5acdd111efba4ede1b6ee0880a_1920x1080_1x-0.jpg||6791634f51f26-9e362acacdd111efbc990a1fed0e8b6d_1920x1080_1x-0.jpg', '2025-01-22 22:29:51', 0),
	(187, 5, 'Galingas ir patikimas SSD diskas – UltraDrive 512GB', 3, 'a:1:{i:0;s:259:"Parduodamas UltraDrive 512GB SSD diskas, puikiai tinka kompiuteriams, kuriems reikia greito duomenų įrašymo ir skaitymo. Naudotas, tačiau veikia kaip naujas – greitas, tylus ir patikimas. Idealiai tinka tiek žaidimams, tiek darbui su dideliais failais.";}', '+370 600 11223', 'Jonas@gmail.com', 'Telšiai', 55, '6791640b627b0-3ddde2cad5ca11efbe5bfa6b91144fe1_1920x1080_1x-0.jpg||6791640b6293b-3dde0296d5ca11ef816afa6b91144fe1_1920x1080_1x-0.jpg||6791640b62a8c-3ddd4a4ad5ca11efa2fbfa6b91144fe1_1920x1080_1x-0.jpg', '2025-01-22 22:32:59', 0),
	(188, 5, 'Viskas viename kompiuteris – HP All-in-One 24', 16, 'a:1:{i:0;s:224:"Parduodamas HP All-in-One 24 kompiuteris. Kompaktiškas, elegantiškas ir galingas. Su dideliu ekranu ir visais reikalingais priedais. Puikiai tinka namų darbams ir kasdieniam naudojimui. Naudotas, tačiau puikios būklės.";}', '+370 600 23456', 'Jonas@gmail.com', 'Gargždai', 400, '6791647d0b3dc-61b9qO6nCgL._AC_UF894_1000_QL80_.jpg||6791647d0b574-3ddde2cad5ca11efbe5bfa6b91144fe1_1920x1080_1x-0.jpg', '2025-01-22 22:34:53', 1),
	(189, 6, 'Žaidimų vaizdo plokštė – MSI GeForce GTX 1660 Ti', 12, 'a:1:{i:0;s:221:"Parduodama MSI GeForce GTX 1660 Ti vaizdo plokštė. Puikiai tinka žaidimams ir grafikos apdorojimui. Naudota, tačiau veikia be jokių problemų. Tai puikus pasirinkimas žaidėjams, norintiems aukštos kokybės vaizdo.";}', '+370 600 45678', 'Petras@gmail.com', 'Vilkaviškis', 250, '67916545c7799-57d50848ceb311efbfa752672c17a0ee_1920x1080_1x-0.jpg||67916545c7936-547252e6ceb311ef86072293ca937c1e_1920x1080_1x-0.jpg||67916545c7a49-f58c620eceb611ef85d452672c17a0ee_1920x1080_1x-0.jpg', '2025-01-22 22:38:13', 0),
	(190, 6, 'Patikima motininė plokštė – ASRock B450M Pro4', 7, 'a:1:{i:0;s:233:"Parduodama ASRock B450M Pro4 motininė plokštė. Tinka tiek žaidimams, tiek kasdieniam naudojimui. Puikiai palaiko AMD Ryzen procesorius, turi daug jungčių ir gerą aušinimo sistemą. Naudota, tačiau veikia be jokių problemų.";}', '+370 600 56789', 'Petras@gmail.com', 'Ukmergė', 65, '67916688ac10c-e1f85688acf811efaa3abe4f37723c62_1920x1080_1x-0.jpg||67916688ac28a-e1f80c28acf811ef97b7be4f37723c62_1920x1080_1x-0.jpg', '2025-01-22 22:43:36', 1),
	(191, 6, 'Paprastas ir greitas procesorius – AMD Ryzen 5 3600', 9, 'a:1:{i:0;s:203:"Parduodamas AMD Ryzen 5 3600 procesorius. Puikiai tinka tiek žaidimams, tiek darbui su sudėtingesnėmis užduotimis. Galingas ir greitas, veikia be jokių problemų. Naudotas, tačiau puikios būklės.";}', '+370 600 67890', 'Petras@gmail.com', 'Varėna', 220, '679166c150296-_.jpg', '2025-01-22 22:44:33', 0),
	(192, 6, 'Korpusas – Fractal Design Meshify C', 4, 'a:1:{i:0;s:216:"Parduodamas Fractal Design Meshify C kompiuterio korpusas. Tai puikus pasirinkimas žaidėjams ir kompiuterių entuziastams, norintiems geros ventiliacijos ir modernios išvaizdos. Naudotas, tačiau puikios būklės.";}', '+370 600 78901', 'Petras@gmail.com', 'Zarasai', 85, '679167304cab3-00a84e34c93d11ef8d3fdacfad8ad281_1920x1080_1x-0.jpg||679167304cce9-00a81932c93d11efae1ddacfad8ad281_1920x1080_1x-0.jpg', '2025-01-22 22:46:24', 0),
	(193, 6, 'G.SKILL Ripjaws V 16GB', 8, 'a:1:{i:0;s:173:"Parduodama G.SKILL Ripjaws V 16GB RAM atmintis. Tinkama tiek žaidimams, tiek profesionaliam darbui. Greitas, stabilus ir tylus veikimas. Naudotas, tačiau puikios būklės.";}', '+370 600 89012', 'Paulius@test.ltu', 'Anykščiai', 60, '6791677dc7d9b-images.jpg', '2025-01-22 22:47:41', 0),
	(194, 6, 'Nešiojamas kompiuteris – Dell XPS 13', 17, 'a:1:{i:0;s:216:"Parduodamas Dell XPS 13 nešiojamas kompiuteris. Kompaktiškas ir lengvas, su galingu procesoriumi ir puikiu ekranu. Idealiai tinka tiek darbui, tiek pramogoms. Naudotas, tačiau puikios būklės, su visais priedais.";}', '+370 600 11223', 'Petras@gmail.com', 'Kaunas', 750, '679167bc85b9c-DMyEYdqZ78LHzhYpLMV-UzGLPS9etqsEbgtYxtlOpFI_1920x1080_1x-0.jpg||679167bc85d38-LbqNDjAs1wi2Hridc4sghtQQRNtryG_gm71CK0R1ng8_1920x1080_1x-0.jpg', '2025-01-22 22:48:44', 1),
	(195, 6, 'Greitas ir talpus SSD – Samsung 970 EVO Plus 1TB', 3, 'a:1:{i:0;s:215:"Parduodamas Samsung 970 EVO Plus 1TB SSD diskas. Greitas ir patikimas, puikiai tinka tiek žaidimams, tiek profesionaliam darbui. Naudotas, tačiau veikia kaip naujas – didelis greitis ir talpa už puikią kainą.";}', '+370 600 23456', 'Petras@gmail.com', 'Neringa', 120, '679167f6b3c94-images__1_.jpg||679167f6b3e16-samsung-970-evo-plus-1tb-mz-v7s1t0bw.jpg', '2025-01-22 22:49:42', 0),
	(196, 6, 'Galinga vaizdo plokštė – ASUS ROG Strix RTX 3080', 12, 'a:3:{i:0;s:186:"Parduodama ASUS ROG Strix RTX 3080 vaizdo plokštė. Ideali žaidimams ir profesionaliam darbui su grafika. Aukštos kokybės vaizdas, puikus našumas. Naudota, tačiau puikios būklės.";i:1;s:0:"";i:2;s:0:"";}', '+370 600 34567', 'Petras@gmail.com', 'Vilnius', 850, '679168522e337-c4941bc0d51d11efa1b84e667085ade3_1920x1080_1x-0.png||6791686524489-d4a6bba8d51d11efb9784e667085ade3_1920x1080_1x-0.jpg', '2025-01-22 22:51:14', 2),
	(197, 2, 'ASUS Xonar AE Garso Plokštė', 2, 'a:1:{i:0;s:205:"Parduodama ASUS Xonar AE garso plokštė. Puikiai tinka tiek žaidimams, tiek muzikos kūrimui. Aukštos kokybės garso apdorojimas, palaiko 7.1 kanalų garsą. Naudota, tačiau veikia be jokių problemų.";}', '+370 600 45678', 'Paulius@test.lt', 'Biržai', 55, '679168ba1979c-asus-xonar-ae-vidinis-71-kanalai-pci-e_JLAO30n.jpg||679168ba1990d-669fad17-2c09-48f0-9e71-ea8500b7b3ff.jpg', '2025-01-22 22:52:58', 2),
	(198, 2, ' Seasonic Focus GX-650W', 6, 'a:1:{i:0;s:178:"Parduodamas Seasonic Focus GX-650W maitinimo blokas. Puikiai tinka žaidimų kompiuteriams ir galingiems sistemoms. Patikimas, tylus ir efektyvus. Naudotas, bet puikios būklės.";}', '+370 600 56789', 'Paulius@test.ltu', 'Kaišiadorys', 95, '6791690077199-51wOpEuo7rL.jpg||679169007736a-seasonic-focus-gx-650-650-w-100-240_HbqiXC3.jpeg', '2025-01-22 22:54:08', 0),
	(199, 2, ' Cooler Master MasterBox korpusas', 4, 'a:1:{i:0;s:183:"Parduodamas Cooler Master MasterBox Q300L kompiuterio korpusas. Kompaktiškas, lengvas, su geru oro srautu ir moderniu dizainu. Naudotas, tačiau puikios būklės, be jokių defektų.";}', '+370 600 67890', 'Paulius@test.ltu', 'Jurbarkas', 60, '6791696e3bb89-ce995c22cdc811ef91b5beca599c4813_1920x1080_1x-0.jpg||6791696e3bd48-cc87c4e6cdc811efbef892c7e6305f85_1920x1080_1x-0.jpg', '2025-01-22 22:55:58', 0),
	(200, 2, 'Corsair Vengeance LPX 32GB RAM', 8, 'a:1:{i:0;s:185:"Parduodama Corsair Vengeance LPX 32GB RAM atmintis. Puikiai tinka žaidimams ir profesionaliam darbui su dideliais duomenų kiekiais. Naudota, tačiau veikia puikiai, be jokių klaidų.";}', '+370 600 78901', 'Paulius@test.ltu', 'Jonava', 85, '679169f51178e-images__3_.jpg||679169f511944-images__2_.jpg', '2025-01-22 22:58:13', 0),
	(201, 2, 'Intel Core i9-11900K procesorius', 9, 'a:1:{i:0;s:201:"Parduodamas Intel Core i9-11900K procesorius. Puikiai tinka tiek žaidimams, tiek profesionaliam darbui su sudėtingais uždaviniais. Galingas, greitas ir efektyvus. Naudotas, tačiau puikios būklės.";}', '+370 600 89012', 'Paulius@test.ltu', 'Skuodas', 550, '67916a297b036-74db74e0d00c11ef8859daa65a0555d8_1920x1080_1x-0.jpg||67916a297b1c1-6cfde06ed00c11ef984cfe985c5a888b_1920x1080_1x-0.jpg', '2025-01-22 22:59:05', 0),
	(202, 2, 'SSD diskas – Crucial P5 Plus 500GB', 3, 'a:1:{i:0;s:183:"Parduodamas Crucial P5 Plus 500GB SSD diskas. Greitas ir patikimas, puikiai tinka tiek žaidimams, tiek darbui. Naudotas, tačiau veikia puikiai, su ilgalaikiu garantiniu laikotarpiu.";}', '+370 600 11223', 'Paulius@test.lt', 'Širvintos', 65, '67916a736e125-images__4_.jpg||67916a736e28a-BrAieCbeJf8yieE56yVuK7.jpg', '2025-01-22 23:00:19', 1),
	(203, 2, 'TP-Link Archer T4U', 11, 'a:2:{i:0;s:173:"Parduodama TP-Link Archer T4U tinklo plokštė. Puikiai tinka tiek namų, tiek biuro tinklams. Greitas ir stabilus Wi-Fi ryšys. Naudota, tačiau veikia be jokių problemų.";i:1;s:0:"";}', '+370 600 34567', 'Paulius@test.ltu', 'Kaišiadorys', 30, '67916b0470392-7926643c922d11efa72016be565de10a_1920x1080_1x-0.jpg||67916b04705d1-79262968922d11ef92dc16be565de10a_1920x1080_1x-0.jpg', '2025-01-22 23:02:44', 1),
	(204, 2, 'Parduodamas kortelių skaitytuvas', 5, 'a:1:{i:0;s:169:"Parduodamas kortelių skaitytuvas, puikiai tinkantis tiek asmeniniams, tiek profesiniams poreikiams. Palaiko SD, microSD ir kitas korteles. Naudotas, bet veikia puikiai.";}', '+370 600 12345', 'Paulius@test.ltu', 'Joniškis', 15, '67916ccc6ae56-s-l400.jpg||67916ccc6affd-s-l1200.jpg', '2025-01-22 23:10:20', 0),
	(205, 2, 'Parduodamas SCSI kontroleris', 10, 'a:1:{i:0;s:126:"Parduodamas SCSI kontroleris kompiuteriui. Puikiai tinka senesniems kompiuteriams ir serveriams. Naudotas, bet puikiai veikia.";}', '+370 600 23456', 'Paulius@test.ltu', 'Klaipėda', 40, '67916d3967755-20221129_200256.jpg||67916d39678d4-20221129_200222.jpg', '2025-01-22 23:12:09', 0);

-- Dumping structure for table skelbimu_tinklapis.vartotojai
CREATE TABLE IF NOT EXISTS `vartotojai` (
  `ID` int unsigned NOT NULL AUTO_INCREMENT,
  `VartotojoVardas` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `ElPastas` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Slaptazodis` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `SukurimoData` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ElPastas` (`ElPastas`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table skelbimu_tinklapis.vartotojai: ~3 rows (approximately)
INSERT INTO `vartotojai` (`ID`, `VartotojoVardas`, `ElPastas`, `Slaptazodis`, `SukurimoData`) VALUES
	(2, 'Paulius', 'paulius@gmail.com', '$2y$10$HAtw6HhDwXRoAylKKoeNl.efXYTfvlbgRhufpw4tBkrPMqhK2gdI6', '2024-12-09 18:41:55'),
	(3, 'Paulius2', 'paulius2@a.lt', '$2y$10$PRfjPT2MTI20ja8atlewieyo6oiNYCt1sMjlqxEu28P.//sOS0W42', '2024-12-15 16:43:55'),
	(4, 'Lauryna Kirdeikyte', 'laurynakirdeikyte@gmail.com', '$2y$10$yGRM8mBMGjGFLrJvWHvdM.8Rr9siq0lRD26BfXGDkLEgrpmSARx1W', '2025-01-19 15:38:13'),
	(5, 'Jonas', 'Jonas@gmail.com', '$2y$10$Ms47.GaWNWuTqroxSPfjxuPUCSeTiBaOrn7LGEk0IIMLpGVbV5N6O', '2025-01-22 20:35:51'),
	(6, 'Petras', 'Petras@gmail.com', '$2y$10$Syw4dXGg1J0JVGxeGOJToOm4Te07Cr2I77fDxBDugummhfnv2Hg1G', '2025-01-22 21:36:31');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
