CREATE TABLE amistades (
    id int AUTO_INCREMENT PRIMARY KEY,
    user_id_1 int NOT NULL,
    user_id_2 int NOT NULL,
    estado ENUM('pendiente', 'aceptada', 'bloqueada') DEFAULT 'pendiente',
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id_1) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id_2) REFERENCES users(id) ON DELETE CASCADE
);