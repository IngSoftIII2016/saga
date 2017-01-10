USE gestion_aulas;
-- -----------------------------------------------------
-- Table `gestion_aulas`.`ROL`
-- -----------------------------------------------------

CREATE  TABLE `gestion_aulas`.`rol` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
  engine = InnoDB;

-- -----------------------------------------------------
-- INSERT Table `gestion_aulas`.`rol`
-- -----------------------------------------------------

INSERT INTO `gestion_aulas`.`rol` (`nombre`) VALUES ('admin');
INSERT INTO `gestion_aulas`.`rol` (`nombre`) VALUES ('administracion academica');
INSERT INTO `gestion_aulas`.`rol` (`nombre`) VALUES ('bedel');
INSERT INTO `gestion_aulas`.`rol` (`nombre`) VALUES ('alumno');

-- -----------------------------------------------------
-- INSERT Table `Usuario`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `estado` tinyint(1) unsigned DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `nombre_usuario` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'$2y$08$GjNYMBqLQ5e08LQtG5R/WOpK51JYTkkQZJal3Tj9F96dxWot.QqxK','administrador',1,'administrador','saga','administrador');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

-- -----------------------------------------------------
-- COLUMN `rol` Table `gestion_aulas`.`usuario`
-- -----------------------------------------------------

ALTER TABLE `gestion_aulas`.`usuario` ADD COLUMN `rol` INT NOT NULL AFTER `nombre_usuario`;

-- -----------------------------------------------------
-- UPDATE roles a usuarios
-- -----------------------------------------------------

UPDATE `gestion_aulas`.`usuario` SET `rol`='1' WHERE `id`='1';
UPDATE `gestion_aulas`.`usuario` SET `rol`='2' WHERE `id`='24';
UPDATE `gestion_aulas`.`usuario` SET `rol`='3' WHERE `id`='25';

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
-- Table `gestion_aulas`.`accion`
-- -----------------------------------------------------

CREATE TABLE `gestion_aulas`.`accion` (
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
