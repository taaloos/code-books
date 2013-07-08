-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.1.32-community


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema siteweb
--

CREATE DATABASE IF NOT EXISTS siteweb;
USE siteweb;

--
-- Definition of table `auditoria`
--
CREATE TABLE `auditoria` (
  `auditoria_id` int(11) NOT NULL,
  `usuario_login` varchar(20) NOT NULL,
  `ip` varchar(60) DEFAULT NULL,
  `classe` varchar(60) DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `funcao` char(3) DEFAULT NULL,
  `historico` mediumtext,
  KEY `auditoria_pkey` (`auditoria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `auditoria`
--
--
-- Definition of table `favoritos`
--
CREATE TABLE `favoritos` (
  `usuario_id` int(11) NOT NULL,
  `programa` varchar(120) NOT NULL,
  KEY `favoritos_pkey` (`usuario_id`,`programa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `favoritos`
--
--
-- Definition of table `historico`
--
CREATE TABLE `historico` (
  `usuario_id` int(11) NOT NULL,
  `programa` varchar(120) NOT NULL,
  `acessos` int(11) DEFAULT NULL,
  KEY `historico_pkey` (`usuario_id`,`programa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `historico`
--
INSERT INTO `historico` VALUES  (1,'adm_auditoria.php5',85),
 (1,'adm_menu.php5',41),
 (1,'index.php5',5),
 (10,'adm_usuario.php5',1),
 (1,'adm_permissao.php5',10),
 (1,'adm_usuario.php5',51);

--
-- Definition of table `menu`
--
CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `menu_desc` varchar(30) NOT NULL,
  `menu_prog` varchar(120) NOT NULL,
  `menu_icon` varchar(120) DEFAULT NULL,
  `menu_pai` int(11) DEFAULT NULL,
  KEY `menu_pkey` (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--
INSERT INTO `menu` VALUES  (2,'Administração','[menu]','',-1),
 (3,'Gerenciador de Menus','adm_menu.php5','menu.png',2),
 (5,'Processos','[menu]','',-1),
 (11,'Gerenciador de Usuários','adm_usuario.php5','user.png',2),
 (7,'Entradas','exemplo_5_7.php5','proximo.png',6),
 (12,'Permissões','adm_permissao.php5','permissoes.png',2),
 (13,'***TRIAL MO','***TRIAL MODE***','***TRIAL MOD',6),
 (14,'Auditoria','adm_auditoria.php5','audit.png',2),
 (6,'Movimentação','[menu]','',5),
 (15,'Teste de menu','exemplo_5_7.php5','',6);

--
-- Definition of table `permissao`
--
CREATE TABLE `permissao` (
  `usuario_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `permissao_modo` char(3) DEFAULT NULL,
  KEY `permissao_pkey` (`usuario_id`,`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permissao`
--
--
-- Definition of table `tab_teste`
--
CREATE TABLE `tab_teste` (
  `codigo` int(11) NOT NULL,
  `descricao` varchar(20) DEFAULT NULL,
  `valor` double DEFAULT NULL,
  KEY `tab_teste_pkey` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tab_teste`
--
--
-- Definition of table `usuario`
--
CREATE TABLE `usuario` (
  `usuario_id` int(11) NOT NULL,
  `usuario_nome` varchar(60) NOT NULL,
  `usuario_login` varchar(20) NOT NULL,
  `usuario_senha` varchar(30) NOT NULL,
  `usuario_email` varchar(120) DEFAULT NULL,
  `usuario_ativo` int(11) DEFAULT NULL,
  KEY `chv_login` (`usuario_login`),
  KEY `usuario_pkey` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuario`
--
INSERT INTO `usuario` VALUES 
 (10,'Administrador','admin','SfCxXyng3gs=','',1);



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
