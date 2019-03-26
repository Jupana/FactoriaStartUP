# Host: localhost  (Version 5.5.5-10.1.36-MariaDB)
# Date: 2019-03-26 19:31:52
# Generator: MySQL-Front 6.0  (Build 2.20)


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
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "fsu_projects"
#

INSERT INTO `fsu_projects` VALUES (56,28,'Project de Prueba',NULL,'Some text 58',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-21 20:04:00',NULL,0,0,0,0),(64,29,'Marketing Web','nicol','Ipsum Ipsum Ipsum Ipsum Ipsum Ipsum Ipsum Ipsum Ipsum Ipsum Ipsum Ipsum Ipsum Ipsum Ipsum Ipsum Ipsum Ipsum Ipsum Ipsum Ipsum Ipsum Ipsum Ipsum Ipsum Ipsum Ipsum Ipsum','Adultos','Web Marketing','15000','20000','55000','El Lorem Ipsum fue concebido como un texto de relleno,',NULL,NULL,'2019-03-26 17:41:19',NULL,0,1,0,0);

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
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "fsu_profiles_users"
#

INSERT INTO `fsu_profiles_users` VALUES (7,28,24,15,'otro cambio','2019-03-25 14:19:59'),(124,29,22,13,'jj','2019-03-26 15:15:46'),(125,29,22,13,'canbio','2019-03-26 15:21:10');

#
# Structure for table "fsu_news"
#

DROP TABLE IF EXISTS `fsu_news`;
CREATE TABLE `fsu_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `news_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `news_content` longtext COLLATE utf8mb4_unicode_ci,
  `news_summary` longtext COLLATE utf8mb4_unicode_ci,
  `news_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `news_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_731D3EC7A76ED395` (`user_id`),
  CONSTRAINT `FK_731D3EC7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `fsu_users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "fsu_news"
#

INSERT INTO `fsu_news` VALUES (1,29,'Vivendi','Vivendi culmina la compra a Planeta de la editorial francesa Editis.Vivendi culmina la compra a Planeta de la editorial francesa EditisVivendi culmina la compra a Planeta de la editorial francesa Editis.Vivendi culmina la compra a Planeta de la editorial francesa EditisVivendi culmina la compra a Planeta de la editorial francesa Editis.Vivendi culmina la compra a Planeta de la editorial francesa EditisVivendi culmina la compra a Planeta de la editorial francesa Editis.Vivendi culmina la compra a Planeta de la editorial francesa Editis','Vivendi culmina la compra a Planeta de la editorial francesa Editis.Vivendi culmina la compra a Planeta de la editorial francesa Editis','1553621510.jpeg',NULL),(2,29,'Nueva Nooticia','<a href=\"{{path(\"posts_details\",{\"id\":post.id})}}\">Read More</a> <a href=\"{{path(\"posts_details\",{\"id\":post.id})}}\">Read More</a> <a href=\"{{path(\"posts_details\",{\"id\":post.id})}}\">Read More</a>','<a href=\"{{path(\"posts_details\",{\"id\":post.id})}}\">Read More</a> <a href=\"{{path(\"posts_details\",{\"id\":post.id})}}\">Read More</a> <a href=\"{{path(\"posts_details\",{\"id\":post.id})}}\">Read More</a>','1553623111.jpeg','2019-03-26 18:58:31'),(3,28,'Nocitia otro Usuario','licpun licpun licpun licpun licpun licpun licpun licpun licpun licpun licpun licpun licpun licpun licpun licpun licpun licpun licpun licpun licpun licpun licpun licpun licpun licpun licpun licpun licpun licpun licpun licpun','licpun licpun licpun licpun licpun licpun licpun licpun','1553623627.jpeg','2019-03-26 19:08:32');

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

INSERT INTO `migration_versions` VALUES ('20190326170215'),('20190326175158');
