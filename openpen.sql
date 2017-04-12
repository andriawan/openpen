CREATE DATABASE  IF NOT EXISTS `openpen` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `openpen`;
-- MySQL dump 10.13  Distrib 5.6.28, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: openpen
-- ------------------------------------------------------
-- Server version	5.6.28-0ubuntu0.15.04.1

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
-- Table structure for table `act_marathon_prop`
--

DROP TABLE IF EXISTS `act_marathon_prop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `act_marathon_prop` (
  `marathon_prop_id` int(4) NOT NULL AUTO_INCREMENT,
  `writing_id` int(4) NOT NULL,
  `user_proposer` int(9) NOT NULL,
  `prop_text` text NOT NULL,
  `date_prop_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `prop_status` int(1) DEFAULT '0',
  PRIMARY KEY (`marathon_prop_id`),
  KEY `fk_writing_id_idx` (`writing_id`),
  KEY `fk_proposer_idx` (`user_proposer`),
  CONSTRAINT `fk_proposer` FOREIGN KEY (`user_proposer`) REFERENCES `user` (`regist_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_writing_id` FOREIGN KEY (`writing_id`) REFERENCES `act_writing` (`writing_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='table for propose marathon writing\n';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `act_marathon_prop`
--

LOCK TABLES `act_marathon_prop` WRITE;
/*!40000 ALTER TABLE `act_marathon_prop` DISABLE KEYS */;
INSERT INTO `act_marathon_prop` VALUES (1,33,10,'love you so much :)','2017-01-15 13:48:58',0),(2,33,10,'love you so much :)','2017-01-15 13:49:20',0),(3,5,10,'cek it my bro','2017-01-15 13:51:18',0),(4,5,10,'cek it bro','2017-01-15 13:53:37',0),(5,5,10,'texting','2017-01-15 14:06:56',0),(6,5,10,'texting','2017-01-15 14:07:34',0),(7,5,10,'xgdgd','2017-01-15 14:09:56',0),(8,36,9,'test sek','2017-01-15 14:20:19',0),(9,36,9,'test sek','2017-01-15 14:21:09',0),(10,36,9,'cek it out bro','2017-01-15 15:12:51',0);
/*!40000 ALTER TABLE `act_marathon_prop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `act_writing`
--

DROP TABLE IF EXISTS `act_writing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `act_writing` (
  `writing_id` int(4) NOT NULL AUTO_INCREMENT,
  `user_regist_id` int(9) NOT NULL,
  `title` varchar(45) DEFAULT NULL,
  `content` text,
  `date_created` timestamp NULL DEFAULT NULL,
  `marathon_status` int(1) DEFAULT NULL,
  `toc_status` varchar(45) DEFAULT NULL,
  `activity_id` int(2) DEFAULT NULL,
  PRIMARY KEY (`writing_id`),
  KEY `fk_activity_id_idx` (`activity_id`),
  KEY `fk_writing_user1` (`user_regist_id`),
  CONSTRAINT `fk_activity_id` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`activity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_writing_user1` FOREIGN KEY (`user_regist_id`) REFERENCES `user` (`regist_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `act_writing`
--

LOCK TABLES `act_writing` WRITE;
/*!40000 ALTER TABLE `act_writing` DISABLE KEYS */;
INSERT INTO `act_writing` VALUES (1,10,'My Love','Aku di sini tak akan pernak menyakiti','2017-01-13 05:46:20',1,'Introduction',1),(5,9,'jello my first','damn you my skill','2017-01-13 05:51:38',1,'Introduction',1),(6,8,'just title','bla bla bla bla bla','2017-01-13 05:58:30',1,'Introduction',1),(7,8,'s','dfdgdg','2017-01-13 06:01:07',1,'Introduction',1),(8,8,'safdaf','dfdgdgdfafdaf','2017-01-13 06:04:19',1,'Introduction',1),(17,10,'ceksfsfsf','ssgfsgsg','2017-01-13 06:15:13',1,'Introduction',1),(18,10,'cekfsf','xfsvslkslfjsl bfaskfsk ksnfksnfksnf','2017-01-13 06:18:08',0,'Introduction',1),(19,10,'hello','aedjabdabdakd,xna','2017-01-13 06:30:55',1,'Introduction',1),(20,10,'hai','bluewn','2017-01-13 06:35:38',1,'Introduction',1),(21,8,'aafa','sfssfg sfsfscsfsf fsfsf','2017-01-13 06:36:18',1,'Introduction',1),(24,10,'sfsg','arafafra sfsfaf','2017-01-13 08:47:55',1,'Introduction',1),(25,8,'we make it as go','my name is alk, i have another story','2017-01-13 08:49:38',1,'Introduction',1),(27,8,'zvxsgxss','zxvxvxvxvx','2017-01-13 08:54:08',0,'Introduction',2),(33,15,'me as mine','asdjkfafnclasn','2017-01-13 13:01:45',1,'Introduction',1),(34,10,'cek br','no bug no learning','2017-01-13 15:28:06',1,'Introduction',1),(35,10,'Dunia','Dengan segenap rasa, allin pulang dengan membawa kabar duka. Di tengah perjalanan pulang, ia terhenti menunggu air matanya sempurna jatuh ke bumi :)','2017-01-14 11:19:48',1,'Introduction',1),(36,10,'test','fusly come','2017-01-14 14:29:09',1,'Introduction',1);
/*!40000 ALTER TABLE `act_writing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `activity`
--

DROP TABLE IF EXISTS `activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity` (
  `activity_id` int(2) NOT NULL AUTO_INCREMENT,
  `activity` text,
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity`
--

LOCK TABLES `activity` WRITE;
/*!40000 ALTER TABLE `activity` DISABLE KEYS */;
INSERT INTO `activity` VALUES (1,'writes new story'),(2,'proposes story'),(3,'is interested in your story');
/*!40000 ALTER TABLE `activity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `all_user_post`
--

DROP TABLE IF EXISTS `all_user_post`;
/*!50001 DROP VIEW IF EXISTS `all_user_post`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `all_user_post` AS SELECT 
 1 AS `regist_id`,
 1 AS `lastname`,
 1 AS `firstname`,
 1 AS `pen_name`,
 1 AS `writing_id`,
 1 AS `content`,
 1 AS `date_created`,
 1 AS `marathon_status`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `friend_list`
--

DROP TABLE IF EXISTS `friend_list`;
/*!50001 DROP VIEW IF EXISTS `friend_list`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `friend_list` AS SELECT 
 1 AS `user_regist_id`,
 1 AS `pen_name`,
 1 AS `friend`,
 1 AS `confirm`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `genre`
--

DROP TABLE IF EXISTS `genre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `genre` (
  `genre_id` int(3) NOT NULL AUTO_INCREMENT,
  `genre` varchar(45) NOT NULL,
  PRIMARY KEY (`genre_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genre`
--

LOCK TABLES `genre` WRITE;
/*!40000 ALTER TABLE `genre` DISABLE KEYS */;
INSERT INTO `genre` VALUES (1,'Fiction'),(2,'Fantasy'),(3,'Romance'),(4,'Daily Life'),(5,'Scifi'),(6,'Thriller');
/*!40000 ALTER TABLE `genre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `message_id` int(9) NOT NULL AUTO_INCREMENT,
  `sender_id` int(9) DEFAULT NULL,
  `reciever_id` int(9) DEFAULT NULL,
  `message_subject` text,
  `date_created` timestamp NULL DEFAULT NULL,
  `is_read` int(1) DEFAULT '0',
  PRIMARY KEY (`message_id`),
  KEY `sender_fk_idx` (`sender_id`),
  KEY `reciever_fk_idx` (`reciever_id`),
  CONSTRAINT `reciever_fk` FOREIGN KEY (`reciever_id`) REFERENCES `user` (`regist_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sender_fk` FOREIGN KEY (`sender_id`) REFERENCES `user` (`regist_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,15,10,'sfgsgs','2017-01-15 03:09:03',1),(2,15,10,'sfgsgsxfg','2017-01-15 03:12:36',1),(3,15,10,'test','2017-01-15 03:14:17',1),(4,10,15,'cek','2017-01-15 03:18:24',1),(5,10,8,'ceking out','2017-01-15 03:57:04',1),(6,10,9,'test bro','2017-01-15 04:00:59',0),(7,9,10,'oke bro','2017-01-15 04:01:27',1),(8,10,8,'cek it','2017-01-15 05:46:45',1),(10,10,9,'cek','2017-01-15 08:20:12',0),(11,10,15,'test','2017-01-15 08:20:49',1),(12,10,15,'oke','2017-01-15 08:22:21',1),(13,15,10,'yap','2017-01-15 08:23:27',1),(14,10,15,'klasik','2017-01-15 08:24:24',1),(15,8,10,'okey','2017-01-15 08:25:30',1),(16,8,10,'hello','2017-01-15 08:34:20',1),(17,10,8,'cek','2017-01-15 08:34:49',1),(18,8,15,'cekadafad','2017-01-15 08:40:02',1),(19,8,10,'i am okey','2017-01-15 08:40:33',1),(20,10,8,'of course','2017-01-15 08:42:52',1),(21,8,10,'oke','2017-01-15 08:44:35',1),(22,10,8,'cekds','2017-01-15 08:46:56',1),(23,8,10,'membalas','2017-01-15 08:47:28',1),(24,10,8,'','2017-01-15 08:47:39',1),(25,10,8,'cek','2017-01-15 10:58:58',0);
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `messages_list`
--

DROP TABLE IF EXISTS `messages_list`;
/*!50001 DROP VIEW IF EXISTS `messages_list`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `messages_list` AS SELECT 
 1 AS `sender_id`,
 1 AS `pen_name`,
 1 AS `firstname`,
 1 AS `lastname`,
 1 AS `reciever_id`,
 1 AS `message_subject`,
 1 AS `date_created`,
 1 AS `is_read`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `notif_id` int(9) NOT NULL AUTO_INCREMENT,
  `reciever` int(9) DEFAULT NULL,
  `sender` int(9) DEFAULT NULL,
  `activity` int(2) DEFAULT NULL,
  `object_id` int(9) DEFAULT NULL,
  `notif_created` timestamp NULL DEFAULT NULL,
  `notif_status` int(1) DEFAULT '0',
  PRIMARY KEY (`notif_id`),
  KEY `fk_user_reciever_idx` (`reciever`),
  KEY `fk_user_sender_idx` (`sender`),
  KEY `fk_activity_idx` (`activity`),
  CONSTRAINT `fk_activity` FOREIGN KEY (`activity`) REFERENCES `activity` (`activity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_user_reciever` FOREIGN KEY (`reciever`) REFERENCES `user` (`regist_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_user_sender` FOREIGN KEY (`sender`) REFERENCES `user` (`regist_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,9,10,2,5,'2017-01-15 14:09:56',0),(2,10,9,2,36,'2017-01-15 14:21:09',0),(3,10,9,2,36,'2017-01-15 15:12:51',0);
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `notifications_list`
--

DROP TABLE IF EXISTS `notifications_list`;
/*!50001 DROP VIEW IF EXISTS `notifications_list`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `notifications_list` AS SELECT 
 1 AS `notif_id`,
 1 AS `reciever`,
 1 AS `sender`,
 1 AS `activity`,
 1 AS `object_id`,
 1 AS `notif_created`,
 1 AS `notif_status`,
 1 AS `regist_id`,
 1 AS `pen_name`,
 1 AS `firstname`,
 1 AS `lastname`,
 1 AS `email`,
 1 AS `phone_number`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `pen_friend`
--

DROP TABLE IF EXISTS `pen_friend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pen_friend` (
  `init_id` int(9) NOT NULL AUTO_INCREMENT,
  `user_regist_id` int(9) NOT NULL,
  `friend` int(9) DEFAULT NULL,
  `confirm` int(1) DEFAULT '0',
  PRIMARY KEY (`init_id`),
  KEY `fk_regist_id_idx` (`user_regist_id`),
  KEY `fk_pen_friend_1_idx` (`friend`),
  CONSTRAINT `fk_pen_friend_1` FOREIGN KEY (`friend`) REFERENCES `user` (`regist_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_regist_id` FOREIGN KEY (`user_regist_id`) REFERENCES `user` (`regist_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pen_friend`
--

LOCK TABLES `pen_friend` WRITE;
/*!40000 ALTER TABLE `pen_friend` DISABLE KEYS */;
INSERT INTO `pen_friend` VALUES (71,8,10,1),(72,10,8,1),(74,15,10,1),(75,10,15,1),(76,10,9,1),(77,9,10,1),(78,9,15,1),(79,15,9,1),(80,8,15,1),(81,15,8,1);
/*!40000 ALTER TABLE `pen_friend` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `proposal_list`
--

DROP TABLE IF EXISTS `proposal_list`;
/*!50001 DROP VIEW IF EXISTS `proposal_list`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `proposal_list` AS SELECT 
 1 AS `marathon_prop_id`,
 1 AS `writing_id`,
 1 AS `user_proposer`,
 1 AS `prop_text`,
 1 AS `date_prop_created`,
 1 AS `prop_status`,
 1 AS `regist_id`,
 1 AS `pen_name`,
 1 AS `firstname`,
 1 AS `lastname`,
 1 AS `email`,
 1 AS `phone_number`,
 1 AS `gen_time`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `regist_id` int(9) NOT NULL AUTO_INCREMENT,
  `pen_name` varchar(16) NOT NULL,
  `firstname` varchar(45) NOT NULL DEFAULT 'anonymous',
  `lastname` varchar(45) NOT NULL DEFAULT 'anonymous',
  `age` int(3) NOT NULL,
  `sex` enum('Male','Female') NOT NULL,
  `email` varchar(512) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `password` varchar(100) NOT NULL,
  `gen_time` timestamp NULL DEFAULT NULL,
  `date_birth` datetime DEFAULT NULL,
  PRIMARY KEY (`regist_id`,`pen_name`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (8,'gagas','Andriawan','Irwan',22,'Male','andriawanirwan@yahoo.com','087857854930','$2y$09$Ny.ooqdkrozyFszZ5C1iKOKuaBQIBVTGeDfY5GrcJEFXo6jhsU5DS','2017-01-12 11:55:30','1994-12-13 00:00:00'),(9,'jjuts','jikukan','ninjutsu',27,'Male','jjusts@hushu.com','0823134548','$2y$09$NnRcxrgXGawesbhpeQeDn.NCK7/EV78nQPoybmn7BUO2./PKhA8y2','2017-01-12 13:19:14','1990-09-04 00:00:00'),(10,'eywarnerone','Muhammad','Irwan Andriawan',22,'Male','andriawan2014@gmail.com','089637755100','$2y$09$cHs2F7gDLy7JnekVtEnAWO6pvCIU1x/n0/lAx0ti51nBZa6IRBUCO','2017-01-12 15:41:26','1994-11-13 00:00:00'),(14,'JFLASJGLAJ','hafh','aHFKASJGKAS',27,'Male','cbshsdfhnd@yaho','192913724','$2y$09$h0xA3Wn3QxU.mKzlxZPlFOVeu5DNVJgSzoaZPrfhBMmjy.bjnNGDa','2017-01-13 02:56:02','1990-11-23 00:00:00'),(15,'drastika','Daras','Tika',22,'Female','darastika@yahoo.com','089637755100','$2y$09$JpyVPfDIY54FXNeBb4rYSOLT/nKSUyEPb7/H97ZiJZUIVMIswZ1t2','2017-01-13 11:45:58','1995-09-24 00:00:00'),(20,'bimzx','xuxu','bima',19,'Female','andriawan2014@gmail.com','087857854930','$2y$09$vnZD1o.hEe9pxyW.vvLA2.XkKOp4vEs.q9DnGpx.qXSEIdMUhcOTq','2017-01-14 03:50:18','1997-11-15 00:00:00'),(22,'aszlas','agra','ad',21,'Female','andriawanirwan@yahoo.com','087857854930','$2y$09$xql78/20iI/idzyHP0r7ueBsr7p5SmuzCoQDRb8yE6.qGwYjtThzS','2017-01-14 04:03:38','1996-01-10 00:00:00'),(23,'spoxw','aldc','adad',20,'Female','andriawan2014@gmail.com','087857854930','$2y$09$RGYgu7tAyaV0e2Iy02Q2Tuf9jQjGhpZj1lTblYRmJJfNNsquVV.Bm','2017-01-14 04:16:30','1997-03-07 00:00:00'),(26,'sfsfsfsfg','eyw','eqaeqe',829,'Male','andriawan2014@gmail.com','087857854930','$2y$09$096vZvF5Pwk6f2dwCgY55uyb/6UoYloCIZg90Yu23HfByVrONYWXC','2017-01-14 04:36:02','1199-12-31 00:00:00'),(36,'ef12xgsgsdg','Andriawan','adad',22,'Female','andriawan2014@gmail.com','087857854930','$2y$09$twf8OTQnLPoZJifKGQ4HmuM.Tv07/pvJUTh9Fczb1o8gzMyeghUFu','2017-01-14 10:30:54','1994-12-11 00:00:00');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_genre`
--

DROP TABLE IF EXISTS `user_genre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_genre` (
  `user_genre_id` int(4) NOT NULL AUTO_INCREMENT,
  `user_id` int(9) NOT NULL,
  `genre_id` int(3) NOT NULL,
  PRIMARY KEY (`user_genre_id`,`user_id`),
  KEY `fk_genre_id_idx` (`genre_id`),
  KEY `fk_user_id` (`user_id`),
  CONSTRAINT `fk_genre_id` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`genre_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`regist_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_genre`
--

LOCK TABLES `user_genre` WRITE;
/*!40000 ALTER TABLE `user_genre` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_genre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `writing_genre`
--

DROP TABLE IF EXISTS `writing_genre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `writing_genre` (
  `writing_genre_id` int(11) NOT NULL AUTO_INCREMENT,
  `writing_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL,
  PRIMARY KEY (`writing_genre_id`),
  KEY `fk_ggenre_id` (`genre_id`),
  KEY `fk_gwriting_id` (`writing_id`),
  CONSTRAINT `fk_ggenre_id` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`genre_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_gwriting_id` FOREIGN KEY (`writing_id`) REFERENCES `act_writing` (`writing_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `writing_genre`
--

LOCK TABLES `writing_genre` WRITE;
/*!40000 ALTER TABLE `writing_genre` DISABLE KEYS */;
/*!40000 ALTER TABLE `writing_genre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `all_user_post`
--

/*!50001 DROP VIEW IF EXISTS `all_user_post`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `all_user_post` AS select `user`.`regist_id` AS `regist_id`,`user`.`lastname` AS `lastname`,`user`.`firstname` AS `firstname`,`user`.`pen_name` AS `pen_name`,`act_writing`.`writing_id` AS `writing_id`,`act_writing`.`content` AS `content`,`act_writing`.`date_created` AS `date_created`,`act_writing`.`marathon_status` AS `marathon_status` from (`user` join `act_writing`) where (`user`.`regist_id` = `act_writing`.`user_regist_id`) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `friend_list`
--

/*!50001 DROP VIEW IF EXISTS `friend_list`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `friend_list` AS select `pen_friend`.`user_regist_id` AS `user_regist_id`,`user`.`pen_name` AS `pen_name`,`pen_friend`.`friend` AS `friend`,`pen_friend`.`confirm` AS `confirm` from (`user` join `pen_friend`) where (`user`.`regist_id` = `pen_friend`.`user_regist_id`) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `messages_list`
--

/*!50001 DROP VIEW IF EXISTS `messages_list`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `messages_list` AS select `messages`.`sender_id` AS `sender_id`,`user`.`pen_name` AS `pen_name`,`user`.`firstname` AS `firstname`,`user`.`lastname` AS `lastname`,`messages`.`reciever_id` AS `reciever_id`,`messages`.`message_subject` AS `message_subject`,`messages`.`date_created` AS `date_created`,`messages`.`is_read` AS `is_read` from (`user` join `messages`) where (`user`.`regist_id` = `messages`.`sender_id`) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `notifications_list`
--

/*!50001 DROP VIEW IF EXISTS `notifications_list`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `notifications_list` AS select `notifications`.`notif_id` AS `notif_id`,`notifications`.`reciever` AS `reciever`,`notifications`.`sender` AS `sender`,`notifications`.`activity` AS `activity`,`notifications`.`object_id` AS `object_id`,`notifications`.`notif_created` AS `notif_created`,`notifications`.`notif_status` AS `notif_status`,`user`.`regist_id` AS `regist_id`,`user`.`pen_name` AS `pen_name`,`user`.`firstname` AS `firstname`,`user`.`lastname` AS `lastname`,`user`.`email` AS `email`,`user`.`phone_number` AS `phone_number` from (`notifications` join `user`) where (`user`.`regist_id` = `notifications`.`sender`) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `proposal_list`
--

/*!50001 DROP VIEW IF EXISTS `proposal_list`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `proposal_list` AS select `act_marathon_prop`.`marathon_prop_id` AS `marathon_prop_id`,`act_marathon_prop`.`writing_id` AS `writing_id`,`act_marathon_prop`.`user_proposer` AS `user_proposer`,`act_marathon_prop`.`prop_text` AS `prop_text`,`act_marathon_prop`.`date_prop_created` AS `date_prop_created`,`act_marathon_prop`.`prop_status` AS `prop_status`,`user`.`regist_id` AS `regist_id`,`user`.`pen_name` AS `pen_name`,`user`.`firstname` AS `firstname`,`user`.`lastname` AS `lastname`,`user`.`email` AS `email`,`user`.`phone_number` AS `phone_number`,`user`.`gen_time` AS `gen_time` from (`act_marathon_prop` join `user`) where (`act_marathon_prop`.`user_proposer` = `user`.`regist_id`) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-15 22:39:31
