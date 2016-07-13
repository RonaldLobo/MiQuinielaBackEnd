CREATE DATABASE appquiniela_1;

USE appquiniela_1;

CREATE TABLE usuario(
	pkIdUsuario int AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(50) NOT NULL,
	apellido1 VARCHAR(40),
	correo VARCHAR(50),
	usuario VARCHAR(30) NOT NULL,
	tipo VARCHAR(30) NOT NULL,
	contrasenna VARCHAR(40) NOT NULL,
        rol VARCHAR(30) NOT NULL,
	UNIQUE (usuario)
);


CREATE TABLE equipo(
	pkIdEquipo int AUTO_INCREMENT PRIMARY KEY,
	equipo VARCHAR(100) NOT NULL,
        estado CHARACTER(1) NOT NULL
);


CREATE TABLE torneo(
	pkIdTorneo int AUTO_INCREMENT PRIMARY KEY,
	torneo VARCHAR(100) NOT NULL,
   	estado CHARACTER(1) NOT NULL
);

CREATE TABLE usuarioTorneo(
	pkIdUsuarioTorneo int AUTO_INCREMENT PRIMARY KEY,
	fkIdUsuario int NOT NULL,
   	fkIdTorneo int NOT NULL
);

CREATE TABLE usuarioGrupo(
	pkIdUsuarioGrupo int AUTO_INCREMENT PRIMARY KEY,
	fkIdUsuarioGrupo int NOT NULL,
   	fkIdGrupo int NOT NULL,
        estado VARCHAR(20) NOT NULL
);

CREATE TABLE partido(
	pkIdPartido int AUTO_INCREMENT PRIMARY KEY,
	fkIdPartidoTorneo int NOT NULL,
	fkIdPartidoEquipo1 int NOT NULL,
	fkIdPartidoEquipo2 int NOT NULL,
	marcadorEquipo1 int NOT NULL,
        marcadorEquipo2 int NOT NULL,
        fecha DATETIME 
);


CREATE TABLE prediccion(
	pkIdPrediccion int AUTO_INCREMENT PRIMARY KEY,
	fkIdPrediccionPartido int NOT NULL,
	fkIdPrediccionUsuario int NOT NULL,
        fkIdPrediccionEquipo1 int NOT NULL,
	fkIdPrediccionEquipo2 int NOT NULL,
	marcadorEquipo1 int NOT NULL,
        marcadorEquipo2 int NOT NULL,
        puntaje int 
);


CREATE TABLE grupo(
	pkIdGrupo int AUTO_INCREMENT PRIMARY KEY,
	fkIdGrupoTorneo int NOT NULL,
	fkIdGrupoUsuario int NOT NULL,
    	estado CHARACTER(1) NOT NULL,
        nombre VARCHAR(50) NOT NULL
  );

ALTER TABLE partido ADD CONSTRAINT fkIdPartidoTorneo FOREIGN KEY (fkIdPartidoTorneo) REFERENCES torneo(pkIdTorneo);
ALTER TABLE partido ADD CONSTRAINT fkIdPartidoEquipo1 FOREIGN KEY (fkIdPartidoEquipo1) REFERENCES equipo (pkIdEquipo);
ALTER TABLE partido ADD CONSTRAINT fkIdPartidoEquipo2 FOREIGN KEY (fkIdPartidoEquipo2) REFERENCES equipo (pkIdEquipo);

ALTER TABLE grupo ADD CONSTRAINT fkIdGrupoUsuario FOREIGN KEY (fkIdGrupoUsuario) REFERENCES usuario(pkIdUsuario);
ALTER TABLE grupo ADD CONSTRAINT fkIdGrupoTorneo FOREIGN KEY (fkIdGrupoTorneo) REFERENCES torneo(pkIdTorneo);

ALTER TABLE usuarioTorneo ADD CONSTRAINT fkIdUsuario FOREIGN KEY(fkIdUsuario) REFERENCES usuario(pkIdUsuario);
ALTER TABLE usuarioTorneo ADD CONSTRAINT fkIdTorneo FOREIGN KEY(fkIdTorneo) REFERENCES torneo(pkIdTorneo);

ALTER TABLE usuarioGrupo ADD CONSTRAINT fkIdUsuarioGrupo FOREIGN KEY(fkIdUsuarioGrupo) REFERENCES usuario(pkIdUsuario);
ALTER TABLE usuarioGrupo ADD CONSTRAINT fkIdGrupo FOREIGN KEY(fkIdGrupo) REFERENCES grupo(pkIdGrupo);

ALTER TABLE prediccion ADD CONSTRAINT fkIdPrediccionPartido FOREIGN KEY (fkIdPrediccionPartido ) REFERENCES partido(pkIdPartido);
ALTER TABLE prediccion ADD CONSTRAINT fkIdPrediccionUsuario FOREIGN KEY (fkIdPrediccionUsuario) REFERENCES usuario(pkIdUsuario);
ALTER TABLE prediccion ADD CONSTRAINT fkIdPrediccionEquipo1 FOREIGN KEY (fkIdPrediccionEquipo1) REFERENCES equipo (pkIdEquipo);
ALTER TABLE prediccion ADD CONSTRAINT fkIdPrediccionEquipo2 FOREIGN KEY (fkIdPrediccionEquipo2) REFERENCES equipo (pkIdEquipo);


INSERT INTO `appquiniela_1`.`usuario` (`pkIdUsuario`, `nombre`, `apellido1`, `correo`, `usuario`, `tipo`, `contrasenna`, `rol`) VALUES (NULL, 'admin', 'apellido', 'correo@correo.com', 'admin', 'normal', 'admin', 'admin');
INSERT INTO `appquiniela_1`.`usuario` (`pkIdUsuario`, `nombre`, `apellido1`, `correo`, `usuario`, `tipo`, `contrasenna`, `rol`) VALUES (NULL, 'usuario', 'apellido', 'correoUsuario@correo.com', 'usuario', 'normal', 'usuario', 'usuario');

INSERT INTO `appquiniela_1`.`equipo` (`pkIdEquipo`, `equipo`, `estado`) VALUES (NULL, 'LDA', '1'), (NULL, 'La S', '1');

INSERT INTO `appquiniela_1`.`torneo` (`pkIdTorneo`, `torneo`, `estado`) VALUES (NULL, 'Campeonato CR', '1');

INSERT INTO `appquiniela_1`.`partido` (`pkIdPartido`, `fkIdPartidoTorneo`, `fkIdPartidoEquipo1`, `fkIdPartidoEquipo2`, `marcadorEquipo1`, `marcadorEquipo2`, `fecha`) VALUES (NULL, '1', '1', '2', '2', '2', '2016-07-19 00:00:00');
INSERT INTO `appquiniela_1`.`partido` (`pkIdPartido`, `fkIdPartidoTorneo`, `fkIdPartidoEquipo1`, `fkIdPartidoEquipo2`, `marcadorEquipo1`, `marcadorEquipo2`, `fecha`) VALUES (NULL, '1', '1', '2', '2', '2', '2016-07-21 00:00:00');
INSERT INTO `appquiniela_1`.`partido` (`pkIdPartido`, `fkIdPartidoTorneo`, `fkIdPartidoEquipo1`, `fkIdPartidoEquipo2`, `marcadorEquipo1`, `marcadorEquipo2`, `fecha`) VALUES (NULL, '1', '1', '2', '2', '2', '2016-07-23 00:00:00');

INSERT INTO `appquiniela_1`.`prediccion` (`pkIdPrediccion`, `fkIdPrediccionPartido`, `fkIdPrediccionUsuario`, `fkIdPrediccionEquipo1`, `fkIdPrediccionEquipo2`, `marcadorEquipo1`, `marcadorEquipo2`, `puntaje`) VALUES (NULL, '1', '1', '1', '2', '2', '1', NULL), (NULL, '1', '1', '1', '2', '2', '1', '0');

INSERT INTO `appquiniela_1`.`usuarioTorneo` (`pkIdUsuarioTorneo`, `fkIdUsuario`, `fkIdTorneo`) VALUES (NULL, '1', '1'), (NULL, '2', '1');

INSERT INTO `appquiniela_1`.`grupo` (`pkIdGrupo`, `fkIdGrupoTorneo`, `fkIdGrupoUsuario`, `estado`, `nombre`) VALUES (NULL, '1', '1', '1', 'Amigos');

INSERT INTO `appquiniela_1`.`grupo` (`pkIdGrupo`, `fkIdGrupoTorneo`, `fkIdGrupoUsuario`, `estado`, `nombre`) VALUES (NULL, '1', '1', '1', 'Compas');

INSERT INTO `appquiniela_1`.`usuarioGrupo` (`pkIdUsuarioGrupo`, `fkIdUsuarioGrupo`, `fkIdGrupo`, `estado`) VALUES (NULL, '1', '1', 'invitado');

INSERT INTO `appquiniela_1`.`usuarioGrupo` (`pkIdUsuarioGrupo`, `fkIdUsuarioGrupo`, `fkIdGrupo`, `estado`) VALUES (NULL, '2', '1', 'miembro');

INSERT INTO `appquiniela_1`.`usuarioGrupo` (`pkIdUsuarioGrupo`, `fkIdUsuarioGrupo`, `fkIdGrupo`, `estado`) VALUES (NULL, '1', '2', 'invitado');