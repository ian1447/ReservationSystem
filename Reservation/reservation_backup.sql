/*
SQLyog Ultimate v9.62 
MySQL - 5.5.5-10.4.25-MariaDB : Database - reservation_system
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`reservation_system` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `reservation_system`;

/*Table structure for table `facilities` */

DROP TABLE IF EXISTS `facilities`;

CREATE TABLE `facilities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `facilities` */

insert  into `facilities`(`id`,`location`) values (1,'Activity Center'),(2,'Multimedia Room'),(3,'Conference Room'),(4,'School Bus'),(5,'Chairs and Tables'),(6,'Sound System');

/*Table structure for table `transactions` */

DROP TABLE IF EXISTS `transactions`;

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reservation_status` int(1) NOT NULL DEFAULT 0 COMMENT 'Applied or declined 0 for applied 1 for approved',
  `transdate` datetime NOT NULL,
  `reserver_username` varchar(255) NOT NULL,
  `reserved_facility` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0 COMMENT 'if reservation has been used 0 for not yet used 1 for used',
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `transactions` */

insert  into `transactions`(`id`,`reservation_status`,`transdate`,`reserver_username`,`reserved_facility`,`status`,`date_from`,`date_to`) values (1,1,'2023-01-11 14:03:43','user','School Bus',0,'2023-01-10','2023-01-10'),(3,2,'2023-01-12 12:14:15','user','Conference Room',0,'2023-01-20','2023-01-20'),(5,0,'2023-01-12 15:03:05','user','Chairs and Tables',0,'2023-01-06','2023-01-07');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `privilege` enum('user','admin') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`,`privilege`) values (1,'admin','admin','admin'),(2,'user','user','user'),(3,'mor','pass','user');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
