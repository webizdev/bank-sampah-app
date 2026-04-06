-- MySQL dump 10.13  Distrib 8.0.45, for Linux (x86_64)
--
-- Host: localhost    Database: banksampah
-- ------------------------------------------------------
-- Server version	8.0.45

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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text,
  `icon` varchar(50) DEFAULT NULL,
  `image_url` text,
  `is_popular` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT (now()),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Plastik','plastik','Sampah plastik','local_drink',NULL,1,'2026-04-06 18:19:51'),(2,'Plastik','kertas','Sampah kertas','description',NULL,1,'2026-04-06 18:19:51'),(3,'Plastik','logam','Sampah logam','hardware',NULL,1,'2026-04-06 18:19:51'),(4,'Plastik','kaca','Sampah kaca','wine_bar',NULL,0,'2026-04-06 18:26:48'),(5,'Plastik','minyak-jelantah','Minyak sisa UCO','oil_barrel',NULL,1,'2026-04-06 18:26:48');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content`
--

DROP TABLE IF EXISTS `content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `content` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `content` text,
  `category` varchar(50) DEFAULT 'BLOG',
  `event_date` timestamp NULL DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `cta_link` text,
  `image_url` text,
  `status` varchar(20) DEFAULT 'PUBLISHED',
  `created_at` timestamp NULL DEFAULT (now()),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content`
--

LOCK TABLES `content` WRITE;
/*!40000 ALTER TABLE `content` DISABLE KEYS */;
INSERT INTO `content` VALUES (1,'Workshop Daur Ulang Kreatif','Ubah Sampah Jadi Berkah','Ikuti workshop kami pada hari Sabtu mendatang untuk belajar membuat kerajinan dari limbah plastik.','AGENDA','2026-04-07 00:00:00','Balai Desa Sukamaju','','https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?auto=format&fit=crop&q=80','PUBLISHED','2026-04-06 18:26:48'),(2,'Workshop Daur Ulang Kreatif','Langkah Kecil untuk Bumi','Memilah sampah organik dan non-organik sangat membantu proses daur ulang.','EDUKASI','2026-04-07 00:00:00','','','../uploads/articles/article_1775501586.jpg','PUBLISHED','2026-04-06 18:26:48');
/*!40000 ALTER TABLE `content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `crafts`
--

DROP TABLE IF EXISTS `crafts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `crafts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `description` text,
  `cta_link` text,
  `image_url` text,
  `created_at` timestamp NULL DEFAULT (now()),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crafts`
--

LOCK TABLES `crafts` WRITE;
/*!40000 ALTER TABLE `crafts` DISABLE KEYS */;
INSERT INTO `crafts` VALUES (1,'Kerajinan Dari Botol',12000.00,'Di buat dari botol bekas','https://wa.me/6281234567890','../uploads/crafts/craft_1775502870.png','2026-04-06 19:14:30'),(2,'Kerajinan Dari Sendok',22000.00,'Kerajinan dari sendok bekas resto','https://wa.me/6281234567890','../uploads/crafts/craft_1775502922.jpg','2026-04-06 19:15:22'),(3,'Tas Cantik',19000.00,'Tas cantik ini dibuat dari plastik multi layer','https://wa.me/6281234567890','../uploads/crafts/craft_1775502984.jpeg','2026-04-06 19:16:24'),(4,'Tas Anyaman Plastik',45000.00,'Tas ini dibuat dari anyaman plastik bekas','https://wa.me/6281234567890','../uploads/crafts/craft_1775503032.jpg','2026-04-06 19:17:12');
/*!40000 ALTER TABLE `crafts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text,
  `price_per_kg` decimal(10,2) NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `image_url` text,
  `is_popular` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT (now()),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `products_category_id_categories_id_fk` (`category_id`),
  CONSTRAINT `products_category_id_categories_id_fk` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,'Botol PET Bersih','botol-pet',NULL,4500.00,'local_drink',NULL,1,'2026-04-06 18:19:51'),(2,1,'Botol PET Bersih','gelas-plastik',NULL,3500.00,'coffee',NULL,1,'2026-04-06 18:19:51'),(3,2,'Botol PET Bersih','kardus-bekas',NULL,2800.00,'inventory_2',NULL,1,'2026-04-06 18:19:51'),(4,2,'Botol PET Bersih','kertas-hvs',NULL,1200.00,'menu_book',NULL,1,'2026-04-06 18:26:48'),(5,3,'Botol PET Bersih','kaleng-alu',NULL,10000.00,'view_in_ar',NULL,1,'2026-04-06 18:26:48'),(6,5,'Botol PET Bersih','jelantah','',5000.00,'opacity','../uploads/products/product_1775503944_69d40a4890da2.png',1,'2026-04-06 18:26:48');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned DEFAULT NULL,
  `weight_sold` decimal(10,2) NOT NULL,
  `price_per_kg` decimal(10,2) NOT NULL,
  `total_price` decimal(12,2) NOT NULL,
  `buyer_name` varchar(150) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'COMPLETED',
  `created_at` timestamp NULL DEFAULT (now()),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `sales_product_id_products_id_fk` (`product_id`),
  CONSTRAINT `sales_product_id_products_id_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales`
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` VALUES (1,6,2.00,8000.00,16000.00,'BSI','COMPLETED','2026-04-06 20:07:35');
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `description` text,
  `type` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT (now()),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,'Penjemputan Rutin','Tim kami akan menjemput sampah Anda setiap hari Minggu.','PICKUP',1,'2026-04-06 18:26:48'),(2,'Penjemputan Rutin','Mari kita berkolaburasi membentuk budaya sadar kebersihan dan mengelola sampah dengan benar','CONSULT',1,'2026-04-06 18:26:48');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text,
  `description` text,
  `updated_at` timestamp NULL DEFAULT (now()) ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `settings_setting_key_unique` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'app_name','Bank Sampah',NULL,'2026-04-06 18:54:48'),(2,'wa_cs_number','6281257123863',NULL,'2026-04-06 18:54:48'),(3,'address','Samarinda',NULL,'2026-04-06 18:54:48'),(4,'social_instagram','https://instagram.com',NULL,'2026-04-06 18:54:48'),(5,'social_facebook','https://facebook.com',NULL,'2026-04-06 18:54:48'),(6,'social_twitter','https://x.com',NULL,'2026-04-06 18:54:48'),(7,'tier_bronze_min','0',NULL,'2026-04-06 18:54:48'),(8,'tier_silver_min','50',NULL,'2026-04-06 18:54:48'),(9,'tier_gold_min','200',NULL,'2026-04-06 18:54:48');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `weight_est` decimal(10,2) NOT NULL,
  `weight_actual` decimal(10,2) DEFAULT NULL,
  `total_payout` decimal(10,2) NOT NULL,
  `status` varchar(20) DEFAULT 'PENDING',
  `type` varchar(20) DEFAULT 'DROPOFF',
  `address` text,
  `note` text,
  `created_at` timestamp NULL DEFAULT (now()),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `transactions_product_id_products_id_fk` (`product_id`),
  KEY `transactions_user_id_users_id_fk` (`user_id`),
  CONSTRAINT `transactions_product_id_products_id_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `transactions_user_id_users_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (7,2,6,12.00,12.00,60000.00,'VERIFIED','DROPOFF',NULL,NULL,'2026-04-06 20:06:30'),(8,2,1,1.00,1.00,4500.00,'VERIFIED','DROPOFF',NULL,NULL,'2026-04-06 20:06:42');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `whatsapp` varchar(20) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT 'USER',
  `balance` decimal(12,2) DEFAULT '0.00',
  `total_kg` decimal(10,2) DEFAULT '0.00',
  `tier` varchar(50) DEFAULT 'Bronze',
  `avatar_url` text,
  `organization` varchar(100) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `account_number` varchar(50) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `address` text,
  `created_at` timestamp NULL DEFAULT (now()),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `users_whatsapp_unique` (`whatsapp`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator','08123456789','admin@banksampah.com','password123','ADMIN',0.00,0.00,'Gold',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-04-06 18:26:48'),(2,'Administrator','08111222333','budi@example.com',NULL,'USER',64500.00,13.00,'Silver','uploads/avatars/avatar_2_1775501419.png','Bank Sampah','BCA','801234567888',-0.57823587,117.19272792,'Jalan Provinsi, Bukuan, Palaran, Samarinda, East Kalimantan, Kalimantan, Indonesia','2026-04-06 18:26:48');
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

-- Dump completed on 2026-04-06 21:19:58
