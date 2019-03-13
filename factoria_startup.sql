# Host: localhost  (Version 5.5.5-10.1.36-MariaDB)
# Date: 2019-03-12 19:38:15
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "migration_versions"
#How ot update Entity + Database
#php bin/console cache:clear
#php bin/console doctrine:cache:clear-metadata
#php bin/console doctrine:migrations:diff
#php bin/console doctrine:migrations:migrate xxxxxxxx (version)
#php bin/console doctrine:schema:update --force --dump-sql


CREATE database factoria_startup;
use factoria_startup;

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Data for table "migration_versions"
#

INSERT INTO `migration_versions` VALUES ('20190312133026');

#
# Structure for table "user"
#

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surname_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surname_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` datetime DEFAULT NULL,
  `sex` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `block` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apartment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `perfil_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `team_search` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proyect_search` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instription_date` datetime DEFAULT NULL,
  `latitud` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitud` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "user"
#

INSERT INTO `user` VALUES (11,'liviu','$2y$13$uAfYUwkN.ikxXApFq9pdz.Hk2DDH80RwLoG0032DK8b21n15OQMuO','liviu@liviu.com','Liviu Vasile','Todoran','Gologan',NULL,'Hombre','Calle','Vilar de Donas','13','13','2D','Madrid','28050','Madrid','España',NULL,'0','1','999 999 999','2019-03-12 20:04:00',NULL,NULL,NULL);

#
# Structure for table "project"
#

DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`),
  KEY `IDX_2FB3D0EEA76ED395` (`user_id`),
  CONSTRAINT `FK_2FB3D0EEA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "project"
#

INSERT INTO `project` VALUES (1,11,'Project de Prueba',NULL,'Some text 51',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-12 20:04:00'),(2,11,'Project de Prueba',NULL,'Some text 100',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-12 20:04:00'),(3,11,'Project de Prueba',NULL,'Some text 40',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-12 20:04:00'),(4,11,'Project de Prueba',NULL,'Some text 100',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-12 20:04:00'),(5,11,'Project de Prueba',NULL,'Some text 96',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-12 20:04:00'),(6,11,'Project de Prueba',NULL,'Some text 69',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-12 20:04:00'),(7,11,'Project de Prueba',NULL,'Some text 19',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-12 20:04:00'),(8,11,'Project de Prueba',NULL,'Some text 65',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-12 20:04:00'),(9,11,'Project de Prueba',NULL,'Some text 15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-12 20:04:00'),(10,11,'Project de Prueba',NULL,'Some text 61',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-12 20:04:00');
