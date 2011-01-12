SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `grupo01` ;
CREATE SCHEMA IF NOT EXISTS `grupo01` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `grupo01` ;

-- -----------------------------------------------------
-- Table `grupo01`.`Usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `grupo01`.`Usuario` ;

CREATE  TABLE IF NOT EXISTS `grupo01`.`Usuario` (
  `login` VARCHAR(10) NOT NULL ,
  `password` VARCHAR(10) NOT NULL ,
  `tipoUsuario` ENUM('T','R','A') NOT NULL DEFAULT 'T' ,
  PRIMARY KEY (`login`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grupo01`.`Trabajador`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `grupo01`.`Trabajador` ;

CREATE  TABLE IF NOT EXISTS `grupo01`.`Trabajador` (
  `dni` VARCHAR(9) NOT NULL ,
  `nombre` VARCHAR(20) NOT NULL ,
  `apellidos` VARCHAR(30) NOT NULL ,
  `fechaNac` DATE NULL ,
  `categoria` INT NOT NULL ,
  `Usuario_login` VARCHAR(10) NOT NULL ,
  PRIMARY KEY (`dni`) ,
  INDEX `fk_Trabajador_Usuario1` (`Usuario_login` ASC) ,
  CONSTRAINT `fk_Trabajador_Usuario1`
    FOREIGN KEY (`Usuario_login` )
    REFERENCES `grupo01`.`Usuario` (`login` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grupo01`.`Proyecto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `grupo01`.`Proyecto` ;

CREATE  TABLE IF NOT EXISTS `grupo01`.`Proyecto` (
  `idProyecto` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NOT NULL ,
  `fechaInicio` DATE NULL ,
  `fechaFin` DATE NULL ,
  `descripcion` TEXT NULL ,
  `jefeProyecto` VARCHAR(9) NOT NULL ,
  PRIMARY KEY (`idProyecto`) ,
  UNIQUE INDEX `Nombre_UNIQUE` (`nombre` ASC) ,
  INDEX `fk_Proyecto_Trabajador1` (`jefeProyecto` ASC) ,
  CONSTRAINT `fk_Proyecto_Trabajador1`
    FOREIGN KEY (`jefeProyecto` )
    REFERENCES `grupo01`.`Trabajador` (`dni` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grupo01`.`Fase`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `grupo01`.`Fase` ;

CREATE  TABLE IF NOT EXISTS `grupo01`.`Fase` (
  `idFase` INT NOT NULL AUTO_INCREMENT ,
  `Proyecto_idProyecto` INT NOT NULL ,
  `nombre` ENUM('Inicio', 'Elaboracion', 'Construccion', 'Transicion') NOT NULL ,
  `fechaInicioE` DATE NOT NULL ,
  `fechaFinE` DATE NOT NULL ,
  `fechaInicioR` DATE NULL ,
  `fechaFinR` DATE NULL ,
  PRIMARY KEY (`idFase`) ,
  INDEX `fk_Fase_Proyecto1` (`Proyecto_idProyecto` ASC) ,
  CONSTRAINT `fk_Fase_Proyecto1`
    FOREIGN KEY (`Proyecto_idProyecto` )
    REFERENCES `grupo01`.`Proyecto` (`idProyecto` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grupo01`.`Iteracion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `grupo01`.`Iteracion` ;

CREATE  TABLE IF NOT EXISTS `grupo01`.`Iteracion` (
  `idIteracion` INT NOT NULL AUTO_INCREMENT ,
  `Fase_idFase` INT NOT NULL ,
  `numero` INT NOT NULL ,
  `fechaInicio` DATE NULL ,
  `fechaFin` DATE NULL ,
  PRIMARY KEY (`idIteracion`) ,
  INDEX `fk_Iteracion_Fase1` (`Fase_idFase` ASC) ,
  CONSTRAINT `fk_Iteracion_Fase1`
    FOREIGN KEY (`Fase_idFase` )
    REFERENCES `grupo01`.`Fase` (`idFase` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grupo01`.`Rol`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `grupo01`.`Rol` ;

CREATE  TABLE IF NOT EXISTS `grupo01`.`Rol` (
  `idRol` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(35) NOT NULL ,
  `categoria` INT NOT NULL ,
  PRIMARY KEY (`idRol`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grupo01`.`Actividad`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `grupo01`.`Actividad` ;

CREATE  TABLE IF NOT EXISTS `grupo01`.`Actividad` (
  `idActividad` INT NOT NULL AUTO_INCREMENT ,
  `Iteracion_idIteracion` INT NOT NULL ,
  `nombre` VARCHAR(45) NOT NULL ,
  `duracionEstimada` INT NOT NULL ,
  `fechaInicio` DATE NULL ,
  `fechaFin` DATE NULL ,
  `Rol_idRol` INT NOT NULL ,
  PRIMARY KEY (`idActividad`) ,
  INDEX `fk_Actividad_Iteracion1` (`Iteracion_idIteracion` ASC) ,
  INDEX `fk_Actividad_Rol1` (`Rol_idRol` ASC) ,
  CONSTRAINT `fk_Actividad_Iteracion1`
    FOREIGN KEY (`Iteracion_idIteracion` )
    REFERENCES `grupo01`.`Iteracion` (`idIteracion` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Actividad_Rol1`
    FOREIGN KEY (`Rol_idRol` )
    REFERENCES `grupo01`.`Rol` (`idRol` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grupo01`.`InformeTareas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `grupo01`.`InformeTareas` ;

CREATE  TABLE IF NOT EXISTS `grupo01`.`InformeTareas` (
  `idInformeTareas` INT NOT NULL AUTO_INCREMENT ,
  `Actividad_idActividad` INT NOT NULL ,
  `Trabajador_dni` VARCHAR(9) NOT NULL ,
  `semana` DATE NOT NULL ,
  `estado` ENUM('Pendiente','Aceptado','Cancelado') NOT NULL DEFAULT 'Pendiente' ,
  PRIMARY KEY (`idInformeTareas`) ,
  INDEX `fk_Tarea_Actividad1` (`Actividad_idActividad` ASC) ,
  INDEX `fk_TareaPersonal_Trabajador1` (`Trabajador_dni` ASC) ,
  CONSTRAINT `fk_Tarea_Actividad1`
    FOREIGN KEY (`Actividad_idActividad` )
    REFERENCES `grupo01`.`Actividad` (`idActividad` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_TareaPersonal_Trabajador1`
    FOREIGN KEY (`Trabajador_dni` )
    REFERENCES `grupo01`.`Trabajador` (`dni` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grupo01`.`CatalogoTareas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `grupo01`.`CatalogoTareas` ;

CREATE  TABLE IF NOT EXISTS `grupo01`.`CatalogoTareas` (
  `idTareaCatalogo` INT NOT NULL AUTO_INCREMENT ,
  `descripcion` VARCHAR(80) NOT NULL ,
  PRIMARY KEY (`idTareaCatalogo`) ,
  UNIQUE INDEX `Descripcion_UNIQUE` (`descripcion` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grupo01`.`Configuracion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `grupo01`.`Configuracion` ;

CREATE  TABLE IF NOT EXISTS `grupo01`.`Configuracion` (
  `idConfiguracion` INT NOT NULL AUTO_INCREMENT ,
  `numMaxProyectos` INT NOT NULL ,
  `categoriaMaxima` INT NULL DEFAULT 4 ,
  PRIMARY KEY (`idConfiguracion`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grupo01`.`Vacaciones`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `grupo01`.`Vacaciones` ;

CREATE  TABLE IF NOT EXISTS `grupo01`.`Vacaciones` (
  `idVacaciones` INT NOT NULL AUTO_INCREMENT ,
  `fechaInicio` DATE NOT NULL ,
  `fechaFin` DATE NOT NULL ,
  `Trabajador_dni` VARCHAR(9) NOT NULL ,
  PRIMARY KEY (`idVacaciones`) ,
  INDEX `fk_Vacaciones_Trabajador1` (`Trabajador_dni` ASC) ,
  CONSTRAINT `fk_Vacaciones_Trabajador1`
    FOREIGN KEY (`Trabajador_dni` )
    REFERENCES `grupo01`.`Trabajador` (`dni` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grupo01`.`TrabajadorProyecto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `grupo01`.`TrabajadorProyecto` ;

CREATE  TABLE IF NOT EXISTS `grupo01`.`TrabajadorProyecto` (
  `Trabajador_dni` VARCHAR(9) NOT NULL ,
  `Proyecto_idProyecto` INT NOT NULL ,
  `porcentaje` INT NOT NULL DEFAULT 100 ,
  `Rol_idRol` INT NOT NULL ,
  INDEX `fk_TrabajadorProyecto_Trabajador1` (`Trabajador_dni` ASC) ,
  INDEX `fk_TrabajadorProyecto_Proyecto1` (`Proyecto_idProyecto` ASC) ,
  PRIMARY KEY (`Trabajador_dni`, `Proyecto_idProyecto`) ,
  INDEX `fk_TrabajadorProyecto_Rol1` (`Rol_idRol` ASC) ,
  CONSTRAINT `fk_TrabajadorProyecto_Trabajador1`
    FOREIGN KEY (`Trabajador_dni` )
    REFERENCES `grupo01`.`Trabajador` (`dni` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_TrabajadorProyecto_Proyecto1`
    FOREIGN KEY (`Proyecto_idProyecto` )
    REFERENCES `grupo01`.`Proyecto` (`idProyecto` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_TrabajadorProyecto_Rol1`
    FOREIGN KEY (`Rol_idRol` )
    REFERENCES `grupo01`.`Rol` (`idRol` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grupo01`.`TrabajadorActividad`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `grupo01`.`TrabajadorActividad` ;

CREATE  TABLE IF NOT EXISTS `grupo01`.`TrabajadorActividad` (
  `Trabajador_dni` VARCHAR(9) NOT NULL ,
  `Actividad_idActividad` INT NOT NULL ,
  PRIMARY KEY (`Trabajador_dni`, `Actividad_idActividad`) ,
  INDEX `fk_Trabajador_has_Actividad_Actividad1` (`Actividad_idActividad` ASC) ,
  INDEX `fk_Trabajador_has_Actividad_Trabajador1` (`Trabajador_dni` ASC) ,
  CONSTRAINT `fk_Trabajador_has_Actividad_Trabajador1`
    FOREIGN KEY (`Trabajador_dni` )
    REFERENCES `grupo01`.`Trabajador` (`dni` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Trabajador_has_Actividad_Actividad1`
    FOREIGN KEY (`Actividad_idActividad` )
    REFERENCES `grupo01`.`Actividad` (`idActividad` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grupo01`.`ActividadPredecesora`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `grupo01`.`ActividadPredecesora` ;

CREATE  TABLE IF NOT EXISTS `grupo01`.`ActividadPredecesora` (
  `Actividad_idActividad` INT NOT NULL ,
  `Actividad_idActividadP` INT NOT NULL ,
  PRIMARY KEY (`Actividad_idActividad`, `Actividad_idActividadP`) ,
  INDEX `fk_Actividad_has_Actividad_Actividad2` (`Actividad_idActividadP` ASC) ,
  INDEX `fk_Actividad_has_Actividad_Actividad1` (`Actividad_idActividad` ASC) ,
  CONSTRAINT `fk_Actividad_has_Actividad_Actividad1`
    FOREIGN KEY (`Actividad_idActividad` )
    REFERENCES `grupo01`.`Actividad` (`idActividad` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Actividad_has_Actividad_Actividad2`
    FOREIGN KEY (`Actividad_idActividadP` )
    REFERENCES `grupo01`.`Actividad` (`idActividad` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grupo01`.`Artefacto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `grupo01`.`Artefacto` ;

CREATE  TABLE IF NOT EXISTS `grupo01`.`Artefacto` (
  `Actividad_idActividad` INT NOT NULL ,
  `nombre` VARCHAR(45) NOT NULL ,
  `url` VARCHAR(300) NOT NULL ,
  `comentarios` TEXT NULL ,
  INDEX `fk_Artefacto_Actividad1` (`Actividad_idActividad` ASC) ,
  PRIMARY KEY (`Actividad_idActividad`) ,
  CONSTRAINT `fk_Artefacto_Actividad1`
    FOREIGN KEY (`Actividad_idActividad` )
    REFERENCES `grupo01`.`Actividad` (`idActividad` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grupo01`.`TareaPersonal`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `grupo01`.`TareaPersonal` ;

CREATE  TABLE IF NOT EXISTS `grupo01`.`TareaPersonal` (
  `idTareaPersonal` INT NOT NULL AUTO_INCREMENT ,
  `InformeTareas_idInformeTareas` INT NOT NULL ,
  `CatalogoTareas_idTareaCatalogo` INT NOT NULL ,
  `horas` INT NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`idTareaPersonal`) ,
  INDEX `fk_TareaPersonal_InformeTareas1` (`InformeTareas_idInformeTareas` ASC) ,
  INDEX `fk_TareaPersonal_CatalogoTareas1` (`CatalogoTareas_idTareaCatalogo` ASC) ,
  CONSTRAINT `fk_TareaPersonal_InformeTareas1`
    FOREIGN KEY (`InformeTareas_idInformeTareas` )
    REFERENCES `grupo01`.`InformeTareas` (`idInformeTareas` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_TareaPersonal_CatalogoTareas1`
    FOREIGN KEY (`CatalogoTareas_idTareaCatalogo` )
    REFERENCES `grupo01`.`CatalogoTareas` (`idTareaCatalogo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `grupo01`.`Usuario`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `grupo01`;
INSERT INTO `grupo01`.`Usuario` (`login`, `password`, `tipoUsuario`) VALUES ('admin', 'admin', 'A');
INSERT INTO `grupo01`.`Usuario` (`login`, `password`, `tipoUsuario`) VALUES ('personal', 'personal', 'R');
INSERT INTO `grupo01`.`Usuario` (`login`, `password`, `tipoUsuario`) VALUES ('sandra', 'sandra', 'T');
INSERT INTO `grupo01`.`Usuario` (`login`, `password`, `tipoUsuario`) VALUES ('javier', 'javier', 'T');
INSERT INTO `grupo01`.`Usuario` (`login`, `password`, `tipoUsuario`) VALUES ('patricia', 'patricia', 'T');
INSERT INTO `grupo01`.`Usuario` (`login`, `password`, `tipoUsuario`) VALUES ('mario', 'mario', 'T');
INSERT INTO `grupo01`.`Usuario` (`login`, `password`, `tipoUsuario`) VALUES ('luis', 'luis', 'T');
INSERT INTO `grupo01`.`Usuario` (`login`, `password`, `tipoUsuario`) VALUES ('lidia', 'lidia', 'T');

COMMIT;

-- -----------------------------------------------------
-- Data for table `grupo01`.`Trabajador`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `grupo01`;
INSERT INTO `grupo01`.`Trabajador` (`dni`, `nombre`, `apellidos`, `fechaNac`, `categoria`, `Usuario_login`) VALUES ('72238118S', 'Patricia', 'Cadenas Quijano', '1986-07-16', 3, 'patricia');
INSERT INTO `grupo01`.`Trabajador` (`dni`, `nombre`, `apellidos`, `fechaNac`, `categoria`, `Usuario_login`) VALUES ('72262662H', 'Javier', 'García Tomillo', '1987-12-03', 3, 'javier');
INSERT INTO `grupo01`.`Trabajador` (`dni`, `nombre`, `apellidos`, `fechaNac`, `categoria`, `Usuario_login`) VALUES ('67384907I', 'Sandra', 'López Cuadra', '1979-09-05', 1, 'sandra');
INSERT INTO `grupo01`.`Trabajador` (`dni`, `nombre`, `apellidos`, `fechaNac`, `categoria`, `Usuario_login`) VALUES ('35267909F', 'Luis', 'de la Calle Gutiérrez', '1980-02-27', 1, 'luis');
INSERT INTO `grupo01`.`Trabajador` (`dni`, `nombre`, `apellidos`, `fechaNac`, `categoria`, `Usuario_login`) VALUES ('46547668R', 'Lidia C.', 'Arribas Velasco', '1984-05-10', 2, 'lidia');

COMMIT;

-- -----------------------------------------------------
-- Data for table `grupo01`.`Proyecto`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `grupo01`;
INSERT INTO `grupo01`.`Proyecto` (`idProyecto`, `nombre`, `fechaInicio`, `fechaFin`, `descripcion`, `jefeProyecto`) VALUES (1, 'PATRAC', NULL, NULL, 'Proyecto para Patrimonio Accesible', '67384907I');
INSERT INTO `grupo01`.`Proyecto` (`idProyecto`, `nombre`, `fechaInicio`, `fechaFin`, `descripcion`, `jefeProyecto`) VALUES (2, 'SIGESTPROSO', NULL, NULL, 'Seguimiento integrado de la gestión temporal de proyectos de software ', '35267909F');

COMMIT;

-- -----------------------------------------------------
-- Data for table `grupo01`.`Rol`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `grupo01`;
INSERT INTO `grupo01`.`Rol` (`idRol`, `nombre`, `categoria`) VALUES (1, 'Jefe de proyecto', 1);
INSERT INTO `grupo01`.`Rol` (`idRol`, `nombre`, `categoria`) VALUES (2, 'Analista', 2);
INSERT INTO `grupo01`.`Rol` (`idRol`, `nombre`, `categoria`) VALUES (3, 'Diseñador', 3);
INSERT INTO `grupo01`.`Rol` (`idRol`, `nombre`, `categoria`) VALUES (4, 'Analista-programador', 3);
INSERT INTO `grupo01`.`Rol` (`idRol`, `nombre`, `categoria`) VALUES (5, 'Responsable equipo de pruebas', 3);
INSERT INTO `grupo01`.`Rol` (`idRol`, `nombre`, `categoria`) VALUES (6, 'Programador', 4);
INSERT INTO `grupo01`.`Rol` (`idRol`, `nombre`, `categoria`) VALUES (7, 'Probador', 4);

COMMIT;

-- -----------------------------------------------------
-- Data for table `grupo01`.`CatalogoTareas`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `grupo01`;
INSERT INTO `grupo01`.`CatalogoTareas` (`idTareaCatalogo`, `descripcion`) VALUES (1, 'Trato con usuarios (llamadas, citas individuales, etc.)');
INSERT INTO `grupo01`.`CatalogoTareas` (`idTareaCatalogo`, `descripcion`) VALUES (2, 'Reuniones externas');
INSERT INTO `grupo01`.`CatalogoTareas` (`idTareaCatalogo`, `descripcion`) VALUES (3, 'Reuniones internas');
INSERT INTO `grupo01`.`CatalogoTareas` (`idTareaCatalogo`, `descripcion`) VALUES (4, 'Lectura de especificaciones y todo tipo de documentación');
INSERT INTO `grupo01`.`CatalogoTareas` (`idTareaCatalogo`, `descripcion`) VALUES (5, 'Elaboración de documentación (informes, documentos, documentación de programas)');
INSERT INTO `grupo01`.`CatalogoTareas` (`idTareaCatalogo`, `descripcion`) VALUES (6, 'Desarrollo de programas');
INSERT INTO `grupo01`.`CatalogoTareas` (`idTareaCatalogo`, `descripcion`) VALUES (7, 'Revisión de informes, programas, etc.');
INSERT INTO `grupo01`.`CatalogoTareas` (`idTareaCatalogo`, `descripcion`) VALUES (8, 'Verificación de programas');
INSERT INTO `grupo01`.`CatalogoTareas` (`idTareaCatalogo`, `descripcion`) VALUES (9, 'Formación de usuarios');
INSERT INTO `grupo01`.`CatalogoTareas` (`idTareaCatalogo`, `descripcion`) VALUES (10, 'Varios (sin clasificar)');

COMMIT;
