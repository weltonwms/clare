

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

