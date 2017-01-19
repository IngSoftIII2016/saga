-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema saga
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema saga
-- -----------------------------------------------------
DROP SCHEMA `saga`;
CREATE SCHEMA `saga` DEFAULT CHARACTER SET utf8 ;
USE `saga` ;

-- -----------------------------------------------------
-- Table `accion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `accion` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `url` VARCHAR(100) NULL DEFAULT NULL,
  `metodo` VARCHAR(45) NULL DEFAULT NULL,
  `recurso` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `unique_url_metodo` (`url` ASC, `metodo` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `rol`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `rol` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `unique_nombre` (`nombre` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `accion_rol`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `accion_rol` (
  `Accion_id` INT(11) UNSIGNED NOT NULL,
  `Rol_id` INT(11) UNSIGNED NOT NULL,
  INDEX `fk_accion_has_rol_accion1_idx` (`Accion_id` ASC),
  INDEX `fk_accion_has_rol_rol1_idx` (`Rol_id` ASC),
  PRIMARY KEY (`Accion_id`, `Rol_id`),
  CONSTRAINT `fk_accion_has_rol_accion1`
    FOREIGN KEY (`Accion_id`)
    REFERENCES `accion` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_accion_has_rol_rol1`
    FOREIGN KEY (`Rol_id`)
    REFERENCES `rol` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `asignatura`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `asignatura` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(140) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `carrera`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `carrera` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `nombre` (`nombre` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `asignatura_carrera`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `asignatura_carrera` (
  `Asignatura_id` INT(11) UNSIGNED NOT NULL,
  `Carrera_id` INT(11) UNSIGNED NOT NULL,
  `anio` INT(11) NOT NULL,
  `regimen` ENUM('C', '1C', '2C', 'Anual') NOT NULL DEFAULT 'C',
  PRIMARY KEY (`Asignatura_id`, `Carrera_id`),
  INDEX `fk_asignatura_has_carrera_carrera1_idx` (`Carrera_id` ASC),
  INDEX `fk_asignatura_has_carrera_asignatura1_idx` (`Asignatura_id` ASC),
  CONSTRAINT `fk_asignatura_has_carrera_asignatura1`
    FOREIGN KEY (`Asignatura_id`)
    REFERENCES `asignatura` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_asignatura_has_carrera_carrera1`
    FOREIGN KEY (`Carrera_id`)
    REFERENCES `carrera` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sede`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sede` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `unique_nombre` (`nombre` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `localidad`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `localidad` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `Sede_id` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `unique_nombre` (`nombre` ASC),
  INDEX `fk_Localidad_Sede1_idx` (`Sede_id` ASC),
  CONSTRAINT `fk_Localidad_Sede1`
    FOREIGN KEY (`Sede_id`)
    REFERENCES `sede` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `edificio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `edificio` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `Localidad_id` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `nombre` (`nombre` ASC),
  INDEX `fk_Edificio_Localidad1_idx` (`Localidad_id` ASC),
  CONSTRAINT `fk_Edificio_Localidad1`
    FOREIGN KEY (`Localidad_id`)
    REFERENCES `localidad` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `aula`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `aula` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(200) NOT NULL,
  `ubicacion` INT(11) NOT NULL,
  `capacidad` INT(11) NULL DEFAULT NULL,
  `Edificio_id` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Aula_Edificio1_idx` (`Edificio_id` ASC),
  UNIQUE INDEX `unique_edificio_nombre` (`Edificio_id` ASC, `nombre` ASC),
  UNIQUE INDEX `unique_edificio_ubicacion` (`Edificio_id` ASC, `ubicacion` ASC),
  CONSTRAINT `fk_Aula_Edificio1`
    FOREIGN KEY (`Edificio_id`)
    REFERENCES `edificio` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `docente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `docente` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `unique_apellido_nombre` (`apellido` ASC, `nombre` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `periodo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `periodo` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fecha_inicio` DATE NOT NULL,
  `fecha_fin` DATE NOT NULL,
  `descripcion` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `comision`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `comision` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `Periodo_id` INT(11) UNSIGNED NOT NULL,
  `Docente_id` INT(11) UNSIGNED NULL DEFAULT NULL,
  `Asignatura_id` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Cursada_Periodo1_idx` (`Periodo_id` ASC),
  INDEX `fk_Cursada_Asignatura1_idx` (`Asignatura_id` ASC),
  INDEX `fk_Cursada_Docente1_idx` (`Docente_id` ASC),
  UNIQUE INDEX `unique_periodo_asignatura_nombre` (`Periodo_id` ASC, `Asignatura_id` ASC, `nombre` ASC),
  CONSTRAINT `fk_Comision_Docente1`
    FOREIGN KEY (`Docente_id`)
    REFERENCES `docente` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cursada_Asignatura1`
    FOREIGN KEY (`Asignatura_id`)
    REFERENCES `asignatura` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cursada_Periodo1`
    FOREIGN KEY (`Periodo_id`)
    REFERENCES `periodo` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `horario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `horario` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(45) NULL DEFAULT NULL,
  `frecuencia_semanas` INT(11) NOT NULL DEFAULT '1',
  `dia` INT(11) UNSIGNED NOT NULL,
  `hora_inicio` TIME NOT NULL,
  `duracion` TIME NOT NULL,
  `Comision_id` INT(11) UNSIGNED NOT NULL,
  `Aula_id` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Horario_Comision1_idx` (`Comision_id` ASC),
  INDEX `fk_Horario_Aula1_idx` (`Aula_id` ASC),
  INDEX `index_dia` (`dia` ASC),
  INDEX `index_hora_inicio` (`hora_inicio` ASC),
  CONSTRAINT `fk_Horario_Aula1`
    FOREIGN KEY (`Aula_id`)
    REFERENCES `aula` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Horario_Cursada1`
    FOREIGN KEY (`Comision_id`)
    REFERENCES `comision` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `clase`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clase` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Aula_id` INT(11) UNSIGNED NOT NULL,
  `fecha` DATE NOT NULL,
  `hora_inicio` TIME NOT NULL,
  `hora_fin` TIME NOT NULL,
  `Horario_id` INT(11) UNSIGNED NOT NULL,
  `comentario` VARCHAR(300) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Aula_has_Cursada_Aula1_idx` (`Aula_id` ASC),
  INDEX `fk_clase_horario1_idx` (`Horario_id` ASC),
  INDEX `clase_fecha_index` (`fecha` ASC),
  CONSTRAINT `fk_Aula_has_Cursada_Aula1`
    FOREIGN KEY (`Aula_id`)
    REFERENCES `aula` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_clase_horario1`
    FOREIGN KEY (`Horario_id`)
    REFERENCES `horario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `evento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `evento` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Aula_id` INT(11) UNSIGNED NOT NULL,
  `fecha` DATE NOT NULL,
  `hora_inicio` TIME NOT NULL,
  `hora_fin` TIME NOT NULL,
  `motivo` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `Aula_id` (`Aula_id` ASC),
  CONSTRAINT `evento_ibfk_1`
    FOREIGN KEY (`Aula_id`)
    REFERENCES `aula` (`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `tipo_recurso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tipo_recurso` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `unique_nombre` (`nombre` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `recurso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `recurso` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Tipo_recurso_id` INT(11) UNSIGNED NOT NULL,
  `Aula_id` INT(11) UNSIGNED NOT NULL,
  `disponible` TINYINT(1) UNSIGNED NOT NULL,
  `detalles` VARCHAR(140) NULL,
  PRIMARY KEY (`id`),
  INDEX `Aula_id` (`Aula_id` ASC),
  INDEX `Tipo_recurso_id` (`Tipo_recurso_id` ASC),
  CONSTRAINT `recurso_ibfk_1`
    FOREIGN KEY (`Aula_id`)
    REFERENCES `aula` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `recurso_ibfk_2`
    FOREIGN KEY (`Tipo_recurso_id`)
    REFERENCES `tipo_recurso` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` INT(11) UNSIGNED NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `estado` TINYINT(1) UNSIGNED NULL DEFAULT NULL,
  `nombre` VARCHAR(50) NULL DEFAULT NULL,
  `apellido` VARCHAR(50) NULL DEFAULT NULL,
  `Rol_id` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_usuario_rol_idx` (`Rol_id` ASC),
  UNIQUE INDEX `unique_email` (`email` ASC),
  CONSTRAINT `fk_usuario_rol`
    FOREIGN KEY (`Rol_id`)
    REFERENCES `rol` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
