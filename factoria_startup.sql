# Host: localhost  (Version 5.5.5-10.1.36-MariaDB)
# Date: 2019-01-17 19:47:10
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "users"
#

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `isActive` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

#
# Data for table "users"
#

INSERT INTO `users` VALUES (1,'Liviu','$2a$04$HEsEAORHyDBE1fHUjAQP0ur9kLBz.gQgp3PYTELp230fulJR5zFua','liviu@yahoo.com',1);
