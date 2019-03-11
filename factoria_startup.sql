# Host: localhost  (Version 5.5.5-10.1.36-MariaDB)
# Date: 2019-03-11 20:10:59
# Generator: MySQL-Front 6.0  (Build 2.20)


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

INSERT INTO `migration_versions` VALUES ('20190311124250');

#
# Structure for table "user"
#

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "user"
#

INSERT INTO `user` VALUES (1,'nicol','$2y$13$RJx.pej8eeFwvnVCJgy0ZuC0VZlpW3INSc9Upqrleb5LDv8l1kGWW','nicol@nicol.com','Nicoleta Laura'),(2,'Laura','$2y$13$cmYqO9mTJbfhVQqxFeGdoOc1KDOGRdGbF3tTjljqjpd/4FgdnHljm','laura@laura.com','Laura'),(3,'Liviu','$2y$13$eZZw8RBHa1C6eF4ybebaOuSwxLpXI9P5C3A1DpMKuOLaTeZ6BnI8W','liviu@liviu.com','Liviu Vasile');
