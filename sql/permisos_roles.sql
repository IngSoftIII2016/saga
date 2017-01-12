USE gestion_aulas;

-- -----------------------------------------------------
-- DROP TABLES
-- -----------------------------------------------------

DROP TABLE IF EXISTS `gestion_aulas`.`usuario`;
DROP TABLE IF EXISTS `gestion_aulas`.`accion_rol`;
DROP TABLE IF EXISTS `gestion_aulas`.`accion`;
DROP TABLE IF EXISTS `gestion_aulas`.`rol`;

-- -----------------------------------------------------
-- INSERT Table `Usuario`
-- -----------------------------------------------------

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gestion_aulas`.`usuario` (
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

-- -----------------------------------------------------
-- COLUMN `rol` Table `gestion_aulas`.`usuario`
-- -----------------------------------------------------

ALTER TABLE `gestion_aulas`.`usuario` ADD COLUMN `rol` INT NOT NULL AFTER `nombre_usuario`;

-- -----------------------------------------------------
-- Table `gestion_aulas`.`ROL`
-- -----------------------------------------------------

CREATE TABLE `gestion_aulas`.`rol` (
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

ALTER TABLE `gestion_aulas`.`accion` ADD COLUMN `recurso` VARCHAR(45) NULL  AFTER `metodo`;

--
-- Dumping data for table `usuario`
--
INSERT INTO gestion_aulas.usuario (password, email, estado, nombre, apellido, nombre_usuario, rol)
VALUES
  ('75DUkoxVPbiygl12cOyEHcUs7secdmVZx8aGSM/KmcrEbymZmCJOZUgcac7Tawkk9wYAK/KAdLU8ZZElPHv6RA==', 'administrador', 1, 'Administrador', 'Saga', 'administrador', 1);



-- -----------------------------------------------------
-- Alta de acciones
-- -----------------------------------------------------

INSERT INTO `gestion_aulas`.`accion` (`url`, `metodo`, `recurso`) VALUES
  ('/saga/api/AuthEndpoint/login', 'POST', 'Login'),
  ('/saga/api/AuthEndpoint/reset_pass', 'POST', 'Login'),
  ('/saga/api/accionrol', 'GET', 'Permisos'),
  ('/saga/api/accionrol', 'POST', 'Permisos'),
  ('/saga/api/accionrol', 'PUT', 'Permisos'),
  ('/saga/api/accionrol', 'DELETE', 'Permisos'),
  ('/saga/api/asignaturas', 'GET', 'Asignaturas'),
  ('/saga/api/asignaturas', 'POST', 'Asignaturas'),
  ('/saga/api/asignaturas', 'PUT', 'Asignaturas'),
  ('/saga/api/asignaturas', 'DELETE', 'Asignaturas'),
  ('/saga/api/asignaturacarrera', 'GET', 'Planes de Estudio'),
  ('/saga/api/asignaturacarrera', 'POST', 'Planes de Estudio'),
  ('/saga/api/asignaturacarrera', 'PUT', 'Planes de Estudio'),
  ('/saga/api/asignaturacarrera', 'DELETE', 'Planes de Estudio'),
  ('/saga/api/aulas', 'GET', 'Aulas'),
  ('/saga/api/aulas', 'POST', 'Aulas'),
  ('/saga/api/aulas', 'PUT', 'Aulas'),
  ('/saga/api/aulas', 'DELETE', 'Aulas'),
  ('/saga/api/carreras', 'GET', 'Carreras'),
  ('/saga/api/carreras', 'POST', 'Carreras'),
  ('/saga/api/carreras', 'PUT', 'Carreras'),
  ('/saga/api/carreras', 'DELETE', 'Carreras'),
  ('/saga/api/clases', 'GET', 'Clases'),
  ('/saga/api/clases', 'POST', 'Clases'),
  ('/saga/api/clases', 'PUT', 'Clases'),
  ('/saga/api/clases', 'DELETE', 'Clases'),
  ('/saga/api/comisiones', 'GET', 'Comisiones'),
  ('/saga/api/comisiones', 'POST', 'Comisiones'),
  ('/saga/api/comisiones', 'PUT', 'Comisiones'),
  ('/saga/api/comisiones', 'DELETE', 'Comisiones'),
  ('/saga/api/docentes', 'GET', 'Docentes'),
  ('/saga/api/docentes', 'POST', 'Docentes'),
  ('/saga/api/docentes', 'PUT', 'Docentes'),
  ('/saga/api/docentes', 'DELETE', 'Docentes'),
  ('/saga/api/edificios', 'GET', 'Edificios'),
  ('/saga/api/edificios', 'POST', 'Edificios'),
  ('/saga/api/edificios', 'PUT', 'Edificios'),
  ('/saga/api/edificios', 'DELETE', 'Edificios'),
  ('/saga/api/eventos', 'GET', 'Eventos'),
  ('/saga/api/eventos', 'POST', 'Eventos'),
  ('/saga/api/eventos', 'PUT', 'Eventos'),
  ('/saga/api/eventos', 'DELETE', 'Eventos'),
  ('/saga/api/horarios', 'GET', 'Horarios'),
  ('/saga/api/horarios', 'POST', 'Horarios'),
  ('/saga/api/horarios', 'PUT', 'Horarios'),
  ('/saga/api/horarios', 'DELETE', 'Horarios'),
  ('/saga/api/localidades', 'GET', 'Localidades'),
  ('/saga/api/localidades', 'POST', 'Localidades'),
  ('/saga/api/localidades', 'PUT', 'Localidades'),
  ('/saga/api/localidades', 'DELETE', 'Localidades'),
  ('/saga/api/periodos', 'GET', 'Periodos'),
  ('/saga/api/periodos', 'POST', 'Periodos'),
  ('/saga/api/periodos', 'PUT', 'Periodos'),
  ('/saga/api/periodos', 'DELETE', 'Periodos'),
  ('/saga/api/recursos', 'GET', 'Recursos'),
  ('/saga/api/recursos', 'POST', 'Recursos'),
  ('/saga/api/recursos', 'PUT', 'Recursos'),
  ('/saga/api/recursos', 'DELETE', 'Recursos'),
  ('/saga/api/roles', 'GET', 'Roles'),
  ('/saga/api/roles', 'POST', 'Roles'),
  ('/saga/api/roles', 'PUT', 'Roles'),
  ('/saga/api/roles', 'DELETE', 'Roles'),
  ('/saga/api/sedes', 'GET', 'Sedes'),
  ('/saga/api/sedes', 'POST', 'Sedes'),
  ('/saga/api/sedes', 'PUT', 'Sedes'),
  ('/saga/api/sedes', 'DELETE', 'Sedes'),
  ('/saga/api/tiporecursos', 'GET', 'Tipos de Recursos'),
  ('/saga/api/tiporecursos', 'POST', 'Tipos de Recursos'),
  ('/saga/api/tiporecursos', 'PUT', 'Tipos de Recursos'),
  ('/saga/api/tiporecursos', 'DELETE', 'Tipos de Recursos'),
  ('/saga/api/usuarios', 'GET', 'Usuarios'),
  ('/saga/api/usuarios', 'POST', 'Usuarios'),
  ('/saga/api/usuarios', 'PUT', 'Usuarios'),
  ('/saga/api/usuarios', 'DELETE', 'Usuarios');

-- ----------------------------------------------------------
-- Permisos de prueba
-- ----------------------------------------------------------

INSERT INTO gestion_aulas.accion_rol (Accion_id, Rol_id)
VALUES (71, 1), (72, 1), (73, 1), (74, 1);