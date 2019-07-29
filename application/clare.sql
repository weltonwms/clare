CREATE TABLE `anotacao` (
  `id_anotacao` int(11) NOT NULL,
  `id_fornecedor` int(11) NOT NULL COMMENT 'fk fornecedor',
  `descricao` varchar(300) NOT NULL,
  `data` date NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `endereco` varchar(100) NOT NULL,
  `telefone` varchar(45) NOT NULL,
  `responsavel` varchar(100) DEFAULT NULL,
  `cnpj` varchar(60) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `telefone2` varchar(60) DEFAULT NULL,
  `telefone3` varchar(60) DEFAULT NULL,
  `cep` varchar(15) DEFAULT NULL,
  `inc_estadual` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `fornecedor` (
  `id_fornecedor` int(11) NOT NULL,
  `empresa` varchar(100) NOT NULL,
  `responsavel` varchar(100) DEFAULT NULL,
  `fone` varchar(45) DEFAULT NULL,
  `conta` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `item_servico` (
  `id_item` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `qtd_produto` int(11) DEFAULT NULL,
  `descricao` varchar(100) DEFAULT NULL,
  `valor_final` decimal(10,3) NOT NULL,
  `valor_fornecedor` decimal(10,3) DEFAULT NULL,
  `total_fornecedor` decimal(10,2) DEFAULT NULL COMMENT 'Valor de compra do Produto',
  `total_venda` decimal(10,2) DEFAULT NULL COMMENT 'Valor de Venda do Produto'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `pagamento` (
  `id_pagamento` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `valor_pago` decimal(10,2) NOT NULL,
  `data` date NOT NULL,
  `tipo_pagamento` smallint(6) DEFAULT NULL,
  `operacao` tinyint(4) DEFAULT NULL,
  `id_fornecedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `produto` (
  `id_produto` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `id_fornecedor` int(11) NOT NULL,
  `valor` decimal(10,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `servico` (
  `id_servico` int(11) NOT NULL,
  `data` date DEFAULT NULL,
  `id_cliente` int(11) NOT NULL,
  `estado` int(11) DEFAULT NULL,
  `forma_pagamento` varchar(100) DEFAULT NULL,
  `obs` varchar(200) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  `porcentagem_comissao` float DEFAULT NULL,
  `id_vendedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `login` varchar(45) NOT NULL,
  `senha` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `vendedor` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `servico_estado` (
  `id` int(11) NOT NULL,
  `estado` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `servico_estado` (`id`, `estado`) VALUES
(1, 'Orçamento'),
(2, 'Executado'),
(3, 'Em Produção'),
(4, 'Entregue não Pago');

CREATE TABLE `servico_tipo` (
  `id` int(11) NOT NULL,
  `tipo` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `servico_tipo` (`id`, `tipo`) VALUES
(1, 'Revenda'),
(2, 'Comissão'),
(3, 'Venda Direta');


ALTER TABLE `servico_estado`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `servico_tipo`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `anotacao`
  ADD PRIMARY KEY (`id_anotacao`),
  ADD KEY `id_fornecedor` (`id_fornecedor`);

ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`);

ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`id_fornecedor`);

ALTER TABLE `item_servico`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `fk_produto` (`id_produto`),
  ADD KEY `fk_servico` (`id_servico`);

ALTER TABLE `pagamento`
  ADD PRIMARY KEY (`id_pagamento`),
  ADD KEY `fk_pg_servico` (`id_servico`),
  ADD KEY `fk_pg_id_fornecedor` (`id_fornecedor`) USING BTREE;

ALTER TABLE `produto`
  ADD PRIMARY KEY (`id_produto`),
  ADD KEY `fk_produto_fornecedor1` (`id_fornecedor`);

ALTER TABLE `servico`
  ADD PRIMARY KEY (`id_servico`),
  ADD KEY `fk_servico_cliente` (`id_cliente`);

ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

ALTER TABLE `vendedor`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `anotacao`
  MODIFY `id_anotacao` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `fornecedor`
  MODIFY `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `item_servico`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `pagamento`
  MODIFY `id_pagamento` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `servico`
  MODIFY `id_servico` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `vendedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `anotacao`
  ADD CONSTRAINT `anotacao_ibfk_1` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `item_servico`
  ADD CONSTRAINT `item_servico_ibfk_1` FOREIGN KEY (`id_servico`) REFERENCES `servico` (`id_servico`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `item_servico_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`);

ALTER TABLE `pagamento`
  ADD CONSTRAINT `fk_pg_servico` FOREIGN KEY (`id_servico`) REFERENCES `servico` (`id_servico`) ON DELETE CASCADE,
  ADD CONSTRAINT `pagamento_ibfk_1` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`);

ALTER TABLE `produto`
  ADD CONSTRAINT `fk_produto_fornecedor1` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `servico`
  ADD CONSTRAINT `fk_servico_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

