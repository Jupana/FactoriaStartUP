# Host: localhost  (Version 5.5.5-10.1.36-MariaDB)
# Date: 2019-03-15 15:59:50
# Generator: MySQL-Front 6.0  (Build 2.20)

#
# Structure for table "migration_versions"
#How ot update Entity + Database
#php bin/console cache:clear
#php bin/console doctrine:cache:clear-metadata
#php bin/console doctrine:migrations:diff
#php bin/console doctrine:migrations:migrate xxxxxxxx (version)
#php bin/console doctrine:schema:update --force --dump-sql
#

# Structure for table "fsu_profiles_users"
#

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "fsu_profiles_users"
#

INSERT INTO `fsu_profiles_users` VALUES (1,4,9,6,'Aqui esta la descripcion profesional sobre el perfil grabado de prueba','2019-03-15 20:01:00'),(2,4,8,5,'Aqui esta la descripcion profesional sobre el perfil grabado de prueba','2019-03-15 20:01:00');

#
# Structure for table "fsu_sectores"
#

DROP TABLE IF EXISTS `fsu_sectores`;
CREATE TABLE `fsu_sectores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sector_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "fsu_sectores"
#

INSERT INTO `fsu_sectores` VALUES (4,'Financiero'),(5,'Ventas'),(6,'Marketing');

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "fsu_profiles"
#

INSERT INTO `fsu_profiles` VALUES (6,4,'Contable'),(7,4,'Administrativo financiero'),(8,5,'Comercial'),(9,6,'Analista Web'),(10,6,'Director marketing');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "fsu_users"
#

INSERT INTO `fsu_users` VALUES (4,'liviu','$2y$13$88Ank08ABKmU8FjjVVx/ouDnZxfME0aw0DYwAmAgxFR2IF6TV585y','liviu@liviu.com','Liviu Vasile','Todoran','Gologan',NULL,'Hombre','Calle','Vilar de Donas','13','13','2D','Madrid','28050','Madrid','España',NULL,'0','1','999 999 999',NULL,NULL,NULL,NULL);

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
  `project_sector` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_clientes_users` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
  CONSTRAINT `FK_5F4097C3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `fsu_users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "fsu_projects"
#

INSERT INTO `fsu_projects` VALUES (21,4,'Project de Prueba',NULL,'Some text 7',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-15 20:04:00'),(22,4,'Project de Prueba',NULL,'Some text 30',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-15 20:04:00'),(23,4,'Project de Prueba',NULL,'Some text 52',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-15 20:04:00'),(24,4,'Project de Prueba',NULL,'Some text 71',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-15 20:04:00'),(25,4,'Project de Prueba',NULL,'Some text 29',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-15 20:04:00'),(26,4,'Project de Prueba',NULL,'Some text 63',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-15 20:04:00'),(27,4,'Project de Prueba',NULL,'Some text 29',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-15 20:04:00'),(28,4,'Project de Prueba',NULL,'Some text 73',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-15 20:04:00'),(29,4,'Project de Prueba',NULL,'Some text 79',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-15 20:04:00'),(30,4,'Project de Prueba',NULL,'Some text 2',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-15 20:04:00');

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

INSERT INTO `migration_versions` VALUES ('20190315130822');
