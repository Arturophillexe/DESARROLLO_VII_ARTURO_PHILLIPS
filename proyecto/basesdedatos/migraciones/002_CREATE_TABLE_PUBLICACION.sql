CREATE TABLE publicacion (
    id int AUTO_INCREMENT PRIMARY KEY,
    usuario_id int NOT NULL,
    titulo varchar (60),
    descripcion text,
    imagen varchar(255),
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES users(id) ON DELETE CASCADE
);