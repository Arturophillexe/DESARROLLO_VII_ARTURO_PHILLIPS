CREATE TABLE mensaje (
    id int AUTO_INCREMENT PRIMARY KEY,
    emisor_id int not null,
    receptor_id int not null,
    mensaje text not null,
    fecha_men DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (emisor_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (receptor_id) REFERENCES users(id) ON DELETE CASCADE
);