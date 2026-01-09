-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2026 at 06:20 PM
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
-- Database: `nukscholarship`
--

-- --------------------------------------------------------

--
-- Table structure for table `使用者`
--

CREATE TABLE `使用者` (
  `姓名` varchar(255) DEFAULT NULL,
  `種類` varchar(255) DEFAULT NULL,
  `帳號` varchar(255) NOT NULL,
  `密碼` varchar(255) DEFAULT NULL,
  `電話` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `身分證ID` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `使用者`
--

INSERT INTO `使用者` (`姓名`, `種類`, `帳號`, `密碼`, `電話`, `email`, `身分證ID`) VALUES
('石督鄧', '學生', 'a1125500', '1234', '0800092000', 'test@mail.com', 'S123456789'),
('林小明', '學生', 'a1125501', '1234', '0900000001', 'a1125501@mail.com', 'S123456780'),
('王小華', '學生', 'a1125502', '1234', '0900000002', 'a1125502@mail.com', 'S123456781'),
('陳小美', '學生', 'a1125503', '1234', '0900000003', 'a1125503@mail.com', 'S123456782'),
('李小強', '學生', 'a1125504', '1234', '0900000004', 'a1125504@mail.com', 'S123456783'),
('艾德明', '系統管理員', 'admin001', 'admin', '0911000001', 'admin@nuk.edu.tw', 'A111111111'),
('艾德明二', '系統管理員', 'admin002', 'admin', '0911000002', 'admin002@nuk.edu.tw', 'A111111112'),
('艾德明三', '系統管理員', 'admin003', 'admin', '0911000003', 'admin003@nuk.edu.tw', 'A111111113'),
('艾德明四', '系統管理員', 'admin004', 'admin', '0911000004', 'admin004@nuk.edu.tw', 'A111111114'),
('艾德明五', '系統管理員', 'admin005', 'admin', '0911000005', 'admin005@nuk.edu.tw', 'A111111115'),
('普白德基金會', '獎助單位', 'org0001', 'orgpw', '0911000003', 'org@foundation.org', 'C333333333'),
('普白德基金會二', '獎助單位', 'org0002', 'orgpw', '0911000022', 'org0002@foundation.org', 'C333333334'),
('普白德基金會三', '獎助單位', 'org0003', 'orgpw', '0911000023', 'org0003@foundation.org', 'C333333335'),
('普白德基金會四', '獎助單位', 'org0004', 'orgpw', '0911000024', 'org0004@foundation.org', 'C333333336'),
('普白德基金會五', '獎助單位', 'org0005', 'orgpw', '0911000025', 'org0005@foundation.org', 'C333333337'),
('剖菲瑟', '老師', 't0001', 'teach', '0911000002', 'teacher@nuk.edu.tw', 'B222222222'),
('剖菲瑟二', '老師', 't0002', 'teach', '0911000012', 't0002@nuk.edu.tw', 'B222222223'),
('剖菲瑟三', '老師', 't0003', 'teach', '0911000013', 't0003@nuk.edu.tw', 'B222222224'),
('剖菲瑟四', '老師', 't0004', 'teach', '0911000014', 't0004@nuk.edu.tw', 'B222222225'),
('剖菲瑟五', '老師', 't0005', 'teach', '0911000015', 't0005@nuk.edu.tw', 'B222222226');

-- --------------------------------------------------------

--
-- Table structure for table `公告`
--

CREATE TABLE `公告` (
  `公告編號` varchar(255) NOT NULL,
  `日期` varchar(255) DEFAULT NULL,
  `內容` varchar(5000) DEFAULT NULL,
  `管理員帳號` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `公告`
--

INSERT INTO `公告` (`公告編號`, `日期`, `內容`, `管理員帳號`) VALUES
('N001', '2026-01-06', '測試公告', 'admin001'),
('N002', '2026-01-07', '獎學金申請系統已上線，請同學依期限完成申請。', 'admin001'),
('N003', '2026-01-08', '提醒：請確認個人資料與成績單上傳。', 'admin002'),
('N004', '2026-01-09', '提醒：推薦信截止日將至，請老師協助。', 'admin003'),
('N005', '2026-01-10', '公告：審查結果將於本週公布。', 'admin004');

-- --------------------------------------------------------

--
-- Table structure for table `學生`
--

CREATE TABLE `學生` (
  `系所` varchar(255) DEFAULT NULL,
  `學號` varchar(255) DEFAULT NULL,
  `學生帳號` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `學生`
--

INSERT INTO `學生` (`系所`, `學號`, `學生帳號`) VALUES
('資工', 'a1125500', 'a1125500'),
('資工', 'a1125501', 'a1125501'),
('電機', 'a1125502', 'a1125502'),
('資管', 'a1125503', 'a1125503'),
('應數', 'a1125504', 'a1125504');

-- --------------------------------------------------------

--
-- Table structure for table `審查`
--

CREATE TABLE `審查` (
  `初審日期` varchar(255) DEFAULT NULL,
  `初審結果` varchar(255) DEFAULT NULL,
  `複審日期` varchar(255) DEFAULT NULL,
  `是否核准` varchar(255) DEFAULT NULL,
  `獎助單位帳號` varchar(255) NOT NULL,
  `申請編號` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `審查`
--

INSERT INTO `審查` (`初審日期`, `初審結果`, `複審日期`, `是否核准`, `獎助單位帳號`, `申請編號`) VALUES
('2026-01-07', '通過', '2026-01-10', '是', 'org0001', 'APP0001'),
('2026-01-08', '通過', '2026-01-11', '是', 'org0002', 'APP0002'),
('2026-01-08', '補件', '2026-01-12', '否', 'org0003', 'APP0003'),
('2026-01-09', '通過', '2026-01-12', '是', 'org0004', 'APP0004'),
('2026-01-09', '通過', '2026-01-13', '是', 'org0005', 'APP0005');

-- --------------------------------------------------------

--
-- Table structure for table `成績單`
--

CREATE TABLE `成績單` (
  `成績單編號` varchar(255) NOT NULL,
  `學期` varchar(255) DEFAULT NULL,
  `學分數` varchar(255) DEFAULT NULL,
  `排名` varchar(255) DEFAULT NULL,
  `學業平均` varchar(255) DEFAULT NULL,
  `GPA` varchar(255) DEFAULT NULL,
  `學生帳號` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `成績單`
--

INSERT INTO `成績單` (`成績單編號`, `學期`, `學分數`, `排名`, `學業平均`, `GPA`, `學生帳號`) VALUES
('TRN-a1125500-2025-1', '2025-1', '18', '10', '85', '3.6', 'a1125500'),
('TRN-a1125501-2025-1', '2025-1', '19', '8', '88', '3.7', 'a1125501'),
('TRN-a1125502-2025-1', '2025-1', '20', '12', '82', '3.4', 'a1125502'),
('TRN-a1125503-2025-1', '2025-1', '18', '6', '90', '3.8', 'a1125503'),
('TRN-a1125504-2025-1', '2025-1', '17', '15', '80', '3.2', 'a1125504');

-- --------------------------------------------------------

--
-- Table structure for table `有`
--

CREATE TABLE `有` (
  `成績單編號` varchar(255) NOT NULL,
  `課堂編號` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `有`
--

INSERT INTO `有` (`成績單編號`, `課堂編號`) VALUES
('TRN-a1125500-2025-1', 'CS101'),
('TRN-a1125501-2025-1', 'CS102'),
('TRN-a1125502-2025-1', 'CS103'),
('TRN-a1125503-2025-1', 'CS104'),
('TRN-a1125504-2025-1', 'CS105');

-- --------------------------------------------------------

--
-- Table structure for table `推薦信`
--

CREATE TABLE `推薦信` (
  `內容` varchar(5000) DEFAULT NULL,
  `日期` varchar(255) DEFAULT NULL,
  `老師帳號` varchar(255) NOT NULL,
  `申請編號` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `推薦信`
--

INSERT INTO `推薦信` (`內容`, `日期`, `老師帳號`, `申請編號`) VALUES
('該生學習態度認真，具備良好問題解決能力，並在課堂專題表現優異，特此推薦。', '2026-01-05', 't0001', 'APP0001'),
('該生表現穩定且積極向學，遇到困難能主動求助並完成任務，推薦申請。', '2026-01-06', 't0002', 'APP0002'),
('該生對研究具熱忱，能獨立思考並完成專題成果，具有潛力，推薦申請。', '2026-01-06', 't0003', 'APP0003'),
('該生服務精神佳，能帶領團隊並完成服務計畫，值得鼓勵，推薦申請。', '2026-01-07', 't0004', 'APP0004'),
('該生具備良好外語能力與學習規劃，對國際交流有明確目標，推薦申請。', '2026-01-07', 't0005', 'APP0005');

-- --------------------------------------------------------

--
-- Table structure for table `獎助單位`
--

CREATE TABLE `獎助單位` (
  `聯絡人` varchar(255) DEFAULT NULL,
  `名稱` varchar(255) DEFAULT NULL,
  `獎助單位帳號` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `獎助單位`
--

INSERT INTO `獎助單位` (`聯絡人`, `名稱`, `獎助單位帳號`) VALUES
('林基金會窗口', '林氏教育基金會', 'org0001'),
('張基金會窗口', '張氏教育基金會', 'org0002'),
('王基金會窗口', '王氏教育基金會', 'org0003'),
('陳基金會窗口', '陳氏教育基金會', 'org0004'),
('李基金會窗口', '李氏教育基金會', 'org0005');

-- --------------------------------------------------------

--
-- Table structure for table `獎學金`
--

CREATE TABLE `獎學金` (
  `名稱` varchar(255) NOT NULL,
  `補助金額` varchar(255) DEFAULT NULL,
  `期限` varchar(255) DEFAULT NULL,
  `名額` varchar(255) DEFAULT NULL,
  `獎助單位帳號` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `獎學金`
--

INSERT INTO `獎學金` (`名稱`, `補助金額`, `期限`, `名額`, `獎助單位帳號`) VALUES
('優秀獎學金', '10000', '2026-12-31', '10', 'org0001'),
('國際交流獎學金', '20000', '2026-08-31', '5', 'org0005'),
('服務學習獎學金', '8000', '2026-09-30', '15', 'org0004'),
('清寒助學金', '12000', '2026-11-30', '20', 'org0002'),
('研究獎助金', '15000', '2026-10-31', '8', 'org0003');

-- --------------------------------------------------------

--
-- Table structure for table `獎學金_條件`
--

CREATE TABLE `獎學金_條件` (
  `條件` varchar(255) NOT NULL,
  `名稱` varchar(255) NOT NULL,
  `獎助單位帳號` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `獎學金_條件`
--

INSERT INTO `獎學金_條件` (`條件`, `名稱`, `獎助單位帳號`) VALUES
('GPA>=3.5', '優秀獎學金', 'org0001'),
('具研究成果或專題', '研究獎助金', 'org0003'),
('具英文能力證明', '國際交流獎學金', 'org0005'),
('家境清寒證明', '清寒助學金', 'org0002'),
('服務時數>=40', '服務學習獎學金', 'org0004');

-- --------------------------------------------------------

--
-- Table structure for table `申請資料`
--

CREATE TABLE `申請資料` (
  `自傳` varchar(5000) DEFAULT NULL,
  `申請日期` varchar(255) DEFAULT NULL,
  `申請編號` varchar(255) NOT NULL,
  `學生帳號` varchar(255) DEFAULT NULL,
  `名稱` varchar(255) DEFAULT NULL,
  `獎助單位帳號` varchar(255) DEFAULT NULL,
  `成績單編號` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `申請資料`
--

INSERT INTO `申請資料` (`自傳`, `申請日期`, `申請編號`, `學生帳號`, `名稱`, `獎助單位帳號`, `成績單編號`) VALUES
('我熱心學習並積極參與專題與競賽，期望申請此獎學金以支持學業發展。', '2026-01-06', 'APP0001', 'a1125500', '優秀獎學金', 'org0001', 'TRN-a1125500-2025-1'),
('我家境較困難，但仍努力維持學業表現，希望能獲得助學金。', '2026-01-07', 'APP0002', 'a1125501', '清寒助學金', 'org0002', 'TRN-a1125501-2025-1'),
('我有參與專題研究與成果發表，想申請研究相關獎助。', '2026-01-07', 'APP0003', 'a1125502', '研究獎助金', 'org0003', 'TRN-a1125502-2025-1'),
('我長期投入志工服務並累積服務時數，期望申請服務學習獎學金。', '2026-01-08', 'APP0004', 'a1125503', '服務學習獎學金', 'org0004', 'TRN-a1125503-2025-1'),
('我想申請出國交流，並已準備英文能力證明與學習計畫。', '2026-01-08', 'APP0005', 'a1125504', '國際交流獎學金', 'org0005', 'TRN-a1125504-2025-1');

-- --------------------------------------------------------

--
-- Table structure for table `監護人`
--

CREATE TABLE `監護人` (
  `身分證ID` varchar(255) NOT NULL,
  `姓名` varchar(255) DEFAULT NULL,
  `關係` varchar(255) DEFAULT NULL,
  `學生帳號` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `監護人`
--

INSERT INTO `監護人` (`身分證ID`, `姓名`, `關係`, `學生帳號`) VALUES
('D444444444', '葛迪恩', '父', 'a1125500'),
('D444444445', '林爸爸', '父', 'a1125501'),
('D444444446', '王媽媽', '母', 'a1125502'),
('D444444447', '陳叔叔', '叔', 'a1125503'),
('D444444448', '李阿姨', '姨', 'a1125504');

-- --------------------------------------------------------

--
-- Table structure for table `科目`
--

CREATE TABLE `科目` (
  `種類` varchar(255) DEFAULT NULL,
  `分數` varchar(255) DEFAULT NULL,
  `課堂名稱` varchar(255) DEFAULT NULL,
  `課堂編號` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `科目`
--

INSERT INTO `科目` (`種類`, `分數`, `課堂名稱`, `課堂編號`) VALUES
('必修', '90', '資料結構', 'CS101'),
('必修', '86', '計算機網路', 'CS102'),
('選修', '88', '資料庫系統', 'CS103'),
('必修', '84', '作業系統', 'CS104'),
('選修', '92', '資訊安全導論', 'CS105');

-- --------------------------------------------------------

--
-- Table structure for table `系統管理員`
--

CREATE TABLE `系統管理員` (
  `管理員帳號` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `系統管理員`
--

INSERT INTO `系統管理員` (`管理員帳號`) VALUES
('admin001'),
('admin002'),
('admin003'),
('admin004'),
('admin005');

-- --------------------------------------------------------

--
-- Table structure for table `老師`
--

CREATE TABLE `老師` (
  `科系` varchar(255) DEFAULT NULL,
  `老師帳號` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `老師`
--

INSERT INTO `老師` (`科系`, `老師帳號`) VALUES
('資工', 't0001'),
('資工', 't0002'),
('電機', 't0003'),
('資管', 't0004'),
('應數', 't0005');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `使用者`
--
ALTER TABLE `使用者`
  ADD PRIMARY KEY (`帳號`);

--
-- Indexes for table `公告`
--
ALTER TABLE `公告`
  ADD PRIMARY KEY (`公告編號`),
  ADD KEY `管理員帳號` (`管理員帳號`);

--
-- Indexes for table `學生`
--
ALTER TABLE `學生`
  ADD PRIMARY KEY (`學生帳號`);

--
-- Indexes for table `審查`
--
ALTER TABLE `審查`
  ADD PRIMARY KEY (`獎助單位帳號`,`申請編號`),
  ADD KEY `申請編號` (`申請編號`);

--
-- Indexes for table `成績單`
--
ALTER TABLE `成績單`
  ADD PRIMARY KEY (`成績單編號`),
  ADD KEY `學生帳號` (`學生帳號`);

--
-- Indexes for table `有`
--
ALTER TABLE `有`
  ADD PRIMARY KEY (`成績單編號`,`課堂編號`),
  ADD KEY `課堂編號` (`課堂編號`);

--
-- Indexes for table `推薦信`
--
ALTER TABLE `推薦信`
  ADD PRIMARY KEY (`老師帳號`,`申請編號`),
  ADD KEY `申請編號` (`申請編號`);

--
-- Indexes for table `獎助單位`
--
ALTER TABLE `獎助單位`
  ADD PRIMARY KEY (`獎助單位帳號`);

--
-- Indexes for table `獎學金`
--
ALTER TABLE `獎學金`
  ADD PRIMARY KEY (`名稱`,`獎助單位帳號`),
  ADD KEY `獎助單位帳號` (`獎助單位帳號`);

--
-- Indexes for table `獎學金_條件`
--
ALTER TABLE `獎學金_條件`
  ADD PRIMARY KEY (`條件`,`名稱`,`獎助單位帳號`),
  ADD KEY `名稱` (`名稱`,`獎助單位帳號`);

--
-- Indexes for table `申請資料`
--
ALTER TABLE `申請資料`
  ADD PRIMARY KEY (`申請編號`),
  ADD KEY `學生帳號` (`學生帳號`),
  ADD KEY `名稱` (`名稱`,`獎助單位帳號`),
  ADD KEY `成績單編號` (`成績單編號`);

--
-- Indexes for table `監護人`
--
ALTER TABLE `監護人`
  ADD PRIMARY KEY (`身分證ID`,`學生帳號`),
  ADD KEY `學生帳號` (`學生帳號`);

--
-- Indexes for table `科目`
--
ALTER TABLE `科目`
  ADD PRIMARY KEY (`課堂編號`);

--
-- Indexes for table `系統管理員`
--
ALTER TABLE `系統管理員`
  ADD PRIMARY KEY (`管理員帳號`);

--
-- Indexes for table `老師`
--
ALTER TABLE `老師`
  ADD PRIMARY KEY (`老師帳號`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `公告`
--
ALTER TABLE `公告`
  ADD CONSTRAINT `公告_ibfk_1` FOREIGN KEY (`管理員帳號`) REFERENCES `系統管理員` (`管理員帳號`);

--
-- Constraints for table `學生`
--
ALTER TABLE `學生`
  ADD CONSTRAINT `學生_ibfk_1` FOREIGN KEY (`學生帳號`) REFERENCES `使用者` (`帳號`);

--
-- Constraints for table `審查`
--
ALTER TABLE `審查`
  ADD CONSTRAINT `審查_ibfk_1` FOREIGN KEY (`獎助單位帳號`) REFERENCES `獎助單位` (`獎助單位帳號`),
  ADD CONSTRAINT `審查_ibfk_2` FOREIGN KEY (`申請編號`) REFERENCES `申請資料` (`申請編號`);

--
-- Constraints for table `成績單`
--
ALTER TABLE `成績單`
  ADD CONSTRAINT `成績單_ibfk_1` FOREIGN KEY (`學生帳號`) REFERENCES `學生` (`學生帳號`);

--
-- Constraints for table `有`
--
ALTER TABLE `有`
  ADD CONSTRAINT `有_ibfk_1` FOREIGN KEY (`成績單編號`) REFERENCES `成績單` (`成績單編號`),
  ADD CONSTRAINT `有_ibfk_2` FOREIGN KEY (`課堂編號`) REFERENCES `科目` (`課堂編號`);

--
-- Constraints for table `推薦信`
--
ALTER TABLE `推薦信`
  ADD CONSTRAINT `推薦信_ibfk_1` FOREIGN KEY (`老師帳號`) REFERENCES `老師` (`老師帳號`),
  ADD CONSTRAINT `推薦信_ibfk_2` FOREIGN KEY (`申請編號`) REFERENCES `申請資料` (`申請編號`);

--
-- Constraints for table `獎助單位`
--
ALTER TABLE `獎助單位`
  ADD CONSTRAINT `獎助單位_ibfk_1` FOREIGN KEY (`獎助單位帳號`) REFERENCES `使用者` (`帳號`);

--
-- Constraints for table `獎學金`
--
ALTER TABLE `獎學金`
  ADD CONSTRAINT `獎學金_ibfk_1` FOREIGN KEY (`獎助單位帳號`) REFERENCES `獎助單位` (`獎助單位帳號`);

--
-- Constraints for table `獎學金_條件`
--
ALTER TABLE `獎學金_條件`
  ADD CONSTRAINT `獎學金_條件_ibfk_1` FOREIGN KEY (`名稱`,`獎助單位帳號`) REFERENCES `獎學金` (`名稱`, `獎助單位帳號`);

--
-- Constraints for table `申請資料`
--
ALTER TABLE `申請資料`
  ADD CONSTRAINT `申請資料_ibfk_1` FOREIGN KEY (`學生帳號`) REFERENCES `學生` (`學生帳號`),
  ADD CONSTRAINT `申請資料_ibfk_2` FOREIGN KEY (`名稱`,`獎助單位帳號`) REFERENCES `獎學金` (`名稱`, `獎助單位帳號`),
  ADD CONSTRAINT `申請資料_ibfk_3` FOREIGN KEY (`成績單編號`) REFERENCES `成績單` (`成績單編號`);

--
-- Constraints for table `監護人`
--
ALTER TABLE `監護人`
  ADD CONSTRAINT `監護人_ibfk_1` FOREIGN KEY (`學生帳號`) REFERENCES `學生` (`學生帳號`);

--
-- Constraints for table `系統管理員`
--
ALTER TABLE `系統管理員`
  ADD CONSTRAINT `系統管理員_ibfk_1` FOREIGN KEY (`管理員帳號`) REFERENCES `使用者` (`帳號`);

--
-- Constraints for table `老師`
--
ALTER TABLE `老師`
  ADD CONSTRAINT `老師_ibfk_1` FOREIGN KEY (`老師帳號`) REFERENCES `使用者` (`帳號`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
