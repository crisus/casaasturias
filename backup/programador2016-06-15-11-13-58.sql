-- MySQL dump 10.13  Distrib 5.7.13, for Win64 (x86_64)
--
-- Host: localhost    Database: programador
-- ------------------------------------------------------
-- Server version	5.7.13-log

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
-- Table structure for table `actividades`
--

DROP TABLE IF EXISTS `actividades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actividades` (
  `id` int(255) NOT NULL,
  `actividad` varchar(70) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actividades`
--

LOCK TABLES `actividades` WRITE;
/*!40000 ALTER TABLE `actividades` DISABLE KEYS */;
INSERT INTO `actividades` VALUES (0,'SIN ACTIVIDAD'),(1,'CURSO TENIS NORTE'),(2,'LIMPIEZA PISTA'),(3,'CURSO PADEL 5K'),(4,'TORNEO VETERANOS'),(5,'REPARACION DE RED'),(6,'Para PADEL en pista Pista: 3 rociar insecticida para avispas'),(7,'Para FUTBOL  cazar topos');
/*!40000 ALTER TABLE `actividades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `caracteristicas`
--

DROP TABLE IF EXISTS `caracteristicas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `caracteristicas` (
  `hora_apertura` varchar(5) NOT NULL,
  `hora_cierre` varchar(5) NOT NULL,
  `minutos_antes_reserva` int(2) NOT NULL,
  `minutos_despues_reserva` int(2) NOT NULL,
  `id` int(11) NOT NULL,
  `dias_para_reservar` int(11) NOT NULL,
  `periodo_conservacion_datos` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `caracteristicas`
--

LOCK TABLES `caracteristicas` WRITE;
/*!40000 ALTER TABLE `caracteristicas` DISABLE KEYS */;
INSERT INTO `caracteristicas` VALUES ('9:00','23:30',5,10,1,4,100);
/*!40000 ALTER TABLE `caracteristicas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deportes`
--

DROP TABLE IF EXISTS `deportes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deportes` (
  `deporte` varchar(25) NOT NULL,
  `iconA` varchar(45) DEFAULT NULL,
  `numero_pistas` int(2) DEFAULT NULL,
  PRIMARY KEY (`deporte`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deportes`
--

LOCK TABLES `deportes` WRITE;
/*!40000 ALTER TABLE `deportes` DISABLE KEYS */;
INSERT INTO `deportes` VALUES ('fronton',NULL,NULL),('futbol',NULL,NULL),('padel',NULL,NULL),('tenis',NULL,NULL);
/*!40000 ALTER TABLE `deportes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `firmadas`
--

DROP TABLE IF EXISTS `firmadas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `firmadas` (
  `n_socio` varchar(8) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  `deporte` varchar(45) NOT NULL,
  `np` int(2) NOT NULL,
  `nbTiempo` int(2) NOT NULL,
  `id_tareas` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `firmadas`
--

LOCK TABLES `firmadas` WRITE;
/*!40000 ALTER TABLE `firmadas` DISABLE KEYS */;
INSERT INTO `firmadas` VALUES ('00007/00','mario','2016-06-10','padel',3,10,0),('00001/00','maite','2016-06-10','tenis',2,10,0),('20000/00','REPARACION DE RED','2016-06-14','padel',3,1,5),('20000/00','TORNEO VETERANOS','2016-06-14','padel',3,2,4),('20000/00','TORNEO VETERANOS','2016-06-19','padel',3,2,4),('20000/00','Para FUTBOL  cazar topos','2016-06-12','futbol',1,1,7),('20000/00','Para PADEL en pista Pista: 3 rociar insecticida para avispas','2016-06-13','padel',4,9,6),('20000/00','Para PADEL en pista Pista: 3 rociar insecticida para avispas','2016-06-15','padel',4,9,6),('20000/00','Para PADEL en pista Pista: 3 rociar insecticida para avispas','2016-06-16','padel',4,9,6),('20000/00','Para PADEL en pista Pista: 3 rociar insecticida para avispas','2016-06-18','padel',4,9,6),('20000/00','Para PADEL en pista Pista: 3 rociar insecticida para avispas','2016-06-20','padel',4,9,6),('20000/00','Para PADEL en pista Pista: 3 rociar insecticida para avispas','2016-06-22','padel',4,9,6),('20000/00','Para PADEL en pista Pista: 3 rociar insecticida para avispas','2016-06-23','padel',4,9,6),('20000/00','Para PADEL en pista Pista: 3 rociar insecticida para avispas','2016-06-25','padel',4,9,6),('20000/00','Para PADEL en pista Pista: 3 rociar insecticida para avispas','2016-06-27','padel',4,9,6),('20000/00','Para PADEL en pista Pista: 3 rociar insecticida para avispas','2016-06-29','padel',4,9,6),('20000/00','Para PADEL en pista Pista: 3 rociar insecticida para avispas','2016-06-30','padel',4,9,6),('20000/00','Para FUTBOL  cazar topos','2016-06-15','padel',2,1,7);
/*!40000 ALTER TABLE `firmadas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fronton`
--

DROP TABLE IF EXISTS `fronton`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fronton` (
  `np` int(2) NOT NULL,
  `tiempo` int(3) DEFAULT NULL,
  `min` int(2) DEFAULT NULL,
  `max` int(2) DEFAULT NULL,
  PRIMARY KEY (`np`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fronton`
--

LOCK TABLES `fronton` WRITE;
/*!40000 ALTER TABLE `fronton` DISABLE KEYS */;
INSERT INTO `fronton` VALUES (1,60,2,6),(2,60,2,6);
/*!40000 ALTER TABLE `fronton` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `futbol`
--

DROP TABLE IF EXISTS `futbol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `futbol` (
  `np` int(2) NOT NULL,
  `tiempo` int(3) DEFAULT NULL,
  `min` int(2) DEFAULT NULL,
  `max` int(2) DEFAULT NULL,
  PRIMARY KEY (`np`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `futbol`
--

LOCK TABLES `futbol` WRITE;
/*!40000 ALTER TABLE `futbol` DISABLE KEYS */;
INSERT INTO `futbol` VALUES (1,180,11,22);
/*!40000 ALTER TABLE `futbol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `observaciones`
--

DROP TABLE IF EXISTS `observaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `observaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `n_socio` varchar(10) NOT NULL,
  `fecha` date NOT NULL,
  `deporte` varchar(45) NOT NULL,
  `pista` int(11) NOT NULL,
  `asunto` tinytext NOT NULL,
  `observacion` longtext NOT NULL,
  `archivada` int(1) NOT NULL,
  `realizada` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `observaciones`
--

LOCK TABLES `observaciones` WRITE;
/*!40000 ALTER TABLE `observaciones` DISABLE KEYS */;
INSERT INTO `observaciones` VALUES (1,'00007/00','2016-06-10','padel',3,'avispas','problema con avispas',1,1),(2,'00007/00','2016-06-12','futbol',1,'topos','agujeros en en el terreno de juego, parecen hechos por topos',0,1);
/*!40000 ALTER TABLE `observaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `padel`
--

DROP TABLE IF EXISTS `padel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `padel` (
  `np` int(2) NOT NULL,
  `tiempo` int(3) DEFAULT NULL,
  `min` int(2) DEFAULT NULL,
  `max` int(2) DEFAULT NULL,
  PRIMARY KEY (`np`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `padel`
--

LOCK TABLES `padel` WRITE;
/*!40000 ALTER TABLE `padel` DISABLE KEYS */;
INSERT INTO `padel` VALUES (1,60,4,4),(2,90,4,4),(3,60,4,4),(4,90,4,4);
/*!40000 ALTER TABLE `padel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservas`
--

DROP TABLE IF EXISTS `reservas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservas` (
  `n_socio` varchar(8) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  `deporte` varchar(45) NOT NULL,
  `np` int(2) NOT NULL,
  `nbTiempo` int(2) NOT NULL,
  `id_tareas` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservas`
--

LOCK TABLES `reservas` WRITE;
/*!40000 ALTER TABLE `reservas` DISABLE KEYS */;
INSERT INTO `reservas` VALUES ('00007/00','mario','2016-06-11','padel',3,6,0),('20000/00','REPARACION DE RED','2016-06-14','padel',3,1,5),('20000/00','TORNEO VETERANOS','2016-06-14','padel',3,2,4),('20000/00','TORNEO VETERANOS','2016-06-19','padel',3,2,4),('20000/00','Para FUTBOL  cazar topos','2016-06-12','futbol',1,1,7),('00001/00','maite','2016-06-13','padel',3,12,0),('00002/00','adolfo','2016-06-13','padel',3,12,0),('20000/00','Para PADEL en pista Pista: 3 rociar insecticida para avispas','2016-06-13','padel',4,9,6),('20000/00','Para PADEL en pista Pista: 3 rociar insecticida para avispas','2016-06-15','padel',4,9,6),('20000/00','Para PADEL en pista Pista: 3 rociar insecticida para avispas','2016-06-16','padel',4,9,6),('20000/00','Para PADEL en pista Pista: 3 rociar insecticida para avispas','2016-06-18','padel',4,9,6),('20000/00','Para PADEL en pista Pista: 3 rociar insecticida para avispas','2016-06-20','padel',4,9,6),('20000/00','Para PADEL en pista Pista: 3 rociar insecticida para avispas','2016-06-22','padel',4,9,6),('20000/00','Para PADEL en pista Pista: 3 rociar insecticida para avispas','2016-06-23','padel',4,9,6),('20000/00','Para PADEL en pista Pista: 3 rociar insecticida para avispas','2016-06-25','padel',4,9,6),('20000/00','Para PADEL en pista Pista: 3 rociar insecticida para avispas','2016-06-27','padel',4,9,6),('20000/00','Para PADEL en pista Pista: 3 rociar insecticida para avispas','2016-06-29','padel',4,9,6),('20000/00','Para PADEL en pista Pista: 3 rociar insecticida para avispas','2016-06-30','padel',4,9,6),('00007/00','mario','2016-06-14','padel',3,4,0),('00006/00','carlos','2016-06-14','padel',2,3,0),('00001/00','maite','2016-06-14','padel',3,5,0),('00001/00','maite','2016-06-14','padel',4,8,0),('00000/00','ADMIN','2016-06-14','padel',4,8,0),('00004/00','isabel','2016-06-14','padel',4,7,0),('20000/00','Para FUTBOL  cazar topos','2016-06-15','padel',2,1,7);
/*!40000 ALTER TABLE `reservas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tenis`
--

DROP TABLE IF EXISTS `tenis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tenis` (
  `np` int(2) NOT NULL,
  `tiempo` int(3) DEFAULT NULL,
  `min` int(2) DEFAULT NULL,
  `max` int(2) DEFAULT NULL,
  PRIMARY KEY (`np`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tenis`
--

LOCK TABLES `tenis` WRITE;
/*!40000 ALTER TABLE `tenis` DISABLE KEYS */;
INSERT INTO `tenis` VALUES (1,60,2,4),(2,60,2,4),(3,60,2,4),(4,60,2,4);
/*!40000 ALTER TABLE `tenis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id_usuario` varchar(8) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `clave` varchar(45) NOT NULL,
  `tipo` int(2) NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES ('00000/00','ADMIN','010101',3),('00001/00','maite','',1),('00001/01','belen','',1),('00002/00','adolfo','',1),('00002/01','laura','',1),('00003/00','LUCIANO','',1),('00003/01','MARIBEL','',1),('00004/00','isabel','',1),('00004/01','raquel','',1),('00005/00','veronica','',1),('00005/01','luis','',1),('00006/00','carlos','',1),('00006/01','miguel','',1),('00007/00','mario','',1),('00007/01','lucia','',1),('00020/00','ANA','14689',1),('20000/00','Cristian','235711',2);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-15 11:13:59
