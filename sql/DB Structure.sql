SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `cli_id` int(11) NOT NULL AUTO_INCREMENT,
  `cli_nome` varchar(255) DEFAULT NULL,
  `cli_rg` varchar(255) NOT NULL,
  `cli_cpf` varchar(255) NOT NULL,
  `cli_telefone` varchar(255) DEFAULT NULL,
  `cli_email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cli_id`),
  KEY `cli_id` (`cli_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `consumo`;
CREATE TABLE `consumo` (
  `cns_produto` int(11) NOT NULL,
  `cns_reserva` int(11) NOT NULL,
  `cns_valor` double NOT NULL,
  `cns_momento` datetime NOT NULL,
  `cns_qtde` int(11) NOT NULL,
  KEY `FK_CNS_PRODUTO` (`cns_produto`),
  KEY `FK_CNS_RESERVA` (`cns_reserva`),
  CONSTRAINT `FK_CNS_PRODUTO` FOREIGN KEY (`cns_produto`) REFERENCES `produtos` (`prd_id`),
  CONSTRAINT `FK_CNS_RESERVA` FOREIGN KEY (`cns_reserva`) REFERENCES `reservas` (`rsv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `funcionarios`;
CREATE TABLE `funcionarios` (
  `fnc_id` int(11) NOT NULL AUTO_INCREMENT,
  `fnc_nome` varchar(255) NOT NULL,
  `fnc_rg` varchar(255) NOT NULL,
  `fnc_cpf` varchar(255) NOT NULL,
  `fnc_telefone` varchar(255) NOT NULL,
  `fnc_email` varchar(255) NOT NULL,
  `fnc_endereco` varchar(255) NOT NULL,
  `fnc_cep` varchar(255) NOT NULL,
  `fnc_cidade` varchar(255) NOT NULL,
  `fnc_funcao` varchar(255) NOT NULL,
  `fnc_salario` double NOT NULL,
  `fnc_usuario` int(11) NOT NULL,
  PRIMARY KEY (`fnc_id`,`fnc_usuario`),
  KEY `FK_USUARIO` (`fnc_usuario`),
  KEY `fnc_id` (`fnc_id`),
  CONSTRAINT `FK_USUARIO` FOREIGN KEY (`fnc_usuario`) REFERENCES `usuarios` (`usr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `grupos_acessos`;
CREATE TABLE `grupos_acessos` (
  `grp_id` int(11) NOT NULL AUTO_INCREMENT,
  `grp_nome` varchar(255) NOT NULL,
  PRIMARY KEY (`grp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `grupos_acessos` VALUES ('1', 'Administradores');
INSERT INTO `grupos_acessos` VALUES ('2', 'Gerentes');
INSERT INTO `grupos_acessos` VALUES ('3', 'Grupo Básico');

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE `produtos` (
  `prd_id` int(11) NOT NULL AUTO_INCREMENT,
  `prd_descricao` varchar(255) NOT NULL,
  `prd_valor` double NOT NULL,
  PRIMARY KEY (`prd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `reservas`;
CREATE TABLE `reservas` (
  `rsv_id` int(11) NOT NULL AUTO_INCREMENT,
  `rsv_data_entrada` varchar(255) NOT NULL,
  `rsv_data_saida` varchar(255) NOT NULL,
  `rsv_status` tinyint(4) NOT NULL,
  `rsv_cliente` int(11) NOT NULL,
  `rsv_funcionario` int(11) NOT NULL,
  `rsv_suite` int(11) NOT NULL,
  PRIMARY KEY (`rsv_id`),
  KEY `FK_CLIENTE` (`rsv_cliente`),
  KEY `FK_FUNCIONARIO` (`rsv_funcionario`),
  KEY `FK_SUITE` (`rsv_suite`),
  CONSTRAINT `FK_CLIENTE` FOREIGN KEY (`rsv_cliente`) REFERENCES `clientes` (`cli_id`),
  CONSTRAINT `FK_FUNCIONARIO` FOREIGN KEY (`rsv_funcionario`) REFERENCES `funcionarios` (`fnc_id`),
  CONSTRAINT `FK_SUITE` FOREIGN KEY (`rsv_suite`) REFERENCES `suites` (`ste_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `suites`;
CREATE TABLE `suites` (
  `ste_id` int(11) NOT NULL AUTO_INCREMENT,
  `ste_tipo` varchar(255) NOT NULL,
  `ste_valor` double NOT NULL,
  PRIMARY KEY (`ste_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `usr_id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_name` varchar(255) NOT NULL,
  `usr_senha` varchar(255) NOT NULL,
  `usr_grupo` int(11) NOT NULL,
  PRIMARY KEY (`usr_id`),
  KEY `FK_GRUPO_ACESSOS` (`usr_grupo`),
  CONSTRAINT `FK_GRUPO_ACESSOS` FOREIGN KEY (`usr_grupo`) REFERENCES `grupos_acessos` (`grp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `usuarios` VALUES ('1', 'admin', '$2y$10$kCblqGy2XtlUdAOzEatTx.1RUKtiEAh/zC.yekZ3p.10qTgPQw92S', '1');