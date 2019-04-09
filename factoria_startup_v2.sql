-- MySQL dump 10.13  Distrib 5.7.25, for osx10.13 (x86_64)
--
-- Host: localhost    Database: factoria_startup
-- ------------------------------------------------------
-- Server version	5.7.25

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `fsu_profesional_profile`
--

DROP TABLE IF EXISTS `fsu_profesional_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fsu_profesional_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profesional_description` varchar(5500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profesional_search_project` tinyint(1) DEFAULT NULL,
  `profesional_id_user` int(11) NOT NULL,
  `profesional_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fsu_profesional_profile`
--

LOCK TABLES `fsu_profesional_profile` WRITE;
/*!40000 ALTER TABLE `fsu_profesional_profile` DISABLE KEYS */;
/*!40000 ALTER TABLE `fsu_profesional_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fsu_profiles`
--

DROP TABLE IF EXISTS `fsu_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fsu_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profil_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fsu_profiles`
--

LOCK TABLES `fsu_profiles` WRITE;
/*!40000 ALTER TABLE `fsu_profiles` DISABLE KEYS */;
INSERT INTO `fsu_profiles` VALUES (41,'Educación'),(42,'Investigación y ciencia'),(43,'Gestión y administración'),(44,'Sanidad'),(45,'Servicios'),(46,'Ocio y entretenimiento'),(47,'Distribución y venta'),(48,'Sector inmobiliario'),(49,'Finanzas'),(50,'Turismo'),(51,'Otras Aportaciones');
/*!40000 ALTER TABLE `fsu_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fsu_profiles_users`
--

DROP TABLE IF EXISTS `fsu_profiles_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fsu_profiles_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `profil_id` int(11) DEFAULT NULL,
  `sector_id` int(11) DEFAULT NULL,
  `profil_profesional_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E99B63F2A76ED395` (`user_id`),
  KEY `IDX_E99B63F2275ED078` (`profil_id`),
  KEY `IDX_E99B63F2DE95C867` (`sector_id`),
  CONSTRAINT `FK_E99B63F2275ED078` FOREIGN KEY (`profil_id`) REFERENCES `fsu_profiles` (`id`),
  CONSTRAINT `FK_E99B63F2A76ED395` FOREIGN KEY (`user_id`) REFERENCES `fsu_users` (`id`),
  CONSTRAINT `FK_E99B63F2DE95C867` FOREIGN KEY (`sector_id`) REFERENCES `fsu_sectores` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fsu_profiles_users`
--

LOCK TABLES `fsu_profiles_users` WRITE;
/*!40000 ALTER TABLE `fsu_profiles_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `fsu_profiles_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fsu_projects`
--

DROP TABLE IF EXISTS `fsu_projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fsu_projects` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `project_sector_id` int(11) DEFAULT NULL,
  `project_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_short_description` longtext COLLATE utf8mb4_unicode_ci,
  `project_description` longtext COLLATE utf8mb4_unicode_ci,
  `project_phase_idea` tinyint(1) DEFAULT NULL,
  `project_phase_ideaMV` tinyint(1) DEFAULT NULL,
  `project_phase_productoMV` tinyint(1) DEFAULT NULL,
  `project_phase_productoFinal` tinyint(1) DEFAULT NULL,
  `project_potentialy_users` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_potentialy_companies` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_aprox_facturation1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_aprox_facturation2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_aprox_facturation3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_competitors` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_team_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_team` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_date` datetime DEFAULT NULL,
  PRIMARY KEY (`project_id`),
  KEY `IDX_5F4097C3A76ED395` (`user_id`),
  KEY `IDX_5F4097C3CFA98DB0` (`project_sector_id`),
  CONSTRAINT `FK_5F4097C3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `fsu_users` (`id`),
  CONSTRAINT `FK_5F4097C3CFA98DB0` FOREIGN KEY (`project_sector_id`) REFERENCES `fsu_sectores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fsu_projects`
--

LOCK TABLES `fsu_projects` WRITE;
/*!40000 ALTER TABLE `fsu_projects` DISABLE KEYS */;
INSERT INTO `fsu_projects` VALUES (21,6,NULL,'Project de Prueba',NULL,'Some text 55',0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-04-09 20:04:00'),(22,6,NULL,'Project de Prueba',NULL,'Some text 88',0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-04-09 20:04:00'),(23,6,NULL,'Project de Prueba',NULL,'Some text 59',0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-04-09 20:04:00'),(24,6,NULL,'Project de Prueba',NULL,'Some text 26',0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-04-09 20:04:00'),(25,6,NULL,'Project de Prueba',NULL,'Some text 41',0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-04-09 20:04:00');
/*!40000 ALTER TABLE `fsu_projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fsu_sectores`
--

DROP TABLE IF EXISTS `fsu_sectores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fsu_sectores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sector_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fsu_sectores`
--

LOCK TABLES `fsu_sectores` WRITE;
/*!40000 ALTER TABLE `fsu_sectores` DISABLE KEYS */;
INSERT INTO `fsu_sectores` VALUES (37,'Educación'),(38,'Investigación y ciencia'),(39,'Gestión y administración'),(40,'Sanidad'),(41,'Servicios'),(42,'Ocio y entretenimiento'),(43,'Distribución y vent'),(44,'Sector inmobiliario'),(45,'Finanzas'),(46,'Turismo'),(47,'Otras Aportaciones');
/*!40000 ALTER TABLE `fsu_sectores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fsu_users`
--

DROP TABLE IF EXISTS `fsu_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fsu_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_surname_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_surname_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_birth_date` datetime DEFAULT NULL,
  `user_sex` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_street_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_street_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_street_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_block` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_apartment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_provincie` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_perfil_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_team_search` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_proyect_search` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_inscription_date` datetime DEFAULT NULL,
  `user_latitud` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_longitud` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_IP` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_7A866DA918D3E277` (`user_username`),
  UNIQUE KEY `UNIQ_7A866DA9550872C` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fsu_users`
--

LOCK TABLES `fsu_users` WRITE;
/*!40000 ALTER TABLE `fsu_users` DISABLE KEYS */;
INSERT INTO `fsu_users` VALUES (6,'liviu','$2y$13$MtLoenrI80I2IrsTEdodAu/17ecdL7ip9gZWEQPCKjB8LtTIHx7p2','liviu@liviu.com','Liviu Vasile','Todoran','Gologan',NULL,'Hombre','Calle','Vilar de Donas','13','13','2D','Madrid','28050','Madrid','España',NULL,'0','1','999 999 999',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `fsu_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration_versions`
--

LOCK TABLES `migration_versions` WRITE;
/*!40000 ALTER TABLE `migration_versions` DISABLE KEYS */;
INSERT INTO `migration_versions` VALUES ('20190325204324',NULL),('20190408215455','2019-04-08 21:55:44'),('20190408220313','2019-04-08 22:05:52'),('20190409184956','2019-04-09 18:56:09');
/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-04-09 21:09:21
