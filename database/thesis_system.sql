-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2025 at 05:55 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thesis_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `professors`
--

CREATE TABLE `professors` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `topic` text DEFAULT NULL,
  `landline` varchar(20) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `university` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `professors`
--

INSERT INTO `professors` (`user_id`, `name`, `surname`, `topic`, `landline`, `mobile`, `department`, `university`) VALUES
(1, 'Giannis', 'Papadopoulos', NULL, NULL, NULL, 'TMHYP', NULL),
(100, 'Alex', 'Demoprof', 'Network-centric systems', '2610000001', '6900000001', 'CEID', 'University of Patras'),
(101, 'Vera', 'Testperson', 'Integrated Systems', '2610000002', '6900000002', 'CEID', 'University of Patras'),
(102, 'Dimitra', 'Samplename', 'Artificial Intelligence', '2610000003', '6900000003', 'CEID', 'University of Patras'),
(103, 'Elias', 'Mockson', 'WEB', '2610000004', '6900000004', 'CEID', 'University of Patras'),
(104, 'Andrew', 'Hozier Byrne', 'Artificial Intelligence', '2610170390', '6917031990', 'CEID', 'University of Patras'),
(105, 'Nikos', 'Korobos', 'Data Engineering', '2610324365', '6978530352', 'IT', 'University of Patras'),
(106, 'Kostas', 'Karanikolos', 'informatics', '2610324242', '6934539920', 'CEID', 'University of Patras'),
(107, 'Mpampis', 'Sougias', 'Arxeologia', '2610945934', '6947845334', 'Arxeologias', 'UOI'),
(108, 'Daskalos', 'Makaveli', 'Business', '2310231023', '6929349285', 'Economics', 'UOA'),
(109, 'Maria', 'Palami', 'SQL injections', '1234567890', '6988223322', 'Engineering', 'University of SKG'),
(110, 'Meni', 'Talaiporimeni', 't', '2610333999', '6999990999', 'CEID', 'UoP'),
(111, 'Tzouli', 'Alexandratou', 'Big Data', '2264587412', '6996116921', 'CEID', 'University of Patras'),
(112, 'Karikhs', 'Raftel', 'Pharmaceutical Drugs', '69', '6945258923', 'Chemistry', 'University of Streets'),
(113, 'Vlasis', 'Restas', 'Nekro8aftiki', '78696910', '69696964', 'Nekro8aftikis', 'University Of Ohio'),
(114, 'Fat ', 'Banker', 'kippah', '6942014121', '6969784205', 'Froutemporiki', 'University of Israel'),
(115, 'Hamze', 'Mohamed', 'Logistics', '1245789513', '1456983270', 'Social Rehabitation', 'University of UAE'),
(116, 'Nora', 'Exampleton', 'Information Theory', '2610000005', '6900000005', 'ECE', 'University of Patras'),
(117, 'Peter', 'Placeholder', 'Telecommunication Electronics', '2610000006', '6900000006', 'ECE', 'University of Patras	'),
(118, 'Papadopoulos ', 'Eustathios', 'Physics', '210-1234567', '690-1234567', 'Physics', 'National and Kapodistrian University of Athens'),
(119, 'Konstantinou', 'Maria', 'Statistics and Probability', '2310-7654321', '694-7654321', 'Mathematics', 'Aristotle University of Thessaloniki'),
(120, 'Jim', 'Nikolaou', 'Artificial Intelligence', '2610-9876543', '697-9876543', 'Computer Science', 'University of Patras'),
(121, 'Sophia', 'Michailidi', 'Economic Theory', '2310-5432109', '698-5432109', 'Economics', 'Athens University of Economics and Business'),
(122, 'Michael ', 'Papadreou', 'Renewable Energy Systems', '2610-4455667', '697-4455667', 'Electrical Engineering', 'University of Ioannina'),
(123, 'Elon', 'Musk', 'Electric Vehicles', '1-888-518-3752', 'Null', 'Department of Physics', 'University of Pennsylvania, Philadelphia'),
(124, 'Kostas', 'Kalantas', 'AI', '2610121212', '6912121212', 'department', 'University'),
(125, 'Giorgis', 'Fousekis', 'topic', 'land', 'mob', 'dep', 'university'),
(126, 'Nikos', 'Koukos', 'top', 'la', 'mo', 'de', 'university'),
(127, 'patrick', 'xrusopsaros', 'thalasioi ipopotamoi', '2610567917', '6952852742', 'Solomos', 'Nemo'),
(128, 'Paraskevas', 'koutsikos', 'Provata', '2298042035', '6969696969', 'Ktinotrofia', 'University of Methana'),
(129, 'Ezio', 'Auditore da Firenze', 'assassinations', 'null', 'null', 'Monterigioni', 'University of Assasinos'),
(130, 'Sotiris', 'Panaikas', 'Bet Predictions', '1235654899', '2310521010', 'opap', 'London'),
(131, 'Anitta', 'Wynn', 'Probability', '2610486396', '698888884', 'Computer Engineering', 'University of Beegwean'),
(132, 'Jose Luis', 'Mendilibar', 'Sentres', '2105555555', '6922222222', 'Conference League', 'Uni of Olympiacos'),
(133, 'Liam', 'Payne', 'Cryptography', '2462311345', '6980847234', 'CEID', 'University of Patras'),
(134, 'Zayn', 'Malik', 'Oriented programing', '2310221234', '6971006355', 'CEID', 'University of Patras'),
(135, 'Nikos ', 'Papas', 'manas', 'spiti', '69854512', 'Hastle', 'Hastle University'),
(136, 'Oikoumenikos', 'Prasinos', 'Nikolakos', '987546123', '69 6 9 69', 'Ougantiani Filosofia', 'Nation University Of Pakistan'),
(137, 'Severus', 'Snape', 'math 2', '26210 26441', '6926626226', 'ceid', 'University of Patras'),
(138, 'Tung Tung', 'Sahur', 'Graphs', '210 1425735', '69434619363', 'CEID', 'University of Patras'),
(139, 'Maria', 'Papadopoulou', 'Computer science', '2610123456', '6912345678', 'CEID', 'University of Patras'),
(140, 'Nikos', 'Georgiou', 'Physics', '2610111111', '6911111111', 'CEID', 'University of Patras'),
(141, 'MARI', 'BRO', 'Life', '666', '666', 'no', 'University of Brain'),
(142, '<a href=\"https://www.youtube.com\">G</a>', 'Goat', 'no', '666', '666', 'No', 'University of Goats'),
(143, 'Brain', 'Rot', 'no', '9', '6', 'Brainrot', '<a href=\"https://www.youtube.com/watch?v=nxSbhVnwdFw&t=1121s\">Crocodilo</a>'),
(144, 'Giannis ', 'Sinsidis', 'Ypsiloikardiakoipalmoi', '2610645698', '697878787', 'Palindromikis kiniseos', 'University of Makias'),
(145, 'Giorgos', 'Fragkofonias', 'oikonomia tou tsipi', '2610546132', '697878787', 'Real Economics ', 'University Of Empty Pocket'),
(146, 'Ioannis', 'Tsilis', 'Iliopoulos to fainomeno', '2610212121', '6921212121', 'Tsili Kafeneio', 'University of the Road'),
(147, 'Prasinos ', 'Frouros', 'alafouzo poula', '261056458', '698778788', 'Panathinaiki agwgh', 'University of tears'),
(148, 'Giorgio ', 'Bonassera', 'spagetti aldente', '23131131', '6575754', 'cuccina italiana', 'Carbonara University'),
(149, 'Giorgos', 'Bartzokas', 'Basketball Strategy', '2108743265', '6932178542', 'SEF', 'University of Gate 7'),
(608, 'Aristeidis', 'Panopoulos', 'Data', '2645023475', '6987863645', 'CEID', 'University of Patras'),
(609, 'Panagiotis', 'Aristopoulos', 'PLA', '2657481902', '6974568973', 'CEID', 'University of Patras'),
(610, 'Billie ', 'Eilish', 'Sound Engineering', '2100000011', '6930000011', 'CEID', 'PATRON'),
(611, 'Hlias', 'Psinakis', 'Management', '2100000444', '6930000088', 'CEID', 'PATRON'),
(769, 'Όνομα', 'Επώνυμο', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `secretaries`
--

CREATE TABLE `secretaries` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `secretaries`
--

INSERT INTO `secretaries` (`user_id`, `name`, `surname`) VALUES
(1, 'Secretary', 'Admin'),
(150, 'Ελένη', 'Παπαδοπούλου'),
(152, 'Μαρία', 'Δημητρίου'),
(159, 'Νίκη', 'Γραμματικού');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `student_number` varchar(255) NOT NULL,
  `street` varchar(255) DEFAULT NULL,
  `number` varchar(10) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `landline_telephone` varchar(20) DEFAULT NULL,
  `mobile_telephone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`user_id`, `name`, `surname`, `student_number`, `street`, `number`, `city`, `postcode`, `father_name`, `landline_telephone`, `mobile_telephone`) VALUES
(3, 'John', 'Lennon', '10434000', 'Ermou', '18', 'Athens', '10431', 'George', '2610123456', '6970001112'),
(4, 'Petros', 'Verikokos', '10434001', 'Adrianou', '20', 'Thessaloniki', '54248', 'Giannis', '2610778899', '6970001112'),
(5, 'test', 'name', '10434002', 'str', '1', 'patra', '26222', 'father', '2610123456', '6912345678'),
(6, 'Robert', 'Smith', '10434003', 'Fascination', '17', 'London', '1989', 'Alex', '2610251989', '6902051989'),
(7, 'Rex', 'Tyrannosaurus', '10434004', 'Cretaceous', '2', 'Laramidia', '54321', 'Daspletosaurus', '25613285265', '6911231234'),
(8, 'Paul', 'Mescal ', '10434005', 'Smith Str.', '33', 'New York ', '59', 'Paul', '-', '-'),
(9, 'Pedro', 'Pascal', '10434006', 'Johnson', '90', 'New York ', '70', 'José ', '-', '-'),
(10, 'David', 'Gilmour', '10434007', 'Sortef', '29', 'New York', '26', 'Douglas', '-', '-'),
(11, 'Lana', 'Del Rey ', '10434008', 'Κορίνθου ', '321', 'Πάτρα', '26228', 'none', '2109857423', '695148899'),
(12, 'Stevie', 'Nicks', '10434009', 'Magic Str. ', '8', 'New Orleans', '35', 'Jess ', '56', '67'),
(13, 'Margaret', 'Qualley', '10434010', 'Substance Str.', '25', 'Los Angeles ', '7', 'Paul', '67', '695148899'),
(14, 'Mia', 'Goth', '10434011', 'Pearl Str. ', '4', 'Michigan', '8', 'Lee', '-', '-'),
(15, 'Florence ', 'Pugh', '10434012', 'Midsommar Str. l', '1', 'Away', '24', '-', '5', '2'),
(16, 'PJ ', 'Harvey', '10434013', 'Lonely Str.', '27', 'Bridport', '-7', 'Ray', '56', '43'),
(17, 'Penélope', 'Cruz', '10434014', 'Almadovar', '55', 'Madrid', '23', 'Eduardo ', '5', '4'),
(18, 'Emma', 'Stone', '10434015', 'Poor Str.', '3', 'Paris ', '34', 'none', '2333333', '4455555'),
(19, 'Jenny', 'Vanou', '10434016', 'Mpouat Str.', '23', 'Athens', '10', 'Basil', '09', '45'),
(20, 'Salma ', 'Hayek', '10434017', 'Desperado Str. ', '24', 'Madrid ', '656', 'Sami', '344', '221'),
(21, 'Julie ', 'Delpy', '10434018', 'Before Str.', '36', 'Paris', '567', 'Kieślowski', '1223', '3455'),
(22, 'Giannis', 'Aggelakas', '10434019', 'Trypes Str.', '3', 'Athens', '2354', 'Theos', '23', '45'),
(23, 'Eleutheria ', 'Arvanitaki', '10434020', 'Entexno Str. ', '2', 'Athens', '345', 'Kosmos', '657', '345'),
(24, 'Marina', 'Spanou', '10434021', 'Pagkrati Str.', '25', 'Athens', '2456', 'Gates', '897', '354'),
(25, 'Rena', 'Koumioti', '10434022', 'Mpouat Str.', '24', 'Athens', '5749', 'Ellhniko', '23557', '32453'),
(26, 'Charlotte', 'Aitchison', '10434023', 'Boiler Room St', '365', 'New York', '360', 'Jon', '2610365365', '693653365'),
(27, 'Rhaenyra', 'Targaryen', '10434024', 'Dragon St', '2021', 'Kings Landing', '2021', 'Viserys', '2610101010', '6910101010'),
(28, 'Ben', 'Dover', '10434025', 'Colon Str.', '124A', 'NY', '11045', 'Carlos', '2584694587', '5841852384'),
(29, 'Marios', 'Papadakis', '10434026', 'Korinthou', '266', 'Patras', '26223', 'Ioannis', '+302105562567', '+306975562567'),
(30, 'Nicholas ', 'Hoult', '10434027', 'Nosferatu Str.', '34', 'London', '567', 'Roger', '436', '46478'),
(31, 'Joo Hyuk', 'Nam', '10434028', 'Kanakari', '135', 'Patra', '26440', 'Baek Yi Jin', '2610443568', '6978756432'),
(32, 'Nikos', 'Peletie', '10434029', 'Kolokotroni', '6', 'Athens', '34754', 'George', '2104593844', '6987655433'),
(33, 'Nikos', 'Koukos', '10434030', 'Triton', '12', 'Salamina', '12216', 'Giannis', '210553985', '6946901012'),
(34, 'Maria', 'Fouseki', '10434031', 'Jason ', '33', 'London', '44391', 'Tasos', '2109993719', '6923144642'),
(35, 'Nikos ', 'Korobos', '10434032', 'Masalias', '4', 'Sparti', '32095', 'Giannis', '2279036758', '6948308576'),
(36, 'Maria', 'Togia', '10434033', 'Athinon', '4', 'Athens', '28482', 'Petros', '2100393022', '6953782102'),
(37, 'Giorgos', 'Menegakis', '10434034', 'korinthou', '56', 'patras', '56892', 'nikos', '2610485796', '6934527125'),
(38, 'Trakis', 'Giannakopoulos', '10434035', 'Othonos kai Amalias ', '100', 'Patras', '26500', 'None', '2610381393', '6028371830'),
(39, 'Chris', 'Kouvadis', '10434036', 'vanizelou', '36', 'Patras', '26500', 'Pfloutsou', '2610995999', '6947937524'),
(40, 'pafloutsou', 'kaskarai', '10434037', 'kolokotroni', '12', 'Patras', '26500', 'mauragkas', '2610978423', '6935729345'),
(41, 'Billy', 'Diesel', '10434038', 'Alexandras Ave', '12', 'Athens', '11521', 'Iman', '2101234567', '6912345678'),
(42, 'Tome', 'of Madness', '10434039', 'Panepisthmiou', '69', 'Patras', '26441', 'Prafit', '2610654321', '6969966996'),
(43, 'fort', 'nite', '10434040', 'karaiskakis', '69', 'tilted tower', '4747', 'epic games', '2610747474', '6988112233'),
(44, 'Zeus', 'Ikosaleptos', '10434041', 'Novi', '25', 'Athens', '20033', 'Kleft', '2109090901', '6900008005'),
(45, 'AG', 'Cook', '10434042', 'Britpop', '7G', 'London', '2021', 'PC Music', '2121212121', '1212121212'),
(46, 'Maria', 'Mahmood', '10434043', 'Mouratidi', '4', 'New York', '25486', 'Paparizou', '2108452666', '6980081351'),
(47, 'Kostas', 'Poupis', '10434044', 'Ag Kiriakis', '11', 'Papaou', '50501', 'Aelakis', '222609123', '698452154'),
(48, 'Hugh', 'Jass', '10434045', 'Wall Street', '69', 'Jerusalem', '478', 'Mike Oxlong', '69696969', '696969420'),
(49, 'Xontro ', 'Pigouinaki', '10434046', 'Krasopotirou', '69', 'Colarato', '14121', 'Adolf Heisenberg', '6913124205', '4747859625'),
(50, 'Μaria', 'Nikolaou', '10434047', 'Achilleos', '21', 'Athens', '10437', 'Dimitris', '2109278907', '6945533213'),
(51, 'Eleni', 'Fotiou', '10434048', 'Adrianou ', '65', 'Athens', '10556', 'Nikos', '2108745645', '6978989000'),
(52, 'Xara', 'Fanouriou', '10434049', 'Chaonias ', '54', 'Athens', '10441', 'Petros', '2108724324', '6945622222'),
(53, 'Nikos', 'Panagiotou', '10434050', 'Chomatianou', '32', 'Athens', '10439', 'Giorgos', '2107655555', '6941133333'),
(54, 'Petros', 'Daidalos', '10434051', 'Dafnidos', '4', 'Athens', '11364', 'Pavlos', '2108534566', '6976644333'),
(55, 'Giannis', 'Ioannou', '10434052', 'Danais', '9', 'Athens', '11631', 'Kostas', '2107644999', '6976565655'),
(56, 'Tsili', 'Doghouse', '10434053', 'novi lane', '33', 'Patras', '26478', 'Stoiximan', '2610420420', '6999999999'),
(57, 'Marialena', 'Antoniou', '10434054', 'Ermou', '24', 'Athens', '10563', 'Nikolaos', '210-5678901', '693-5678901'),
(58, 'Ioannis', 'Panagiotou', '10434055', 'Kyprou', '42', 'Patra', '26441', 'Kwstas', '2610-123456', '698-1234567'),
(59, 'George', 'Karamalis', '10434056', 'Kolokotroni', '10', 'Larissa', '41222', 'Petros', '2410-456789', '697-4567890'),
(60, 'Kyriakos', 'Papapetrou', '10434057', 'Zakunthou', '36', 'Volos', '10654', 'Apostolos', '210-6789012', '695-6789012'),
(61, 'Maria', 'Kp', '10434058', 'pelopidas ', '52', 'patra', '28746', 'george', '2610555555', '6932323232'),
(62, 'Nikos', 'papadopoulos', '10434059', 'anapafseos', '34', 'patra', '26503', 'takis', '2691045092', '69090909'),
(63, 'Giannis ', 'Molotof', '10434060', 'Ermou', '34', 'Patras', '29438', 'Giorgos', '2610254390', '6943126767'),
(64, 'Sagdy', 'Znuts', '10434061', 'Grove', '12', 'San Andreas', '123456', 'NULL', '123456789', '123456789'),
(65, 'Mary', 'Poppins', '10434062', 'Niktolouloudias ', '123', 'Chalkida', '23456', 'George', '2613456089', '6980987654'),
(66, 'Tinker', 'Bell', '10434063', 'Vatomourias', '55', 'Pano Raxoula', '2345', 'Mixail', '2456034567', '6987543345'),
(67, 'Lilly', 'Bloom', '10434064', 'Patnanasis', '45', 'Patra', '26440', 'Menelaos', '2610435988', '6987555433'),
(68, 'GIORGOS', 'MASOURAS', '10434065', 'AGIOU IOANNNI RENTI', '7', 'PEIRAIAS', '47200', 'PETROS', '694837204', '210583603'),
(69, 'KENDRICK', 'NUNN', '10434066', 'OAKA', '25', 'ATHENS', '666', 'GIANNAKOPOULOS', '6982736199', '6906443321'),
(70, 'Depeche', 'Mode', '10434067', 'Enjoy The Silence', '1990', 'London', '1990', 'Dave', '1234567890', '1234567770'),
(71, 'name', 'surname', '10434068', 'your', '69', 'mom', '15584', 'father', '222', '2223'),
(72, 'Nikos', 'Kosmopoulos', '10434069', 'Araksou', '12', 'Giotopoli', '69420', 'Greg', '210 9241993', '6978722312'),
(73, 'Aris', 'Poupis', '10434070', 'Mpofa', '10', 'Kolonia', '12345', 'Mpamias', '2105858858', '6935358553'),
(74, 'gerry', 'banana', '10434071', 'lootlake', '12', 'tilted', '26500', 'johnesy', '6947830287', '2610987632'),
(75, 'grekotsi', 'parthenios', '10434072', 'kokmotou', '69', 'thessaloniki', '20972', 'mourlo', '6947910234', '2610810763'),
(76, 'Mochi', 'Mon', '10434073', 'Novi', '55', 'Maxxwin', '99999', 'Drake', '2610550406', '6967486832'),
(77, 'Nikolaos', 'Serraios', '10434074', 'Papaflessa', '12', 'Patra', '26222', 'Georgios', '2610456632', '6975849305'),
(78, 'Xaralampos', 'Mparmaksizoglou', '10434075', 'Konstantinoupoleos', '32', 'Athens', '16524', 'Eugenios', '2109995555', '6912345678'),
(79, 'kyriakos', 'pareena', '10434076', 'karaiskaki', '23', 'patras', '23444', 'lebron', '2214567809', '6972861212'),
(80, 'Tortelino', 'Diagrafino', '10434077', 'emp', '69', 'empa', '5432', 'kaae', '2101312000', '6913121312'),
(81, 'Maria', 'Db', '10434078', 'Spiti sou', '3', 'Patras', '26441', 'sql', '2610 123456', '6912345678'),
(82, 'Bombardriro', 'Crocodilo', '10434079', 'Pony Peponi', '69', 'Athens', '15344', 'Lirili Larila', '26810 12345', '6909876543'),
(83, 'Balerinna ', 'Cappucinna', '10434080', 'mimimimi', '4', 'lalalala', '23861', 'balerinno lololo', '2610729878', '6983615882'),
(84, 'Ntinos', 'Konstantinos', '10434081', 'Valaoritou', '1', 'patras', '26225', 'Nikolaos', '2610222222', '6988888888'),
(85, 'Xara', 'Georgiou', '10434082', 'Psilalonia', '12', 'Patras', '26225', 'Giorgos', '261000000', '6933333333'),
(86, 'Marios', 'Konstantinou', '10434083', 'Kanakari', '1', 'Patras', '26225', 'Foivos', '2610777777', '6944444444'),
(87, 'Mina', 'Minopoulou', '10434084', 'patra', '13', 'patras', '12345', 'makis', '261044444', '699999999'),
(88, 'Sakis', 'Rouvas', '10434085', 'Raftel', '45', 'Piece', '123', 'Gol', '66666666', '66666666'),
(89, 'Shinji', 'Ikari', '10434086', '	NERV Boulevard', '	4', '	Tokyo-3', '192', 'Gendo Ikari', '	0366666666', '	08012345678'),
(90, 'Alexis', 'tsipras', '10434087', 'Kilkis', '13', 'patra', '26441', 'Kostaw', '6978215130', '6978215130'),
(91, 'Tasos', 'kolokotronhs', '10434088', 'alitheias', '69', 'Igoumenitsa', '24463', 'Theodoros', '26578953', '6978584575'),
(92, 'Minas ', 'Minaroglou', '10434089', 'ksefotou', '36', 'Moon city', '245643', 'Manolis', '465352358', '698713245'),
(93, 'La', 'Polizia', '10434090', 'Mpatsenou', '46', 'Sideria', '164542', 'Klavdios', '4673596', '55464852'),
(94, 'manousos', 'Dlabiras', '10434091', 'giannitson', '47', 'Tripoli', '23100', 'Georgios', '23242424', '24242424'),
(95, 'Nick', 'Calathes', '10434092', 'Ermou', '28', 'Athens', '10551', 'Giorgos', '2105863247', '6945218947'),
(96, 'Donald', 'Trump', '10434093', 'White House', '911', 'Washington ', '2049', 'Fred', '2024561111', '2024561414'),
(97, 'Pelina', 'Anastasopoulou', '10434094', 'poseidon', '20', 'patras', '26332', 'andreas', '2610324567', '6949396780'),
(98, 'Andriana', 'Kapogiannopoulou', '10434095', 'poseidon', '12', 'patras', '26332', 'George', '2610321456', '6949396731'),
(99, 'Rixardos', 'Leodokardos', '10434096', 'Patissia', '69', 'Athens', '26312', 'Apostolos', '2106969420', '6969696969'),
(554, 'Makis', 'Savvas', '10434097', 'Kiprou', '1', 'Patra', '26441', 'Sakis', '2646045768', '6986756734'),
(555, 'Nikos', 'Stratomitros', '10434098', 'Eolidos', '12', 'Athens', '11853', 'Vaggelis', '2103478465', '6978846758'),
(556, 'Lucifer', 'Morningstar', '10434099', 'Hell', '666', 'Los Angeles', '66666', 'God', '2100000666', '6660000006'),
(557, 'Natasha ', 'Romanoff', '10434100', 'Avengers Tower', '1', 'New York', '10110', 'Alexei Shostakov', '2100000888', '6970000008'),
(768, 'Όνομα', 'Επώνυμο', '1234567', '', '', '', '', '0', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `theses`
--

CREATE TABLE `theses` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('under_assignment','active','under_review','completed','cancelled') DEFAULT 'under_assignment',
  `student_id` int(11) DEFAULT NULL,
  `supervisor_id` int(11) DEFAULT NULL,
  `assignment_date` date DEFAULT NULL,
  `completion_date` date DEFAULT NULL,
  `final_grade` decimal(4,2) DEFAULT NULL,
  `final_text_link` varchar(255) DEFAULT NULL,
  `draft_file_path` varchar(255) DEFAULT NULL,
  `material_links` text DEFAULT NULL,
  `presentation_date` date DEFAULT NULL,
  `presentation_time` time DEFAULT NULL,
  `presentation_location` varchar(255) DEFAULT NULL,
  `nimertis_link` varchar(255) DEFAULT NULL,
  `gs_number` varchar(255) DEFAULT NULL,
  `cancellation_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `theses`
--

INSERT INTO `theses` (`id`, `title`, `description`, `status`, `student_id`, `supervisor_id`, `assignment_date`, `completion_date`, `final_grade`, `final_text_link`, `draft_file_path`, `material_links`, `presentation_date`, `presentation_time`, `presentation_location`, `nimertis_link`, `gs_number`, `cancellation_reason`) VALUES
(1, 'Ανάπτυξη Εφαρμογής για Διαχείριση Φοιτητικών Δεδομένων', 'Δημιουργία μιας web εφαρμογής που θα επιτρέπει στους φοιτητές να διαχειρίζονται τα προσωπικά τους στοιχεία και την πορεία των σπουδών τους.', 'under_review', 18, 101, '2025-09-03', NULL, 9.00, NULL, 'uploads/test_draft.pdf', '', '2026-05-10', '03:00:00', 'uop', 'https://nimertis.library.upatras.gr/home', NULL, NULL),
(5, 'Ανάλυση Κοινωνικών Δικτύων και Εξόρυξη Πληροφορίας', 'Εξόρυξη δεδομένων από κοινωνικά δίκτυα για την ανάλυση της συμπεριφοράς των χρηστών και την πρόβλεψη τάσεων.', NULL, 10, NULL, '0000-00-00', NULL, NULL, NULL, NULL, NULL, '2024-12-19', '15:30:00', 'Αίθουσα 3, Κτίριο Πληροφορικής', NULL, NULL, NULL),
(12, 'Εντοπισμός μεθόδων κακόβουλου χειρισμού', 'Η διπλωματική αυτή χρησιμοποιεί μηχανική μάθηση και επεξεργασία σημάτων και γραφημάτων.', 'under_assignment', NULL, 100, NULL, NULL, NULL, 'uploads/1757526319_9.MηΠαραμετρικέςΜέθοδοιΚΝΝ.pdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'Αποδοτικοί αλγόριθμοι για υπολογιστικώς δύσκολα προβλήματα σε τυχαία γραφήματα', 'Σε ένα τυχαίο γράφημα τομής ετικετών ', 'under_assignment', 18, 100, '2025-09-10', NULL, NULL, 'uploads/1757526718_8 Mη_παραμετρικές_τεχνικές_Parzen.pdf', NULL, NULL, NULL, NULL, NULL, 'https://nemertes.library.upatras.gr/communities/f772a176-3485-4ba4-b1db-c9dcc20d0553', NULL, NULL),
(15, 'Διπλωματική 3', 'Περιγραφή', 'under_assignment', NULL, 104, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'ΔΙΠΛΩΜΑΤΙΚΗ', 'ΤΕΣΤ', 'cancelled', 20, 134, '2022-09-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '20/2025', 'από Διδάσκοντα'),
(18, 'Διπλωματική 5', 'Περιγραφή διπλωματικής ', 'cancelled', 11, 101, '2025-09-12', NULL, NULL, 'uploads/1757690019_Ergastiriaki_Askisi_24-25-1.0.pdf', 'uploads/Ergastiriaki_Askisi_24-25-1.0.pdf', 'https://www.youtube.com', '2026-09-28', '07:35:00', 'https://upatras-gr.zoom.us/j/5649232365?pwd=NDN1VUhCQVZWcldkTHhDSU5lNUErZz09', 'https://nemertes.library.upatras.gr/communities/f772a176-3485-4ba4-b1db-c9dcc20d0553', '202234', 'Κατόπιν αίτησης φοιτητή/τριας'),
(19, 'Νεο θεμα ', 'σφω', 'under_assignment', 82, 100, '2025-09-18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'Μελέτη εργαλείων ai για πρόβλεψη ποδοσφαιρικού αγώνα ', 'Περιγραφή', 'under_review', 8, 100, '2025-09-19', NULL, NULL, NULL, 'uploads/AEGEAN_AIRLINES_SA_E_ticket_Confirmation.pdf', 'https://www.youtube.com/', '2025-09-20', '15:07:00', 'https://upatras-gr.zoom.us/j/5649232365?pwd=NDN1VUhCQVZWcldkTHhDSU5lNUErZz09', 'https://nemertes.library.upatras.gr/communities/f772a176-3485-4ba4-b1db-c9dcc20d0553', NULL, NULL),
(21, 'Διπλωματική under_review', 'Περιγραφή 1', 'completed', 3, 102, '2025-09-19', '2025-09-19', 9.00, 'uploads/1758280686_Ergastiriaki_Askisi_24-25-1.0.pdf', 'uploads/Ergastiriaki_Askisi_24-25-1.0.pdf', 'https://www.youtube.com/', '2025-09-28', '21:45:00', 'https://upatras-gr.zoom.us/j/5649232365?pwd=NDN1VUhCQVZWcldkTHhDSU5lNUErZz09', 'https://nemertes.library.upatras.gr/communities/f772a176-3485-4ba4-b1db-c9dcc20d0553', NULL, NULL),
(22, 'Διπλωματική completed', 'Περιγραφή 1', 'completed', 4, 102, '2025-09-19', '2025-09-19', 9.33, 'uploads/1758280725_Ergastiriaki_Askisi_24-25-1.0.pdf', 'uploads/1758280725_Ergastiriaki_Askisi_24-25-1.0.pdf', '', '0000-00-00', '00:00:00', '', 'https://nemertes.library.upatras.gr/communities/f772a176-3485-4ba4-b1db-c9dcc20d0553', NULL, NULL),
(23, 'Διπλωματική under_assignment', 'Περιγραφή 1', 'under_assignment', 6, 102, '2025-09-19', NULL, NULL, 'uploads/1758280764_Ergastiriaki_Askisi_24-25-1.0.pdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'Διπλωματική cancelled', 'Περιγραφή 1', 'under_review', 8, 102, '2025-09-19', NULL, NULL, 'uploads/1758280790_Ergastiriaki_Askisi_24-25-1.0.pdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'Διπλωματική active', 'Περιγραφή 1', 'under_assignment', 9, 102, '2025-09-19', NULL, NULL, 'uploads/1758280835_Ergastiriaki_Askisi_24-25-1.0.pdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 'Διπλωματική ', 'Περιγραφή', 'under_assignment', 17, 102, '2025-09-20', NULL, NULL, 'uploads/1758357024_Ergastiriaki_Askisi_24-25-1.0.pdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 'Νέο Θέμα ', 'Περιγραφή', 'under_assignment', NULL, 102, NULL, NULL, NULL, 'uploads/1758379018_Ergastiriaki_Askisi_24-25-1.0.pdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'Διπλωματική για μέλος', 'Περιγραφή', 'active', 5, 134, '2025-09-20', NULL, NULL, 'uploads/1758379254_Ergastiriaki_Askisi_24-25-1.0.pdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'Διπλωματική φοιτητή με διπλωματική υπό εξέταση ', 'Περιγραφή', 'under_review', 13, 128, '2025-09-20', NULL, NULL, 'uploads/1758381382_Ergastiriaki_Askisi_24-25-1.0.pdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `thesis_committee`
--

CREATE TABLE `thesis_committee` (
  `thesis_id` int(11) NOT NULL,
  `professor_id` int(11) NOT NULL,
  `role` enum('supervisor','member') NOT NULL,
  `invitation_status` varchar(20) NOT NULL DEFAULT 'pending',
  `response_date` date DEFAULT NULL,
  `grade` decimal(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `thesis_committee`
--

INSERT INTO `thesis_committee` (`thesis_id`, `professor_id`, `role`, `invitation_status`, `response_date`, `grade`) VALUES
(1, 101, 'supervisor', 'accepted', '2025-09-03', 9.00),
(1, 111, 'member', 'accepted', NULL, 10.00),
(1, 147, 'member', 'accepted', NULL, 8.00),
(12, 100, 'supervisor', 'accepted', '2025-09-10', NULL),
(13, 100, 'supervisor', 'accepted', '2025-09-10', NULL),
(17, 106, 'member', 'accepted', '2025-09-11', NULL),
(17, 134, 'supervisor', 'accepted', '2025-09-11', NULL),
(17, 140, 'member', 'accepted', '2025-09-11', NULL),
(18, 101, 'supervisor', 'accepted', '2025-09-12', NULL),
(18, 147, 'member', 'accepted', '2025-09-12', NULL),
(18, 610, 'member', 'accepted', '2025-09-12', NULL),
(19, 100, 'supervisor', 'accepted', '2025-09-18', NULL),
(19, 124, 'member', 'rejected', '2025-09-18', NULL),
(19, 146, 'member', 'accepted', '2025-09-18', NULL),
(20, 100, 'supervisor', 'accepted', '2025-09-19', NULL),
(20, 124, 'member', 'accepted', '2025-09-19', NULL),
(20, 140, 'member', 'accepted', '2025-09-19', NULL),
(21, 102, 'supervisor', 'accepted', '2025-09-19', 10.00),
(21, 121, 'member', 'accepted', '2025-09-19', 9.00),
(21, 123, 'member', 'accepted', '2025-09-19', 8.00),
(21, 124, 'member', 'rejected', '2025-09-19', NULL),
(22, 102, 'supervisor', 'accepted', '2025-09-19', 10.00),
(22, 120, 'member', 'accepted', '2025-09-19', 10.00),
(22, 148, 'member', 'accepted', '2025-09-19', 8.00),
(23, 102, 'supervisor', 'accepted', '2025-09-19', NULL),
(24, 102, 'supervisor', 'accepted', '2025-09-19', NULL),
(24, 131, 'member', 'accepted', '2025-09-17', NULL),
(24, 610, 'member', 'accepted', '2025-09-18', NULL),
(25, 102, 'supervisor', 'accepted', '2025-09-19', NULL),
(27, 102, 'supervisor', 'accepted', '2025-09-20', NULL),
(29, 102, 'supervisor', 'accepted', '2025-09-20', NULL),
(30, 102, 'member', 'accepted', '2025-09-20', NULL),
(30, 118, 'member', 'accepted', '2025-09-20', NULL),
(30, 134, 'supervisor', 'accepted', '2025-09-20', NULL),
(31, 102, 'member', 'accepted', '2025-09-20', NULL),
(31, 128, 'supervisor', 'accepted', '2025-09-20', NULL),
(31, 141, 'member', 'accepted', '2025-09-20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `thesis_notes`
--

CREATE TABLE `thesis_notes` (
  `id` int(11) NOT NULL,
  `thesis_id` int(11) NOT NULL,
  `professor_id` int(11) NOT NULL,
  `note_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `thesis_notes`
--

INSERT INTO `thesis_notes` (`id`, `thesis_id`, `professor_id`, `note_text`, `created_at`) VALUES
(1, 1, 111, 'Πολύ καλή προσπάθεια', '2025-09-10 19:34:03'),
(2, 17, 134, 'Αρκετά καλή προσπάθεια', '2025-09-11 19:04:12');

-- --------------------------------------------------------

--
-- Table structure for table `thesis_status_history`
--

CREATE TABLE `thesis_status_history` (
  `id` int(11) NOT NULL,
  `thesis_id` int(11) NOT NULL,
  `old_status` varchar(50) DEFAULT NULL,
  `new_status` varchar(50) NOT NULL,
  `change_timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `thesis_status_history`
--

INSERT INTO `thesis_status_history` (`id`, `thesis_id`, `old_status`, `new_status`, `change_timestamp`) VALUES
(2, 15, 'under_assignment', 'under_assignment', '2025-09-10 22:59:10'),
(4, 17, 'active', 'cancelled', '2025-09-11 22:09:41'),
(5, 18, 'active', 'under_review', '2025-09-12 19:28:45'),
(6, 20, 'active', 'under_review', '2025-09-19 12:00:45'),
(7, 21, 'active', 'under_review', '2025-09-19 14:32:57'),
(8, 21, 'under_review', 'completed', '2025-09-19 15:30:28'),
(9, 22, 'active', 'under_review', '2025-09-19 15:42:54'),
(10, 22, 'under_review', 'completed', '2025-09-19 15:46:28'),
(11, 31, 'active', 'under_review', '2025-09-20 18:19:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('student','professor','secretary') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `created_at`) VALUES
(1, 'secretary@ceid.upatras.gr', '$2y$10$wN33A3N.0t8z.28p5x1c/ON/h3GgGqgG03xG.1.hXfEwE0t7Fw.pQyE', 'secretary@ceid.upatras.gr', 'secretary', '2025-08-19 09:00:00'),
(2, '104333999@students.upatras.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', '104333999@students.upatras.gr', 'student', '2025-08-19 09:10:05'),
(3, 'st10434000@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434000@upnet.gr', 'student', '2025-08-19 09:10:05'),
(4, 'st10434001@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434001@upnet.gr', 'student', '2025-08-19 09:10:05'),
(5, 'st10434002@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434002@upnet.gr', 'student', '2025-08-19 09:10:05'),
(6, 'st10434003@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434003@upnet.gr', 'student', '2025-08-19 09:10:05'),
(7, 'st10434004@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434004@upnet.gr', 'student', '2025-08-19 09:10:05'),
(8, 'st10434005@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434005@upnet.gr', 'student', '2025-08-19 09:10:05'),
(9, 'st10434006@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434006@upnet.gr', 'student', '2025-08-19 09:10:05'),
(10, 'st10434007@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434007@upnet.gr', 'student', '2025-08-19 09:10:05'),
(11, 'st10434008@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434008@upnet.gr', 'student', '2025-08-19 09:10:05'),
(12, 'st10434009@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434009@upnet.gr', 'student', '2025-08-19 09:10:05'),
(13, 'st10434010@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434010@upnet.gr', 'student', '2025-08-19 09:10:05'),
(14, 'st10434011@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434011@upnet.gr', 'student', '2025-08-19 09:10:05'),
(15, 'st10434012@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434012@upnet.gr', 'student', '2025-08-19 09:10:05'),
(16, 'st10434013@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434013@upnet.gr', 'student', '2025-08-19 09:10:05'),
(17, 'st10434014@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434014@upnet.gr', 'student', '2025-08-19 09:10:05'),
(18, 'st10434015@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434015@upnet.gr', 'student', '2025-08-19 09:10:05'),
(19, 'st10434016@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434016@upnet.gr', 'student', '2025-08-19 09:10:05'),
(20, 'st10434017@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434017@upnet.gr', 'student', '2025-08-19 09:10:05'),
(21, 'st10434018@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434018@upnet.gr', 'student', '2025-08-19 09:10:05'),
(22, 'st10434019@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434019@upnet.gr', 'student', '2025-08-19 09:10:05'),
(23, 'st10434020@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434020@upnet.gr', 'student', '2025-08-19 09:10:05'),
(24, 'st10434021@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434021@upnet.gr', 'student', '2025-08-19 09:10:05'),
(25, 'st10434022@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434022@upnet.gr', 'student', '2025-08-19 09:10:05'),
(26, 'st10434023@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434023@upnet.gr', 'student', '2025-08-19 09:10:05'),
(27, 'st10434024@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434024@upnet.gr', 'student', '2025-08-19 09:10:05'),
(28, 'st10434025@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434025@upnet.gr', 'student', '2025-08-19 09:10:05'),
(29, 'st10434026@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434026@upnet.gr', 'student', '2025-08-19 09:10:05'),
(30, 'st10434027@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434027@upnet.gr', 'student', '2025-08-19 09:10:05'),
(31, 'st10434028@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434028@upnet.gr', 'student', '2025-08-19 09:10:05'),
(32, 'st10434029@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434029@upnet.gr', 'student', '2025-08-19 09:10:05'),
(33, 'st10434030@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434030@upnet.gr', 'student', '2025-08-19 09:10:05'),
(34, 'st10434031@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434031@upnet.gr', 'student', '2025-08-19 09:10:05'),
(35, 'st10434032@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434032@upnet.gr', 'student', '2025-08-19 09:10:05'),
(36, 'st10434033@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434033@upnet.gr', 'student', '2025-08-19 09:10:05'),
(37, 'st10434034@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434034@upnet.gr', 'student', '2025-08-19 09:10:05'),
(38, 'st10434035@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434035@upnet.gr', 'student', '2025-08-19 09:10:05'),
(39, 'st10434036@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434036@upnet.gr', 'student', '2025-08-19 09:10:05'),
(40, 'st10434037@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434037@upnet.gr', 'student', '2025-08-19 09:10:05'),
(41, 'st10434038@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434038@upnet.gr', 'student', '2025-08-19 09:10:05'),
(42, 'st10434039@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434039@upnet.gr', 'student', '2025-08-19 09:10:05'),
(43, 'st10434040@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434040@upnet.gr', 'student', '2025-08-19 09:10:05'),
(44, 'st10434041@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434041@upnet.gr', 'student', '2025-08-19 09:10:05'),
(45, 'st10434042@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434042@upnet.gr', 'student', '2025-08-19 09:10:05'),
(46, 'st10434043@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434043@upnet.gr', 'student', '2025-08-19 09:10:05'),
(47, 'st10434044@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434044@upnet.gr', 'student', '2025-08-19 09:10:05'),
(48, 'st10434045@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434045@upnet.gr', 'student', '2025-08-19 09:10:05'),
(49, 'st10434046@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434046@upnet.gr', 'student', '2025-08-19 09:10:05'),
(50, 'st10434047@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434047@upnet.gr', 'student', '2025-08-19 09:10:05'),
(51, 'st10434048@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434048@upnet.gr', 'student', '2025-08-19 09:10:05'),
(52, 'st10434049@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434049@upnet.gr', 'student', '2025-08-19 09:10:05'),
(53, 'st10434050@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434050@upnet.gr', 'student', '2025-08-19 09:10:05'),
(54, 'st10434051@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434051@upnet.gr', 'student', '2025-08-19 09:10:05'),
(55, 'st10434052@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434052@upnet.gr', 'student', '2025-08-19 09:10:05'),
(56, 'st10434053@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434053@upnet.gr', 'student', '2025-08-19 09:10:05'),
(57, 'st10434054@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434054@upnet.gr', 'student', '2025-08-19 09:10:05'),
(58, 'st10434055@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434055@upnet.gr', 'student', '2025-08-19 09:10:05'),
(59, 'st10434056@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434056@upnet.gr', 'student', '2025-08-19 09:10:05'),
(60, 'st10434057@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434057@upnet.gr', 'student', '2025-08-19 09:10:05'),
(61, 'st10434058@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434058@upnet.gr', 'student', '2025-08-19 09:10:05'),
(62, 'st10434059@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434059@upnet.gr', 'student', '2025-08-19 09:10:05'),
(63, 'st10434060@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434060@upnet.gr', 'student', '2025-08-19 09:10:05'),
(64, 'st10434061@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434061@upnet.gr', 'student', '2025-08-19 09:10:05'),
(65, 'st10434062@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434062@upnet.gr', 'student', '2025-08-19 09:10:05'),
(66, 'st10434063@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434063@upnet.gr', 'student', '2025-08-19 09:10:05'),
(67, 'st10434064@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434064@upnet.gr', 'student', '2025-08-19 09:10:05'),
(68, 'st10434065@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434065@upnet.gr', 'student', '2025-08-19 09:10:05'),
(69, 'st10434066@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434066@upnet.gr', 'student', '2025-08-19 09:10:05'),
(70, 'st10434067@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434067@upnet.gr', 'student', '2025-08-19 09:10:05'),
(71, 'st10434068@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434068@upnet.gr', 'student', '2025-08-19 09:10:05'),
(72, 'st10434069@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434069@upnet.gr', 'student', '2025-08-19 09:10:05'),
(73, 'st10434070@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434070@upnet.gr', 'student', '2025-08-19 09:10:05'),
(74, 'st10434071@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434071@upnet.gr', 'student', '2025-08-19 09:10:05'),
(75, 'st10434072@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434072@upnet.gr', 'student', '2025-08-19 09:10:05'),
(76, 'st10434073@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434073@upnet.gr', 'student', '2025-08-19 09:10:05'),
(77, 'st10434074@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434074@upnet.gr', 'student', '2025-08-19 09:10:05'),
(78, 'st10434075@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434075@upnet.gr', 'student', '2025-08-19 09:10:05'),
(79, 'st10434076@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434076@upnet.gr', 'student', '2025-08-19 09:10:05'),
(80, 'st10434077@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434077@upnet.gr', 'student', '2025-08-19 09:10:05'),
(81, 'st10434078@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434078@upnet.gr', 'student', '2025-08-19 09:10:05'),
(82, 'st10434079@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434079@upnet.gr', 'student', '2025-08-19 09:10:05'),
(83, 'st10434080@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434080@upnet.gr', 'student', '2025-08-19 09:10:05'),
(84, 'st10434081@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434081@upnet.gr', 'student', '2025-08-19 09:10:05'),
(85, 'st10434082@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434082@upnet.gr', 'student', '2025-08-19 09:10:05'),
(86, 'st10434083@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434083@upnet.gr', 'student', '2025-08-19 09:10:05'),
(87, 'st10434084@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434084@upnet.gr', 'student', '2025-08-19 09:10:05'),
(88, 'st10434085@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434085@upnet.gr', 'student', '2025-08-19 09:10:05'),
(89, 'st10434086@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434086@upnet.gr', 'student', '2025-08-19 09:10:05'),
(90, 'st10434087@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434087@upnet.gr', 'student', '2025-08-19 09:10:05'),
(91, 'st10434088@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434088@upnet.gr', 'student', '2025-08-19 09:10:05'),
(92, 'st10434089@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434089@upnet.gr', 'student', '2025-08-19 09:10:06'),
(93, 'st10434090@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434090@upnet.gr', 'student', '2025-08-19 09:10:06'),
(94, 'st10434091@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434091@upnet.gr', 'student', '2025-08-19 09:10:06'),
(95, 'st10434092@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434092@upnet.gr', 'student', '2025-08-19 09:10:06'),
(96, 'st10434093@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434093@upnet.gr', 'student', '2025-08-19 09:10:06'),
(97, 'st10434094@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434094@upnet.gr', 'student', '2025-08-19 09:10:06'),
(98, 'st10434095@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434095@upnet.gr', 'student', '2025-08-19 09:10:06'),
(99, 'st10434096@upnet.gr', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'st10434096@upnet.gr', 'student', '2025-08-19 09:10:06'),
(100, 'demo.professor100@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor100@example.com', 'professor', '2025-08-19 09:10:06'),
(101, 'demo.professor101@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor101@example.com', 'professor', '2025-08-19 09:10:06'),
(102, 'demo.professor102@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor102@example.com', 'professor', '2025-08-19 09:10:06'),
(103, 'demo.professor103@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor103@example.com', 'professor', '2025-08-19 09:10:06'),
(104, 'demo.professor104@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor104@example.com', 'professor', '2025-08-19 09:10:06'),
(105, 'demo.professor105@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor105@example.com', 'professor', '2025-08-19 09:10:06'),
(106, 'demo.professor106@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor106@example.com', 'professor', '2025-08-19 09:10:06'),
(107, 'demo.professor107@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor107@example.com', 'professor', '2025-08-19 09:10:06'),
(108, 'demo.professor108@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor108@example.com', 'professor', '2025-08-19 09:10:06'),
(109, 'demo.professor109@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor109@example.com', 'professor', '2025-08-19 09:10:06'),
(110, 'demo.professor110@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor110@example.com', 'professor', '2025-08-19 09:10:06'),
(111, 'demo.professor111@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor111@example.com', 'professor', '2025-08-19 09:10:06'),
(112, 'demo.professor112@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor112@example.com', 'professor', '2025-08-19 09:10:06'),
(113, 'demo.professor113@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor113@example.com', 'professor', '2025-08-19 09:10:06'),
(114, 'demo.professor114@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor114@example.com', 'professor', '2025-08-19 09:10:06'),
(115, 'demo.professor115@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor115@example.com', 'professor', '2025-08-19 09:10:06'),
(116, 'demo.professor116@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor116@example.com', 'professor', '2025-08-19 09:10:06'),
(117, 'demo.professor117@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor117@example.com', 'professor', '2025-08-19 09:10:06'),
(118, 'demo.professor118@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor118@example.com', 'professor', '2025-08-19 09:10:06'),
(119, 'demo.professor119@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor119@example.com', 'professor', '2025-08-19 09:10:06'),
(120, 'demo.professor120@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor120@example.com', 'professor', '2025-08-19 09:10:06'),
(121, 'demo.professor121@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor121@example.com', 'professor', '2025-08-19 09:10:06'),
(122, 'demo.professor122@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor122@example.com', 'professor', '2025-08-19 09:10:06'),
(123, 'demo.professor123@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor123@example.com', 'professor', '2025-08-19 09:10:06'),
(124, 'abcdef@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'abcdef@example.com', 'professor', '2025-08-19 09:10:06'),
(125, 'abcdefg@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'abcdefg@example.com', 'professor', '2025-08-19 09:10:06'),
(126, 'exxample@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'exxample@example.com', 'professor', '2025-08-19 09:10:06'),
(127, 'demo.professor127@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor127@example.com', 'professor', '2025-08-19 09:10:06'),
(128, 'demo.professor128@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor128@example.com', 'professor', '2025-08-19 09:10:06'),
(129, 'demo.professor129@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor129@example.com', 'professor', '2025-08-19 09:10:06'),
(130, 'demo.professor130@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor130@example.com', 'professor', '2025-08-19 09:10:06'),
(131, 'demo.professor131@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor131@example.com', 'professor', '2025-08-19 09:10:06'),
(132, 'demo.professor132@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor132@example.com', 'professor', '2025-08-19 09:10:06'),
(133, 'demo.professor133@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor133@example.com', 'professor', '2025-08-19 09:10:06'),
(134, 'demo.professor134@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor134@example.com', 'professor', '2025-08-19 09:10:06'),
(135, 'demo.professor135@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor135@example.com', 'professor', '2025-08-19 09:10:06'),
(136, 'demo.professor136@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor136@example.com', 'professor', '2025-08-19 09:10:06'),
(137, 'demo.professor137@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor137@example.com', 'professor', '2025-08-19 09:10:06'),
(138, 'demo.professor138@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor138@example.com', 'professor', '2025-08-19 09:10:06'),
(139, 'demo.professor139@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor139@example.com', 'professor', '2025-08-19 09:10:06'),
(140, 'demo.professor140@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor140@example.com', 'professor', '2025-08-19 09:10:06'),
(141, 'demo.professor141@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor141@example.com', 'professor', '2025-08-19 09:10:06'),
(142, 'demo.professor142@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor142@example.com', 'professor', '2025-08-19 09:10:06'),
(143, 'demo.professor143@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor143@example.com', 'professor', '2025-08-19 09:10:06'),
(144, 'demo.professor144@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor144@example.com', 'professor', '2025-08-19 09:10:06'),
(145, 'demo.professor145@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor145@example.com', 'professor', '2025-08-19 09:10:06'),
(146, 'demo.professor146@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor146@example.com', 'professor', '2025-08-19 09:10:06'),
(147, 'demo.professor147@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor147@example.com', 'professor', '2025-08-19 09:10:06'),
(148, 'demo.professor148@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor148@example.com', 'professor', '2025-08-19 09:10:06'),
(149, 'demo.professor149@example.com', '$2y$10$s6pdMyyqiYrmuSJHDuIrqOZZ8zW99xgzzJ7AsZlcb79/i9aT273Gm', 'demo.professor149@example.com', 'professor', '2025-08-19 09:10:06'),
(150, 'grammateia2', '$2y$10$cPA.5iT7k61v2g.xZ.aMguXn/Nl4Yk8g8k7zB6r5f4E3g2h1I0j9a', 'grammateia2@upatras.gr', 'secretary', '2025-08-21 09:47:16'),
(152, 'grammateia3', '$2y$10$f/9S.9u4b.v7w8X.yZ/A.B.C.D.E.F.G.H.I.J.K.L.M.N.O', 'grammateia3@upatras.gr', 'secretary', '2025-08-21 09:54:11'),
(159, 'secretary', '$2y$10$APKKFLUwsGqjGFV02dnBuuhyflESrVVix8/lJ14xh7hdXtCXQYGHe', 'secretary@upatras.gr', 'secretary', '2025-08-21 10:00:56'),
(554, 'st10434097@upnet.gr', '$2y$10$BDX3O.MugYJ7Cg5i1J61k.GrifZC0jOvjSRW0RVdMRmVg5DuTP7PC', 'st10434097@upnet.gr', 'student', '2025-09-08 18:31:27'),
(555, 'st10434098@upnet.gr', '$2y$10$BDX3O.MugYJ7Cg5i1J61k.GrifZC0jOvjSRW0RVdMRmVg5DuTP7PC', 'st10434098@upnet.gr', 'student', '2025-09-08 18:31:27'),
(556, 'st10434099@upnet.gr', '$2y$10$BDX3O.MugYJ7Cg5i1J61k.GrifZC0jOvjSRW0RVdMRmVg5DuTP7PC', 'st10434099@upnet.gr', 'student', '2025-09-08 18:31:27'),
(557, 'st10434100@upnet.gr', '$2y$10$BDX3O.MugYJ7Cg5i1J61k.GrifZC0jOvjSRW0RVdMRmVg5DuTP7PC', 'st10434100@upnet.gr', 'student', '2025-09-08 18:31:27'),
(608, 'demo.professor608@example.com', '$2y$10$BDX3O.MugYJ7Cg5i1J61k.GrifZC0jOvjSRW0RVdMRmVg5DuTP7PC', 'demo.professor608@example.com', 'professor', '2025-09-08 18:31:27'),
(609, 'demo.professor609@example.com', '$2y$10$BDX3O.MugYJ7Cg5i1J61k.GrifZC0jOvjSRW0RVdMRmVg5DuTP7PC', 'demo.professor609@example.com', 'professor', '2025-09-08 18:31:27'),
(610, 'demo.professor610@example.com', '$2y$10$BDX3O.MugYJ7Cg5i1J61k.GrifZC0jOvjSRW0RVdMRmVg5DuTP7PC', 'demo.professor610@example.com', 'professor', '2025-09-08 18:31:27'),
(611, 'demo.professor611@example.com', '$2y$10$BDX3O.MugYJ7Cg5i1J61k.GrifZC0jOvjSRW0RVdMRmVg5DuTP7PC', 'demo.professor611@example.com', 'professor', '2025-09-08 18:31:27'),
(768, 'student@example.com', '$2y$10$903awGkV.vxHLgfR9Lh83uJb41C90SD.jKDvYdG6FkUZncvGRTmgC', 'student@example.com', 'student', '2025-09-18 16:13:18'),
(769, 'professor@example.com', '$2y$10$903awGkV.vxHLgfR9Lh83uJb41C90SD.jKDvYdG6FkUZncvGRTmgC', 'professor@example.com', 'professor', '2025-09-18 16:13:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `professors`
--
ALTER TABLE `professors`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `secretaries`
--
ALTER TABLE `secretaries`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `student_number` (`student_number`);

--
-- Indexes for table `theses`
--
ALTER TABLE `theses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `thesis_committee`
--
ALTER TABLE `thesis_committee`
  ADD PRIMARY KEY (`thesis_id`,`professor_id`),
  ADD KEY `professor_id` (`professor_id`);

--
-- Indexes for table `thesis_notes`
--
ALTER TABLE `thesis_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `thesis_id` (`thesis_id`),
  ADD KEY `professor_id` (`professor_id`);

--
-- Indexes for table `thesis_status_history`
--
ALTER TABLE `thesis_status_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `thesis_id` (`thesis_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `theses`
--
ALTER TABLE `theses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `thesis_notes`
--
ALTER TABLE `thesis_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `thesis_status_history`
--
ALTER TABLE `thesis_status_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=770;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `professors`
--
ALTER TABLE `professors`
  ADD CONSTRAINT `professors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `secretaries`
--
ALTER TABLE `secretaries`
  ADD CONSTRAINT `secretaries_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `theses`
--
ALTER TABLE `theses`
  ADD CONSTRAINT `theses_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `thesis_committee`
--
ALTER TABLE `thesis_committee`
  ADD CONSTRAINT `thesis_committee_ibfk_1` FOREIGN KEY (`thesis_id`) REFERENCES `theses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `thesis_committee_ibfk_2` FOREIGN KEY (`professor_id`) REFERENCES `professors` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `thesis_notes`
--
ALTER TABLE `thesis_notes`
  ADD CONSTRAINT `thesis_notes_ibfk_1` FOREIGN KEY (`thesis_id`) REFERENCES `theses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `thesis_notes_ibfk_2` FOREIGN KEY (`professor_id`) REFERENCES `professors` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `thesis_status_history`
--
ALTER TABLE `thesis_status_history`
  ADD CONSTRAINT `thesis_status_history_ibfk_1` FOREIGN KEY (`thesis_id`) REFERENCES `theses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
