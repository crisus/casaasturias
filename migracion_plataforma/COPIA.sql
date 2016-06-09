-- MySQL dump 10.13  Distrib 5.5.46, for debian-linux-gnu (x86_64)
--
-- Host: Localhost    Database: programador
-- ------------------------------------------------------
-- Server version	5.5.46-0+deb7u1

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

CREATE DATABASE IF NOT EXITS `programador`;

--
-- Table structure for table `actividades`
--

DROP TABLE IF EXISTS `programador`.`actividades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programador`.`actividades` (
  `id` int(255) NOT NULL,
  `actividad` varchar(70) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actividades`
--

LOCK TABLES `programador`.`actividades` WRITE;
/*!40000 ALTER TABLE `programador`.`actividades` DISABLE KEYS */;
INSERT INTO `programador`.`actividades` VALUES (0,'SIN ACTIVIDAD'),(1,'CURSO TENIS NORTE'),(2,'LIMPIEZA PISTA'),(3,'CURSO PADEL 5K'),(4,'TORNEO VETERANOS'),(5,'REPARACION DE RED');
/*!40000 ALTER TABLE `programador`.`actividades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `caracteristicas`
--

DROP TABLE IF EXISTS `programador`.`caracteristicas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programador`.`caracteristicas` (
  `hora_apertura` varchar(5) NOT NULL,
  `hora_cierre` varchar(5) NOT NULL,
  `minutos_antes_reserva` int(2) NOT NULL,
  `minutos_despues_reserva` int(2) NOT NULL,
  `id` int(11) NOT NULL,
  `dias_para_reservar` int(11) NOT NULL,
    `periodo_conservacion_datos` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `caracteristicas`
--

LOCK TABLES `programador`.`caracteristicas` WRITE;
/*!40000 ALTER TABLE `programador`.`caracteristicas` DISABLE KEYS */;
INSERT INTO `programador`.`caracteristicas` VALUES ('9:00','23:30',5,10,1,4,100);
/*!40000 ALTER TABLE `programador`.`caracteristicas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `observaciones`
--

DROP TABLE IF EXISTS `programador`.`observaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programador`.`observaciones` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `n_socio` VARCHAR(10) NOT NULL,
  `fecha` DATE NOT NULL,
  `deporte` VARCHAR(45) NOT NULL,
  `pista` INT NOT NULL,
  `asunto` TEXT(150) NOT NULL,
  `observacion` LONGTEXT NOT NULL,
  `archivada` INT(1) NOT NULL,
  `realizada` INT(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
  ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `deportes`
--

DROP TABLE IF EXISTS `programador`.`deportes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programador`.`deportes` (
  `deporte` varchar(25) NOT NULL,
  `iconA` varchar(45) DEFAULT NULL,
  `numero_pistas` int(2) DEFAULT NULL,
  PRIMARY KEY (`deporte`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deportes`
--

LOCK TABLES `programador`.`deportes` WRITE;
/*!40000 ALTER TABLE `programador`.`deportes` DISABLE KEYS */;
INSERT INTO `programador`.`deportes` VALUES ('fronton',NULL,NULL),('padel',NULL,NULL),('tenis',NULL,NULL);
/*!40000 ALTER TABLE `programador`.`deportes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `firmadas`
--

DROP TABLE IF EXISTS `programador`.`firmadas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programador`.`firmadas` (
  `n_socio` varchar(8) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `fecha` date NOT NULL,
  `deporte` varchar(45) NOT NULL,
  `np` int(2) NOT NULL,
  `nbTiempo` int(2) NOT NULL,
    `id_tareas` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fronton`
--

DROP TABLE IF EXISTS `programador`.`fronton`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programador`.`fronton` (
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

LOCK TABLES `programador`.`fronton` WRITE;
/*!40000 ALTER TABLE `programador`.`fronton` DISABLE KEYS */;
INSERT INTO `programador`.`fronton` VALUES (1,60,2,6),(2,60,2,6);
/*!40000 ALTER TABLE `programador`.`fronton` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `padel`
--

DROP TABLE IF EXISTS `programador`.`padel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programador`.`padel` (
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

LOCK TABLES `programador`.`padel` WRITE;
/*!40000 ALTER TABLE `programador`.`padel` DISABLE KEYS */;
INSERT INTO `programador`.`padel` VALUES (1,60,4,4),(2,90,4,4),(3,60,4,4),(4,90,4,4);
/*!40000 ALTER TABLE `programador`.`padel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservas`
--

DROP TABLE IF EXISTS `programador`.`reservas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programador`.`reservas` (
  `n_socio` varchar(8) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `fecha` date NOT NULL,
  `deporte` varchar(45) NOT NULL,
  `np` int(2) NOT NULL,
  `nbTiempo` int(2) NOT NULL,
    `id_tareas` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tenis`
--

DROP TABLE IF EXISTS `programador`.`tenis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programador`.`tenis` (
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

LOCK TABLES `programador`.`tenis` WRITE;
/*!40000 ALTER TABLE `programador`.`tenis` DISABLE KEYS */;
INSERT INTO `programador`.`tenis` VALUES (1,60,2,4),(2,60,2,4),(3,60,2,4),(4,60,2,4);
/*!40000 ALTER TABLE `programador`.`tenis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `programador`.`usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programador`.`usuario` (
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

LOCK TABLES `programador`.`usuario` WRITE;
/*!40000 ALTER TABLE `programador`.`usuario` DISABLE KEYS */;
INSERT INTO `programador`.`usuario` VALUES ('00001/00','maite','',1),('00001/01','belen','',1),('00002/00','adolfo','',1),('00002/01','laura','',1),('00003/00','LUCIANO','',1),('00003/01','MARIBEL','',1),('00004/00','isabel','',1),('00004/01','raquel','',1),('00005/00','veronica','',1),('00005/01','luis','',1),('00006/00','carlos','',1),('00006/01','miguel','',1),('00007/00','mario','',1),('00007/01','lucia','',1),('00020/00','ANA','14689',1),('20000/00','Cristian','235711',2),('00000/00','ADMIN','010101',3);
/*!40000 ALTER TABLE `programador`.`usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-30 15:59:57
