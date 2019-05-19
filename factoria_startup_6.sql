-- MySQL dump 10.13  Distrib 5.7.26, for Linux (x86_64)
--
-- Host: localhost    Database: factoria_startup
-- ------------------------------------------------------
-- Server version	5.7.26-0ubuntu0.16.04.1

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
-- Table structure for table `fsu_contribute`
--
use factoria_startup;
DROP TABLE IF EXISTS `fsu_contribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fsu_contribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contribute_project_id` int(11) DEFAULT NULL,
  `contribute_profile` varchar(3000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contribute_description` varchar(3000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contribute_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F62FC0433342C72C` (`contribute_project_id`),
  CONSTRAINT `FK_F62FC0433342C72C` FOREIGN KEY (`contribute_project_id`) REFERENCES `fsu_projects` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fsu_contribute`
--

LOCK TABLES `fsu_contribute` WRITE;
/*!40000 ALTER TABLE `fsu_contribute` DISABLE KEYS */;
INSERT INTO `fsu_contribute` VALUES (1,6,'Programación','Necesito a alguien que programe','2019-05-17 09:12:04'),(2,7,'Programación','dfgfdsg','2019-05-17 12:38:31');
/*!40000 ALTER TABLE `fsu_contribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fsu_needs_project`
--

DROP TABLE IF EXISTS `fsu_needs_project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fsu_needs_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `needs_project_id` int(11) DEFAULT NULL,
  `needs_perfil` varchar(3000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `needs_deal` varchar(3000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `needs_percent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `needs_description` varchar(3000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `needs_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `needs_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E5484F70F809791` (`needs_project_id`),
  CONSTRAINT `FK_E5484F70F809791` FOREIGN KEY (`needs_project_id`) REFERENCES `fsu_projects` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fsu_needs_project`
--

LOCK TABLES `fsu_needs_project` WRITE;
/*!40000 ALTER TABLE `fsu_needs_project` DISABLE KEYS */;
INSERT INTO `fsu_needs_project` VALUES (1,6,'Diseño',NULL,'% Ventas','Some Text',NULL,'2019-05-17 12:34:34'),(2,7,'Diseño',NULL,'% Ventas','dfgfdg',NULL,'2019-05-17 12:38:40');
/*!40000 ALTER TABLE `fsu_needs_project` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fsu_profiles`
--

LOCK TABLES `fsu_profiles` WRITE;
/*!40000 ALTER TABLE `fsu_profiles` DISABLE KEYS */;
INSERT INTO `fsu_profiles` VALUES (1,'Marketing'),(2,'Diseño'),(3,'Programación'),(4,'Legal'),(5,'Comercial'),(6,'Financiero'),(7,'Espacio Físico'),(8,'Financiación');
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
  `profiles_profesional_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profiles_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E99B63F2A76ED395` (`user_id`),
  KEY `IDX_E99B63F2275ED078` (`profil_id`),
  KEY `IDX_E99B63F2DE95C867` (`sector_id`),
  CONSTRAINT `FK_E99B63F2275ED078` FOREIGN KEY (`profil_id`) REFERENCES `fsu_profiles` (`id`),
  CONSTRAINT `FK_E99B63F2A76ED395` FOREIGN KEY (`user_id`) REFERENCES `fsu_users` (`id`),
  CONSTRAINT `FK_E99B63F2DE95C867` FOREIGN KEY (`sector_id`) REFERENCES `fsu_sectores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fsu_profiles_users`
--

LOCK TABLES `fsu_profiles_users` WRITE;
/*!40000 ALTER TABLE `fsu_profiles_users` DISABLE KEYS */;
INSERT INTO `fsu_profiles_users` VALUES (1,1,1,1,'Primer Proyecto','2019-05-17 20:01:00'),(2,1,2,2,'Segundo Proyecto','2019-05-17 20:01:00');
/*!40000 ALTER TABLE `fsu_profiles_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fsu_projects`
--

DROP TABLE IF EXISTS `fsu_projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fsu_projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `project_sector_id` int(11) DEFAULT NULL,
  `project_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_short_description` longtext COLLATE utf8mb4_unicode_ci,
  `project_description` longtext COLLATE utf8mb4_unicode_ci,
  `project_phase_idea` tinyint(1) DEFAULT NULL,
  `project_phase_ideaMV` tinyint(1) DEFAULT NULL,
  `project_phase_productoMV` tinyint(1) DEFAULT NULL,
  `project_phase_productoFinal` tinyint(1) DEFAULT NULL,
  `project_clientes_users` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_potentialy_users` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_potentialy_companies` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_aprox_facturation1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_aprox_facturation2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_aprox_facturation3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_competitors` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_team_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_team` tinyint(1) DEFAULT NULL,
  `project_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5F4097C3A76ED395` (`user_id`),
  KEY `IDX_5F4097C3CFA98DB0` (`project_sector_id`),
  CONSTRAINT `FK_5F4097C3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `fsu_users` (`id`),
  CONSTRAINT `FK_5F4097C3CFA98DB0` FOREIGN KEY (`project_sector_id`) REFERENCES `fsu_sectores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fsu_projects`
--

LOCK TABLES `fsu_projects` WRITE;
/*!40000 ALTER TABLE `fsu_projects` DISABLE KEYS */;
INSERT INTO `fsu_projects` VALUES (1,1,NULL,'Project de Prueba',NULL,'Some text 95',0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'2019-05-17 20:04:00'),(2,1,NULL,'Project de Prueba',NULL,'Some text 70',0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'2019-05-17 20:04:00'),(3,1,NULL,'Project de Prueba',NULL,'Some text 96',0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'2019-05-17 20:04:00'),(4,1,NULL,'Project de Prueba',NULL,'Some text 1',0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'2019-05-17 20:04:00'),(5,1,NULL,'Project de Prueba',NULL,'Some text 71',0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'2019-05-17 20:04:00'),(6,1,NULL,'PROYECTO CAFE','Lo definimos en una linea','Rezmen ejecutivo',0,0,0,1,NULL,'1000','5','10','15','20','3',NULL,1,NULL),(7,1,NULL,'Another one','Texto','fdsag',0,0,0,1,NULL,'123','2','10','18','25','3',NULL,1,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fsu_sectores`
--

LOCK TABLES `fsu_sectores` WRITE;
/*!40000 ALTER TABLE `fsu_sectores` DISABLE KEYS */;
INSERT INTO `fsu_sectores` VALUES (1,'Educación'),(2,'Investigación y ciencia'),(3,'Gestión y administración'),(4,'Sanidad'),(5,'Servicios'),(6,'Ocio y entretenimiento'),(7,'Distribución y vent'),(8,'Sector inmobiliario'),(9,'Finanzas'),(10,'Turismo'),(11,'Otras Aportaciones');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fsu_users`
--

LOCK TABLES `fsu_users` WRITE;
/*!40000 ALTER TABLE `fsu_users` DISABLE KEYS */;
INSERT INTO `fsu_users` VALUES (1,'liviu','$2y$13$nfN7qd7ESVrBqrtB3yUssOULEhAtI3SsElHfI52OK89g7Nr.HuZ9K','liviu@liviu.com','Liviu Vasile','Todoran','Gologan','1982-02-02 00:00:00','h','Calle','Vilar de Donas','13','13','2D','Madrid','28050','Madrid','España','liviu-b7c8a42c83e1d232e2599407e6d0f6f7.png','0','1','999 999 999','2019-05-17 20:04:00','40.5089','-3.66544',NULL),(2,'Nicole','$2y$13$/pf/8X.3ae3aXZQZTj9nmenluphEUHn8igoWgERBDsZBXCBpNq/5a','nicole@nicole.com','Nicole','Todoran','Gologan','1995-05-07 00:00:00','m',NULL,'Calle Viloria de la Rioja','19',NULL,'59','Madrid','28050','Madrid','España','Nicole-3e42c61cd3bd2c73ab97f0ab556289fd.jpeg',NULL,NULL,'999 999 777',NULL,'40.5049725','-3.6676389',NULL),(3,'trabajo','$2y$13$QIApAXRjskLCQyy9AzORruzxufuzWpLP./xNoVJyptAi.fRe1n9vu','trabajo@trabajo.com','Trabajo','Munca','work','1983-03-06 00:00:00','h',NULL,'Pedro Teixeira','8',NULL,'8','Madrid','28020','Madrid','España','trabajo-2df765a027db8463758c4fa32e7ad4ba.jpeg',NULL,NULL,'999 999 823',NULL,'40.4548351','-3.6941898',NULL);
/*!40000 ALTER TABLE `fsu_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-05-17 13:28:48
