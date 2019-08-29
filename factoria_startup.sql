# Host: localhost  (Version 5.5.5-10.1.36-MariaDB)
# Date: 2019-03-22 20:10:44
# Generator: MySQL-Front 6.0  (Build 2.20)

#
# Structure for table "migration_versions"
#How ot update Entity + Database
#php bin/console cache:clear
#php bin/console doctrine:cache:clear-metadata
#php bin/console doctrine:migrations:diff
#php bin/console doctrine:migrations:status --show-versions
#php bin/console doctrine:migrations:migrate xxxxxxxx (version)
#php bin/console doctrine:schema:update --force --dump-sql

#CREATE USER 'liviu'@'localhost' IDENTIFIED BY 'liviu';
#GRANT ALL PRIVILEGES ON *.* TO 'liviu'@'localhost';
#FLUSH PRIVILEGES;
#

#
# Structure for table "fsu_profiles_users"
#
use factoria_startup;
DROP TABLE IF EXISTS `fsu_profiles_users`;
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "fsu_profiles_users"
#

INSERT INTO `fsu_profiles_users` VALUES (7,28,24,15,'jjgvfd','2019-03-22 20:07:42'),(10,29,21,13,'SUPER','2019-03-22 18:27:47');

#
# Structure for table "fsu_sectores"
#

DROP TABLE IF EXISTS `fsu_sectores`;
CREATE TABLE `fsu_sectores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sector_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "fsu_sectores"
#

INSERT INTO `fsu_sectores` VALUES (13,'Financiero'),(14,'Ventas'),(15,'Marketing');

#
# Structure for table "fsu_profiles"
#

DROP TABLE IF EXISTS `fsu_profiles`;
CREATE TABLE `fsu_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sector_id` int(11) DEFAULT NULL,
  `profil_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_88E3A157DE95C867` (`sector_id`),
  CONSTRAINT `FK_88E3A157DE95C867` FOREIGN KEY (`sector_id`) REFERENCES `fsu_sectores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "fsu_profiles"
#

INSERT INTO `fsu_profiles` VALUES (21,13,'Contable'),(22,13,'Administrativo financiero'),(23,14,'Comercial'),(24,15,'Analista Web'),(25,15,'Director marketing');

#
# Structure for table "fsu_users"
#

DROP TABLE IF EXISTS `fsu_users`;
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
  `user_Profile_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_team_search` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_Project_search` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_inscription_date` datetime DEFAULT NULL,
  `user_latitud` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_longitud` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_IP` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_7A866DA918D3E277` (`user_username`),
  UNIQUE KEY `UNIQ_7A866DA9550872C` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "fsu_users"
#

INSERT INTO `fsu_users` VALUES (28,'liviu','$2y$13$luFd.7/xG7VG1wWXpTtYh.ON/BDqj.kHjE508EMPCHHcLyrqyWEUe','liviu@liviu.com','Liviu Vasile','Todoran','Gologan',NULL,'Hombre','Calle','Vilar de Donas','13','13','2D','Madrid','28050','Madrid','España',NULL,'0','1','999 999 999',NULL,NULL,NULL,NULL),(29,'Nicol','$2y$13$bx8zguOrptiNquFIQSyFmuyUK7JUhrkNNlweXqh60Y2jU975hoEjC','nicol@nicol.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

#
# Structure for table "fsu_projects"
#

DROP TABLE IF EXISTS `fsu_projects`;
CREATE TABLE `fsu_projects` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `project_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_short_description` longtext COLLATE utf8mb4_unicode_ci,
  `project_description` longtext COLLATE utf8mb4_unicode_ci,
  `project_potentialy_users` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_potentialy_companies` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_aprox_facturation1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_aprox_facturation2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_aprox_facturation3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_competitors` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_team_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_team` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_date` datetime DEFAULT NULL,
  `project_sector_id` int(11) DEFAULT NULL,
  `project_phase_idea` tinyint(1) DEFAULT NULL,
  `project_phase_ideaMV` tinyint(1) DEFAULT NULL,
  `project_phase_productoMV` tinyint(1) DEFAULT NULL,
  `project_phase_productoFinal` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`project_id`),
  KEY `IDX_5F4097C3A76ED395` (`user_id`),
  KEY `IDX_5F4097C3CFA98DB0` (`project_sector_id`),
  CONSTRAINT `FK_5F4097C3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `fsu_users` (`id`),
  CONSTRAINT `FK_5F4097C3CFA98DB0` FOREIGN KEY (`project_sector_id`) REFERENCES `fsu_sectores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "fsu_projects"
#

INSERT INTO `fsu_projects` VALUES (56,28,'Project de Prueba',NULL,'Some text 58',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-21 20:04:00',NULL,0,0,0,0),(57,28,'Project de Prueba',NULL,'Some text 41',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-21 20:04:00',NULL,0,0,0,0),(58,28,'Project de Prueba',NULL,'Some text 3',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-21 20:04:00',NULL,0,0,0,0),(59,28,'Project de Prueba',NULL,'Some text 78',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-21 20:04:00',NULL,0,0,0,0),(60,28,'Project de Prueba',NULL,'Some text 45',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-21 20:04:00',NULL,0,0,0,0),(61,28,'Marketing Web','fshbsr','gdrdg','Adultos','Web Marketing','22222','5000','1000','rgs',NULL,NULL,'2019-03-21 15:22:59',NULL,1,0,0,0),(62,29,'project Minimo Viable','project Finalproject Finalproject Final','project Finalproject Finalproject Finalproject Finalproject Finalproject','Adultos','Web Marketing','22222','5555','200000','Marketing',NULL,NULL,'2019-03-21 15:58:49',NULL,0,0,1,0);

#
# Structure for table "migration_versions"
#

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Data for table "migration_versions"
#

