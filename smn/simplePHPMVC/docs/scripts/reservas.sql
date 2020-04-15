CREATE TABLE `dynapolls`.`reservas` (
  `parqueoid` INT NOT NULL AUTO_INCREMENT,
  `parqueoEst` VARCHAR(3) NOT NULL,
  `parqueoLot` VARCHAR(45) NOT NULL,
  `parqueoTip` VARCHAR(3) NOT NULL,
  PRIMARY KEY (`parqueoid`));

  INSERT INTO `dynapolls`.`reservas` (`parqueoid`, `parqueoEst`, `parqueoLot`, `parqueoTip`) VALUES ('1', 'ACT', 'SA', 'CAR');
  INSERT INTO `dynapolls`.`reservas` (`parqueoid`, `parqueoEst`, `parqueoLot`, `parqueoTip`) VALUES ('2', 'INA', 'MRV', 'MTO');
