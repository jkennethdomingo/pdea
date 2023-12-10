-- MySQL dump 10.13  Distrib 8.0.31, for Win64 (x86_64)
--
-- Host: localhost    Database: mainappdev
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `mainappdev`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `mainappdev` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `mainappdev`;

--
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `address` (
  `address_id` int unsigned NOT NULL AUTO_INCREMENT,
  `address_type` enum('Residential','Permanent') NOT NULL,
  `province` varchar(100) NOT NULL,
  `city_municipality` varchar(100) NOT NULL,
  `barangay` varchar(100) NOT NULL,
  `subdivision_village` varchar(100) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `house_block_lot` varchar(100) DEFAULT NULL,
  `zip_code` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`address_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `address`
--

LOCK TABLES `address` WRITE;
/*!40000 ALTER TABLE `address` DISABLE KEYS */;
INSERT INTO `address` VALUES (1,'Residential','BUKIDNON','DAMULOG','ALUDAS','hshs','Ke','12','8721','2023-12-08 21:37:36','2023-12-08 21:37:36'),(2,'Residential','BUKIDNON','DAMULOG','ALUDAS','hshs','Ke','12','8721','2023-12-08 21:37:36','2023-12-08 21:37:36'),(3,'Residential','BUKIDNON','DAMULOG','ALUDAS','hshs','Ke','12','8721','2023-12-08 21:43:11','2023-12-08 21:43:11'),(4,'Residential','BUKIDNON','DAMULOG','ALUDAS','hshs','Ke','12','8721','2023-12-08 21:43:11','2023-12-08 21:43:11'),(5,'Residential','BUKIDNON','DAMULOG','ALUDAS','hshs','Ke','12','8721','2023-12-08 21:44:01','2023-12-08 21:44:01'),(6,'Residential','BUKIDNON','DAMULOG','ALUDAS','hshs','Ke','12','8721','2023-12-08 21:44:01','2023-12-08 21:44:01'),(7,'Residential','BUKIDNON','DAMULOG','ALUDAS','hshs','Ke','12','8721','2023-12-08 21:54:22','2023-12-08 21:54:22'),(8,'Residential','BUKIDNON','DAMULOG','ALUDAS','hshs','Ke','12','8721','2023-12-08 21:54:22','2023-12-08 21:54:22'),(9,'Residential','BUKIDNON','DAMULOG','ALUDAS','hshs','Ke','12','8721','2023-12-08 21:55:27','2023-12-08 21:55:27'),(10,'Residential','BUKIDNON','DAMULOG','ALUDAS','hshs','Ke','12','8721','2023-12-08 21:55:27','2023-12-08 21:55:27'),(11,'Residential','BUKIDNON','DAMULOG','ALUDAS','hshs','Ke','12','8721','2023-12-08 22:06:22','2023-12-08 22:06:22'),(12,'Residential','BUKIDNON','DAMULOG','ALUDAS','hshs','Ke','12','8721','2023-12-08 22:06:22','2023-12-08 22:06:22'),(27,'Residential','SARANGANI','GLAN','BATOTULING','jsjs','Ke','12','9517','2023-12-08 22:57:42','2023-12-08 22:57:42'),(28,'Residential','SARANGANI','GLAN','BATOTULING','jsjs','Ke','12','9517','2023-12-08 22:57:42','2023-12-08 22:57:42'),(29,'Residential','SARANGANI','GLAN','BATOTULING','jsjs','Ke','12','9517','2023-12-08 23:04:36','2023-12-08 23:04:36'),(30,'Residential','SARANGANI','GLAN','BATOTULING','jsjs','Ke','12','9517','2023-12-08 23:04:36','2023-12-08 23:04:36'),(31,'Residential','SARANGANI','GLAN','BATOTULING','jsjs','Ke','12','9517','2023-12-08 23:09:46','2023-12-08 23:09:46'),(32,'Residential','SARANGANI','GLAN','BATOTULING','jsjs','Ke','12','9517','2023-12-08 23:09:46','2023-12-08 23:09:46'),(33,'Residential','BUKIDNON','BAUNGON','DANATAG','Calapan','Baruyan','12','8707','2023-12-08 23:19:32','2023-12-08 23:19:32'),(34,'Residential','BUKIDNON','BAUNGON','DANATAG','Calapan','Baruyan','12','8707','2023-12-08 23:19:32','2023-12-08 23:19:32'),(35,'Residential','BUKIDNON','BAUNGON','DANATAG','Calapan','Baruyan','12','8707','2023-12-08 23:21:07','2023-12-08 23:21:07'),(36,'Residential','BUKIDNON','BAUNGON','DANATAG','Calapan','Baruyan','12','8707','2023-12-08 23:21:07','2023-12-08 23:21:07'),(37,'Residential','BUKIDNON','BAUNGON','DANATAG','Calapan','Baruyan','12','8707','2023-12-08 23:22:53','2023-12-08 23:22:53'),(38,'Residential','BUKIDNON','BAUNGON','DANATAG','Calapan','Baruyan','12','8707','2023-12-08 23:22:53','2023-12-08 23:22:53'),(39,'Residential','ORIENTAL MINDORO','CITY OF CALAPAN','BARUYAN','Sta Maria','Lupa','Villa144','5200','2023-12-09 02:15:44','2023-12-09 02:15:44'),(40,'Residential','ORIENTAL MINDORO','CITY OF CALAPAN','BARUYAN','Sta Maria','Lupa','Villa144','5200','2023-12-09 02:15:44','2023-12-09 02:15:44');
/*!40000 ALTER TABLE `address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asset`
--

DROP TABLE IF EXISTS `asset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asset` (
  `asset_id` int unsigned NOT NULL AUTO_INCREMENT,
  `asset_type_id` int unsigned NOT NULL,
  `description` text NOT NULL,
  `article` varchar(255) DEFAULT NULL,
  `yr_acquired` date NOT NULL,
  `serial_number` varchar(255) NOT NULL,
  `property_number` varchar(255) NOT NULL,
  `unit_of_measure` varchar(50) NOT NULL,
  `unit_value` decimal(10,2) NOT NULL,
  `item_status` enum('Active','Archived') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`asset_id`),
  UNIQUE KEY `serial_number` (`serial_number`),
  UNIQUE KEY `property_number` (`property_number`),
  KEY `asset_asset_type_id_foreign` (`asset_type_id`),
  CONSTRAINT `asset_asset_type_id_foreign` FOREIGN KEY (`asset_type_id`) REFERENCES `asset_type` (`asset_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asset`
--

LOCK TABLES `asset` WRITE;
/*!40000 ALTER TABLE `asset` DISABLE KEYS */;
INSERT INTO `asset` VALUES (2,1,'Office Building RO MIMAROPA','N/A','2018-11-18','1','1','set',100000.00,'Active','2023-12-09 20:43:09','2023-12-09 20:43:09'),(14,2,'Acer P1287 DLP Projector with Projector Screen','PROJECTOR','2016-10-26','00FF','1060502000-11-000FF','set',26483.60,'Active','2023-12-09 22:05:27','2023-12-09 22:05:27');
/*!40000 ALTER TABLE `asset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asset_audit`
--

DROP TABLE IF EXISTS `asset_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asset_audit` (
  `audit_id` int unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int unsigned NOT NULL,
  `audit_date` timestamp NOT NULL,
  `EmployeeID` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`audit_id`),
  KEY `asset_audit_asset_id_foreign` (`asset_id`),
  KEY `asset_audit_EmployeeID_foreign` (`EmployeeID`),
  CONSTRAINT `asset_audit_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `asset` (`asset_id`),
  CONSTRAINT `asset_audit_EmployeeID_foreign` FOREIGN KEY (`EmployeeID`) REFERENCES `personal_information` (`EmployeeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asset_audit`
--

LOCK TABLES `asset_audit` WRITE;
/*!40000 ALTER TABLE `asset_audit` DISABLE KEYS */;
INSERT INTO `asset_audit` VALUES (2,14,'2023-12-09 22:05:27','EMP0986','2023-12-09 22:05:27','2023-12-09 22:05:27');
/*!40000 ALTER TABLE `asset_audit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asset_location`
--

DROP TABLE IF EXISTS `asset_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asset_location` (
  `location_id` int unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int unsigned NOT NULL,
  `EmployeeID` varchar(20) DEFAULT NULL,
  `department_id` int DEFAULT NULL,
  `provincial_office_id` int DEFAULT NULL,
  `regional_office_id` int unsigned DEFAULT NULL,
  `remarks_whereabouts` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`location_id`),
  KEY `asset_location_asset_id_foreign` (`asset_id`),
  KEY `asset_location_EmployeeID_foreign` (`EmployeeID`),
  KEY `asset_location_department_id_foreign` (`department_id`),
  KEY `asset_location_provincial_office_id_foreign` (`provincial_office_id`),
  KEY `asset_location_regional_office_id_foreign` (`regional_office_id`),
  CONSTRAINT `asset_location_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `asset` (`asset_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `asset_location_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`) ON DELETE CASCADE ON UPDATE SET NULL,
  CONSTRAINT `asset_location_EmployeeID_foreign` FOREIGN KEY (`EmployeeID`) REFERENCES `personal_information` (`EmployeeID`) ON DELETE CASCADE ON UPDATE SET NULL,
  CONSTRAINT `asset_location_provincial_office_id_foreign` FOREIGN KEY (`provincial_office_id`) REFERENCES `provincial_office` (`provincial_office_id`) ON DELETE CASCADE ON UPDATE SET NULL,
  CONSTRAINT `asset_location_regional_office_id_foreign` FOREIGN KEY (`regional_office_id`) REFERENCES `regional_office` (`regional_office_id`) ON DELETE CASCADE ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asset_location`
--

LOCK TABLES `asset_location` WRITE;
/*!40000 ALTER TABLE `asset_location` DISABLE KEYS */;
INSERT INTO `asset_location` VALUES (1,2,NULL,NULL,NULL,NULL,'RO (Regional Ofiice)','2023-12-09 20:43:09','2023-12-09 20:43:09'),(13,14,NULL,NULL,NULL,NULL,'RO (Regional Ofiice)','2023-12-09 22:05:27','2023-12-09 22:05:27');
/*!40000 ALTER TABLE `asset_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asset_status`
--

DROP TABLE IF EXISTS `asset_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asset_status` (
  `status_id` int unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int unsigned NOT NULL,
  `qty_per_property_card` int NOT NULL,
  `physical_count` int NOT NULL,
  `shortage_overage_qty` int NOT NULL,
  `shortage_overage_value` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`status_id`),
  KEY `asset_status_asset_id_foreign` (`asset_id`),
  CONSTRAINT `asset_status_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `asset` (`asset_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asset_status`
--

LOCK TABLES `asset_status` WRITE;
/*!40000 ALTER TABLE `asset_status` DISABLE KEYS */;
INSERT INTO `asset_status` VALUES (2,2,1,1,0,0.00,'svc','2023-12-09 20:43:09','2023-12-09 20:43:09'),(14,14,1,1,0,0.00,'svc','2023-12-09 22:05:27','2023-12-09 22:05:27');
/*!40000 ALTER TABLE `asset_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asset_type`
--

DROP TABLE IF EXISTS `asset_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asset_type` (
  `asset_type_id` int unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) NOT NULL,
  PRIMARY KEY (`asset_type_id`),
  UNIQUE KEY `type_name` (`type_name`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asset_type`
--

LOCK TABLES `asset_type` WRITE;
/*!40000 ALTER TABLE `asset_type` DISABLE KEYS */;
INSERT INTO `asset_type` VALUES (1,'1060401000 (BUILDINGS)'),(2,'1060501000 (OFFICE EQUIPMENT)'),(4,'1060503000 (IT EQUIPMENT AND SOFTWARE)'),(5,'1060507000 (COMMUNICATION EQUIPMENT)'),(8,'1060510000 (MILITARY AND POLICE EQUIPMENT (MPE)'),(6,'1060511000 (MEDICAL, DENTAL AND LABORATORY EQUIPMENT)'),(7,'1060513000 (SPORTS EQUIPMENT)'),(9,'1060599000 (OTHER MACHINERIES AND EQUIPMENT)'),(11,'1060601000 (MOTOR VEHICLES)'),(3,'1060701000 (FURNITURE AND FIXTURE)'),(10,'1060702000 (LIBRARY BOOKS)'),(12,'1069801000 (OTHER WORKING ANIMALS)'),(13,'1069899000 (OTHER PROPERTY, PLANT AND EQUIPMENT)');
/*!40000 ALTER TABLE `asset_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `authentication_roles`
--

DROP TABLE IF EXISTS `authentication_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `authentication_roles` (
  `AuthRoleID` int NOT NULL AUTO_INCREMENT,
  `AuthRoleName` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`AuthRoleID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `authentication_roles`
--

LOCK TABLES `authentication_roles` WRITE;
/*!40000 ALTER TABLE `authentication_roles` DISABLE KEYS */;
INSERT INTO `authentication_roles` VALUES (1,'HR_ADMIN','2023-11-12 06:48:50','2023-11-12 06:48:50'),(2,'LOGISTICS_ADMIN','2023-11-12 06:48:50','2023-11-12 06:48:50'),(3,'NON_ADMIN','2023-11-12 06:48:50','2023-11-12 06:48:50');
/*!40000 ALTER TABLE `authentication_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `children`
--

DROP TABLE IF EXISTS `children`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `children` (
  `child_id` int unsigned NOT NULL AUTO_INCREMENT,
  `family_id` int unsigned NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`child_id`),
  KEY `children_family_id_foreign` (`family_id`),
  CONSTRAINT `children_family_id_foreign` FOREIGN KEY (`family_id`) REFERENCES `family_background` (`family_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `children`
--

LOCK TABLES `children` WRITE;
/*!40000 ALTER TABLE `children` DISABLE KEYS */;
INSERT INTO `children` VALUES (1,3,'Bae Suzy','2023-12-29','2023-12-08 22:06:22','2023-12-08 22:06:22'),(2,3,'K','2023-12-29','2023-12-08 22:06:22','2023-12-08 22:06:22');
/*!40000 ALTER TABLE `children` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `civil_service_eligibility`
--

DROP TABLE IF EXISTS `civil_service_eligibility`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `civil_service_eligibility` (
  `eligibility_id` int NOT NULL AUTO_INCREMENT,
  `EmployeeID` varchar(20) NOT NULL,
  `career_service` varchar(255) DEFAULT NULL,
  `rating` decimal(5,2) DEFAULT NULL,
  `date_of_examination` date NOT NULL,
  `place_of_examination` varchar(255) NOT NULL,
  `license_number` varchar(50) DEFAULT NULL,
  `license_date_of_validity` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`eligibility_id`),
  KEY `civil_service_eligibility_EmployeeID_foreign` (`EmployeeID`),
  CONSTRAINT `civil_service_eligibility_EmployeeID_foreign` FOREIGN KEY (`EmployeeID`) REFERENCES `personal_information` (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `civil_service_eligibility`
--

LOCK TABLES `civil_service_eligibility` WRITE;
/*!40000 ALTER TABLE `civil_service_eligibility` DISABLE KEYS */;
INSERT INTO `civil_service_eligibility` VALUES (1,'EMP09869','Hello',1.00,'2023-12-14','Calapan','112','2023-12-21','2023-12-08 22:57:42','2023-12-08 22:57:42'),(2,'EMP098691','Hello',1.00,'2023-12-14','Calapan','112','2023-12-21','2023-12-08 23:04:36','2023-12-08 23:04:36'),(3,'EMPD098691','Hello',1.00,'2023-12-14','Calapan','112','2023-12-21','2023-12-08 23:09:46','2023-12-08 23:09:46'),(4,'48795','Hello',75.00,'2023-10-11','Calapan','879456','2024-01-10','2023-12-09 02:15:44','2023-12-09 02:15:44');
/*!40000 ALTER TABLE `civil_service_eligibility` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `department` (
  `department_id` int NOT NULL AUTO_INCREMENT,
  `department_name` varchar(255) NOT NULL,
  PRIMARY KEY (`department_id`),
  UNIQUE KEY `department_name` (`department_name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (6,'Compliance Service'),(4,'Enforcement'),(3,'Intelligence'),(7,'Internal Affairs'),(2,'Legal Affairs'),(1,'Narcotics Control'),(5,'Preventive Education'),(8,'Research and Statistics');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `designation`
--

DROP TABLE IF EXISTS `designation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `designation` (
  `DesignationID` int unsigned NOT NULL AUTO_INCREMENT,
  `DesignationName` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`DesignationID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `designation`
--

LOCK TABLES `designation` WRITE;
/*!40000 ALTER TABLE `designation` DISABLE KEYS */;
INSERT INTO `designation` VALUES (1,'Provincial Officer','2023-11-12 08:11:33','2023-11-12 08:11:33'),(2,'Chief Intelligence Officer','2023-11-12 08:11:33','2023-11-12 08:11:33'),(3,'Lead Administrative Officer','2023-11-12 08:11:33','2023-11-12 08:11:33'),(4,'Senior Legal Counsel','2023-11-12 08:11:33','2023-11-12 08:11:33'),(5,'Director of Logistics','2023-11-12 08:11:33','2023-11-12 08:11:33'),(6,'Chief Financial Officer','2023-11-12 08:11:33','2023-11-12 08:11:33'),(7,'Head of Public Affairs','2023-11-12 08:11:33','2023-11-12 08:11:33'),(8,'Senior Compliance Officer','2023-11-12 08:11:33','2023-11-12 08:11:33'),(9,'Laboratory Manager','2023-11-12 08:11:33','2023-11-12 08:11:33'),(10,'Academy Instructor','2023-11-12 08:11:33','2023-11-12 08:11:33'),(11,'Special Operations Commander','2023-11-12 08:11:33','2023-11-12 08:11:33'),(12,'Community Relations Officer','2023-11-12 08:11:33','2023-11-12 08:11:33'),(13,'Foreign Affairs Liaison','2023-11-12 08:11:33','2023-11-12 08:11:33'),(14,'Internal Auditor','2023-11-12 08:11:33','2023-11-12 08:11:33');
/*!40000 ALTER TABLE `designation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `educational_background`
--

DROP TABLE IF EXISTS `educational_background`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `educational_background` (
  `education_id` int unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeID` varchar(20) NOT NULL,
  `level` enum('Elementary','Secondary','Vocational','College','GraduateStudies') NOT NULL,
  `name_of_school` varchar(100) NOT NULL,
  `degree_course` varchar(100) DEFAULT NULL,
  `period_of_attendance_from` year DEFAULT NULL,
  `period_of_attendance_to` year DEFAULT NULL,
  `highest_level_units_earned` int DEFAULT NULL,
  `year_graduated` year DEFAULT NULL,
  `scholarship_academic_honors_received` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`education_id`),
  KEY `educational_background_EmployeeID_foreign` (`EmployeeID`),
  CONSTRAINT `educational_background_EmployeeID_foreign` FOREIGN KEY (`EmployeeID`) REFERENCES `personal_information` (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `educational_background`
--

LOCK TABLES `educational_background` WRITE;
/*!40000 ALTER TABLE `educational_background` DISABLE KEYS */;
INSERT INTO `educational_background` VALUES (1,'MCDOBOT1234','Elementary','AMS','Basic',2000,2007,0,2007,'Highest','2023-12-08 21:55:27','2023-12-08 21:55:27'),(2,'MCDOBOT1234','Secondary','AMS','Basic',2000,2007,0,2007,'Highest','2023-12-08 21:55:27','2023-12-08 21:55:27'),(3,'MCDOBOT1234','','AMS','Basic',2000,2007,0,2007,'Highest','2023-12-08 21:55:27','2023-12-08 21:55:27'),(4,'MCDOBOT1234','College','AMS','Basic',2000,2007,0,2007,'Highest','2023-12-08 21:55:27','2023-12-08 21:55:27'),(5,'MCDOBOT1234','','AMS','Basic',2000,2007,0,2007,'Highest','2023-12-08 21:55:27','2023-12-08 21:55:27'),(6,'MCDOBOT12345','Elementary','AMS','Basic',2000,2007,0,2007,'Highest','2023-12-08 22:06:22','2023-12-08 22:06:22'),(7,'MCDOBOT12345','Secondary','AMS','Basic',2000,2007,0,2007,'Highest','2023-12-08 22:06:22','2023-12-08 22:06:22'),(8,'MCDOBOT12345','Vocational','AMS','Basic',2000,2007,0,2007,'Highest','2023-12-08 22:06:22','2023-12-08 22:06:22'),(9,'MCDOBOT12345','College','AMS','Basic',2000,2007,0,2007,'Highest','2023-12-08 22:06:22','2023-12-08 22:06:22'),(10,'MCDOBOT12345','GraduateStudies','AMS','Basic',2000,2007,0,2007,'Highest','2023-12-08 22:06:22','2023-12-08 22:06:22'),(46,'EMP09869','Elementary','','',0000,0000,0,0000,'','2023-12-08 22:57:42','2023-12-08 22:57:42'),(47,'EMP09869','Secondary','','',0000,0000,0,0000,'','2023-12-08 22:57:42','2023-12-08 22:57:42'),(48,'EMP09869','Vocational','','',0000,0000,0,0000,'','2023-12-08 22:57:42','2023-12-08 22:57:42'),(49,'EMP09869','College','','',0000,0000,0,0000,'','2023-12-08 22:57:42','2023-12-08 22:57:42'),(50,'EMP09869','GraduateStudies','','',0000,0000,0,0000,'','2023-12-08 22:57:42','2023-12-08 22:57:42'),(51,'EMP098691','Elementary','','',0000,0000,0,0000,'','2023-12-08 23:04:36','2023-12-08 23:04:36'),(52,'EMP098691','Secondary','','',0000,0000,0,0000,'','2023-12-08 23:04:36','2023-12-08 23:04:36'),(53,'EMP098691','Vocational','','',0000,0000,0,0000,'','2023-12-08 23:04:36','2023-12-08 23:04:36'),(54,'EMP098691','College','','',0000,0000,0,0000,'','2023-12-08 23:04:36','2023-12-08 23:04:36'),(55,'EMP098691','GraduateStudies','','',0000,0000,0,0000,'','2023-12-08 23:04:36','2023-12-08 23:04:36'),(56,'EMPD098691','Elementary','','',0000,0000,0,0000,'','2023-12-08 23:09:46','2023-12-08 23:09:46'),(57,'EMPD098691','Secondary','','',0000,0000,0,0000,'','2023-12-08 23:09:46','2023-12-08 23:09:46'),(58,'EMPD098691','Vocational','','',0000,0000,0,0000,'','2023-12-08 23:09:46','2023-12-08 23:09:46'),(59,'EMPD098691','College','','',0000,0000,0,0000,'','2023-12-08 23:09:46','2023-12-08 23:09:46'),(60,'EMPD098691','GraduateStudies','','',0000,0000,0,0000,'','2023-12-08 23:09:46','2023-12-08 23:09:46'),(61,'EMP09861','Elementary','','',0000,0000,0,0000,'','2023-12-08 23:19:32','2023-12-08 23:19:32'),(62,'EMP09861','Secondary','','',0000,0000,0,0000,'','2023-12-08 23:19:32','2023-12-08 23:19:32'),(63,'EMP09861','Vocational','','',0000,0000,0,0000,'','2023-12-08 23:19:32','2023-12-08 23:19:32'),(64,'EMP09861','College','','',0000,0000,0,0000,'','2023-12-08 23:19:32','2023-12-08 23:19:32'),(65,'EMP09861','GraduateStudies','','',0000,0000,0,0000,'','2023-12-08 23:19:32','2023-12-08 23:19:32'),(66,'EMP098616','Elementary','','',0000,0000,0,0000,'','2023-12-08 23:21:07','2023-12-08 23:21:07'),(67,'EMP098616','Secondary','','',0000,0000,0,0000,'','2023-12-08 23:21:07','2023-12-08 23:21:07'),(68,'EMP098616','Vocational','','',0000,0000,0,0000,'','2023-12-08 23:21:07','2023-12-08 23:21:07'),(69,'EMP098616','College','','',0000,0000,0,0000,'','2023-12-08 23:21:07','2023-12-08 23:21:07'),(70,'EMP098616','GraduateStudies','','',0000,0000,0,0000,'','2023-12-08 23:21:07','2023-12-08 23:21:07'),(71,'EMP0986161','Elementary','','',0000,0000,0,0000,'','2023-12-08 23:22:53','2023-12-08 23:22:53'),(72,'EMP0986161','Secondary','','',0000,0000,0,0000,'','2023-12-08 23:22:53','2023-12-08 23:22:53'),(73,'EMP0986161','Vocational','','',0000,0000,0,0000,'','2023-12-08 23:22:53','2023-12-08 23:22:53'),(74,'EMP0986161','College','','',0000,0000,0,0000,'','2023-12-08 23:22:53','2023-12-08 23:22:53'),(75,'EMP0986161','GraduateStudies','','',0000,0000,0,0000,'','2023-12-08 23:22:53','2023-12-08 23:22:53'),(76,'48795','Elementary','AMS','Basic Education',2006,2012,0,2012,'high honor','2023-12-09 02:15:44','2023-12-09 02:15:44'),(77,'48795','Secondary','Oriental Mindoro National High School','Basic Education',2013,2020,0,2020,'high honor','2023-12-09 02:15:44','2023-12-09 02:15:44'),(78,'48795','Vocational','MinSU','BSIT',2021,2025,0,2025,'cumlaude','2023-12-09 02:15:44','2023-12-09 02:15:44'),(79,'48795','College','BatSU','BSIT',2026,2027,0,2027,'cumluade','2023-12-09 02:15:44','2023-12-09 02:15:44'),(80,'48795','GraduateStudies','DWCC','BSIT',2028,2029,0,2029,'cumlaude','2023-12-09 02:15:44','2023-12-09 02:15:44');
/*!40000 ALTER TABLE `educational_background` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_address`
--

DROP TABLE IF EXISTS `employee_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee_address` (
  `EmployeeAddressID` int unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeID` varchar(20) NOT NULL,
  `address_id` int DEFAULT NULL,
  `address_type` enum('RESIDENTIAL','PERMANENT') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`EmployeeAddressID`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_address`
--

LOCK TABLES `employee_address` WRITE;
/*!40000 ALTER TABLE `employee_address` DISABLE KEYS */;
INSERT INTO `employee_address` VALUES (1,'MCDOBOT',1,'RESIDENTIAL','2023-12-08 21:37:36','2023-12-08 21:37:36'),(2,'MCDOBOT',2,'PERMANENT','2023-12-08 21:37:36','2023-12-08 21:37:36'),(3,'MCDOBOT1',3,'RESIDENTIAL','2023-12-08 21:43:11','2023-12-08 21:43:11'),(4,'MCDOBOT1',4,'PERMANENT','2023-12-08 21:43:11','2023-12-08 21:43:11'),(5,'MCDOBOT12',5,'RESIDENTIAL','2023-12-08 21:44:01','2023-12-08 21:44:01'),(6,'MCDOBOT12',6,'PERMANENT','2023-12-08 21:44:01','2023-12-08 21:44:01'),(7,'MCDOBOT123',7,'RESIDENTIAL','2023-12-08 21:54:22','2023-12-08 21:54:22'),(8,'MCDOBOT123',8,'PERMANENT','2023-12-08 21:54:22','2023-12-08 21:54:22'),(9,'MCDOBOT1234',9,'RESIDENTIAL','2023-12-08 21:55:27','2023-12-08 21:55:27'),(10,'MCDOBOT1234',10,'PERMANENT','2023-12-08 21:55:27','2023-12-08 21:55:27'),(11,'MCDOBOT12345',11,'RESIDENTIAL','2023-12-08 22:06:22','2023-12-08 22:06:22'),(12,'MCDOBOT12345',12,'PERMANENT','2023-12-08 22:06:22','2023-12-08 22:06:22'),(27,'EMP09869',27,'RESIDENTIAL','2023-12-08 22:57:42','2023-12-08 22:57:42'),(28,'EMP09869',28,'PERMANENT','2023-12-08 22:57:42','2023-12-08 22:57:42'),(29,'EMP098691',29,'RESIDENTIAL','2023-12-08 23:04:36','2023-12-08 23:04:36'),(30,'EMP098691',30,'PERMANENT','2023-12-08 23:04:36','2023-12-08 23:04:36'),(31,'EMPD098691',31,'RESIDENTIAL','2023-12-08 23:09:46','2023-12-08 23:09:46'),(32,'EMPD098691',32,'PERMANENT','2023-12-08 23:09:46','2023-12-08 23:09:46'),(33,'EMP09861',33,'RESIDENTIAL','2023-12-08 23:19:32','2023-12-08 23:19:32'),(34,'EMP09861',34,'PERMANENT','2023-12-08 23:19:32','2023-12-08 23:19:32'),(35,'EMP098616',35,'RESIDENTIAL','2023-12-08 23:21:07','2023-12-08 23:21:07'),(36,'EMP098616',36,'PERMANENT','2023-12-08 23:21:07','2023-12-08 23:21:07'),(37,'EMP0986161',37,'RESIDENTIAL','2023-12-08 23:22:53','2023-12-08 23:22:53'),(38,'EMP0986161',38,'PERMANENT','2023-12-08 23:22:53','2023-12-08 23:22:53'),(39,'48795',39,'RESIDENTIAL','2023-12-09 02:15:44','2023-12-09 02:15:44'),(40,'48795',40,'PERMANENT','2023-12-09 02:15:44','2023-12-09 02:15:44');
/*!40000 ALTER TABLE `employee_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_authroles`
--

DROP TABLE IF EXISTS `employee_authroles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee_authroles` (
  `AuthRoleID` int NOT NULL,
  `EmpAuthID` int NOT NULL AUTO_INCREMENT,
  `EmployeeID` varchar(20) NOT NULL,
  PRIMARY KEY (`EmpAuthID`),
  KEY `employee_authroles_AuthRoleID_foreign` (`AuthRoleID`),
  KEY `employee_authroles_EmployeeID_foreign` (`EmployeeID`),
  CONSTRAINT `employee_authroles_AuthRoleID_foreign` FOREIGN KEY (`AuthRoleID`) REFERENCES `authentication_roles` (`AuthRoleID`),
  CONSTRAINT `employee_authroles_EmployeeID_foreign` FOREIGN KEY (`EmployeeID`) REFERENCES `personal_information` (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_authroles`
--

LOCK TABLES `employee_authroles` WRITE;
/*!40000 ALTER TABLE `employee_authroles` DISABLE KEYS */;
INSERT INTO `employee_authroles` VALUES (1,2,'EMP12345'),(2,15,'EMP0986'),(2,16,'EMP09860'),(2,17,'EMP098'),(2,18,'EMP'),(3,19,'EMP65'),(3,20,'EMP652'),(3,21,'EMP6521'),(3,22,'EMP6521s'),(3,23,'EMP6521s1'),(3,24,'EMP6521s11'),(3,25,'ABC'),(3,26,'XYZ'),(3,27,'Z123'),(3,28,'GIDLE'),(3,29,'USER123'),(3,30,'MCDOBOT'),(3,31,'MCDOBOT1'),(3,32,'MCDOBOT12'),(3,33,'MCDOBOT123'),(3,34,'MCDOBOT1234'),(3,35,'MCDOBOT12345'),(3,37,'EMP09869'),(3,38,'EMP098691'),(3,39,'EMPD098691'),(3,40,'EMP09861'),(3,41,'EMP098616'),(3,42,'EMP0986161'),(3,43,'48795');
/*!40000 ALTER TABLE `employee_authroles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_designation`
--

DROP TABLE IF EXISTS `employee_designation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee_designation` (
  `EmpDesigID` int unsigned NOT NULL AUTO_INCREMENT,
  `DesignationID` int unsigned NOT NULL,
  `EmployeeID` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`EmpDesigID`),
  KEY `employee_designation_DesignationID_foreign` (`DesignationID`),
  KEY `employee_designation_EmployeeID_foreign` (`EmployeeID`),
  CONSTRAINT `employee_designation_DesignationID_foreign` FOREIGN KEY (`DesignationID`) REFERENCES `designation` (`DesignationID`),
  CONSTRAINT `employee_designation_EmployeeID_foreign` FOREIGN KEY (`EmployeeID`) REFERENCES `personal_information` (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_designation`
--

LOCK TABLES `employee_designation` WRITE;
/*!40000 ALTER TABLE `employee_designation` DISABLE KEYS */;
INSERT INTO `employee_designation` VALUES (1,1,'USER123','2023-11-26 02:32:47','2023-11-26 02:32:47'),(2,10,'MCDOBOT','2023-12-08 21:37:36','2023-12-08 21:37:36'),(3,10,'MCDOBOT1','2023-12-08 21:43:11','2023-12-08 21:43:11'),(4,10,'MCDOBOT12','2023-12-08 21:44:01','2023-12-08 21:44:01'),(5,10,'MCDOBOT123','2023-12-08 21:54:22','2023-12-08 21:54:22'),(6,10,'MCDOBOT1234','2023-12-08 21:55:27','2023-12-08 21:55:27'),(7,10,'MCDOBOT12345','2023-12-08 22:06:22','2023-12-08 22:06:22'),(9,10,'EMP09869','2023-12-08 22:57:42','2023-12-08 22:57:42'),(10,10,'EMP098691','2023-12-08 23:04:36','2023-12-08 23:04:36'),(11,10,'EMPD098691','2023-12-08 23:09:46','2023-12-08 23:09:46'),(12,11,'EMP09861','2023-12-08 23:19:33','2023-12-08 23:19:33'),(13,11,'EMP098616','2023-12-08 23:21:07','2023-12-08 23:21:07'),(14,11,'EMP0986161','2023-12-08 23:22:53','2023-12-08 23:22:53'),(15,8,'48795','2023-12-09 02:15:44','2023-12-09 02:15:44');
/*!40000 ALTER TABLE `employee_designation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_leaves`
--

DROP TABLE IF EXISTS `employee_leaves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee_leaves` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeID` varchar(20) NOT NULL,
  `leave_type_id` int unsigned NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` text,
  `status` enum('approved','pending','rejected') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_leaves_EmployeeID_foreign` (`EmployeeID`),
  KEY `employee_leaves_leave_type_id_foreign` (`leave_type_id`),
  CONSTRAINT `employee_leaves_EmployeeID_foreign` FOREIGN KEY (`EmployeeID`) REFERENCES `personal_information` (`EmployeeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `employee_leaves_leave_type_id_foreign` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_type` (`LeaveTypeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_leaves`
--

LOCK TABLES `employee_leaves` WRITE;
/*!40000 ALTER TABLE `employee_leaves` DISABLE KEYS */;
INSERT INTO `employee_leaves` VALUES (1,'ABC',4,'2023-11-28','2023-11-28','Fever','approved','2023-11-27 19:29:41','2023-11-27 19:29:41'),(14,'USER123',1,'2023-11-29','2023-11-29','None','approved','2023-11-28 03:55:01','2023-11-28 03:55:01'),(15,'USER123',1,'2023-11-30','2023-12-03','Lagnat','approved','2023-11-28 04:01:06','2023-11-28 04:01:06'),(16,'EMP12345',1,'2023-12-04','2023-12-08','Hello','approved','2023-11-28 19:14:53','2023-11-28 19:14:53'),(17,'XYZ',2,'2023-12-08','2023-12-08','Sick','approved','2023-12-04 16:22:49','2023-12-04 16:22:49'),(18,'USER123',4,'2023-12-27','2023-12-28','Sick','approved','2023-12-08 13:18:06','2023-12-09 06:16:09'),(19,'USER123',2,'2023-12-29','2023-12-29','Fever','approved','2023-12-09 06:41:11','2023-12-09 06:41:27'),(20,'USER123',4,'2023-12-08','2023-12-09','Fever','rejected','2023-12-09 06:49:42','2023-12-09 08:37:54'),(22,'USER123',3,'2024-02-07','2024-02-07','Pahinga','rejected','2023-12-09 18:57:43','2023-12-09 19:50:28');
/*!40000 ALTER TABLE `employee_leaves` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_position`
--

DROP TABLE IF EXISTS `employee_position`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee_position` (
  `EmpPosID` int unsigned NOT NULL AUTO_INCREMENT,
  `PositionID` int unsigned NOT NULL,
  `EmployeeID` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`EmpPosID`),
  KEY `employee_position_PositionID_foreign` (`PositionID`),
  KEY `employee_position_EmployeeID_foreign` (`EmployeeID`),
  CONSTRAINT `employee_position_EmployeeID_foreign` FOREIGN KEY (`EmployeeID`) REFERENCES `personal_information` (`EmployeeID`),
  CONSTRAINT `employee_position_PositionID_foreign` FOREIGN KEY (`PositionID`) REFERENCES `position` (`PositionID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_position`
--

LOCK TABLES `employee_position` WRITE;
/*!40000 ALTER TABLE `employee_position` DISABLE KEYS */;
INSERT INTO `employee_position` VALUES (1,10,'USER123','2023-11-26 02:32:47','2023-11-26 02:32:47'),(2,9,'MCDOBOT','2023-12-08 21:37:36','2023-12-08 21:37:36'),(3,9,'MCDOBOT1','2023-12-08 21:43:11','2023-12-08 21:43:11'),(4,9,'MCDOBOT12','2023-12-08 21:44:01','2023-12-08 21:44:01'),(5,9,'MCDOBOT123','2023-12-08 21:54:22','2023-12-08 21:54:22'),(6,9,'MCDOBOT1234','2023-12-08 21:55:27','2023-12-08 21:55:27'),(7,9,'MCDOBOT12345','2023-12-08 22:06:22','2023-12-08 22:06:22'),(9,11,'EMP09869','2023-12-08 22:57:42','2023-12-08 22:57:42'),(10,11,'EMP098691','2023-12-08 23:04:36','2023-12-08 23:04:36'),(11,11,'EMPD098691','2023-12-08 23:09:46','2023-12-08 23:09:46'),(12,11,'EMP09861','2023-12-08 23:19:33','2023-12-08 23:19:33'),(13,11,'EMP098616','2023-12-08 23:21:07','2023-12-08 23:21:07'),(14,11,'EMP0986161','2023-12-08 23:22:53','2023-12-08 23:22:53'),(15,9,'48795','2023-12-09 02:15:44','2023-12-09 02:15:44');
/*!40000 ALTER TABLE `employee_position` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_section`
--

DROP TABLE IF EXISTS `employee_section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee_section` (
  `EmpSectID` int unsigned NOT NULL AUTO_INCREMENT,
  `SectionID` int unsigned NOT NULL,
  `EmployeeID` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`EmpSectID`),
  KEY `employee_section_SectionID_foreign` (`SectionID`),
  KEY `employee_section_EmployeeID_foreign` (`EmployeeID`),
  CONSTRAINT `employee_section_EmployeeID_foreign` FOREIGN KEY (`EmployeeID`) REFERENCES `personal_information` (`EmployeeID`),
  CONSTRAINT `employee_section_SectionID_foreign` FOREIGN KEY (`SectionID`) REFERENCES `section` (`SectionID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_section`
--

LOCK TABLES `employee_section` WRITE;
/*!40000 ALTER TABLE `employee_section` DISABLE KEYS */;
INSERT INTO `employee_section` VALUES (1,12,'USER123','2023-11-26 02:32:47','2023-11-26 02:32:47'),(2,9,'MCDOBOT','2023-12-08 21:37:36','2023-12-08 21:37:36'),(3,9,'MCDOBOT1','2023-12-08 21:43:11','2023-12-08 21:43:11'),(4,9,'MCDOBOT12','2023-12-08 21:44:01','2023-12-08 21:44:01'),(5,9,'MCDOBOT123','2023-12-08 21:54:22','2023-12-08 21:54:22'),(6,9,'MCDOBOT1234','2023-12-08 21:55:27','2023-12-08 21:55:27'),(7,9,'MCDOBOT12345','2023-12-08 22:06:22','2023-12-08 22:06:22'),(9,10,'EMP09869','2023-12-08 22:57:42','2023-12-08 22:57:42'),(10,10,'EMP098691','2023-12-08 23:04:36','2023-12-08 23:04:36'),(11,10,'EMPD098691','2023-12-08 23:09:46','2023-12-08 23:09:46'),(12,10,'EMP09861','2023-12-08 23:19:33','2023-12-08 23:19:33'),(13,10,'EMP098616','2023-12-08 23:21:07','2023-12-08 23:21:07'),(14,10,'EMP0986161','2023-12-08 23:22:53','2023-12-08 23:22:53'),(15,11,'48795','2023-12-09 02:15:44','2023-12-09 02:15:44');
/*!40000 ALTER TABLE `employee_section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `family_background`
--

DROP TABLE IF EXISTS `family_background`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `family_background` (
  `family_id` int unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeID` varchar(20) NOT NULL,
  `spouse_first_name` varchar(50) DEFAULT NULL,
  `spouse_name_extension` varchar(50) DEFAULT NULL,
  `spouse_middle_name` varchar(50) DEFAULT NULL,
  `spouse_surname` varchar(50) DEFAULT NULL,
  `spouse_occupation` varchar(100) DEFAULT NULL,
  `spouse_employer_business_name` varchar(100) DEFAULT NULL,
  `spouse_business_address` varchar(255) DEFAULT NULL,
  `spouse_telephone_no` varchar(15) DEFAULT NULL,
  `father_surname` varchar(50) DEFAULT NULL,
  `father_first_name` varchar(50) DEFAULT NULL,
  `father_middle_name` varchar(50) DEFAULT NULL,
  `father_name_extension` varchar(50) DEFAULT NULL,
  `mother_maiden_name` varchar(50) DEFAULT NULL,
  `mother_surname` varchar(50) DEFAULT NULL,
  `mother_first_name` varchar(50) DEFAULT NULL,
  `mother_middle_name` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`family_id`),
  KEY `family_background_EmployeeID_foreign` (`EmployeeID`),
  CONSTRAINT `family_background_EmployeeID_foreign` FOREIGN KEY (`EmployeeID`) REFERENCES `personal_information` (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `family_background`
--

LOCK TABLES `family_background` WRITE;
/*!40000 ALTER TABLE `family_background` DISABLE KEYS */;
INSERT INTO `family_background` VALUES (1,'MCDOBOT123',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-12-08 21:54:22','2023-12-08 21:54:22'),(2,'MCDOBOT1234',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-12-08 21:55:27','2023-12-08 21:55:27'),(3,'MCDOBOT12345','New','Jr.','Jeans','Minji','Kpop Idol','Minji','Not Available','09123456789','Haerin','Kang','Jeans',NULL,'Danielle',NULL,'Kang','Jeans','2023-12-08 22:06:22','2023-12-08 22:06:22'),(11,'EMP09869',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-12-08 22:57:42','2023-12-08 22:57:42'),(12,'EMP098691',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-12-08 23:04:36','2023-12-08 23:04:36'),(13,'EMPD098691',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-12-08 23:09:46','2023-12-08 23:09:46'),(14,'EMP09861',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-12-08 23:19:32','2023-12-08 23:19:32'),(15,'EMP098616',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-12-08 23:21:07','2023-12-08 23:21:07'),(16,'EMP0986161',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-12-08 23:22:53','2023-12-08 23:22:53'),(17,'48795','Manalo',NULL,'Garcia','May','Seller','May sari-sari store','Baruyan, Calapan City','987458','Theo','Manalo','Garcia',NULL,'Mila',NULL,'Garcia','Manalo','2023-12-09 02:15:44','2023-12-09 02:15:44');
/*!40000 ALTER TABLE `family_background` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `government_issued_ids`
--

DROP TABLE IF EXISTS `government_issued_ids`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `government_issued_ids` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeID` varchar(20) NOT NULL,
  `id_type` varchar(50) NOT NULL,
  `date_of_issuance` date DEFAULT NULL,
  `place_of_issuance` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `government_issued_ids_EmployeeID_foreign` (`EmployeeID`),
  CONSTRAINT `government_issued_ids_EmployeeID_foreign` FOREIGN KEY (`EmployeeID`) REFERENCES `personal_information` (`EmployeeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `government_issued_ids`
--

LOCK TABLES `government_issued_ids` WRITE;
/*!40000 ALTER TABLE `government_issued_ids` DISABLE KEYS */;
/*!40000 ALTER TABLE `government_issued_ids` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `internal_employee_training`
--

DROP TABLE IF EXISTS `internal_employee_training`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `internal_employee_training` (
  `internal_training_id` int unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeID` varchar(20) NOT NULL,
  `training_id` int unsigned NOT NULL,
  `attendance_date` date DEFAULT NULL,
  PRIMARY KEY (`internal_training_id`),
  KEY `internal_employee_training_EmployeeID_foreign` (`EmployeeID`),
  KEY `internal_employee_training_training_id_foreign` (`training_id`),
  CONSTRAINT `internal_employee_training_EmployeeID_foreign` FOREIGN KEY (`EmployeeID`) REFERENCES `personal_information` (`EmployeeID`),
  CONSTRAINT `internal_employee_training_training_id_foreign` FOREIGN KEY (`training_id`) REFERENCES `training` (`training_id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `internal_employee_training`
--

LOCK TABLES `internal_employee_training` WRITE;
/*!40000 ALTER TABLE `internal_employee_training` DISABLE KEYS */;
INSERT INTO `internal_employee_training` VALUES (1,'ABC',10,NULL),(2,'EMP',10,NULL),(3,'ABC',13,NULL),(4,'EMP',13,NULL),(12,'EMP098',17,NULL),(35,'EMP',11,NULL),(36,'EMP098',11,NULL),(37,'EMP0986',11,NULL),(43,'ABC',18,NULL),(44,'EMP',18,NULL),(45,'EMP098',18,NULL),(47,'ABC',19,NULL),(48,'EMP',19,NULL),(50,'EMP',20,NULL),(51,'EMP098',20,NULL),(52,'EMP0986',20,NULL),(53,'EMP09860',20,NULL),(54,'EMP12345',20,NULL),(56,'ABC',21,NULL),(57,'ABC',24,NULL),(59,'48795',26,NULL),(60,'ABC',26,NULL);
/*!40000 ALTER TABLE `internal_employee_training` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leave_balance`
--

DROP TABLE IF EXISTS `leave_balance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `leave_balance` (
  `LeaveBalanceID` int unsigned NOT NULL AUTO_INCREMENT,
  `LeaveTypeID` int unsigned NOT NULL,
  `EmployeeID` varchar(20) NOT NULL,
  `NumberofLeaves` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`LeaveBalanceID`),
  KEY `leave_balance_LeaveTypeID_foreign` (`LeaveTypeID`),
  KEY `leave_balance_EmployeeID_foreign` (`EmployeeID`),
  CONSTRAINT `leave_balance_EmployeeID_foreign` FOREIGN KEY (`EmployeeID`) REFERENCES `personal_information` (`EmployeeID`),
  CONSTRAINT `leave_balance_LeaveTypeID_foreign` FOREIGN KEY (`LeaveTypeID`) REFERENCES `leave_type` (`LeaveTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leave_balance`
--

LOCK TABLES `leave_balance` WRITE;
/*!40000 ALTER TABLE `leave_balance` DISABLE KEYS */;
INSERT INTO `leave_balance` VALUES (2,1,'EMP12345',0,'2023-11-12 07:03:32','2023-11-28 19:14:53'),(3,2,'EMP12345',3,'2023-11-12 07:03:32','2023-11-12 07:03:32'),(4,3,'EMP12345',15,'2023-11-12 07:03:32','2023-11-12 07:03:32'),(5,4,'EMP12345',3,'2023-11-12 07:03:32','2023-11-12 07:03:32'),(6,1,'EMP0986',5,'2023-11-12 16:16:50','2023-11-12 16:16:50'),(7,2,'EMP0986',3,'2023-11-12 16:16:50','2023-11-12 16:16:50'),(8,3,'EMP0986',15,'2023-11-12 16:16:50','2023-11-12 16:16:50'),(9,4,'EMP0986',15,'2023-11-12 16:16:50','2023-11-12 16:16:50'),(10,1,'EMP09860',5,'2023-11-12 16:24:16','2023-11-12 16:24:16'),(11,2,'EMP09860',3,'2023-11-12 16:24:16','2023-11-12 16:24:16'),(12,3,'EMP09860',15,'2023-11-12 16:24:16','2023-11-12 16:24:16'),(13,4,'EMP09860',15,'2023-11-12 16:24:16','2023-11-12 16:24:16'),(14,1,'EMP098',5,'2023-11-12 16:30:19','2023-11-12 16:30:19'),(15,2,'EMP098',3,'2023-11-12 16:30:19','2023-11-12 16:30:19'),(16,3,'EMP098',15,'2023-11-12 16:30:19','2023-11-12 16:30:19'),(17,4,'EMP098',15,'2023-11-12 16:30:19','2023-11-12 16:30:19'),(18,1,'EMP',5,'2023-11-12 16:32:52','2023-11-12 16:32:52'),(19,2,'EMP',3,'2023-11-12 16:32:52','2023-11-12 16:32:52'),(20,3,'EMP',15,'2023-11-12 16:32:52','2023-11-12 16:32:52'),(21,4,'EMP',15,'2023-11-12 16:32:52','2023-11-12 16:32:52'),(22,1,'EMP65',5,'2023-11-13 00:48:12','2023-11-13 00:48:12'),(23,2,'EMP65',3,'2023-11-13 00:48:12','2023-11-13 00:48:12'),(24,3,'EMP65',15,'2023-11-13 00:48:12','2023-11-13 00:48:12'),(25,4,'EMP65',15,'2023-11-13 00:48:12','2023-11-13 00:48:12'),(26,1,'EMP652',5,'2023-11-13 00:54:15','2023-11-13 00:54:15'),(27,2,'EMP652',3,'2023-11-13 00:54:15','2023-11-13 00:54:15'),(28,3,'EMP652',15,'2023-11-13 00:54:15','2023-11-13 00:54:15'),(29,4,'EMP652',15,'2023-11-13 00:54:15','2023-11-13 00:54:15'),(30,1,'EMP6521',5,'2023-11-13 00:55:29','2023-11-13 00:55:29'),(31,2,'EMP6521',3,'2023-11-13 00:55:29','2023-11-13 00:55:29'),(32,3,'EMP6521',15,'2023-11-13 00:55:29','2023-11-13 00:55:29'),(33,4,'EMP6521',15,'2023-11-13 00:55:29','2023-11-13 00:55:29'),(34,1,'EMP6521s',5,'2023-11-13 00:55:41','2023-11-13 00:55:41'),(35,2,'EMP6521s',3,'2023-11-13 00:55:41','2023-11-13 00:55:41'),(36,3,'EMP6521s',15,'2023-11-13 00:55:41','2023-11-13 00:55:41'),(37,4,'EMP6521s',15,'2023-11-13 00:55:41','2023-11-13 00:55:41'),(38,1,'EMP6521s1',5,'2023-11-13 00:59:04','2023-11-13 00:59:04'),(39,2,'EMP6521s1',3,'2023-11-13 00:59:04','2023-11-13 00:59:04'),(40,3,'EMP6521s1',15,'2023-11-13 00:59:04','2023-11-13 00:59:04'),(41,4,'EMP6521s1',15,'2023-11-13 00:59:04','2023-11-13 00:59:04'),(42,1,'EMP6521s11',5,'2023-11-13 00:59:44','2023-11-13 00:59:44'),(43,2,'EMP6521s11',3,'2023-11-13 00:59:44','2023-11-13 00:59:44'),(44,3,'EMP6521s11',15,'2023-11-13 00:59:44','2023-11-13 00:59:44'),(45,4,'EMP6521s11',15,'2023-11-13 00:59:44','2023-11-13 00:59:44'),(46,1,'ABC',5,'2023-11-13 01:03:33','2023-11-13 01:03:33'),(47,2,'ABC',3,'2023-11-13 01:03:33','2023-11-13 01:03:33'),(48,3,'ABC',15,'2023-11-13 01:03:33','2023-11-13 01:03:33'),(49,4,'ABC',15,'2023-11-13 01:03:33','2023-11-13 01:03:33'),(50,1,'XYZ',5,'2023-11-13 01:42:51','2023-11-13 01:42:51'),(51,2,'XYZ',2,'2023-11-13 01:42:51','2023-12-04 16:22:49'),(52,3,'XYZ',15,'2023-11-13 01:42:51','2023-11-13 01:42:51'),(53,4,'XYZ',15,'2023-11-13 01:42:51','2023-11-13 01:42:51'),(54,1,'Z123',5,'2023-11-13 20:13:25','2023-11-13 20:13:25'),(55,2,'Z123',3,'2023-11-13 20:13:25','2023-11-13 20:13:25'),(56,3,'Z123',15,'2023-11-13 20:13:25','2023-11-13 20:13:25'),(57,4,'Z123',15,'2023-11-13 20:13:25','2023-11-13 20:13:25'),(58,1,'GIDLE',5,'2023-11-13 20:34:53','2023-11-13 20:34:53'),(59,2,'GIDLE',3,'2023-11-13 20:34:53','2023-11-13 20:34:53'),(60,3,'GIDLE',15,'2023-11-13 20:34:53','2023-11-13 20:34:53'),(61,4,'GIDLE',15,'2023-11-13 20:34:53','2023-11-13 20:34:53'),(62,1,'USER123',0,'2023-11-26 02:32:47','2023-11-28 04:01:06'),(63,2,'USER123',2,'2023-11-26 02:32:47','2023-12-09 06:41:27'),(64,3,'USER123',15,'2023-11-26 02:32:47','2023-11-26 02:32:47'),(65,4,'USER123',13,'2023-11-26 02:32:47','2023-12-09 06:16:09'),(66,1,'MCDOBOT',0,'2023-12-08 21:37:36','2023-12-08 21:37:36'),(67,2,'MCDOBOT',0,'2023-12-08 21:37:36','2023-12-08 21:37:36'),(68,3,'MCDOBOT',0,'2023-12-08 21:37:36','2023-12-08 21:37:36'),(69,4,'MCDOBOT',0,'2023-12-08 21:37:36','2023-12-08 21:37:36'),(70,1,'MCDOBOT1',0,'2023-12-08 21:43:11','2023-12-08 21:43:11'),(71,2,'MCDOBOT1',0,'2023-12-08 21:43:11','2023-12-08 21:43:11'),(72,3,'MCDOBOT1',0,'2023-12-08 21:43:11','2023-12-08 21:43:11'),(73,4,'MCDOBOT1',0,'2023-12-08 21:43:11','2023-12-08 21:43:11'),(74,1,'MCDOBOT12',0,'2023-12-08 21:44:01','2023-12-08 21:44:01'),(75,2,'MCDOBOT12',0,'2023-12-08 21:44:01','2023-12-08 21:44:01'),(76,3,'MCDOBOT12',0,'2023-12-08 21:44:01','2023-12-08 21:44:01'),(77,4,'MCDOBOT12',0,'2023-12-08 21:44:01','2023-12-08 21:44:01'),(78,1,'MCDOBOT123',0,'2023-12-08 21:54:22','2023-12-08 21:54:22'),(79,2,'MCDOBOT123',0,'2023-12-08 21:54:22','2023-12-08 21:54:22'),(80,3,'MCDOBOT123',0,'2023-12-08 21:54:22','2023-12-08 21:54:22'),(81,4,'MCDOBOT123',0,'2023-12-08 21:54:22','2023-12-08 21:54:22'),(82,1,'MCDOBOT1234',0,'2023-12-08 21:55:27','2023-12-08 21:55:27'),(83,2,'MCDOBOT1234',0,'2023-12-08 21:55:27','2023-12-08 21:55:27'),(84,3,'MCDOBOT1234',0,'2023-12-08 21:55:27','2023-12-08 21:55:27'),(85,4,'MCDOBOT1234',0,'2023-12-08 21:55:27','2023-12-08 21:55:27'),(86,1,'MCDOBOT12345',0,'2023-12-08 22:06:22','2023-12-08 22:06:22'),(87,2,'MCDOBOT12345',0,'2023-12-08 22:06:22','2023-12-08 22:06:22'),(88,3,'MCDOBOT12345',0,'2023-12-08 22:06:22','2023-12-08 22:06:22'),(89,4,'MCDOBOT12345',0,'2023-12-08 22:06:22','2023-12-08 22:06:22'),(94,1,'EMP09869',0,'2023-12-08 22:57:42','2023-12-08 22:57:42'),(95,2,'EMP09869',0,'2023-12-08 22:57:42','2023-12-08 22:57:42'),(96,3,'EMP09869',0,'2023-12-08 22:57:42','2023-12-08 22:57:42'),(97,4,'EMP09869',0,'2023-12-08 22:57:42','2023-12-08 22:57:42'),(98,1,'EMP098691',0,'2023-12-08 23:04:36','2023-12-08 23:04:36'),(99,2,'EMP098691',0,'2023-12-08 23:04:36','2023-12-08 23:04:36'),(100,3,'EMP098691',0,'2023-12-08 23:04:36','2023-12-08 23:04:36'),(101,4,'EMP098691',0,'2023-12-08 23:04:36','2023-12-08 23:04:36'),(102,1,'EMPD098691',0,'2023-12-08 23:09:46','2023-12-08 23:09:46'),(103,2,'EMPD098691',0,'2023-12-08 23:09:46','2023-12-08 23:09:46'),(104,3,'EMPD098691',0,'2023-12-08 23:09:46','2023-12-08 23:09:46'),(105,4,'EMPD098691',0,'2023-12-08 23:09:46','2023-12-08 23:09:46'),(106,1,'EMP09861',0,'2023-12-08 23:19:33','2023-12-08 23:19:33'),(107,2,'EMP09861',0,'2023-12-08 23:19:33','2023-12-08 23:19:33'),(108,3,'EMP09861',0,'2023-12-08 23:19:33','2023-12-08 23:19:33'),(109,4,'EMP09861',0,'2023-12-08 23:19:33','2023-12-08 23:19:33'),(110,1,'EMP098616',0,'2023-12-08 23:21:07','2023-12-08 23:21:07'),(111,2,'EMP098616',0,'2023-12-08 23:21:07','2023-12-08 23:21:07'),(112,3,'EMP098616',0,'2023-12-08 23:21:07','2023-12-08 23:21:07'),(113,4,'EMP098616',0,'2023-12-08 23:21:07','2023-12-08 23:21:07'),(114,1,'EMP0986161',0,'2023-12-08 23:22:53','2023-12-08 23:22:53'),(115,2,'EMP0986161',0,'2023-12-08 23:22:53','2023-12-08 23:22:53'),(116,3,'EMP0986161',0,'2023-12-08 23:22:53','2023-12-08 23:22:53'),(117,4,'EMP0986161',0,'2023-12-08 23:22:53','2023-12-08 23:22:53'),(118,1,'48795',0,'2023-12-09 02:15:44','2023-12-09 02:15:44'),(119,2,'48795',0,'2023-12-09 02:15:44','2023-12-09 02:15:44'),(120,3,'48795',0,'2023-12-09 02:15:44','2023-12-09 02:15:44'),(121,4,'48795',0,'2023-12-09 02:15:44','2023-12-09 02:15:44');
/*!40000 ALTER TABLE `leave_balance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leave_request_notes`
--

DROP TABLE IF EXISTS `leave_request_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `leave_request_notes` (
  `NoteID` int unsigned NOT NULL AUTO_INCREMENT,
  `LeaveRequestID` int unsigned NOT NULL,
  `Note` text,
  `CreatedBy` varchar(50) NOT NULL,
  `CreatedAt` datetime NOT NULL,
  `TypeOfNote` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`NoteID`),
  KEY `leave_request_notes_LeaveRequestID_foreign` (`LeaveRequestID`),
  CONSTRAINT `leave_request_notes_LeaveRequestID_foreign` FOREIGN KEY (`LeaveRequestID`) REFERENCES `employee_leaves` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leave_request_notes`
--

LOCK TABLES `leave_request_notes` WRITE;
/*!40000 ALTER TABLE `leave_request_notes` DISABLE KEYS */;
INSERT INTO `leave_request_notes` VALUES (1,22,'Ayoko nga','EMP12345','2023-12-10 03:50:28','rejection');
/*!40000 ALTER TABLE `leave_request_notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leave_type`
--

DROP TABLE IF EXISTS `leave_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `leave_type` (
  `LeaveTypeID` int unsigned NOT NULL AUTO_INCREMENT,
  `LeaveTypeName` text NOT NULL,
  `DefaultLeaveCount` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`LeaveTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leave_type`
--

LOCK TABLES `leave_type` WRITE;
/*!40000 ALTER TABLE `leave_type` DISABLE KEYS */;
INSERT INTO `leave_type` VALUES (1,'Mandatory Leave',5,'2023-11-12 06:50:10','2023-11-12 06:50:10'),(2,'Special Privilege Leave',3,'2023-11-12 06:50:10','2023-11-12 06:50:10'),(3,'Vacation Leave',15,'2023-11-12 06:50:10','2023-11-12 06:50:10'),(4,'Sick Leave',15,'2023-11-12 06:50:10','2023-11-12 06:50:10');
/*!40000 ALTER TABLE `leave_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2023-11-19-055920','App\\Database\\Migrations\\PersonalInformation','default','App',1700393599,1),(2,'2023-11-19-060041','App\\Database\\Migrations\\AuthenticationRole','default','App',1700393599,1),(3,'2023-11-19-060156','App\\Database\\Migrations\\EmployeeAuthrole','default','App',1700393599,1),(4,'2023-11-19-060258','App\\Database\\Migrations\\Section','default','App',1700393599,1),(5,'2023-11-19-060355','App\\Database\\Migrations\\EmployeeSection','default','App',1700393599,1),(6,'2023-11-19-060453','App\\Database\\Migrations\\LeaveType','default','App',1700393599,1),(7,'2023-11-19-060549','App\\Database\\Migrations\\LeaveBalance','default','App',1700393599,1),(8,'2023-11-19-060644','App\\Database\\Migrations\\Designation','default','App',1700393599,1),(9,'2023-11-19-060808','App\\Database\\Migrations\\EmployeeDesignation','default','App',1700393599,1),(10,'2023-11-19-061244','App\\Database\\Migrations\\Position','default','App',1700393599,1),(11,'2023-11-19-061355','App\\Database\\Migrations\\EmployeePosition','default','App',1700393599,1),(12,'2023-11-19-061719','App\\Database\\Migrations\\FamilyBackground','default','App',1700393599,1),(13,'2023-11-19-061814','App\\Database\\Migrations\\Children','default','App',1700393599,1),(14,'2023-11-19-062043','App\\Database\\Migrations\\Address','default','App',1700393599,1),(15,'2023-11-19-062133','App\\Database\\Migrations\\EducationalBackground','default','App',1700393599,1),(16,'2023-11-19-062224','App\\Database\\Migrations\\TrainingPrograms','default','App',1700393599,1),(17,'2023-11-19-062323','App\\Database\\Migrations\\CivilServiceEligibility','default','App',1700393599,1),(18,'2023-11-19-062410','App\\Database\\Migrations\\WorkExperience','default','App',1700393599,1),(19,'2023-11-19-062531','App\\Database\\Migrations\\VoluntaryWork','default','App',1700393599,1),(20,'2023-11-19-062618','App\\Database\\Migrations\\OtherInformation','default','App',1700393599,1),(21,'2023-11-19-062749','App\\Database\\Migrations\\PdSheetQuestions','default','App',1700393599,1),(22,'2023-11-19-062835','App\\Database\\Migrations\\ReferencesTbl','default','App',1700393600,1),(23,'2023-11-19-062919','App\\Database\\Migrations\\GovernmentIssuedIds','default','App',1700393600,1),(24,'2023-11-19-063337','App\\Database\\Migrations\\Department','default','App',1700393600,1),(25,'2023-11-19-063617','App\\Database\\Migrations\\ProvincialOffice','default','App',1700393600,1),(26,'2023-11-19-063727','App\\Database\\Migrations\\RegionalOffice','default','App',1700393600,1),(27,'2023-11-19-064540','App\\Database\\Migrations\\Procurement','default','App',1700393600,1),(28,'2023-11-19-065040','App\\Database\\Migrations\\AssetType','default','App',1700393600,1),(29,'2023-11-19-065134','App\\Database\\Migrations\\Asset','default','App',1700393600,1),(30,'2023-11-19-065747','App\\Database\\Migrations\\AssetStatus','default','App',1700393600,1),(31,'2023-11-19-065941','App\\Database\\Migrations\\AssetLocation','default','App',1700393600,1),(32,'2023-11-19-070316','App\\Database\\Migrations\\AssetAudit','default','App',1700393600,1),(33,'2023-11-19-071243','App\\Database\\Migrations\\Training','default','App',1700393600,1),(34,'2023-11-19-071320','App\\Database\\Migrations\\InternalEmployeeTraining','default','App',1700393600,1),(35,'2023-11-19-071521','App\\Database\\Migrations\\EmployeeAddress','default','App',1700393600,1),(36,'2023-11-19-105500','App\\Database\\Migrations\\ProcurementStatus','default','App',1700393693,2),(37,'2023-11-19-111102','App\\Database\\Migrations\\ProcurementUpdate','default','App',1700393693,2),(38,'2023-11-19-151828','App\\Database\\Migrations\\ProcurementStatusUpdate','default','App',1700407238,3),(39,'2023-11-19-232824','App\\Database\\Migrations\\ProcurementStatusUpdate','default','App',1700436665,4),(40,'2023-11-20-002108','App\\Database\\Migrations\\PersonalInformationPhoto','default','App',1700439686,5),(41,'2023-11-23-101630','App\\Database\\Migrations\\Trainingupdate1','default','App',1700734775,6),(42,'2023-11-23-152523','App\\Database\\Migrations\\EmployeeTrainingUpdate','default','App',1700753168,7),(43,'2023-11-24-012406','App\\Database\\Migrations\\CreateEmployeeLeave','default','App',1700789117,8),(44,'2023-11-26-104428','App\\Database\\Migrations\\Updateonemployeeleave','default','App',1700995483,9),(45,'2023-12-08-222319','App\\Database\\Migrations\\CreateLeaveRequestNotesTable','default','App',1702074305,10),(46,'2023-12-08-230032','App\\Database\\Migrations\\AlterLeaveRequestNotesTable','default','App',1702076451,11),(47,'2023-12-09-052054','App\\Database\\Migrations\\Updateaddressfk','default','App',1702099818,12),(49,'2023-12-09-053150','App\\Database\\Migrations\\Updateaddressfk','default','App',1702100208,13),(50,'2023-12-09-053717','App\\Database\\Migrations\\Address','default','App',1702100244,14),(51,'2023-12-09-054135','App\\Database\\Migrations\\AddressUpdate','default','App',1702100548,15),(52,'2023-12-09-060433','App\\Database\\Migrations\\AddVocationalAndGraduateStudiesToLevelEnum','default','App',1702101885,16),(53,'2023-12-09-065720','App\\Database\\Migrations\\CivilServiceAlter','default','App',1702105053,17),(54,'2023-12-10-020736','App\\Database\\Migrations\\AddArticleToAsset','default','App',1702174181,18),(55,'2023-12-10-043010','App\\Database\\Migrations\\DeleteAssetLocation','default','App',1702182622,19),(57,'2023-12-10-043043','App\\Database\\Migrations\\RemakeAssetLocation','default','App',1702183381,20),(58,'2023-12-10-054929','App\\Database\\Migrations\\DeleteAssetAudit','default','App',1702187399,21),(59,'2023-12-10-055509','App\\Database\\Migrations\\AssetAudit','default','App',1702187723,22);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `other_information`
--

DROP TABLE IF EXISTS `other_information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `other_information` (
  `info_id` int NOT NULL AUTO_INCREMENT,
  `EmployeeID` varchar(20) NOT NULL,
  `special_skills_hobbies` text,
  `non_academic_distinctions_recognition` text,
  `membership_association_organization` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`info_id`),
  KEY `other_information_EmployeeID_foreign` (`EmployeeID`),
  CONSTRAINT `other_information_EmployeeID_foreign` FOREIGN KEY (`EmployeeID`) REFERENCES `personal_information` (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `other_information`
--

LOCK TABLES `other_information` WRITE;
/*!40000 ALTER TABLE `other_information` DISABLE KEYS */;
INSERT INTO `other_information` VALUES (1,'EMP0986161','Sleeping','None','None','2023-12-08 23:22:53','2023-12-08 23:22:53'),(2,'48795','hello','hello','hello','2023-12-09 02:15:44','2023-12-09 02:15:44');
/*!40000 ALTER TABLE `other_information` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pd_sheet_questions`
--

DROP TABLE IF EXISTS `pd_sheet_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pd_sheet_questions` (
  `question_id` int unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeID` varchar(20) NOT NULL,
  `question_code` varchar(20) NOT NULL,
  `question_text` text NOT NULL,
  `answer` enum('Yes','No') NOT NULL,
  `details` text,
  `date_of_event` date DEFAULT NULL,
  `status_or_remarks` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`question_id`),
  KEY `pd_sheet_questions_EmployeeID_foreign` (`EmployeeID`),
  CONSTRAINT `pd_sheet_questions_EmployeeID_foreign` FOREIGN KEY (`EmployeeID`) REFERENCES `personal_information` (`EmployeeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pd_sheet_questions`
--

LOCK TABLES `pd_sheet_questions` WRITE;
/*!40000 ALTER TABLE `pd_sheet_questions` DISABLE KEYS */;
/*!40000 ALTER TABLE `pd_sheet_questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_information`
--

DROP TABLE IF EXISTS `personal_information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_information` (
  `EmployeeID` varchar(20) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `name_extension` varchar(10) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `place_of_birth` varchar(100) DEFAULT NULL,
  `sex` enum('M','F') NOT NULL,
  `civil_status` varchar(20) DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `blood_type` varchar(5) DEFAULT NULL,
  `gsis_id_no` varchar(20) DEFAULT NULL,
  `pag_ibig_id_no` varchar(20) DEFAULT NULL,
  `philhealth_no` varchar(20) DEFAULT NULL,
  `sss_no` varchar(20) DEFAULT NULL,
  `tin_no` varchar(20) DEFAULT NULL,
  `agency_employee_no` varchar(20) DEFAULT NULL,
  `citizenship` varchar(50) NOT NULL,
  `dual_citizenship_type` varchar(25) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `telephone_no` varchar(15) DEFAULT NULL,
  `mobile_no` varchar(15) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `DateOfEntry` date NOT NULL,
  `IPCR` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `photo` text,
  PRIMARY KEY (`EmployeeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_information`
--

LOCK TABLES `personal_information` WRITE;
/*!40000 ALTER TABLE `personal_information` DISABLE KEYS */;
INSERT INTO `personal_information` VALUES ('48795','Garcia','Mike','','Santos','1988-03-16','Batangas City','M','Single',78.00,75.00,'A-','789544521','79658412','32147841','3246598762','15795441369','84697','Filipino',NULL,'','9874586','0978463591','mike@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$SkgwckM4TWZnWDc1YVYuUQ$Qz3MnAbRIz08CNkM4+QBoEvVOPsMwzKxckSutZiQDh0','2020-10-12',45216,'2023-12-09 02:15:44','2023-12-09 02:15:44',NULL),('ABC','Jo','Yuri','','Choi','1988-11-30','America','F','Single',150.10,40.70,'A+','42324242','4242311121','212131313','3131311313','99837434','1E18812812','Dual Citizenship','by birth','Korea, Democratic People\"S Republic of','987-4567','09987654321','joyuri@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$bmdCRVYuUmVaZTk5TXdJUQ$DpmWcDcclb2JzVhK/qOdsMCefztPNEPtZa3C6SKiSKk','2023-11-13',5,'2023-11-12 17:03:33','2023-11-19 16:45:16','1700441116_c7d3745ac74616ef2eb7.jpg'),('EMP','Doe','Johna','','Mae','1979-11-12','America','F','Married',150.10,40.70,'AB+','42324242','4242311121','212131313','3131311313','99837434','1E18812812','Dual Citizenship','by naturalization','Afghanistan','987-4567','09987654321','jdayenkenneth@email.com','$argon2id$v=19$m=65536,t=4,p=1$MmhzeUM5QWZtMXUxOUtTLw$sNIAwy0aqPwXifm6YCcbPp61QcCtNrPpFNXbJyfywVs','2023-11-13',5,'2023-11-12 08:32:52','2023-11-20 03:11:13','1700478673_15d1e95a479c8b283d3a.png'),('EMP098','Doe','Johna','','Mae','1979-11-12','America','F','Married',150.10,40.70,'AB+','42324242','4242311121','212131313','3131311313','99837434','1E18812812','Dual Citizenship','by naturalization','MV','987-4567','09987654321','johna.doez@email.com','$argon2id$v=19$m=65536,t=4,p=1$NldGL2VldHVJd0xnR2Z4Zw$8loUQ/w12wsqGO0VWGXwupNf5nVWF6kE6Wm9V0gLCAk','2023-11-13',5,'2023-11-12 08:30:19','2023-11-12 08:30:19',NULL),('EMP0986','Doe','Johna','','Mae','1979-11-12','America','F','Married',150.10,40.70,'AB+','42324242','4242311121','212131313','3131311313','99837434','1E18812812','Dual Citizenship','by naturalization','MV','987-4567','09987654321','johna.doe@email.com','$argon2id$v=19$m=65536,t=4,p=1$ek4zMG5DaE9hR3FHb1NOTw$MJEFEJ4HtkpIHpBSBc1q7pctrLPYRMs6jd7OJJ3aYhc','2023-11-13',5,'2023-11-12 08:16:50','2023-11-12 08:16:50',NULL),('EMP09860','Doe','Johna','','Mae','1979-11-12','America','F','Married',150.10,40.70,'AB+','42324242','4242311121','212131313','3131311313','99837434','1E18812812','Dual Citizenship','by naturalization','MV','987-4567','09987654321','johna.doez@email.com','$argon2id$v=19$m=65536,t=4,p=1$dkR0RVl3V0FDTng0WDd3SA$zd6vGQtHl8/EQz9clnnmP8aLTGgeLSHmv0wuwQm0kPw','2023-11-13',5,'2023-11-12 08:24:16','2023-11-12 08:24:16',NULL),('EMP09861','Doe','Johnas','','Mae','2004-12-22','Seoul','F','Single',150.10,40.70,'A+','42324242','4242311121','212131313','3131311313','99837434','1E18812812','Dual Citizenship','by naturalization','Afghanistan','987-4567','09987654321','abs@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$a1o1OXMwdnNDSjhKcnhVaA$WSoKQoGerwmKWjaxSSCSnkhcJQuu0Z/6G2nxSbN+3l4','2023-12-09',5,'2023-12-08 23:19:32','2023-12-08 23:19:32',NULL),('EMP098616','Doe','Johnas','','Mae','2004-12-22','Seoul','F','Single',150.10,40.70,'A+','42324242','4242311121','212131313','3131311313','99837434','1E18812812','Dual Citizenship','by naturalization','Afghanistan','987-4567','09987654321','abs@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$bkxBQkFETWowdmhsTDdwag$QKRh2UJjYYymHuoy/mcAo3I9q4OXCbRV0oWvBhRVLwU','2023-12-09',5,'2023-12-08 23:21:07','2023-12-08 23:21:07',NULL),('EMP0986161','Doe','Johnas','','Mae','2004-12-22','Seoul','F','Single',150.10,40.70,'A+','42324242','4242311121','212131313','3131311313','99837434','1E18812812','Dual Citizenship','by naturalization','Afghanistan','987-4567','09987654321','abs@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$UmxoLkJUWmRqTFM4ekh0cA$hSGkkWbGUBISDupQ90CZtZ2TGO9ZZcxcBuE1k2K1F9M','2023-12-09',5,'2023-12-08 23:22:53','2023-12-08 23:22:53',NULL),('EMP09869','Jang','Johna','','Mae','2023-12-06','America','F','Single',150.10,40.70,'A+','42324242','4242311121','212131313','3131311313','99837434','1E18812812','Filipino',NULL,'','987-4567','09987654321','k212@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$Y0dkbXFzSm41bzlYdmZpUw$6l1+iAKW5XW5g/HTqR0NSfteCxF9bY6uyPhzEyUEA2Y','2023-12-09',5,'2023-12-08 22:57:42','2023-12-08 22:57:42',NULL),('EMP098691','Jang','Johna','','Mae','2023-12-06','America','F','Single',150.10,40.70,'A+','42324242','4242311121','212131313','3131311313','99837434','1E18812812','Filipino',NULL,'','987-4567','09987654321','k212@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$em9Ka3VrdHA0VWR2RWpXMw$1ew9Y8JXQXIwa4GIGbbHOdGPjJlgNCDPfPrmWT4ncUA','2023-12-09',5,'2023-12-08 23:04:36','2023-12-08 23:04:36',NULL),('EMP12345','Doe','John','Jr.','Smith','1990-01-01','Cityville','M','Single',175.50,70.20,'O+','123456789','987654321','123123123','321321321','111222333','AEN123456','Filipino',NULL,'','123-4567','+639171234567','johndoe@email.com','$argon2id$v=19$m=65536,t=4,p=1$MEhMRkZsRWt5VXZZL1ZGbw$LdL/JaTGXnEwGaUk4pXGRMXRPSo6G+jySx9FoxFmmaY','2023-01-01',5,'2023-11-11 23:03:32','2023-11-11 23:03:32',NULL),('EMP65','Jo','Yuri','','Choi','1988-11-13','America','F','Single',150.10,40.70,'A+','42324242','4242311121','212131313','3131311313','99837434','1E18812812','Dual Citizenship','by birth','Korea, Democratic People\"S Republic of','987-4567','09987654321','joyuri@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$Y0ptaUdDRkdpdFBDWkxuYg$wUDrgJF39tZjtKww5cKorfQDAlI/X+/tx3kA8hKK9ik','2023-11-13',5,'2023-11-12 16:48:12','2023-11-12 16:48:12',NULL),('EMP652','Jo','Yuri','','Choi','1988-11-13','America','F','Single',150.10,40.70,'A+','42324242','4242311121','212131313','3131311313','99837434','1E18812812','Dual Citizenship','by birth','Korea, Democratic People\"S Republic of','987-4567','09987654321','joyuri@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$MWc3Zkh6c014aHhmMFRPSg$TtrI8fX3w7JVNMA2GakDzrdACMh9HrbETUq7uKlyzDE','2023-11-13',5,'2023-11-12 16:54:15','2023-11-12 16:54:15',NULL),('EMP6521','Jo','Yuri','','Choi','1988-11-13','America','F','Single',150.10,40.70,'A+','42324242','4242311121','212131313','3131311313','99837434','1E18812812','Dual Citizenship','by birth','Korea, Democratic People\"S Republic of','987-4567','09987654321','joyuri@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$b1pUcC9ObFR2Q09adWNPQw$vHFz/uP+CsQK45SkpajC0+IfFVEMtUz0wJ+5Yke5l04','2023-11-13',5,'2023-11-12 16:55:29','2023-11-12 16:55:29',NULL),('EMP6521s','Jo','Yuri','','Choi','1988-11-13','America','F','Single',150.10,40.70,'A+','42324242','4242311121','212131313','3131311313','99837434','1E18812812','Dual Citizenship','by birth','Korea, Democratic People\"S Republic of','987-4567','09987654321','joyuri@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$ZkpXb3pxL0Jtc2pDVTlmaA$ijuRdMbLFCfFMcOMjEeRghLYKNq2QWsyrQJOJCplSvw','2023-11-13',5,'2023-11-12 16:55:41','2023-11-12 16:55:41',NULL),('EMP6521s1','Jo','Yuri','','Choi','1988-11-13','America','F','Single',150.10,40.70,'A+','42324242','4242311121','212131313','3131311313','99837434','1E18812812','Dual Citizenship','by birth','Korea, Democratic People\"S Republic of','987-4567','09987654321','joyuri@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$Lk1KaTVjQkNEUHVsdlZoLw$G0QX0woQ29in+/fhsQ+wTZEYueJ4jveTH5u0uzQiQR8','2023-11-13',5,'2023-11-12 16:59:04','2023-11-12 16:59:04',NULL),('EMP6521s11','Jo','Yuri','','Choi','1988-11-13','America','F','Single',150.10,40.70,'A+','42324242','4242311121','212131313','3131311313','99837434','1E18812812','Dual Citizenship','by birth','Korea, Democratic People\"S Republic of','987-4567','09987654321','joyuri@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$UUp5ck01UDc4TDhCcUJJMg$9sCmkUEzamrhebmwpBNGJN4QEqhK7+oyyssCnH2mjSo','2023-11-13',5,'2023-11-12 16:59:44','2023-11-12 16:59:44',NULL),('EMPD098691','Jang','Johna','','Mae','2023-12-06','America','F','Single',150.10,40.70,'A+','42324242','4242311121','212131313','3131311313','99837434','1E18812812','Filipino',NULL,'','987-4567','09987654321','k212@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$SWdhZHZpTzRYWGRyN0JUYg$F1ZHxFINkhmh4azuML74E3C2vDMz8qXnK1V70BXBQsg','2023-12-09',5,'2023-12-08 23:09:46','2023-12-08 23:09:46',NULL),('GIDLE','sas','sasa','','Mae','2023-11-14','America','M','Single',150.10,40.70,'AB-','42324242','4242311121','212131313','3131311313','99837434','1E18812812','Filipino',NULL,'','987-4567','09987654321','dyze@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$YXc0blJBWVlsTjlTUlRtaw$o1HoeS2lTmxmD9X0VSBuMUJJF7oMo2ejvdgUuXE1ulU','2023-11-28',5,'2023-11-13 12:34:53','2023-11-13 12:34:53',NULL),('MCDOBOT','MC','Do','','Libee','2023-12-20','America','M','Single',150.10,40.70,'A+','42324242','4242311121','212131313','3131311313','99837434','1E18812812','Filipino',NULL,'','987-4567','09987654321','mcdo@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$cG9VQVRUQkgzb3QxMFRCdg$C0ddxofoigHpCPA0lWQI0iYCeD8/7qBLTfS3cxlR9Zc','2023-12-09',5,'2023-12-08 21:37:36','2023-12-08 21:37:36',NULL),('MCDOBOT1','MC','Do','','Libee','2023-12-20','America','M','Single',150.10,40.70,'A+','42324242','4242311121','212131313','3131311313','99837434','1E18812812','Filipino',NULL,'','987-4567','09987654321','mcdo@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$a2ljS09Eam1Da2ZwaExPTg$Ppm0dNpYZ0YHBMksRr5B6+deKxD4Ile9UMmGSaxZ/Mw','2023-12-09',5,'2023-12-08 21:43:11','2023-12-08 21:43:11',NULL),('MCDOBOT12','MC','Do','','Libee','2023-12-20','America','M','Single',150.10,40.70,'A+','42324242','4242311121','212131313','3131311313','99837434','1E18812812','Filipino',NULL,'','987-4567','09987654321','mcdo1@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$TjZ1TTFBR0IxUXRueHZPUg$mdbQDZDj3v6pAqvyCAzbAmOJJ9CrNuUcWQXlHruCib8','2023-12-09',5,'2023-12-08 21:44:01','2023-12-08 21:44:01',NULL),('MCDOBOT123','MC','Do','','Libee','2023-12-20','America','M','Single',150.10,40.70,'A+','42324242','4242311121','212131313','3131311313','99837434','1E18812812','Filipino',NULL,'','987-4567','09987654321','mcdo12@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$Z1FYWXRFL2gubTBZVzNweA$iU1Iy3fVlwUhbccFUPAJ+uQ6Wvyr5C0puJWsw0j51dw','2023-12-09',5,'2023-12-08 21:54:22','2023-12-08 21:54:22',NULL),('MCDOBOT1234','MC','Do','','Libee','2023-12-20','America','M','Single',150.10,40.70,'A+','42324242','4242311121','212131313','3131311313','99837434','1E18812812','Filipino',NULL,'','987-4567','09987654321','mcdo123@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$ZnZoNjBwWGJodk1LTkdnbw$IYkG91dh2n3ynJdrFUwpxSYKVa/3LBP1/NjGAz6oIqY','2023-12-09',5,'2023-12-08 21:55:27','2023-12-08 21:55:27',NULL),('MCDOBOT12345','MC','Do','','Libee','2023-12-20','America','M','Single',150.10,40.70,'A+','42324242','4242311121','212131313','3131311313','99837434','1E18812812','Filipino',NULL,'','987-4567','09987654321','mcdo1234@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$enZGWVlHT3BHZWc0eFBFZQ$x85YkoPfAGN3NK7zOPaeNKNIua55MYw7kYUeV1SYnC4','2023-12-09',5,'2023-12-08 22:06:22','2023-12-08 22:06:22',NULL),('USER123','User','Doe','','Thea','2023-11-26','America','F','Single',150.10,40.00,'A+','42324242','4242311121','212131313','3131311313','99837434','1E18812812','Filipino',NULL,'','987-4567','09987654321','userdoe@email.com','$argon2id$v=19$m=65536,t=4,p=1$dWguS2tRN2dQNVlmLm5QOA$Zh4q4ZtMm5kmys1OJ0leVQbUbeo134cHaiFgU1kcqXI','2023-11-26',3,'2023-11-26 02:32:47','2023-11-26 02:32:47',NULL),('XYZ','Jang','Wonyoung','','Thea','2004-08-01','Seoul','F','Single',171.00,40.00,'AB+','42324242','4242311121','212131313','3131311313','99837434','1E18812812','Dual Citizenship','by naturalization','Korea, Democratic People\"S Republic of','987-4567','09987654321','wonyoung@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$Ym96dTRWTFlqOGJVR3FiSw$nQecl1P41X6y59i2rVs3tr9Ovei/G4lxzT2FSlCL7/8','2023-11-13',5,'2023-11-12 17:42:51','2023-11-12 17:42:51',NULL),('Z123','Hanni','New','','Jeans','2002-11-13','Seoul','F','Single',150.10,40.70,'O-','42324242','4242311121','212131313','3131311313','99837434','1E18812812','Filipino',NULL,'','987-4567','09987654321','hanni@email.com','$argon2id$v=19$m=65536,t=4,p=1$ZGM3UUVkZHlFNFhOTDl1Mg$BGZWNGt+mgZb8QIvMlJ4PyF8B15c1Fkxa5xYkX4j7RE','2023-11-14',5,'2023-11-13 12:13:25','2023-11-13 12:13:25',NULL);
/*!40000 ALTER TABLE `personal_information` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `position`
--

DROP TABLE IF EXISTS `position`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `position` (
  `PositionID` int unsigned NOT NULL AUTO_INCREMENT,
  `PositionName` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`PositionID`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `position`
--

LOCK TABLES `position` WRITE;
/*!40000 ALTER TABLE `position` DISABLE KEYS */;
INSERT INTO `position` VALUES (1,'Office of the Director-General','2023-11-12 08:11:17','2023-11-12 08:11:17'),(2,'Chief of Staff','2023-11-12 08:11:17','2023-11-12 08:11:17'),(3,'Office of the Deputy Director-General for Administration','2023-11-12 08:11:17','2023-11-12 08:11:17'),(4,'Office of the Deputy Director-General for Operations','2023-11-12 08:11:17','2023-11-12 08:11:17'),(5,'Human Resource Management Service (HRMS)','2023-11-12 08:11:17','2023-11-12 08:11:17'),(6,'Financial Management Service (FMS)','2023-11-12 08:11:17','2023-11-12 08:11:17'),(7,'Logistics and Administrative Management Service (LAMS)','2023-11-12 08:11:17','2023-11-12 08:11:17'),(8,'Internal Affairs Service (IAS)','2023-11-12 08:11:17','2023-11-12 08:11:17'),(9,'PDEA Academy','2023-11-12 08:11:17','2023-11-12 08:11:17'),(10,'Intelligence and Investigation Service (IIS)','2023-11-12 08:11:17','2023-11-12 08:11:17'),(11,'Plans and Operations Service (POS)','2023-11-12 08:11:17','2023-11-12 08:11:17'),(12,'Legal and Prosecution Service (LPS)','2023-11-12 08:11:17','2023-11-12 08:11:17'),(13,'Compliance Service (CS)','2023-11-12 08:11:17','2023-11-12 08:11:17'),(14,'International Cooperation and Foreign Affairs Service (ICFAS)','2023-11-12 08:11:17','2023-11-12 08:11:17'),(15,'Preventive Education and Community Involvement Service (PECIS)','2023-11-12 08:11:17','2023-11-12 08:11:17'),(16,'Special Enforcement Service (SES)','2023-11-12 08:11:17','2023-11-12 08:11:17'),(17,'Laboratory Service (LS)','2023-11-12 08:11:17','2023-11-12 08:11:17'),(18,'Public Information Office (PIO)','2023-11-12 08:11:17','2023-11-12 08:11:17');
/*!40000 ALTER TABLE `position` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `procurement`
--

DROP TABLE IF EXISTS `procurement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `procurement` (
  `procurement_id` int NOT NULL AUTO_INCREMENT,
  `project_particulars` varchar(255) NOT NULL,
  `date_of_receipt_of_request` date NOT NULL,
  `purchase_work_job_request_no` int NOT NULL,
  `purchase_work_job_request_date` date NOT NULL,
  `philgeps_posting` tinyint(1) NOT NULL DEFAULT '0',
  `abstract_of_canvas_no` int NOT NULL,
  `abstract_of_canvas_date` date NOT NULL,
  `price_quotation_no` int NOT NULL,
  `price_quotation_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `EmployeeID` varchar(20) DEFAULT NULL,
  `department_id` int DEFAULT NULL,
  `provincial_office_id` int DEFAULT NULL,
  `regional_office_id` int unsigned DEFAULT NULL,
  `supplier` varchar(255) NOT NULL,
  `date_request_for_fund` date NOT NULL,
  `ideal_no_of_days_to_complete` int NOT NULL,
  `actual_days_to_complete` int NOT NULL,
  `difference` int NOT NULL,
  `purchase_order` varchar(255) NOT NULL,
  `delivery_status` varchar(50) NOT NULL,
  `remarks` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `item_status` enum('Active','Archived') NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`procurement_id`),
  KEY `procurement_EmployeeID_foreign` (`EmployeeID`),
  KEY `procurement_department_id_foreign` (`department_id`),
  KEY `procurement_provincial_office_id_foreign` (`provincial_office_id`),
  KEY `procurement_regional_office_id_foreign` (`regional_office_id`),
  CONSTRAINT `procurement_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`),
  CONSTRAINT `procurement_EmployeeID_foreign` FOREIGN KEY (`EmployeeID`) REFERENCES `personal_information` (`EmployeeID`),
  CONSTRAINT `procurement_provincial_office_id_foreign` FOREIGN KEY (`provincial_office_id`) REFERENCES `provincial_office` (`provincial_office_id`),
  CONSTRAINT `procurement_regional_office_id_foreign` FOREIGN KEY (`regional_office_id`) REFERENCES `regional_office` (`regional_office_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `procurement`
--

LOCK TABLES `procurement` WRITE;
/*!40000 ALTER TABLE `procurement` DISABLE KEYS */;
INSERT INTO `procurement` VALUES (9,'Office Supplies Acquisition','2023-11-20',111,'2023-11-20',1,443,'2023-11-21',111,'2023-11-21',1000.00,'EMP12345',NULL,NULL,NULL,'Supplier Y','2023-11-28',50,12,0,'N/A','In Transit','Awaiting delivery of items','2023-11-19 07:20:43','2023-11-19 07:20:43','Active'),(10,'Secret','2023-11-21',1112,'2023-11-21',1,443,'2023-11-29',2121,'2023-11-09',2000.00,NULL,NULL,1,NULL,'ABC','2023-11-27',10,12,0,'N/A','On Hold','Awaiting delivery of items','2023-11-19 15:32:03','2023-11-19 21:16:41','Archived'),(11,'Stocking of Supplies','2023-11-24',1113,'2023-11-22',1,443,'2023-11-29',333,'2023-11-24',1000.00,NULL,NULL,NULL,1,'ABC','2023-12-05',100,10,-90,'N/A','On Hold','Awaiting delivery of items','2023-11-20 20:34:14','2023-11-25 21:38:12','Archived'),(12,'Office Supplies Acquisition','2023-11-02',111,'2023-11-14',1,443,'2023-11-23',2121,'2023-11-16',1000.00,'EMP',NULL,NULL,NULL,'Supplier Z','2023-11-22',10,111,101,'N/A','On Hold','Wala naman','2023-11-20 21:15:48','2023-11-20 21:50:40','Archived');
/*!40000 ALTER TABLE `procurement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `procurement_status`
--

DROP TABLE IF EXISTS `procurement_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `procurement_status` (
  `status_ID` int unsigned NOT NULL AUTO_INCREMENT,
  `procurement_id` int DEFAULT NULL,
  `status_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`status_ID`),
  KEY `fk_procurement` (`procurement_id`),
  CONSTRAINT `fk_procurement` FOREIGN KEY (`procurement_id`) REFERENCES `procurement` (`procurement_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `procurement_status`
--

LOCK TABLES `procurement_status` WRITE;
/*!40000 ALTER TABLE `procurement_status` DISABLE KEYS */;
INSERT INTO `procurement_status` VALUES (9,9,'Pending'),(10,10,'Pending'),(11,11,'Pending'),(12,12,'Rejected');
/*!40000 ALTER TABLE `procurement_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provincial_office`
--

DROP TABLE IF EXISTS `provincial_office`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `provincial_office` (
  `provincial_office_id` int NOT NULL AUTO_INCREMENT,
  `office_name` varchar(255) NOT NULL,
  `location` text NOT NULL,
  PRIMARY KEY (`provincial_office_id`),
  UNIQUE KEY `office_name` (`office_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provincial_office`
--

LOCK TABLES `provincial_office` WRITE;
/*!40000 ALTER TABLE `provincial_office` DISABLE KEYS */;
INSERT INTO `provincial_office` VALUES (1,'PDEA Mimaropa Office 1','Marinduque'),(2,'PDEA Mimaropa Office 2','Occidental Mindoro'),(3,'PDEA Mimaropa Office 3','Oriental Mindoro'),(4,'PDEA Mimaropa Office 4','Palawan'),(5,'PDEA Mimaropa Office 5','Romblon');
/*!40000 ALTER TABLE `provincial_office` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `references_tbl`
--

DROP TABLE IF EXISTS `references_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `references_tbl` (
  `reference_id` int unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeID` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text,
  `telephone_no` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`reference_id`),
  KEY `references_tbl_EmployeeID_foreign` (`EmployeeID`),
  CONSTRAINT `references_tbl_EmployeeID_foreign` FOREIGN KEY (`EmployeeID`) REFERENCES `personal_information` (`EmployeeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `references_tbl`
--

LOCK TABLES `references_tbl` WRITE;
/*!40000 ALTER TABLE `references_tbl` DISABLE KEYS */;
/*!40000 ALTER TABLE `references_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `regional_office`
--

DROP TABLE IF EXISTS `regional_office`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `regional_office` (
  `regional_office_id` int unsigned NOT NULL AUTO_INCREMENT,
  `regional_office_name` varchar(255) NOT NULL,
  PRIMARY KEY (`regional_office_id`),
  UNIQUE KEY `regional_office_name` (`regional_office_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `regional_office`
--

LOCK TABLES `regional_office` WRITE;
/*!40000 ALTER TABLE `regional_office` DISABLE KEYS */;
INSERT INTO `regional_office` VALUES (1,'PDEA MIMAROPA');
/*!40000 ALTER TABLE `regional_office` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `section`
--

DROP TABLE IF EXISTS `section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `section` (
  `SectionID` int unsigned NOT NULL AUTO_INCREMENT,
  `SectionName` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`SectionID`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `section`
--

LOCK TABLES `section` WRITE;
/*!40000 ALTER TABLE `section` DISABLE KEYS */;
INSERT INTO `section` VALUES (1,'Human Resource and Records Section (HRRS)','2023-11-12 08:11:03','2023-11-12 08:11:03'),(2,'Logistics and Management Section (LAMS)','2023-11-12 08:11:03','2023-11-12 08:11:03'),(3,'Finance Section','2023-11-12 08:11:03','2023-11-12 08:11:03'),(4,'Preventive Education and Community Involvement (PECI) Section','2023-11-12 08:11:03','2023-11-12 08:11:03'),(5,'Legal Section','2023-11-12 08:11:03','2023-11-12 08:11:03'),(6,'Compliance Section','2023-11-12 08:11:03','2023-11-12 08:11:03'),(7,'Laboratory Section','2023-11-12 08:11:03','2023-11-12 08:11:03'),(8,'Intelligence and Investigation Section','2023-11-12 08:11:03','2023-11-12 08:11:03'),(9,'Regional Operations Center (ROC)','2023-11-12 08:11:03','2023-11-12 08:11:03'),(10,'Barangay Drug Clearing Program (BDCP) Team','2023-11-12 08:11:03','2023-11-12 08:11:03'),(11,'Regional Special Enforcement Team (RSET)','2023-11-12 08:11:03','2023-11-12 08:11:03'),(12,'Oriental Mindoro Provincial Office','2023-11-12 08:11:03','2023-11-12 08:11:03'),(13,'Occidental Mindoro Provincial Office','2023-11-12 08:11:03','2023-11-12 08:11:03'),(14,'Marinduque Provincial Office','2023-11-12 08:11:03','2023-11-12 08:11:03'),(15,'Romblon Provincial Office','2023-11-12 08:11:03','2023-11-12 08:11:03'),(16,'Palawan Provincial Office','2023-11-12 08:11:03','2023-11-12 08:11:03'),(17,'Seaport Interdiction Unit (SIU) Calapan','2023-11-12 08:11:03','2023-11-12 08:11:03'),(18,'Seaport Interdiction Unit (SIU) Palawan','2023-11-12 08:11:03','2023-11-12 08:11:03'),(19,'Airport Interdiction Unit (AIU) Palawan','2023-11-12 08:11:03','2023-11-12 08:11:03');
/*!40000 ALTER TABLE `section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `training`
--

DROP TABLE IF EXISTS `training`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `training` (
  `training_id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `period_from` date NOT NULL,
  `period_to` date NOT NULL,
  `number_of_hours` int NOT NULL,
  `conducted_by` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`training_id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `training`
--

LOCK TABLES `training` WRITE;
/*!40000 ALTER TABLE `training` DISABLE KEYS */;
INSERT INTO `training` VALUES (8,'Cyber Security Training','2023-11-01','2023-11-02',1,'Sir Simplicio','2023-11-23 02:28:30','2023-11-23 02:28:30'),(9,'Rest Day','2023-11-02','2023-11-02',1,'Sir Simplicio','2023-11-23 04:24:03','2023-11-23 04:24:03'),(10,'Matulog','2023-11-04','2023-11-05',1,'JD','2023-11-23 05:02:09','2023-11-23 21:12:40'),(11,'abc','2023-11-05','2023-11-05',1,'Sir Simplicio','2023-11-23 06:44:09','2023-11-26 03:40:54'),(12,'Final Examination','2023-11-21','2023-11-23',1,'JDS','2023-11-23 07:14:55','2023-11-23 07:43:06'),(13,'Sleep','2023-11-07','2023-11-08',1,'Tzuyu','2023-11-23 07:45:18','2023-11-26 03:25:57'),(14,'Wake up','2023-11-09','2023-11-09',1,'Tzuyu','2023-11-23 07:48:37','2023-11-23 21:10:24'),(15,'Final Examination 2','2023-11-03','2023-11-03',1,'JD','2023-11-23 20:01:00','2023-11-23 20:01:00'),(16,'Board Meeting','2023-11-23','2023-11-23',1,'JD','2023-11-23 20:20:54','2023-11-23 20:20:54'),(17,'Board Meeting 2','2023-11-20','2023-11-20',1,'JD','2023-11-23 20:21:32','2023-11-26 02:57:10'),(18,'Rest Day 3','2023-11-19','2023-11-19',1,'JD','2023-11-25 21:33:56','2023-11-26 03:47:07'),(19,'New Training','2023-11-27','2023-11-27',1,'Sir Simplicio','2023-11-27 00:18:20','2023-11-27 00:28:42'),(20,'New Training For Dashboard','2023-11-28','2023-11-28',1,'Sir Simplicio','2023-11-27 19:29:12','2023-11-27 19:29:12'),(21,'Defense','2023-11-30','2023-11-30',1,'JD','2023-11-28 05:34:03','2023-11-28 19:17:47'),(22,'Defense 2','2023-12-01','2023-12-01',1,'JD','2023-11-28 05:35:09','2023-11-28 05:35:09'),(23,'Defense 3','2023-12-02','2023-12-02',1,'JD','2023-11-28 17:51:43','2023-11-28 17:51:43'),(24,'Fen','2023-11-29','2023-12-01',1,'JD','2023-11-28 19:17:19','2023-11-28 19:17:56'),(25,'Birthday ni sir','2023-12-02','2023-12-02',1,'JD','2023-11-28 21:55:05','2023-11-28 21:55:05'),(26,'Checking of Progress','2023-12-06','2023-12-07',1,'Ma\'am Epie','2023-12-04 16:22:19','2023-12-09 18:59:52'),(27,'Sprint','2023-12-13','2023-12-13',1,'JD','2023-12-09 16:08:13','2023-12-09 16:08:13');
/*!40000 ALTER TABLE `training` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `training_programs`
--

DROP TABLE IF EXISTS `training_programs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `training_programs` (
  `training_id` int unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeID` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `period_from` date NOT NULL,
  `period_to` date NOT NULL,
  `number_of_hours` int NOT NULL,
  `conducted_by` varchar(255) NOT NULL,
  `is_company_provided` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`training_id`),
  KEY `training_programs_EmployeeID_foreign` (`EmployeeID`),
  CONSTRAINT `training_programs_EmployeeID_foreign` FOREIGN KEY (`EmployeeID`) REFERENCES `personal_information` (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `training_programs`
--

LOCK TABLES `training_programs` WRITE;
/*!40000 ALTER TABLE `training_programs` DISABLE KEYS */;
INSERT INTO `training_programs` VALUES (1,'EMP098616','ABC','2023-12-09','2023-12-10',5,'Sir',0,'2023-12-08 23:21:07','2023-12-08 23:21:07'),(2,'EMP0986161','ABC','2023-12-09','2023-12-10',5,'Sir',0,'2023-12-08 23:22:53','2023-12-08 23:22:53'),(3,'48795','hello','2019-09-04','2022-12-06',54,'hello',0,'2023-12-09 02:15:44','2023-12-09 02:15:44');
/*!40000 ALTER TABLE `training_programs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `voluntary_work`
--

DROP TABLE IF EXISTS `voluntary_work`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `voluntary_work` (
  `voluntary_work_id` int unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeID` varchar(20) NOT NULL,
  `organization_name` varchar(255) NOT NULL,
  `position` varchar(100) NOT NULL,
  `period_from` date NOT NULL,
  `period_to` date NOT NULL,
  `number_of_hours` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`voluntary_work_id`),
  KEY `voluntary_work_EmployeeID_foreign` (`EmployeeID`),
  CONSTRAINT `voluntary_work_EmployeeID_foreign` FOREIGN KEY (`EmployeeID`) REFERENCES `personal_information` (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voluntary_work`
--

LOCK TABLES `voluntary_work` WRITE;
/*!40000 ALTER TABLE `voluntary_work` DISABLE KEYS */;
INSERT INTO `voluntary_work` VALUES (1,'EMP09861','ABC','123','2023-12-09','2023-12-10',1,'2023-12-08 23:19:32','2023-12-08 23:19:32'),(2,'EMP098616','ABC','123','2023-12-09','2023-12-10',1,'2023-12-08 23:21:07','2023-12-08 23:21:07'),(3,'EMP0986161','ABC','123','2023-12-09','2023-12-10',1,'2023-12-08 23:22:53','2023-12-08 23:22:53'),(4,'48795','hi','hello','2020-08-05','2022-11-03',240,'2023-12-09 02:15:44','2023-12-09 02:15:44');
/*!40000 ALTER TABLE `voluntary_work` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `work_experience`
--

DROP TABLE IF EXISTS `work_experience`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `work_experience` (
  `experience_id` int unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeID` varchar(20) NOT NULL,
  `inclusive_dates_from` date NOT NULL,
  `inclusive_dates_to` date NOT NULL,
  `position_title` varchar(100) NOT NULL,
  `department_agency_office_company` varchar(255) NOT NULL,
  `monthly_salary` decimal(10,2) NOT NULL,
  `salary_grade_step_increment` varchar(20) DEFAULT NULL,
  `status_of_appointment` varchar(50) NOT NULL,
  `govt_service` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`experience_id`),
  KEY `work_experience_EmployeeID_foreign` (`EmployeeID`),
  CONSTRAINT `work_experience_EmployeeID_foreign` FOREIGN KEY (`EmployeeID`) REFERENCES `personal_information` (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `work_experience`
--

LOCK TABLES `work_experience` WRITE;
/*!40000 ALTER TABLE `work_experience` DISABLE KEYS */;
INSERT INTO `work_experience` VALUES (1,'EMPD098691','2023-12-09','2023-12-10','Hello','Hello',100.00,'1','1',0,'2023-12-08 23:09:46','2023-12-08 23:09:46'),(2,'48795','2016-08-07','0000-00-00','hello','hello',48795.00,'47895','hello',0,'2023-12-09 02:15:44','2023-12-09 02:15:44');
/*!40000 ALTER TABLE `work_experience` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-12-10 17:47:34
