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
-- Table structure for table `fsu_contribute`
--

DROP TABLE IF EXISTS `fsu_contribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fsu_contribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contribute_description` varchar(3000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contribute_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fsu_contribute`
--

LOCK TABLES `fsu_contribute` WRITE;
/*!40000 ALTER TABLE `fsu_contribute` DISABLE KEYS */;
/*!40000 ALTER TABLE `fsu_contribute` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fsu_profesional_profile`
--

LOCK TABLES `fsu_profesional_profile` WRITE;
/*!40000 ALTER TABLE `fsu_profesional_profile` DISABLE KEYS */;
INSERT INTO `fsu_profesional_profile` VALUES (1,'Description de perfi, textonuevo',1,1,'2019-04-18 19:18:18');
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
  `contribute_profile_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_88E3A157E9D5CA08` (`contribute_profile_id`),
  CONSTRAINT `FK_88E3A157E9D5CA08` FOREIGN KEY (`contribute_profile_id`) REFERENCES `fsu_contribute` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fsu_profiles`
--

LOCK TABLES `fsu_profiles` WRITE;
/*!40000 ALTER TABLE `fsu_profiles` DISABLE KEYS */;
INSERT INTO `fsu_profiles` VALUES (1,'Marketing',NULL),(2,'Diseño',NULL),(3,'Programación',NULL),(4,'Legal',NULL),(5,'Comercial',NULL),(6,'Financiero',NULL),(7,'Espacio Físico',NULL),(8,'Financiación',NULL);
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
  `profiles_profil_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profiles_sector_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profiles_profesional_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profiles_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E99B63F2A76ED395` (`user_id`),
  CONSTRAINT `FK_E99B63F2A76ED395` FOREIGN KEY (`user_id`) REFERENCES `fsu_users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fsu_profiles_users`
--

LOCK TABLES `fsu_profiles_users` WRITE;
/*!40000 ALTER TABLE `fsu_profiles_users` DISABLE KEYS */;
INSERT INTO `fsu_profiles_users` VALUES (28,1,'Marketing','Educación','Baaa','2019-04-18 18:31:52'),(33,1,'Programación','Investigación y ciencia','gadfgh','2019-04-18 20:00:06'),(35,1,'Diseño','Gestión y administración','HFGJ','2019-04-21 12:16:41'),(36,1,'Programación','Gestión y administración','HJGH','2019-04-21 12:28:25');
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
  `project_team` tinyint(1) DEFAULT NULL,
  `project_date` datetime DEFAULT NULL,
  `project_clientes_users` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contribute_id_id` int(11) DEFAULT NULL,
  `needs_project_id_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`project_id`),
  KEY `IDX_5F4097C3A76ED395` (`user_id`),
  KEY `IDX_5F4097C3CFA98DB0` (`project_sector_id`),
  KEY `IDX_5F4097C3EE6BF2A4` (`contribute_id_id`),
  KEY `IDX_5F4097C349288805` (`needs_project_id_id`),
  CONSTRAINT `FK_5F4097C349288805` FOREIGN KEY (`needs_project_id_id`) REFERENCES `needs_project` (`id`),
  CONSTRAINT `FK_5F4097C3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `fsu_users` (`id`),
  CONSTRAINT `FK_5F4097C3CFA98DB0` FOREIGN KEY (`project_sector_id`) REFERENCES `fsu_sectores` (`id`),
  CONSTRAINT `FK_5F4097C3EE6BF2A4` FOREIGN KEY (`contribute_id_id`) REFERENCES `fsu_contribute` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fsu_projects`
--

LOCK TABLES `fsu_projects` WRITE;
/*!40000 ALTER TABLE `fsu_projects` DISABLE KEYS */;
INSERT INTO `fsu_projects` VALUES (1,1,NULL,'Project de Prueba',NULL,'Some text 66',0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-04-13 20:04:00',NULL,NULL,NULL),(2,1,NULL,'Project de Prueba',NULL,'Some text 83',0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-04-13 20:04:00',NULL,NULL,NULL),(3,1,NULL,'Project de Prueba',NULL,'Some text 63',0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-04-13 20:04:00',NULL,NULL,NULL),(4,1,NULL,'Project de Prueba',NULL,'Some text 50',0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-04-13 20:04:00',NULL,NULL,NULL),(5,1,NULL,'Project Cinco','la descripcion corta','New text, New text, New text',0,0,0,0,'25','20','2500','2500','2500','10',NULL,NULL,'2019-04-13 20:04:00',NULL,NULL,NULL),(6,1,NULL,'Siuuu',NULL,NULL,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(7,1,NULL,'Proyecto nuevo',NULL,NULL,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(8,1,NULL,'GetId',NULL,NULL,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(9,1,NULL,'GetId',NULL,NULL,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fsu_users`
--

LOCK TABLES `fsu_users` WRITE;
/*!40000 ALTER TABLE `fsu_users` DISABLE KEYS */;
INSERT INTO `fsu_users` VALUES (1,'liviu','$2y$13$Do9P2qyW4LvgXu1ilWvxvOqoVjE0Dah8/GZgmB1lMoP9TAWIyX/Di','liviu@liviu.com','Liviu Vasile','Todoran','Gologan','1983-12-11 00:00:00','h','Calle','Vilar de Donas','13','13','2D','Madrid','28050','Madrid','España','liviu-bf8ccd980f8aa25a5bb795c669c9472e.jpeg','0','1','999 999 999',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `fsu_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration_versions`
--

LOCK TABLES `migration_versions` WRITE;
/*!40000 ALTER TABLE `migration_versions` DISABLE KEYS */;
INSERT INTO `migration_versions` VALUES ('20190421182359','2019-04-21 18:24:48');
/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `needs_project`
--

DROP TABLE IF EXISTS `needs_project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `needs_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `needs_perfil_id` int(11) DEFAULT NULL,
  `needs_id` int(11) NOT NULL,
  `needs_deal` varchar(3000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `needs_percent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `needs_description` varchar(3000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `needs_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `needs_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_45E804EED69769D2` (`needs_perfil_id`),
  CONSTRAINT `FK_45E804EED69769D2` FOREIGN KEY (`needs_perfil_id`) REFERENCES `fsu_profiles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `needs_project`
--

LOCK TABLES `needs_project` WRITE;
/*!40000 ALTER TABLE `needs_project` DISABLE KEYS */;
/*!40000 ALTER TABLE `needs_project` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-04-21 20:27:16
