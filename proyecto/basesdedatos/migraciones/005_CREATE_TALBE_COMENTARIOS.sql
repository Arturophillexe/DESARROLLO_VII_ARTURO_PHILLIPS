CREATE TABLE comentarios (
    id int AUTO_INCREMENT PRIMARY KEY,
    publicacion_id int NOT NULL,
    usuario_id int NOT NULL,
    contenido text NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (publicacion_id) REFERENCES publicacion(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES users(id) ON DELETE CASCADE
);