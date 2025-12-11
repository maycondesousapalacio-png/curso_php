-- Remover as tabelas existentes (CUIDADO: isso apagará todos os dados)
DROP TABLE IF EXISTS `concessionaria`.`venda`;
DROP TABLE IF EXISTS `concessionaria`.`modelo`;

-- Recriar a tabela modelo com chave primária simples
CREATE TABLE IF NOT EXISTS `concessionaria`.`modelo` (
  `idmodelo` INT NOT NULL AUTO_INCREMENT,
  `nome_modelo` VARCHAR(100) NOT NULL,
  `cor_modelo` VARCHAR(100) NULL,
  `ano_modelo` YEAR NULL,
  `tipo_modelo` VARCHAR(100) NULL,
  `marca_idmarca` INT NOT NULL,
  PRIMARY KEY (`idmodelo`),
  INDEX `fk_modelo_marca1_idx` (`marca_idmarca` ASC),
  CONSTRAINT `fk_modelo_marca1`
    FOREIGN KEY (`marca_idmarca`)
    REFERENCES `concessionaria`.`marca` (`idmarca`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- Recriar a tabela venda com chave primária simples
CREATE TABLE IF NOT EXISTS `concessionaria`.`venda` (
  `idvenda` INT NOT NULL AUTO_INCREMENT,
  `data_venda` DATE NULL,
  `valor_venda` DECIMAL(10,2) NULL,
  `funcionario_idfuncionario` INT NOT NULL,
  `cliente_idcliente` INT NOT NULL,
  `modelo_idmodelo` INT NOT NULL,
  PRIMARY KEY (`idvenda`),
  INDEX `fk_venda_funcionario_idx` (`funcionario_idfuncionario` ASC),
  INDEX `fk_venda_cliente1_idx` (`cliente_idcliente` ASC),
  INDEX `fk_venda_modelo1_idx` (`modelo_idmodelo` ASC),
  CONSTRAINT `fk_venda_funcionario`
    FOREIGN KEY (`funcionario_idfuncionario`)
    REFERENCES `concessionaria`.`funcionario` (`idfuncionario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_venda_cliente1`
    FOREIGN KEY (`cliente_idcliente`)
    REFERENCES `concessionaria`.`cliente` (`idcliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_venda_modelo1`
    FOREIGN KEY (`modelo_idmodelo`)
    REFERENCES `concessionaria`.`modelo` (`idmodelo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;