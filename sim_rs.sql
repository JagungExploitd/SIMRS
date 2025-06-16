-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2025 at 02:15 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sim_rs`
--

-- --------------------------------------------------------

--
-- Table structure for table `admission`
--

CREATE TABLE `admission` (
  `admissionID` int(10) NOT NULL,
  `patientsID` int(10) NOT NULL,
  `doctorID` int(10) NOT NULL,
  `staffID` int(10) NOT NULL,
  `roomID` int(10) NOT NULL,
  `admission_date` date NOT NULL,
  `discharge_date` date DEFAULT NULL,
  `initial_diagnosis` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admission`
--

INSERT INTO `admission` (`admissionID`, `patientsID`, `doctorID`, `staffID`, `roomID`, `admission_date`, `discharge_date`, `initial_diagnosis`) VALUES
(101, 51, 2301, 3401, 301, '2025-05-18', '2025-05-20', 'Hypertension'),
(102, 52, 2302, 3402, 302, '2025-05-18', '2025-05-22', 'Asthma'),
(103, 53, 2303, 3403, 303, '2025-05-19', NULL, 'Bronchitis'),
(104, 54, 2304, 3404, 304, '2025-05-19', NULL, 'Fever'),
(105, 55, 2305, 3405, 305, '2025-05-18', '2025-05-20', 'Fracture'),
(106, 56, 2306, 3406, 306, '2025-05-18', '2025-05-20', 'Skin Rash'),
(107, 57, 2307, 3407, 307, '2025-05-19', NULL, 'Pneumonia'),
(108, 58, 2308, 3408, 308, '2025-05-19', NULL, 'Conjunctivitis'),
(109, 59, 2309, 3409, 309, '2025-05-20', '2025-05-22', 'Lung Cancer'),
(110, 60, 2310, 3410, 310, '2025-05-20', NULL, 'Asthma'),
(111, 61, 2311, 3411, 311, '2025-05-18', '2025-05-21', 'Migraine'),
(112, 62, 2312, 3412, 312, '2025-05-20', NULL, 'Diabetes Type 1'),
(113, 63, 2313, 3413, 313, '2025-05-18', '2025-05-22', 'Epilepsy'),
(114, 64, 2314, 3414, 314, '2025-05-19', NULL, 'Allergic Rhinitis'),
(115, 65, 2315, 3401, 315, '2025-05-18', '2025-05-20', 'Acid Reflux'),
(116, 66, 2316, 3402, 316, '2025-05-19', '2025-05-21', 'Gallstones'),
(117, 67, 2317, 3403, 317, '2025-05-20', NULL, 'Arthritis'),
(118, 68, 2318, 3404, 318, '2025-05-19', '2025-05-20', 'Anxiety'),
(119, 69, 2319, 3405, 319, '2025-05-18', NULL, 'Chest Pain'),
(120, 70, 2320, 3406, 320, '2025-05-19', '2025-05-21', 'Obesity'),
(121, 71, 2321, 3407, 301, '2025-05-18', '2025-05-20', 'Kidney Infection'),
(122, 72, 2322, 3408, 302, '2025-05-19', NULL, 'Sore Throat'),
(123, 73, 2323, 3409, 303, '2025-05-20', '2025-05-21', 'Back Pain'),
(124, 74, 2324, 3410, 304, '2025-05-19', NULL, 'Cough'),
(125, 75, 2325, 3411, 305, '2025-05-18', '2025-05-22', 'Fever'),
(126, 76, 2326, 3412, 306, '2025-05-18', '2025-05-21', 'Stomach Ulcer'),
(127, 77, 2327, 3413, 307, '2025-05-19', NULL, 'Migraine'),
(128, 78, 2328, 3414, 308, '2025-05-19', '2025-05-21', 'Anemia'),
(129, 79, 2329, 3401, 309, '2025-05-18', '2025-05-19', 'Pneumonia'),
(130, 80, 2301, 3402, 310, '2025-05-20', '2025-05-22', 'Cystic Fibrosis'),
(131, 81, 2302, 3403, 311, '2025-05-20', NULL, 'Hypertension');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `doctorID` int(11) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `specialist` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`doctorID`, `username`, `first_name`, `last_name`, `specialist`) VALUES
(2301, 'john_doe', 'John', 'Doe', 'Cardiologist'),
(2302, 'jane_smith', 'Jane', 'Smith', 'Neurologist'),
(2303, 'mike_johnson', 'Mike', 'Johnson', 'Pediatrician'),
(2304, 'emily_davis', 'Emily', 'Davis', 'Dermatologist'),
(2305, 'oliver_brown', 'Oliver', 'Brown', 'Orthopedist'),
(2306, 'ava_wilson', 'Ava', 'Wilson', 'Psychiatrist'),
(2307, 'ella_moore', 'Ella', 'Moore', 'Surgeon'),
(2308, 'james_taylor', 'James', 'Taylor', 'Radiologist'),
(2309, 'lucas_anderson', 'Lucas', 'Anderson', 'ENT Specialist'),
(2310, 'isabella_thomas', 'Isabella', 'Thomas', 'Gastroenterologist'),
(2311, 'sophia_jackson', 'Sophia', 'Jackson', 'Oncologist'),
(2312, 'benjamin_white', 'Benjamin', 'White', 'Opthalmologist'),
(2313, 'chloe_harris', 'Chloe', 'Harris', 'Anesthesiologist'),
(2314, 'olivia_martin', 'Olivia', 'Martin', 'Nephrologist'),
(2315, 'nathan_garcia', 'Nathan', 'Garcia', 'General Practitioner'),
(2316, 'rachel_martinez', 'Rachel', 'Martinez', 'Urologist'),
(2317, 'samuel_roberts', 'Samuel', 'Roberts', 'Plastic Surgeon'),
(2318, 'david_clark', 'David', 'Clark', 'Pulmonologist'),
(2319, 'amelia_lewis', 'Amelia', 'Lewis', 'Endocrinologist'),
(2320, 'noah_walker', 'Noah', 'Walker', 'Rheumatologist'),
(2321, 'ella_lopez', 'Ella', 'Lopez', 'Pathologist'),
(2322, 'zoe_young', 'Zoe', 'Young', 'Hematologist'),
(2323, 'mason_king', 'Mason', 'King', 'Geriatrician'),
(2324, 'logan_scott', 'Logan', 'Scott', 'Infectious Disease Specialist'),
(2325, 'ella_adams', 'Ella', 'Adams', 'Physical Therapist'),
(2326, 'ryan_baker', 'Ryan', 'Baker', 'Emergency Medicine'),
(2327, 'joseph_hernandez', 'Joseph', 'Hernandez', 'Vascular Surgeon'),
(2328, 'kate_carter', 'Kate', 'Carter', 'Neuropsychiatrist'),
(2329, 'liam_mitchell', 'Liam', 'Mitchell', 'Immunologist'),
(2331, 'nizam', 'Nizam', 'Bro', 'Gold Lane');

-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE `medicine` (
  `medicineID` int(11) NOT NULL,
  `medicine_name` varchar(50) NOT NULL,
  `medicine_stock` int(11) NOT NULL,
  `medicine_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicine`
--

INSERT INTO `medicine` (`medicineID`, `medicine_name`, `medicine_stock`, `medicine_price`) VALUES
(1201, 'Paracetamol', 335, 18000),
(1202, 'Ibuprofen', 459, 67000),
(1203, 'Aspirin', 231, 32000),
(1204, 'Amoxicillin', 453, 49000),
(1205, 'Cetirizine', 416, 57000),
(1206, 'Loratadine', 222, 76000),
(1207, 'Metformin', 130, 24000),
(1208, 'Simvastatin', 245, 35000),
(1209, 'Atorvastatin', 399, 83000),
(1210, 'Losartan', 432, 61000),
(1211, 'Omeprazole', 416, 48000),
(1212, 'Lansoprazole', 354, 60000),
(1213, 'Furosemide', 455, 93000),
(1214, 'Hydrochlorothiazide', 147, 19000),
(1215, 'Ciprofloxacin', 164, 28000),
(1216, 'Azithromycin', 290, 38000),
(1217, 'Doxycycline', 270, 52000),
(1218, 'Clindamycin', 420, 46000),
(1219, 'Amoxiclav', 129, 58000),
(1220, 'Diclofenac', 261, 73000),
(1221, 'Prednisolone', 81, 35000),
(1222, 'Methylprednisolone', 269, 66000),
(1223, 'Hydrocortisone', 88, 58000),
(1224, 'Alprazolam', 232, 91000),
(1225, 'Clonazepam', 80, 41000),
(1226, 'Lorazepam', 343, 56000),
(1227, 'Diazepam', 175, 68000),
(1228, 'Midazolam', 88, 90000),
(1229, 'Lorazepam', 230, 76000),
(1230, 'Tramadol', 348, 65000);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patientsID` int(11) NOT NULL,
  `provinceID` char(2) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `weight` decimal(4,0) DEFAULT NULL,
  `height` decimal(3,0) DEFAULT NULL,
  `disease` varchar(40) DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `birth_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patientsID`, `provinceID`, `first_name`, `last_name`, `weight`, `height`, `disease`, `gender`, `birth_date`) VALUES
(51, 'AC', 'Liam', 'Müller', 75, 180, 'Hypertension', 'M', '1992-03-15'),
(52, 'BB', 'Olivia', 'Smith', 60, 165, 'Asthma', 'F', '1988-07-22'),
(53, 'BL', 'Noah', 'Schmidt', 80, 175, 'Bronchitis', 'M', '1995-11-10'),
(54, 'BN', 'Emma', 'Jones', 55, 160, 'Fever', 'F', '2000-01-30'),
(55, 'BS', 'Lucas', 'Taylor', 85, 185, 'Fracture', 'M', '1987-05-20'),
(56, 'DY', 'Sophia', 'Brown', 65, 170, 'Skin Rash', 'F', '1992-08-13'),
(57, 'JB', 'Mason', 'Wilson', 72, 178, 'Pneumonia', 'M', '1993-03-25'),
(58, 'JI', 'Isabella', 'Davis', 58, 162, 'Conjunctivitis', 'F', '1996-12-05'),
(59, 'JK', 'James', 'Rodriguez', 78, 172, 'Lung Cancer', 'M', '1985-04-18'),
(60, 'JM', 'Charlotte', 'Martínez', 64, 168, 'Asthma', 'F', '1990-06-30'),
(61, 'JT', 'Ethan', 'Hernández', 74, 176, 'Migraine', 'M', '1994-09-07'),
(62, 'JW', 'Amelia', 'Lopez', 59, 163, 'Diabetes Type 1', 'F', '1999-11-12'),
(63, 'JK', 'Alexander', 'García', 82, 180, 'Epilepsy', 'M', '1988-02-28'),
(64, 'KU', 'Ava', 'Miller', 52, 155, 'Allergic Rhinitis', 'F', '2002-01-19'),
(65, 'LA', 'Jack', 'Wilson', 76, 180, 'Acid Reflux', 'M', '1993-05-09'),
(66, 'ML', 'Mia', 'Moore', 63, 167, 'Gallstones', 'F', '2000-01-19'),
(67, 'MU', 'Oliver', 'Taylor', 88, 183, 'Arthritis', 'M', '1990-11-20'),
(68, 'NA', 'Ella', 'Anderson', 57, 162, 'Anxiety', 'F', '1996-01-18'),
(69, 'NB', 'Henry', 'Thomas', 79, 177, 'Chest Pain', 'M', '1999-06-19'),
(70, 'NT', 'Scarlett', 'Jackson', 61, 165, 'Obesity', 'F', '1987-04-30'),
(71, 'PA', 'Benjamin', 'White', 73, 170, 'Kidney Infection', 'M', '1993-11-09'),
(72, 'PB', 'Harper', 'Harris', 65, 168, 'Sore Throat', 'F', '2000-02-25'),
(73, 'RI', 'Sebastian', 'Clark', 80, 182, 'Back Pain', 'M', '1996-10-12'),
(74, 'SA', 'Avery', 'Lewis', 54, 160, 'Cough', 'F', '1992-07-01'),
(75, 'SB', 'Jack', 'Young', 75, 179, 'Fever', 'M', '1999-01-15'),
(76, 'SE', 'Lily', 'Walker', 58, 167, 'Stomach Ulcer', 'F', '1989-08-21'),
(77, 'SG', 'Daniel', 'Hall', 85, 180, 'Migraine', 'M', '1995-12-09'),
(78, 'SN', 'Grace', 'Allen', 60, 163, 'Anemia', 'F', '1990-10-14'),
(79, 'SS', 'Matthew', 'King', 76, 176, 'Pneumonia', 'M', '1993-09-06'),
(80, 'ST', 'Zoe', 'Scott', 55, 160, 'Cystic Fibrosis', 'F', '1994-02-28'),
(81, 'SU', 'David', 'Adams', 77, 178, 'Hypertension', 'M', '1997-07-12'),
(82, 'JK', 'Kharisdeo Fernando', 'Kasyono', 90, 180, 'Obesity', 'M', '2002-10-23');

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `provinceID` char(2) NOT NULL,
  `province_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `province`
--

INSERT INTO `province` (`provinceID`, `province_name`) VALUES
('AC', 'Aceh'),
('BB', 'Bangka Belitung'),
('BL', 'Bali'),
('BN', 'Banten'),
('BS', 'Bengkulu'),
('DY', 'DI Yogyakarta'),
('GO', 'Gorontalo'),
('JB', 'Jawa Barat'),
('JI', 'Jawa Timur'),
('JK', 'DKI Jakarta'),
('JM', 'Jambi'),
('JT', 'Jawa Tengah'),
('JW', 'Jawa'),
('KI', 'Kalimantan Timur'),
('KL', 'Kalimantan Raya'),
('KR', 'Kepulauan Riau'),
('KS', 'Kalimantan Selatan'),
('KT', 'Kalimantan Tengah'),
('KU', 'Kalimantan Utara'),
('LA', 'Lampung'),
('ML', 'Maluku'),
('MU', 'Maluku Utara'),
('NA', 'Nusa Aceh'),
('NB', 'Nusa Tenggara Barat'),
('NT', 'Nusa Tenggara Timur'),
('PA', 'Papua'),
('PB', 'Papua Barat'),
('RI', 'Riau'),
('SA', 'Sumatera Utara'),
('SB', 'Sumatera Barat'),
('SE', 'Sebu'),
('SG', 'Sulawesi Tenggara'),
('SN', 'Sumatera Selatan'),
('SS', 'Sulawesi Selatan'),
('ST', 'Sulawesi Tengah'),
('SU', 'Sulawesi Utara');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `roleID` int(11) NOT NULL,
  `role_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`roleID`, `role_name`) VALUES
(0, 'Admin'),
(1, 'Doctor'),
(2, 'Receptionist'),
(3, 'Pharmacist');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `roomID` int(11) NOT NULL,
  `room_type` varchar(20) NOT NULL,
  `room_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`roomID`, `room_type`, `room_name`) VALUES
(301, 'VIP', 'Room 301 - VIP'),
(302, 'Standard', 'Room 302 - Standard'),
(303, 'Emergency', 'Room 303 - Emergency'),
(304, 'ICU', 'Room 304 - ICU'),
(305, 'Private', 'Room 305 - Private'),
(306, 'General', 'Room 306 - General'),
(307, 'Deluxe', 'Room 307 - Deluxe'),
(308, 'Pediatric', 'Room 308 - Pediatric'),
(309, 'Maternity', 'Room 309 - Maternity'),
(310, 'Surgical', 'Room 310 - Surgical'),
(311, 'Isolation', 'Room 311 - Isolation'),
(312, 'Recovery', 'Room 312 - Recovery'),
(313, 'Laboratory', 'Room 313 - Laboratory'),
(314, 'Consultation', 'Room 314 - Consultation'),
(315, 'Operating', 'Room 315 - Operating'),
(316, 'Orthopedic', 'Room 316 - Orthopedic'),
(317, 'Neurology', 'Room 317 - Neurology'),
(318, 'Cardiology', 'Room 318 - Cardiology'),
(319, 'Oncology', 'Room 319 - Oncology'),
(320, 'Radiology', 'Room 320 - Radiology'),
(321, 'Standard', 'Room 321 - Standard'),
(322, 'Standard', 'Room 322 - Standard'),
(323, 'Standard', 'Room 323 - Standard'),
(324, 'Standard', 'Room 324 - Standard'),
(325, 'Standard', 'Room 325 - Standard'),
(326, 'Standard', 'Room 326 - Standard'),
(327, 'Standard', 'Room 327 - Standard'),
(328, 'Standard', 'Room 328 - Standard'),
(329, 'Standard', 'Room 329 - Standard'),
(330, 'Standard', 'Room 330 - Standard'),
(331, 'VIP', 'Room 331 - VIP'),
(332, 'VIP', 'Room 332 - VIP'),
(333, 'VIP', 'Room 333 - VIP'),
(334, 'Deluxe', 'Room 334 - Deluxe'),
(335, 'Deluxe', 'Room 335 - Deluxe'),
(336, 'General', 'Room 336 - General'),
(337, 'General', 'Room 337 - General'),
(338, 'Private', 'Room 338 - Private'),
(339, 'Private', 'Room 339 - Private');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffID` int(10) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `staff_first_name` varchar(30) NOT NULL,
  `staff_last_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffID`, `username`, `staff_first_name`, `staff_last_name`) VALUES
(3401, 'satoshit', 'Satoshi', 'Tanaka'),
(3402, 'yuki_sakamoto', 'Yuki', 'Sakamoto'),
(3403, 'haruto_kobayashi', 'Haruto', 'Kobayashi'),
(3404, 'mina_yamamoto', 'Mina', 'Yamamoto'),
(3405, 'hiroshi_nakamura', 'Hiroshi', 'Nakamura'),
(3406, 'aya_matsumoto', 'Aya', 'Matsumoto'),
(3407, 'jin_lee', 'Jin', 'Lee'),
(3408, 'jiwoo_park', 'Jiwoo', 'Park'),
(3409, 'mei_chen', 'Mei', 'Chen'),
(3410, 'jun_wang', 'Jun', 'Wang'),
(3411, 'ayesha_khan', 'Ayesha', 'Khan'),
(3412, 'raj_sharma', 'Raj', 'Sharma'),
(3413, 'kai_li', 'Kai', 'Li'),
(3414, 'lina_nguyen', 'Lina', 'Nguyen');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transactionID` int(11) NOT NULL,
  `admissionID` int(11) NOT NULL,
  `medicineID` int(11) NOT NULL,
  `transaction_date` date NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transactionID`, `admissionID`, `medicineID`, `transaction_date`, `total_amount`, `payment_method`) VALUES
(501, 101, 1201, '2025-05-18', 18000.00, 'Cash'),
(502, 102, 1202, '2025-05-19', 67000.00, 'Card'),
(503, 103, 1203, '2025-05-19', 32000.00, 'Insurance'),
(504, 104, 1204, '2025-05-20', 49000.00, 'Cash'),
(505, 105, 1205, '2025-05-20', 57000.00, 'Card'),
(506, 106, 1206, '2025-05-21', 76000.00, 'Insurance'),
(507, 107, 1207, '2025-05-21', 24000.00, 'Cash'),
(508, 108, 1208, '2025-05-22', 35000.00, 'Card'),
(509, 109, 1209, '2025-05-22', 83000.00, 'Insurance'),
(510, 110, 1210, '2025-05-23', 61000.00, 'Cash'),
(511, 111, 1211, '2025-05-23', 48000.00, 'Card'),
(512, 112, 1212, '2025-05-24', 60000.00, 'Insurance'),
(513, 113, 1213, '2025-05-24', 93000.00, 'Cash'),
(514, 114, 1214, '2025-05-25', 19000.00, 'Card'),
(515, 115, 1215, '2025-05-25', 28000.00, 'Insurance'),
(516, 116, 1216, '2025-05-26', 38000.00, 'Cash'),
(517, 117, 1217, '2025-05-26', 52000.00, 'Card'),
(518, 118, 1218, '2025-05-27', 46000.00, 'Insurance'),
(519, 119, 1219, '2025-05-27', 58000.00, 'Cash'),
(520, 120, 1220, '2025-05-28', 73000.00, 'Card'),
(521, 121, 1221, '2025-05-28', 35000.00, 'Insurance'),
(522, 122, 1222, '2025-05-29', 66000.00, 'Cash'),
(523, 123, 1223, '2025-05-29', 58000.00, 'Card'),
(524, 124, 1224, '2025-05-30', 91000.00, 'Insurance'),
(525, 125, 1225, '2025-05-30', 41000.00, 'Cash'),
(526, 126, 1226, '2025-06-01', 56000.00, 'Card'),
(527, 127, 1227, '2025-06-01', 68000.00, 'Insurance'),
(528, 128, 1228, '2025-06-02', 90000.00, 'Cash'),
(529, 129, 1229, '2025-06-02', 76000.00, 'Card'),
(530, 130, 1230, '2025-06-03', 65000.00, 'Insurance');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `roleID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `roleID`) VALUES
('admin', '$2y$10$9wjsDSxssXisnEUN9ojX9.ITHUjxey/7VO8vlC7Px9cmL6v4Za0qS', 0),
('amelia_lewis', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1),
('ava_wilson', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1),
('aya_matsumoto', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 2),
('ayesha_khan', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 3),
('benjamin_white', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1),
('chloe_harris', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1),
('david_clark', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1),
('ella_adams', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1),
('ella_lopez', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1),
('ella_moore', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1),
('emily_davis', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1),
('haruto_kobayashi', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 3),
('hiroshi_nakamura', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 2),
('isabella_thomas', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1),
('james_taylor', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1),
('jane_smith', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1),
('jin_lee', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 3),
('jiwoo_park', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 3),
('john_doe', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1),
('joseph_hernandez', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1),
('jun_wang', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 2),
('kai_li', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 2),
('kate_carter', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1),
('liam_mitchell', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1),
('lina_nguyen', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 2),
('logan_scott', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1),
('lucas_anderson', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1),
('mason_king', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1),
('mei_chen', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 2),
('mike_johnson', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1),
('mina_yamamoto', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 3),
('nathan_garcia', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1),
('nizam', '$2y$10$DCqT3Q6Uf9K/jZQTlKsFTeQhekSA60DSZx47jyCWZC0fPG6mZWMG.', 2),
('noah_walker', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1),
('oliver_brown', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1),
('olivia_martin', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1),
('rachel_martinez', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1),
('raj_sharma', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 3),
('ryan_baker', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1),
('samuel_roberts', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1),
('satoshit', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 2),
('sophia_jackson', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1),
('yuki_sakamoto', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 3),
('zoe_young', '$2y$10$XJATqDV/rqMC5E3.bo3MPO37rvMfVxEbG6BUXkyaUjmc9LfeuZFJa', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admission`
--
ALTER TABLE `admission`
  ADD PRIMARY KEY (`admissionID`),
  ADD KEY `patientsID` (`patientsID`),
  ADD KEY `doctorID` (`doctorID`),
  ADD KEY `staffID` (`staffID`),
  ADD KEY `roomID` (`roomID`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`doctorID`),
  ADD KEY `fk_doctor_username` (`username`);

--
-- Indexes for table `medicine`
--
ALTER TABLE `medicine`
  ADD PRIMARY KEY (`medicineID`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patientsID`),
  ADD KEY `patients_ibfk_1` (`provinceID`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`provinceID`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`roleID`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`roomID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffID`),
  ADD KEY `fk_staff_username` (`username`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transactionID`),
  ADD KEY `admissionID` (`admissionID`),
  ADD KEY `medicineID` (`medicineID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD KEY `roleID` (`roleID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admission`
--
ALTER TABLE `admission`
  MODIFY `admissionID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=501;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `doctorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2332;

--
-- AUTO_INCREMENT for table `medicine`
--
ALTER TABLE `medicine`
  MODIFY `medicineID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1231;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patientsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `roomID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=340;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staffID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3415;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transactionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=531;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admission`
--
ALTER TABLE `admission`
  ADD CONSTRAINT `admission_ibfk_1` FOREIGN KEY (`patientsID`) REFERENCES `patients` (`patientsID`),
  ADD CONSTRAINT `admission_ibfk_2` FOREIGN KEY (`doctorID`) REFERENCES `doctor` (`doctorID`),
  ADD CONSTRAINT `admission_ibfk_3` FOREIGN KEY (`staffID`) REFERENCES `staff` (`staffID`),
  ADD CONSTRAINT `admission_ibfk_4` FOREIGN KEY (`roomID`) REFERENCES `room` (`roomID`);

--
-- Constraints for table `doctor`
--
ALTER TABLE `doctor`
  ADD CONSTRAINT `fk_doctor_username` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_ibfk_1` FOREIGN KEY (`provinceID`) REFERENCES `province` (`provinceID`);

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `fk_staff_username` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`admissionID`) REFERENCES `admission` (`admissionID`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`medicineID`) REFERENCES `medicine` (`medicineID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`roleID`) REFERENCES `roles` (`roleID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
