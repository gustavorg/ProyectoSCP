DROP DATABASE IF EXISTS bdsistemas;

CREATE DATABASE bdsistemas;

USE bdsistemas;

create table usuario(
CodigoUsuario char(5) not null primary key,
Password varchar(20) not null,
Nombre varchar(40) not null
) engine INNODB;

create table cliente(
CodigoCliente char(5) not null primary key,
Nombre varchar(40) not null,
NivelInt varchar(20) not null,
Contacto varchar(20) not null,
Rubro varchar(20) not null,
Motivo varchar(20) not null,
fechaRegistro date,
CodigoNegocio char(5) not null
) engine INNODB;

create table negociacion(
CodigoNegocio char(5) not null primary key,
Nombre varchar(30) not null
) engine INNODB;

create table usuarioCliente(
CodigoUsuario char(5),
CodigoCliente char(5)
);

create table actividad(
CodigoActividad char(5) not null primary key,
NivelInt varchar(20) not null,
Contacto varchar(20) not null,
Motivo varchar(20) not null,
fechaRegistro date,
CodigoCliente char(5) not null
) engine INNODB;



INSERT INTO usuario VALUES("C0001", "123456", "Jaime Romero");
INSERT INTO usuario VALUES("C0002", "123456", "Omar Crispin");

INSERT INTO cliente VALUES("D0001", "Claro", "Muy Interesado", "Celular", "Industrias", "Comercial", "2013-05-03", "N0001");
INSERT INTO cliente VALUES("D0002", "Movistar", "Regular", "Fono fijo", "Industrias", "Prensa","2013-05-29", "N0002");
INSERT INTO cliente VALUES("D0003", "ViewSonic", "Regular", "Personal", "Industrias", "Comercial", "2014-05-28", "N0003");
INSERT INTO cliente VALUES("D0004", "Blitz", "Muy Interesado", "Whatsapp", "Industrias", "Prensa", "2015-05-29", "N0004");
INSERT INTO cliente VALUES("D0005", "Bitel", "Regular", "Fono fijo", "Industrias", "Comercial","2016-01-09", "N0002");
INSERT INTO cliente VALUES("D0006", "Donofrio", "Muy Interesado", "Personal", "Alimentos", "Prensa", "2016-02-22", "N0005");
INSERT INTO cliente VALUES("D0007", "Ajinomoto", "Muy Interesado", "Personal", "Alimentos", "Prensa", "2016-03-30", "N0003");
INSERT INTO cliente VALUES("D0008", "Backus", "Regular", "Correo", "Alimentos", "Prensa", "2013-09-29", "N0002");
INSERT INTO cliente VALUES("D0009", "Nike", "Regular", "Fono fijo", "Deportes", "Comercial", "2014-12-12", "N0001");
INSERT INTO cliente VALUES("D0010", "Adidas", "Regular", "Fono fijo", "Deportes", "Comercial", "2015-11-29", "N0005");

INSERT INTO negociacion VALUES("N0001", "TV Empresa");
INSERT INTO negociacion VALUES("N0002", "Activaciones BTL");
INSERT INTO negociacion VALUES("N0003", "Realizacion de video");
INSERT INTO negociacion VALUES("N0004", "Merchandising");
INSERT INTO negociacion VALUES("N0005", "Otros");

INSERT INTO usuarioCliente VALUES("C0001", "D0001");
INSERT INTO usuarioCliente VALUES("C0001", "D0002");
INSERT INTO usuarioCliente VALUES("C0001", "D0005");
INSERT INTO usuarioCliente VALUES("C0001", "D0006");
INSERT INTO usuarioCliente VALUES("C0001", "D0009");
INSERT INTO usuarioCliente VALUES("C0001", "D0010");
INSERT INTO usuarioCliente VALUES("C0002", "D0003");
INSERT INTO usuarioCliente VALUES("C0002", "D0004");
INSERT INTO usuarioCliente VALUES("C0002", "D0007");
INSERT INTO usuarioCliente VALUES("C0002", "D0008");


INSERT INTO actividad VALUES("A0001", "Muy Interesado", "Celular", "Industrias", "2013-05-03", "D0001");
INSERT INTO actividad VALUES("A0002", "Regular", "Fono fijo", "Industrias", "2013-05-29", "D0002");
INSERT INTO actividad VALUES("A0003", "Regular", "Personal", "Industrias", "2014-05-28", "D0001");
INSERT INTO actividad VALUES("A0004", "Muy Interesado", "Whatsapp", "Industrias", "2015-05-29", "D0004");
INSERT INTO actividad VALUES("A0005", "Regular", "Fono fijo", "Industrias", "2016-01-09", "D0002");
INSERT INTO actividad VALUES("A0006", "Muy Interesado", "Personal", "Alimentos", "2016-02-22", "D0005");
INSERT INTO actividad VALUES("A0007", "Muy Interesado", "Personal", "Alimentos", "2016-03-30", "D0003");
INSERT INTO actividad VALUES("A0008", "Regular", "Correo", "Alimentos", "2013-09-29", "D0002");
INSERT INTO actividad VALUES("A0009", "Regular", "Fono fijo", "Deportes", "2014-12-12", "D0001");
INSERT INTO actividad VALUES("A0010", "Regular", "Fono fijo", "Deportes", "2015-11-29", "D0005");

ALTER TABLE usuarioCliente ADD FOREIGN KEY(CodigoUsuario) REFERENCES usuario(CodigoUsuario);
ALTER TABLE usuarioCliente ADD FOREIGN KEY(CodigoCliente) REFERENCES cliente(CodigoCliente);
ALTER TABLE cliente ADD FOREIGN KEY(CodigoNegocio) REFERENCES negociacion(CodigoNegocio);
ALTER TABLE actividad ADD FOREIGN KEY(CodigoCliente) REFERENCES cliente(CodigoCliente);
