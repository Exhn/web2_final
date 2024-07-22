create database supermercado;
use supermercado;

create table productos (
idProducto int auto_increment primary key,
nombre varchar(30),
descripcion varchar(70),
precio float);

create table tipoUsuario (
rol tinyint primary key,
descripcion varchar(30)
);

create table usuarios (
idUsuario int auto_increment primary key,
usuario varchar(30),
pass varchar(30),
rol tinyint,
foreign key(rol) references tipoUsuario(rol),
unique(usuario)
);
 
insert into tipousuario values 
(1, "Admin"),
(2, "Empleado");

insert into usuarios (usuario, pass, rol) values
("luli123", "luli123", 1),
("saga123", "saga123", 2);

insert into productos (nombre, descripcion, precio) values
("Pepsi", "Gaseosa", 1800.0),
("Coca-cola", "Gaseosa", 2200.0),
("Rex", "Snack salado", 1750.50),
("Lays", "Papas fritas 180G", 2500.50);

select * from productos;