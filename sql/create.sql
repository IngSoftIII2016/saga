SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `gestion_aulas` DEFAULT CHARACTER SET utf8 ;
USE `gestion_aulas` ;

-- -----------------------------------------------------
-- Table `gestion_aulas`.`asignatura`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gestion_aulas`.`asignatura` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(140) NOT NULL,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `gestion_aulas`.`carrera`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gestion_aulas`.`carrera` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `gestion_aulas`.`asignatura_carrera`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gestion_aulas`.`asignatura_carrera` (
  `Asignatura_id` INT(11) NOT NULL,
  `Carrera_id` INT(11) NOT NULL,
  `anio` INT(11) NOT NULL,
  `regimen` ENUM('C','1C','2C','Anual') NOT NULL DEFAULT 'C',
  PRIMARY KEY (`Asignatura_id`, `Carrera_id`),
  INDEX `fk_asignatura_has_carrera_carrera1_idx` (`Carrera_id` ASC),
  INDEX `fk_asignatura_has_carrera_asignatura1_idx` (`Asignatura_id` ASC),
  CONSTRAINT `fk_asignatura_has_carrera_asignatura1`
  FOREIGN KEY (`Asignatura_id`)
  REFERENCES `gestion_aulas`.`asignatura` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_asignatura_has_carrera_carrera1`
  FOREIGN KEY (`Carrera_id`)
  REFERENCES `gestion_aulas`.`carrera` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `gestion_aulas`.`sede`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gestion_aulas`.`sede` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC))
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `gestion_aulas`.`localidad`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gestion_aulas`.`localidad` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `Sede_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC),
  INDEX `fk_Localidad_Sede1_idx` (`Sede_id` ASC),
  CONSTRAINT `fk_Localidad_Sede1`
  FOREIGN KEY (`Sede_id`)
  REFERENCES `gestion_aulas`.`sede` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `gestion_aulas`.`edificio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gestion_aulas`.`edificio` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `Localidad_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC),
  INDEX `fk_Edificio_Localidad1_idx` (`Localidad_id` ASC),
  CONSTRAINT `fk_Edificio_Localidad1`
  FOREIGN KEY (`Localidad_id`)
  REFERENCES `gestion_aulas`.`localidad` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `gestion_aulas`.`aula`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gestion_aulas`.`aula` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(200) NOT NULL,
  `ubicacion` INT(11) NOT NULL,
  `capacidad` INT(11) NULL DEFAULT NULL,
  `Edificio_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Aula_Edificio1_idx` (`Edificio_id` ASC),
  CONSTRAINT `fk_Aula_Edificio1`
  FOREIGN KEY (`Edificio_id`)
  REFERENCES `gestion_aulas`.`edificio` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `gestion_aulas`.`periodo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gestion_aulas`.`periodo` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `fecha_inicio` DATE NOT NULL,
  `fecha_fin` DATE NOT NULL,
  `descripcion` VARCHAR(45),
  PRIMARY KEY (`id`))
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `gestion_aulas`.`comision`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gestion_aulas`.`comision` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `Periodo_id` INT(11) NOT NULL,
  `Docente_id` INT(11) NULL DEFAULT NULL,
  `Asignatura_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Cursada_Periodo1_idx` (`Periodo_id` ASC),
  INDEX `fk_Cursada_Asignatura1_idx` (`Asignatura_id` ASC),
  INDEX `fk_Cursada_Docente1_idx` (`Docente_id` ASC),
  CONSTRAINT `fk_Cursada_Asignatura1`
  FOREIGN KEY (`Asignatura_id`)
  REFERENCES `gestion_aulas`.`asignatura` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Comision_Docente`
  FOREIGN KEY (`Docente_id`)
  REFERENCES `gestion_aulas`.`docente` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cursada_Periodo1`
  FOREIGN KEY (`Periodo_id`)
  REFERENCES `gestion_aulas`.`periodo` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `gestion_aulas`.`horario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gestion_aulas`.`horario` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(45) NULL DEFAULT NULL,
  `frecuencia_semanas` INT(11) NOT NULL DEFAULT '1',
  `dia` INT(11) NOT NULL,
  `hora_inicio` TIME NOT NULL,
  `duracion` TIME NOT NULL,
  `Comision_id` INT(11) NOT NULL,
  `Aula_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Horario_Comision1_idx` (`Comision_id` ASC),
  INDEX `fk_Horario_Aula1_idx` (`Aula_id` ASC),
  CONSTRAINT `fk_Horario_Aula1`
  FOREIGN KEY (`Aula_id`)
  REFERENCES `gestion_aulas`.`aula` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Horario_Cursada1`
  FOREIGN KEY (`Comision_id`)
  REFERENCES `gestion_aulas`.`comision` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `gestion_aulas`.`clase`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gestion_aulas`.`clase` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `Aula_id` INT(11) NOT NULL,
  `fecha` DATE NOT NULL,
  `hora_inicio` TIME NOT NULL,
  `hora_fin` TIME NOT NULL,
  `Horario_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Aula_has_Cursada_Aula1_idx` (`Aula_id` ASC),
  INDEX `fk_clase_horario1_idx` (`Horario_id` ASC),
  INDEX `clase_fecha_index` (`fecha` ASC),
  CONSTRAINT `fk_Aula_has_Cursada_Aula1`
  FOREIGN KEY (`Aula_id`)
  REFERENCES `gestion_aulas`.`aula` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_clase_horario1`
  FOREIGN KEY (`Horario_id`)
  REFERENCES `gestion_aulas`.`horario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `gestion_aulas`.`estado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gestion_aulas`.`estado` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC))
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `gestion_aulas`.`clase_estado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gestion_aulas`.`clase_estado` (
  `Estado_id` INT(11) NOT NULL,
  `Clase_id` INT(11) NOT NULL,
  `descripcion` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`Estado_id`, `Clase_id`),
  INDEX `fk_Estado_has_Clase_Clase1_idx` (`Clase_id` ASC),
  INDEX `fk_Estado_has_Clase_Estado1_idx` (`Estado_id` ASC),
  CONSTRAINT `fk_Estado_has_Clase_Clase1`
  FOREIGN KEY (`Clase_id`)
  REFERENCES `gestion_aulas`.`clase` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Estado_has_Clase_Estado1`
  FOREIGN KEY (`Estado_id`)
  REFERENCES `gestion_aulas`.`estado` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `gestion_aulas`.`docente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gestion_aulas`.`docente` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `gestion_aulas`.`evento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gestion_aulas`.`evento` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `Aula_id` INT(11) NOT NULL,
  `fecha` DATE NOT NULL,
  `hora_inicio` TIME NOT NULL,
  `hora_fin` TIME NOT NULL,
  `motivo` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `Aula_id` (`Aula_id` ASC),
  CONSTRAINT `evento_ibfk_1`
  FOREIGN KEY (`Aula_id`)
  REFERENCES `gestion_aulas`.`aula` (`id`))
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `gestion_aulas`.`grupo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gestion_aulas`.`grupo` (
  `id` MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(20) NOT NULL,
  `description` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB
  AUTO_INCREMENT = 4
  DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `gestion_aulas`.`login_attempts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gestion_aulas`.`login_attempts` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_address` VARCHAR(15) NOT NULL,
  `login` VARCHAR(100) NOT NULL,
  `time` INT(11) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `gestion_aulas`.`tipo_recurso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gestion_aulas`.`tipo_recurso` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `nombre` (`nombre` ASC))
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `gestion_aulas`.`recurso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gestion_aulas`.`recurso` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `Tipo_recurso_id` INT(11) NOT NULL,
  `Aula_id` INT(11) NOT NULL,
  `disponible` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `Aula_id` (`Aula_id` ASC),
  INDEX `Tipo_recurso_id` (`Tipo_recurso_id` ASC),
  CONSTRAINT `recurso_ibfk_1`
  FOREIGN KEY (`Aula_id`)
  REFERENCES `gestion_aulas`.`aula` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `recurso_ibfk_2`
  FOREIGN KEY (`Tipo_recurso_id`)
  REFERENCES `gestion_aulas`.`tipo_recurso` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `gestion_aulas`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gestion_aulas`.`usuario` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_address` VARCHAR(15) NOT NULL,
  `username` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `salt` VARCHAR(255) NULL DEFAULT NULL,
  `email` VARCHAR(100) NOT NULL,
  `activation_code` VARCHAR(40) NULL DEFAULT NULL,
  `forgotten_password_code` VARCHAR(40) NULL DEFAULT NULL,
  `forgotten_password_time` INT(11) UNSIGNED NULL DEFAULT NULL,
  `remember_code` VARCHAR(40) NULL DEFAULT NULL,
  `created_on` INT(11) UNSIGNED NOT NULL,
  `last_login` INT(11) UNSIGNED NULL DEFAULT NULL,
  `active` TINYINT(1) UNSIGNED NULL DEFAULT NULL,
  `first_name` VARCHAR(50) NULL DEFAULT NULL,
  `last_name` VARCHAR(50) NULL DEFAULT NULL,
  `company` VARCHAR(100) NULL DEFAULT NULL,
  `phone` VARCHAR(20) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `gestion_aulas`.`usuario_grupo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gestion_aulas`.`usuario_grupo` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `group_id` MEDIUMINT(8) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `uc_users_groups` (`user_id` ASC, `group_id` ASC),
  INDEX `fk_users_groups_users1_idx` (`user_id` ASC),
  INDEX `fk_users_groups_groups1_idx` (`group_id` ASC),
  CONSTRAINT `fk_users_groups_groups1`
  FOREIGN KEY (`group_id`)
  REFERENCES `gestion_aulas`.`grupo` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_groups_users1`
  FOREIGN KEY (`user_id`)
  REFERENCES `gestion_aulas`.`usuario` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
