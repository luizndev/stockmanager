-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.28-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para teste
DROP DATABASE IF EXISTS `teste`;
CREATE DATABASE IF NOT EXISTS `teste` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `teste`;

-- Copiando estrutura para tabela teste.log_retirada
CREATE TABLE IF NOT EXISTS `log_retirada` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_item` varchar(255) DEFAULT '0',
  `quantidade` int(11) DEFAULT NULL,
  `responsavel` varchar(255) DEFAULT NULL,
  `solicitante` varchar(255) DEFAULT NULL,
  `data` varchar(255) DEFAULT NULL,
  `codigo_item` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `codigo_item` (`codigo_item`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela teste.tabela_itens
CREATE TABLE IF NOT EXISTS `tabela_itens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_item` varchar(255) DEFAULT '0',
  `quantidade` int(11) DEFAULT 0,
  `data_validade` date DEFAULT NULL,
  `almoxarifado` varchar(255) DEFAULT 'Almoxarifado X',
  `codigo_item` varchar(255) DEFAULT '0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Exportação de dados foi desmarcado.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
