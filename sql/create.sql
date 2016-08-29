SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `UNRN_2935` ;
CREATE SCHEMA IF NOT EXISTS `UNRN_2935` DEFAULT CHARACTER SET latin1 ;
USE `UNRN_2935` ;

-- -----------------------------------------------------
-- Table `UNRN_2935`.`sede`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `UNRN_2935`.`sede` ;

CREATE TABLE IF NOT EXISTS `UNRN_2935`.`sede` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `UNRN_2935`.`localidad`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `UNRN_2935`.`localidad` ;

CREATE TABLE IF NOT EXISTS `UNRN_2935`.`localidad` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `Sede_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC),
  INDEX `fk_Localidad_Sede1_idx` (`Sede_id` ASC),
  CONSTRAINT `fk_Localidad_Sede1`
    FOREIGN KEY (`Sede_id`)
    REFERENCES `UNRN_2935`.`sede` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `UNRN_2935`.`edificio`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `UNRN_2935`.`edificio` ;

CREATE TABLE IF NOT EXISTS `UNRN_2935`.`edificio` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `Localidad_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC),
  INDEX `fk_Edificio_Localidad1_idx` (`Localidad_id` ASC),
  CONSTRAINT `fk_Edificio_Localidad1`
    FOREIGN KEY (`Localidad_id`)
    REFERENCES `UNRN_2935`.`localidad` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `UNRN_2935`.`aula`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `UNRN_2935`.`aula` ;

CREATE TABLE IF NOT EXISTS `UNRN_2935`.`aula` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(200) NOT NULL,
  `capacidad` INT(11) NULL DEFAULT NULL,
  `Edificio_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Aula_Edificio1_idx` (`Edificio_id` ASC),
  CONSTRAINT `fk_Aula_Edificio1`
    FOREIGN KEY (`Edificio_id`)
    REFERENCES `UNRN_2935`.`edificio` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `UNRN_2935`.`carrera`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `UNRN_2935`.`carrera` ;

CREATE TABLE IF NOT EXISTS `UNRN_2935`.`carrera` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `UNRN_2935`.`periodo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `UNRN_2935`.`periodo` ;

CREATE TABLE IF NOT EXISTS `UNRN_2935`.`periodo` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `fecha_inicio` DATE NOT NULL,
  `fecha_fin` DATE NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `UNRN_2935`.`materia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `UNRN_2935`.`materia` ;

CREATE TABLE IF NOT EXISTS `UNRN_2935`.`materia` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `anio` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `UNRN_2935`.`cursada`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `UNRN_2935`.`cursada` ;

CREATE TABLE IF NOT EXISTS `UNRN_2935`.`cursada` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `Periodo_id` INT(11) NOT NULL,
  `Materia_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Cursada_Periodo1_idx` (`Periodo_id` ASC),
  INDEX `fk_Cursada_Materia1_idx` (`Materia_id` ASC),
  CONSTRAINT `fk_Cursada_Periodo1`
    FOREIGN KEY (`Periodo_id`)
    REFERENCES `UNRN_2935`.`periodo` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cursada_Materia1`
    FOREIGN KEY (`Materia_id`)
    REFERENCES `UNRN_2935`.`materia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `UNRN_2935`.`horario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `UNRN_2935`.`horario` ;

CREATE TABLE IF NOT EXISTS `UNRN_2935`.`horario` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `frecuencia_semanas` INT(11) NOT NULL DEFAULT 1,
  `dia` INT(11) NOT NULL,
  `hora_inicio` TIME NOT NULL,
  `duracion` TIME NOT NULL,
  `Cursada_id` INT(11) NOT NULL,
  `Aula_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Horario_Cursada1_idx` (`Cursada_id` ASC),
  INDEX `fk_Horario_Aula1_idx` (`Aula_id` ASC),
  CONSTRAINT `fk_Horario_Cursada1`
    FOREIGN KEY (`Cursada_id`)
    REFERENCES `UNRN_2935`.`cursada` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Horario_Aula1`
    FOREIGN KEY (`Aula_id`)
    REFERENCES `UNRN_2935`.`aula` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `UNRN_2935`.`clase`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `UNRN_2935`.`clase` ;

CREATE TABLE IF NOT EXISTS `UNRN_2935`.`clase` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `Aula_id` INT(11) NOT NULL,
  `fecha` DATE NOT NULL,
  `hora_inicio` TIME NOT NULL,
  `hora_fin` TIME NOT NULL,
  `Horario_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Aula_has_Cursada_Aula1_idx` (`Aula_id` ASC),
  INDEX `fk_clase_horario1_idx` (`Horario_id` ASC),
  CONSTRAINT `fk_Aula_has_Cursada_Aula1`
    FOREIGN KEY (`Aula_id`)
    REFERENCES `UNRN_2935`.`aula` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_clase_horario1`
    FOREIGN KEY (`Horario_id`)
    REFERENCES `UNRN_2935`.`horario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `UNRN_2935`.`estado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `UNRN_2935`.`estado` ;

CREATE TABLE IF NOT EXISTS `UNRN_2935`.`estado` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `UNRN_2935`.`clase_estado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `UNRN_2935`.`clase_estado` ;

CREATE TABLE IF NOT EXISTS `UNRN_2935`.`clase_estado` (
  `Estado_id` INT(11) NOT NULL,
  `Clase_id` INT(11) NOT NULL,
  `descripcion` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`Estado_id`, `Clase_id`),
  INDEX `fk_Estado_has_Clase_Clase1_idx` (`Clase_id` ASC),
  INDEX `fk_Estado_has_Clase_Estado1_idx` (`Estado_id` ASC),
  CONSTRAINT `fk_Estado_has_Clase_Estado1`
    FOREIGN KEY (`Estado_id`)
    REFERENCES `UNRN_2935`.`estado` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Estado_has_Clase_Clase1`
    FOREIGN KEY (`Clase_id`)
    REFERENCES `UNRN_2935`.`clase` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `UNRN_2935`.`docente`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `UNRN_2935`.`docente` ;

CREATE TABLE IF NOT EXISTS `UNRN_2935`.`docente` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `UNRN_2935`.`cursada_docente`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `UNRN_2935`.`cursada_docente` ;

CREATE TABLE IF NOT EXISTS `UNRN_2935`.`cursada_docente` (
  `Cursada_id` INT(11) NOT NULL,
  `Docente_id` INT(11) NOT NULL,
  PRIMARY KEY (`Cursada_id`, `Docente_id`),
  INDEX `fk_cursada_has_docente_docente1_idx` (`Docente_id` ASC),
  INDEX `fk_cursada_has_docente_cursada1_idx` (`Cursada_id` ASC),
  CONSTRAINT `fk_cursada_has_docente_cursada1`
    FOREIGN KEY (`Cursada_id`)
    REFERENCES `UNRN_2935`.`cursada` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cursada_has_docente_docente1`
    FOREIGN KEY (`Docente_id`)
    REFERENCES `UNRN_2935`.`docente` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `UNRN_2935`.`materia_carrera`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `UNRN_2935`.`materia_carrera` ;

CREATE TABLE IF NOT EXISTS `UNRN_2935`.`materia_carrera` (
  `Materia_id` INT(11) NOT NULL,
  `Carrera_id` INT(11) NOT NULL,
  PRIMARY KEY (`Materia_id`, `Carrera_id`),
  INDEX `fk_materia_has_carrera_carrera1_idx` (`Carrera_id` ASC),
  INDEX `fk_materia_has_carrera_materia1_idx` (`Materia_id` ASC),
  CONSTRAINT `fk_materia_has_carrera_materia1`
    FOREIGN KEY (`Materia_id`)
    REFERENCES `UNRN_2935`.`materia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_materia_has_carrera_carrera1`
    FOREIGN KEY (`Carrera_id`)
    REFERENCES `UNRN_2935`.`carrera` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
