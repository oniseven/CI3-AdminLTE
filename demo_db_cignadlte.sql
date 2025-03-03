/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.5.4-MariaDB : Database - db_cignadlte
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_cignadlte` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_cignadlte`;

/*Table structure for table `menu_privileges` */

DROP TABLE IF EXISTS `menu_privileges`;

CREATE TABLE `menu_privileges` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `privilege_id` int(10) unsigned NOT NULL,
  `menu_id` int(10) unsigned NOT NULL,
  `is_selected` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_menu_privilege` (`privilege_id`,`menu_id`),
  KEY `fk_menu_privileges_menu` (`menu_id`),
  CONSTRAINT `fk_menu_privileges_menu` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_menu_privileges_privilege` FOREIGN KEY (`privilege_id`) REFERENCES `privileges` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `menu_privileges` */

/*Table structure for table `menus` */

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `position` enum('left','top') NOT NULL DEFAULT 'left',
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `icon` varchar(30) NOT NULL,
  `is_last` tinyint(1) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `menus` */

insert  into `menus`(`id`,`parent_id`,`position`,`name`,`slug`,`link`,`icon`,`is_last`,`is_active`) values 
(1,NULL,'left','Starter Page','/','/','fas fa-tachometer-alt',1,1),
(2,NULL,'left','Tables','table','#','fas fa-table',0,1),
(3,2,'left','Simple Table','simple_table','tables/simple','far fa-circle',1,1),
(4,2,'left','Datatables','dtables','tables/dtables','far fa-circle',1,1),
(5,2,'left','JqGrid','jqgrid','tables/jqgrid','far fa-circle',1,1),
(6,NULL,'left','Level 1','level_1','#','fas fa-circle',0,1),
(7,6,'left','Level 2','level_2','#','far fa-circle',1,1),
(8,6,'left','Level 2','level_2_2','#','far fa-circle',0,1),
(9,8,'left','Level 3','level_3','#','fas fa-circle',1,1),
(10,NULL,'top','Home','home','#','far fa-circle',1,1),
(11,NULL,'top','Contact','contact','#','far fa-circle',1,1),
(12,NULL,'left','Extra','extra','#','far fa-plus-square',0,1),
(13,12,'left','Login','login','login','far fa-circle',1,1),
(14,12,'left','Register','register','register','far fa-circle',1,1),
(15,NULL,'left','Setting','setting','#','far fa-circle',0,1),
(16,15,'left','Privileges','privileges','setting/privileges','far fa-circle',1,1);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `migrations` */

insert  into `migrations`(`version`) values 
(5);

/*Table structure for table `privileges` */

DROP TABLE IF EXISTS `privileges`;

CREATE TABLE `privileges` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `privileges` */

/*Table structure for table `user_privileges` */

DROP TABLE IF EXISTS `user_privileges`;

CREATE TABLE `user_privileges` (
  `user_id` int(10) unsigned NOT NULL,
  `privilege_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`privilege_id`),
  KEY `fk_user_privileges_privilege` (`privilege_id`),
  CONSTRAINT `fk_user_privileges_privilege` FOREIGN KEY (`privilege_id`) REFERENCES `privileges` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_user_privileges_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `user_privileges` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `users` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
