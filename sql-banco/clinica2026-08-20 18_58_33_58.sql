-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           12.1.2-MariaDB - MariaDB Server
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para clinica
CREATE DATABASE IF NOT EXISTS `clinica` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `clinica`;

-- Copiando estrutura para tabela clinica.especialidades
CREATE TABLE IF NOT EXISTS `especialidades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(100) NOT NULL,
  `sigla` varchar(10) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela clinica.especialidades: ~20 rows (aproximadamente)
INSERT INTO `especialidades` (`id`, `descricao`, `sigla`, `ativo`, `created_at`, `updated_at`) VALUES
	(1, 'CARDIOLOGIA', 'CARD', 1, '2026-08-20 21:02:43', '2026-08-20 21:24:27'),
	(2, 'DERMATOLOGIA', 'DERM', 1, '2026-08-20 21:02:43', '2026-08-20 21:24:54'),
	(3, 'ENDOCRINOLOGIA', 'ENDO', 1, '2026-08-20 21:02:43', '2026-08-20 21:24:54'),
	(4, 'GASTROENTEROLOGIA', 'GASTRO', 1, '2026-08-20 21:02:43', '2026-08-20 21:24:54'),
	(5, 'GINECOLOGIA E OBSTETRÍCIA', 'GO', 1, '2026-08-20 21:02:43', '2026-08-20 21:24:54'),
	(6, 'NEUROLOGIA', 'NEURO', 1, '2026-08-20 21:02:43', '2026-08-20 21:24:54'),
	(7, 'OFTALMOLOGIA', 'OFTALMO', 1, '2026-08-20 21:02:43', '2026-08-20 21:24:54'),
	(8, 'ORTOPEDIA E TRAUMATOLOGIA', 'ORTO', 1, '2026-08-20 21:02:43', '2026-08-20 21:24:54'),
	(9, 'OTORRINOLARINGOLOGIA', 'OTORRINO', 1, '2026-08-20 21:02:43', '2026-08-20 21:24:54'),
	(10, 'PEDIATRIA', 'PED', 1, '2026-08-20 21:02:43', '2026-08-20 21:24:54'),
	(11, 'PSIQUIATRIA', 'PSIQ', 1, '2026-08-20 21:02:43', '2026-08-20 21:24:54'),
	(12, 'UROLOGIA', 'URO', 1, '2026-08-20 21:02:43', '2026-08-20 21:24:54'),
	(13, 'CLÍNICA GERAL', 'CG', 1, '2026-08-20 21:02:43', '2026-08-20 21:24:54'),
	(14, 'ENDODONTIA', 'ENDOD', 1, '2026-08-20 21:02:43', '2026-08-20 21:24:54'),
	(15, 'ANESTESIOLOGIA', 'ANEST', 1, '2026-08-20 21:02:43', '2026-08-20 21:24:54'),
	(16, 'NUTROLOGIA', 'NUTRO', 1, '2026-08-20 21:02:43', '2026-08-20 21:24:54'),
	(17, 'REUMATOLOGIA', 'REUMA', 1, '2026-08-20 21:02:43', '2026-08-20 21:24:54'),
	(18, 'PNEUMOLOGIA', 'PNEUMO', 1, '2026-08-20 21:02:43', '2026-08-20 21:24:54'),
	(19, 'INFECTOLOGIA', 'INFECT', 1, '2026-08-20 21:02:43', '2026-08-20 21:24:54'),
	(20, 'ONCOLOGIA', 'ONCO', 1, '2026-08-20 21:02:43', '2026-08-20 21:24:54');

-- Copiando estrutura para tabela clinica.medicos
CREATE TABLE IF NOT EXISTS `medicos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `cpf` varchar(14) NOT NULL,
  `endereco` varchar(150) DEFAULT NULL,
  `crm` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela clinica.medicos: ~1 rows (aproximadamente)
INSERT INTO `medicos` (`id`, `nome`, `telefone`, `cpf`, `endereco`, `crm`, `created_at`, `updated_at`) VALUES
	(1, 'MANOEL BANDEIRA', '26611866', '12345678910', 'RUA DOS OPERARIOS', '523144', '2026-08-20 21:57:33', '2026-08-20 21:57:33');

-- Copiando estrutura para tabela clinica.medico_especialidade
CREATE TABLE IF NOT EXISTS `medico_especialidade` (
  `medico_id` int(11) NOT NULL,
  `especialidade_id` int(11) NOT NULL,
  PRIMARY KEY (`medico_id`,`especialidade_id`),
  KEY `especialidade_id` (`especialidade_id`),
  CONSTRAINT `1` FOREIGN KEY (`medico_id`) REFERENCES `medicos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `2` FOREIGN KEY (`especialidade_id`) REFERENCES `especialidades` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela clinica.medico_especialidade: ~5 rows (aproximadamente)
INSERT INTO `medico_especialidade` (`medico_id`, `especialidade_id`) VALUES
	(1, 1),
	(1, 4),
	(1, 7),
	(1, 8),
	(1, 10);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
