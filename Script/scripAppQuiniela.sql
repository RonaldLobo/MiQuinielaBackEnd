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
	torno VARCHAR(100) NOT NULL,
   	estado CHARACTER(1) NOT NULL
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
    	estado CHARACTER(1) NOT NULL
  );

ALTER TABLE partido ADD CONSTRAINT fkIdPartidoTorneo FOREIGN KEY (fkIdPartidoTorneo) REFERENCES torneo(pkIdTorneo);
ALTER TABLE partido ADD CONSTRAINT fkIdPartidoEquipo1 FOREIGN KEY (fkIdPartidoEquipo1) REFERENCES equipo (pkIdEquipo);
ALTER TABLE partido ADD CONSTRAINT fkIdPartidoEquipo2 FOREIGN KEY (fkIdPartidoEquipo2) REFERENCES equipo (pkIdEquipo);

ALTER TABLE grupo ADD CONSTRAINT fkIdGrupoUsuario FOREIGN KEY (fkIdGrupoUsuario) REFERENCES usuario(pkIdUsuario);
ALTER TABLE grupo ADD CONSTRAINT fkIdGrupoTorneo FOREIGN KEY (fkIdGrupoTorneo) REFERENCES torneo(pkIdTorneo);



ALTER TABLE prediccion ADD CONSTRAINT fkIdPrediccionPartido FOREIGN KEY (fkIdPrediccionPartido ) REFERENCES partido(pkIdPartido);
ALTER TABLE prediccion ADD CONSTRAINT fkIdPrediccionUsuario FOREIGN KEY (fkIdPrediccionUsuario) REFERENCES usuario(pkIdUsuario);
ALTER TABLE prediccion ADD CONSTRAINT fkIdPrediccionEquipo1 FOREIGN KEY (fkIdPrediccionEquipo1) REFERENCES equipo (pkIdEquipo);
ALTER TABLE prediccion ADD CONSTRAINT fkIdPrediccionEquipo2 FOREIGN KEY (fkIdPrediccionEquipo2) REFERENCES equipo (pkIdEquipo);