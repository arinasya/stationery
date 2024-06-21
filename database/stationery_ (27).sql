-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2024 at 10:00 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `stationery_`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `item_id`, `quantity`, `price`) VALUES
(1, 8, 89, 1, 14.85);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `charge_code` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `price`, `vendor_id`, `description`, `status`, `date_created`, `charge_code`) VALUES
(3, 'A4 PAPER QUALITY 70GSM', 9.9, 3, '&lt;p&gt;&lt;b&gt;500 Sheets&lt;/b&gt;&lt;/p&gt;', 1, '2024-05-10 16:52:24', '52525000'),
(4, 'A3 PAPER 70GSM', 28, 3, '&lt;p&gt;&lt;b&gt;500 Sheets&lt;/b&gt;&lt;/p&gt;', 1, '2024-05-10 17:12:51', '52525087'),
(5, 'A5 PAPER 70GSM', 7.5, 3, '&lt;p&gt;&lt;b&gt;500 Sheets&lt;/b&gt;&lt;/p&gt;', 1, '2024-05-10 17:15:10', '52525145'),
(6, 'ARTLINE MARKER PEN 500', 2.9, 3, '&lt;p&gt;&lt;b&gt;Black&lt;/b&gt;&lt;/p&gt;', 1, '2024-05-10 17:17:41', '52525038'),
(7, 'ARTLINE MARKER PEN 500 Blue', 2.9, 3, '&lt;p&gt;&lt;b&gt;Blue&lt;/b&gt;&lt;/p&gt;', 1, '2024-05-10 17:21:04', '52525039'),
(8, 'ARTLINE MARKER PEN 500 RED', 2.9, 3, '&lt;p&gt;&lt;b&gt;Red&lt;/b&gt;&lt;/p&gt;', 1, '2024-05-10 17:23:08', '52525094'),
(9, 'ARTLINE STAMP  PAD INK    BLACK', 7.2, 3, '&lt;p&gt;Black&lt;/p&gt;', 1, '2024-05-13 09:28:07', '52520091'),
(10, 'ARTLINE STAMP  PAD INK    BLUE', 7.2, 3, '&lt;p&gt;Blue&lt;/p&gt;', 1, '2024-05-13 09:29:44', '52520125'),
(11, 'ARTLINE STAMP  PAD INK    RED', 7.2, 3, '&lt;p&gt;Red&lt;/p&gt;', 1, '2024-05-13 09:31:33', '52525075'),
(12, 'STAPLES BULLET 24/6 (3-1M)   BIG', 1.5, 3, '&lt;p&gt;Big&lt;/p&gt;', 1, '2024-05-13 09:33:59', '52525020'),
(13, 'STAPLES BULLET MAX 10       SMALL', 1.1, 3, '&lt;p&gt;Small&lt;/p&gt;', 1, '2024-05-13 09:36:28', '52525001'),
(14, 'Cellophane Tape 24X45', 3.8, 3, '&lt;p&gt;24X45&lt;/p&gt;', 1, '2024-05-13 09:39:24', '52525021'),
(15, 'Happy Glue', 1.2, 3, '&lt;p&gt;Glue&lt;/p&gt;', 1, '2024-05-13 09:41:07', '52525004'),
(16, 'PAPER CLIP SMALL', 0.6, 3, '&lt;p&gt;small&lt;/p&gt;', 1, '2024-05-13 09:43:50', '52525005'),
(17, 'PAPER FASTENER', 2.5, 3, '&lt;p&gt;Paper Fastener&lt;/p&gt;', 1, '2024-05-13 09:45:48', '52525052'),
(18, 'SUPER PP FOLDER CBE 805A', 2.8, 3, '&lt;p&gt;CBE 805A&lt;/p&gt;', 1, '2024-05-13 09:47:57', '52525103'),
(19, 'BATTERY ENERGIZER 9V', 14.5, 3, '&lt;p&gt;9V&lt;/p&gt;', 1, '2024-05-13 09:50:52', '52525044'),
(20, 'BATTERY ENEGIZER D', 5.9, 3, '&lt;p&gt;Energizer D&lt;/p&gt;', 1, '2024-05-13 09:53:01', '52525051'),
(22, 'BATTERY ENEGIZER CR2032-3V', 5, 3, '&lt;p&gt;CR2032-3V&lt;/p&gt;', 1, '2024-05-13 10:09:41', '52525127'),
(23, 'BATTERY C', 4.8, 3, '&lt;p&gt;Battery C&lt;/p&gt;', 1, '2024-05-13 10:10:25', '52525022'),
(24, 'DOCUMENT PROTECTOR', 2, 3, '&lt;p&gt;Document Protector&lt;/p&gt;', 1, '2024-05-13 10:11:30', '52525008'),
(25, 'F/SCAP BOOK 300PG  LONG', 6.5, 3, '&lt;p&gt;300PG LONG&lt;/p&gt;', 1, '2024-05-13 10:12:29', '52525023'),
(26, 'Q/TO BOOK 300PG  SHORT', 4.8, 3, '&lt;p&gt;300PG SHORT&lt;/p&gt;', 1, '2024-05-13 10:13:26', '52525024'),
(27, 'L SHAPE FOLDER A4 PUTIH', 1.5, 3, 'Folder A4 Putih', 1, '2024-05-13 10:14:22', '52525159'),
(28, 'L SHAPE FOLDER A4  (MIX COLOR)', 1.5, 3, '&lt;p&gt;Folder A4 Mix Collor&lt;/p&gt;', 1, '2024-05-13 10:15:22', '52525060'),
(29, 'MANAGEMENT FILE   BLUE', 1.8, 3, '&lt;p&gt;Management file blue&lt;/p&gt;', 1, '2024-05-13 10:16:21', '52525046'),
(30, 'STICKER - HIGH ALERT - 1000\\''S', 0.08, 3, '&lt;p&gt;1000\\''S&lt;/p&gt;', 1, '2024-05-13 10:17:20', '52520039'),
(31, 'STICKER - HIGH ALERT LASA DRUG - 1000\\''S', 0.08, 3, '&lt;p&gt;High Alert LASA Drug 1000\\''S&lt;/p&gt;', 1, '2024-05-13 10:18:18', '52520124'),
(32, 'STICKER ANTIBIOTIC - 1000\\''S', 0.08, 3, '&lt;p&gt;Sticker Antibiotic - 1000\\''S&lt;/p&gt;', 1, '2024-05-13 10:20:05', '52520040'),
(33, 'STICKER REFRIGERATE - 1000\\''S', 0.08, 3, '&lt;p&gt;Sticker Refrigerate- 1000\\''S&lt;/p&gt;', 1, '2024-05-13 10:21:21', '52520041'),
(34, 'STICKER PRECAUTION DROWSINESS -  1000\\''S', 0.08, 3, '&lt;p&gt;STICKER PRECAUTION DROWSINESS -&amp;nbsp; 1000\\''S&lt;br&gt;&lt;/p&gt;', 1, '2024-05-13 10:22:28', '52520042'),
(35, 'STICKER YELLOW EXPIRY - 1000\\''S ', 0.04, 3, '&lt;p&gt;STICKER YELLOW EXPIRY - 1000\\''S&amp;nbsp;&lt;br&gt;&lt;/p&gt;', 1, '2024-05-13 10:23:57', '52520043'),
(36, 'ENVELOPE 14X17 XRAY (1 BX)', 180, 3, '&lt;p&gt;ENVELOPE 14X17 XRAY (1 BX)&lt;br&gt;&lt;/p&gt;', 1, '2024-05-13 10:24:56', '52520083'),
(37, 'ENVELOPE 10X12 XRAY  (1 BX)', 150, 3, '&lt;p&gt;ENVELOPE 10X12 XRAY&amp;nbsp; (1 BX)&lt;br&gt;&lt;/p&gt;', 1, '2024-05-13 10:26:17', '52520117'),
(38, 'GLOSSY PAPER SZ A4', 10, 3, '&lt;p&gt;GLOSSY PAPER SZ A4&lt;br&gt;&lt;/p&gt;', 1, '2024-05-13 10:27:10', '52525074'),
(39, 'FILE FOLDER PATIENT - WELLNESS', 1.8, 3, '&lt;p&gt;Wellness&lt;/p&gt;', 1, '2024-05-13 10:28:23', '52520166'),
(40, 'APPOINTMENT CARD           ', 0.2, 3, '&lt;p&gt;appointment card&lt;/p&gt;', 1, '2024-05-13 10:30:10', '52520006'),
(41, 'CHARGES  CHECK LIST ', 3, 3, '&lt;p&gt;CHARGES&amp;nbsp; CHECK LIST&amp;nbsp;&lt;br&gt;&lt;/p&gt;', 1, '2024-05-13 10:30:55', '52520007'),
(42, 'CONSENT FOR H.I.V TEST', 3, 3, '&lt;p&gt;CONSENT FOR H.I.V TEST&lt;br&gt;&lt;/p&gt;', 1, '2024-05-13 10:32:09', '52520100'),
(43, 'CONSENT FOR RELEASE OF MEDICAL INFORMATION (MEDICAL REPORT) ', 4.5, 3, '&lt;p&gt;Medical Report&lt;/p&gt;', 1, '2024-05-13 10:33:13', '52520008'),
(44, 'DISCHARGE CARE PLAN', 3, 3, '&lt;p&gt;Discharge Care Plan&lt;/p&gt;', 1, '2024-05-13 10:34:42', '52520009'),
(45, 'GENERAL CONSENT FOR ROUTINE PROCEDURE & TRATMENT', 4.5, 3, '&lt;p&gt;GENERAL CONSENT FOR ROUTINE PROCEDURE &amp;amp; TRATMENT&lt;br&gt;&lt;/p&gt;', 1, '2024-05-13 10:35:34', '52520010'),
(46, 'GENERAL REGISTRATION BOOK (ALL WARD)', 180, 3, 'All Ward', 1, '2024-05-13 10:36:58', '52525014'),
(47, 'REGISTRATION BOOK FOR DELIVERY (MATERNITY)', 150, 3, '&lt;p&gt;Maternity&lt;/p&gt;', 1, '2024-05-13 10:38:11', '52525109'),
(48, 'HEALTH INFORMATION SERVICES-INPATIENT CHECKLIST', 3, 3, '&lt;p&gt;Inpatient Checklist&lt;/p&gt;', 1, '2024-05-13 10:39:05', '52520011'),
(49, 'INFECTION CONTROL - VISUAL INFUSION', 4.5, 3, '&lt;p&gt;Visual Infusion&lt;/p&gt;', 1, '2024-05-13 10:39:54', '52520012'),
(50, 'INPATIENT DISCHARGE FORM', 3, 3, '&lt;p&gt;Discharge Form&lt;/p&gt;', 1, '2024-05-13 10:41:56', '52520013'),
(51, 'INPATIENT ROUTINE MEDICATION FORM', 7.5, 3, '&lt;p&gt;Routine Medication Form&lt;/p&gt;', 1, '2024-05-13 10:43:03', '52520045'),
(52, 'LETTER OF GUARANTEE & INDEMNITY', 12, 3, '&lt;p&gt;Letter Of Guarantee &amp;amp; Indemnity&lt;/p&gt;', 1, '2024-05-13 10:44:47', '52520014'),
(55, 'MORTUARY TAG - RED', 0.6, 3, '&lt;p&gt;Red&lt;/p&gt;', 1, '2024-05-13 10:49:27', '52520120'),
(56, 'MORTUARY TAG - WHITE', 0.6, 3, '&lt;p&gt;White&lt;/p&gt;', 1, '2024-05-13 10:50:17', '52520119'),
(57, 'OPERATION RECORD', 4.5, 3, '&lt;p&gt;Operation Record&lt;/p&gt;', 1, '2024-05-13 10:55:41', '52520046'),
(58, 'PARTIAL SUPPLY NOTE FORM (PART SUPPLY OF PRESCRIPTION FORM)', 5.5, 3, '&lt;p&gt;Part Supply of Prescription Form&lt;/p&gt;', 1, '2024-05-13 10:56:51', '52520047'),
(59, 'PRESCRIPTION FORM', 5.5, 3, '&lt;p&gt;PRESCRIPTION FORM&lt;br&gt;&lt;/p&gt;', 1, '2024-05-13 10:57:52', '52520048'),
(60, 'PROFESSIONAL FEES CHARGE FORM', 5.5, 3, '&lt;p&gt;Professional Fees Charge Form&lt;/p&gt;', 1, '2024-05-13 10:59:15', '52520017'),
(61, 'REGISTRATION BOOK A&E', 150, 3, '&lt;p&gt;Registration Book A&amp;amp;E&lt;/p&gt;', 1, '2024-05-13 11:00:31', '52520049'),
(62, 'PSYCHOTROPIC BOOK OT GREEN', 150, 3, '&lt;p&gt;Psychotropic book OT Green&lt;/p&gt;', 1, '2024-05-13 11:01:23', '52520150'),
(63, 'PSYCHOTROPIC BOOK INJECTION RED', 150, 3, '&lt;p&gt;RED&lt;/p&gt;', 1, '2024-05-13 11:02:24', '52520121'),
(64, 'PSYCHOTROPIC BOOK TABLET BLUE', 150, 3, '&lt;p&gt;Tablet Blue&lt;/p&gt;', 1, '2024-05-13 11:03:29', '52520106'),
(65, 'REGISTRATION FORM ', 3, 3, '&lt;p&gt;Registration Form&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 1, '2024-05-13 11:04:31', '52520050'),
(66, 'TAGGING FORM (NEW)       ', 3, 3, '&lt;p&gt;Tagging Form&amp;nbsp;&lt;/p&gt;', 1, '2024-05-13 11:05:19', '52520018'),
(67, 'TRIAGE FORM', 3, 3, '&lt;p&gt;Triage Form&lt;/p&gt;', 1, '2024-05-13 11:06:09', '52520051'),
(68, 'CONSENT FORM BLOOD COMPONENT TRANSFUSION', 4.5, 3, '&lt;p&gt;Consent Form Blood Component Tranfusion&lt;/p&gt;', 1, '2024-05-13 11:07:19', '52520116'),
(69, 'INTAKE & OUTPUT CHAT', 3, 3, '&lt;p&gt;Intake &amp;amp; Output Chat&lt;/p&gt;', 1, '2024-05-13 11:08:21', '52520052'),
(70, 'ANAESTHETIC RECORD - YELLOW', 6, 3, '&lt;p&gt;Yellow&lt;/p&gt;', 1, '2024-05-13 11:09:26', '52520019'),
(71, 'BOOKING OT ', 180, 3, '&lt;p&gt;Booking OT&lt;/p&gt;', 1, '2024-05-13 11:10:22', '52525015'),
(72, 'REGISTRATION BOOK O.T', 180, 3, '&lt;p&gt;Registration Book O.T&lt;/p&gt;', 1, '2024-05-13 11:11:25', '52520102'),
(73, 'CONSIGNMENT BOOK OT ( CHARGE FORM)', 7, 3, '&lt;p&gt;Charge Form.&lt;/p&gt;', 1, '2024-05-13 11:13:48', '52520000'),
(74, 'PDPA FORM (AKTA PERLINDUNGAN DATA PERIBADI)', 4.3, 3, '&lt;p&gt;PDPA Form&lt;/p&gt;', 1, '2024-05-13 11:17:43', '52520020'),
(75, 'CONSIGNMENT CHARGE FORM', 7, 3, '&lt;p&gt;Consignment Charge Form&lt;/p&gt;', 1, '2024-05-13 11:18:51', '52520000'),
(76, 'PATIENTS PROPERTY FORM', 12, 3, '&lt;p&gt;Patients Property Form&lt;/p&gt;', 1, '2024-05-13 11:19:50', '52520085'),
(77, 'ICU CHART', 1.8, 3, '&lt;p&gt;ICU Chart&lt;/p&gt;', 1, '2024-05-13 11:20:42', '52520096'),
(78, 'MEDICAL CERTIFICATION OF CAUSE OF DEATH', 12, 3, '&lt;p&gt;Medical Certification of Cause of Death&lt;/p&gt;', 1, '2024-05-13 11:21:51', '52370139'),
(79, 'CONTRAST ADMINISTRATION CONSENT FORM', 5, 3, '&lt;p&gt;Contrast Administration Consent Form&lt;/p&gt;', 1, '2024-05-13 11:23:01', '52520155'),
(80, 'MRIÂ SAFETYÂ CHECKLISTÂ &Â PATIENTÂ CONSENTÂ FORM', 3, 3, '&lt;p&gt;MRI Safety Checklist &amp;amp; Patient Consent Form&lt;/p&gt;', 1, '2024-05-13 11:24:08', '52520156'),
(81, 'BORANGÂ PENGESAHAN/DECLARATIONÂ FORMÂ FORÂ WOMEN', 2.5, 3, '&lt;p&gt;Declaration Form For Women&lt;/p&gt;', 1, '2024-05-13 11:25:32', '52520157'),
(82, 'PLAIN ZIPPER 8 X 11 (100\\''S)', 35, 3, '&lt;p&gt;Plain Zipper 8X11 (100\\''S)&lt;/p&gt;', 1, '2024-05-13 11:28:32', '52220271'),
(83, 'AMBER PILL BOX - 2OZ', 70, 4, '&lt;p&gt;size 2 OZ&lt;/p&gt;', 1, '2024-05-13 11:29:39', '52376487'),
(84, 'AMBER PILL BOX - SIZE 4 OZ', 90, 4, '&lt;p&gt;size 4 OZ&lt;/p&gt;', 1, '2024-05-13 11:31:06', '52376488'),
(85, 'RED DISPENSING BOTTLE (ext) 60ML  (100\\''S)', 100, 4, '&lt;p&gt;Red Dispensing Bottle 60ML (100\\''S)&lt;/p&gt;', 1, '2024-05-13 11:32:20', '52220121'),
(86, 'RED DISPENSING BOTTLE (ext) 120ml  (100\\''S)', 160, 4, '&lt;p&gt;Red Dispensing Bottle 120ml (100\\''S)&lt;/p&gt;', 1, '2024-05-13 11:33:14', '52525085'),
(87, 'WHITE DISPENSING BOTTLE (int)- SIZE 60ML (100\\''S)', 85, 4, '&lt;p&gt;White Dispensing Bottle size 60ml (100\\''s)&lt;/p&gt;', 1, '2024-05-13 11:34:24', '52376490'),
(88, 'WHITE DISPENSING BOTTLE (int) SIZE 120ML (100\\''S)', 140, 4, '&lt;p&gt;White Dispensing Bottle size 120ml (100\\''s)&lt;/p&gt;', 1, '2024-05-13 11:35:29', '52376491'),
(89, 'STICKER PHARMACY BLANK ROLL (50 X 85) PHARMASERV', 14.85, 5, '&lt;p&gt;Sticker Pharmacy&lt;/p&gt;', 1, '2024-05-13 11:38:46', '52378278'),
(90, 'PHARMACY TAGGING STICKER DOUBLE RELEASE (1,000\\''S) ', 15, 6, '&lt;p&gt;Pharmacy Tagging Sticker Double Release (1,000\\''s)&lt;/p&gt;', 1, '2024-05-13 11:41:22', '52525155'),
(91, 'PURCHASING TAGGING STICKER BEIGE (2,000\\''S) ', 23, 6, '&lt;p&gt;Purchasing Tagging Sticker Beige (2,000\\''s)&lt;/p&gt;', 1, '2024-05-13 11:42:33', '52525169'),
(92, 'THERMALÂ TRANSFERÂ RIBBONÂ (55MMÂ XÂ 300MM) (50 ROLLS) ', 13, 6, '&lt;p&gt;Thermal Transfer Ribbon (55mm X 300mm) (50 Rolls)&lt;/p&gt;', 1, '2024-05-13 11:44:03', '52525063'),
(93, 'DVD-R (X-RAY) ', 1.3, 7, '&lt;p&gt;DVD-R (X-RAY)&lt;/p&gt;', 1, '2024-05-13 11:45:45', '52520118'),
(94, 'CASING COVER PRINTED ONLY ', 0.6, 7, '&lt;p&gt;Casing Cover Printed Only&lt;/p&gt;', 1, '2024-05-13 11:46:39', '52520037'),
(95, 'ENVELOPE NON WINDOW 4X9     (500\\''S / BX)', 0.12, 8, '&lt;p&gt;Envelope non window 4X9 (500\\''S / BX)&lt;/p&gt;', 1, '2024-05-13 12:00:55', '52520002'),
(96, 'ENVELOPE WITH WINDOW 4X9  (500\\''S / BX)', 0.12, 8, '&lt;p&gt;Envelope with window 4X9 (500\\''S / BX)&lt;/p&gt;', 1, '2024-05-13 12:02:23', '52520003'),
(97, 'ENVELOPE SIZE A4 (250\\''S / BX)', 0.24, 8, '&lt;p&gt;Envelope size A4 (250\\''S / BX)&lt;/p&gt;', 1, '2024-05-13 12:03:29', '52520004'),
(98, 'ENVELOPE SIZE A3 (250\\''S / BX)', 0.3, 8, '&lt;p&gt;Envelope size A3 (250\\''S / BX)&lt;/p&gt;', 1, '2024-05-13 12:04:36', '52520075'),
(100, 'LETTER HEAD PER REAM (500\\''S) ', 0.08, 8, '&lt;p&gt;Letter Head Per Ream (500\\''s)&lt;/p&gt;', 1, '2024-05-13 12:06:42', '52520005'),
(101, 'INK SATO (T102F)        ', 10.3, 8, '&lt;p&gt;Ink sato (T102F)&lt;/p&gt;', 1, '2024-05-13 12:07:49', '52525016'),
(102, 'BATTERY ENEGIZER AA', 2.6, 8, '&lt;p&gt;Battery energizer AA&lt;/p&gt;', 1, '2024-05-13 12:09:00', '52525018'),
(103, 'BATTERY ENEGIZER AAA', 2.6, 8, '&lt;p&gt;Battery Energizer AAA&lt;/p&gt;', 1, '2024-05-13 12:09:58', '52525019'),
(104, 'PATIENT STICKER  (1000\\''S = 1 BX)', 0.1, 8, '&lt;p&gt;Patient Sticker (1000\\''s = 1BX)&lt;/p&gt;', 1, '2024-05-13 12:11:04', '52520069'),
(105, 'STICKER FREEZER (PHARMACY) 1\\''S', 0.12, 8, '&lt;p&gt;Sticker Freezer (Pharmacy) 1\\''s&lt;/p&gt;', 1, '2024-05-13 12:12:12', '52520144'),
(106, 'STICKER DRUG ADMINISTRATION (ALL WARD) 500\\''S', 0.18, 8, '&lt;p&gt;Sticker drug administration (all ward) 500\\''s&lt;/p&gt;', 1, '2024-05-13 12:13:27', '52520070'),
(107, 'STICKER DATE OPEN MULTI-DOSE (ALL WARD) 500\\''S', 0.15, 8, '&lt;p&gt;Sticker date open multi-dose (all ward) 500\\''s&lt;/p&gt;', 1, '2024-05-13 12:14:52', '52520071'),
(108, 'THERMAL STICKER A&E', 12, 8, '&lt;p&gt;Thermal sticker A&amp;amp;E&lt;/p&gt;', 1, '2024-05-13 12:17:19', '52525017'),
(109, 'BLUE FOLDER (CASE NOTE) CONFIDENTIAL FILE ', 0.85, 8, '&lt;p&gt;Blue folder (case note)&amp;nbsp;&lt;/p&gt;', 1, '2024-05-13 12:18:16', '52520145'),
(110, 'ANAESTHESIA DISCLOSURE  AND CONSENT', 4.5, 8, '&lt;p&gt;Anaesthesia disclosure and consent&lt;/p&gt;', 1, '2024-05-13 12:20:03', '52520053'),
(111, 'ADMISSION FORM', 12, 8, '&lt;p&gt;Admission form&lt;/p&gt;', 1, '2024-05-13 12:20:56', '52520055'),
(114, 'INPATIENT/RELATIVE ORIENTATION CHECK LIST', 8.8, 8, '&lt;p&gt;Inpatient/Relative orientation check list&lt;/p&gt;', 1, '2024-05-13 12:27:27', '52520057'),
(115, 'OPERATION THEATRE TIME', 4.5, 8, '&lt;p&gt;Operation theatre time&lt;/p&gt;', 1, '2024-05-13 12:28:21', '52520058'),
(116, 'NURSING ASSESSMENT PLANNING', 9, 8, '&lt;p&gt;Nursing assessment planning&lt;/p&gt;', 1, '2024-05-13 12:29:07', '52520059'),
(117, 'OT DEPARTURE FORM CLINICAL BEST PRACTICES', 6.2, 8, '&lt;p&gt;OT departure form clinical best practices&lt;/p&gt;', 1, '2024-05-13 12:30:29', '52520078'),
(118, 'OT PRE-OP & SURGICAL SAFETY CHECKLIST (ALLWARD)', 4.5, 8, '&lt;p&gt;OT Pre-OP &amp;amp; Surgical Safety Checklist (AllWard)&lt;/p&gt;', 1, '2024-05-13 12:32:08', '52520060'),
(119, 'OT RECOVERY (PRE-DISCHARGE CHECKLIST FORM)', 4.5, 8, '&lt;p&gt;Pre-Discharge Checklist Form&lt;/p&gt;', 1, '2024-05-13 12:33:42', '52520061'),
(120, 'OT ENDOSCOPY INTRA-PROCEDURE ASSESSMENT', 3, 8, '&lt;p&gt;OT endoscopy intra-procedure assessment&lt;/p&gt;', 1, '2024-05-13 12:34:51', '52520079'),
(121, 'FOLLOW UP SHEET FOR GUARANTEE ', 4.5, 8, '&lt;p&gt;Follow up sheet for guarantee&lt;/p&gt;', 1, '2024-05-13 12:35:50', '52520062'),
(122, 'REQUEST FOR ROOM OF CHOICE', 3, 8, '&lt;p&gt;Request for room of choice&lt;/p&gt;', 1, '2024-05-13 12:36:48', '52520132'),
(123, 'REQUISITION OF GUARANTEE LETTER', 4.8, 8, '&lt;p&gt;Requisition of Guarantee Letter&amp;nbsp;&lt;/p&gt;', 1, '2024-05-13 12:38:19', '52520063'),
(124, 'INPATIENT-MEDICATION REFUND NOTE', 5.5, 8, '&lt;p&gt;Inpatient-Medication Refund Note&lt;/p&gt;', 1, '2024-05-13 12:39:19', '52520016'),
(125, 'A&E CHARGE FORM', 3, 8, '&lt;p&gt;A&amp;amp;E Charge Form&lt;/p&gt;', 1, '2024-05-13 12:40:16', '52520080'),
(126, 'CSSD CHARGE FORM', 8.8, 8, '&lt;p&gt;CSSD Charge Form&lt;/p&gt;', 1, '2024-05-13 12:41:47', '52520065'),
(127, 'OPERATION EQUIPMENT CHARGES FORM', 8.8, 8, '&lt;p&gt;Operation equipment charges form&lt;/p&gt;', 1, '2024-05-13 12:42:56', '52520087'),
(128, 'NURSING PROCEDURE CHARGE FORM ', 4.5, 8, '&lt;p&gt;Nursing procedure charge form&lt;/p&gt;', 1, '2024-05-13 12:43:55', '52520066'),
(129, 'NURSING GENERAL EQUIPMENT CHARGES', 3, 8, '&lt;p&gt;Nursing general equipment charges&lt;/p&gt;', 1, '2024-05-13 12:44:56', '52520067'),
(130, 'ASSIST DR PROSEDURE CHARGES FORM', 4.5, 8, '&lt;p&gt;Assist DR procedure charges form&lt;/p&gt;', 1, '2024-05-13 12:46:12', '52520068'),
(133, 'ICU CHARGES FORM', 3, 8, '&lt;p&gt;ICU charges form&lt;/p&gt;', 1, '2024-05-13 12:51:41', '52520123'),
(134, 'INFORMED CONSENT', 8.8, 8, '&lt;p&gt;Informed consent&lt;/p&gt;', 1, '2024-05-13 12:52:26', '52520074'),
(135, 'ADULT OBSERVATION CHART (EWS)', 13.8, 8, '&lt;p&gt;Adult observation chart (EWS)&lt;/p&gt;', 1, '2024-05-13 12:53:39', '52520092'),
(136, 'DENGUE CHART', 11.8, 8, '&lt;p&gt;Dengue chart&lt;/p&gt;', 1, '2024-05-13 12:54:30', '52520093'),
(137, 'DENGUE ASSESSMENT CHECKLIST', 8.9, 8, '&lt;p&gt;Dengue assessment checklist&lt;/p&gt;', 1, '2024-05-13 12:55:18', '52520094'),
(138, 'BLOOD PRODUCT TRANSFUSION CHECKLIST', 4.5, 8, '&lt;p&gt;Blood product transfusion checklist&lt;/p&gt;', 1, '2024-05-13 12:56:34', '52520095'),
(139, 'NOTIFICATION OF COMMUNICABLE DISEASES - FONT YELLOW', 12, 8, '&lt;p&gt;Notification of communicable diseases - font yellow&lt;/p&gt;', 1, '2024-05-13 12:57:42', '52520086'),
(140, 'PHYSIO OUTPATIENT FORM', 12, 8, '&lt;p&gt;Physio outpatient form&amp;nbsp;&lt;/p&gt;', 1, '2024-05-13 14:07:34', '52520158'),
(141, 'ANTENATAL BOOK ', 0.85, 8, '&lt;p&gt;Antenatal book&lt;/p&gt;', 1, '2024-05-13 14:08:35', '52520098'),
(142, 'BABY RECORD BOOK', 8, 8, '&lt;p&gt;Baby record book&lt;/p&gt;', 1, '2024-05-13 14:09:22', '52520088'),
(143, 'APPOINTMENT BOOK PHYSIO', 80, 8, '&lt;p&gt;Appointment book physio&lt;/p&gt;', 1, '2024-05-13 14:10:08', '52520105'),
(144, 'COLOUR SIMILI A4 PAPER  BLUE  (500\\''S / REAMS)', 0.032, 3, '&lt;p&gt;Colour simili A4 Paper Blue (500\\''s / Reams)&lt;/p&gt;', 1, '2024-05-13 14:12:03', '52525009'),
(145, 'COLOUR SIMILI A4 PAPER  PINK   (500\\''S / REAMS)', 0.032, 3, '&lt;p&gt;Colour simili A4 paper pink (500\\''s / reams)&lt;/p&gt;', 1, '2024-05-13 14:13:26', '52525010'),
(146, 'COLOUR SIMILI A4 PAPER  GREEN   (500\\''S / REAMS)', 0.032, 3, '&lt;p&gt;Colour simili A4 paper green (500\\''s/reams)&lt;/p&gt;', 1, '2024-05-13 14:14:37', '52525011'),
(147, 'COLOUR SIMILI A4 PAPER  YELLOW   (500\\''S / REAMS)', 0.032, 3, '&lt;p&gt;Colour simili A4 paper yellow (500\\''s / reams)&lt;/p&gt;', 1, '2024-05-13 14:15:51', '52525012'),
(148, 'COLOUR SIMILI A4 PAPER  ORANGE   (500\\''S / REAMS)', 0.032, 3, '&lt;p&gt;Colour simili A4 paper orange (500\\''s / reams)&lt;/p&gt;', 1, '2024-05-13 14:16:48', '52525013'),
(149, 'COLOUR SIMILI A4 PAPER  PEACH    (500\\''S / REAMS)', 0.032, 3, '&lt;p&gt;Colour simili A4 paper peach (500\\''s / reams)&lt;/p&gt;', 1, '2024-05-13 14:18:02', '52525028'),
(150, 'DOCUMENT PLASTIC 16CM X 26CM   ', 8, 3, '&lt;p&gt;Document plastic 16cm X 26cm&lt;/p&gt;', 1, '2024-05-13 14:19:06', '52525064'),
(151, 'TREASURY TAGS (TALI HIJAU)', 7.5, 3, '&lt;p&gt;Treasury tags (tali hijau)&lt;/p&gt;', 1, '2024-05-13 14:19:49', '52525042'),
(152, 'ARTLINE MARKER PEN 70       BLACK', 2.9, 3, '&lt;p&gt;ARTLINE MARKER PEN 70&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;BLACK&lt;br&gt;&lt;/p&gt;', 1, '2024-06-10 10:39:44', '52525043'),
(153, 'ARTLINE MARKER PEN 70       BLUE', 2.9, 3, '&lt;p&gt;ARTLINE MARKER PEN 70&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;BLUE&lt;br&gt;&lt;/p&gt;', 1, '2024-06-10 10:41:46', '52520089'),
(154, 'ARTLINE MARKER PEN 70       RED', 2.9, 3, '&lt;p&gt;ARTLINE MARKER PEN 70&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;RED&lt;br&gt;&lt;/p&gt;', 1, '2024-06-10 10:43:28', '52520090'),
(155, 'Test', 12, 6, '&lt;p&gt;Test&lt;/p&gt;', 1, '2024-06-11 10:41:29', '0145'),
(156, 'QMS ROLL', 4.5, 3, '&lt;p&gt;qms roll&amp;nbsp;&lt;/p&gt;', 1, '2024-06-12 10:36:38', '52525032');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
`id` int(11) NOT NULL,
  `department` text CHARACTER SET utf8mb4 NOT NULL,
  `total_amount` float NOT NULL,
  `status` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `confirm` tinyint(1) NOT NULL,
  `request` varchar(250) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `department`, `total_amount`, `status`, `user_id`, `order_date`, `confirm`, `request`) VALUES
(2, '', 0, 0, 7, '2024-05-28 09:25:23', 0, ''),
(3, 'IT', 0, 0, 7, '2024-05-28 09:25:28', 0, ''),
(4, '', 0, 0, 7, '2024-05-28 09:33:18', 0, ''),
(5, '', 0, 0, 7, '2024-05-28 09:37:37', 1, ''),
(6, '', 0, 0, 7, '2024-05-28 09:48:02', 0, ''),
(7, '', 0, 0, 7, '2024-05-28 10:32:09', 0, ''),
(8, '', 0, 0, 7, '2024-05-28 10:41:55', 0, ''),
(9, '', 0, 0, 7, '2024-05-28 10:42:15', 0, ''),
(10, '', 0, 0, 7, '2024-05-28 12:40:18', 0, ''),
(11, '', 0, 0, 7, '2024-05-28 12:40:40', 0, ''),
(12, '', 0, 0, 7, '2024-05-28 12:40:47', 0, ''),
(13, '', 0, 0, 7, '2024-05-28 12:42:19', 0, 'confirm'),
(14, '', 0, 0, 7, '2024-05-28 12:42:20', 0, 'confirm'),
(15, '', 0, 0, 7, '2024-05-28 12:45:00', 0, 'confirm'),
(16, '', 0, 0, 7, '2024-05-28 12:56:05', 0, ''),
(17, '', 0, 0, 7, '2024-05-28 14:06:18', 0, ''),
(18, '', 0, 0, 7, '2024-05-28 14:10:32', 0, ''),
(19, '', 0, 0, 7, '2024-05-28 14:20:39', 0, ''),
(20, '', 0, 0, 7, '2024-05-28 14:20:43', 0, ''),
(21, '', 0, 0, 7, '2024-05-28 14:21:24', 0, ''),
(22, '', 0, 0, 8, '2024-05-29 09:32:57', 0, ''),
(23, '', 0, 0, 8, '2024-05-29 09:35:24', 0, ''),
(24, '', 0, 0, 8, '2024-05-29 10:36:10', 0, ''),
(27, '', 0, 0, 8, '2024-05-29 11:25:31', 0, ''),
(28, '', 0, 0, 8, '2024-05-29 12:05:30', 0, ''),
(29, '', 0, 0, 8, '2024-05-29 12:35:35', 0, 'confirm'),
(30, '', 0, 0, 8, '2024-05-29 12:46:57', 0, 'confirm'),
(31, '', 0, 0, 8, '2024-05-29 14:26:18', 0, 'confirm'),
(32, '', 0, 0, 8, '2024-05-29 14:39:13', 0, 'confirm'),
(33, '', 0, 0, 8, '2024-05-29 14:49:12', 0, '0'),
(35, 'purchasing', 0, 0, 8, '2024-05-29 15:01:21', 0, 'confirm'),
(36, '', 0, 0, 8, '2024-05-29 15:46:25', 0, 'confirm'),
(39, '', 0, 0, 7, '2024-05-31 10:47:49', 0, 'confirm'),
(40, '', 11.8, 0, 7, '2024-05-31 10:58:57', 0, 'confirm'),
(41, 'purchasing', 1235.1, 1, 8, '2024-06-01 08:50:16', 1, 'confirm'),
(42, 'Purchasing', 0.032, 0, 8, '2024-06-04 12:43:50', 0, 'confirm'),
(43, 'IT', 80, 0, 7, '2024-06-19 12:04:38', 0, 'confirm'),
(45, 'IT', 5.2, 0, 9, '2024-06-21 10:54:37', 0, 'confirm'),
(46, '', 23.12, 0, 9, '2024-06-21 11:14:15', 0, 'confirm');

-- --------------------------------------------------------

--
-- Table structure for table `order_list`
--

CREATE TABLE IF NOT EXISTS `order_list` (
`id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(30) NOT NULL,
  `price` double NOT NULL,
  `total` double NOT NULL,
  `vendor_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_list`
--

INSERT INTO `order_list` (`id`, `order_id`, `item_id`, `quantity`, `price`, `total`, `vendor_id`) VALUES
(1, 7, 3, 1, 9.9, 9.9, 0),
(2, 7, 148, 1, 0.032, 0.032, 0),
(3, 9, 2, 1, 123, 123, 0),
(4, 17, 2, 1, 123, 123, 0),
(5, 18, 2, 1, 123, 123, 0),
(6, 19, 2, 1, 123, 123, 0),
(7, 21, 2, 1, 123, 123, 0),
(14, 27, 80, 1, 3, 3, 0),
(15, 27, 100, 1, 0.08, 0.08, 0),
(16, 28, 141, 1, 0.85, 0.85, 0),
(17, 29, 73, 1, 7, 7, 0),
(18, 30, 2, 1, 123, 123, 0),
(19, 31, 23, 1, 4.8, 4.8, 0),
(20, 32, 30, 1, 0.08, 0.08, 0),
(21, 33, 103, 1, 2.6, 2.6, 0),
(22, 34, 98, 1, 0.3, 0.3, 0),
(23, 35, 109, 1, 0.85, 0.85, 0),
(24, 36, 111, 1, 12, 12, 0),
(31, 39, 2, 1, 123, 123, 0),
(32, 39, 120, 1, 3, 3, 0),
(33, 39, 123, 1, 4.8, 4.8, 0),
(34, 40, 136, 1, 11.8, 11.8, 0),
(35, 41, 5, 1, 7.5, 7.5, 0),
(36, 41, 3, 124, 9.9, 1227.6000000000001, 0),
(37, 42, 147, 1, 0.032, 0.032, 0),
(38, 43, 143, 1, 80, 80, 0),
(40, 45, 102, 2, 2.6, 5.2, 0),
(41, 46, 95, 1, 0.12, 0.12, 0),
(42, 46, 91, 1, 23, 23, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE IF NOT EXISTS `sales` (
`id` int(11) NOT NULL,
  `total_amount` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `total_amount`, `date_created`, `order_id`) VALUES
(1, 0, '2024-05-29 11:25:31', 27),
(2, 0, '2024-05-29 12:05:30', 28),
(3, 0, '2024-05-29 12:35:35', 29),
(4, 0, '2024-05-29 12:46:57', 30),
(5, 0, '2024-05-29 14:26:18', 31),
(6, 0, '2024-05-29 14:39:13', 32),
(7, 0, '2024-05-29 14:49:12', 33),
(8, 0, '2024-05-29 14:51:17', 34),
(9, 0, '2024-05-29 15:01:21', 35),
(10, 0, '2024-05-29 15:46:25', 36),
(11, 130.8, '2024-05-31 10:47:49', 39),
(12, 11.8, '2024-05-31 10:58:57', 40),
(13, 1235.1, '2024-06-01 08:50:16', 41),
(14, 0.032, '2024-06-04 12:43:50', 42),
(15, 80, '2024-06-19 12:04:38', 43),
(17, 5.2, '2024-06-21 10:54:37', 45),
(18, 23.12, '2024-06-21 11:14:15', 46);

-- --------------------------------------------------------

--
-- Table structure for table `summary`
--

CREATE TABLE IF NOT EXISTS `summary` (
`id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `total_quantity` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE IF NOT EXISTS `system_info` (
`id` int(11) NOT NULL,
  `meta_field` text CHARACTER SET utf8mb4 NOT NULL,
  `meta_value` text CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Stationery'),
(2, 'short_name', 'stationery'),
(3, 'logo', 'uploads/kpjLogo.png'),
(4, 'user_avatar', 'uploads/user_image.png'),
(5, 'cover', 'uploads/tidy-office-desk-feature.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(250) NOT NULL,
  `user_level` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `last_login` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `department` text CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `user_level`, `status`, `last_login`, `department`) VALUES
(7, 'IT', 'IT', 'ab6ffb571395465f5558740d7f3f2efe', 1, 1, '2024-04-30 09:34:59', 'IT'),
(8, 'purchasing', 'purchasing', 'eca945ce3e670c619ae34839729dd7c7', 2, 1, '2024-04-30 12:03:54', 'Purchasing'),
(9, 'test', 'test', '13bade984aa416220470ca3f82bf5fb8', 3, 1, '2024-05-07 10:30:40', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE IF NOT EXISTS `user_groups` (
`id` int(11) NOT NULL,
  `group_name` varchar(200) NOT NULL,
  `group_level` int(11) NOT NULL,
  `group_status` int(1) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `group_name`, `group_level`, `group_status`, `date_created`) VALUES
(1, 'Purchasing', 2, 1, '0000-00-00 00:00:00'),
(2, 'IT', 1, 1, '0000-00-00 00:00:00'),
(8, 'Guest', 3, 1, '2024-04-30 08:48:54'),
(9, 'account', 3, 1, '2024-05-08 10:32:20'),
(10, 'test', 3, 1, '2024-05-10 16:17:06');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE IF NOT EXISTS `vendors` (
`id` int(11) NOT NULL,
  `name` varchar(260) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `name`, `status`, `date_created`) VALUES
(3, 'KASHIFA', 1, '2024-05-10 16:39:00'),
(4, 'INFAST', 1, '2024-05-10 16:39:26'),
(5, 'PHARMASERV', 1, '2024-05-10 16:39:41'),
(6, 'CG RIBAND', 1, '2024-05-10 16:39:55'),
(7, 'DANAU RESOURCES', 1, '2024-05-10 16:40:10'),
(8, 'C&B', 1, '2024-05-10 16:40:35'),
(9, '', 0, '2024-06-21 10:46:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_list`
--
ALTER TABLE `order_list`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `summary`
--
ALTER TABLE `summary`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=158;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `order_list`
--
ALTER TABLE `order_list`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `summary`
--
ALTER TABLE `summary`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
