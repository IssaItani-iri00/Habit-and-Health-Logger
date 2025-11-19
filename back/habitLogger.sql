-- MySQL dump 10.13  Distrib 8.0.43, for macos15 (x86_64)
--
-- Host: localhost    Database: habitLogger
-- ------------------------------------------------------
-- Server version	8.0.43

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `entries`
--

DROP TABLE IF EXISTS `entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `entries` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `raw_text` text NOT NULL,
  `entry_date` date NOT NULL,
  `workout_minutes` int DEFAULT NULL,
  `coffee_cups` int DEFAULT NULL,
  `sleep_time` time DEFAULT NULL,
  `sleep_duration_minutes` int DEFAULT NULL,
  `estimated_calories` int DEFAULT NULL,
  `meal_suggestion` text,
  `nutrition` json DEFAULT NULL,
  `mood` varchar(50) DEFAULT NULL,
  `water_cups` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_entries_user` (`user_id`),
  CONSTRAINT `fk_entries_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entries`
--

LOCK TABLES `entries` WRITE;
/*!40000 ALTER TABLE `entries` DISABLE KEYS */;
/*!40000 ALTER TABLE `entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `habits`
--

DROP TABLE IF EXISTS `habits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `habits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `target_value` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_habits_user` (`user_id`),
  CONSTRAINT `fk_habits_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `habits`
--

LOCK TABLES `habits` WRITE;
/*!40000 ALTER TABLE `habits` DISABLE KEYS */;
/*!40000 ALTER TABLE `habits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (3,'issaitani03@gmail.com','$2y$12$keEkkKzVLplFO8MS1ADHR.h2cAh7XBseK85ufTAnXwQGJbB9TNAKu','admin','Issa'),(5,'issaitani@gmail.com','$2y$12$Rc/pdHgdo56V97/BSSlGN.f5Zyj/iaGMuOncS2AIG7ksHBrhpRux2','user','test'),(6,'charbeldaoud@gmail.com','$2y$12$UpAwLpY0GXpoAdmBAWObju9.w35Jmd1l00SjVxLftMZfnVIfOkoJe','user','Charbel'),(7,'testing@gmail.com','$2y$12$UbLlGV2LPmolDmnssGts1.8TuCByb8gq6b12LZDR9Wxg./fPkTelS','user','Test'),(8,'rayanitani@gmail.com','$2y$12$0J39eYufm4sLhBoTHGwug.UWVxEEXUV3tkoYkzmSG7kKJk0twcMYq','user','Rayan'),(9,'hadiitani@gmail.com','$2y$12$ooc1rNm5fXbuf1JURA5MPOOGb3cKRIGRoTO/T6Dr9MWytJDuX951S','user','Hadi'),(10,'issatest@gmail.com','$2y$12$K.OuykauoBeEHinWwnapdODcrkRTQWY6NBD02UnPF39a.zk7MoXsi','user','IssaTest'),(11,'issatest2@gmail.com','$2y$12$V5IquGQnV7kmnGH.7joCdOu.DJn14a9ZRKv7ZoicBLJFVVtII8PQ2','user','IssaTest2');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-19 23:02:43
