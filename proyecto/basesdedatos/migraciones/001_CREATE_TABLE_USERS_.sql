CREATE TABLE USERS(
    id int AUTO_INCREMENT PRIMARY KEY,
    username varchar(40) NOT NULL,
    edad int (2),
    foto_perfil varchar (255),
    contraseña varchar(255),
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
);