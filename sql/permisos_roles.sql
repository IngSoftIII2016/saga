-- -----------------------------------------------------
-- Table `gestion_aulas`.`ROL`
-- -----------------------------------------------------

CREATE  TABLE `gestion_aulas`.`rol` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
  engine = InnoDB;
  
-- -----------------------------------------------------
-- COLUMN `rol` Table `gestion_aulas`.`usuario`
-- -----------------------------------------------------
  
  ALTER TABLE `gestion_aulas`.`usuario` ADD COLUMN `rol` INT NOT NULL  AFTER `phone` ;
  
-- -----------------------------------------------------
-- FOREIGN KEY `rol` Table `gestion_aulas`.`usuario`
-- -----------------------------------------------------
  
  ALTER TABLE `gestion_aulas`.`usuario` 
  ADD CONSTRAINT `fk_usuario_rol`
  FOREIGN KEY (`rol` )
  REFERENCES `gestion_aulas`.`rol` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, ADD INDEX `fk_usuario_rol_idx` (`rol` ASC) ;

-- -----------------------------------------------------
-- INSERT Table `gestion_aulas`.`rol`
-- -----------------------------------------------------

INSERT INTO `gestion_aulas`.`rol` (`nombre`) VALUES ('admin');
INSERT INTO `gestion_aulas`.`rol` (`nombre`) VALUES ('administracion academica');
INSERT INTO `gestion_aulas`.`rol` (`nombre`) VALUES ('bedel');
INSERT INTO `gestion_aulas`.`rol` (`nombre`) VALUES ('alumno');

-- -----------------------------------------------------
-- Table `gestion_aulas`.`accion`
-- -----------------------------------------------------

CREATE  TABLE `gestion_aulas`.`accion` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `url` VARCHAR(100) NULL ,
  `metodo` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
  engine = InnoDB;
  
-- -----------------------------------------------------
-- Table `gestion_aulas`.`accion_rol`
-- -----------------------------------------------------
 
 CREATE  TABLE `gestion_aulas`.`accion_rol` (
  `Accion_id` INT NULL ,
  `Rol_id` INT NULL )
  engine = InnoDB;
  
-- -----------------------------------------------------
-- FOREIGN KEY Table `gestion_aulas`.`accion_rol`
-- -----------------------------------------------------
 
 ALTER TABLE `gestion_aulas`.`accion_rol` 
  ADD CONSTRAINT `fk_accion_has_rol_accion1`
  FOREIGN KEY (`Accion_id` )
  REFERENCES `gestion_aulas`.`accion` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `fk_accion_has_rol_rol1`
  FOREIGN KEY (`Rol_id` )
  REFERENCES `gestion_aulas`.`rol` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, ADD INDEX `fk_accion_has_rol_accion1_idx` (`Accion_id` ASC) 
, ADD INDEX `fk_accion_has_rol_rol1_idx` (`Rol_id` ASC) ;

-- -----------------------------------------------------
-- COLUMN `recurso` Table `gestion_aulas`.`accion`
-- -----------------------------------------------------

ALTER TABLE `gestion_aulas`.`accion` ADD COLUMN `recurso` VARCHAR(45) NULL  AFTER `metodo` ;

