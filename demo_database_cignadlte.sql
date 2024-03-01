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

/*Table structure for table `menus` */

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `position` enum('top','left') NOT NULL DEFAULT 'left',
  `name` varchar(100) NOT NULL,
  `slug` varchar(30) NOT NULL,
  `link` varchar(100) NOT NULL,
  `icon` varchar(30) NOT NULL DEFAULT 'far fa-circle',
  `is_last` tinyint(1) unsigned NOT NULL DEFAULT 1,
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Data for the table `menus` */

insert  into `menus`(`id`,`parent_id`,`position`,`name`,`slug`,`link`,`icon`,`is_last`,`is_active`) values 
(1,NULL,'left','Starter Page','starter','starter','fas fa-tachometer-alt',1,1),
(2,NULL,'left','Tables','table','#','fas fa-table',0,1),
(3,2,'left','Simple Table','simple_table','tables/simple','far fa-circle',1,1),
(4,2,'left','Datatables','dtables','tables/dtables','far fa-circle',1,1),
(5,2,'left','JqGrid','jqgrid','tables/jqgrid','far fa-circle',1,1),
(6,NULL,'left','Level 1','level_1','#','fas fa-circle',0,1),
(7,6,'left','Level 2','level_2','#','far fa-circle',1,1),
(8,6,'left','Level 2','level_2','#','far fa-circle',0,1),
(9,8,'left','Level 3','level_3','#','fas fa-circle',1,1),
(10,NULL,'top','Home','home','#','far fa-circle',1,1),
(11,NULL,'top','Contact','contact','#','far fa-circle',1,1),
(12,NULL,'left','Extra','extra','#','far fa-plus-square',0,1),
(13,12,'left','Login','login','login','far fa-circle',1,1),
(14,12,'left','Register','register','register','far fa-circle',1,1),
(15,NULL,'left','CRUD','crud','crud','far fa-circle',1,1);

/*Table structure for table `test_crud` */

DROP TABLE IF EXISTS `test_crud`;

CREATE TABLE `test_crud` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `about` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `test_crud` */

insert  into `test_crud`(`id`,`name`,`about`,`created_at`) values 
(1,'John Doe','Just human being','2024-03-01 11:09:35'),
(4,'John Doe','Just human being','2024-03-01 11:20:54');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_username` (`username`),
  UNIQUE KEY `uq_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`,`fullname`,`email`,`is_active`) values 
(1,'america.roob','43da3f7ab16aba994bdcabdd207b301df20da98d','Valentin Turner','beahan.joshuah@example.net',1),
(2,'jovanny38','2f9be7d8f7ddc2509e0f5ab0b435f425a80446c5','Cali Medhurst','eileen.rippin@example.com',0),
(3,'stokes.ezekiel','d36e4e1549197157e8bf9d220e61ec3e3995c4c4','Mrs. Pearline Kunze','celestine02@example.net',0),
(4,'libby86','4a7eaa27ecdfea536231c14ab44a66c6c5ae2f48','Amely Jerde','lind.anderson@example.net',1),
(5,'ikreiger','8857e3473121c5a312d0aba478d5336f176a8bd5','Shannon Schmitt','szboncak@example.com',1),
(6,'mervin.pfannerstill','4c54e689cebf9862d31e09d379442aae1dc4adba','Marlin Jacobs','bahringer.berenice@example.org',0),
(7,'jayde85','a875cf10390145a3889670e40775ce8e07a5a2e4','Mrs. Dorothy Huel','jazmyne93@example.com',0),
(8,'frami.charlotte','2f5e805bd9f4a70e2a49005675ac677f00b18941','Ms. Velma Deckow Jr.','gledner@example.net',1),
(9,'pfannerstill.lolita','17ecc9ec1fdba2121553eea91c1139e19c3543bf','Zena Homenick','justyn.marvin@example.com',1),
(10,'jacey75','ed045bc8b5fa7a24d7b066e8974401ffee400fab','Eriberto Schmeler','julian67@example.net',0),
(11,'fatima.breitenberg','f461c8e653c566a0a208d76709edf2604546023d','Emmanuelle Streich','tre97@example.net',0),
(12,'twila10','44d0b8cbe066faa55771a427b54714435d472ba0','Jules Von III','wadams@example.org',0),
(13,'koelpin.melyssa','aef60f67143464d741a73ca7c84580c8b13272c3','Kelsi Kemmer','roscoe.thiel@example.org',0),
(14,'roslyn.lind','f9dbf17f8315d5185b7b19be0f3a80b0d05fe24f','Mr. Roy Davis IV','sswift@example.org',0),
(15,'raufderhar','a1e936f24ed54a3f812144f980079b0f31a2a124','Tara Padberg','bernadine89@example.com',1),
(16,'robel.lukas','e374208d8053798dd29d24e2d7b4c46711467e0a','Georgette Nicolas','meaghan71@example.org',0),
(17,'ana.armstrong','7041efc26ccf7b756caa8711bddc1b9f4bf643fc','Garnet Muller','america90@example.org',1),
(18,'jacobs.jamal','ab366ea3e98c1af0a300929613dbcbe57a70e143','Nathan Balistreri','halvorson.juana@example.com',0),
(19,'bdonnelly','836f317a6343db31e48db12c3de206f5827c8552','Prof. Brandon Bogan','maudie25@example.org',0),
(20,'shanahan.alice','b5fadc4818f48a27536b281f07f48826d356011c','Llewellyn DuBuque','cmedhurst@example.com',0),
(21,'alfredo17','7abd760fa125fa6860b7cbf0dd37d06f00cf34d3','Dr. Efrain Mraz','hilma55@example.org',0),
(22,'yost.lazaro','b9e9bf8cbbdd478a3d99fc889daf673f35a52015','Berniece Kuvalis','ryan.sheridan@example.com',1),
(23,'marks.orlando','759a6fb9e64c3a0e9249ae656713079b34ec7327','Reymundo Schaefer IV','emosciski@example.org',0),
(24,'jimmy10','7429668b6c5af7a8f8c1b408c682971cb8edc301','Josefina Altenwerth I','boyle.maverick@example.com',1),
(25,'erippin','0eb6ee9ba1b824d116157c349941b68d8fdff445','Karolann Waelchi','lacy.brakus@example.org',0),
(26,'marks.jose','43626ac6642709aeea6d20f3193e9a9d6ed4115d','Orlo Kulas','cbins@example.org',0),
(27,'stark.jett','8d85bbc6840effaca857c4c2e107bd288473b739','Jarrett Stracke','birdie.rohan@example.com',0),
(28,'herman.gerardo','a5d0cbee46e54ad804277101ebe09de0d4f9573c','Gregorio Torp','roscoe.boyer@example.com',0),
(29,'ethel.mcclure','19aa74f03646570ecf33839cc4fd585358c06d4c','Candida Hessel','harvey31@example.net',0),
(30,'ceasar.larson','58d9b90b496b10afdfdb5dbc3becf6acf98dc163','Miss Skyla Ziemann DDS','gilda17@example.com',1),
(31,'adams.precious','679c67a7a5d6505a2d9695038ced571ea186dae9','Prof. Elton Bergstrom III','mvonrueden@example.org',0),
(32,'jbrekke','dffe362a7d18bd019df5447ae9fadeb094b7c301','Harold Conroy','kuvalis.domenick@example.com',1),
(33,'beatty.evie','6fc68e9e75188c1c3bdf8b05573068176e343e2a','Modesta Miller','hattie.greenfelder@example.net',0),
(34,'tremblay.zack','7f70b18f38e23703abc31ce05232536d24b1be32','Kristy Stamm IV','vincenzo.o\'kon@example.net',1),
(35,'aleen54','494f59a1ed961f730c2ff5b04adaab190ed85c63','Rollin Koepp','braun.billie@example.net',1),
(36,'ucassin','0a6309722c42a5b79dc590475478f29cfe5ffc4e','Horace Boyer','arno14@example.net',1),
(37,'roob.amparo','494332a8ae759287243ab32c54a13a47504a490d','Genoveva Corwin','grady.cesar@example.com',1),
(38,'christiana35','bc9732d64c12a011d5c56445b4dbbf3afd4386f3','Federico Braun V','roob.shad@example.net',0),
(39,'crist.elliott','20c8479aee57283c2a0781052a23d14a53372434','Mr. Garnett Dietrich III','mrunte@example.com',1),
(40,'nella96','df453511af74be437b503609caef97e25618910b','Keara Carroll','cnolan@example.com',0),
(41,'bertram75','da3b2178954afeb0527f646d62ebbccf7f9e4db6','Glenda Dickinson II','meagan.douglas@example.com',1),
(42,'bpacocha','f00ee0ce8bf9c044a326885c10b29f08dec67aeb','Dr. Roma Legros MD','tvon@example.org',1),
(43,'dagmar.price','b31c6fad916337f912abdd6630bad0318ce9809a','Elvis Reynolds','glangosh@example.net',1),
(44,'derick.boyer','7ee59800169d711adb37fd40966e470c6dda9d4d','Lenore Koss','ueichmann@example.com',1),
(45,'qritchie','6218d09d6d9618bf62cba6998cd029b438f6db81','Rosalind Leffler','dthiel@example.com',0),
(46,'gabriella95','bf437d63a873e964c65f930bcb5ab30a407cd649','Velva Jenkins','andre43@example.com',0),
(47,'funk.tamia','4e44a41214efef86e2feb7ffbcad025fae346509','Alexzander Dare','nelda04@example.net',1),
(48,'harber.jaeden','432d2c8ea62eda003f2a7ef6b2de84c849279eba','Brando Kozey','wlittle@example.com',1),
(49,'adeline.smitham','f107f0af280b56b53c17b965b9b50fe43b2d0f1b','Bethel Kub','sabina.collier@example.org',1),
(50,'maci94','1620bf8c5d99a5274d1b622f4ad826adc5717214','Dr. Moshe Leuschke II','herman.alverta@example.com',0),
(51,'cward','a56934ecd26eda3903a9761a286e46a364dfcc78','Shad DuBuque','rosetta94@example.com',1),
(52,'smitham.maxwell','e7dc839bc1e05272ec501d0b1f6f8d55d1ce9cbf','Evert Koch','lueilwitz.halie@example.org',0),
(53,'douglas.waters','2f3d3b307c41f0a0fb8edf4ea107ff58956660bc','Amira Lehner','ahaley@example.com',1),
(54,'mellie05','790c62118efac3538b1af51ee6d4f537ea2d8695','Miss Christelle Gerlach DVM','rodrick.stracke@example.net',0),
(55,'jay86','16a77fcb7f570d2c80ef468e93c8d048276201f4','Elisha Dach','jbartoletti@example.org',0),
(56,'ywisozk','9b2b20cd65f0c52edbb1fc36dc39179f15068929','Otho Reichel','jakob37@example.com',1),
(57,'jjacobi','ab9aebe77556791d5798e87f60aee79b62d0f3aa','Sage Witting','harvey.austen@example.net',1),
(58,'keenan.schowalter','9d6767952ed988456764048a126eb443be193f60','Trudie Brekke','dswaniawski@example.net',0),
(59,'simonis.arianna','88a7a06e8e75019e881a5e447fe0376b1e80ebfc','Jamal Howell','davis.joel@example.net',1),
(60,'fay.zena','d705018f5c4aff26c21a92f7223897d41ee20381','Prof. Keyshawn Nicolas','wava.donnelly@example.net',0),
(61,'claude86','1117396b1dd0dd271b69c07a063a589f231d3c01','Mr. Wilford Bernier II','agoyette@example.org',1),
(62,'chester.hahn','f725be75b91d81da006c79387f8a33c627b385f3','Amari Ryan','reynolds.jacinto@example.org',1),
(63,'kuhic.michaela','fcdf729e62c228233373e06c6a47526b12aeb1a4','Lolita Ritchie','brekke.vickie@example.net',1),
(64,'weber.johnny','1220db088bce745a12434a2a9a929ee92cc9953e','Marvin Veum','ogoyette@example.com',1),
(65,'myah64','74f6ec301907d692f2bcb11c6238912bc1ab8100','Ms. Carrie Will','jay27@example.com',0),
(66,'robel.cora','29c74927911672a358796d89198a472ea6f66638','Effie Mosciski Jr.','daija.kovacek@example.net',1),
(67,'jcrooks','7d0e61c3693c6f9680dc6d25931e61a192ed53b7','Martine Becker','jerry70@example.net',1),
(68,'hollie82','6d0c5069d69c0d48db006e82886982ab414c4cd3','Dr. Walton Nikolaus IV','lstroman@example.net',1),
(69,'roel00','a66bc2d00baf2d17bf875a796b02cf04467c91fe','Max Gottlieb','michele71@example.org',0),
(70,'mariam.streich','405b82f287fcfa68b1c734738d50c37fd55b455f','Tatum White','rodriguez.brittany@example.org',1),
(71,'oral58','aeb97864a125ad154a1b8fb45de14bd438bb74b2','Maria Macejkovic I','lyla.doyle@example.com',0),
(72,'heidenreich.ignatius','1a2f1a7b76fd83f22e021a607aa733e38879f4c0','Elwin Williamson','destinee.herzog@example.com',1),
(73,'christy58','b23ad8bf3bd300c73a0185e67a00b8a43e837db9','Jarvis Kovacek','reynold.morissette@example.com',1),
(74,'mertz.alexandra','68fbca537336757c859cb77a1e7741c05a8bda7b','Ephraim Schoen DDS','pdicki@example.net',0),
(75,'sean96','99ac25d225173afc194f2b0ebc6f60fa42a251be','Prof. Dereck Trantow','damon.aufderhar@example.com',1),
(76,'fatima65','83ca74df233c6b92a610a87fe094da08098b2f91','Milan Schuster','sbotsford@example.net',1),
(77,'madisyn.larson','c4efe4fcc1d472e230743e6403d8582b39468e5b','Dr. Peggie Grimes DDS','kellie.harvey@example.org',0),
(78,'satterfield.kaylin','8ab47831ee24d7c87448a8885111830619f831d7','Maxwell Fritsch','clarabelle.stehr@example.net',0),
(79,'jed.weber','90fe73f852c30c8211fa1b5f9672b8d23f5ad9ec','Burnice Volkman','kris.ladarius@example.com',1),
(80,'davon.bernier','9c28232c84f6aa6a4afdecfa2dd75bad9f751738','Mitchel Feil','mohamed42@example.net',1),
(81,'lubowitz.geovany','e79c52120ef5f6893388981f55c41f11717a519b','Javonte Hermann','imraz@example.net',0),
(82,'martin.zboncak','aebc1c1287eb77502fc2839a3276f4f42c21239a','Emil Balistreri','braeden.jerde@example.net',1),
(83,'okoepp','b6bd1580756d857daf32916554ca4c22dbda32a9','Jake McLaughlin','streich.sonia@example.com',1),
(84,'rigoberto.huels','5e328ab77196dea3fbe3b117da9ff341605339e3','Casandra Torp','heller.teresa@example.com',1),
(85,'kattie96','7bfe79a766ea04ef7b77fa909e7d3c391c519e6b','Gerson Romaguera','lavon92@example.org',0),
(86,'christina46','8e3826cc678f50f4fcd697b8361520a3e1b6ce71','Angelita Lesch','vconn@example.org',1),
(87,'wilhelm.hammes','0275407cd483ae4048e866d778d8b0fab9b05152','Jaren Ledner','torphy.velva@example.org',1),
(88,'angeline.blick','3eab6c5d861d9876d89c741d3855fea56cd05384','Marcos Hegmann','ekonopelski@example.org',1),
(89,'rodrigo.dickens','6c262b2c5d4de7d7ad3036cb7556514af7d86c5c','Hailey Williamson','abner.emard@example.com',0),
(90,'lmiller','fbe05edbdbc27215b29337acb63957a6c5ae6b02','Winona Mayer','montana95@example.org',0),
(91,'nschamberger','eaaaf78f217d420f2db88ca73ed4ee1a3b6a415f','Eloise Carroll DDS','egrimes@example.com',1),
(92,'batz.nellie','d6d9a42c979496ec83746113c9b599aa639de324','Haven Marks Sr.','glover.jaclyn@example.com',0),
(93,'genoveva.emard','9a20a7f9612dee7f3e2ff8fb63d184153c8e08ea','Rosetta Cormier','weldon08@example.net',0),
(94,'eldon90','b5f5d4da30fa3f80bfcbd92d9039adf00b0f65e8','Derick Runolfsson','kellen41@example.org',1),
(95,'alena38','762af535678292c0a53175273220f3cb8ca72c79','Dr. Helga Stokes DVM','klein.kamryn@example.net',0),
(96,'major.goodwin','0e50b31b73ea1cb22bbf9d454ca027bb78587f26','Russ Dietrich','courtney72@example.com',1),
(97,'lou52','5f0227ed8c8f601823c02ac39be4c181465ed731','Prof. Maiya Mills II','ihoeger@example.com',0),
(98,'ueffertz','a4f34f85e8fdf42444a17580f156bab1a174ed91','Dr. Jaren Sauer Jr.','herman.nella@example.net',1),
(99,'heaney.pinkie','ce79f6ba7d9e9ebaa104538c2215f2f9b6d0f7f3','Alayna Skiles','beahan.buck@example.com',1),
(100,'leif19','cad5c22550a9589714e706ed542bfb0fc115646c','Greyson Boyle','morgan72@example.com',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
